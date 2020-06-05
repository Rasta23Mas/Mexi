<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");


$id_Contrato = $_POST['id_Contrato'];
$sqlVenta = new sqlVentasDAO();
$sqlVenta->busquedaAbonos($id_Contrato);