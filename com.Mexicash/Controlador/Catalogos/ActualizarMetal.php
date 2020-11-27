<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");

$tipo = $_POST['tipo'];


$sqlMetal = new sqlCatalogoDAO();
if($tipo==1){
    $idMetal = $_POST['idMetal'];
    $sqlMetal->eliminarMetal($idMetal);
}else if($tipo==2){
    $idMetal = $_POST['idMetal'];
    $precio = $_POST['precio'];
    $sqlMetal->guardarMetal($idMetal,$precio);
}if($tipo==3){
    $idTipo = $_POST['idTipo'];
    $unidad = $_POST['unidad'];
    $precio = $_POST['precio'];
    $sqlMetal->agregarMetal($idTipo,$unidad,$precio);
}else if($tipo==4){
    $idMetal = $_POST['idMetal'];
    $sqlMetal->modalLLenarMetales($idMetal);
}
