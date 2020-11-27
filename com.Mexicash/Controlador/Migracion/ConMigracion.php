<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlMigracionDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$tipo = $_POST['tipo'];

$sqlMigracion = new sqlMigracionDAO();
if($tipo==1){
    $sqlMigracion->sqlBuscarIdContrato();
}else if($tipo==2){
    $idContratoSerie = $_POST['idContratoSerie'];
    $checkCompraGlb = $_POST['checkCompraGlb'];
    $sqlMigracion->sqlBuscarValidarContrato($idContratoSerie,$checkCompraGlb);
}else if($tipo==3){
    $sqlMigracion->sqlArticulosMigObsoletos();
}
