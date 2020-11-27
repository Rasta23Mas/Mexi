<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlTokenDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$contrato = $_POST['contrato'];
$tipoContrato = $_POST['tipoContrato'];
$tipoFormulario = $_POST['tipoFormulario'];
$token = $_POST['token'];
$tokenDescripcion = $_POST['tokenDescripcion'];
$tokenMovimiento = $_POST['tokenMovimiento'];

$sqlToken = new sqlTokenDAO();
$sqlToken->tokenContrato($contrato,$tipoContrato,$tipoFormulario,$token,$tokenDescripcion,$tokenMovimiento);


