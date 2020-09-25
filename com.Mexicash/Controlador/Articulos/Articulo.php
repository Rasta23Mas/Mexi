<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Articulo.php");
include_once(SQL_PATH . "sqlArticulosDAO.php");

$idTipoEnviar = $_POST['$idTipoEnviar'];
$idArticulo = $_POST['idArticulo'];
$imei = $_POST['IMEI'];

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
    $interes = $_POST['interes'];
    $idDetallePrenda = $_POST['idDetallePrenda'];
    $idObs = $_POST['idObs'];
    $descCorto = $_POST['descCorto'];
    $idTipoE = null;
    $idMarca = null;
    $idEstado = null;
    $idModelo = null;
    $idSerie = null;
    $idPrestamoE = null;
    $idAvaluoE = null;
    $tipoInteresE = null;
    $interesArt = null;
    $idObsE = null;
    $idDetallePrendaE = null;
    $descCortoElectro = null;

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
    $tipoInteres = null;
    $interesMetal = null;
    $idObs = null;
    $idDetallePrenda = null;
    $descCorto = null;
    $idTipoE = $_POST['idTipoElectronico'];
    $idMarca = $_POST['idMarca'];
    $idEstado = $_POST['idEstado'];
    $idModelo = $_POST['idModelo'];
    $idSerie = $_POST['idSerie'];
    $idPrestamoE = $_POST['idPrestamoElectronico'];
    $idAvaluoE = $_POST['idAvaluoElectronico'];
    $idVitrina = $_POST['idVitrina'];
    $idPrecioCat = $_POST['idPrecioCat'];
    $interes = $_POST['interes'];
    $idObsE = $_POST['idObsElectronico'];
    $idDetallePrendaE = $_POST['idDetallePrendaElectronico'];
    $descCortoElectro = $_POST['descCortoElectro'];

}

$articulo = new Articulo(
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
    $interes,
    $idObs,
    $idDetallePrenda,
    $descCorto,
    $idTipoE,
    $idMarca,
    $idEstado,
    $idModelo,
    $idSerie,
    $idPrestamoE,
    $idAvaluoE,
    $idObsE,
    $idDetallePrendaE,
    $descCortoElectro
);

$sqlArticulo = new sqlArticulosDAO();
$sqlArticulo->guardarArticulo($idTipoEnviar,$idArticulo,$imei, $articulo);

?>

