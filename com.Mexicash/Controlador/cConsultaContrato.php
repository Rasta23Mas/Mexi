<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/dirs.php');
include_once (SQL_PATH."sqlContratoDAO.php");

$contrato = $_GET['contrato'];
$nombre = $_GET['nombre'];
$celular = $_GET['celular'];

$sql = new sqlContratoDAO();

$arr = array();

$arr = $sql->buscarContrato($contrato, $nombre, $celular);

echo json_encode($arr);
