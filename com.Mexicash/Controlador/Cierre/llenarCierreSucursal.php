<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");


$tipo = $_POST['tipo'];
$idCierreSucursal = $_POST['idCierreSucursal'];

$sqlTblCierre = new sqlCierreDAO();

if($tipo==1){
    $sqlTblCierre->validarCierreSucursal($idCierreSucursal);
}else if($tipo==2){
    $sqlTblCierre->llenarSaldosSucursal($idCierreSucursal);
}else if($tipo==3){
    $sqlTblCierre->llenarEntradasSalidas($idCierreSucursal);
}else if($tipo==4){
    $sqlTblCierre->llenarGenerales($idCierreSucursal);
}else if($tipo==5){
    $sqlTblCierre->llenarInformativo();
}


?>