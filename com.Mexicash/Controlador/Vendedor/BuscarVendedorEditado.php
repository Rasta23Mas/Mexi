<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVendedorDAO.php");

$vendedorEditado = $_POST['vendedorEditado'];
$sqlVendedor = new sqlVendedorDAO();
$sqlVendedor->buscarVendedorEditado($vendedorEditado);