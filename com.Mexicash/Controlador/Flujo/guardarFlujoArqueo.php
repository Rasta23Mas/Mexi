<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlFlujoDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$id_catFlujo = $_POST['id_catFlujo'];
$importe = $_POST['importe'];
$usuarioCaja = $_POST['usuarioCaja'];
$importeLetra = $_POST['importeLetra'];




$sqlFlujo = new sqlFlujoDAO();
$sqlFlujo->guardarFlujoArqueo($id_catFlujo,$importe,$usuarioCaja,$importeLetra);

?>