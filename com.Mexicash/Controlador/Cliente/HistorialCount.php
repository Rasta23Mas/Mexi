<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlClienteDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$clienteEmpeno = $_POST['clienteEmpeno'];
$sqlCliente = new sqlClienteDAO();


$sqlCliente->historialCount($clienteEmpeno);
