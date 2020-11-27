<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlClienteDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');


$Mostrar = $_POST['Mostrar'];
$idNombres = $_POST['$idNombres'];
$sqlCliente = new sqlClienteDAO();

if($Mostrar==1){
    $sqlCliente->traerTodos();
}else if($Mostrar==2){
    $sqlCliente->verTodos($idNombres);
}


