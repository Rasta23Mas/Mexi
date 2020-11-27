<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlFlujoDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$tipo = $_POST['tipo'];
$importe = $_POST['importe'];

$sqlFlujo = new sqlFlujoDAO();
$sqlFlujo->guardarAjustesArqueo($tipo,$importe);

?>