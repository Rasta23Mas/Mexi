<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");


$id_Contrato = $_POST['id_Contrato'];
$id_serie = $_POST['id_serie'];
$tipo_movimiento = $_POST['tipo_movimiento'];
$precio_Actual = $_POST['precio_Actual'];
$abono = $_POST['abono'];
$abono_Total = $_POST['abono_Total'];
$efectivo = $_POST['efectivo'];
$cambio = $_POST['cambio'];
$sucursal = $_POST['sucursal'];

$sqlVenta = new sqlVentasDAO();
$sqlVenta->guardarAbono($id_Contrato,$id_serie,$tipo_movimiento,$precio_Actual,$abono,$abono_Total,$efectivo,$cambio,$sucursal);