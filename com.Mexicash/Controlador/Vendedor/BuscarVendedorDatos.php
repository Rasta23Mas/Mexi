<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVendedorDAO.php");

$idVendedorEditar = $_POST['idVendedorEditar'];
$sqlVendedor = new sqlVendedorDAO();
$sqlVendedor->buscarVendedorDatos($idVendedorEditar);