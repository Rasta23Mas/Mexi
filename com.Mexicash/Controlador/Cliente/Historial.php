<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlClienteDAO.php");

$clienteEmpeno = $_POST['clienteEmpeno'];
$tipo = $_POST['tipo'];
$sqlCliente = new sqlClienteDAO();
if($tipo==1){
    $sqlCliente->historial($clienteEmpeno);
}else if($tipo==2){
    $sqlCliente->historialAuto($clienteEmpeno);
}
