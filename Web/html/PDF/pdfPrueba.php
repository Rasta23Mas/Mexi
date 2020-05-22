<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
require_once(WEB_PATH . "dompdf/autoload.inc.php");
use Dompdf\Dompdf;


$dompdf = new DOMPDF();
$dompdf->load_html( file_get_contents( 'contrato.php' ) );
$dompdf->render();
$dompdf->stream("mi_archivo.pdf");