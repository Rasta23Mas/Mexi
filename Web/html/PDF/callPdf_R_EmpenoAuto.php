<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
require_once(WEB_PATH . "dompdf/autoload.inc.php");
require_once (BASE_PATH . "Conectar.php");
use Dompdf\Dompdf;


if (!isset($_SESSION)) {
    session_start();
}
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
$FECHAVEN = "";
$FECHAALM ="";
$CONTRATO = "";
$NombreCompleto = "";
$PRESTAMO = "";
$Plazo = "";
$Periodo = "";
$TipoInteres = "";
$ObserElec = "";
$ObserMetal = "";
$ObserAuto = "";
$DetalleAuto = "";
$Detalle ="";
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
                    <center><h3><b>Empeños</b></h3></center>
                    <br>
         <table  width="100%"border="1">
                        <thead style="background: dodgerblue; color:white;">
                            <tr align="center">
                               <th>Fecha</th>
        <th>Vencimiento</th>
        <th>Almoneda</th>
        <th>Cliente</th>
        <th>Contrato</th>
        <th>Préstamo</th>
        <th>Detalle</th>
        <th>Observaciones</th>
        
                            </tr>
                        </thead>
                        <tbody id="idTBodyHistorico"  align="center"> ';
$query = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM,  
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Con.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMOAUTO,
                        CONCAT (Aut.marca , ' ',Aut.modelo,' ', Aut.anio,' ', Aut.color) as DESCRIPCIONAUTO,
                        Aut.observaciones as ObserAuto,
                        Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato AND Con.sucursal = Aut.sucursal
                        WHERE Con.id_Formulario=3 AND DATE_FORMAT(Con.fecha_creacion,'%Y-%m-%d') 
                        BETWEEN '$fechaIni' AND '$fechaFin' AND Con.sucursal=$sucursal
                        ORDER BY Con.id_contrato";
$resultado = $db->query($query);
$tipoMetal = 0;
$tipoElectro = 0;
$tipoAuto = 0;
$tablaArticulos = '';

foreach ($resultado as $row) {
    $FECHA = $row["FECHA"];
    $FECHAVEN = $row["FECHAVEN"];
    $FECHAALM = $row["FECHAALM"];
    $CONTRATO = $row["CONTRATO"];
    $NombreCompleto = $row["NombreCompleto"];
    $PRESTAMOAUTO = $row["PRESTAMOAUTO"];
    $descripcionAuto = $row["DESCRIPCIONAUTO"];
    $ObserAuto = $row["ObserAuto"];
    $Form = $row["Form"];

    $PRESTAMO = number_format($PRESTAMO, 2,'.',',');
    $PRESTAMOAUTO = number_format($PRESTAMOAUTO, 2,'.',',');
    
    $Obser = "";
    $DetalleFin = "";
    $PRES  = "";
    $DES  = "";

        $tipoMetal=0;
        $tipoElectro=0;
        $tipoAuto++;
        $Obser = $descripcionAuto;
        $DetalleFin = $ObserAuto;
        $PRES  = $PRESTAMOAUTO;


    $tablaArticulos .= '<tr><td >' . $FECHA . '</td>
                        <td>' . $FECHAVEN . '</td>
                        <td>' . $FECHAALM . '</td>
                        <td>' . $NombreCompleto . '</td>
                        <td>' . $CONTRATO . '</td>
                        <td>' . $PRES . '</td>
                        <td>' . $Obser . '</td>
                        <td>' . $DetalleFin . '</td>
                        </tr>';
}






$contenido .= $tablaArticulos;
$contenido .='
                        </tbody>
                        </table>';
$contenido .= '</form></body></html>';
$nombreContrato = 'Reporte_Empeno_Auto.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
