<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlFlujoDAO.php");

$id_catFlujo = $_POST['id_catFlujo'];
$importe = $_POST['importe'];
$idFolio = $_POST['idFolio'];
$concepto = $_POST['concepto'];
$usuarioCaja = $_POST['usuarioCaja'];
$importeLetra = $_POST['importeLetra'];




$sqlFlujo = new sqlFlujoDAO();
$sqlFlujo->updateFlujo($id_catFlujo,$importe,$idFolio,$concepto,$usuarioCaja,$importeLetra);

?>