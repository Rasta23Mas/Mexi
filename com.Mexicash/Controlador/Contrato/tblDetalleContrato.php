<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlContratoDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');


$idContratoBusqueda = $_POST['idContratoBusqueda'];
$tipoContratoGlobal = $_POST['tipoContratoGlobal'];

$sqlTblContrato= new sqlContratoDAO();
if($tipoContratoGlobal==1){
    $sqlTblContrato->buscarDetalleContArticulo($idContratoBusqueda,$tipoContratoGlobal);

}else if($tipoContratoGlobal==2){
    $sqlTblContrato->buscarDetalleContAuto($idContratoBusqueda,$tipoContratoGlobal);

}

?>