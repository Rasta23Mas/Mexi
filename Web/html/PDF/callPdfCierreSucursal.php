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
$NombreUsuario = $_SESSION["usuario"];

$querySucursal = "SELECT NombreCasa, Nombre FROM cat_sucursal
                    WHERE id_Sucursal =$sucursal ";


$resultadoSucursal = $db->query($querySucursal);

foreach ($resultadoSucursal as $row) {
    $NombreCasa = $row["NombreCasa"];
    $Nombre = $row["Nombre"];
}

$folioCierreSucursal = 0;
if (isset($_GET['folioCierreSucursal'])) {
    $folioCierreSucursal = $_GET['folioCierreSucursal'];
}



$queryCierreCaja = "SELECT * FROM bit_cierresucursal
                    WHERE folio_CierreSucursal =$folioCierreSucursal AND sucursal=$sucursal";
$resultado = $db->query($queryCierreCaja);


foreach ($resultado as $row) {
    $id_CierreSucursal = $row["id_CierreSucursal"];
    $saldo_Inicial = $row["saldo_Inicial"];
    $dotacionesA_Caja = $row["dotacionesA_Caja"];
    $CantAportacionesBoveda = $row["CantAportacionesBoveda"];
    $aportaciones_Boveda = $row["aportaciones_Boveda"];
    $CantCapitalRecuperado = $row["CantCapitalRecuperado"];
    $capitalRecuperado = $row["capitalRecuperado"];
    $CantAbono = $row["CantAbono"];
    $abonoCapital = $row["abonoCapital"];
    $intereses = $row["intereses"];
    $CantCostoContrato = $row["CantCostoContrato"];
    $costoContrato = $row["costoContrato"];
    $iva = $row["iva"];
    $CantVentasMostrador = $row["CantVentasMostrador"];
    $mostrador = $row["mostrador"];
    $iva_venta = $row["iva_venta"];
    $utilidadVenta = $row["utilidadVenta"];
    $CantApartados = $row["CantApartados"];
    $apartados = $row["apartados"];
    $CantAbonoVentas = $row["CantAbonoVentas"];
    $abonoVentas = $row["abonoVentas"];
    $gps = $row["gps"];
    $poliza = $row["poliza"];
    $pension = $row["pension"];
    $CantAjustes = $row["CantAjustes"];
    $ajustes = $row["ajustes"];

    $CantRefrendoMig = $row["CantRefMig"];
    $refrendoMig = $row["refrendoMig"];

    $CantRetirosCaja = $row["CantRetirosCaja"];
    $retirosCaja = $row["retirosCaja"];
    $CantRetirosBoveda = $row["CantRetirosBoveda"];
    $retiros_boveda = $row["retiros_boveda"];
    $CantPrestamosNuevos = $row["CantPrestamosNuevos"];
    $prestamosNuevos = $row["prestamosNuevos"];
    $CantDescuentos = $row["CantDescuentos"];
    $descuentosAplicados = $row["descuentosAplicados"];
    $CantDescuentosVentas = $row["CantDescuentosVentas"];
    $descuentos_ventas = $row["descuentos_ventas"];
    $CantIncremento = $row["CantIncremento"];
    $incrementoPatrimonio = $row["incrementoPatrimonio"];
    $total_Entrada = $row["total_Entrada"];
    $totalIVA = $row["totalIVA"];
    $total_Salida = $row["total_Salida"];
    $saldo_final = $row["saldo_final"];
    $InfoSaldoInicial = $row["InfoSaldoInicial"];
    $InfoEntradas = $row["InfoEntradas"];
    $InfoSalidas = $row["InfoSalidas"];
    $InfoSaldoFinal = $row["InfoSaldoFinal"];
    $InfoApartados = $row["InfoApartados"];
    $InfoAbono = $row["InfoAbono"];
    $InfoTotalInventario = $row["InfoTotalInventario"];
    $usuario = $row["usuario"];
    $sucursal = $row["sucursal"];
    $fecha_Creacion = $row["fecha_Creacion"];
    $estatus = $row["estatus"];
}

$saldo_Inicial = number_format($saldo_Inicial, 2, '.', ',');
$dotacionesA_Caja = number_format($dotacionesA_Caja, 2, '.', ',');
$aportaciones_Boveda = number_format($aportaciones_Boveda, 2, '.', ',');
$capitalRecuperado = number_format($capitalRecuperado, 2, '.', ',');
$abonoCapital = number_format($abonoCapital, 2, '.', ',');
$intereses = number_format($intereses, 2, '.', ',');
$costoContrato = number_format($costoContrato, 2, '.', ',');
$iva = number_format($iva, 2, '.', ',');
$mostrador = number_format($mostrador, 2, '.', ',');
$iva_venta = number_format($iva_venta, 2, '.', ',');
$utilidadVenta = number_format($utilidadVenta, 2, '.', ',');
$apartados = number_format($apartados, 2, '.', ',');
$abonoVentas = number_format($abonoVentas, 2, '.', ',');
$gps = number_format($gps, 2, '.', ',');
$poliza = number_format($poliza, 2, '.', ',');
$pension = number_format($pension, 2, '.', ',');
$ajustes = number_format($ajustes, 2, '.', ',');
$refrendoMig = number_format($refrendoMig, 2, '.', ',');
$retirosCaja = number_format($retirosCaja, 2, '.', ',');
$retiros_boveda = number_format($retiros_boveda, 2, '.', ',');
$prestamosNuevos = number_format($prestamosNuevos, 2, '.', ',');
$descuentosAplicados = number_format($descuentosAplicados, 2, '.', ',');
$descuentos_ventas = number_format($descuentos_ventas, 2, '.', ',');
$incrementoPatrimonio = number_format($incrementoPatrimonio, 2, '.', ',');
$total_Entrada = number_format($total_Entrada, 2, '.', ',');
$totalIVA = number_format($totalIVA, 2, '.', ',');
$total_Salida = number_format($total_Salida, 2, '.', ',');
$saldo_final = number_format($saldo_final, 2, '.', ',');
$InfoSaldoInicial = number_format($InfoSaldoInicial, 2, '.', ',');
$InfoEntradas = number_format($InfoEntradas, 2, '.', ',');
$InfoSalidas = number_format($InfoSalidas, 2, '.', ',');
$InfoSaldoFinal = number_format($InfoSaldoFinal, 2, '.', ',');
$InfoApartados = number_format($InfoApartados, 2, '.', ',');
$InfoAbono = number_format($InfoAbono, 2, '.', ',');
$InfoTotalInventario = number_format($InfoTotalInventario, 2, '.', ',');


$saldo_Inicial = "$" . $saldo_Inicial;
$dotacionesA_Caja = "$" . $dotacionesA_Caja;
$aportaciones_Boveda = "$" . $aportaciones_Boveda;
$capitalRecuperado = "$" . $capitalRecuperado;
$abonoCapital = "$" . $abonoCapital;
$intereses = "$" . $intereses;
$costoContrato = "$" . $costoContrato;
$iva = "$" . $iva;
$mostrador = "$" . $mostrador;
$iva_venta = "$" . $iva_venta;
$utilidadVenta = "$" . $utilidadVenta;
$apartados = "$" . $apartados;
$abonoVentas = "$" . $abonoVentas;
$gps = "$" . $gps;
$poliza = "$" . $poliza;
$pension = "$" . $pension;
$ajustes = "$" . $ajustes;
$refrendoMig = "$" . $refrendoMig;
$retirosCaja = "$" . $retirosCaja;
$retiros_boveda = "$" . $retiros_boveda;
$prestamosNuevos = "$" . $prestamosNuevos;
$descuentosAplicados = "$" . $descuentosAplicados;
$descuentos_ventas = "$" . $descuentos_ventas;
$incrementoPatrimonio = "$" . $incrementoPatrimonio;
$total_Entrada = "$" . $total_Entrada;
$totalIVA = "$" . $totalIVA;

$total_Salida = "$" . $total_Salida;
$saldo_final = "$" . $saldo_final;
$InfoSaldoInicial = "$" . $InfoSaldoInicial;
$InfoEntradas = "$" . $InfoEntradas;
$InfoSalidas = "$" . $InfoSalidas;
$InfoSaldoFinal = "$" . $InfoSaldoFinal;
$InfoApartados = "$" . $InfoApartados;
$InfoAbono = "$" . $InfoAbono;
$InfoTotalInventario = "$" . $InfoTotalInventario;

$contenido = '<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <style>
          .letraGrandeNegrita{
          font-size: .6em;
          font-weight: bold;
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

        .titleTable {
            background: dodgerblue;
            color: white;
        }

        .titleTableEntrada {
            background: #33cc33;
            color: white;
        }

        .titleTableSalida {
            background: #ff0000;
            color: white;
        }

     
        

.tableCierre {
    border-collapse: collapse;
}
.tableTDCierre  {
    border-left: 0.01em solid #ccc;
    border-right: 0.01em solid #ccc;
    border-top: 0.01em solid #ccc;
    border-bottom: 0.01em solid #ccc;
}
    </style>
</head>
<body>
<form>';
$contenido .= '
<table align="center" border="0" WIDTH="100%" class="letraGrandeNegrita tableTDCierre">
    <tbody class="tableTDCierre">
        <tr>
            <th style="width:5%;"></th>
            <th style="width:30%;"></th>
            <th style="width:15%;"></th>
            <th style="width:5%;"></th>
            <th style="width:25%;"></th>
            <th style="width:20%;"></th>
        </tr>
        <tr>
            <td colspan="6" align="center" >
                <label>' . $NombreCasa . '</label>
            </td>
        </tr>
        <tr>
            <td colspan="6" align="center" >
                <label ID="sucursal">SUCURSAL: ' . $Nombre . '</label>
            </td>
        </tr>
        <tr>
            <td colspan="6" align="center">
                <label >&nbsp;&nbsp;CIERRE DE SUCURSAL</label>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <br>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label>&nbsp;&nbsp;&nbsp;SALDO INICIAL:</label>
            </td>
            <td >
                <label>' . $saldo_Inicial . '</label>
            </td>
            <td colspan="3" class="titleTable tableTDCierre">
                <label>&nbsp;&nbsp;&nbsp;RETIROS DE EFECTIVO</label>
            </td>
        </tr>
        <tr>
            <td  colspan="2" >
                <label>&nbsp;&nbsp;&nbsp;DOTACIONES A CAJA:</label>
            </td>
            <td >
                <label>' . $dotacionesA_Caja . '</label>
            </td>
            <td align="center">
                <label>' . $CantRetirosCaja . '</label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;RETIROS A CAJA:</label>
            </td>
            <td >
                <label>' . $retirosCaja . '</label>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <br>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="titleTableEntrada" align="center">
                <label>&nbsp;&nbsp;&nbsp;ENTRADAS</label>
            </td>
            <td colspan="3" class="titleTableSalida" align="center">
                <label>&nbsp;&nbsp;&nbsp;SALIDAS</label>
            </td>
        </tr>
        <tr>
            <td colspan="6"><br></td>
        </tr>
        <tr>
            <td align="center">
                <label>' . $CantAportacionesBoveda . '</label>
            </td>
            <td>
                <label>&nbsp;&nbsp;&nbsp;APORTACIONES BÓVEDA:</label>
            </td>
            <td >
                <label>' . $aportaciones_Boveda . '</label>
            </td>
            <td align="center">
                <label>' . $CantRetirosBoveda . '</label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;RETIROS A BÓVEDA:</label>
            </td>
            <td >
                <label>' . $retiros_boveda . '</label>
            </td>
        </tr>
        <tr>
            <td align="center">
                <label>' . $CantCapitalRecuperado . '</label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;CAPITAL RECUPERADO:</label>
            </td>
            <td >
               <label>' . $capitalRecuperado . '</label>
            </td>
            <td align="center">
               <label>' . $CantPrestamosNuevos . '</label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;PRÉSTAMOS NUEVOS:</label>
            </td>
            <td >
                <label>' . $prestamosNuevos . '</label>
            </td>
        </tr>
        <tr>
            <td align="center">
                <label>' . $CantAbono . '</label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;ABONO A CAPITAL:</label>
            </td>
            <td >
               <label>' . $abonoCapital . '</label>
            </td>
            <td align="center">
               <label>' . $CantDescuentos . '</label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;DESC. APLICADOS:</label>
            </td>
            <td >
                <label>' . $descuentosAplicados . '</label>
            </td>
        </tr>
        <tr>
            <td >
               <label></label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;INTERESES:</label>
            </td>
            <td>
               <label>' . $intereses . '</label>
            </td>
            <td align="center">
               <label>' . $CantDescuentosVentas . '</label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;DESC. VENTAS:</label>
            </td>
            <td >
               <label>' . $descuentos_ventas . '</label>
            </td>
        </tr>
        <tr>
            <td align="center">
                <label>' . $CantCostoContrato . '</label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;COSTO CONTRATO:</label>
            </td>
            <td >
               <label>' . $costoContrato . '</label>
            </td>
            <td align="center">
               <label>' . $CantIncremento . '</label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;INCREMENTO PAT.:</label>
            </td>
            <td >
                <label>' . $incrementoPatrimonio . '</label>
            </td>
        </tr>
        <tr>
            <td >
                <label></label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;I.V.A. :</label>
            </td>
            <td >
              <label>' . $iva . '</label>
            </td>
            <td colspan="3" class="titleTable ">
                <label>&nbsp;&nbsp;&nbsp;TOTALES</label>
            </td>
        </tr>
        <tr>
            <td align="center">
                <label>' . $CantVentasMostrador . '</label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;VENTAS MOSTRADOR:</label>
            </td>
            <td >
               <label>' . $mostrador . '</label>
            </td>
            <td colspan="2">
                <b><label>&nbsp;&nbsp;&nbsp;TOTAL ENTRADAS:</label>
            </td>
            <td >
                <label>' . $total_Entrada . '</label>
            </td>
        </tr>
        <tr>
            <td >
                <label></label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;IVA VENTAS:</label>
            </td>
            <td >
               <label>' . $iva_venta . '</label>
            </td>
            <td  colspan="2">
                <b><label>&nbsp;&nbsp;&nbsp;TOTAL IVA:</label>
            </td>
            <td >
                <label>' . $totalIVA . '</label>
            </td>
        </tr>
        <tr>
            <td >
                <br>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;UTILIDAD VENTA:</label>
            </td>
            <td  >
               <label>' . $utilidadVenta . '</label>
            </td>
            <td  colspan="2">
                <b><label>&nbsp;&nbsp;&nbsp;TOTAL SALIDAS:</label>
            </td>
            <td >
               <label>' . $total_Salida . '</label>
            </td>
        </tr>
        <tr>
            <td align="center">
              <label>' . $CantApartados . '</label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;APARTADOS:</label>
            </td>
            <td >
                <label>' . $apartados . '</label>
            </td>
            <td colspan="2">
                <b><label>&nbsp;&nbsp;&nbsp;SALDO FINAL:</label>
            </td>
            <td >
                <label>' . $saldo_final . '</label>
            </td>
        </tr>
        <tr>
            <td align="center">
                <label>' . $CantAbonoVentas . '</label>
            </td>
            <td>
                <label>&nbsp;&nbsp;&nbsp;ABONO:</label>
            </td>
            <td >
               <label>' . $abonoVentas . '</label>
            </td>
        
            <td  colspan="3">
                <br>
            </td>
        </tr>
        <tr>
            <td >
               <label></label>
            </td>
            <td>
                <label>&nbsp;&nbsp;&nbsp;GPS:</label>
            </td>
            <td >
               <label>' . $gps . '</label>
            </td>
            <td colspan="3" class="titleTable ">
                <label>&nbsp;&nbsp;&nbsp;INFORMATIVOS</label>
            </td>
        </tr>
        <tr>
            <td >
                <label></label>
            </td>
            <td >
                <label>&nbsp;&nbsp;&nbsp;POLIZA:</label>
            </td>
            <td >
                <label>' . $poliza . '</label>
            </td>
            <td class="tableTDCierre"  colspan="2">
                <label>&nbsp;&nbsp;&nbsp;SALDO INICIAL:</label>
            </td>
           <td class="tableTDCierre" >
               <label>' . $InfoSaldoInicial . '</label>
            </td>
        </tr>
        <tr>
            <td >
                <label></label>
            </td>
            <td  >
                <label>&nbsp;&nbsp;&nbsp;PENSION:</label>
            </td>
            <td >
                <label>' . $pension . '</label>
            </td>
            <td class="tableTDCierre"  colspan="2">
                <label>&nbsp;&nbsp;&nbsp;ENTRADAS:</label>
            </td>
            <td class="tableTDCierre" >
                <label>' . $InfoEntradas . '</label>
            </td>
        </tr>
        <tr>
            <td align="center">
                <label>' . $CantAjustes . '</label>
            </td>
            <td  >
                <label>&nbsp;&nbsp;&nbsp;AJUSTES:</label>
            </td>
            <td >
                <label>' . $ajustes . '</label>
            </td>
            <td colspan="2" class="tableTDCierre" >
                <label>&nbsp;&nbsp;&nbsp;SALIDAS:</label>
            </td>
            <td class="tableTDCierre" >
               <label>' . $InfoSalidas . '</label>
            </td>
        </tr>
        <tr>
             <td align="center">
                <label>' . $CantRefrendoMig . '</label>
            </td>
            <td  >
                <label>&nbsp;&nbsp;&nbsp;REFRENDO MIGRACIÓN:</label>
            </td>
            <td >
                <label>' . $refrendoMig . '</label>
            </td>
            <td colspan="2" class="tableTDCierre" >
                <label>&nbsp;&nbsp;&nbsp;SALDO FINAL:</label>
            </td>
           <td class="tableTDCierre" >
                <label>' . $InfoSaldoFinal . '</label>
            </td>
        </tr>
        <tr>
            <td  colspan="3">
                <label></label>
            </td>
            <td  class="tableTDCierre"  colspan="2">
                <label>&nbsp;&nbsp;&nbsp;APARTADOS:</label>
            </td>
            <td class="tableTDCierre" >
                <label>' . $InfoApartados . '</label>
            </td>
        </tr>
        <tr>
            <td  colspan="3">
                <label></label>
            </td>
            <td class="tableTDCierre"  colspan="2">
                <label>&nbsp;&nbsp;&nbsp;ABONOS:</label>
            </td>
            <td class="tableTDCierre" >
                <label>' . $InfoAbono . '</label>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <label></label>
            </td>
            <td class="tableTDCierre"  colspan="2">
                <label>&nbsp;&nbsp;&nbsp;TOTAL INVENTARIO:</label>
            </td>
            <td class="tableTDCierre">
                <label>' . $InfoTotalInventario . '</label>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <br>
            </td>
        </tr>  ';
$contenido .= '</tbody></table></form></body></html>';
//echo $contenido;
//exit();
$nombreContrato = 'Cierre_Sucursal_Num ' . $folioCierreSucursal . ".pdf";
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
if($sucursal==1){
    $dompdf->setPaper('letter', 'portrait');

}else if($sucursal==2){
    $dompdf->setPaper('letter', 'portrait');

}
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
