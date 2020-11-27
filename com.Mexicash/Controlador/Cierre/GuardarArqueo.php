<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');


$idMilCantGlobal = $_POST['idMilCantGlobal'];
$idQuinientosCantGlobal = $_POST['idQuinientosCantGlobal'];
$idDoscientosCantGlobal = $_POST['idDoscientosCantGlobal'];
$idCienCantGlobal = $_POST['idCienCantGlobal'];
$idCincuentaCantGlobal = $_POST['idCincuentaCantGlobal'];
$idVeinteCantGlobal = $_POST['idVeinteCantGlobal'];
$idVeinteMonCantGlobal = $_POST['idVeinteMonCantGlobal'];
$idDiezCantGlobal = $_POST['idDiezCantGlobal'];
$idCincoCantGlobal = $_POST['idCincoCantGlobal'];
$idDosCantGlobal = $_POST['idDosCantGlobal'];
$idUnoCantGlobal = $_POST['idUnoCantGlobal'];
$idCincuentaCCantGlobal = $_POST['idCincuentaCCantGlobal'];
$idCentavosCantGlobal = $_POST['idCentavosCantGlobal'];
$idMilGlobal = $_POST['idMilGlobal'];
$idQuinientosGlobal = $_POST['idQuinientosGlobal'];
$idDoscientosGlobal = $_POST['idDoscientosGlobal'];
$idCienGlobal = $_POST['idCienGlobal'];
$idCincuentaGlobal = $_POST['idCincuentaGlobal'];
$idVeinteGlobal = $_POST['idVeinteGlobal'];
$idVeinteMonGlobal = $_POST['idVeinteMonGlobal'];
$idDiezGlobal = $_POST['idDiezGlobal'];
$idCincoGlobal = $_POST['idCincoGlobal'];
$idDosGlobal = $_POST['idDosGlobal'];
$idUnoGlobal = $_POST['idUnoGlobal'];
$idCincuentaCGlobal = $_POST['idCincuentaCGlobal'];
$idCentavosGlobal = $_POST['idCentavosGlobal'];

$totalArqueoMonedas = $_POST['totalArqueoMonedas'];
$totalArqueoBilletes = $_POST['totalArqueoBilletes'];
$totalArqueoGlobal = $_POST['totalArqueoGlobal'];
$guardadoPorGerenteGlb = $_POST['guardadoPorGerenteGlb'];
$idCierreCaja = $_POST['idCierreCaja'];
$idUsuarioCaja = $_POST['idUsuarioCaja'];

$ajustesGbl = $_POST['ajustesGbl'];
$incrementoPatGbl = $_POST['incrementoPatGbl'];


$sqlTblCierre = new sqlCierreDAO();
$sqlTblCierre->guardarArqueo(
    $idMilCantGlobal,
$idQuinientosCantGlobal,
$idDoscientosCantGlobal,
$idCienCantGlobal,
$idCincuentaCantGlobal,
$idVeinteCantGlobal,
$idVeinteMonCantGlobal,
$idDiezCantGlobal,
$idCincoCantGlobal,
$idDosCantGlobal,
$idUnoCantGlobal,
$idCincuentaCCantGlobal,
$idCentavosCantGlobal,
$idMilGlobal,
$idQuinientosGlobal,
$idDoscientosGlobal,
$idCienGlobal,
$idCincuentaGlobal,
$idVeinteGlobal,
$idVeinteMonGlobal,
$idDiezGlobal,
$idCincoGlobal,
$idDosGlobal,
$idUnoGlobal,
$idCincuentaCGlobal,
$idCentavosGlobal,
$totalArqueoMonedas,
$totalArqueoBilletes,
$totalArqueoGlobal,
$guardadoPorGerenteGlb,
$idCierreCaja,
$idUsuarioCaja,
    $ajustesGbl,
    $incrementoPatGbl
);

?>