<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");

$tipo_movimiento = $_POST['tipo_movimiento'];
$subTotal = $_POST['subTotal'];
$iva = $_POST['iva'];
$descuento = $_POST['descuento'];
$total = $_POST['total'];
$totalprestamo = $_POST['totalprestamo'];
$utilidad = $_POST['utilidad'];
$efectivo = $_POST['efectivo'];
$cambio = $_POST['cambio'];
$cliente = $_POST['cliente'];
$idToken = $_POST['idToken'];
$tokenDesc = $_POST['tokenDesc'];
$idBazar = $_POST['idBazar'];


$sqlVenta = new sqlVentasDAO();
$sqlVenta->sqlGuardarVenta($tipo_movimiento,$subTotal,$iva,$descuento,$total,$totalprestamo,$utilidad,$efectivo,$cambio,$cliente,$idToken,$tokenDesc,$idBazar);