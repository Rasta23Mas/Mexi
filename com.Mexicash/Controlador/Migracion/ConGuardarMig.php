<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlMigracionDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');


$sqlMig = new sqlMigracionDAO();
$sqlMig->sqlGuardarMig();