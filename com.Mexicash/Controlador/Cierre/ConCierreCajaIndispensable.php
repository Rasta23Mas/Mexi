<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");


$estatus = $_POST['estatus'];
$user = $_POST['user'];
$tipo = $_POST['tipo'];

$sqlTblCierre = new sqlCierreDAO();

if($tipo==0){
    $sqlTblCierre->sqlCierreCajaIndispensable($estatus);

}else{
    $sqlTblCierre->sqlCierreCajaIndispensableUser($estatus,$user);
}



?>