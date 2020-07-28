<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Auto.php");
include_once(SQL_PATH . "sqlAutoDAO.php");

//DatosContrato
$idClienteAuto = $_POST['idClienteAuto'];
$fechaVencimiento = $_POST['fechaVencimiento'];
$totalPrestamo = $_POST['totalPrestamo'];
$totalAvaluo = $_POST['totalAvaluo'];
$polizaSeguroCost = $_POST['polizaSeguro'];
$gps = $_POST['gps'];
$pension = $_POST['pension'];
$beneficiario = $_POST['beneficiario'];
$cotitular = $_POST['cotitular'];
$plazo = $_POST['plazo'];
$periodo = $_POST['periodo'];
$idTipoInteres = $_POST['idTipoInteres'];
$tasa = $_POST['tasa'];
$alm = $_POST['alm'];
$seguro = $_POST['seguro'];
$iva = $_POST['iva'];
$dias = $_POST['dias'];
$idTipoFormulario = $_POST['idTipoFormulario'];
$aforo = $_POST['aforo'];
//19
//Auto
$idTipoVehiculo = $_POST['idTipoVehiculo'];
$idMarca = $_POST['idMarca'];
$idModelo = $_POST['idModelo'];
$idAnio = $_POST['idAnio'];
$idColor = $_POST['idColor'];
$idPlacas = $_POST['idPlacas'];
$idFactura = $_POST['idFactura'];
$idKms = $_POST['idKms'];
$idAgencia = $_POST['idAgencia'];
$idMotor = $_POST['idMotor'];
$idSerie = $_POST['idSerie'];
$idVehiculo = $_POST['idVehiculo'];
$idRepuve = $_POST['idRepuve'];
$idGasolina = $_POST['idGasolina'];
$idAseguradora = $_POST['idAseguradora'];
$idTarjeta = $_POST['idTarjeta'];
$idPoliza = $_POST['idPoliza'];
$idFecVencimientoAuto = $_POST['idFechaVencAuto'];
$idTipoPoliza = $_POST['idTipoPoliza'];
$idObservacionesAuto = $_POST['idObservacionesAuto'];
$idCheckTarjeta = $_POST['idCheckTarjeta'];
$idCheckFactura = $_POST['idCheckFactura'];
$idCheckINE = $_POST['idCheckINE'];
$idCheckImportacion = $_POST['idCheckImportacion'];
$idCheckTenecia = $_POST['idCheckTenecia'];
$idCheckPoliza = $_POST['idCheckPoliza'];
$idCheckLicencia = $_POST['idCheckLicencia'];
$diasAlmoneda = $_POST['diasAlmoneda'];
$fecha_Alm = $_POST['fecha_Alm'];
//48

$auto = new Auto(
//Contrato
    $idClienteAuto,
    $fechaVencimiento,
    $totalPrestamo,
    $totalAvaluo,
    $polizaSeguroCost,
    $gps,
    $pension,
    $beneficiario,
    $cotitular,
    $plazo,
    $periodo,
    $idTipoInteres,
    $tasa,
    $alm,
    $seguro,
    $iva,
    $dias,
    $idTipoFormulario,
    $aforo,
    //Auto
    $idTipoVehiculo,
    $idMarca,
    $idModelo,
    $idAnio,
    $idColor,
    $idPlacas,
    $idFactura,
    $idKms,
    $idAgencia,
    $idMotor,
    $idSerie,
    $idVehiculo,
    $idRepuve,
    $idGasolina,
    $idAseguradora,
    $idTarjeta,
    $idPoliza,
    $idFecVencimientoAuto,
    $idTipoPoliza,
    $idObservacionesAuto,
    $idCheckTarjeta,
    $idCheckFactura,
    $idCheckINE,
    $idCheckImportacion,
    $idCheckTenecia,
    $idCheckPoliza,
    $idCheckLicencia,
    $diasAlmoneda,
    $fecha_Alm
);

$sqlAuto = new sqlAutoDAO();
$sqlAuto->generaContratoAuto($auto);




