<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
require_once(WEB_PATH . "dompdf/autoload.inc.php");
require_once (BASE_PATH . "Conectar.php");
use Dompdf\Dompdf;


if (!isset($_SESSION)) {
    session_start();
}
$usuario = $_SESSION["idUsuario"];
$sucursal = $_SESSION["sucursal"];
$fechaIni='';
$fechaFin='';
if (isset($_GET['fechaIni'])) {
    $fechaIni = $_GET['fechaIni'];
}
if (isset($_GET['fechaFin'])) {
    $fechaFin = $_GET['fechaFin'];
}


$fecha_Bazar = "";
$id_Contrato = "";
$id_serie ="";
$Movimiento = "";
$Detalle = "";
$precio_venta = "";
$CatDesc = "";


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
  padding: 6px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

    </style>
</head>
<body>
<form>';
$contenido .= '
                    <center><h3><b>Reporte Bazar</b></h3></center>
                    <br>
         <table  width="100%"border="1">
                        <thead style="background: dodgerblue; color:white;">
                            <tr align="center">
                                <th>Fecha Bazar</th>
                                <th>Contrato</th>
                                <th>Prestamo</th>
                                <th>Vitrina</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody id="idTBodyInventario"  align="center"> ';
$query = "SELECT DATE_FORMAT(fecha_creacion,'%Y-%m-%d') as Fecha_Bazar,
                        id_Contrato, descripcionCorta,  prestamo, vitrinaVenta						
                        FROM articulo_bazar_tbl 
                        WHERE DATE_FORMAT(fecha_creacion,'%Y-%m-%d') 
                        BETWEEN '$fechaIni' AND '$fechaFin' AND sucursal=$sucursal 
                        Order by id_Contrato";
$resultado = $db->query($query);

$tablaArticulos = '';

foreach ($resultado as $row) {
    $fecha_Bazar = $row["Fecha_Bazar"];
    $id_Contrato = $row["id_Contrato"];
    $descripcionCorta = $row["descripcionCorta"];
    $prestamo = $row["prestamo"];
    $vitrinaVenta = $row["vitrinaVenta"];

    $prestamo = number_format($prestamo, 2,'.',',');
    $vitrinaVenta = number_format($vitrinaVenta, 2,'.',',');


    $tablaArticulos .= '<tr><td >' . $fecha_Bazar . '</td>
                        <td>' . $id_Contrato . '</td>
                        <td>$' . $prestamo . '</td>
                        <td>$' . $vitrinaVenta . '</td>
                        <td>' . $descripcionCorta . '</td>
                        </tr>';
}

$contenido .= $tablaArticulos;
$contenido .='
                        </tbody>
                        </table>';
$contenido .= '</form></body></html>';
//echo $contenido;
//exit();
$nombreContrato = 'Reporte_Bazar_Fechas.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
