<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlReportesDAO.php");


$contrato = $_POST['contrato'];
$tipoContrato = $_POST['tipoContrato'];
$Estatus = $_POST['Estatus'];

$sqlReportesDAO = new sqlReportesDAO();
if ($tipoContrato == 1) {
    $sqlReportesDAO->sqlMigrarBazar($contrato,$Estatus);
}else if ($tipoContrato == 2) {
    $sqlReportesDAO->sqlMigrarBazarAuto($contrato,$Estatus);
}

?>