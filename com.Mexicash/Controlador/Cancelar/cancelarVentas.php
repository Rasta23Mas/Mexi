<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCancelarDAO.php");

$id_Bazar = $_POST['id_Bazar'];
$Movimiento = $_POST['Movimiento'];
$tipo = $_POST['tipo'];
$sqlCancelar = new sqlCancelarDAO();

if($tipo==1){
    $sqlCancelar->sqlCancelarVenta($id_Bazar);

}


?>