<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlDesempenoDAO.php");

$tipeFormulario = $_POST['tipeFormulario'];
$saldoPendiente = $_POST['saldoPendiente'];
$descuentoFinal = $_POST['descuentoFinal'];
$contrato = $_POST['contrato'];
$idEstatusArt = $_POST['idEstatusArt'];
$estatusAnterior = $_POST['estatusAnterior'];


/*$sqlDesempeno = new sqlDesempenoDAO();
$sqlDesempeno->generarDesSinInteres($tipeFormulario, $contrato, $idEstatusArt,$estatusAnterior);
*/


?>