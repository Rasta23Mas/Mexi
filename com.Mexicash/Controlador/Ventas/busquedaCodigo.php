<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");


$idCodigo = $_POST['idCodigo'];
$tipoBusqueda = $_POST['tipoBusqueda'];
$sqlVenta = new sqlVentasDAO();
if($tipoBusqueda==1){
    $sqlVenta->busquedaCodigo($idCodigo);
}else if ($tipoBusqueda==2){
    $sqlVenta->busquedaContrato($idCodigo);
}else if ($tipoBusqueda==3){
    $id_bazar = $_POST['id_bazar'];
    $sqlVenta->sqlBusquedaSinCodigo($idCodigo,$id_bazar);
}


