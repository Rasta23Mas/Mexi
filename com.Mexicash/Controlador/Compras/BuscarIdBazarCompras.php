<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlComprasDAO.php");

$sqlCompras = new sqlComprasDAO();
$sqlCompras->sqlBuscarIdBazarCompras();