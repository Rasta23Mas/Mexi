<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");

$idCodigo = $_POST['idCodigo'];
$tipo = $_POST['tipo'];
$limit = $_POST['limit'];
$offset = $_POST['offset'];
$sqlVenta = new sqlVentasDAO();
$sqlVenta->sqlBusquedaCodigoApartados($idCodigo,$tipo,$limit,$offset);

