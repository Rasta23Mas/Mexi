<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlConfiguracionDAO.php");



$sqlConfiguracionDAO = new sqlConfiguracionDAO();
$sqlConfiguracionDAO->llenarHorario();

?>