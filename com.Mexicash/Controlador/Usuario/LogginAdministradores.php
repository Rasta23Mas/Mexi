<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlUsuarioDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$sucursal = $_POST['sucursal'];
$usu = new sqlUsuarioDAO();
$usu->sucursalAdmin($sucursal);


