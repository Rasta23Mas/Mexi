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
    $sqlReportesDAO->reporteHistorico($fechaIni,$fechaFin,$busqueda);
}else if ($tipoReporte == 2) {
    $sqlReportesDAO->reporteContratos($busqueda);
}else if ($tipoReporte == 3) {
    $sqlReportesDAO->reporteDesempe($fechaIni,$fechaFin,$busqueda);
}else if ($tipoReporte == 4) {
    $sqlReportesDAO->reporteRefrendo($fechaIni,$fechaFin,$busqueda);
}else if ($tipoReporte == 5) {
    $sqlReportesDAO->sqlReporteBazar($busqueda,$limit,$offset);
}else if ($tipoReporte == 6) {
    //Compra
    $sqlReportesDAO->reporteBazar($fechaIni,$fechaFin,$busqueda);
}else if ($tipoReporte == 7) {
    $sqlReportesDAO->reporteInve($busqueda);
}else if ($tipoReporte == 8) {
    //Transferencia
    $sqlReportesDAO->reporteBazar($fechaIni,$fechaFin,$busqueda);
}else if ($tipoReporte == 9) {
    //Venta
    $sqlReportesDAO->reporteBazar($fechaIni,$fechaFin,$busqueda);
}

?>