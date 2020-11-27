<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlTokenDAO.php");

$token = $_POST['token'];

$sqlToken = new sqlTokenDAO();

$sqlToken->sqlValidarToken($token);


?>