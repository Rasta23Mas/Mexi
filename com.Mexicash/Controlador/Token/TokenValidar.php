<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlDesempenoDAO.php");

$token = $_POST['token'];

$sqlDesempeno = new sqlDesempenoDAO();

$sqlDesempeno->validarToken($token);


?>