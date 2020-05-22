<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
require_once(WEB_PATH . "dompdf/autoload.inc.php");
use Dompdf\Dompdf;

$html=file_get_contents_curl('contrato.php');

$dompdf = new Dompdf();
    $dompdf->setPaper('A4','portrait');
$dompdf->loadHtml(utf8_decode($html));

$dompdf->render();

            $pdf =$dompdf->output();
            $dompdf->stream();
