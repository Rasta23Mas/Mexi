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
                    <center><h3><b>Inventario</b></h3></center>
                    <br>
         <table  width="100%"border="1">
                        <thead style="background: dodgerblue; color:white;">
                            <tr align="center">
                                <th>Fecha</th>
                                <th>Contrato</th>
                                <th>Serie</th>
                                <th>Precio Venta</th>
                                <th>Detalle</th>
                            </tr>
                        </thead>
                        <tbody id="idTBodyInventario"  align="center">';
$query = "SELECT DATE_FORMAT(ART.fecha_creacion,'%Y-%m-%d') as FECHA, ART.id_Contrato,
                        CONCAT (id_SerieSucursal,Adquisiciones_Tipo,id_SerieContrato,id_SerieArticulo) as id_serie,
                        prestamo  AS precio_venta, ART.descripcionCorta AS Detalle
                        FROM articulo_tbl AS ART 
                        LEFT JOIN contratos_tbl AS Con on ART.id_Contrato = Con.id_Contrato AND Con.sucursal = $sucursal
                        WHERE Con.fisico = 1 AND ART.id_Estatus != 20 AND  ART.sucursal = $sucursal
                        AND (Con.id_cat_estatus=1 OR Con.id_cat_estatus=2 ) ";
$resultado = $db->query($query);
$tablaArticulos = '';
foreach ($resultado as $row) {
    $FECHA = $row["FECHA"];
    $id_Contrato = $row["id_Contrato"];
    $id_serie = $row["id_serie"];
    $precio_venta = $row["precio_venta"];
    $Detalle = $row["Detalle"];

    $tablaArticulos .= '<tr><td >' . $FECHA . '</td>
                        <td>' . $id_Contrato . '</td>
                        <td>' . $id_serie . '</td>
                        <td>$' . $precio_venta . '</td>
                        <td>' . $Detalle . '</td>
                        </tr>';
}

$contenido .= $tablaArticulos;
$contenido .='
                        </tbody>
                        </table>';
$contenido .= '</form></body></html>';
echo $contenido;
exit;

$nombreContrato = 'Reporte_Inventario.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
