<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlTokenDAO.php");

$idTokenSubtotalGlb = $_POST['idTokenSubtotalGlb'];
$idTokenIvaGlb = $_POST['idTokenIvaGlb'];
$idTokenTotalGlb = $_POST['idTokenTotalGlb'];
$idToken = $_POST['idToken'];
$tokenDesc = $_POST['tokenDesc'];
$idTokenMov = $_POST['idTokenMov'];
$idContratoCompra = $_POST['idContratoCompra'];


$sqlToken = new sqlTokenDAO();

$sqlToken->sqlTokenCompras($idTokenSubtotalGlb,$idTokenIvaGlb,$idTokenTotalGlb,$idToken,$tokenDesc,$idTokenMov,$idContratoCompra);


?>