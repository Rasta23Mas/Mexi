<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');
$tipoUsuario = $_SESSION['tipoUsuario'];

if($tipoUsuario==2){
    include_once (HTML_PATH."menuAdmin.php");
}elseif ($tipoUsuario==3){
    include_once (HTML_PATH."menuGeneral.php");
}elseif ($tipoUsuario==4){
    include_once (HTML_PATH."menuVendedor.php");
}


$sucursal = $_SESSION["sucursal"];
include_once(HTML_PATH . "Catalogos/modalActualizarMetal.php");
include_once(HTML_PATH . "Catalogos/modalAgregarMetal.php");
include_once(SQL_PATH . "sqlArticulosDAO.php");
include_once(SQL_PATH . "sqlCatalogoDAO.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Generales-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catalogo</title>
    <!--Funciones-->
    <script src="../../JavaScript/funcionesCatalogos.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionesArticulos.js"></script>
    <!--    Script inicial-->
    <script type="application/javascript">
        $(document).ready(function () {
            selectPrenda();
            var tipoUsuario = <?php echo $tipoUsuario; ?>;
            $("#idTipoUserCat").val(tipoUsuario);
        })
    </script>
</head>
<body>
<form id="idFormCatMetales" name="formCatMetales">
    <div id="contenedor" class="container">
        <div>
            <br>
            <br>
        </div>
        <div class="row" >
            <div class="col-6">
                <table width="70%">
                    <tbody class="text-body" align="left">
                    <tr>
                        <td colspan="6">Tipo:</td>
                        <td colspan="6">
                            <select id="idTipoMetal" name="cmbTipoMetal" class="selectpicker"
                                    onchange="cargarTablaCatMetales($('#idTipoMetal').val())"
                                    style="width: 150px">
                            </select>

                        </td>
                        <td align="center">
                            <input type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgregarMetal"
                                   value="Agregar">
                            <input type="text" name="billete"  id="idTipoUserCat" maxlength="3" class="invisible"
                                   /></td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" >
            <div class="col-6">
                <table class="table table-hover table-condensed table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th>Tipo </th>
                        <th>Unidad </th>
                        <th>Precio</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody id="idCatMetales">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
</body>
</html>
