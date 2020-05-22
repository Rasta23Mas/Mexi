<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");

$tipoCombo = $_POST['tipoCombo'];
$marcaCombo = $_POST['marcaCombo'];
$modeloCombo = $_POST['modeloCombo'];

$sqlTblElectronico= new sqlCatalogoDAO();
$sqlTblElectronico->buscarElectronico($tipoCombo,$marcaCombo,$modeloCombo) ;


?>