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
$id_ContratoMig = "";

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
                    <center><h3><b>Contratos Vencidos</b></h3></center>
                    <br>
         <table  width="100%"border="1">
                        <thead style="background: dodgerblue; color:white;">
                            <tr align="center">
                                <th>Fecha Bazar</th>
                                <th>Contrato</th>
                                <th>Serie</th>
                                <th>Movimiento</th>
                                <th>Detalle</th>
                                <th>Precio Venta</th>
                                <th>Tipo Adquisición</th>
                                <th>Contrato Migración</th>
                            </tr>
                        </thead>
                        <tbody id="idTBodyInventario"  align="center"> ';
$query = " SELECT Baz.id_Contrato,id_serie,Mov.descripcion as Movimiento,fecha_Bazar,precio_venta, 
                        ART.detalle as Detalle, CAT.descripcion as CatDesc, ART.id_ContratoMig
                        FROM articulo_bazar_tbl as Baz
                        LEFT JOIN articulo_tbl AS ART on Baz.id_Articulo = ART.id_Articulo 
                        LEFT JOIN cat_adquisicion AS CAT on ART.Adquisiciones_Tipo = CAT.id_Adquisicion
                        LEFT JOIN cat_movimientos AS Mov on Baz.tipo_movimiento = Mov.id_Movimiento
                        WHERE tipo_movimiento!= 6 and Baz.sucursal=$sucursal";
$resultado = $db->query($query);

$tablaArticulos = '';

foreach ($resultado as $row) {
    $fecha_Bazar = $row["fecha_Bazar"];
    $id_Contrato = $row["id_Contrato"];
    $id_serie = $row["id_serie"];
    $Movimiento = $row["Movimiento"];
    $Detalle = $row["Detalle"];
    $precio_venta = $row["precio_venta"];
    $CatDesc = $row["CatDesc"];
    $id_ContratoMig = $row["id_ContratoMig"];

    $precio_venta = number_format($precio_venta, 2,'.',',');


    $tablaArticulos .= '<tr><td >' . $fecha_Bazar . '</td>
                        <td>' . $id_Contrato . '</td>
                        <td>' . $id_serie . '</td>
                        <td>' . $Movimiento . '</td>
                        <td>' . $Detalle . '</td>
                        <td>$' . $precio_venta . '</td>
                        <td>' . $CatDesc . '</td>
                        <td>' . $id_ContratoMig . '</td>
                        </tr>';
}

$contenido .= $tablaArticulos;
$contenido .='
                        </tbody>
                        </table>';
$contenido .= '</form></body></html>';
//echo $contenido;
//exit();
$nombreContrato = 'Reporte Bazar.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
