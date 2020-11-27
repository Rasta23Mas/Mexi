<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$idMetal = $_POST['tipoMetal'];
$sqlTblCatMetales= new sqlCatalogoDAO();
$sqlTblCatMetales->llenarTblCatMetales($idMetal) ;


?>