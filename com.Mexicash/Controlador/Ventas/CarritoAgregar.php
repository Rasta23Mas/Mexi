<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");

$id_ArticuloBazar = $_POST['id_ArticuloBazar'];
$idCliente = $_POST['idCliente'];
$idVendedor = $_POST['idVendedor'];

$sqlVenta = new sqlVentasDAO();
$sqlVenta->sqlAgregarCarrito($id_ArticuloBazar,$idCliente,$idVendedor);