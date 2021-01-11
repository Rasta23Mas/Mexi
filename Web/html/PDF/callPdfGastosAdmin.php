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


$subTotal = 0;
$Total = 0;
$reimpresion='';
if (isset($_GET['reimpresion'])) {
    $reimpresion = "REIMPRESIÓN";
}
if (isset($_GET['tipo'])) {
    $tipoReporte = $_GET['tipo'];
}
if (isset($_GET['contrato'])) {
    $idContrato = $_GET['contrato'];
}
if (isset($_GET['ultimoMovimiento'])) {
    $ultimoMovimiento = $_GET['ultimoMovimiento'];
}else{
    $ultimoMovimiento = 0;
}

$query = " SELECT Con.id_movimiento,CONCAT (Cli.apellido_Mat, ' ',Cli.apellido_Pat,' ', Cli.nombre) as NombreCompleto,
                    Con.s_descuento_aplicado,Cot.total_Prestamo, Con.pag_efectivo, Con.pag_cambio, Con.fechaAlmoneda, Con.fechaVencimiento,
                    Con.fecha_Movimiento, CONCAT (Usu.apellido_Pat, ' ',Usu.apellido_Mat,' ', Usu.nombre) as NombreUsuario,
                    Suc.Nombre AS NombreSucursal, Suc.NombreCasa, Suc.rfc,
                    Suc.direccion AS DirSucursal, Suc.telefono AS TelSucursal ,Con.pag_total,Con.pag_subtotal,e_costoContrato
                    FROM contrato_mov_tbl AS Con 
                    INNER JOIN contratos_tbl AS Cot on Con.id_contrato = Cot.id_Contrato AND Cot.sucursal=$sucursal
                    INNER JOIN cliente_tbl AS Cli on Cot.id_Cliente = Cli.id_Cliente AND Cli.sucursal=$sucursal
                    INNER JOIN bit_cierrecaja AS Bit on Con.id_cierreCaja = Bit.id_CierreCaja AND Bit.sucursal=$sucursal
                    INNER JOIN usuarios_tbl AS Usu on Bit.usuario = Usu.id_User 
                    INNER JOIN cat_sucursal AS Suc on Con.sucursal = Suc.id_Sucursal 
                    WHERE Con.id_Contrato =$idContrato AND Con.sucursal=$sucursal 
                     AND Bit.sucursal=$sucursal";
                        if($ultimoMovimiento!=0){
                            $query .= " and Con.id_movimiento = $ultimoMovimiento";
                        }
                    $query .= " ORDER BY id_movimiento DESC LIMIT 1";
                        //echo $query;
$resultado = $db->query($query);


foreach ($resultado as $row) {
    $id_Recibo = $row["id_movimiento"];
    $NombreCompleto = $row["NombreCompleto"];
    $prestamo = $row["total_Prestamo"];
    $descuentoAplicado = $row["s_descuento_aplicado"];
    $efectivo = $row["pag_efectivo"];
    $cambio = $row["pag_cambio"];
    $Fecha_Almoneda = $row["fechaAlmoneda"];
    $Fecha_Vencimiento = $row["fechaVencimiento"];
    $Fecha_Creacion = $row["fecha_Movimiento"];
    $NombreUsuario = $row["NombreUsuario"];
    $NombreSucursal = $row["NombreSucursal"];
    $NombreCasa = $row["NombreCasa"];
    $rfc = $row["rfc"];
    $DirSucursal = $row["DirSucursal"];
    $TelSucursal = $row["TelSucursal"];
    $Total = $row["pag_total"];
    $subTotal = $row["pag_subtotal"];
    $CostoContrato = $row["e_costoContrato"];
    $subTotal= round($subTotal,2);
    $CostoContrato= round($CostoContrato,2);
    $Total= round($Total,2);
    $descuentoAplicado= round($descuentoAplicado,2);
}

if($tipoReporte==1){
    $nombreReporteAr="REFRENDO";
    $nombreReporte="REFRENDO";

}else{
    $nombreReporte="DESEMPEÑO";
    $nombreReporteAr="DESEMPENO";
}
$query = "SELECT  Ar.descripcionCorta AS DescripcionCorta,  Ar.observaciones AS Obs
                    FROM contratos_tbl as Con 
                    INNER JOIN articulo_tbl as Ar on Con.id_Contrato =  Ar.id_Contrato AND Ar.sucursal= $sucursal
                    WHERE Con.id_Contrato =$idContrato AND Con.sucursal= $sucursal";
$tablaArt = $db->query($query);
$tablaArticulos = '';
$detallePiePagina = '';
foreach ($tablaArt as $row) {
    //Tabla MEt
    $DescripcionCorta = $row["DescripcionCorta"];
    $observaciones = $row["Obs"];
    $detallePiePagina .= $DescripcionCorta . '/' . $observaciones;

}

$prestamo = number_format($prestamo, 2,'.',',');
$descuentoAplicado = number_format($descuentoAplicado, 2,'.',',');
$efectivo = number_format($efectivo, 2,'.',',');
$cambio = number_format($cambio, 2,'.',',');
$Total = number_format($Total, 2,'.',',');
$subTotal = number_format($subTotal, 2,'.',',');
$CostoContrato = number_format($CostoContrato, 2,'.',',');

$Fecha_Creacion = date("d-m-Y", strtotime($Fecha_Creacion));
$Fecha_Almoneda = date("d-m-Y", strtotime($Fecha_Almoneda));
$Fecha_Vencimiento = date("d-m-Y", strtotime($Fecha_Vencimiento));


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
          font-size: .5em;
          font-weight: bold;
         }
          .letraChicaNegrita{
          font-size: .3em;
          font-weight: bold;
         }
          .letraNormal{
          font-size: .4em;
         }
          .letraGrande{
          font-size: .5em;
         }
          .letraChica{
          font-size: .3em;
         }
         
         .tableColl {
        border-collapse: collapse;
        }
        .tdAlto{
        height: 10px;
        }
        .tituloCelda{
          background-color: #ebebe0
        }
    </style>
</head>
<body>
<form>';
$contenido .= '<table width="100%" border="1">
        <tbody>
        <tr>
        <td align="center" >
         <table width="100%" border="0" class="letraNormalNegrita">
                <tr>
                    <td colspan="3" align="center">
                        <label> '. $NombreCasa .'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label ID="sucursal">SUCURSAL: '. $NombreSucursal .'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label ID="sucursalDir">'. $DirSucursal .'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label ID="sucursalTel">Tel: '. $TelSucursal .'</label>
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
                        <label>'. $nombreReporte .'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label> ****************** </label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label id="idContrato">CONTRATO NO: '. $idContrato.' </label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <label id="id_Recibo">RECIBO NO: '. $id_Recibo.'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left">
                        <label id="idFechaHoy">FECHA: '. $Fecha_Creacion.'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left">
                        <label id="idCliente">CLIENTE: '. $NombreCompleto.'</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>PRÉSTAMO:</label></td>
                    <td align="right"><label>$ '.$prestamo.'</label></td>
                </tr>
        
                <tr>
                    <td colspan="2" align="right"><label>GASTOS ADMINISTRACIÓN:</label></td>
                    <td align="right"><label>$ '.$CostoContrato.'</label></td>
                </tr>
               
                 <tr>
                    <td colspan="2" align="right"><label>DESC. APLICADO:</label></td>
                    <td align="right"><label>$ '.$descuentoAplicado.'</label></td>
                </tr>
                 <tr>
                    <td colspan="2"><label></label></td>
                    <td align="right"><label>-------------</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>SUBTOTAL:</label></td>
                    <td align="right"><label>$ '.$subTotal.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>TOTAL:</label></td>
                    <td align="right"><label>$ '.$Total.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>EFECTIVO:</label></td>
                    <td align="right"><label>$ '.$efectivo.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>CAMBIO:</label></td>
                    <td align="right"><label>$ '.$cambio.'</label></td>
                </tr>
                 <tr>
                    <td colspan="3" align="center">____________________________________</td>
                </tr>
                <tr>
                <td>
                &nbsp;
                </td>
                </tr>
                <tr>
                    <td colspan="3" align="left"><label id="idDetalle">'.$detallePiePagina.'</label></td>
                </tr>
                <tr>
                    <td colspan="3"><label id="idUsuario">Usuario: '.$NombreUsuario.'</label></td>
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
$nombreContrato = $nombreReporteAr.'_Num_' . $id_Recibo . ".pdf";
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
