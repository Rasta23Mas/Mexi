<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Contratos.php");
include_once(SQL_PATH . "sqlContratoDAO.php");
$idCliente = $_POST['idCliente'];
$totalPrestamo = $_POST['totalPrestamo'];
$totalAvaluo = $_POST['totalAvaluo'];
$diasAlmonedaValue = $_POST['diasAlmonedaValue'];
$cotitular = $_POST['cotitular'];
$beneficiario = $_POST['beneficiario'];
$plazo = $_POST['plazo'];
$periodo = $_POST['periodo'];
$tipoInteres = $_POST['tipoInteres'];
$tasa = $_POST['tasa'];
$alm = $_POST['alm'];
$seguro = $_POST['seguro'];
$iva = $_POST['iva'];
$dias = $_POST['dias'];
$idTipoFormulario = $_POST['idTipoFormulario'];
$aforo = $_POST['aforo'];
$fecha_vencimiento = $_POST['fecha_vencimiento'];
$fecha_almoneda = $_POST['fecha_almoneda'];
$suma_InteresPrestamo = $_POST['Suma_InteresPrestamo'];
$total_Intereses = $_POST['Total_Intereses'];
$totalAvaluoLetra = $_POST['totalAvaluoLetra'];

$contrato = new Contratos(
    $idCliente,
    $totalPrestamo,
    $totalAvaluo,
    $diasAlmonedaValue,
    $cotitular,
    $beneficiario,
    $plazo,
    $periodo,
    $tipoInteres,
    $tasa,
    $alm,
    $seguro,
    $iva,
    $dias,
    $idTipoFormulario,
    $aforo,
    $fecha_vencimiento,
    $fecha_almoneda,
    $suma_InteresPrestamo,
    $total_Intereses,
    $totalAvaluoLetra
);

$sqlContrato = new sqlContratoDAO();
$sqlContrato->guardarContrato($contrato);

?>

