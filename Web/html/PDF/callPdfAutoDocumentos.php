<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
require_once(WEB_PATH . "dompdf/autoload.inc.php");

use Dompdf\Dompdf;


if (!isset($_SESSION)) {
    session_start();
}
$usuario = $_SESSION["idUsuario"];
$NombreUsuario = $_SESSION["usuario"];
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
    $db = "mexicash";
}


$mysql = new  mysqli($server, $user, $password, $db);


$NombreCompleto = "";
$Contrato = "";
$NombreCompleto = "";
$Vencimiento = "";
$Creacion = "";
$Tarjeta = "";
$Factura = "";
$INE = "";
$Importacion = "";
$Tenencia = "";
$Poliza = "";
$Licencia = "";
$NombreUsuario = "";
$NombreSucursal = "";

if (isset($_GET['contrato'])) {
    $idContrato = $_GET['contrato'];
}



$query = "SELECT CONCAT (Cli.apellido_Mat, ' ',Cli.apellido_Pat,' ', Cli.nombre) AS NombreCompleto, 
DATE_FORMAT(Con.fecha_Creacion,'%d-%m-%Y') AS Creacion, Aut.chkTarjeta AS Tarjeta, Aut.chkFactura AS Factura, Aut.chkINE AS INE,
Aut.chkImportacion AS Importacion,Aut.chkTenencias AS Tenencia, Aut.chkPoliza AS Poliza, Aut.chkLicencia AS Licencia 
FROM contrato_tbl AS Con 
INNER JOIN cliente_tbl AS Cli on Con.id_Cliente = Cli.id_Cliente 
INNER JOIN auto_tbl AS Aut on Con.id_Contrato = Aut.id_Contrato 
WHERE Con.id_Contrato=$idContrato AND Con.tipoContrato = 2";
$resultado = $mysql->query($query);


foreach ($resultado as $row) {
    $NombreCompleto = $row["NombreCompleto"];
    $Creacion = $row["Creacion"];
    $Tarjeta = $row["Tarjeta"];
    $Factura = $row["Factura"];
    $INE = $row["INE"];
    $Importacion = $row["Importacion"];
    $Tenencia = $row["Tenencia"];
    $Poliza = $row["Poliza"];
    $Licencia = $row["Licencia"];

    if($Tarjeta==1){
        $Tarjeta = "Si";
    }else{
        $Tarjeta = "No";
    }
    if($Factura==1){
        $Factura = "Si";
    }else{
        $Factura = "No";
    }
    if($INE==1){
        $INE = "Si";
    }else{
        $INE = "No";
    }
    if($Importacion==1){
        $Importacion = "Si";
    }else{
        $Importacion = "No";
    }
    if($Tenencia==1){
        $Tenencia = "Si";
    }else{
        $Tenencia = "No";
    }
    if($Poliza==1){
        $Poliza = "Si";
    }else{
        $Poliza = "No";
    }
    if($Licencia==1){
        $Licencia = "Si";
    }else{
        $Licencia = "No";
    }


}

$buscar = "SELECT Nombre, direccion, telefono, NombreCasa,rfc FROM cat_sucursal WHERE id_Sucursal = " . $sucursal;
$contrato = $mysql->query($buscar);
foreach ($contrato as $fila) {
    $sucNombre = $fila['Nombre'];
    $sucDireccion = $fila['direccion'];
    $sucTelefono = $fila['telefono'];
    $sucNombreCasa = $fila['NombreCasa'];
    $sucRfc = $fila['rfc'];
}

$contenido = '<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .letraNormalNegrita{
          font-size: .6em;
          font-weight: bold;
         }
          .letraGrandeNegrita{
          font-size: 1em;
          font-weight: bold;
         }
          .letraChicaNegrita{
          font-size: .4em;
          font-weight: bold;
         }
          .letraNormal{
          font-size: .6em;
         }
          .letraGrande{
          font-size: 1em;
         }
          .letraChica{
          font-size: .4em;
         }
        .tituloCelda{
          background-color: #ebebe0
        }
    </style>
</head>
<body>
<form>';
$contenido .= '<table width="30%" border="1">
        <tbody>
        <tr>
            <td align="center" >
                <table width="=100%" border="0">
                    <tr>
                        <td colspan="4" align="center">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <label>COMPROBANTE DE </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <label>DOCUMENTOS ENTREGADOS</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <label ID="sucursal">SUCURSAL: '. $sucNombre .'</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            &nbsp;
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4" align="left">
                            <label >CONTRATO NO: '. $idContrato.' </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="left">
                            <label >CLIENTE : '. $NombreCompleto.' </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="left">
                            <label >FECHA : '. $Creacion.' </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="left">
                            <label >FECHA VENCIMIENTO : '. $Vencimiento.' </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left">
                            <label >Tarjeta de Circulación :</label>
                        </td>
                         <td align="left">
                            <label >'. $Tarjeta.' </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left">
                            <label >Factura : </label>
                        </td>
                         <td align="left">
                            <label >'. $Factura.' </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left">
                            <label >Copia INE : </label>
                        </td>
                         <td align="left">
                            <label >'. $INE.' </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left">
                            <label >Importación : </label>
                        </td>
                         <td align="left">
                            <label >'. $Importacion.' </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left">
                            <label >Tenencias (Últimas 5) : </label>
                        </td>
                         <td align="left">
                            <label >'. $Tenencia.' </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left">
                            <label >Póliza de seguro : </label>
                        </td>
                         <td align="left">
                            <label >'. $Poliza.' </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left">
                            <label >Copia de Licencia: </label>
                        </td>
                         <td align="left">
                            <label >'. $Licencia.' </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            &nbsp;
                        </td>
                    </tr>
                          <tr>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                          <tr>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <label>___________________________</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <label>Cliente</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <label>'. $NombreCompleto.' </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                          <tr>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                          <tr>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <label>___________________________</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <label>Usuario </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <label>'. $NombreUsuario.' </label>
                        </td>
                    </tr>
                         <tr>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                </table>
            </td>
        </tr>';
$contenido .= '</tbody></table></form></body></html>';

$nombreContrato = 'Documentos_Contrato Num ' . $idContrato . ".pdf";
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
