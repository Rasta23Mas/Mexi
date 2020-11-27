<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlContratoDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');


$idClienteConsulta = $_POST['idClienteConsulta'];
$tipoContratoGlobal = $_POST['tipoContratoGlobal'];


$sqlTblContrato= new sqlContratoDAO();
$sqlTblContrato->buscarContratoDetalleNombre($idClienteConsulta,$tipoContratoGlobal);

?>