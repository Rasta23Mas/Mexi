<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlBitacorasDAO.php");

$precioAnteriorGlb = $_POST['precioAnteriorGlb'];
$precioModGlb = $_POST['precioModGlb'];
$idArticuloGlb = $_POST['idArticuloGlb'];
$idTokenGLb = $_POST['idTokenGLb'];

$bit = new sqlBitacorasDAO();
$bit->sqlBitPrecioMod($precioAnteriorGlb,$precioModGlb,$idArticuloGlb,$idTokenGLb);


