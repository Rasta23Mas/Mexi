<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlComprasDAO.php");

$tipoMovimiento = $_POST['tipoMovimiento'];
$idVendedor = $_POST['idVendedor'];
$subTotal = $_POST['subTotal'];
$iva = $_POST['iva'];
$total = $_POST['total'];
$efectivo = $_POST['efectivo'];
$cambio = $_POST['cambio'];
$idContratoCompra = $_POST['idContratoCompra'];
$idCompraGlb = $_POST['idCompraGlb'];

$sqlCompra = new sqlComprasDAO();
$sqlCompra->sqlGuardarCompra($tipoMovimiento,$idVendedor,$subTotal,$iva,$total,$efectivo,$cambio,$idContratoCompra,$idCompraGlb);