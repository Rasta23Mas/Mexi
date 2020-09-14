<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosComprasDAO.php");

$sqlTblArticuloCom = new sqlArticulosComprasDAO();
$sqlTblArticuloCom->sqlBuscarArticulosCompras() ;


?>