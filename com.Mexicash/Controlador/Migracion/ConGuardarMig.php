<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlMigracionDAO.php");


$sqlMig = new sqlMigracionDAO();
$sqlMig->sqlGuardarMig();