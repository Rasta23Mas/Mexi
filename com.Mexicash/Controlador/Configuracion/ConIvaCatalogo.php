<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlConfiguracionDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');


$sqlConfiguracionDAO = new sqlConfiguracionDAO();
$sqlConfiguracionDAO->sqlLlenarIvaCat();

?>