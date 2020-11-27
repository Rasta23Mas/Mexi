<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlTokenDAO.php");

$idTokenSubtotalGlb = $_POST['idTokenSubtotalGlb'];
$idTokenIvaGlb = $_POST['idTokenIvaGlb'];
$idTokenTotalGlb = $_POST['idTokenTotalGlb'];
$idTokenDescuentoGlb = $_POST['idTokenDescuentoGlb'];
$idToken = $_POST['idToken'];
$tokenDesc = $_POST['tokenDesc'];
$idTokenMov = $_POST['idTokenMov'];

$sqlToken = new sqlTokenDAO();

$sqlToken->sqlTokenVentas($idTokenSubtotalGlb,$idTokenIvaGlb,$idTokenTotalGlb,$idTokenDescuentoGlb,$idToken,$tokenDesc,$idTokenMov);


?>