<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/dirs.php');
include_once (SQL_PATH."sqlClienteDAO.php");

$nombre = $_GET['cliente'];

$sql = new sqlClienteDAO();

$arr = array();

$data = array();

$arr = $sql->consultaClienteEmpeño($nombre, 3);

echo json_encode($arr);
