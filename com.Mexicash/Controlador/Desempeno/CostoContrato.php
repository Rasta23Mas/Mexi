<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlDesempenoDAO.php");

$contrato = $_POST['contrato'];

$sqlDesempeno = new sqlDesempenoDAO();

$sqlDesempeno->costoContrato($contrato);


?>