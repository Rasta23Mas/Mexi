<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlMigracionDAO.php");

$idContratoMig = $_POST['idContratoMig'];
$idFolioMig = $_POST['idFolioMig'];
$idPrestamoMig = $_POST['idPrestamoMig'];
$idAvaluoMig = $_POST['idAvaluoMig'];
$idVitrinaMig = $_POST['idVitrinaMig'];
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
$idChasis = $_POST['idChasis'];
$idVehiculo = $_POST['idVehiculo'];
$idRepuve = $_POST['idRepuve'];
$idGasolina = $_POST['idGasolina'];
$idTarjeta = $_POST['idTarjeta'];
$idAseguradora = $_POST['idAseguradora'];
$idPoliza = $_POST['idPoliza'];
$idFechaVencAuto = $_POST['idFechaVencAuto'];
$idTipoPoliza = $_POST['idTipoPoliza'];
$totalAvaluoLetra = $_POST['totalAvaluoLetra'];
$observacionesAuto = $_POST['observacionesAuto'];
$idCheckTarjeta = $_POST['idCheckTarjeta'];
$idCheckFactura = $_POST['idCheckFactura'];
$idCheckINE = $_POST['idCheckINE'];
$idCheckImportacion = $_POST['idCheckImportacion'];
$idCheckTenecia = $_POST['idCheckTenecia'];
$idCheckPoliza = $_POST['idCheckPoliza'];
$idCheckLicencia = $_POST['idCheckLicencia'];


$sqlMig = new sqlMigracionDAO();
$sqlMig->sqlAutoMig(
    $idContratoMig,
$idFolioMig,
$idPrestamoMig,
$idAvaluoMig,
$idVitrinaMig,
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
$idChasis,
$idVehiculo,
$idRepuve,
$idGasolina,
$idTarjeta,
$idAseguradora,
$idPoliza,
$idFechaVencAuto,
$idTipoPoliza,
$totalAvaluoLetra,
$observacionesAuto,
$idCheckTarjeta,
$idCheckFactura,
$idCheckINE,
$idCheckImportacion,
$idCheckTenecia,
$idCheckPoliza,
$idCheckLicencia
);