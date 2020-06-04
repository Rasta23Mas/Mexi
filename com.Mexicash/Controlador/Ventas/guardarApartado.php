<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");


$id_ContratoGlb = $_POST['id_ContratoGlb'];
$id_serieGlb = $_POST['id_serieGlb'];
$id_ClienteGlb = $_POST['id_ClienteGlb'];
$precio_ActualGlb = $_POST['precio_ActualGlb'];
$apartadoGlb = $_POST['apartadoGlb'];
$fechaVencimiento = $_POST['fechaVencimiento'];
$ivaGlb = $_POST['ivaGlb'];
$tipo_movimientoGlb = $_POST['tipo_movimientoGlb'];
$vendedorGlb = $_POST['vendedorGlb'];
$sucursalGlb = $_POST['sucursalGlb'];


$sqlVenta = new sqlVentasDAO();
$sqlVenta->guardarVenta($id_ContratoGlb,$id_serieGlb,$id_ClienteGlb,$precio_ActualGlb,$apartadoGlb,$fechaVencimiento,$ivaGlb,$tipo_movimientoGlb,$vendedorGlb,$sucursalGlb);