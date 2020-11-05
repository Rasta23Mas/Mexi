<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlUsuarioDAO.php");

$usuario = $_POST['User'];

$usu = new sqlUsuarioDAO();
$usu->sqlCambioPass($usuario);


