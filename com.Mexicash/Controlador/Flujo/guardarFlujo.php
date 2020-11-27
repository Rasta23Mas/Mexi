<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlFlujoDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$id_catFlujo = $_POST['id_catFlujo'];
$importe = $_POST['importe'];
$idFolio = $_POST['idFolio'];
$concepto = $_POST['concepto'];
$usuarioCaja = $_POST['usuarioCaja'];
$importeLetra = $_POST['importeLetra'];

$Central = $_POST['Central'];
$Banco = $_POST['Banco'];
$Boveda = $_POST['Boveda'];
$Caja = $_POST['Caja'];




$sqlFlujo = new sqlFlujoDAO();
$sqlFlujo->updateFlujo($id_catFlujo,$importe,$idFolio,$concepto,$usuarioCaja,$importeLetra,$Central,$Banco,$Boveda,$Caja);

?>