<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCancelarDAO.php");

$tipo_movimiento = $_POST['tipo_movimiento'];
$movimientoCancelado = $_POST['movimientoCancelado'];
$IdMovimiento = $_POST['IdMovimiento'];

$sqlCancelar = new sqlCancelarDAO();

//Datos por tipo de contrato
$sqlCancelar->cancelarMovimiento($tipo_movimiento,$movimientoCancelado,$IdMovimiento);


?>