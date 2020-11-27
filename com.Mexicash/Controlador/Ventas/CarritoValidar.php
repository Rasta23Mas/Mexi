<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");

$id_ArticuloBazar = $_POST['id_ArticuloBazar'];

$sqlVenta = new sqlVentasDAO();
$sqlVenta->sqlValidarCarrito($id_ArticuloBazar);