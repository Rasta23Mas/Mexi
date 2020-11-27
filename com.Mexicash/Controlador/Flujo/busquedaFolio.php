<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlFlujoDAO.php");


$sqlFlujo = new sqlFlujoDAO();

$idFolioBuscar = $_POST['idFolioBuscar'];

//Busqueda de flujo
$sqlFlujo->busquedaFolio($idFolioBuscar);


?>