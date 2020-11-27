<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$codigo = $_POST['codigo'];
$sqlVenta = new sqlVentasDAO();
$sqlVenta->busquedaApartados($codigo);

