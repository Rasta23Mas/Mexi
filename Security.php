<?php
session_start();
date_default_timezone_set('America/Mexico_City');
if ($_SESSION["autentificado"] != "SI") {
    //si no está logueado lo envío a la página de autentificación
    header("Location: index.php");
} else {
    $fechaGuardada = $_SESSION["ultimoAcceso"];
    echo $fechaGuardada;
    $ahora = date("Y-n-j H:i:s");
    $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
    $tiempo_limite = 600;
    if($tiempo_transcurrido >= $tiempo_limite) {
        session_destroy();
        header("Location: ../../../index.php");
    }else {
        $_SESSION["ultimoAcceso"] = $ahora;
    }
}
?>