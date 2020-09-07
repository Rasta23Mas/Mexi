<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");

$id_Bazar = $_POST['id_Bazar'];
$idCliente = $_POST['idCliente'];
$idVendedor = $_POST['idVendedor'];

$sqlVenta = new sqlVentasDAO();
$sqlVenta->sqlAgregarCarrito($id_Bazar,$idCliente,$idVendedor);