<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlClienteDAO.php");

$ClienteNombre= $_POST['idNombres'];
$sqlCliente = new sqlClienteDAO();
$sqlCliente->autocompleteClienteAbono($ClienteNombre);