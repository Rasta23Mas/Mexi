<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlDesempenoDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$tipeFormulario = $_POST['tipeFormulario'];
$contrato = $_POST['contrato'];
$token = $_POST['token'];
$descuento = $_POST['descuento'];
$gps = $_POST['gps'];
$pension = $_POST['pension'];
$poliza = $_POST['poliza'];
//$newFechaAlm = $_POST['newFechaAlm'];
//$newFechaVencimiento = $_POST['newFechaVencimiento'];
//$idEstatusArt = $_POST['idEstatusArt'];
$tipoContrato = $_POST['tipoContrato'];
$token_interes = $_POST['token_interes'];
$token_moratorio = $_POST['token_moratorio'];
$token_gps = $_POST['token_gps'];
$token_pension = $_POST['token_pension'];
$token_poliza = $_POST['token_poliza'];
$token_movimiento = $_POST['token_movimiento'];
$token_decripcion = $_POST['token_decripcion'];
//$estatusAnterior = $_POST['estatusAnterior'];


$sqlDesempeno = new sqlDesempenoDAO();

$sqlDesempeno->generar($tipeFormulario,$descuento,$contrato,$token,$tipoContrato,$token_interes,$token_moratorio, $token_gps,$token_pension,$token_poliza,$token_movimiento,$token_decripcion);



?>