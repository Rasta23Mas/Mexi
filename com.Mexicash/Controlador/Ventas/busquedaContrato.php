<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");


$idContrato = $_POST['idContrato'];
$sqlVenta = new sqlVentasDAO();
$sqlVenta->busquedaContrato($idContrato);