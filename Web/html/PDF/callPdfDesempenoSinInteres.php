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

if (isset($_GET['contrato'])) {
    $idContrato = $_GET['contrato'];
}
if (isset($_GET['ultimoMovimiento'])) {
    $ultimoMovimiento = $_GET['ultimoMovimiento'];
}else{
    $ultimoMovimiento = 0;
}


$query = "SELECT id_Recibo,CONCAT (Cli.apellido_Mat, ' ',Cli.apellido_Pat,' ', Cli.nombre) as NombreCompleto,prestamo,abonoCapital, 
                    intereses, almacenaje, seguro, desempeñoExt, moratorios, otrosCobros, descuentoAplicado, descuentoPuntos, iva, 
                    efectivo, cambio, mutuo, refrendo, Bit.costoContrato AS CostoContrato, Fecha_Almoneda, Fecha_Vencimiento, Bit.Fecha_Creacion,  
                    CONCAT (Usu.apellido_Pat, ' ',Usu.apellido_Mat,' ', Usu.nombre) as NombreUsuario, Suc.Nombre AS NombreSucursal, 
                    Suc.direccion AS DirSucursal, Suc.telefono AS TelSucursal 
                    FROM bit_pagos AS Bit 
                    INNER JOIN cliente_tbl AS Cli on Bit.id_Cliente = Cli.id_Cliente 
                    INNER JOIN usuarios_tbl AS Usu on Bit.usuario = Usu.id_User 
                    INNER JOIN cat_sucursal AS Suc on Bit.sucursal = Suc.id_Sucursal 
                     WHERE Bit.id_Contrato =$idContrato";
                    if($ultimoMovimiento!=0){
                        $query .= " and Bit.ultimoMovimiento = $ultimoMovimiento ";
                    }
                    $query .= " ORDER BY id_Recibo DESC LIMIT 1";
$resultado = $mysql->query($query);


foreach ($resultado as $row) {

    $NombreSucursal = $row["NombreSucursal"];
    $DirSucursal = $row["DirSucursal"];
    $TelSucursal = $row["TelSucursal"];
    $id_Recibo = $row["id_Recibo"];
    $Fecha_Creacion = $row["Fecha_Creacion"];
    $NombreCompleto = $row["NombreCompleto"];
    $prestamo = $row["prestamo"];
    $abonoCapital = $row["abonoCapital"];
    $intereses = $row["intereses"];
    $almacenaje = $row["almacenaje"];
    $seguro = $row["seguro"];
    $desempeñoExt = $row["desempeñoExt"];
    $moratorios = $row["moratorios"];
    $otrosCobros = $row["otrosCobros"];
    $descuentoAplicado = $row["descuentoAplicado"];
    $descuentoPuntos = $row["descuentoPuntos"];
    $iva = $row["iva"];
    $efectivo = $row["efectivo"];
    $cambio = $row["cambio"];
    $mutuo = $row["mutuo"];
    $refrendo = $row["refrendo"];
    $CostoContrato = $row["CostoContrato"];
    $Fecha_Almoneda = $row["Fecha_Almoneda"];
    $Fecha_Vencimiento = $row["Fecha_Vencimiento"];
    $NombreUsuario = $row["NombreUsuario"];

    $subTotal =   $prestamo;

    $intereses= round($intereses,2);
    $almacenaje= round($almacenaje,2);
    $seguro= round($seguro,2);
    $desempeñoExt= round($desempeñoExt,2);
    $moratorios= round($moratorios,2);
    $otrosCobros= round($otrosCobros,2);
    $descuentoAplicado= round($descuentoAplicado,2);
    $descuentoPuntos= round($descuentoPuntos,2);
    $CostoContrato= round($CostoContrato,2);
    $subTotal= round($subTotal,2);
    $iva= round($iva,2);
    $Total = $subTotal +$CostoContrato +$iva ;
    $Total= round($Total,2);


}

$query = "SELECT ET.descripcion AS TipoElectronico, EM.descripcion AS MarcaElectronico, EMOD.descripcion AS ModeloElectronico,
                            Ar.detalle AS Detalle, TA.descripcion AS TipoMetal, TK.descripcion as Kilataje,
                            TC.descripcion as Calidad FROM contrato_tbl as Con 
                            INNER JOIN articulo_tbl as Ar on Con.id_Contrato =  Ar.id_Contrato
                            LEFT JOIN cat_electronico_tipo as ET on Ar.tipo = ET.id_tipo
                            LEFT JOIN cat_electronico_marca as EM on Ar.marca = EM.id_marca
                            LEFT JOIN cat_electronico_modelo as EMOD on Ar.modelo = EMOD.id_modelo
                            LEFT JOIN cat_tipoarticulo as TA on AR.tipo = TA.id_tipo
                            LEFT JOIN cat_kilataje as TK on AR.kilataje = TK.id_Kilataje
                            LEFT JOIN cat_calidad as TC on AR.calidad = TC.id_calidad
                            WHERE Con.id_Contrato =$idContrato ";
$tablaArt = $mysql->query($query);
$tablaArticulos = '';
$detallePiePagina = '';
foreach ($tablaArt as $row) {
    //Tabla MEt
    $TipoMetal = $row["TipoMetal"];
    $Kilataje = $row["Kilataje"];
    $Calidad = $row["Calidad"];
    $Detalle = $row["Detalle"];
    $tipoDescripcion ='';
    $detalleDescripcion ='';

    if ($Kilataje==''||$Kilataje==null){
        $tipoDescripcion = 'Electronicos';
        $TipoElectronico = $row["TipoElectronico"];
        $MarcaElectronico = $row["MarcaElectronico"];
        $ModeloElectronico = $row["ModeloElectronico"];
        $detalleDescripcion = $TipoElectronico . ' '. $MarcaElectronico  . ' '. $ModeloElectronico . ' '. $Detalle;
        $detallePiePagina .= $detalleDescripcion . '//';
    }else{
        $tipoDescripcion = 'Metales';
        $TipoMetal = $row["TipoMetal"];
        $Calidad = $row["Calidad"];
        $detalleDescripcion = $TipoMetal . ' '. $Kilataje  . ' '. $Calidad . ' '. $Detalle;
        $detallePiePagina .= $detalleDescripcion . '/';
    }
}


$prestamo = number_format($prestamo, 2,'.',',');
$abonoCapital = number_format($abonoCapital, 2,'.',',');
$intereses = number_format($intereses, 2,'.',',');
$almacenaje = number_format($almacenaje, 2,'.',',');
$seguro = number_format($seguro, 2,'.',',');
$desempeñoExt = number_format($desempeñoExt, 2,'.',',');
$moratorios = number_format($moratorios, 2,'.',',');
$otrosCobros = number_format($otrosCobros, 2,'.',',');
$descuentoAplicado = number_format($descuentoAplicado, 2,'.',',');
$descuentoPuntos = number_format($descuentoPuntos, 2,'.',',');
$iva = number_format($iva, 2,'.',',');
$efectivo = number_format($efectivo, 2,'.',',');
$cambio = number_format($cambio, 2,'.',',');
$mutuo = number_format($mutuo, 2,'.',',');
$refrendo = number_format($refrendo, 2,'.',',');
$CostoContrato = number_format($CostoContrato, 2,'.',',');
$subTotal = number_format($subTotal, 2,'.',',');

$Total = number_format($Total, 2,'.',',');


$Fecha_Creacion = date("d-m-Y", strtotime($Fecha_Creacion));
$Fecha_Almoneda = date("d-m-Y", strtotime($Fecha_Almoneda));
$Fecha_Vencimiento = date("d-m-Y", strtotime($Fecha_Vencimiento));

if (!isset($_GET['pdf'])) {
    $contenido = '<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../../JavaScript/funcionesRefrendo.js"></script>
    <style>
        .letraNormalNegrita {
            font-size: 1.2em;
            font-weight: bold;
        }

        .letraGrandeNegrita {
            font-size: 1.6em;
            font-weight: bold;
        }

        .letraChicaNegrita {
            font-size: .8em;
            font-weight: bold;
        }

        .letraNormal {
            font-size: 1.2em;
        }

        .letraGrande {
            font-size: 1.6em;
        }

        .letraChica {
            font-size: .8em;
        }
         .btn{
        color: #0099CC;
        background: transparent;
        border: 2px solid #0099CC;
        border-radius: 6px;
      padding: 16px 32px;
      text-align: center;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      -webkit-transition-duration: 0.4s; /* Safari */
      transition-duration: 0.4s;
      cursor: pointer;
      text-decoration: none;
      text-transform: uppercase;
}
        }
        .btnGenerarPDF {
        background-color: white; 
        color: black; 
        border: 2px solid #008CBA;
        }
        .btnGenerarPDF:hover {
        background-color: #008CBA;
        color: white;
        }
        
        .borderBlue{
        border-style: solid;
         border-color: dodgerblue;
          border-collapse: collapse;
        }
        
        .tdborderBlue{
        border-style: solid;
         border-color: dodgerblue;
          border-collapse: collapse;
            padding: 10px;
        }
    </style>
</head>
<body >
<form align="center">';
    $contenido .= '<table width="30%" border="1">
        <tbody>
        <tr>
        <td align="center" >
         <table width="=100%" border="0">
                <tr>
                    <td colspan="3" align="center">
                        <label>MIRIAM GAMA VAZQUEZ</label>
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
                        <label ID="sucursalRfc">RFC: GAVM800428KQ3</label>
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
                        <label>DESEMPEÑO</label>
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
                 <tr><td><br></td></tr>
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
                 <tr><td><br></td></tr>
                <tr>
                    <td colspan="2" align="right"><label>PRÉSTAMO:</label></td>
                    <td align="right"><label>$ '.$prestamo.'</label></td>
                </tr>
         
                <tr>
                    <td colspan="2" align="right"><label>INTERESES:</label></td>
                    <td align="right"><label>$ '.$intereses.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>ALMACENAJE:</label></td>
                    <td align="right"><label>$ '.$almacenaje.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>SEGURO:</label></td>
                    <td align="right"><label>$ '.$seguro.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>DESEMPEÑO EXT.:</label></td>
                    <td align="right"><label>$ '.$desempeñoExt.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>MORATORIOS:</label></td>
                    <td align="right"><label>$ '.$moratorios.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>OTROS COBROS:</label></td>
                    <td align="right"><label>$ '.$otrosCobros.'</label></td>
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
                    <td colspan="2" align="right"><label>COSTO DE CONTRATO:</label></td>
                    <td align="right"><label>$ '.$CostoContrato.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>IVA:</label></td>
                    <td align="right"><label>$ '.$iva.'</label></td>
                </tr>
               
                <tr>
                    <td colspan="2" align="right"><label>DESC. X Puntos:</label></td>
                    <td align="right"><label>$ '.$descuentoPuntos.'</label></td>
                </tr>
                 <tr>
                    <td colspan="2"><label></label></td>
                    <td align="right"><label>-------------</label></td>
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
                    <td colspan="3" align="center"><hr></td>
                </tr>
                <tr>
                <td>
                &nbsp;
                </td>
                </tr>
                 <tr>
                <td>
                <label>Descripción: </label>
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
    $contenido .= '<tr><td align="center" >
        <input type="button" class="btn btnGenerarPDF" value="Generar PDF"  onclick="verPDFDesempeno('.$idContrato.');" >
        </td></tr>';
    $contenido .= '</tbody></table></form></body></html>';
    echo $contenido;
    exit;
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
         <table width="100%" border="0" class="letraNormalNegrita">
                <tr>
                    <td colspan="3" align="center">
                        <label>MIRIAM GAMA VAZQUEZ</label>
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
                        <label ID="sucursalRfc">RFC: GAVM800428KQ3</label>
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
                        <label>DESEMPEÑO</label>
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
                    <td colspan="2" align="right"><label>INTERESES:</label></td>
                    <td align="right"><label>$ '.$intereses.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>ALMACENAJE:</label></td>
                    <td align="right"><label>$ '.$almacenaje.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>SEGURO:</label></td>
                    <td align="right"><label>$ '.$seguro.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>DESEMPEÑO EXT.:</label></td>
                    <td align="right"><label>$ '.$desempeñoExt.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>MORATORIOS:</label></td>
                    <td align="right"><label>$ '.$moratorios.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>OTROS COBROS:</label></td>
                    <td align="right"><label>$ '.$otrosCobros.'</label></td>
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
                    <td colspan="2" align="right"><label>COSTO DE CONTRATO:</label></td>
                    <td align="right"><label>$ '.$CostoContrato.'</label></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><label>IVA:</label></td>
                    <td align="right"><label>$ '.$iva.'</label></td>
                </tr>
               
                <tr>
                    <td colspan="2" align="right"><label>DESC. X Puntos:</label></td>
                    <td align="right"><label>$ '.$descuentoPuntos.'</label></td>
                </tr>
                 <tr>
                    <td colspan="2"><label></label></td>
                    <td align="right"><label>-------------</label></td>
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

$nombreContrato = 'Desempeno Num ' . $id_Recibo . ".pdf";
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
