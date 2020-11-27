<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");

$articulos = new sqlArticulosDAO();
$articulos->llenarCmbCatArticulos();
?>

