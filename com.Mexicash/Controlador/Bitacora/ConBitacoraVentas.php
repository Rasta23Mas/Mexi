<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlBitacorasDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$id_Movimiento = $_POST['id_Movimiento'];
$id_bazar = $_POST['id_bazar'];
$id_cliente = $_POST['id_cliente'];
$idToken = $_POST['idToken'];

$bit = new sqlBitacorasDAO();
$bit->sqlBitacoraVentas($id_Movimiento,$id_bazar,$id_cliente,$idToken);


