<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
require_once(WEB_PATH . "dompdf/autoload.inc.php");

use Dompdf\Dompdf;


if (!isset($_SESSION)) {
    session_start();
}
$usuario = $_SESSION["idUsuario"];
$sucursal = $_SESSION["sucursal"];
$NombreUsuario = $_SESSION["usuario"];


$web = 2;
if ($web == 1) {
    $server = "localhost";
    $user = "u672450412_root";
    $password = "12345";
    $db = "u672450412_Mexicash";
} else {
    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "mexicash";
}

$mysql = new  mysqli($server, $user, $password, $db);

$querySucursal = "SELECT NombreCasa, Nombre FROM cat_sucursal
                    WHERE id_Sucursal =$sucursal ";

$resultadoSucursal = $mysql->query($querySucursal);


foreach ($resultadoSucursal as $row) {
    $NombreCasa = $row["NombreCasa"];
    $Nombre = $row["Nombre"];
}

$folioCierreSucursal = 0;
if (isset($_GET['folioCierreSucursal'])) {
    $folioCierreSucursal = $_GET['folioCierreSucursal'];
}

$CerradoNombreUsuario = "";


$queryCierreCaja = "SELECT * FROM bit_cierresucursal
                    WHERE folio_CierreSucursal =$folioCierreSucursal ";

$resultado = $mysql->query($queryCierreCaja);


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



if (!isset($_GET['pdf'])) {
    $contenido = '<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
            <script src="../../JavaScript/funcionesCierres.js"></script>

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

        .primeraColTotales {
            width: 75px;
            text-align: right;
        }

        .espacioEnmedio {
            width: 50px;
        }

        .terceraCol {
            text-align: right;
        }

        .primeraCol {
            width: 75px;
            text-align: center;
        }

        .segundaCol {
            width: 200px;
        }

        .terceraCol {
            width: 100px;
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
<body >
<form align="center">';
    $contenido .= '<table width="60%" align="center">
        <tbody>
        <tr>
            <td align="center" >
                <table width="100%" border="0">
                <tr>
                    <td colspan="7" align="center" class="letraGrandeNegrita">
                        <label>' . $NombreCasa . '</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" align="center" class="letraGrandeNegrita">
                        <label ID="sucursal">SUCURSAL: ' . $Nombre . '</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="left">
                        <label class="letraGrandeNegrita">&nbsp;&nbsp;CIERRE DE CAJA</label>
                    </td>
                    <td colspan="3" align="right">
                        <label class="letraGrandeNegrita">' . $CerradoNombreUsuario . '</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <br>
                    </td>
                </tr>
                <tr class="letraNormalNegrita">
                        <td colspan="2" >
                            <label>&nbsp;&nbsp;&nbsp;CAJA:  ' . $id_CierreCaja . '</label>
                        </td>
                       <td colspan="3" >
                            <label>&nbsp;&nbsp;&nbsp;CAJERO:  ' . $NombreUsuario . '</label>
                        </td>
                        <td colspan="2" align="right">
                            <label>&nbsp;&nbsp;&nbsp;FECHA:  ' . $fecha_Creacion . '</label>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol">
                          <br>
                        </td>
                        <td class="segundaCol">
                           <br>
                        </td>
                        <td class="terceraCol">
                            <br>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol">
                             <br>
                        </td>
                        <td class="segundaCol">
                              <br>
                        </td>
                        <td class="terceraCol">
                               <br>
                        </td>
                    </tr>
        </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" class="tableCierre">
                <tr>
                        <td colspan="3" class="titleTable tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;DOTACIONES DE EFECTIVO</label>
                        </td>
                        <td class="espacioEnmedio" >
                            <br>
                        </td>
                        <td colspan="3" class="titleTable tableTDCierre" >
                            <label>&nbsp;&nbsp;&nbsp;RETIROS DE EFECTIVO</label>
                        </td>
                    </tr>
                <tr  >
                        <td class="primeraCol tableTDCierre"  >
                            <label> ( ' . $cantDotaciones . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre" >
                            <label>&nbsp;&nbsp;&nbsp;DOTACIONES A CAJA</label>
                        </td>
                        <td class="terceraCol tableTDCierre" >
                            <label >' . $dotacionesA_Caja . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol tableTDCierre" >
                          <label> ( ' . $cantRetiros . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre" >
                            <label>&nbsp;&nbsp;&nbsp;RETIROS A CAJA</label>
                        </td>
                        <td class="terceraCol tableTDCierre" >
                              <label >' . $retirosCaja . '</label>
                        </td>
                    </tr>
                <tr>
                        <td colspan="7"><br></td>
                    </tr>
                 <tr >
                        <td colspan="3" class="titleTableEntrada tableTDCierre" align="center">
                            <label>&nbsp;&nbsp;&nbsp;ENTRADAS</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="titleTableSalida tableTDCierre" align="center">
                            <label>&nbsp;&nbsp;&nbsp;SALIDAS</label>
                        </td>
                    </tr>
                <tr>
                        <td colspan="7"><br></td>
                    </tr>
                <tr>
                        <td colspan="3" class="titleTable tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;TRADICIONALES</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="titleTable tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;TRADICIONALES</label>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                           <label> ( ' . $cantCapitalRecuperado . ' )</label>
                        </td>
                        <td class="segundaCol  tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;CAPITAL RECUPERADO:</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                              <label >' . $capitalRecuperado . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol tableTDCierre">
                           <label> ( ' . $cantPrestamos . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;PRESTAMOS NUEVOS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                              <label >' . $prestamosNuevos . '</label>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantAbono . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;ABONO A CAPITAL:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $abonoCapital . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantDescuentos . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;DESC. APLICADOS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $descuentosAplicados . '</label>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                           <label> ( ' . $cantInteres . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;INTERESES:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                              <label >' . $intereses . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantDescuentosVentas . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;DESC. VENTAS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $descuento_Ventas . '</label>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                           <label> ( ' . $cantCostoContrato . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;COSTO CONTRATO:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $costoContrato . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                         <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantIncremento . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;INCREMENTO PAT.:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $incremento . '</label>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                           <label> ( ' . $cantIva . ' )</label>
                        </td>
                        <td class="segundaCol  tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;I.V.A. :</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                              <label >' . $iva . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" >
                            <br>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                           <label> ( ' . $cantGps . ' )</label>
                        </td>
                        <td class="segundaCol  tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;RENTA GPS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                              <label >' . $gps . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="titleTable tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;TOTALES</label>
                        </td>
                       
                </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantPoliza . ' )</label>
                        </td>
                        <td class="segundaCol  tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;POLIZA:</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                               <label >' . $poliza . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                         <td class="primeraColTotales tableTDCierre" colspan="2">
                            <label><b>&nbsp;&nbsp;&nbsp;TOTAL ENTRADAS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                              <label >' . $total_Entrada . '</label>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantPension . ' )</label>
                        </td>
                        <td class="segundaCol  tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;PENSIÓN:</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                              <label >' . $pension . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                         <td class="primeraColTotales tableTDCierre" colspan="2">
                            <label><b>&nbsp;&nbsp;&nbsp;TOTAL IVA:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                              <label >' . $total_Iva . '</label>
                        </td>
                    </tr>
                <tr>
                       <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantAjustes . ' )</label>
                        </td>
                        <td class="segundaCol  tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;AJUSTES:</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                              <label >' . $ajuste . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales tableTDCierre" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;TOTAL SALIDAS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $total_Salida . '</label>
                        </td>
    
                        </td>
                    </tr>
                <tr>
                        <td colspan="3" ></td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales tableTDCierre" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;EFECTIVO CAJA:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                              <label >' . $efectivo_Caja . '</label>
                        </td>
                    </tr>
                <tr>
                        <td colspan="3" class="titleTable tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;VENTAS</label>
                        </td>
                       
                        <td colspan="1">
                            <br>
                        </td>
                        <td class="primeraColTotales tableTDCierre" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;SALDO CAJA:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                              <label >' . $saldo_Caja . '</label>
                    </tr>
                <tr>
                <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantCapitalRecuperado . ' )</label>
                        </td>
                        <td class="segundaCol  tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;CAPITAL RECUPERADO:</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                               <label >' . $capitalRecuperado . '</label>
                        </td>
                       
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                <tr>
                 <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantIvaVenta . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;I.V.A.:</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                              <label >' . $iva_venta . '</label>
                        </td>
                        
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                <tr>
                <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantApartados . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;APARTADOS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $apartadosVentas . '</label>
                        </td>
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                    <tr>
                <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantAbonoVentas . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;ABONOS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $abonoVentas . '</label>
                        </td>
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                      <tr>
                        <td colspan="7">
                            <br>
                        </td>
                    </tr>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantRefrendos . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;* INFORM. REFRENDO:</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                               <label >' . $informeRefrendo . '</label>
                        </td>
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                <tr>
                    <td colspan="7">
                    <br>
                </td>
                </tr>
        </table>
        </td>
        </tr>';
    $contenido .= '<tr><td align="center" colspan="7">
        <input type="button" class="btn btnGenerarPDF" value="Generar PDF"  onclick="verPDFCaja(' . $folioCierreSucursal . ');" >
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

        .primeraColTotales {
            text-align: right;
        }

        .espacioEnmedio {
            width: 20px;
        }

        .primeraCol {
            width: 16px;
            text-align: center;
        }

        .segundaCol {
            width: 200px;
        }

        .terceraCol {
            width: 30px;
            text-align: right;
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
$contenido .= '<table align="center" border="0" class="letraGrandeNegrita">
        <tbody>
  
                <tr>
                    <td colspan="7" align="center" class="letraGrandeNegrita">
                        <label>' . $NombreCasa . '</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" align="center" class="letraGrandeNegrita">
                        <label ID="sucursal">SUCURSAL: ' . $Nombre . '</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="left">
                        <label class="letraGrandeNegrita">&nbsp;&nbsp;CIERRE DE CAJA</label>
                    </td>
                    <td colspan="3" align="right">
                        <label class="letraGrandeNegrita">' . $CerradoNombreUsuario . '</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <br>
                    </td>
                </tr>
                <tr class="letraGrandeNegrita">
                        <td colspan="2" >
                            <label>&nbsp;&nbsp;&nbsp;CAJA:  ' . $id_CierreCaja . '</label>
                        </td>
                       <td colspan="3" >
                            <label>&nbsp;&nbsp;&nbsp;CAJERO:  ' . $NombreUsuario . '</label>
                        </td>
                        <td colspan="2" align="right">
                            <label>&nbsp;&nbsp;&nbsp;FECHA:  ' . $fecha_Creacion . '</label>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol">
                          <br>
                        </td>
                        <td class="segundaCol">
                           <br>
                        </td>
                        <td class="terceraCol">
                            <br>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol">
                             <br>
                        </td>
                        <td class="segundaCol">
                              <br>
                        </td>
                        <td class="terceraCol">
                               <br>
                        </td>
                    </tr>
        <tr>
            <td colspan="7">
                <table align="center" class="tableCierre letraNormalNegrita">
                <tr>
                        <td colspan="3" class="titleTable tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;DOTACIONES DE EFECTIVO</label>
                        </td>
                        <td class="espacioEnmedio" >
                            <br>
                        </td>
                        <td colspan="3" class="titleTable tableTDCierre" >
                            <label>&nbsp;&nbsp;&nbsp;RETIROS DE EFECTIVO</label>
                        </td>
                    </tr>
                <tr  >
                        <td class="primeraCol tableTDCierre"  >
                            <label> ( ' . $cantDotaciones . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre" >
                            <label>&nbsp;&nbsp;&nbsp;DOTACIONES A CAJA</label>
                        </td>
                        <td class="terceraCol tableTDCierre" >
                            <label >' . $dotacionesA_Caja . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol tableTDCierre" >
                          <label> ( ' . $cantRetiros . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre" >
                            <label>&nbsp;&nbsp;&nbsp;RETIROS A CAJA</label>
                        </td>
                        <td class="terceraCol tableTDCierre" >
                              <label >' . $retirosCaja . '</label>
                        </td>
                    </tr>
                <tr>
                        <td colspan="7"><br></td>
                    </tr>
                 <tr >
                        <td colspan="3" class="titleTableEntrada tableTDCierre" align="center">
                            <label>&nbsp;&nbsp;&nbsp;ENTRADAS</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="titleTableSalida tableTDCierre" align="center">
                            <label>&nbsp;&nbsp;&nbsp;SALIDAS</label>
                        </td>
                    </tr>
                <tr>
                        <td colspan="7"><br></td>
                    </tr>
                <tr>
                        <td colspan="3" class="titleTable tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;TRADICIONALES</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="titleTable tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;TRADICIONALES</label>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                           <label> ( ' . $cantCapitalRecuperado . ' )</label>
                        </td>
                        <td class="segundaCol  tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;CAPITAL RECUPERADO:</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                              <label >' . $capitalRecuperado . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol tableTDCierre">
                           <label> ( ' . $cantPrestamos . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;PRESTAMOS NUEVOS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                              <label >' . $prestamosNuevos . '</label>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantAbono . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;ABONO A CAPITAL:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $abonoCapital . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantDescuentos . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;DESC. APLICADOS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $descuentosAplicados . '</label>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                           <label> ( ' . $cantInteres . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;INTERESES:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                              <label >' . $intereses . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantDescuentosVentas . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;DESC. VENTAS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $descuento_Ventas . '</label>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                           <label> ( ' . $cantCostoContrato . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;COSTO CONTRATO:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $costoContrato . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantIncremento . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;INCREMENTO PAT.:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $incremento . '</label>
                        </td>
                 
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                           <label> ( ' . $cantIva . ' )</label>
                        </td>
                        <td class="segundaCol  tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;I.V.A. :</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                              <label >' . $iva . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                         <td colspan="3" >

                        </td>
                   
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                           <label> ( ' . $cantGps . ' )</label>
                        </td>
                        <td class="segundaCol  tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;RENTA GPS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                              <label >' . $gps . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="titleTable tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;TOTALES</label>
                        </td>
                </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantPoliza . ' )</label>
                        </td>
                        <td class="segundaCol  tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;POLIZA:</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                               <label >' . $poliza . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                         <td class="primeraColTotales tableTDCierre" colspan="2">
                            <label><b>&nbsp;&nbsp;&nbsp;TOTAL ENTRADAS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                              <label >' . $total_Entrada . '</label>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantPension . ' )</label>
                        </td>
                        <td class="segundaCol  tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;PENSIÓN:</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                              <label >' . $pension . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales tableTDCierre" colspan="2">
                            <label><b>&nbsp;&nbsp;&nbsp;TOTAL IVA:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                              <label >' . $total_Iva . '</label>
                        </td>
                    </tr>
                <tr>
                 <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantAjustes . ' )</label>
                        </td>
                        <td class="segundaCol  tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;AJUSTES:</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                              <label >' . $ajuste . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales tableTDCierre" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;TOTAL SALIDAS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $total_Salida . '</label>
                        </td>
                     
                    </tr>
                <tr>
                       <td colspan="3" >
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales tableTDCierre" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;SALDO CAJA:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                              <label >' . $saldo_Caja . '</label>
                        </td>
                    </tr>
                <tr>
                       <td colspan="3" class="titleTable tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;VENTAS</label>
                        </td>
                        <td colspan="1">
                            <br>
                        </td>
                        <td class="primeraColTotales tableTDCierre" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;EFECTIVO CAJA:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                              <label >' . $efectivo_Caja . '</label>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantCapitalRecuperado . ' )</label>
                        </td>
                        <td class="segundaCol  tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;CAPITAL RECUPERADO:</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                               <label >' . $capitalRecuperado . '</label>
                        </td>
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantIvaVenta . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;I.V.A.:</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                              <label >' . $iva_venta . '</label>
                        </td>
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                <tr>
                <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantApartados . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;APARTADOS:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $apartadosVentas . '</label>
                        </td>
                        <td colspan="4">
                            <br>
                        </td>
                </tr>
                <tr>
                    <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantAbonoVentas . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;ABONO:</label>
                        </td>
                        <td class="terceraCol tableTDCierre">
                               <label >' . $abonoVentas . '</label>
                        </td>
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                <tr>
                        <td class="primeraCol tableTDCierre">
                            <label> ( ' . $cantRefrendos . ' )</label>
                        </td>
                        <td class="segundaCol tableTDCierre">
                            <label>&nbsp;&nbsp;&nbsp;* INFORM. REFRENDO:</label>
                        </td>
                        <td class="terceraCol  tableTDCierre">
                               <label >' . $informeRefrendo . '</label>
                        </td>
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                <tr>
                    <td colspan="7">
                    <br>
                </td>
                </tr>
        </table>
        </td>
        </tr>';
$contenido .= '</tbody></table></form></body></html>';

$nombreContrato = 'Cierre Caja Num ' . $folioCierreCaja . ".pdf";
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
