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




$FECHA = "";
$FECHAMOV ="";
$FECHAVEN = "";
$CONTRATO = "";
$PRESTAMO = "";
$INTERESES = "";
$ALMACENAJE = "";
$SEGURO = "";
$ABONO = "";
$DESC = "";
$COSTO = "";
$SUBTOTAL = "";
$IVA ="";
$TOTAL ="";
$Form ="";

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
                    <center><h3><b>Refrendo</b></h3></center>
                    <br>
         <table  width="100%"border="1">
                        <thead style="background: dodgerblue; color:white;">
                            <tr align="center">
                                <th>Fecha</th>
        <th>Fecha Mov.</th>
        <th>Contrato</th>
        <th>Préstamo</th>
        <th>Intereses</th>
        <th>Almacenaje</th>
        <th>Seguro</th>
        <th>Abono Capital</th>
        <th>Desc</th>
        <th>Costo C</th>
        <th>SubTotal</th>
        <th>Iva Int</th>
        <th>Total Cobrado</th>
        <th>Utilidad</th>
                            </tr>
                        </thead>
                        <tbody id="idTBodyHistorico"  align="center"> ';
$query = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') AS FECHAMOV,
                        ConM.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO, 
                        ConM.e_interes AS INTERESES,  ConM.e_almacenaje AS ALMACENAJE, 
                        ConM.e_seguro AS SEGURO,  ConM.e_abono as ABONO,ConM.s_descuento_aplicado as DESCU,
                        ConM.e_iva as IVA, ConM.e_costoContrato AS COSTO, Con.id_Formulario as FORMU,
                         ConM.pag_subtotal,  ConM.pag_total,ConM.e_intereses,ConM.e_moratorios
                        FROM contrato_mov_tbl AS ConM
                        INNER JOIN contratos_tbl AS Con ON ConM.id_contrato = Con.id_Contrato AND Con.sucursal=$sucursal
                        WHERE DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 4 OR ConM.tipo_movimiento = 8 )  
                        ORDER BY Con.id_Formulario,ConM.id_contrato";
$resultado = $db->query($query);
$tipoMetal = 0;
$tipoElectro = 0;
$tipoAuto = 0;
$tablaArticulos = '';

foreach ($resultado as $row) {
    $FECHA = $row["FECHA"];
    $FECHAMOV = $row["FECHAMOV"];
    $CONTRATO = $row["CONTRATO"];
    $PRESTAMO = $row["PRESTAMO"];
    $INTERESES = $row["INTERESES"];
    $ALMACENAJE = $row["ALMACENAJE"];
    $SEGURO = $row["SEGURO"];
    $ABONO = $row["ABONO"];
    $DESC = $row["DESCU"];
    $COSTO = $row["COSTO"];
    $Form = $row["FORMU"];
    $SUBTOTAL = $row["pag_subtotal"];
    $IVA = $row["IVA"];
    $TOTAL = $row["pag_total"];

    $e_intereses = $row["e_intereses"];
    $moratorios = $row["e_moratorios"];
    if($COSTO==0){
        $utilidad = $e_intereses - $IVA;
        $utilidad = $utilidad + $moratorios;
    }else{
        $utilidad = $COSTO;
    }

    $PRESTAMO = number_format($PRESTAMO, 2,'.',',');
    $INTERESES = number_format($INTERESES, 2,'.',',');
    $ALMACENAJE = number_format($ALMACENAJE, 2,'.',',');
    $SEGURO = number_format($SEGURO, 2,'.',',');
    $ABONO = number_format($ABONO, 2,'.',',');
    $DESC = number_format($DESC, 2,'.',',');
    $IVA = number_format($IVA, 2,'.',',');
    $COSTO = number_format($COSTO, 2,'.',',');
    $SUBTOTAL = number_format($SUBTOTAL, 2,'.',',');
    $TOTAL = number_format($TOTAL, 2,'.',',');
    $utilidad = number_format($utilidad, 2,'.',',');

    if($Form==1){
        $tipoMetal++;
    }else if($Form==2){
        $tipoMetal=0;
        $tipoElectro++;
    }else if($Form ==3){
        $tipoMetal=0;
        $tipoElectro=0;
        $tipoAuto++;
    }
    if($tipoMetal==1){
        $tablaArticulos .= '<tr>
        <td colspan="14" style="background: dodgerblue; color:white;  text-align: center" > METAL </td>
        </tr>';
    }else if($tipoElectro==1){
        $tablaArticulos .= '<tr>
        <td colspan="14" style="background: dodgerblue; color:white;  text-align: center" > ELECTRÓNICOS </td>
        </tr>';
    }else if($tipoAuto==1){
        $tablaArticulos .= '<tr>
        <td colspan="14" style="background: dodgerblue; color:white;  text-align: center" > AUTO </td>
        </tr>';
    }

    $tablaArticulos .= '<tr><td >' . $FECHA . '</td>
                        <td>' . $FECHAMOV . '</td>
                        <td>' . $CONTRATO . '</td>
                        <td>' . $PRESTAMO . '</td>
                        <td>' . $INTERESES . '</td>
                        <td>' . $ALMACENAJE . '</td>
                        <td>' . $SEGURO . '</td>
                        <td>' . $ABONO . '</td>
                        <td>' . $DESC . '</td>
                        <td>' . $COSTO . '</td>
                        <td>' . $SUBTOTAL . '</td>
                        <td>' . $IVA . '</td>
                        <td>' . $TOTAL . '</td>
                        <td>' . $utilidad . '</td>
                        </tr>';
}






$contenido .= $tablaArticulos;
$contenido .='
                        </tbody>
                        </table>';
$contenido .= '</form></body></html>';

$nombreContrato = 'Reporte_Refrendo.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
