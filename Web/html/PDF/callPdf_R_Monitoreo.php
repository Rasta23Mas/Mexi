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
$tipo='';
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
if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
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
                                <th>ID</th>
                                <th>Contrato</th>
                                <th>Tipo</th>
                                <th>Token</th>
                                <th>Descripción</th>
                                <th>Descuento</th>
                                <th>Interés</th>
                                <th>Importe</th>
                                <th>Flujo</th>
                                <th>Tipo Token</th>
                                <th>Usuario</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody id="idTBodyMonitoreo"  align="center">
                        ';
$rptMon = "SELECT Bit.id_BitacoraToken,Bit.id_Contrato,Bit.tipo_formulario as FORMU,Bit.token,Bit.descripcion,
                        Bit.descuento,Bit.interes, Cat.descripcion as Descrip, Usu.usuario,Bit.importe_flujo,
                        Bit.id_flujo,
                        DATE_FORMAT(Bit.fecha_Creacion,'%Y-%m-%d') as Fecha FROM bit_token as Bit
                        INNER JOIN cat_token_movimiento as Cat on Bit.id_tokenMovimiento = Cat.id_tokenMovimiento
                        LEFT JOIN usuarios_tbl as Usu on Bit.usuario = Usu.id_User  ";
if($tipo==0||$tipo=="0"){
    $rptMon .= " WHERE Bit.fecha_Creacion BETWEEN '$fechaIni' 
                            AND '$fechaFin' AND Bit.sucursal = $sucursal  ORDER BY Bit.id_BitacoraToken";
}else{
    $rptMon .= "WHERE Bit.id_tokenMovimiento=$tipo AND  Bit.fecha_Creacion BETWEEN '$fechaIni' 
                            AND '$fechaFin' AND Bit.sucursal = $sucursal  ORDER BY Bit.id_BitacoraToken";
}
$resultado = $db->query($rptMon);
$tipoMetal = 0;
$tipoElectro = 0;
$tipoAuto = 0;
$tablaArticulos = '';

foreach ($resultado as $row) {
    $Form = $row["FORMU"];
    $Descu = $row["descuento"];
    $Interes = $row["interes"];
    $Importe = $row["importe_flujo"];
    $tipoArt = "";
    if($Form==1){
        $tipoArt = "METAL";
    }else if($Form==2){
        $tipoArt = "ELECTRÓNICOS";
    }else if($Form ==3){
        $tipoArt = "AUTO";
    }
    $Descu = number_format($Descu, 2,'.',',');
    $Interes = number_format($Interes, 2,'.',',');
    $Importe = number_format($Importe, 2,'.',',');

    $tablaArticulos .= '<tr><td >' . $row["id_BitacoraToken"] . '</td>
                        <td>' . $row["id_Contrato"] . '</td>
                        <td>' . $tipoArt . '</td>
                        <td>' . $row["token"] . '</td>
                        <td>' . $row["descripcion"] . '</td>
                        <td>$' . $Descu . '</td>
                        <td>$' . $Interes . '</td>
                        <td>$' . $Importe . '</td>
                        <td>' . $row["id_flujo"] . '</td>
                        <td>' . $row["Descrip"] . '</td>
                        <td>' . $row["usuario"] . '</td>
                        <td>' . $row["Fecha"] . '</td>
                        </tr>';
}






$contenido .= $tablaArticulos;
$contenido .='
                        </tbody>
                        </table>';
$contenido .= '</form></body></html>';

$nombreContrato = 'Reporte_Autorizaciones.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
