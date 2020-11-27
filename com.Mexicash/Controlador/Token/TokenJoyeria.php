<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlTokenDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$tokenID= $_POST['response'];
$tokenDes = $_POST['tokenDes'];
$motivo = $_POST['motivo'];
$prestamo = $_POST['prestamo'];
$prestamoNuevo = $_POST['prestamoNuevo'];

$sqlToken = new sqlTokenDAO();

$sqlToken->sqlTokenJoyeria($tokenID,$tokenDes,$motivo,$prestamo,$prestamoNuevo);


?>