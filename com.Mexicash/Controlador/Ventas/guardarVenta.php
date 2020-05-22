<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");


$estatus = $_POST['estatus'];
$estatusAnterior = $_POST['estatusAnterior'];
$bazar = $_POST['bazar'];
$cliente = $_POST['cliente'];
$vendedor = $_POST['vendedor'];
$precioVenta = $_POST['precioVenta'];
$descuento = $_POST['descuento'];



$sqlVenta = new sqlVentasDAO();
$sqlVenta->guardarVenta($estatus,$estatusAnterior,$bazar,$cliente,$vendedor,$precioVenta,$descuento);