<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");


$tipo = $_POST['tipo'];
$sqlTblCierre = new sqlCierreDAO();
$sqlTblCierre->validaCierreCaja();



?>