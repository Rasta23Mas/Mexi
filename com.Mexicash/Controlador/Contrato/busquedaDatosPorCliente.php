<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlContratoDAO.php");


$idContratoBusqueda = $_POST['idContratoBusqueda'];

$sqlTblContrato= new sqlContratoDAO();
$sqlTblContrato->buscarDetalleContrato($idContratoBusqueda);

?>