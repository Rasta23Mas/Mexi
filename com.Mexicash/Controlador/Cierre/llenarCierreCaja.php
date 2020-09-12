<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");


$tipo = $_POST['tipo'];
$idUsuarioSelect = $_POST['idUsuarioSelect'];
$idCierreCaja = $_POST['idCierreCaja'];

$sqlTblCierre = new sqlCierreDAO();

if($tipo==1){
    $sqlTblCierre->llenarMovimientosCaja($idUsuarioSelect);
} else if($tipo==2){
    $sqlTblCierre->llenarEntradasySalidas($idCierreCaja);
}else if($tipo==3){
    $sqlTblCierre->llenarEfectivoCaja($idCierreCaja);
}else if($tipo==4){
    $sqlTblCierre->validaCierreCaja($idCierreCaja);
}else if($tipo==5){
    $sqlTblCierre->traerCierreCaja($idUsuarioSelect);
}else if($tipo==6){
    $sqlTblCierre->llenarInformeRefrendo($idCierreCaja);
}else if($tipo==7){
    $sqlTblCierre->llenarAjustesCaja($idCierreCaja);
}else if($tipo==8){
    $sqlTblCierre->validaCierreCajaArqueo($idCierreCaja);
}else if($tipo==9){
    $sqlTblCierre->sqlLlenarEntradasySalidasVentas($idCierreCaja);
}


?>