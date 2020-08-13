<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlReportesDAO.php");


$tipoReporte = $_POST['tipoReporte'];
$fechaIni = $_POST['fechaIni'];
$fechaFin = $_POST['fechaFin'];

$sqlReportesDAO = new sqlReportesDAO();

if($tipoReporte==1){
    $sqlReportesDAO->reporteIngresos($tipoReporte, $fechaIni, $fechaFin);
}else if($tipoReporte==2){
    $sqlReportesDAO->reporteIngresos($tipoReporte, $fechaIni, $fechaFin);

}


?>