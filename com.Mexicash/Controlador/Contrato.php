<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Contrato.php");
include_once(SQL_PATH . "sqlContratoDAO.php");

$idCliente = $_POST['idCliente'];
$totalPrestamo = $_POST['totalPrestamo'];
$Total_Intereses = $_POST['Total_Intereses'];
$Suma_InteresPrestamo = $_POST['Suma_InteresPrestamo'];
$diasAlmonedaValue = $_POST['diasAlmonedaValue'];
$cotitular = $_POST['cotitular'];
$beneficiario = $_POST['beneficiario'];
$plazo = $_POST['plazo'];
$tasa = $_POST['tasa'];
$alm = $_POST['alm'];
$seguro = $_POST['seguro'];
$iva = $_POST['iva'];
$dias = $_POST['dias'];
$idTipoFormulario = $_POST['idTipoFormulario'];
$aforo = $_POST['aforo'];

$contrato = new Contrato(
    $idCliente,
    $totalPrestamo,
    $Total_Intereses,
    $Suma_InteresPrestamo,
    $diasAlmonedaValue,
    $cotitular,
    $beneficiario,
    $plazo,
    $tasa,
    $alm,
    $seguro,
    $iva,
    $dias,
    $idTipoFormulario,
    $aforo,
);

$sqlContrato = new sqlContratoDAO();
$sqlContrato->guardarContrato($contrato);

?>

