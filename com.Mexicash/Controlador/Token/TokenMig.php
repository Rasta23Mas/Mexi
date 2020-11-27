<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlTokenDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$idToken = $_POST['idToken'];
$tokenDesc = $_POST['tokenDesc'];


$sqlToken = new sqlTokenDAO();

$sqlToken->sqlTokenMig($idToken,$tokenDesc);


?>