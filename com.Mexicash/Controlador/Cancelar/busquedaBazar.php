<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCancelarDAO.php");

$tipoContratoGlobal = $_POST['tipoContratoGlobal'];
$tipo = $_POST['tipo'];
$sqlCancelar = new sqlCancelarDAO();

//Datos por tipo de contrato
if($tipo==1){
    $sqlCancelar->comprasCancelar();
}else{
    $sqlCancelar->ventasCancelar();
}
?>