<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlDesempenoDAO.php");

$idtipe = $_POST['tipe'];
$IdMovimiento = $_POST['IdMovimiento'];
$sqlDesempeno= new sqlDesempenoDAO();
$tipoContrato = $_POST['tipoContrato'];
if($idtipe==1) {
    //Busqueda de estatus

    $sqlDesempeno->estatusContrato($IdMovimiento,$tipoContrato);
}else if($idtipe==2){
    //Datos del cliente
    $sqlDesempeno->buscarCliente($IdMovimiento,$tipoContrato);
}else if($idtipe==3){
    //Buscar datos del contrato
    $sqlDesempeno->buscarContrato($IdMovimiento,$tipoContrato);
}else if($idtipe==4){
    //Buscar detalle articulos
    $sqlDesempeno->buscarDetalle($IdMovimiento) ;
}else if($idtipe==5){
    //Buscar detalle auto
    $sqlDesempeno->buscarDetalleAuto($IdMovimiento) ;
}

/* if($idtipe==22){
    $sqlDesempeno->buscarContratoDes($idContrato) ;
}else if($idtipe==44){
    $sqlDesempeno->buscarClienteDesAuto($idContrato) ;
}else if($idtipe==55){
    $sqlDesempeno->buscarContratoDesAuto($idContrato) ;
}else if($idtipe==8){
    $sqlDesempeno->buscarContratoRefAuto($idContrato) ;
}else if($idtipe==9){
    //Busqueda de estatus
    $sqlDesempeno->estatusContrato($idContrato,$tipoContrato) ;
}else if($idtipe==10){
    //Busqueda de estatus
    $sqlDesempeno->estatusContratoAuto($idContrato) ;
}*/



?>