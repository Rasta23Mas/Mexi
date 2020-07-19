<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlReportesDAO.php");


$tipoReporte = $_POST['tipoReporte'];

$sqlReportesDAO= new sqlReportesDAO();
if($tipoReporte==1){
    $sqlReportesDAO->reporteRefrendo($tipoReporte);
}

?>