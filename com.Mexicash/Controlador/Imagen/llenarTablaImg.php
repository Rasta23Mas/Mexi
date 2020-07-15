<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlFotografiaDAO.php");

$idContratoBusqueda = $_POST['idContratoBusqueda'];

$sqlFlujo = new sqlFotografiaDAO();

//Busqueda de flujo
$sqlFlujo->llenarTablaImagenes($idContratoBusqueda);


?>