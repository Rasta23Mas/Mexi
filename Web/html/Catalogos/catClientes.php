<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(HTML_PATH . "menuGeneral.php");
include_once(SQL_PATH . "sqlCatalogoDAO.php");

$sucursal = $_SESSION["sucursal"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Generales-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Funciones-->
    <script src="../../JavaScript/funcionesCatalogos.js"></script>

    <style type="text/css">
        .titleTable {
            background: dodgerblue;
            color: white;
        }
    </style>
    <script type="application/javascript">
        $(document).ready(function () {
            cargarCatClientes(<?php echo $sucursal?>);
            $("#divCat").load('tblClientes.php');
        })
    </script>
</head>
<body>
<div class="row" align="center">
    <table width="100%" border="0">
        <tr>
            <td colspan="6">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td align="center" colspan="6" style=" color:darkblue; ">
                <h3><label id="NombreReporte">Clientes</label></h3>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                &nbsp;
            </td>
        </tr>
    </table>
</div>
<div class="row" align="center">
    <table width="20%" class="border border-primary" align="center">
        <tr align="center">
            <td class="titleTable">
                <label>Exportar</label>
            </td>
            <td class="titleTable">

            </td>
        </tr>
        <tr align="center">
            <td align="center">
                <img src="../../style/Img/excel.png" alt="Excel" onclick="exportarExcelCliente()">
                &nbsp;&nbsp;
                <img src="../../style/Img/pdf_xs.png" alt="PDF" onclick="exportarPDFCliente()">
            </td>
        </tr>
    </table>
</div>
<div class="row" align="center">
    <br>&nbsp;
</div>
<div class="row" align="center">
    <div id="divCat" class="col col-lg-12">
    </div>
</div>
<div class="row" align="center">
    <input type="text" name="sucursa" id="idSucursal" value="<?php echo $sucursal ?>" style="visibility: hidden"/>
</div>
</body>
</html>