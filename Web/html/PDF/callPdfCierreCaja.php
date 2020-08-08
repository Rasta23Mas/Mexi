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


$web = 1;
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

$folioCierreCaja = 0;
if (isset($_GET['folioCierreCaja'])) {
    $folioCierreCaja = $_GET['folioCierreCaja'];
}

$CerradoNombreUsuario = "";


$queryCierreCaja = "SELECT * FROM bit_cierrecaja
                    WHERE folio_CierreCaja =$folioCierreCaja ";

$resultado = $mysql->query($queryCierreCaja);


foreach ($resultado as $row) {
    $id_CierreCaja = $row["id_CierreCaja"];
    $cantDotaciones = $row["cantDotaciones"];
    $dotacionesA_Caja = $row["dotacionesA_Caja"];
    $cantCapitalRecuperado = $row["cantCapitalRecuperado"];
    $capitalRecuperado = $row["capitalRecuperado"];
    $cantAbono = $row["cantAbono"];
    $abonoCapital = $row["abonoCapital"];
    $cantInteres = $row["cantInteres"];
    $intereses = $row["intereses"];
    $cantIva = $row["cantIva"];
    $iva = $row["iva"];
    $cantMostrador = $row["cantMostrador"];
    $mostrador = $row["mostrador"];
    $cantIvaVenta = $row["cantIvaVenta"];
    $iva_venta = $row["iva_venta"];
    $cantApartados = $row["cantApartados"];
    $apartadosVentas = $row["apartadosVentas"];
    $cantAbonoVentas = $row["cantAbonoVentas"];
    $abonoVentas = $row["abonoVentas"];
    $cantGps = $row["cantGps"];
    $gps = $row["gps"];
    $cantPoliza = $row["cantPoliza"];
    $poliza = $row["poliza"];
    $cantPension = $row["cantPension"];
    $pension = $row["pension"];
    $cantRetiros = $row["cantRetiros"];
    $retirosCaja = $row["retirosCaja"];
    $cantPrestamos = $row["cantPrestamos"];
    $prestamosNuevos = $row["prestamosNuevos"];
    $cantDescuentos = $row["cantDescuentos"];
    $descuentosAplicados = $row["descuentosAplicados"];
    $cantDescuentosVentas = $row["cantDescuentosVentas"];
    $descuento_Ventas = $row["descuento_Ventas"];
    $cantCostoContrato = $row["cantCostoContrato"];
    $costoContrato = $row["costoContrato"];
    $total_Salida = $row["total_Salida"];
    $total_Entrada = $row["total_Entrada"];
    $total_Iva = $row["total_Iva"];
    $saldo_Caja = $row["saldo_Caja"];
    $efectivo_Caja = $row["efectivo_Caja"];
    $cantAjustes = $row["cantAjustes"];
    $ajuste = $row["ajuste"];
    $cantIncremento = $row["cantIncremento"];
    $incremento = $row["incremento"];
    $cantRefrendos = $row["cantRefrendos"];
    $informeRefrendo = $row["informeRefrendo"];
    $usuario = $row["usuario"];
    $fecha_Creacion = $row["fecha_Creacion"];
    $CerradoPorGerente = $row["CerradoPorGerente"];
}



$dotacionesA_Caja = number_format($dotacionesA_Caja, 2, '.', ',');
$capitalRecuperado = number_format($capitalRecuperado, 2, '.', ',');
$abonoCapital = number_format($abonoCapital, 2, '.', ',');
$intereses = number_format($intereses, 2, '.', ',');
$iva = number_format($iva, 2, '.', ',');
$mostrador = number_format($mostrador, 2, '.', ',');
$iva_venta = number_format($iva_venta, 2, '.', ',');
$apartadosVentas = number_format($apartadosVentas, 2, '.', ',');
$abonoVentas = number_format($abonoVentas, 2, '.', ',');
$gps = number_format($gps, 2, '.', ',');
$poliza = number_format($poliza, 2, '.', ',');
$pension = number_format($pension, 2, '.', ',');
$retirosCaja = number_format($retirosCaja, 2, '.', ',');
$prestamosNuevos = number_format($prestamosNuevos, 2, '.', ',');
$descuentosAplicados = number_format($descuentosAplicados, 2, '.', ',');
$descuento_Ventas = number_format($descuento_Ventas, 2, '.', ',');
$costoContrato = number_format($costoContrato, 2, '.', ',');
$total_Salida = number_format($total_Salida, 2, '.', ',');
$total_Entrada = number_format($total_Entrada, 2, '.', ',');
$total_Iva = number_format($total_Iva, 2, '.', ',');
$saldo_Caja = number_format($saldo_Caja, 2, '.', ',');
$efectivo_Caja = number_format($efectivo_Caja, 2, '.', ',');
$ajuste = number_format($ajuste, 2, '.', ',');
$incremento = number_format($incremento, 2, '.', ',');
$informeRefrendo = number_format($informeRefrendo, 2, '.', ',');


$dotacionesA_Caja = "$" . $dotacionesA_Caja;
$capitalRecuperado = "$" . $capitalRecuperado;
$abonoCapital = "$" . $abonoCapital;
$intereses = "$" . $intereses;
$iva = "$" . $iva;
$mostrador = "$" . $mostrador;
$iva_venta = "$" . $iva_venta;
$apartadosVentas = "$" . $apartadosVentas;
$abonoVentas = "$" . $abonoVentas;
$gps = "$" . $gps;
$poliza = "$" . $poliza;
$pension = "$" . $pension;
$retirosCaja = "$" . $retirosCaja;
$prestamosNuevos = "$" . $prestamosNuevos;
$descuentosAplicados = "$" . $descuentosAplicados;
$descuento_Ventas = "$" . $descuento_Ventas;
$costoContrato = "$" . $costoContrato;
$total_Salida = "$" . $total_Salida;
$total_Entrada = "$" . $total_Entrada;
$total_Iva = "$" . $total_Iva;
$saldo_Caja = "$" . $saldo_Caja;
$efectivo_Caja = "$" . $efectivo_Caja;
$ajuste = "$" . $ajuste;
$incremento = "$" . $incremento;
$informeRefrendo = "$" . $informeRefrendo;

if ($CerradoPorGerente != 0) {
    $queryCierrePorGerente = "SELECT usuario FROM usuarios_tbl
                    WHERE id_User =$CerradoPorGerente ";
    $resultadoCierrePor = $mysql->query($queryCierrePorGerente);
    foreach ($resultadoCierrePor as $row) {
        $CerradoNombreUsuario = "Cerrado por: " . $row["usuario"];
    }
}


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
                            <label>&nbsp;&nbsp;&nbsp;PRÉSTAMOS NUEVOS:</label>
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
        <input type="button" class="btn btnGenerarPDF" value="Generar PDF"  onclick="verPDFCaja(' . $folioCierreCaja . ');" >
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
<body>
<form>';
$contenido .= '
<table align="center" border="0" class="letraGrandeNegrita">
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
                            <label>&nbsp;&nbsp;&nbsp;PRÉSTAMOS NUEVOS:</label>
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
