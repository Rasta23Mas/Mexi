<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Menu.php');

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
<!--    <link rel="stylesheet" type="text/css" href="../../librerias/jqueryui/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="../../librerias/jqueryui/jquery-ui.min.js"></script>-->
    <link href="bootstrap/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="jquery/jquery-1.11.3.js"></script>
    <script src="bootstrap/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

    <title>Reportes</title>
    <script type="application/javascript">
        $(document).ready(function () {
            fnBuscaReportes(2);
        })
    </script>
    <style type="text/css">
        .titleTable {
            background: dodgerblue;
            color: white;
        }
    </style>
</head>
<body>
<div class="row" align="center">
    <input type="text" name="sucursa" id="idSucursal" value="<?php echo $sucursal ?>" style="visibility: hidden"/>
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
                <select id="idTipoReporte" name="cmbReportes" class="selectpicker"
                        onchange="fnSelectReporte()">
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
                       onclick="fnLlenarReporte()"
                       value="Buscar"/>
            </td>

        </tr>
    </table>
</div>
<div class="panel panel-primary">
    <div class="panel-heading text-center">
        <h3><label id="NombreReporte">Reportes</label></h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-hover">
            <thead>
            <tr align="center">
                <th>Fecha Bazar</th>
                <th>Contrato</th>
                <th>Serie</th>
                <th>Precio Venta</th>
                <th>Detalle</th>
                <th>Tipo Adquisición</th>
            </tr>
            </thead>
            <tbody id="idTBodyBazar">
            </tbody>
        </table>
        <div class="col-md-12 text-center">
            <ul class="pagination" id="paginador"></ul>
        </div>
    </div>
</div>

</body>
</html>