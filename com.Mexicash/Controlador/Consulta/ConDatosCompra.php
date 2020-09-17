<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlConsultaDAO.php");


$idVentaBusqueda = $_POST['idVentaBusqueda'];


$sqlTblVenta= new sqlConsultaDAO();
$sqlTblVenta->sqlBuscarDetalleCompra($idVentaBusqueda);

?>