<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlVentasDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');


$tipo_movimiento = $_POST['tipo_movimiento'];
$efectivo = $_POST['efectivo'];
$cambio = $_POST['cambio'];
$id_Cliente = $_POST['id_Cliente'];
$idBazar = $_POST['idBazar'];
$faltaPagar = $_POST['faltaPagar'];
$abono = $_POST['abono'];
$abono_Total = $_POST['abono_Total'];


$sqlVenta = new sqlVentasDAO();
$sqlVenta->sqlGuardarAbono($tipo_movimiento,$efectivo,$cambio,$id_Cliente,$idBazar,$faltaPagar,$abono,$abono_Total);