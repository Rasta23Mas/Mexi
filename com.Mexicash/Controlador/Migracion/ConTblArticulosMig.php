<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlMigracionDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$sqlTblArticuloMig = new sqlMigracionDAO();
$sqlTblArticuloMig->sqlBuscarArticulosMig() ;


?>