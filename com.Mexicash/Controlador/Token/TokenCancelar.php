<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlTokenDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$token = $_POST['token'];
$Contrato = $_POST['Contrato'];
$tipoContrato = $_POST['tipoContrato'];


$sqlToken = new sqlTokenDAO();
$sqlToken->tokenCancelaciones($token,$Contrato,$tipoContrato);


?>