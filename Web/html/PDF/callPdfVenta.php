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
    $db = "mexicash";
}

$mysql = new  mysqli($server, $user, $password, $db);


$NombreCompleto = "";
$prestamo = "";
$abonoCapital = "";
$intereses = "";
$almacenaje = "";
$seguro = "";
$desempeñoExt = "";
$moratorios = "";
$otrosCobros = "";
$descuentoAplicado = "";
$descuentoPuntos = "";
$iva = "";
$efectivo = "";
$cambio = "";
$mutuo = "";
$refrendo = "";
$Fecha_Almoneda = "";
$Fecha_Vencimiento = "";
$Fecha_Creacion = "";
$NombreUsuario = "";
$sucursal = "";

$subTotal = 0;
$Total = 0;

if (isset($_GET['idBazar'])) {
    $idBazar = $_GET['idBazar'];
}



$descuento_Venta = 0;

$query = "SELECT CSUC.NombreCasa, CSUC.Nombre,CSUC.direccion, CSUC.telefono,CSUC.rfc,BAZ.id_Bazar,
            BAZ.fecha_Modificacion, CONCAT (Cli.apellido_Mat, ' ',Cli.apellido_Pat,' ', Cli.nombre) as NombreCompleto,
            BAZ.id_Contrato, ART.detalle,TK.descripcion as Kilataje,ET.descripcion AS TipoElectronico,
            EM.descripcion AS MarcaElectronico,EMOD.descripcion AS ModeloElectronico,Baz.id_serie,baz.precio_venta,
            BAZ.precio_Actual,BAZ.iva,BAZ.efectivo,BAZ.cambio,USU.usuario, BAZ.descuento_Venta
            FROM bazar_articulos as Baz 
            INNER JOIN cat_sucursal CSuc ON Baz.sucursal=CSUC.id_Sucursal
            INNER JOIN cliente_tbl AS Cli on Baz.id_Cliente = Cli.id_Cliente
            LEFT JOIN articulo_tbl AS ART on Baz.id_serie = CONCAT (ART.id_SerieSucursal, ART.id_SerieContrato,ART.id_SerieArticulo) 
            LEFT JOIN cat_kilataje as TK on ART.kilataje = TK.id_Kilataje
            LEFT JOIN cat_electronico_tipo as ET on ART.tipo = ET.id_tipo
            LEFT JOIN cat_electronico_marca as EM on ART.marca = EM.id_marca
            LEFT JOIN cat_electronico_modelo as EMOD on ART.modelo = EMOD.id_modelo
            LEFT JOIN usuarios_tbl as USU on BAZ.vendedor = USU.id_User
            WHERE id_Bazar=$idBazar";
$resultado = $mysql->query($query);


foreach ($resultado as $row) {
    $NombreCasa = $row["NombreCasa"];
    $Nombre = $row["Nombre"];
    $direccion = $row["direccion"];
    $telefono = $row["telefono"];
    $rfc = $row["rfc"];
    $id_Bazar = $row["id_Bazar"];
    $fecha_Modificacion = $row["fecha_Modificacion"];
    $NombreCompleto = $row["NombreCompleto"];
    $id_Contrato = $row["id_Contrato"];
    $detalle = $row["detalle"];
    $Kilataje = $row["Kilataje"];
    $TipoElectronico = $row["TipoElectronico"];
    $MarcaElectronico = $row["MarcaElectronico"];
    $ModeloElectronico = $row["ModeloElectronico"];
    $id_serie = $row["id_serie"];
    $precio_venta = $row["precio_venta"];
    $precio_Actual = $row["precio_Actual"];
    $iva = $row["iva"];
    $efectivo = $row["efectivo"];
    $cambio = $row["cambio"];
    $usuario = $row["usuario"];
    $descuento_Venta = $row["descuento_Venta"];
}
$total = $precio_venta + $iva;
$total= $total -$descuento_Venta;
$precio_venta = number_format($precio_venta, 2,'.',',');
$iva = number_format($iva, 2,'.',',');
$efectivo = number_format($efectivo, 2,'.',',');
$cambio = number_format($cambio, 2,'.',',');
$precio_Actual = number_format($precio_Actual, 2,'.',',');
$descuento_Venta = number_format($descuento_Venta, 2,'.',',');
$total = number_format($total, 2,'.',',');

$Fecha_Creacion = date("d-m-Y", strtotime($Fecha_Creacion));

$detalle = strtoupper($detalle);
$Kilataje = strtoupper($Kilataje);


$contenido = '<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .letraNormalNegrita{
          font-size: .5em;
          font-weight: bold;
         }
          .letraGrandeNegrita{
          font-size: .9em;
          font-weight: bold;
         }
          .letraChicaNegrita{
          font-size: .3em;
          font-weight: bold;
         }
          .letraNormal{
          font-size: .5em;
         }
          .letraGrande{
          font-size: .9em;
         }
          .letraChica{
          font-size: .3em;
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
        <td>
         <table width="100%" border="0" class="letraNormalNegrita">
                <tr>
                    <td colspan="3" align="center">
                        <label>'. $NombreCasa .'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label ID="sucursal">SUCURSAL: '. $Nombre .'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label ID="sucursalDir">'. $direccion .'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label ID="sucursalTel">Tel: '. $telefono .'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label ID="sucursalRfc">RFC: '. $rfc .'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label> ****************** </label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label>COMPROBANTE DE </label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label>VENTA</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label> ****************** </label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label id="id_Recibo">FOLIO NO: '. $id_Bazar.'</label>
                    </td>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td colspan="3" align="left">
                        <label id="idFechaHoy">FECHA: '. $fecha_Modificacion.'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left">
                        <label id="idCliente">CLIENTE: '. $NombreCompleto.'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left">
                        <label id="idCliente">CONTRATO: '. $id_Contrato.'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left">
                         <label id="idCliente">CODIGO: '. $id_serie.'</label>
                    </td>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td  align="CENTER"><label>DESCRIPCION</label></td>
                        <td  align="CENTER"><label>KILATES</label></td>
                      <td  align="CENTER"><label>PRECIO</label></td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                      <label>_______________________________________</label>
                    </td>
                </tr>
                <tr>
                    <td  align="CENTER"><label>'.$detalle.'</label></td>
                    <td  align="CENTER"><label>'.$Kilataje.'</label></td>
                    <td  align="right"><label>$ '.$precio_venta.'</label></td>
                </tr>
                <tr>
                   <td colspan="2" align="right"><label>IVA:</label></td>
                    <td  align="right"><label>$ '.$iva.'</label></td>
                </tr>
                <tr>
                   <td colspan="2" align="right"><label>DESCUENTOS:</label></td>
                    <td  align="right"><label>$ '.$descuento_Venta.'</label></td>
                </tr>
                <tr>
                   <td colspan="2" align="right"><label>TOTAL:</label></td>
                    <td  align="right"><label>$ '.$total.'</label></td>
                </tr>
                <tr>
                   <td colspan="2" align="right"><label>EFECTIVO:</label></td>
                    <td  align="right"><label>$ '.$efectivo.'</label></td>
                </tr>
                <tr>
                   <td colspan="2" align="right"><label>CAMBIO:</label></td>
                    <td  align="right"><label>$ '.$cambio.'</label></td>
                </tr>
                <tr>
                    <td colspan="2"><label></label></td>
                    <td align="right"><label>-------------</label></td>
                </tr>
                <tr>
                   <td colspan="2" align="right"><label>FALTA POR PAGAR:</label></td>
                    <td  align="right"><label>$ '.$precio_Actual.'</label></td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                      <label>_______________________________________</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left">
                      <label>Venta de piezas de segunda mano.</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left">
                      <label>Las piezas se venden en el estado en
                             que se encuentran.</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left">
                      <label>No se aceptan devoluciones.</label>
                    </td>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td colspan="3" align="left">
                      <label><b>MERCANCÍA SIN GARANTÍA.<b></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left">
                      <label><b>NO SE ACEPTAN CAMBIOS O<b></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left">
                      <label><b>DEVOLUCIONES DE MERCANCÍA.<b></label>
                    </td>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td colspan="3"><label id="idUsuario">Usuario: '.$usuario.'</label></td>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td colspan="3">
                       &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                      <label>___________________________</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label>Cliente</label>
                    </td>
                </tr>
                 <tr>
                    <td colspan="3">
                        &nbsp;
                    </td>
                </tr>
                 <tr>
                    <td colspan="3">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label>___________________________</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label>Usuario</label>
                    </td>
                </tr>
            </table>
        </td>
        </tr>';
$contenido .= '</tbody></table></form></body></html>';

$nombreContrato = 'Venta Num ' . $id_Bazar . ".pdf";
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
