<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_GET['tipoReporte'])) {
    $tipoReporte= $_GET['tipoReporte'];
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once (HTML_PATH."menuGeneral.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Generales-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Funciones-->
    <script src="../../JavaScript/funcionesReportesEmp.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionesCalendario.js"></script>
    <link rel="stylesheet" type="text/css" href="../../librerias/jqueryui/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="../../librerias/jqueryui/jquery-ui.min.js"></script>


    <!--    Script inicial-->
    <script type="application/javascript">
        $(document).ready(function () {
            var reporte = <?php echo $tipoReporte?>;

            if(reporte==1){
                nameForm= "Histórico"
                document.getElementById('NombreReporte').innerHTML = nameForm;
                $("#divReporte").load('rptEmpHistorico.php');
            }else if(reporte==2){
                nameForm= "Inventarios"
                document.getElementById('NombreReporte').innerHTML = nameForm;
                $("#divReporte").load('rptEmpInventario.php');
            }else if(reporte==3){
                nameForm= "Contratos Vencidos"
                document.getElementById('NombreReporte').innerHTML = nameForm;
                $("#divReporte").load('rptEmpContratos.php');
            }else if(reporte==4){
                nameForm= "Desempeños"
                document.getElementById('NombreReporte').innerHTML = nameForm;
                $("#divReporte").load('rptEmpDesempeno.php');
            }else if(reporte==5){
                nameForm= "Refrendo"
                document.getElementById('NombreReporte').innerHTML = nameForm;
                cargarRptRefrendo();
                cargarRptRefrendoAuto();
                $("#divReporte").load('rptEmpRefrendo.php');
                $("#divReporteElect").load('rptEmpRefrendo.php');
                $("#divReporteAut").load('rptEmpRefrendo.php');

            }
        })
    </script>
    <style type="text/css">
        .propInvisible {
            visibility: hidden;
        }

    </style>
</head>
<body>
    <div align="center">
            <table width="100%" border="0">
                <tr>
                    <td colspan="6">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="6" style=" color:darkblue; ">
                        <h3><label id="NombreReporte"></label></h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        &nbsp;
                    </td>
                </tr>
                <tr align="center">
                    <td class="titleTable">
                        <label>Fecha Inicial</label>
                    </td>
                    <td class="titleTable">
                        <label>Fecha Final</label>
                    </td>
                    <td class="titleTable">
                        <label>Buscar cierre </label>
                    </td>
                </tr>
                <tr align="center">
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
                        <input type="button" class="btn btn-success w-50"
                               data-toggle="modal" data-target="#modalCierreCaja"
                               onclick="validarEsatusSucursal()"
                               value="Buscar"/>
                    </td>
                </tr>
                <tr class="MetalesTD">
                    <td colspan="6" align="left" >
                        <h4 >&nbsp;&nbsp;Metales</h4>
                    </td>
                </tr>
                <tr class="MetalesTD">
                    <td colspan="6">
                        <br>
                        <div id="divReporte" class="col col-lg-12">
                        </div>
                    </td>
                </tr>
                <tr class="ElectTD">
                    <td colspan="6" align="left" >
                        <h4 >&nbsp;&nbsp; Electrónicos</h4>>
                    </td>
                </tr>
                <tr class="ElectTD">
                    <td colspan="6">
                        <br>
                        <div id="divReporteElect" class="col col-lg-12">
                        </div>
                    </td>
                </tr>
                <tr class="AutoTD">
                    <td colspan="6" align="left" >
                        <h4 >&nbsp;&nbsp;Autos</h4>
                    </td>
                </tr>
                <tr class="AutoTD">
                    <td colspan="6">
                        <br>
                        <div id="divReporteAut" class="col col-lg-12">
                        </div>
                    </td>
                </tr>
            </table>
    </div>
</body>
</html>