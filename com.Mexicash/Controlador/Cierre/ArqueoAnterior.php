<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");

$usuarioCaja = $_POST['usuarioCaja'];
$idCierreCaja = $_POST['idCierreCaja'];

$sqlCierre = new sqlCierreDAO();
$sqlCierre->busquedaArqueoAnterior($usuarioCaja,$idCierreCaja);

