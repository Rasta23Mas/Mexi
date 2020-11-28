<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlTokenDAO.php");

$contrato = $_POST['contrato'];
$token = $_POST['token'];
$tokenDescripcion = $_POST['tokenDescripcion'];


$sqlToken = new sqlTokenDAO();
$sqlToken->sqlTokenAutoMig($contrato,$token,$tokenDescripcion);


