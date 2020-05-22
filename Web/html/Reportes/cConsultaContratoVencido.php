<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/dirs.php');
include_once (SQL_PATH."sqlReporteDAO.php");

$fechaInicial = $_GET['fechaInicial'];
$fechaFinal = $_GET['fechaFinal'];

$sql = new sqlReporteDAO();

$arr = array();

$arr = $sql->traeContratosVencidos($fechaInicial, $fechaFinal);

echo json_encode($arr);