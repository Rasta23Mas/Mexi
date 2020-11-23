<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlMigracionDAO.php");

$sqlTblArticuloMig = new sqlMigracionDAO();
$sqlTblArticuloMig->sqlBuscarArticulosMig() ;


?>