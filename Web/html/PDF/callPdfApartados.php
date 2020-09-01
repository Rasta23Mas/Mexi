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





$query = "SELECT CSUC.NombreCasa, CSUC.Nombre,CSUC.direccion, CSUC.telefono,CSUC.rfc,BAZ.id_Bazar,
            BAZ.fecha_Modificacion, CONCAT (Cli.apellido_Mat, ' ',Cli.apellido_Pat,' ', Cli.nombre) as NombreCompleto,
            BAZ.id_Contrato, ART.descripcionCorta,ART.observaciones, Baz.id_serie,baz.precio_venta,
            BAZ.precio_Actual,BAZ.apartado,BAZ.iva,BAZ.efectivo,BAZ.cambio,USU.usuario
            FROM bazar_articulos as Baz 
            INNER JOIN cat_sucursal CSuc ON Baz.sucursal=CSUC.id_Sucursal
            INNER JOIN cliente_tbl AS Cli on Baz.id_Cliente = Cli.id_Cliente
            LEFT JOIN articulo_tbl AS ART on Baz.id_Articulo = ART.id_Articulo 
            LEFT JOIN cat_kilataje as TK on ART.kilataje = TK.id_Kilataje
            LEFT JOIN cat_electronico_tipo as ET on ART.tipo = ET.id_tipo
            LEFT JOIN cat_electronico_marca as EM on ART.marca = EM.id_marca
            LEFT JOIN cat_electronico_modelo as EMOD on ART.modelo = EMOD.id_modelo
            LEFT JOIN usuarios_tbl as USU on BAZ.vendedor = USU.id_User
            WHERE id_Bazar=$idBazar";
$resultado = $db->query($query);


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
    $descripcionCorta = $row["descripcionCorta"];
    $observaciones = $row["observaciones"];
    $id_serie = $row["id_serie"];
    $precio_venta = $row["precio_venta"];
    $precio_Actual = $row["precio_Actual"];
    $apartado = $row["apartado"];
    $iva = $row["iva"];
    $efectivo = $row["efectivo"];
    $cambio = $row["cambio"];
    $usuario = $row["usuario"];

}
/*$abonoCapital= round($abonoCapital,2);*/
$subTotal = $precio_venta + $iva;
$faltante = $subTotal - $apartado;
$precio_venta = number_format($precio_venta, 2,'.',',');
$iva = number_format($iva, 2,'.',',');
$apartado = number_format($apartado, 2,'.',',');
$efectivo = number_format($efectivo, 2,'.',',');
$cambio = number_format($cambio, 2,'.',',');
$subTotal = number_format($subTotal, 2,'.',',');
$faltante = number_format($faltante, 2,'.',',');
$Fecha_Creacion = date("d-m-Y", strtotime($Fecha_Creacion));

$descripcionCorta = strtoupper($descripcionCorta);
$observaciones = strtoupper($observaciones);


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
                        <label>ABONO</label>
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
                    <td  align="CENTER"><label>'.$descripcionCorta.'</label></td>
                    <td  align="CENTER"><label>'.$observaciones.'</label></td>
                    <td  align="right"><label>$ '.$precio_venta.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>IVA:</label></td>
                    <td  align="right"><label>$ '.$iva.'</label></td>
                </tr>
                <tr>
                   <td colspan="2" align="right"><label>SUBTOTAL:</label></td>
                    <td  align="right"><label>$ '.$subTotal.'</label></td>
                </tr>
                <tr>
                    <td colspan="2"><label></label></td>
                    <td align="right"><label>-------------</label></td>
                </tr>
                <tr>
                   <td colspan="2" align="right"><label>APARTADO:</label></td>
                    <td  align="right"><label>$ '.$apartado.'</label></td>
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
                    <td  align="right"><label>$ '.$faltante.'</label></td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                      <label>_______________________________________</label>
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
//echo $contenido;
//exit;


$nombreContrato = 'Apartado Num ' . $id_Bazar . ".pdf";
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
