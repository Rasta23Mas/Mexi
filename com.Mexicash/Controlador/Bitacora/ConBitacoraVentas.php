<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlBitacorasDAO.php");

$id_Movimiento = $_POST['id_Movimiento'];
$id_bazar = $_POST['id_bazar'];
$id_cliente = $_POST['id_cliente'];
$id_vendedor = $_POST['id_vendedor'];
$idToken = $_POST['idToken'];

$bit = new sqlBitacorasDAO();
$bit->sqlBitacoraVentas($id_Movimiento,$id_bazar,$id_cliente,$id_vendedor,$idToken);


