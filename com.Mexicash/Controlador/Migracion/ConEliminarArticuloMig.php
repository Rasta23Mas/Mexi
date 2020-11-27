<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlMigracionDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');


$id_ArticuloBazar = $_POST['idArticuloBazar'];

$sqlArticuloMig = new sqlMigracionDAO();
$sqlArticuloMig->sqlEliminarArticuloMig($id_ArticuloBazar);