<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");

$idBazar = $_POST['idBazar'];
$tipo_movimiento = $_POST['tipo_movimiento'];

$sqlVenta = new sqlVentasDAO();
$sqlVenta->sqlArticulosUpdate($idBazar,$tipo_movimiento);