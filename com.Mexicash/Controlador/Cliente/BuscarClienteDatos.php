<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlClienteDAO.php");

$idClienteEditar = $_POST['idClienteEditar'];
$sqlCliente = new sqlClienteDAO();
$sqlCliente->buscarClienteDatos($idClienteEditar);