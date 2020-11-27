<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlUsuarioDAO.php");

$saldoInicialInfo = $_POST['saldoInicialInfo'];
$usu = new sqlUsuarioDAO();
$usu->saldosSucursal($saldoInicialInfo);





