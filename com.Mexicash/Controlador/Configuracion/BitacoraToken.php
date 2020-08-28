<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlConfiguracionDAO.php");


$idGuardarGlb = $_POST['idGuardarGlb'];
$idHorarioIniGlb = $_POST['idHorarioIniGlb'];
$idHorarioFinGlb = $_POST['idHorarioFinGlb'];
$idEstatusGlb = $_POST['idEstatusGlb'];
$idToken = $_POST['idToken'];
$tokenDes = $_POST['tokenDes'];

$sqlConfiguracionDAO = new sqlConfiguracionDAO();
$sqlConfiguracionDAO->bitacoraToken(
    $idGuardarGlb,
    $idHorarioIniGlb,
    $idHorarioFinGlb,
    $idEstatusGlb,
    $idToken,
    $tokenDes
);

?>