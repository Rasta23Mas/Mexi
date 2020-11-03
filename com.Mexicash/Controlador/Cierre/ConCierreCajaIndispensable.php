<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");


$estatus = $_POST['estatus'];

$sqlTblCierre = new sqlCierreDAO();
$sqlTblCierre->sqlCierreCajaIndispensable($estatus);


?>