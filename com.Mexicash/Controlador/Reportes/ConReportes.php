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
//Corporativo
}else if($tipoReporte==23) {
    $sqlReportesDAO->sqlReporteCierreCaja($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}else if($tipoReporte==24) {
    $sqlReportesDAO->sqlReporteCierreSucursal($busqueda,$fechaIni,$fechaFin,$limit,$offset);
}

    ?>