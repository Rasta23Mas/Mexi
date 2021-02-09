<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
require_once(WEB_PATH . "dompdf/autoload.inc.php");
require_once (BASE_PATH . "Conectar.php");

use Dompdf\Dompdf;


if (!isset($_SESSION)) {
    session_start();
}
$fechaIni='';
$fechaFin='';
$sucursal='';
$nombre='';
if (isset($_GET['fechaIni'])) {
    $fechaIni = $_GET['fechaIni'];
}
if (isset($_GET['fechaFin'])) {
    $fechaFin = $_GET['fechaFin'];
}
if (isset($_GET['sucursal'])) {
    $sucursal = $_GET['sucursal'];
}
if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
}


$contenido = '<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

            table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
   font-size: .5em;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

    </style>
</head>
<body>
<form>';
$contenido .= '
                    <center><h3><b>'.  $nombre .'</b></h3></center>
                    <br>
         <table  width="100%"border="1">
                        <thead style="background: dodgerblue; color:white;">
                            <tr align="center">
                                <th>FECHA</th>
                                <th>FOLIO</th>
                                <th>CONTRATO</th>
                                <th>REFRENDO</th>
                                <th>DESEMPEÑO</th>
                            </tr>
                        </thead>
                        <tbody id="idTBodyIngresos"  align="center">';
$rptIng = "SELECT  DATE_FORMAT(fecha_Movimiento,'%Y-%m-%d')  AS Movimiento,id_movimiento, id_contrato, tipo_movimiento,
                                    e_intereses,e_iva,e_pagoDesempeno,e_costoContrato, e_moratorios
                                    FROM contrato_mov_tbl WHERE sucursal=$sucursal AND (tipo_movimiento=4 || tipo_movimiento=5) AND
                                    DATE_FORMAT(fecha_Movimiento,'%Y-%m-%d')                                
                                    BETWEEN '$fechaIni' AND '$fechaFin'   ORDER BY fecha_Movimiento  ";
$resultado = $db->query($rptIng);
$tipoMetal = 0;
$tipoElectro = 0;
$tipoAuto = 0;
$tablaArticulos = '';

foreach ($resultado as $row) {
    $Desem = $row["Desem"];
    $AbonoRef = $row["AbonoRef"];
    $Inte = $row["Inte"];
    $costoContrato = $row["costoContrato"];
    $Iva = $row["Iva"];
    $Ventas = $row["Ventas"];
    $IvaVenta = $row["IvaVenta"];
    $Utilidad = $row["Utilidad"];
    $Apartados = $row["Apartados"];
    $AbonoVen = $row["AbonoVen"];

    $Desem = number_format($Desem, 2,'.',',');
    $AbonoRef = number_format($AbonoRef, 2,'.',',');
    $Inte = number_format($Inte, 2,'.',',');
    $costoContrato = number_format($costoContrato, 2,'.',',');
    $Iva = number_format($Iva, 2,'.',',');
    $Ventas = number_format($Ventas, 2,'.',',');
    $IvaVenta = number_format($IvaVenta, 2,'.',',');
    $Utilidad = number_format($Utilidad, 2,'.',',');
    $Apartados = number_format($Apartados, 2,'.',',');
    $AbonoVen = number_format($AbonoVen, 2,'.',',');

    $tablaArticulos .= '<tr><td >' . $row["id_CierreSucursal"] . '</td>
                        <td>' . $Desem . '</td>
                        <td>' . $AbonoRef . '</td>
                        <td>' . $Inte . '</td>
                        <td>' . $costoContrato . '</td>
                        <td>$' . $Iva . '</td>
                        <td>$' . $Ventas . '</td>
                        <td>$' . $IvaVenta . '</td>
                        <td>' . $Utilidad. '</td>
                        <td>' . $Apartados . '</td>
                        <td>' . $AbonoVen . '</td>
                        <td>' . $row["Fecha"] . '</td>
                        </tr>';
}






$contenido .= $tablaArticulos;
$contenido .='
                        </tbody>
                        </table>';
$contenido .= '</form></body></html>';

$nombreContrato = 'Reporte_Ingresos.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
