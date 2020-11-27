<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCancelarDAO.php");

$ContratoCancelar = $_POST['ContratoCancelar'];
$IdMovimiento = $_POST['IdMovimiento'];


$sqlCancelar = new sqlCancelarDAO();

//Datos por tipo de contrato
$sqlCancelar->recuperaFechaAlm($ContratoCancelar,$IdMovimiento);


?>