<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlClienteDAO.php");

$idNombres = $_POST['$idNombres'];
$sqlCliente = new sqlClienteDAO();
$sqlCliente->verTodos($idNombres);