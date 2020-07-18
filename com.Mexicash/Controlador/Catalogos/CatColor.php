<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");

$sqlCatalogo = new sqlCatalogoDAO();

$color = $_POST['color'];
    $sqlCatalogo->agregarColor($color);





?>

