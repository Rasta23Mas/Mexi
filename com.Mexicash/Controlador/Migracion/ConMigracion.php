<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlMigracionDAO.php");

$tipo = $_POST['tipo'];

$sqlMigracion = new sqlMigracionDAO();
if($tipo==1){
    $sqlMigracion->sqlBuscarIdContrato();
}
