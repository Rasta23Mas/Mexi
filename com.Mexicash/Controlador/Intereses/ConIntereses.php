<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Interes.php");
include_once(SQL_PATH . "sqlInteresesDAO.php");

$resultado = $_POST['tipoInteresValue'];

$interes = new sqlInteresesDAO();
$interes->llenarFormIntereses($resultado) ;


?>

