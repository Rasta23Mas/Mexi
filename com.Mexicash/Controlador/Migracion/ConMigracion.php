<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlComprasDAO.php");

$tipo = $_POST['tipo'];

$sqlCompras = new sqlComprasDAO();
$sqlCompras->sqlBuscarIdBazarCompras();