<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");

$id_Cliente = $_POST['id_Cliente'];
$id_Contrato = $_POST['id_Contrato'];
$id_serie = $_POST['id_serie'];
$tipo_movimiento = $_POST['tipo_movimiento'];
$idPrestamo = $_POST['idPrestamo'];
$precio_Actual = $_POST['precio_Actual'];
$iva = $_POST['iva'];
$apartado = $_POST['apartado'];
$abono = $_POST['abono'];
$abono_Total = $_POST['abono_Total'];
$efectivo = $_POST['efectivo'];
$cambio = $_POST['cambio'];
$sucursal = $_POST['sucursal'];

$sqlVenta = new sqlVentasDAO();
$sqlVenta->guardarAbono($id_Cliente,$id_Contrato,$id_serie,$tipo_movimiento,$idPrestamo,$precio_Actual,$iva,$apartado,$abono,$abono_Total,$efectivo,$cambio,$sucursal);