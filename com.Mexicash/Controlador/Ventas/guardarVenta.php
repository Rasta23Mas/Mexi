<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");



$id_ContratoGlb = $_POST['id_ContratoGlb'];
$id_serieGlb = $_POST['id_serieGlb'];
$id_ClienteGlb = $_POST['id_ClienteGlb'];
$ivaGlb = $_POST['ivaGlb'];
$tipo_movimientoGlb = $_POST['tipo_movimientoGlb'];
$vendedorGlb = $_POST['vendedorGlb'];
$efectivo = $_POST['efectivo'];
$cambio = $_POST['cambio'];
$precioVenta = $_POST['precioVenta'];
$descuento = $_POST['descuento'];
$idToken = $_POST['idToken'];
$tokenDesc = $_POST['tokenDesc'];





$sqlVenta = new sqlVentasDAO();
$sqlVenta->guardarVenta($id_ContratoGlb,$id_serieGlb,$id_ClienteGlb,
    $ivaGlb,$tipo_movimientoGlb,$vendedorGlb,$efectivo,$cambio,$precioVenta,
    $descuento,$idToken,$tokenDesc);