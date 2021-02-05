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
                                <th>Serie</th>
                                <th>Detalle</th>
                                <th>Prestamo</th>
                                <th>Precio Venta</th>
                            </tr>
                        </thead>
                        <tbody id="idTBodyInventario"  align="center"> ';
$query = "SELECT DATE_FORMAT(fecha_Bazar,'%Y-%m-%d') as FECHA, id_Contrato,id_serie,
       prestamo,
       vitrinaVenta AS precio_venta, 
                        descripcionCorta as Detalle
                        FROM articulo_bazar_tbl as Baz
                        WHERE tipo_movimiento!= 6 AND Baz.sucursal=$sucursal";
$resultado = $db->query($query);

$tablaArticulos = '';

foreach ($resultado as $row) {
    $fecha_Bazar = $row["FECHA"];
    $id_Contrato = $row["id_Contrato"];
    $id_serie = $row["id_serie"];
    $Detalle = $row["Detalle"];
    $prestamo = $row["prestamo"];
    $precio_venta = $row["precio_venta"];
    $CatDesc = $row["CatDesc"];

    $precio_venta = number_format($precio_venta, 2,'.',',');


    $tablaArticulos .= '<tr><td >' . $fecha_Bazar . '</td>
                        <td>' . $id_Contrato . '</td>
                        <td>' . $id_serie . '</td>
                        <td>' . $Detalle . '</td>
                        <td>$' . $prestamo . '</td>
                        <td>$' . $precio_venta . '</td>
                        </tr>';
}

$contenido .= $tablaArticulos;
$contenido .='
                        </tbody>
                        </table>';
$contenido .= '</form></body></html>';
//echo $contenido;
//exit();
$nombreContrato = 'Reporte_Bazar.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
