<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlReportesDAO.php");


$tipoReporte = $_POST['tipoReporte'];
$fechaIni = $_POST['fechaIni'];
$fechaFin = $_POST['fechaFin'];
$busqueda = $_POST['busqueda'];
$limit = $_POST['limit'];
$offset = $_POST['offset'];

$sqlReportesDAO = new sqlReportesDAO();
if ($tipoReporte == 1) {
    $sqlReportesDAO->sqlReporteHistorico($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}else if ($tipoReporte == 2) {
    $sqlReportesDAO->sqlReporteContratos($busqueda,$limit,$offset);
}else if ($tipoReporte == 3) {
    $sqlReportesDAO->sqlReporteDesempeno($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}else if ($tipoReporte == 4) {
    $sqlReportesDAO->sqlReporteRefrendo($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}else if ($tipoReporte == 5) {
    $sqlReportesDAO->sqlReporteBazar($busqueda,$limit,$offset);
}else if ($tipoReporte == 6) {
    $sqlReportesDAO->sqlReporteCompras($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}else if ($tipoReporte == 7) {
    $sqlReportesDAO->sqlReporteInventarios($busqueda,$limit,$offset);
}else if ($tipoReporte == 8) {
    //Transferencia
}else if ($tipoReporte == 9) {
    $sqlReportesDAO->sqlReporteVentas($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}else if($tipoReporte==10) {
    $sqlReportesDAO->sqlReporteIngresos($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}else if($tipoReporte==11) {
    $sqlReportesDAO->sqlReporteCorporativo($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}else if($tipoReporte==12) {
    //Descuento de Interés
    $sqlReportesDAO->sqlReporteDescuento($busqueda,$fechaIni,$fechaFin,$limit,$offset,$tipoReporte);
}else if($tipoReporte==13) {
    //Cancelaciones
    $sqlReportesDAO->sqlReporteDescuento($busqueda,$fechaIni,$fechaFin,$limit,$offset,$tipoReporte);
}else if($tipoReporte==14) {
    //Central a Banco
    $sqlReportesDAO->sqlReporteDescuento($busqueda,$fechaIni,$fechaFin,$limit,$offset,$tipoReporte);
}else if($tipoReporte==15) {
    //Banco a Central
    $sqlReportesDAO->sqlReporteDescuento($busqueda,$fechaIni,$fechaFin,$limit,$offset,$tipoReporte);
}else if($tipoReporte==16) {
    //Banco a Boveda
    $sqlReportesDAO->sqlReporteDescuento($busqueda,$fechaIni,$fechaFin,$limit,$offset,$tipoReporte);
}else if($tipoReporte==17) {
    //Boveda a Banco
    $sqlReportesDAO->sqlReporteDescuento($busqueda,$fechaIni,$fechaFin,$limit,$offset,$tipoReporte);
}else if($tipoReporte==18) {
    //Descuento a Ventas
    $sqlReportesDAO->sqlReporteDescuento($busqueda,$fechaIni,$fechaFin,$limit,$offset,$tipoReporte);
}else if($tipoReporte==19) {
    //Cambio de precio
    $sqlReportesDAO->sqlReporteDescuento($busqueda,$fechaIni,$fechaFin,$limit,$offset,$tipoReporte);
}else if($tipoReporte==20) {
    //Monto mayor articulos
    $sqlReportesDAO->sqlReporteDescuento($busqueda,$fechaIni,$fechaFin,$limit,$offset,$tipoReporte);
}else if($tipoReporte==21) {
    //Monto mayor auto
    $sqlReportesDAO->sqlReporteDescuento($busqueda,$fechaIni,$fechaFin,$limit,$offset,$tipoReporte);
}else if($tipoReporte==22) {
    //Horario
    $sqlReportesDAO->sqlReporteDescuento($busqueda,$fechaIni,$fechaFin,$limit,$offset,$tipoReporte);
}else if($tipoReporte==23) {
    $sqlReportesDAO->sqlReporteCierreCaja($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}else if($tipoReporte==24) {
    $sqlReportesDAO->sqlReporteCierreSucursal($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}else if ($tipoReporte == 27) {
    $sqlReportesDAO->sqlReporteEmpeno($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}else if ($tipoReporte == 28) {
    $sqlReportesDAO->sqlReporteBazarAuto($busqueda,$limit,$offset);
}else if ($tipoReporte == 30) {
    $sqlReportesDAO->sqlReporteUtilidad($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}else if ($tipoReporte == 31) {
    $sqlReportesDAO->sqlReportePasarBazar($busqueda,$limit,$offset);
}else if ($tipoReporte == 32) {
    $sqlReportesDAO->sqlReporteUtilidadVenta($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}else if ($tipoReporte == 33) {
    $sqlReportesDAO->sqlReporteInventariosAutos($busqueda,$limit,$offset);
}else if ($tipoReporte == 34) {
    $sqlReportesDAO->sqlReporteEmpenoAuto($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}else if ($tipoReporte == 35) {
    $sqlReportesDAO->sqlReporteMigrarBazar($busqueda,$limit,$offset);
}else if ($tipoReporte == 36) {
    $sqlReportesDAO->sqlReporteRegresarBazar($busqueda,$limit,$offset);
}else if ($tipoReporte == 37) {
    $sqlReportesDAO->sqlReporteMigrarAuto($busqueda,$limit,$offset);
}else if ($tipoReporte == 38) {
    $sqlReportesDAO->sqlReporteRegresarAuto($busqueda,$limit,$offset);
}else if ($tipoReporte == 39) {
    $sqlReportesDAO->sqlReporteBazarHoy($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}

?>