<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");


$id_Bazar = $_POST['id_Bazar'];
$sqlVenta = new sqlVentasDAO();
$sqlVenta->busquedaAbonos($id_Bazar);