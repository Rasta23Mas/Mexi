<?php
if (!isset($_SESSION)) {
    session_start();
}
error_reporting( ~E_NOTICE );
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "ConexionImg.php");
date_default_timezone_set('America/Mexico_City');

$idContrato = 3;
$articulo = 3;
if (isset($_GET['idContrato'])) {
    $idContrato = $_GET['idContrato'];
}
if (isset($_GET['articulo'])) {
    $articulo = $_GET['articulo'];
}

if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
{
    $id = $_GET['edit_id'];

    //$stmt_edit = $DB_con->prepare('SELECT Imagen_Marca, Imagen_Tipo, Imagen_Img FROM tbl_imagenes WHERE Imagen_ID =:uid');
    $stmt_edit = $DB_con->prepare('SELECT Imagen_ID, descripcion, Imagen_Img FROM cat_imagenes WHERE Imagen_ID =:uid');
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
    //$username = $_POST['user_name'];// user name
    $desc = $_POST['desc_name'];// user email

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
        /*$stmt = $DB_con->prepare('UPDATE tbl_imagenes
									 SET Imagen_Marca=:uname, 
										 Imagen_Tipo=:ujob, 
										 Imagen_Img=:upic 
								   WHERE Imagen_ID=:uid');*/
        $fechaMod = date('Y-m-d H:i:s');
        $idCierreCaja = $_SESSION['idCierreCaja'];
        $desc = mb_strtoupper($desc, 'UTF-8');

        $stmt = $DB_con->prepare('UPDATE cat_imagenes 
									 SET descripcion=:des, 
									      id_cierreCajaMod=:cierre, 
									       fechaModificacion=:fecha, 
										 Imagen_Img=:upic 
								   WHERE Imagen_ID=:uid');
        //$stmt->bindParam(':uname',$username);
        $stmt->bindParam(':des',$desc);
        $stmt->bindParam(':cierre', $idCierreCaja);
        $stmt->bindParam(':fecha', $fechaCreacion);
        $stmt->bindParam(':upic',$userpic);
        $stmt->bindParam(':uid',$id);

        if($stmt->execute()){
            $successMSG = "Registro editado correctamente ...";
            header("refresh:2;vImagenesContrato.php?idContrato=".$idContrato ."&articulo=".$articulo); // redirects image view page after 5 seconds.
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
            <div class="row">
                <div class="col-md-5">
                    <div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span>
                        <strong><?php echo $errMSG; ?></strong></div>
                </div>
            </div>
            <?php
        }else if (isset($successMSG)) {
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
        <table class="table table-bordered table-responsive">
            <tr>
                <td><label class="control-label">Contrato</label></td>
                <td><input class="form-control" type="text" name="contrato_name" id="idContratoFotos"
                           value="<?php echo $idContrato; ?>"
                           style="width: 80px" disabled/></td>
            </tr>
            <tr>
                <td><label class="control-label">Articulo</label></td>
                <td><input class="form-control" type="text" name="art_name" id="idArticuloFotos"
                           value="<?php echo $articulo; ?>"
                           style="width: 80px" disabled/></td>
            </tr>
            <tr>
                <td><label class="control-label">Descripción.</label></td>
                <td><input class="form-control" type="text" name="desc_name" value="<?php echo $descripcion; ?>" required /></td>
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