<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlContratoDAO.php");

$sqlContrato = new sqlContratoDAO();
$sqlContrato->articulosObsoletos();