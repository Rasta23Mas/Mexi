<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlFlujoDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$saldoCentralFinal = $_POST['saldoCentralFinal'];
$saldoBancoFinal = $_POST['saldoBancoFinal'];
$saldoBovedaFinal = $_POST['saldoBovedaFinal'];
$saldoCajaFinal = $_POST['saldoCajaFinal'];
$idUsuarioCaja = $_POST['idUsuarioCaja'];


$sqlFlujo = new sqlFlujoDAO();

//llenar totales sin afectar a la caja de usuario
if($idUsuarioCaja==0){
    $sqlFlujo->updateTotalesCentral($saldoCentralFinal,$saldoBancoFinal,$saldoBovedaFinal);
}else{
    //cambio en la caja del usuario
    $sqlFlujo->updateTotalesUsuario($saldoBovedaFinal,$saldoCajaFinal,$idUsuarioCaja);
}



?>