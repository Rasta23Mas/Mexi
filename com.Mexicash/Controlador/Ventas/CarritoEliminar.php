<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");

$id_Ventas = $_POST['id_Ventas'];

$sqlVenta = new sqlVentasDAO();
$sqlVenta->sqlEliminarCarrito($id_Ventas);