<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlTokenDAO.php");

$tokenDes = $_POST['tokenDes'];
$idFolio = $_POST['idFolio'];
$importe = $_POST['importe'];
$cat_token_movimiento = $_POST['cat_token_movimiento'];


$sqlToken = new sqlTokenDAO();
$sqlToken->tokenDotaciones($tokenDes,$idFolio,$importe,$cat_token_movimiento);


?>