<?php
if (!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION["idUsuario"])){
    header("Location: ../../../index.php");
    session_destroy();
}
// Archivo de conexion con la base de datos
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "ConexionImg.php");
include_once(HTML_PATH . "menuGeneral.php");
date_default_timezone_set('America/Mexico_City');
// Condicional para validar el borrado de la imagen

if(isset($_GET['delete_id']))
{
    // Selecciona imagen a borrar
    $stmt_select = $DB_con->prepare('SELECT Imagen_Img FROM tbl_imagenes WHERE Imagen_ID =:uid');
    $stmt_select->execute(array(':uid'=>$_GET['delete_id']));
    $imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
    // Ruta de la imagen
    unlink("../../../Imagenes/".$imgRow['Imagen_Img']);

    // Consulta para eliminar el registro de la base de datos
    $stmt_delete = $DB_con->prepare('DELETE FROM tbl_imagenes WHERE Imagen_ID =:uid');
    $stmt_delete->bindParam(':uid',$_GET['delete_id']);
    $stmt_delete->execute();
    // Redireccioa al inicio
    header("Location: /vImagenesContrato.php");
}


$idContrato = 0;
if (isset($_GET['idContrato'])) {
    $idContrato = $_GET['idContrato'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=yes" />
    <title>Subir imagen.</title>
  
</head>

<body>
<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header"> <a class="navbar-brand" href="vImagenesContrato.php" title='Inicio' target="_blank">Inicio</a> </div>
    </div>
</div>
<div class="container">
    <div class="page-header">
        <h1 class="h2">Mostrar todos. / <a class="btn btn-default" href="vAgregarImagen.php"> <span class="glyphicon glyphicon-plus"></span> &nbsp; Agregar nuevo</a></h1>
    </div>
    <br />
    <div class="row">
        <?php

        $stmt = $DB_con->prepare('SELECT Imagen_ID, Imagen_Marca, Imagen_Tipo, Imagen_Img FROM tbl_imagenes ORDER BY Imagen_ID DESC');
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                ?>
                <div class="col-xs-3">
                    <p class="page-header"><?php echo $Imagen_Marca."&nbsp;/&nbsp;".$Imagen_Tipo; ?></p>
                    <img src="../../../Imagenes/<?php echo $row['Imagen_Img']; ?>" class="img-rounded" width="250px" height="250px" />
                    <p class="page-header"> <span> <a class="btn btn-info" href="vEditarImagen.php?edit_id=<?php echo $row['Imagen_ID']; ?>" title="click for edit" onclick="return confirm('Esta seguro de editar el archivo ?')"><span class="glyphicon glyphicon-edit"></span> Editar</a> <a class="btn btn-danger" href="?delete_id=<?php echo $row['Imagen_ID']; ?>" title="click for delete" onclick="return confirm('Esta seguro de eliminar el archivo?')"><span class="glyphicon glyphicon-remove-circle"></span> Borrar</a> </span> </p>
                </div>
                <?php
            }
        }
        else
        {
            ?>
            <div class="col-xs-12">
                <div class="alert alert-warning"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Datos no encontrados ... </div>
            </div>
            <?php
        }

        ?>
    </div>
</div>
</body>
</html>