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
    <script src="../../JavaScript/funcionesReportes.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionesCalendario.js"></script>
    <link rel="stylesheet" type="text/css" href="../../librerias/jqueryui/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="../../librerias/jqueryui/jquery-ui.min.js"></script>
    <style type="text/css">
        .titleTable {
            background: dodgerblue;
            color: white;
        }
    </style>
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
                <h3><label id="NombreReporte">Autorizaciones</label></h3>
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
    <table width="60%" class="border border-primary" align="center">
        <tr align="center">
            <td class="titleTable">
                <label>Tipo</label>
            </td>
            <td class="titleTable">
                <label>Fecha Inicial</label>
            </td>
            <td class="titleTable">
                <label>Fecha Final</label>
            </td>
            <td class="titleTable">
                <label>Exportar</label>
            </td>
            <td class="titleTable">

            </td>
        </tr>
        <tr align="center">
            <td align="center">
                <select id="idTipoReporteMon" name="nombreReporte" class="selectpicker"  onchange="selectReporteMon()">
                    <option value="0">Todos</option>
                    <?php
                    $data = array();
                    $sql = new sqlCatalogoDAO();
                    $data = $sql->llenarCmbMonitoreoTipo();
                    for ($i = 0; $i < count($data); $i++) {
                        echo "<option value=" . $data[$i]['id_tokenMovimiento'] . ">" . $data[$i]['descripcion'] . "</option>";
                    }
                    ?>
                </select>
            </td>

            <td align="center">
                <input type="text" name="fechaInicial" id="idFechaInicial" style="width: 100px"
                       class="calendarioModBoton"
                       disabled/>
            </td>
            <td>
                <input type="text" name="fechaFinal" id="idFechaFinal" style="width: 100px"
                       class="calendarioModBoton"
                       disabled/>
            </td>
            <td align="center">
                <img src="../../style/Img/excel.png" alt="Excel" onclick="exportarMonitoreo(1)">
                &nbsp;&nbsp;
                <img src="../../style/Img/pdf_xs.png" alt="PDF" onclick="exportarMonitoreo(2)">
            </td>
            <td align="center">
                <input type="button" class="btn btn-success w-75"
                       onclick="llenarReporteMonitoreo()"
                       value="Buscar"/>
            </td>

        </tr>
    </table>
</div>
<div class="row" align="center">
    <br>&nbsp;
</div>
<div class="row" align="center">
    <div id="divRptMonitoreo" class="col col-lg-12">
    </div>
</div>
<div class="row" align="center">
    <input type="text" name="sucursa" id="idSucursal" value="<?php echo $sucursal ?>" style="visibility: hidden"/>
</div>
</body>
</html>