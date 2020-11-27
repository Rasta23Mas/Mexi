<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVendedorDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$idVendedorEditar = $_POST['idVendedorEditar'];
$sqlVendedor = new sqlVendedorDAO();
$sqlVendedor->buscarVendedorDatos($idVendedorEditar);