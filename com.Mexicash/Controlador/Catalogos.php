<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");

$tipoConsulta= $_POST['tipoConsulta'];
$sqlCatalogo = new sqlCatalogoDAO();
 if($tipoConsulta==1){
    $idEstado= $_POST['Estado'];
     $idMunicipio= null;
    $sqlCatalogo->completaMunicipio($idEstado);
}else if($tipoConsulta==2){
    $idEstado= $_POST['Estado'];
    $idMunicipio= $_POST['Municipio'];
    $sqlCatalogo->completaLocalidad($idEstado,$idMunicipio);
}


