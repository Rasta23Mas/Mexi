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
                    <center><h3><b>Histórico</b></h3></center>
                    <br>
         <table  width="100%"border="1">
                        <thead style="background: dodgerblue; color:white;">
                            <tr align="center">
                                <th>Fecha</th>
                                <th>Vencimiento</th>
                                <th>Almoneda</th>
                                <th>Contrato</th>
                                <th>Cliente</th>
                                <th>Préstamo</th>
                                <th>Plazo</th>
                                <th>Periodo</th>
                                <th>Tipo Interés</th>
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
                        Con.total_Prestamo AS PRESTAMO,
                        Art.descripcionCorta AS DESCRIPCION,
                        Art.observaciones as ObserArt,
                        Aut.observaciones as ObserAuto,
                        CONCAT ( Aut.marca,' ', Aut.modelo, ' ',Aut.color, ' ' , Aut.placas) as detalleAuto,
                        Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente AND Cli.sucursal=$sucursal
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato And Art.sucursal=$sucursal
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato AND Aut.sucursal=$sucursal
                        WHERE '$fechaIni' >= Con.fecha_fisico_ini
                        AND '$fechaFin'  <= Con.fecha_fisico_fin  AND Con.sucursal=$sucursal
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
    $PRESTAMO = $row["PRESTAMO"];
    $Plazo = $row["Plazo"];
    $Periodo = $row["Periodo"];
    $TipoInteres = $row["TipoInteres"];
    $descripcionCorta = $row["descripcionCorta"];
    $observaciones = $row["observaciones"];
    $ObserAuto = $row["ObserAuto"];
    $DetalleAuto = $row["DetalleAuto"];
    $Form = $row["Form"];

    $PRESTAMO = number_format($PRESTAMO, 2,'.',',');

    $Obser = "";
    $DetalleFin = "";
    if($Form==1){
        $tipoMetal++;
        $Obser = $descripcionCorta;
        $DetalleFin = $observaciones;
    }else if($Form==2){
        $tipoMetal=0;
        $tipoElectro++;
        $Obser = $descripcionCorta;
        $DetalleFin = $observaciones;
    }else if($Form ==3){
        $tipoMetal=0;
        $tipoElectro=0;
        $tipoAuto++;
        $Obser = $ObserAuto;
        $DetalleFin = $DetalleAuto;
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
                        <td>' . $FECHAVEN . '</td>
                        <td>' . $FECHAALM . '</td>
                        <td>' . $CONTRATO . '</td>
                        <td>' . $NombreCompleto . '</td>
                        <td>' . $PRESTAMO . '</td>
                        <td>' . $Plazo . '</td>
                        <td>' . $Periodo . '</td>
                        <td>' . $TipoInteres . '</td>
                        <td>' . $Obser . '</td>
                        <td>' . $DetalleFin . '</td>
                        </tr>';
}






$contenido .= $tablaArticulos;
$contenido .='
                        </tbody>
                        </table>';
$contenido .= '</form></body></html>';

$nombreContrato = 'Reporte_Historico.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
