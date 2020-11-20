<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");

$sqlTblCierre = new sqlCierreDAO();
$sqlTblCierre->sqlActualizarBazar();

?>