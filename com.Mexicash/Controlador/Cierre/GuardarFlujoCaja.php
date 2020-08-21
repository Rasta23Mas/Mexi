<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");

$id_catFlujo = $_POST['id_catFlujo'];
$importe = $_POST['importe'];
$importeLetra = $_POST['importeLetra'];
$usuarioCaja = $_POST['usuarioCaja'];




$sqlCierre = new sqlCierreDAO();
$sqlCierre->guardarFlujoDeCaja($id_catFlujo,$importe,$importeLetra,$usuarioCaja);

?>