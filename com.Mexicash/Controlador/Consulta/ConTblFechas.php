<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlConsultaDAO.php");


$fechaInicio = $_POST['fechaInicio'];
$fechaFinal = $_POST['fechaFinal'];


$sqlTblVenta= new sqlConsultaDAO();
$sqlTblVenta->sqlBuscarVentaFechas($fechaInicio,$fechaFinal);

?>