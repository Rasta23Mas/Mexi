<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlDesempenoDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$idContrato = $_POST['contrato'];
$tipoContrato = $_POST['tipoContrato'];
$sqlDesempeno= new sqlDesempenoDAO();

$sqlDesempeno->busquedaMovimiento($idContrato,$tipoContrato);

?>