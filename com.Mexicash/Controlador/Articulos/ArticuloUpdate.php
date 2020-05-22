<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlContratoDAO.php");

$contrato = $_POST['contrato'];
$sqlContrato = new sqlContratoDAO();
$sqlContrato->actualizarArticulo($contrato);

?>

