<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");


$idCodigo = $_POST['idCodigo'];
$sqlVenta = new sqlVentasDAO();
$sqlVenta->busquedaCodigoSeleccionado($idCodigo);