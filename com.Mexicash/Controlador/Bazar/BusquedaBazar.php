<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlBazarDAO.php");


$tipo = $_POST['tipo'];

$sqlTblBazar = new sqlBazarDAO();

if($tipo==1){
    //Empeños que pasan a Bazar
    $sqlTblBazar->empenosBazar();
} else if($tipo==2){
    //Empeños que pasan a Bazar
    $sqlTblBazar->empenosBazar();
}






?>