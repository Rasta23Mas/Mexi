<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "ArticuloCompras.php");
include_once(SQL_PATH . "sqlArticulosComprasDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$idTipoEnviar = $_POST['idTipoEnviar'];
$idContrato = $_POST['idContrato'];
$SerieBazar = $_POST['SerieBazar'];
$id_serieTipo = $_POST['id_serieTipo'];
$tipo_movimiento = $_POST['tipo_movimiento'];
$descripcionCorta = $_POST['descripcionCorta'];
$idPrecioCompra = $_POST['idPrecioCompra'];

if ($idTipoEnviar == 1) {

    $idTipoM = $_POST['idTipoMetal'];
    $idKilataje = $_POST['idKilataje'];
    $idCalidad = $_POST['idCalidad'];
    $idCantidad = $_POST['idCantidad'];
    $idPeso = $_POST['idPeso'];
    $idPesoPiedra = $_POST['idPesoPiedra'];
    $idPiedras = $_POST['idPiedras'];
    $idVitrina = $_POST['idVitrina'];
    $idPrecioCat = null;
    $idDetallePrenda = $_POST['idDetallePrenda'];
    $idObs = $_POST['idObs'];

    $idTipoE = null;
    $idMarca = null;
    $idEstado = null;
    $idModelo = null;
    $idSerie = null;
    $tipoInteresE = null;
    $idObsE = null;
    $idDetallePrendaE = null;

} else if ($idTipoEnviar == 2) {

    $idTipoM = null;
    $idKilataje = null;
    $idCalidad = null;
    $idCantidad = null;
    $idPeso = null;
    $idPesoPiedra = null;
    $idPiedras = null;
    $idObs = null;
    $idDetallePrenda = null;
    $idTipoE = $_POST['idTipoElectronico'];
    $idMarca = $_POST['idMarca'];
    $idEstado = $_POST['idEstado'];
    $idModelo = $_POST['idModelo'];
    $idSerie = $_POST['idSerie'];
    $idVitrina = $_POST['idVitrina'];
    $idPrecioCat = $_POST['idPrecioCat'];
    $idObsE = $_POST['idObsElectronico'];
    $idDetallePrendaE = $_POST['idDetallePrendaElectronico'];
}

$articulo = new ArticuloCompras(
    $idTipoM,
    $idKilataje,
    $idCalidad,
    $idCantidad,
    $idPeso,
    $idPesoPiedra,
    $idPiedras,
    $idVitrina,
    $idPrecioCat,
    $idObs,
    $idDetallePrenda,
    $idTipoE,
    $idMarca,
    $idEstado,
    $idModelo,
    $idSerie,
    $idObsE,
    $idDetallePrendaE,
    $idContrato,
    $SerieBazar,
    $id_serieTipo,
    $tipo_movimiento,
    $descripcionCorta
);


$sqlArticuloCompras = new sqlArticulosComprasDAO();
$sqlArticuloCompras->sqlGuardarArticuloCompras($idTipoEnviar, $articulo,$idPrecioCompra);

?>

