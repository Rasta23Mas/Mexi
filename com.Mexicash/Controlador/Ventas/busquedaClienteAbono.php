<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');


$id_ClienteGlb = $_POST['id_ClienteGlb'];
$sqlVenta = new sqlVentasDAO();
$sqlVenta->busquedaApartadosCliente($id_ClienteGlb);