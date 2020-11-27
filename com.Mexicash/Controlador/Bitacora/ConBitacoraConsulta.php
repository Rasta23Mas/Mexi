<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlBitacorasDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$id_Movimiento = $_POST['id_Movimiento'];
$venta = $_POST['venta'];
$idContrato = $_POST['idContrato'];
$cliente = $_POST['cliente'];
$consulta_fechaInicio = $_POST['consulta_fechaInicio'];
$consulta_fechaFinal = $_POST['consulta_fechaFinal'];

$bit = new sqlBitacorasDAO();
$bit->sqlBitacoraConsultas($id_Movimiento,$venta,$idContrato,$cliente,$consulta_fechaInicio,$consulta_fechaFinal);


