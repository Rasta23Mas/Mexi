<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCancelarDAO.php");

$tipoContratoGlobal = $_POST['tipoContratoGlobal'];
$tipo = $_POST['tipo'];
$sqlCancelar = new sqlCancelarDAO();

//Datos por tipo de contrato
if($tipo==1){
    $sqlCancelar->comprasCancelar();
}else if($tipo==2){
    $sqlCancelar->ventasCancelar();
}else if($tipo==3){
    $sqlCancelar->ventasCancelar();
}else if($tipo==4){
    $sqlCancelar->ventasCancelar();
}
?>