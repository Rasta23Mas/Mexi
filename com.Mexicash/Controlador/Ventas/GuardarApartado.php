<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');


$tipo_movimiento = $_POST['tipo_movimiento'];
$subTotal = $_POST['subTotal'];
$iva = $_POST['iva'];
$apartado = $_POST['apartado'];
$faltaPagar = $_POST['faltaPagar'];
$total = $_POST['total'];
$efectivo = $_POST['efectivo'];
$cambio = $_POST['cambio'];
$cliente = $_POST['cliente'];
$idBazar = $_POST['idBazar'];
$vencimiento = $_POST['vencimiento'];

$sqlVenta = new sqlVentasDAO();
$sqlVenta->sqlGuardarApartado($tipo_movimiento,$subTotal,$iva,$apartado,$faltaPagar,$total,$efectivo,$cambio,$cliente,$idBazar,$vencimiento);