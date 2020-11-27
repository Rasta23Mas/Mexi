<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlUsuarioDAO.php");

$sucursal = $_POST['sucursal'];
$usu = new sqlUsuarioDAO();
$usu->sucursalAdmin($sucursal);


