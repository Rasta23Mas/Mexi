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
$rptUtil = "SELECT  DATE_FORMAT(fecha_Movimiento,'%Y-%m-%d')  AS Movimiento,id_movimiento, id_contrato, tipo_movimiento,
                                    e_intereses,e_iva,e_pagoDesempeno,e_costoContrato,prestamo_Informativo
                                    FROM contrato_mov_tbl WHERE sucursal=$sucursal AND (tipo_movimiento=4 || tipo_movimiento=5) AND
                                    DATE_FORMAT(fecha_Movimiento,'%Y-%m-%d')                                
                                    BETWEEN '$fechaIni' AND '$fechaFin'   ORDER BY fecha_Movimiento  ";
echo $rptUtil;
$resultado = $db->query($rptUtil);
$tablaArticulos = '';

foreach ($resultado as $row) {
    $Movimiento= $row["Movimiento"];
    $id_movimiento = $row["id_movimiento"];
    $id_contrato = $row["id_contrato"];
    $tipo_movimiento = $row["tipo_movimiento"];
    $e_intereses = $row["e_intereses"];
    $e_iva = $row["e_iva"];
    $e_pagoDesempeno = $row["e_pagoDesempeno"];
    $e_costoContrato = $row["e_costoContrato"];
    $prestamo_Informativo = $row["prestamo_Informativo"];
    $tot_ref = 0;
    $tot_des = 0;
    if($tipo_movimiento==4){
        if ($e_costoContrato == 0) {
            $tot_ref = $e_intereses - $e_iva;
        } else {
            $tot_ref = $e_costoContrato;
        }
    }else if($tipo_movimiento==5){
        if ($e_costoContrato == 0) {
            $tot_inter = $e_intereses - $e_iva;
        } else {
            $tot_inter = $e_costoContrato;
        }
        $tot_des = $e_pagoDesempeno + $tot_inter;
        $tot_des = $tot_des - $prestamo_Informativo;
    }

    $tot_ref = number_format($tot_ref, 2,'.',',');
    $tot_des = number_format($tot_des, 2,'.',',');

    $tablaArticulos .= '<tr><td >' . $Movimiento . '</td>
                        <td>' . $id_movimiento . '</td>
                        <td>' . $id_contrato . '</td>
                        <td>$' . $tot_ref . '</td>
                        <td>$' . $tot_des . '</td>
                        </tr>';
}

$contenido .= $tablaArticulos;
$contenido .='
                        </tbody>
                        </table>';
$contenido .= '</form></body></html>';
$nombreContrato = 'Reporte_Utilidades.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
