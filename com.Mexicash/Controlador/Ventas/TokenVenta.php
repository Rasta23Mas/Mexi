<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");

$token = $_POST['token'];

$sqlDesempeno = new sqlVentasDAO();

$sqlDesempeno->validarToken($token);


?>