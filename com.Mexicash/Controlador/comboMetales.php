<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");

$Clase = $_POST['clase'];
$idTipoMetal = $_POST['idTipoMetal'];
$comboMetal = new sqlArticulosDAO();
if($Clase == 1){
    $comboMetal->llenarCmbPrenda($idTipoMetal) ;
}else if($Clase == 2){
    $comboMetal->llenarCmbKilataje($idTipoMetal) ;
}else if($Clase == 3){
    $comboMetal->llenarCmbCalidad($idTipoMetal) ;
}else if($Clase == 4){
    $comboMetal->llenarKilatajePrecio($idTipoMetal) ;
}




?>

