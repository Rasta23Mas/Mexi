<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlClienteDAO.php");


$sqlCliente = new sqlClienteDAO();
$sqlCliente->buscarClienteAgregado();