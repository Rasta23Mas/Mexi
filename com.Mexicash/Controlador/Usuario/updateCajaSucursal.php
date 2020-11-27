<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlUsuarioDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$saldoInicialInfo = $_POST['saldoInicialInfo'];
$usu = new sqlUsuarioDAO();
$usu->saldosSucursal($saldoInicialInfo);





