<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlContratoDAO.php");


$fechaInicio = $_POST['fechaInicio'];
$fechaFinal = $_POST['fechaFinal'];
$tipoContratoGlobal = $_POST['tipoContratoGlobal'];


$sqlTblContrato= new sqlContratoDAO();
$sqlTblContrato->buscarContratoFechas($fechaInicio,$fechaFinal, $tipoContratoGlobal);

?>