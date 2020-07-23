<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlReportesDAO.php");


$tipoReporte = $_POST['tipoReporte'];
$fechaIni = $_POST['fechaIni'];
$fechaFin = $_POST['fechaFin'];

$sqlReportesDAO = new sqlReportesDAO();

if ($tipoReporte == 1) {
    $sqlReportesDAO->reporteDesempe($fechaIni,$fechaFin);
}else if ($tipoReporte == 2) {
    $sqlReportesDAO->reporteInve($fechaIni,$fechaFin);
}else if ($tipoReporte == 3) {
    $sqlReportesDAO->reporteContratos();
}else if ($tipoReporte == 4) {
    $sqlReportesDAO->reporteDesempe($fechaIni,$fechaFin);
}else if ($tipoReporte == 5) {
    $sqlReportesDAO->reporteRefrendo($fechaIni,$fechaFin);
}

?>