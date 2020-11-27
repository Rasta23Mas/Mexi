<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$tipe = $_POST['tipe'];
$fechaInicial = $_POST['fechaInicial'];
$fechaFinal = $_POST['fechaFinal'];

$sqlCierre = new sqlCierreDAO();
if($tipe==1){
    $sqlCierre->busquedaPorFechasArqueo($fechaInicial,$fechaFinal);
}else if($tipe==2) {
    $sqlCierre->busquedaPorFechasCajaCierre($fechaInicial, $fechaFinal);
} else if($tipe==3){
    $sqlCierre->busquedaPorFechasSucursalCierre($fechaInicial,$fechaFinal);
}

