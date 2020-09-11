<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlConsultaDAO.php");


$idClienteConsulta = $_POST['idClienteConsulta'];


$sqlConsulta= new sqlConsultaDAO();
$sqlConsulta->sqlBuscarVentaNombre($idClienteConsulta);

?>