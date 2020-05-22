<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");


$sucursal = $_POST['sucursal'];


$sqlTblCierre = new sqlCierreDAO();
$sqlTblCierre->datosSucursal($sucursal);

?>