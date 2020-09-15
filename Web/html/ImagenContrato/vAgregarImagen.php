<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Menu.php');
error_reporting(~E_NOTICE); // avoid notice

include_once(BASE_PATH . "ConexionImg.php");
date_default_timezone_set('America/Mexico_City');

$articulo = 0;

if (isset($_GET['articulo'])) {
    $articulo = $_GET['articulo'];
}

if (isset($_POST['btnsave'])) {
    //$username = $_POST['user_name'];// user name
    $desc = $_POST['desc_name'];// user email

    $imgFile = $_FILES['user_image']['name'];
    $tmp_dir = $_FILES['user_image']['tmp_name'];
    $imgSize = $_FILES['user_image']['size'];


    if (empty($desc)) {
        $errMSG = "Ingrese la descripción.";
    } else if (empty($imgFile)) {
        $errMSG = "Seleccione el archivo de imagen.";
    } else {
        $upload_dir = '../../../Imagenes/'; // upload directory

        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

        // rename uploading image
        $userpic = rand(1000, 1000000) . "." . $imgExt;

        // allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
            // Check file size '1MB'
            if ($imgSize < 1000000) {
                move_uploaded_file($tmp_dir, $upload_dir . $userpic);
            } else {
                $errMSG = "Su archivo es muy grande.";
            }
        } else {
            $errMSG = "Solo archivos JPG, JPEG, PNG & GIF son permitidos.";
        }
    }


    // if no error occured, continue ....
    if (!isset($errMSG)) {
        $fechaCreacion = date('Y-m-d H:i:s');
        $idCierreCaja = $_SESSION['idCierreCaja'];
        $desc = mb_strtoupper($desc, 'UTF-8');

        $stmt = $DB_con->prepare('INSERT INTO cat_imagenes(articulo,descripcion,id_cierreCaja,fechaCreacion,Imagen_Img) 
VALUES(:art,:des,:cierre,:fecha,:upic)');
        $stmt->bindParam(':art', $articulo);
        $stmt->bindParam(':des', $desc);
        $stmt->bindParam(':cierre', $idCierreCaja);
        $stmt->bindParam(':fecha', $fechaCreacion);
        $stmt->bindParam(':upic', $userpic);

        if ($stmt->execute()) {
            $successMSG = "Nuevo registro insertado correctamente ...";
            header("refresh:1;vImagenesContrato.php?articulo=".$articulo); // redirects image view page after 5 seconds.
        } else {
            $errMSG = "Error al insertar ...";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=yes"/>
    <title>Subir imagen.</title>
    <script src="../../JavaScript/funcionesImagen.js"></script>
    <script type="application/javascript">
    </script>
</head>
<body>
<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div>
        <br>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <table>
                <tr>
                    <td align="center">
                        <input type="button" class="btn btn-info" value="Mostrar todos"
                               onclick="MostrarTodos();">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php
    if (isset($errMSG)) {
        ?>
        <div class="row">
            <div class="col-md-5">
                <div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span>
                    <strong><?php echo $errMSG; ?></strong></div>
            </div>
        </div>
        <?php
    } else if (isset($successMSG)) {
        ?>
        <div class="row">
            <div class="col-md-5">
                <div class="alert alert-success"><strong><span
                                class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong></div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="row">
        <div class="col-md-5">
            <form method="post" enctype="multipart/form-data" class="form-horizontal">
                <table class="table table-bordered ">
                    <tr>
                        <td><label class="control-label">Articulo</label></td>
                        <td><input class="form-control" type="text" name="art_name" id="idArticuloFotos"
                                   value="<?php echo $articulo; ?>"
                                   style="width: 140px; text-align: center" disabled/></td>
                    </tr>

                    <tr>
                        <td><label class="control-label">Descripción:</label></td>
                        <td><input class="form-control" type="text" name="desc_name"
                                   value="<?php echo $desc; ?>" style="width: 200px"/></td>
                    </tr>
                    <tr>
                        <td><label class="control-label">Imágen.</label></td>
                        <td><input class="input-group" type="file" name="user_image" accept="image/*"/></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <button type="submit" name="btnsave" class="btn btn-primary"><span
                                        class="glyphicon glyphicon-save"></span> &nbsp; Guardar Imagen
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
</body>
</html>