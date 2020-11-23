<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");

$idPrecioMod = $_POST['idPrecioMod'];
$idArticulo = $_POST['idArticulo'];
$idCodigoAutMod = $_POST['idCodigoAutMod'];

$sqlDesempeno = new sqlVentasDAO();

$sqlDesempeno->sqlValidarPrecioMod($idPrecioMod,$idArticulo,$idCodigoAutMod);


?>