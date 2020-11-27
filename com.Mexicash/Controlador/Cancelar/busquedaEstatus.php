<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCancelarDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$Contrato = $_POST['Contrato'];
$sqlCancelar = new sqlCancelarDAO();

//Datos por tipo de contrato
$sqlCancelar->busquedaEstatus($Contrato);


?>