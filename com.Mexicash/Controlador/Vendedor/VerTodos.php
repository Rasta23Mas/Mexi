<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVendedorDAO.php");


$Mostrar = $_POST['Mostrar'];
$idNombresVendedor = $_POST['idNombresVendedor'];
$sqlVendedor= new sqlVendedorDAO();

if($Mostrar==1){
    $sqlVendedor->traerTodos();
}else if($Mostrar==2){
    $sqlVendedor->verTodos($idNombresVendedor);
}


