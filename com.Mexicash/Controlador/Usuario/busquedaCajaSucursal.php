<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlUsuarioDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$tipo = $_POST['tipo'];
$idCierreSuc = $_POST['idCierreSuc'];
$usu = new sqlUsuarioDAO();

if($tipo==3){
    $usu->insertaCajaSucursal($idCierreSuc);
}else if($tipo==4){
    $usu->haySucursalesRegistradas();
}else if($tipo==5){
    $usu->haySucursalesHoy();
}else if($tipo==6){
    $usu->insertaCajaMaxSucursal();
}else if($tipo==7){
    $usu->buscarInfoSaldoInicial();
}




