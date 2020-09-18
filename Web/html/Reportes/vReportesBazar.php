<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Menu.php');
require_once(BASE_PATH . "Conectar.php");
include_once(SQL_PATH . "sqlCatalogoDAO.php");

$sucursal = $_SESSION["sucursal"];
$CountFilas = "SELECT COUNT(*) as TotalFilas 
                        FROM articulo_bazar_tbl as Baz
                        LEFT JOIN articulo_tbl AS ART on Baz.id_Articulo = ART.id_Articulo 
                        LEFT JOIN cat_adquisicion AS CAT on Baz.id_serieTipo = CAT.id_Adquisicion
                        LEFT JOIN cat_movimientos AS Mov on Baz.tipo_movimiento = Mov.id_Movimiento
                        WHERE tipo_movimiento!= 6 and Baz.sucursal=$sucursal";
$query = $db->query($CountFilas);
if($query->num_rows > 0) {
    $row = $result->fetch_assoc();
    $num_total_rows = $row['TotalFilas'];
}


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
                <h3><label>Reportes Bazar</label></h3>
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
                <label>Reporte</label>
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
                <select id="idTipoReporte" name="cmbVehiculo" class="selectpicker"
                        onchange="selectReporte()">
                    <option value="0">Seleccione:</option>
                    <?php
                    $data = array();
                    $sql = new sqlCatalogoDAO();
                    $data = $sql->llenarCmbReportes(1);
                    for ($i = 0; $i < count($data); $i++) {
                        echo "<option value=" . $data[$i]['id_cat_rpt'] . ">" . $data[$i]['descripcion'] . "</option>";
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
                <img src="../../style/Img/excel.png" alt="Excel" onclick="exportarExcel()">
                &nbsp;&nbsp;
                <img src="../../style/Img/pdf_xs.png" alt="PDF" onclick="exportarPDF()">
            </td>
            <td align="center">
                <input type="button" class="btn btn-success w-75"
                       onclick="llenarReporte()"
                       value="Buscar"/>
            </td>

        </tr>
    </table>
</div>
<div class="row" align="center">
    <br>&nbsp;
</div>
<div class="row" align="center">
    <div id="divRpt" class="col col-lg-12">
    </div>
</div>
<div class="row" align="center">
    <input type="text" name="sucursa" id="idSucursal" value="<?php echo $sucursal ?>" style="visibility: hidden"/>
</div>
</body>
</html>