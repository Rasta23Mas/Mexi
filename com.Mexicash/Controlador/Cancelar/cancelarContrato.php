<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCancelarDAO.php");

$Contrato = $_POST['Contrato'];
$tipoContratoGlobal = $_POST['tipoContratoGlobal'];
$sqlCancelar = new sqlCancelarDAO();

//Datos por tipo de contrato
$sqlCancelar->cancelarContrato($Contrato,$tipoContratoGlobal);


?>