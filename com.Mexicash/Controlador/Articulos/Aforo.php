<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");

$idTipoFormulario = $_POST['idTipoFormulario'];
$sqlTblArticulo= new sqlArticulosDAO();
$sqlTblArticulo->buscarAforo($idTipoFormulario) ;


?>