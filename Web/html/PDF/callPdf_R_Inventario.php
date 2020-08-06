<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
require_once(WEB_PATH . "dompdf/autoload.inc.php");

use Dompdf\Dompdf;


if (!isset($_SESSION)) {
    session_start();
}
$usuario = $_SESSION["idUsuario"];
$sucursal = $_SESSION["sucursal"];


$web = 2;
if($web==1){
    $server = "localhost";
    $user = "u672450412_root";
    $password = "12345";
    $db = "u672450412_Mexicash";
}else{
    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "u672450412_Mexicash";
}

$mysql = new  mysqli($server, $user, $password, $db);


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
                                <th>Vencimiento</th>
                                <th>Almoneda</th>
                                <th>Contrato</th>
                                <th>Cliente</th>
                                <th>Préstamo</th>
                                <th>Plazo</th>
                                <th>Periodo</th>
                                <th>Tipo Interés</th>
                                <th>Observaciones</th>
                                <th>Detalle</th>
                            </tr>
                        </thead>
                        <tbody id="idTBodyInventario"  align="center">
                        ';
$query = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM, 
                        Con.id_contrato AS CONTRATO,
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Con.total_Prestamo AS PRESTAMO,
                        Con.plazo AS Plazo, Con.periodo as Periodo, Con.tipoInteres as TipoInteres,
                        CONCAT(EM.descripcion,' ', ET.descripcion, ' ',EMOD.descripcion) as ObserElec, 
                        CONCAT(Tipo.descripcion, ' ',Kil.descripcion,' ', Cal.descripcion) as ObserMetal,
                        Aut.observaciones as ObserAuto,
                        CONCAT(Aut.marca, ' ', Aut.modelo) as DetalleAuto, 
                        CONCAT(Art.detalle) as Detalle,
                        Art.tipoArticulo, Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN bit_cierrecaja as Bit on Con.id_cierreCaja = Bit.id_CierreCaja
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato 
                        LEFT JOIN cat_electronico_marca as EM on Art.marca = EM.id_marca
                        LEFT JOIN cat_electronico_modelo as EMOD on Art.modelo = EMOD.id_modelo
                        LEFT JOIN cat_electronico_tipo as ET on Art.tipo = ET.id_tipo
                        LEFT JOIN cat_kilataje as Kil on Art.kilataje = Kil.id_Kilataje
                        LEFT JOIN cat_tipoarticulo as Tipo on Art.tipo = Tipo.id_tipo
                        LEFT JOIN cat_calidad as Cal on Art.calidad = Cal.id_calidad
                        WHERE Con.fisico = 1
                        AND Bit.sucursal = $sucursal 
                        ORDER BY Form";
$resultado = $mysql->query($query);
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
    $ObserElec = $row["ObserElec"];
    $ObserMetal = $row["ObserMetal"];
    $ObserAuto = $row["ObserAuto"];
    $DetalleAuto = $row["DetalleAuto"];
    $Detalle = $row["Detalle"];
    $Form = $row["Form"];

    $PRESTAMO = number_format($PRESTAMO, 2,'.',',');

    $Obser = "";
    $DetalleFin = "";
    if($Form==1){
        $tipoMetal++;
        $Obser = $ObserMetal;
        $DetalleFin = $Detalle;
    }else if($Form==2){
        $tipoMetal=0;
        $tipoElectro++;
        $Obser = $ObserElec;
        $DetalleFin = $Detalle;
    }else if($Form ==3){
        $tipoMetal=0;
        $tipoElectro=0;
        $tipoAuto++;
        $Obser = $ObserAuto;
        $DetalleFin = $DetalleAuto;
    }
    if($tipoMetal==1){
        $tablaArticulos .= '<tr>
        <td colspan="11" style="background: dodgerblue; color:white; text-align: center" > METAL </td>
        </tr>';
    }else if($tipoElectro==1){
        $tablaArticulos .= '<tr>
        <td colspan="11" style="background: dodgerblue; color:white; text-align: center"> ELECTRÓNICOS </td>
        </tr>';
    }else if($tipoAuto==1){
        $tablaArticulos .= '<tr>
        <td colspan="11" style="background: dodgerblue; color:white; text-align: center"> AUTO </td>
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

$nombreContrato = 'Reporte Inventario.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);