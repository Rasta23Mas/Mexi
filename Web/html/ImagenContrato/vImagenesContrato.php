<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["idUsuario"])) {
    header("Location: ../../../index.php");
    session_destroy();
}
// Archivo de conexion con la base de datos
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "ConexionImg.php");
date_default_timezone_set('America/Mexico_City');

// Condicional para validar el borrado de la imagen

if (isset($_GET['delete_id'])) {
    // Selecciona imagen a borrar
    $stmt_select = $DB_con->prepare('SELECT Imagen_Img FROM tbl_imagenes WHERE Imagen_ID =:uid');
    $stmt_select->execute(array(':uid' => $_GET['delete_id']));
    $imgRow = $stmt_select->fetch(PDO::FETCH_ASSOC);
    // Ruta de la imagen
    unlink("../../../Imagenes/" . $imgRow['Imagen_Img']);

    // Consulta para eliminar el registro de la base de datos
    $stmt_delete = $DB_con->prepare('DELETE FROM tbl_imagenes WHERE Imagen_ID =:uid');
    $stmt_delete->bindParam(':uid', $_GET['delete_id']);
    $stmt_delete->execute();
    // Redireccioa al inicio
    header("Location: vImagenesContrato.php");
}


$idContrato = 0;
$articulo = 0;
if (isset($_GET['idContrato'])) {
    $idContrato = $_GET['idContrato'];
}
if (isset($_GET['articulo'])) {
    $articulo = $_GET['articulo'];
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
            $("#idContratoFotos").val(idContrato);

            var articulo = <?php echo $articulo ?>;
            $("#idArticuloFotos").val(articulo);
        })
    </script>
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
    <div class="row">
        <div class="col-xs-4">
            <table class="table table-bordered ">
                <tr>
                    <td><label class="control-label">Contrato</label></td>
                    <td><input class="form-control" type="text" name="user_name" id="idContratoFotos"
                               style="width: 80px" disabled/></td>
                </tr>
                <tr>
                    <td><label class="control-label">Articulo</label></td>
                    <td><input class="form-control" type="text" name="user_name" id="idArticuloFotos"
                               style="width: 80px" disabled/></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <?php
        $stmt = $DB_con->prepare('SELECT Imagen_ID, Imagen_Marca, Imagen_Tipo, Imagen_Img FROM tbl_imagenes ORDER BY Imagen_ID DESC');
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                ?>
                <div class="col-xs-3">
<!--                    <p class="page-header"><?php /*echo $Imagen_Marca . "&nbsp;/&nbsp;" . $Imagen_Tipo; */?></p>
-->
                    <p class="page-header">Descripción : <?php echo $Imagen_Tipo; ?></p>

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