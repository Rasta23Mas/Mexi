<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCancelarDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$tipe = $_POST['tipe'];
$folio = $_POST['folio'];
$sqlCancelar = new sqlCancelarDAO();

if($tipe==1){
    //Cierre de Caja
    $sqlCancelar->cierreCaja();
}else if($tipe==2){
    //Cierre de Caja
    $sqlCancelar->cancelarCierreCaja($folio);
}




?>