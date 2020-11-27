<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlUsuarioDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$id_Movimiento = $_POST['id_Movimiento'];
$id_contrato = $_POST['id_contrato'];
$id_almoneda = $_POST['id_almoneda'];
$id_cliente = $_POST['id_cliente'];
$consulta_fechaInicio = $_POST['consulta_fechaInicio'];
$consulta_fechaFinal = $_POST['consulta_fechaFinal'];
$idArqueo = $_POST['idArqueo'];

$usu = new sqlUsuarioDAO();
$usu->bitacoraUsuario($id_Movimiento,$id_contrato,$id_almoneda,$id_cliente,$consulta_fechaInicio,$consulta_fechaFinal,$idArqueo);


