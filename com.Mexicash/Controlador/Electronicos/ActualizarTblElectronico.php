<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");

$tipo = $_POST['tipo'];
$idProducto = $_POST['idProducto'];
$sqlCatalogo = new sqlCatalogoDAO();
if ($tipo == 1) {
    $sqlCatalogo->buscarElectronicoById($idProducto);
} else if ($tipo == 2) {
    $sqlCatalogo->eliminarProducto($idProducto);
}




?>

