<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlBitacorasDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$id_Movimiento = $_POST['id_Movimiento'];
$idContratoCompra = $_POST['idContratoCompra'];
$id_vendedor = $_POST['id_vendedor'];
$idToken = $_POST['idToken'];


$bit = new sqlBitacorasDAO();
$bit->sqlBitacoraCompras($id_Movimiento,$idContratoCompra,$id_vendedor,$idToken);


