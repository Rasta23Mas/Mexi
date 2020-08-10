<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");

$sqlCatalogos= new sqlCatalogoDAO();

$sucursal = $_POST['sucursal'];

$sqlCatalogos->catClientesConsulta($sucursal);


?>