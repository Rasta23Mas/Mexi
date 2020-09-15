<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');
// Archivo de conexion con la base de datos
include_once(BASE_PATH . "ConexionImg.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Menu.php');
date_default_timezone_set('America/Mexico_City');

// Condicional para validar el borrado de la imagen

$articulo = 0;
if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
}
if (isset($_GET['articulo'])) {
    $articulo = $_GET['articulo'];
}

if (isset($_GET['delete_id'])) {
    // Selecciona imagen a borrar
    $stmt_select = $DB_con->prepare('SELECT Imagen_Img FROM cat_imagenes WHERE Imagen_ID =:uid');
    $stmt_select->execute(array(':uid' => $_GET['delete_id']));
    $imgRow = $stmt_select->fetch(PDO::FETCH_ASSOC);
    // Ruta de la imagen
    unlink("../../../Imagenes/" . $imgRow['Imagen_Img']);

    // Consulta para eliminar el registro de la base de datos
    //$stmt_delete = $DB_con->prepare('DELETE FROM cat_imagenes WHERE Imagen_ID =:uid');
    $stmt_delete = $DB_con->prepare('UPDATE cat_imagenes 
									 SET Eliminado=1
								   WHERE Imagen_ID=:uid');
    $stmt_delete->bindParam(':uid', $_GET['delete_id']);
    $stmt_delete->execute();
    // Redireccioa al inicio
    // header("Location: vImagenesContrato.php");
    $successMSG = "Registro eliminado exitosamente ...";
    header("refresh:1;vImagenesContrato.php?articulo=".$articulo); // redirects image view page after 5 seconds.

}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=yes"/>
    <title>Subir imagen.</title>
    <script src="../../JavaScript/funcionesImagen.js"></script>

</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-xs-3">
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <table>
                <tr>
                    <td align="left">
                        <input type="button" class="btn btn-success" value="Agregar nuevo"
                               onclick="AgregarFoto();">
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <br>
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
                <div class="alert alert-danger"><strong><span
                                class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong></div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="row">
        <div class="col-xs-4">
            <table class="table table-bordered ">
                <tr>
                    <td><label class="control-label">Articulos</label></td>
                    <td><input class="form-control" type="text" name="user_name" id="idArticuloFotos" value="<?php echo $articulo ?>"
                               style="width: 140px; text-align: center" disabled/></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <?php
        $stmt = $DB_con->prepare('SELECT Imagen_ID, descripcion, Imagen_Img FROM cat_imagenes WHERE articulo = '. $articulo .' AND Eliminado = 0  ORDER BY Imagen_ID DESC');
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                ?>
                <div class="col-xs-3">
                    <p class="page-header">Descripción : <?php echo $descripcion; ?></p>
                    <img src="../../../Imagenes/<?php echo $row['Imagen_Img']; ?>" class="img-rounded" width="250px"
                         height="250px"/>
                    <p class="page-header">
                        <br>
                    </p>
                    <p class="page-header">
                        <input type="button" class="btn btn-success" value="&nbsp;Editar&nbsp;"
                               onclick="EditarFoto(<?php echo $row['Imagen_ID']; ?>);">
                        &nbsp;
                        <input type="button" class="btn btn-danger" value="Eliminar"
                               onclick="ElimnarFoto(<?php echo $row['Imagen_ID']; ?>);">
                    </p>
                </div>
        <div class="col-xs-1">
            <p class="page-header">
                <br>&nbsp;&nbsp;
            </p>
        </div>

                <?php
            }
        } else {
            ?>
            <div class="col-xs-12">
                <div class="alert alert-warning"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; Datos no
                    encontrados ...
                </div>
            </div>
            <?php
        }

        ?>
    </div>
</div>
</body>
</html>