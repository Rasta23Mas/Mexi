<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosComprasDAO.php");


$id_ArticuloBazar = $_POST['idArticuloBazar'];

$sqlArticuloCom = new sqlArticulosComprasDAO();
$sqlArticuloCom->sqlEliminarArticulo($id_ArticuloBazar);