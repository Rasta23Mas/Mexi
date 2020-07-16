<?php
error_reporting( ~E_NOTICE );
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "ConexionImg.php");
date_default_timezone_set('America/Mexico_City');

if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
{
    $id = $_GET['edit_id'];
    $stmt_edit = $DB_con->prepare('SELECT Imagen_Marca, Imagen_Tipo, Imagen_Img FROM tbl_imagenes WHERE Imagen_ID =:uid');
    $stmt_edit->execute(array(':uid'=>$id));
    $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
    extract($edit_row);
}
else
{
    header("Location: vImagenContrato.php");
}

if(isset($_POST['btn_save_updates']))
{
    $username = $_POST['user_name'];// user name
    $userjob = $_POST['user_job'];// user email

    $imgFile = $_FILES['user_image']['name'];
    $tmp_dir = $_FILES['user_image']['tmp_name'];
    $imgSize = $_FILES['user_image']['size'];

    if($imgFile)
    {
        $upload_dir = '../../../Imagenes/'; // upload directory
        $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        $userpic = rand(1000,1000000).".".$imgExt;
        if(in_array($imgExt, $valid_extensions))
        {
            if($imgSize < 1000000)
            {
                unlink($upload_dir.$edit_row['Imagen_Img']);
                move_uploaded_file($tmp_dir,$upload_dir.$userpic);
            }
            else
            {
                $errMSG = "Su archivo es demasiado grande mayor a 1MB";
            }
        }
        else
        {
            $errMSG = "Solo archivos JPG, JPEG, PNG & GIF .";
        }
    }
    else
    {
        // if no image selected the old image remain as it is.
        $userpic = $edit_row['Imagen_Img']; // old image from database
    }


    // if no error occured, continue ....
    if(!isset($errMSG))
    {
        $stmt = $DB_con->prepare('UPDATE tbl_imagenes 
									 SET Imagen_Marca=:uname, 
										 Imagen_Tipo=:ujob, 
										 Imagen_Img=:upic 
								   WHERE Imagen_ID=:uid');
        $stmt->bindParam(':uname',$username);
        $stmt->bindParam(':ujob',$userjob);
        $stmt->bindParam(':upic',$userpic);
        $stmt->bindParam(':uid',$id);

        if($stmt->execute()){
            ?>
            <script>
                alert('Archivo editado correctamente.')
                window.location.href='vImagenesContrato.php';
            </script>
            <?php
        }
        else{
            $errMSG = "Los datos no fueron actualizados !";
        }
    }
}
include_once(HTML_PATH . "menuGeneral.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=yes"/>
    <title>Subir imagen.</title>
    <script src="../../JavaScript/funcionesImagen.js"></script>
    <script type="application/javascript">
        $(document).ready(function () {
            var idContrato = <?php echo $idContrato ?>;
            document.getElementById('idContratoFotos').innerHTML = idContrato;
        })
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
    <div class="clearfix"></div>
    <form method="post" enctype="multipart/form-data" class="form-horizontal">
        <?php
        if(isset($errMSG)){
            ?>
            <div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?> </div>
            <?php
        }
        ?>
        <table class="table table-bordered table-responsive">
            <tr>
                <td><label class="control-label">Marca.</label></td>
                <td><input class="form-control" type="text" name="user_name" value="<?php echo $Imagen_Marca; ?>" required /></td>
            </tr>
            <tr>
                <td><label class="control-label">Tipo.</label></td>
                <td><input class="form-control" type="text" name="user_job" value="<?php echo $Imagen_Tipo; ?>" required /></td>
            </tr>
            <tr>
                <td><label class="control-label">Imágen.</label></td>
                <td><p><img src="../../../Imagenes/<?php echo $Imagen_Img; ?>" height="150" width="150" /></p>
                    <input class="input-group" type="file" name="user_image" accept="image/*" /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="btn_save_updates" class="btn btn-primary">
                        <span class="glyphicon glyphicon-save"></span> Actualizar </button>
                    <input type="button" class="btn btn-warning" value="Cancelar"
                           onclick="CancelarEditar();">
                    </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>