<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");

$idCierreCaja = $_POST['idCierreCaja'];

$sqlCierre = new sqlCierreDAO();
$sqlCierre->ArqueoEntradasySalidasVentas($idCierreCaja);

