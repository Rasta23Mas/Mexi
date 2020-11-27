<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");


$idArticulo = $_POST['$idArticulo'];

$sqlArticulo = new sqlArticulosDAO();
$sqlArticulo->eliminarArticulo($idArticulo);