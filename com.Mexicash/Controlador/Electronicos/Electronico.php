<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");

$tipo = $_POST['tipo'];
$sqlCatalogo = new sqlCatalogoDAO();
if ($tipo == 1) {
    $sqlCatalogo->cmbElectroTipo();
} else if ($tipo == 2) {
    $tipoCombo = $_POST['tipoCombo'];
    $sqlCatalogo->cmbElectroMarca($tipoCombo);
}else if ($tipo == 3) {
    $tipoCombo = $_POST['tipoCombo'];
    $marcaCombo = $_POST['marcaCombo'];
    $sqlCatalogo->cmbElectroModelo($tipoCombo,$marcaCombo);
}else if ($tipo == 4) {
    $descripcion = $_POST['descripcion'];
    $sqlCatalogo->agregarTipo($descripcion);
} else if ($tipo == 5) {
    $tipoCombo = $_POST['tipoCombo'];
    $descripcion = $_POST['descripcion'];
    $sqlCatalogo->agregarMarca($tipoCombo,$descripcion);
}else if ($tipo == 6) {
    $tipoCombo = $_POST['tipoCombo'];
    $marcaCombo = $_POST['marcaCombo'];
    $descripcion = $_POST['descripcion'];
    $sqlCatalogo->agregarModelo($tipoCombo,$marcaCombo,$descripcion);
}else if ($tipo == 7) {
    $cmbTipo = $_POST['cmbTipo'];
    $cmbMarca = $_POST['cmbMarca'];
    $cmbModelo = $_POST['cmbModelo'];
    $precio = $_POST['precio'];
    $vitrina = $_POST['vitrina'];
    $caracteristicas = $_POST['caracteristicas'];
    $sqlCatalogo->agregarProducto($cmbTipo,$cmbMarca,$cmbModelo,$precio,$vitrina,$caracteristicas);
}else if ($tipo == 8) {
    $idElectro = $_POST['idElectro'];
    $precio = $_POST['precio'];
    $vitrina = $_POST['vitrina'];
    $caracteristicas = $_POST['caracteristicas'];
    $sqlCatalogo->editarProducto($idElectro,$precio,$vitrina,$caracteristicas);
}else if ($tipo == 10) {
    $idElectro = $_POST['descripcion'];

    $sqlCatalogo->pruebaFecha($idElectro);
}




?>

