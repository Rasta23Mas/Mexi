<?php
if(!isset($_SESSION))
{
    session_start();
}
$tipoUsuario = $_SESSION['tipoUsuario'];

if($tipoUsuario==2){
    include_once (HTML_PATH."menuAdmin.php");
}elseif ($tipoUsuario==3){
    include_once (HTML_PATH."menuGeneral.php");
}elseif ($tipoUsuario==4){
    include_once (HTML_PATH."menuVendedor.php");
}
?>