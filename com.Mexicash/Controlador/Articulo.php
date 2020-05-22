<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Articulo.php");
include_once(SQL_PATH . "sqlArticulosDAO.php");

$idTipoEnviar = $_POST['$idTipoEnviar'];

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
    $idUbicacion = $_POST['idUbicacion'];
    $idDetallePrenda = $_POST['idDetallePrenda'];

    $idTipoE = null;
    $idMarca = null;
    $idEstado = null;
    $idModelo = null;
    $idSerie = null;
    $idPrestamoE = null;
    $idAvaluoE = null;
    $tipoInteresE = null;
    $interesArt = null;
    $idUbicacionE = null;
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
    $tipoInteres = null;
    $interesMetal = null;
    $idUbicacion = null;
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
    $interes = $_POST['interes'];
    $idUbicacionE = $_POST['idUbicacionElectronico'];
    $idDetallePrendaE = $_POST['idDetallePrendaElectronico'];
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
    $idUbicacion,
    $idDetallePrenda,
    $idTipoE,
    $idMarca,
    $idEstado,
    $idModelo,
    $idSerie,
    $idPrestamoE,
    $idAvaluoE,
    $idUbicacionE,
    $idDetallePrendaE
);

$sqlArticulo = new sqlArticulosDAO();
$sqlArticulo->guardarArticulo($idTipoEnviar, $articulo);

?>

