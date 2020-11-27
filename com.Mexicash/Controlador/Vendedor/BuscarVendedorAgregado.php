<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVendedorDAO.php");


$sqlVendedor = new sqlVendedorDAO();
$sqlVendedor->buscarVendedorAgregado();