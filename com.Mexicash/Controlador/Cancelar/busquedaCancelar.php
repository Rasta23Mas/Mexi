<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCancelarDAO.php");

$tipoMovimiento = $_POST['tipoMovimiento'];
$tipoContratoGlobal = $_POST['tipoContratoGlobal'];
$sqlCancelar = new sqlCancelarDAO();

if($tipoMovimiento==5||$tipoMovimiento==9) {
    //Busqueda de estatus
    $sqlCancelar->desempenoCancelar($tipoMovimiento,$tipoContratoGlobal);
}else {
    //Datos por tipo de contrato
    $sqlCancelar->empenoCancelar($tipoMovimiento,$tipoContratoGlobal);
}

?>