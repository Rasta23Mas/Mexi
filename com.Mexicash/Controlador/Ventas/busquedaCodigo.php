<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");


$idCodigo = $_POST['idCodigo'];
$tipoBusqueda = $_POST['tipoBusqueda'];
$id_ArticuloBazar = $_POST['id_ArticuloBazar'];
$sqlVenta = new sqlVentasDAO();
$sqlVenta->sqlBusquedaCodigo($idCodigo,$tipoBusqueda,$id_ArticuloBazar);


