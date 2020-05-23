<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlUsuarioDAO.php");

$saldoInicial = $_POST['saldoInicial'];
$usu = new sqlUsuarioDAO();
$usu->saldosSucursal();





