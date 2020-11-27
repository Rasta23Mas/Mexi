<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlContratoDAO.php");


$idContratoBusqueda = $_POST['idContratoBusqueda'];
$tipoContratoGlobal = $_POST['tipoContratoGlobal'];


$sqlTblContrato= new sqlContratoDAO();
$sqlTblContrato->buscarDetalleContrato($idContratoBusqueda,$tipoContratoGlobal);

?>