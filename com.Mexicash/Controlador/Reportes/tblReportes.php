<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlReportesDAO.php");


$tipoReporte = $_POST['tipoReporte'];

$sqlReportesDAO= new sqlReportesDAO();
$sqlReportesDAO->reporteRefrendo($tipoReporte);

?>