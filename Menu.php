<?php
if(!isset($_SESSION))
{
    session_start();
}
$tipoUsuario = $_SESSION['tipoUsuario'];

$cierreCaja = $_SESSION["idCierreCaja"];
$cierreSucursal = $_SESSION["idCierreSucursal"];
if($cierreCaja==0){
    session_destroy();
    echo'<script type="text/javascript">
    alert("Error al iniciar la sesión, por favor consulte con su administrador.");
    window.location.href="../../../index.php";
    </script>';
}elseif ($cierreSucursal==0){
    session_destroy();
    echo'<script type="text/javascript">
    alert("Error al iniciar la sesión, por favor consulte con su administrador.");
    window.location.href="../../../index.php";
    </script>';
    header("Location: ../../../index.php");
}


if($tipoUsuario==2){
    include_once (HTML_PATH."menuAdmin.php");
}elseif ($tipoUsuario==3){
    include_once (HTML_PATH."menuGeneral.php");
}elseif ($tipoUsuario==4){
    include_once (HTML_PATH."menuVendedor.php");
}
?>