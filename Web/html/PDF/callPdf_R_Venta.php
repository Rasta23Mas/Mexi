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
                                   <th>Fecha Venta</th>
                                    <th>Contrato</th>
                                    <th>Serie</th>
                                    <th width="400px">Detalle</th>
                                    <th>Venta</th>
                                    <th>Descuento</th>
                                    <th>Tipo Adquisición</th>
                            </tr>
                        </thead>
                        <tbody id="idTBodyInventario"  align="center"> ';
$query = "SELECT DATE_FORMAT(Ven.fecha_Creacion,'%Y-%m-%d') as FECHA, id_Contrato,id_serie,
                vitrinaVenta AS precio_venta, 
                        descripcionCorta as Detalle,descuento_Venta,CAT.descripcion as CatDesc
                        FROM bit_ventas as Ven
                        LEFT JOIN articulo_bazar_tbl AS ART on Ven.id_ArticuloBazar = ART.id_ArticuloBazar
                        LEFT JOIN contrato_mov_baz_tbl AS Con on Con.id_Bazar = Ven.id_Bazar
                        LEFT JOIN cat_adquisicion AS CAT on id_serieTipo = CAT.id_Adquisicion
                        WHERE DATE_FORMAT(Ven.fecha_Creacion,'%Y-%m-%d')  >=  '$fechaIni'
                        AND DATE_FORMAT(Ven.fecha_Creacion,'%Y-%m-%d')  <=  '$fechaFin' 
                        AND Ven.sucursal=$sucursal";
$resultado = $db->query($query);

$tablaArticulos = '';

foreach ($resultado as $row) {
    $FECHA = $row["FECHA"];
    $id_Contrato = $row["id_Contrato"];
    $id_serie = $row["id_serie"];
    $precio_venta = $row["precio_venta"];
    $Detalle = $row["Detalle"];
    $descuento_Venta = $row["descuento_Venta"];
    $CatDesc = $row["CatDesc"];

    $precio_venta = number_format($precio_venta, 2,'.',',');
    $descuento_Venta = number_format($descuento_Venta, 2,'.',',');


    $tablaArticulos .= '<tr><td >' . $FECHA . '</td>
                        <td>' . $id_Contrato . '</td>
                        <td>' . $id_serie . '</td>
                        <td>' . $Detalle . '</td>
                        <td>$' . $precio_venta . '</td>
                        <td>$' . $descuento_Venta . '</td>
                        <td>' . $CatDesc . '</td>
                        </tr>';
}

$contenido .= $tablaArticulos;
$contenido .='
                        </tbody>
                        </table>';
$contenido .= '</form></body></html>';

$nombreContrato = 'Reporte_Bazar.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
