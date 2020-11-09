<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");

$id_ArticuloBazar = $_POST['id_ArticuloBazar'];
$idCliente = $_POST['idCliente'];
$idBazar = $_POST['idBazar'];
$sqlVenta = new sqlVentasDAO();
$sqlVenta->sqlAgregarCarrito($id_ArticuloBazar,$idCliente,$idBazar);