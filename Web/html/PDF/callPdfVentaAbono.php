<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
require_once(WEB_PATH . "dompdf/autoload.inc.php");
require_once(BASE_PATH . "Conectar.php");

use Dompdf\Dompdf;


if (!isset($_SESSION)) {
    session_start();
}
$usuario = $_SESSION["idUsuario"];
$sucursal = $_SESSION["sucursal"];


if (isset($_GET['idBazar'])) {
    $id_Bazar = $_GET['idBazar'];
}


$query = "SELECT CSUC.NombreCasa, CSUC.Nombre,CSUC.direccion, CSUC.telefono,CSUC.rfc,Baz.id_Bazar,
            Baz.fecha_Creacion, CONCAT (Cli.apellido_Mat, ' ',Cli.apellido_Pat,' ', Cli.nombre) as NombreCompleto,
           Baz.faltaPagar,USU.usuario,Baz.id_Apartado AS Apartado
            FROM contrato_mov_baz_tbl as Baz 
            LEFT JOIN cat_sucursal CSUC ON Baz.sucursal=CSUC.id_Sucursal
            LEFT JOIN cliente_tbl AS Cli on Baz.cliente = Cli.id_Cliente
            LEFT JOIN usuarios_tbl as USU on Baz.vendedor = USU.id_User
            WHERE id_Bazar=$id_Bazar and Baz.sucursal=$sucursal";
$resultado = $db->query($query);
$descripcionCorta = "";
$observaciones = "";

foreach ($resultado as $row) {
    $NombreCasa = $row["NombreCasa"];
    $Nombre = $row["Nombre"];
    $direccion = $row["direccion"];
    $telefono = $row["telefono"];
    $rfc = $row["rfc"];
    $fecha_Modificacion = $row["fecha_Creacion"];
    $NombreCompleto = $row["NombreCompleto"];
    $faltaPagar = $row["faltaPagar"];
    $usuario = $row["usuario"];
    $Apartado = $row["Apartado"];
}

$faltaPagar = number_format($faltaPagar, 2, '.', ',');

$Fecha_Creacion = date("d-m-Y", strtotime($fecha_Modificacion));

$tablaArticulos = '';
if($Apartado==0){
    $idBazarBuscar = $id_Bazar;
}else{
    $idBazarBuscar = $Apartado;
}

$query = "SELECT Art.id_serie, Art.descripcionCorta,Art.vitrinaVenta FROM articulo_bazar_tbl AS Art
                INNER JOIN  bit_ventas AS Ven ON Art.id_ArticuloBazar =  Ven.id_ArticuloBazar
                WHERE id_bazar = $idBazarBuscar AND Art.sucursal=$sucursal";
$tablaArt = $db->query($query);

foreach ($tablaArt as $row) {
    $id_serie = $row["id_serie"];
    $descripcionCorta = $row["descripcionCorta"];
    $vitrinaVenta = $row["vitrinaVenta"];
    $vitrinaVenta = number_format($vitrinaVenta, 2, '.', ',');

    $tablaArticulos .= '<tr>
                            <td><label class="letraGrande">' . $id_serie . '</label></td>
                            <td><label class="letraGrande">' . $descripcionCorta . '</label></td>
                            <td align="right"><label>$ ' . $vitrinaVenta . '</label></td>
                        </tr>';

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
          font-size: 1.2em;
          font-weight: bold;
         }
          .letraChicaNegrita{
          font-size: .6em;
          font-weight: bold;
         }
          .letraNormal{
          font-size: .8em;
         }
          .letraGrande{
          font-size: 1.2em;
         }
          .letraChica{
          font-size: .6em;
         }
        .tituloCelda{
          background-color: #ebebe0
        }
    </style>
</head>
<body>
<form>';
$contenido .= '<table width="100%" border="0">
        <tbody>
        <tr>
        <td>
         <table width="100%" border="0" class="letraNormalNegrita">
                <tr>
                    <td colspan="3" align="center">
                        <label>' . $NombreCasa . 'x2</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label ID="sucursal">SUCURSAL: ' . $Nombre . '</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label ID="sucursalDir">' . $direccion . '</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label ID="sucursalTel">Tel: ' . $telefono . '</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label ID="sucursalRfc">RFC: ' . $rfc . '</label>
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
                        <label id="id_Recibo">FOLIO NO: ' . $id_Bazar . '</label>
                    </td>
                </tr>
                <tr><td colspan="3"><br></td></tr>
                <tr>
                    <td colspan="3" align="left">
                        <label id="idFechaHoy">FECHA: ' . $fecha_Modificacion . '</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left">
                        <label >CLIENTE: ' . $NombreCompleto . '</label>
                    </td>
                </tr>
                <tr><td colspan="3"><br></td></tr>
                <tr>
                    <td  align="CENTER"><label>CÓDIGO</label></td>
                    <td  align="CENTER"><label>DESCRIPCIÓN</label></td>
                    <td  align="CENTER"><label>PRECIO</label></td>
                </tr>';
$contenido .= $tablaArticulos;
$contenido .= ' 
                 <tr>
                   <td colspan="2" align="right"><label>FALTA POR PAGAR:</label></td>
                    <td  align="right"><label>$ ' . $faltaPagar . '</label></td>
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
                <tr><td colspan="3"><br></td></tr>
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
                 <tr><td colspan="3"><br></td></tr>
                <tr>
                    <td colspan="3"><label id="idUsuario">Usuario: ' . $usuario . '</label></td>
                </tr>
                 <tr><td colspan="3"><br></td></tr>
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
/*echo $contenido;
exit();*/
$nombreContrato = 'Venta_A_Num_' . $id_Bazar . ".pdf";
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
if($sucursal==1){
    $dompdf->setPaper('letter', 'portrait');
}else if($sucursal==2){
    $customPaper = array(0,0,300,650);
    $dompdf->setPaper($customPaper);
}
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
