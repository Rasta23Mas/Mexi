<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "ArticuloCompras.php");
include_once(SQL_PATH . "sqlArticulosComprasDAO.php");

$idTipoEnviar = $_POST['idTipoEnviar'];
$idArticulo = $_POST['idArticulo'];


if ($idTipoEnviar == 1) {

    $idTipoM = $_POST['idTipoMetal'];
    $idKilataje = $_POST['idKilataje'];
    $idCalidad = $_POST['idCalidad'];
    $idCantidad = $_POST['idCantidad'];
    $idPeso = $_POST['idPeso'];
    $idPesoPiedra = $_POST['idPesoPiedra'];
    $idPiedras = $_POST['idPiedras'];
    $idPrestamo = $_POST['idPrestamo'];
    $idAvaluo = $_POST['idAvaluo'];
    $idAvaluo = $_POST['idAvaluo'];
    $idVitrina = $_POST['idVitrina'];
    $idPrecioCat = null;
    $idDetallePrenda = $_POST['idDetallePrenda'];
    $idObs = $_POST['idObs'];

    $idTipoE = null;
    $idMarca = null;
    $idEstado = null;
    $idModelo = null;
    $idSerie = null;
    $idPrestamoE = null;
    $idAvaluoE = null;
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
    $idPrestamo = null;
    $idAvaluo = null;
    $idObs = null;
    $idDetallePrenda = null;
    $idTipoE = $_POST['idTipoElectronico'];
    $idMarca = $_POST['idMarca'];
    $idEstado = $_POST['idEstado'];
    $idModelo = $_POST['idModelo'];
    $idSerie = $_POST['idSerie'];
    $idPrestamoE = $_POST['idPrestamoElectronico'];
    $idAvaluoE = $_POST['idAvaluoElectronico'];
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
    $idPrestamo,
    $idAvaluo,
    $idVitrina,
    $idPrecioCat,
    $idObs,
    $idDetallePrenda,
    $idTipoE,
    $idMarca,
    $idEstado,
    $idModelo,
    $idSerie,
    $idPrestamoE,
    $idAvaluoE,
    $idObsE,
    $idDetallePrendaE
);

$sqlArticuloCompras = new sqlArticulosComprasDAO();
$sqlArticuloCompras->guardarArticuloCompras($idTipoEnviar,$idArticulo, $articulo);

?>

