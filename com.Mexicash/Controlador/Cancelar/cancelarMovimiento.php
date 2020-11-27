<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCancelarDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$tipo_movimiento = $_POST['tipo_movimiento'];
$movimientoCancelado = $_POST['movimientoCancelado'];
$IdMovimiento = $_POST['IdMovimiento'];
$fechaAlmoneda = $_POST['fechaAlmoneda'];
$id_movimientoAnterior = $_POST['id_movimientoAnterior'];

$sqlCancelar = new sqlCancelarDAO();

//Datos por tipo de contrato
$sqlCancelar->cancelarMovimiento($tipo_movimiento,$movimientoCancelado,$IdMovimiento,$fechaAlmoneda,$id_movimientoAnterior);


?>