<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlFlujoDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$idUsuarioCaja = $_POST['idUsuarioCaja'];

$sqlFlujo = new sqlFlujoDAO();

//Busqueda de flujo
$sqlFlujo->busquedaCaja($idUsuarioCaja);


?>