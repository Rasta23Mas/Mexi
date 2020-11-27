<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');


$tipoReporte = $_POST['tipoReporte'];

$sqlReportesDAO = new sqlCatalogoDAO();

$sqlReportesDAO->sqlLlenarCmbReportes($tipoReporte);


?>