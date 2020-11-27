<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCancelarDAO.php");

$id_Bazar = $_POST['id_Bazar'];
$tipo = $_POST['tipo'];
$sqlCancelar = new sqlCancelarDAO();

//Datos por tipo de contrato
if($tipo==22){
    $sqlCancelar->sqlBusquedaEstatusApartado($id_Bazar);
}else if($tipo==23){
    $sqlCancelar->sqlBusquedaEstatusAbono($id_Bazar);
}



?>