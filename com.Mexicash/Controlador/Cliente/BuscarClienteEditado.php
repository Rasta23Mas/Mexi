<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlClienteDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$idClienteEditado = $_POST['$clienteEditado'];
$sqlCliente = new sqlClienteDAO();
$sqlCliente->buscarClienteEditado($idClienteEditado);