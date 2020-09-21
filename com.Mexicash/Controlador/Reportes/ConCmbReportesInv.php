<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");


$tipoReporte = $_POST['tipoReporte'];

$sqlReportesDAO = new sqlCatalogoDAO();

$sqlReportesDAO->sqlLlenarCmbReportes($tipoReporte);


?>