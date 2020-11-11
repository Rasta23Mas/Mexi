<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");

$idCierreCaja = $_POST['idCierreCaja'];
$tipo = $_POST['tipo'];
$sqlCierre = new sqlCierreDAO();
if($tipo==0){
    $sqlCierre->sqlArqueoEntradasySalidas($idCierreCaja);
}else if($tipo==1){
    $sqlCierre->sqlArqueoEntradasySalidasVentas($idCierreCaja);
}else if($tipo==2){
    $sqlCierre->sqlArqueoEntradasySalidasCompras($idCierreCaja);
}

