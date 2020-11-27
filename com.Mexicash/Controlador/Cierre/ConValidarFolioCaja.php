<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$sqlCierre = new sqlCierreDAO();
$sqlCierre->sqlValidarFolioCaja();

?>