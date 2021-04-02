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
        <th>Prestamo</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Año</th>
        <th>Color</th>
        <th>Placas</th>
        <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody id="idTBodyInventario"  align="center">';
$query = "SELECT DATE_FORMAT(Aut.fecha_creacion,'%Y-%m-%d') as FECHA, Aut.id_Contrato,
                        total_Prestamo, Aut.marca, Aut.modelo,Aut.anio,Aut.color,
                        Aut.placas, Aut.observaciones
                        FROM auto_tbl AS Aut 
                            LEFT JOIN contratos_tbl AS Con on Aut.id_Contrato = Con.id_Contrato 
                            AND  Aut.sucursal  = Con.sucursal
                            WHERE Con.fisico = 1 AND Aut.id_Estatus != 20 
                            AND  Aut.sucursal = $sucursal AND (Con.id_cat_estatus=1 OR Con.id_cat_estatus=2 )";
$resultado = $db->query($query);
$tablaArticulos = '';
foreach ($resultado as $row) {
    $FECHA = $row["FECHA"];
    $id_Contrato = $row["id_Contrato"];
    $total_Prestamo = $row["total_Prestamo"];
    $marca = $row["marca"];
    $modelo = $row["modelo"];
    $anio = $row["anio"];
    $color = $row["color"];
    $placas = $row["placas"];
    $observaciones = $row["observaciones"];


    $tablaArticulos .= '<tr><td >' . $FECHA . '</td>
                        <td>' . $id_Contrato . '</td>
                        <td>$' . $total_Prestamo . '</td>
                        <td>' . $marca . '</td>
                        <td>' . $modelo . '</td>
                        <td>' . $anio . '</td>
                        <td>' . $color . '</td>
                        <td>' . $placas . '</td>
                        <td>' . $observaciones . '</td>
                        </tr>';
}

$contenido .= $tablaArticulos;
$contenido .='
                        </tbody>
                        </table>';
$contenido .= '</form></body></html>';
echo $contenido;
exit;

$nombreContrato = 'Reporte_Inventario_Auto.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
