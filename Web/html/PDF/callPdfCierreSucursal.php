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
    $db = "u672450412_Mexicash";
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
     <script src="../../JavaScript/funcionesCierreSucursal.js"></script>
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
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <br>
                    </td>
                </tr>
                <tr class="letraNormalNegrita">
            
                       <td colspan="5" >
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
                        <td class="primeraColLeft border border-primary" colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;SALDO INICIAL:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label>' . $saldo_Inicial . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="titleTable border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;RETIROS DE EFECTIVO</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraColLeft border border-primary" colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;DOTACIONES A CAJA:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label>' . $dotacionesA_Caja . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                            <label>' . $CantRetirosCaja . '</label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;RETIROS A CAJA:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label>' . $retirosCaja . '</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7"><br></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="titleTableEntrada" align="center">
                            <label>&nbsp;&nbsp;&nbsp;ENTRADAS</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="titleTableSalida" align="center">
                            <label>&nbsp;&nbsp;&nbsp;SALIDAS</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7"><br></td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label>' . $CantAportacionesBoveda . '</label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;APORTACIONES BÓVEDA:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label>' . $aportaciones_Boveda . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                            <label>' . $CantRetirosBoveda . '</label>
                        </td>
                        <td class="segundaCol border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;RETIROS A BÓVEDA:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label>' . $retiros_boveda . '</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label>' . $CantCapitalRecuperado . '</label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;CAPITAL RECUPERADO:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                           <label>' . $capitalRecuperado . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                           <label>' . $CantPrestamosNuevos . '</label>
                        </td>
                        <td class="segundaCol border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;PRÉSTAMOS NUEVOS:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label>' . $prestamosNuevos . '</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label>' . $CantAbono . '</label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;ABONO A CAPITAL:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                           <label>' . $abonoCapital . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                           <label>' . $CantDescuentos . '</label>
                        </td>
                        <td class="segundaCol border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;DESC. APLICADOS:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label>' . $descuentosAplicados . '</label>
                            </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                           <label></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;INTERESES:</label>
                        </td>

                        <td class="terceraCol  border border-primary">
                           <label>' . $intereses . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                           <label>' . $CantDescuentosVentas . '</label>
                        </td>
                        <td class="segundaCol border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;DESC. VENTAS:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                           <label>' . $descuentos_ventas . '</label>
                         </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label>' . $CantCostoContrato . '</label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;COSTO CONTRATO:</label>
                        </td>

                        <td class="terceraCol  border border-primary">
                           <label>' . $costoContrato . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                           <label>' . $CantIncremento . '</label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;INCREMENTO PAT.:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label>' . $incrementoPatrimonio . '</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;I.V.A. :</label>
                        </td>

                        <td class="terceraCol  border border-primary">
                          <label>' . $iva . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="titleTable border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;TOTALES</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label>' . $CantVentasMostrador . '</label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;VENTAS MOSTRADOR:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                           <label>' . $mostrador . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales border border-primary" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;TOTAL ENTRADAS:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label>' . $total_Entrada . '</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;IVA VENTAS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                           <label>' . $iva_venta . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales border border-primary" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;TOTAL IVA:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label>' . $totalIVA . '</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                        <!--<label id="CantIvaUtilidad"></label>-->
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;UTILIDAD VENTA:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                           <label>' . $utilidadVenta . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales border border-primary" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;TOTAL SALIDAS:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                           <label>' . $total_Salida . '</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                          <label>' . $CantApartados . '</label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;APARTADOS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label>' . $apartados . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales border border-primary" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;SALDO FINAL:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label>' . $saldo_final . '</label>
                        </td>

                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label>' . $CantAbonoVentas . '</label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;ABONO:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                           <label>' . $abonoVentas . '</label>
                        </td>

                        <td class="espacioEnmedio " colspan="4">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                           <label></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;GPS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                           <label>' . $gps . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>

                        <td colspan="3" class="titleTable border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;INFORMATIVOS</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;POLIZA:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label>' . $poliza . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales  border border-primary" colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;SALDO INICIAL:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                           <label>' . $InfoSaldoInicial . '</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;PENSION:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label>' . $pension . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales  border border-primary"  colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;ENTRADAS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label>' . $InfoEntradas . '</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label>' . $CantAjustes . '</label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;AJUSTES:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label>' . $ajustes . '</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales  border border-primary"  colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;SALIDAS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                           <label>' . $InfoSalidas . '</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol" colspan="3">
                            <label></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales  border border-primary"  colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;SALDO FINAL:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label>' . $InfoSaldoFinal . '</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol" colspan="3">
                            <label></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales  border border-primary"  colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;APARTADOS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label>' . $InfoApartados . '</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol" colspan="3">
                            <label></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales  border border-primary"  colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;ABONOS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label>' . $InfoAbono . '</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol" colspan="3">
                            <label></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales  border border-primary"  colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;TOTAL INVENTARIO:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label>' . $InfoTotalInventario . '</label>
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
<table align="center" border="0" WIDTH="90%" class="letraChica">
    <tbody>
        <tr>
            <th style="width:5%;"></th>
            <th style="width:30%;"></th>
            <th style="width:15%;"></th>
            <th style="width:5%;"></th>
            <th style="width:25%;"></th>
            <th style="width:20%;"></th>
        </tr>
        <tr>
            <td colspan="6" align="center" class="letraNormalNegrita">
                <label>' . $NombreCasa . '</label>
            </td>
        </tr>
        <tr>
            <td colspan="6" align="center" class="letraNormalNegrita">
                <label ID="sucursal">SUCURSAL: ' . $Nombre . '</label>
            </td>
        </tr>
        <tr>
            <td colspan="6" align="center">
                <label class="letraNormalNegrita">&nbsp;&nbsp;CIERRE DE SUCURSAL</label>
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
            <td  colspan="2" class="letraChicaNegrita">
                <label>&nbsp;&nbsp;&nbsp;DOTACIONES A CAJA:</label>
            </td>
            <td class="letraChicaNegrita">
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
            <td  colspan="3">
                <label></label>
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

$nombreContrato = 'Cierre Sucursal Num ' . $folioCierreSucursal . ".pdf";
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
