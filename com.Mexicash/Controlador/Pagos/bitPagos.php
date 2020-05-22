<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlDesempenoDAO.php");

$id_ContratoPDF = $_POST['id_ContratoPDF'];
$id_ClientePDF = $_POST['id_ClientePDF'];
$prestamoPDF = $_POST['prestamoPDF'];
$abonoCapitalPDF = $_POST['abonoCapitalPDF'];
$interesesPDF = $_POST['interesesPDF'];
$almacenajePDF = $_POST['almacenajePDF'];
$seguroPDF = $_POST['seguroPDF'];
$desempeñoExtPDF = $_POST['desempeñoExtPDF'];
$moratoriosPDF = $_POST['moratoriosPDF'];
$otrosCobrosPDF = $_POST['otrosCobrosPDF'];
$descuentoAplicadoPDF = $_POST['descuentoAplicadoPDF'];
$descuentoPuntosPDF = $_POST['descuentoPuntosPDF'];
$ivaPDF = $_POST['ivaPDF'];
$efectivoPDF = $_POST['efectivoPDF'];
$cambioPDF = $_POST['cambioPDF'];

$mutuoPDF = $_POST['mutuoPDF'];
$refrendoPDF = $_POST['refrendoPDF'];
$newFechaVencimiento = $_POST['newFechaVencimiento'];
$newFechaAlm = $_POST['newFechaAlm'];
$tipeFormulario = $_POST['tipeFormulario'];
$costo_Contrato = $_POST['costo_Contrato'];
$ultimoMovimiento = $_POST['ultimoMovimiento'];

$sqlDesempeno = new sqlDesempenoDAO();

//Busqueda de bit pagos
$sqlDesempeno->guardarPagos($id_ContratoPDF, $id_ClientePDF, $prestamoPDF, $abonoCapitalPDF, $interesesPDF, $almacenajePDF, $seguroPDF,
                            $desempeñoExtPDF, $moratoriosPDF, $otrosCobrosPDF,$descuentoAplicadoPDF, $descuentoPuntosPDF, $ivaPDF, $efectivoPDF, $cambioPDF, $mutuoPDF,
                            $refrendoPDF, $newFechaVencimiento, $newFechaAlm, $tipeFormulario,$costo_Contrato,$ultimoMovimiento);


?>