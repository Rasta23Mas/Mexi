<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlContratoDAO.php");

$contrato = $_POST['contrato'];
$idSerieContrato = $_POST['idSerieContrato'];
$sqlContrato = new sqlContratoDAO();
$sqlContrato->actualizarArticulo($contrato,$idSerieContrato);

?>

