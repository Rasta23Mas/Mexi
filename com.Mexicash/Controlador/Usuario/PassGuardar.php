<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlUsuarioDAO.php");

$pass = $_POST['pass'];
$user = $_POST['user'];

$hashed_password = password_hash($pass, PASSWORD_DEFAULT);

$usu = new sqlUsuarioDAO();
$usu->sqlGuardarPass($hashed_password,$user);


