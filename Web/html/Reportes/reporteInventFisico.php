<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once (SERVICIOS_PATH."pdf/vendor/autoload.php");

include_once (SERVICIOS_PATH."pdf/plantillas/plantillaReporte.php");

$empe = filter_input(INPUT_POST, 'Empe', FILTER_VALIDATE_BOOLEAN);
if (!isset($_POST['Empe'])){ $empe = 0; }else{ $empe = $_POST["Empe"]; }

$desemp = filter_input(INPUT_POST, 'Desemp', FILTER_VALIDATE_BOOLEAN);
if (!isset($_POST['Desemp'])){ $desemp = 0; }else{ $desemp = $_POST["Desemp"]; }

$refrendo = filter_input(INPUT_POST, 'Refrendo', FILTER_VALIDATE_BOOLEAN);
if (!isset($_POST['Refrendo'])){ $refrendo = 0; }else{ $refrendo = $_POST["Refrendo"]; }

$almoneda = filter_input(INPUT_POST, 'Almoneda', FILTER_VALIDATE_BOOLEAN);
if (!isset($_POST['Almoneda'])){ $almoneda = 0; }else{ $almoneda = $_POST["Almoneda"]; }

$auto = filter_input(INPUT_POST, 'Auto', FILTER_VALIDATE_BOOLEAN);
if (!isset($_POST['Auto'])){ $auto = 0; }else{ $auto = $_POST["Auto"]; }

$pdf = filter_input(INPUT_POST, 'PDF', FILTER_VALIDATE_BOOLEAN);
if (!isset($_POST['PDF'])){ $pdf = 0; }else{ $pdf = $_POST["PDF"]; }

$excel = filter_input(INPUT_POST, 'Excel', FILTER_VALIDATE_BOOLEAN);
if (!isset($_POST['Excel'])){ $excel = 0; }else{ $excel = $_POST["Excel"]; }

$fechaInicial = $_POST['inFechaIn'];
$fechaFinal = $_POST['inFechaFi'];


echo $empe . " " . $desemp . " " . $refrendo . " " . $almoneda . " " . $auto . " " . $pdf . " " . $excel;

if($pdf == 1 && $excel == 1){
    ?>
    <script>alert('Escoge solo un formato para el reporte'); window.close();</script>
    <?php
}else{
    if($pdf == 1){
        getPDF($empe, $desemp, $refrendo, $almoneda, $auto, $fechaInicial, $fechaFinal);
    }else{
        if($excel == 1){
            getInventarioFisicoExcel($empe, $desemp, $refrendo, $almoneda, $auto, $fechaInicial, $fechaFinal);
        }else{
            echo "Recuerda seleccionar un formato en el que deseas el reporte";
        }
    }
}

function getPDF($empe, $desemp, $refrendo, $almoneda, $auto, $fechaInicial, $fechaFinal){
    $css = file_get_contents(STYLE_PATH."css/pdfCSS/reportesPDF.css");

    $mpdf = new \Mpdf\Mpdf([

    ]);

    $plantilla = getInventarioFisicoPDF($empe, $desemp, $refrendo, $almoneda, $auto, $fechaInicial, $fechaFinal);

    $mpdf->writeHtml($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->writeHtml($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);

    $mpdf->Output();
}

