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


$idContrato = '';
$FechaCreacion = '';
$NombreCompleto = '';
$Identificacion = '';
$NumIde = '';
$Direccion = '';
$Telefono = '';
$Celular = '';
$Correo = '';
$Cotitular = '';
$Beneficiario = '';
//Tabla
$MontoPrestamo = '';
$MontoTotal = '';
$Tasa = '';
$Almacenaje = '';
$Seguro = '';
$Iva = '';
//Tabla 2
$FechaAlmoneda = '';
$Dias = '';
$FechaVenc = '';
$Intereses = '';
//Tabla Art
$TipoElectronico = '';
$MarcaElectronico = '';
$ModeloElectronico = '';
$Detalle = '';
//Tabla MEt
$TipoMetal = '';
$Kilataje = '';
$Calidad = '';
$Avaluo = '';
$NombreUsuario = '';
$diasLabel = '';
$totalInteres = 0;
$ivaPorcentaje = 0;

$reimpresion = '';
if (isset($_GET['reimpresion'])) {
    $reimpresion = "Reimpresión";
}
if (isset($_GET['contrato'])) {
    $idContrato = $_GET['contrato'];
}
$nombreContrato = 'Contrato Num _' . $idContrato . ".pdf";

$query = "SELECT Con.fecha_creacion AS FechaCreacion, CONCAT ( Cli.nombre,' ',Cli.apellido_Mat, ' ',Cli.apellido_Pat) as NombreCompleto, 
            CatCli.descripcion AS Identificacion, Cli.num_Identificacion AS NumIde,
            CONCAT(Cli.calle, ', ',Cli.num_interior,', ', Cli.num_exterior, ', ',Cli.localidad, ', ', Cli.municipio, ', ', CatEst.descripcion ) AS Direccion,
            Cli.telefono AS Tel, Cli.celular AS Celular,Cli.correo AS Correo, Con.cotitular AS Cotitular,Con.beneficiario AS Beneficiario,
            Con.total_Prestamo AS MontoPrestamo, Con.suma_InteresPrestamo AS MontoTotal, Con.total_Interes AS Intereses,Con.tasa AS Tasa,Con.alm AS Almacenaje, 
            Con.seguro AS Seguro,Con.Iva AS Iva,Mov.fechaAlmoneda AS FechaAlmoneda, Con.dias AS Dias,Mov.fechaVencimiento AS FechaVenc,
            Con.total_Avaluo AS Avaluo,avaluo_Letra,CONCAT (Usu.apellido_Pat, ' ',Usu.apellido_Mat,' ', Usu.nombre) as NombreUsuario,
            Con.id_Formulario AS TipFormulario, Con.Aforo AS Aforo,CSUC.NombreCasa, CSUC.Nombre,CSUC.direccion, CSUC.telefono,CSUC.rfc,
            CSUC.correo as CorreoCasa, CSUC.pagina as PaginaCasa,CSUC.horario as HorarioCasa
            FROM contratos_tbl AS Con 
            INNER JOIN cliente_tbl AS Cli on Con.id_Cliente = Cli.id_Cliente 
            INNER JOIN cat_cliente AS CatCli on Cli.tipo_Identificacion = CatCli.id_Cat_Cliente
            INNER JOIN cat_estado As CatEst on Cli.estado = CatEst.id_Estado
            INNER JOIN contrato_mov_tbl AS Mov on Con.id_Contrato = Mov.id_contrato 
            INNER JOIN bit_cierrecaja AS Caj on Con.id_cierreCaja = Caj.id_CierreCaja  
            INNER JOIN usuarios_tbl AS Usu on Caj.usuario = Usu.id_User 
            INNER JOIN cat_sucursal CSuc ON Mov.sucursal=CSUC.id_Sucursal
            WHERE Con.id_Contrato =$idContrato ";
$resultado = $db->query($query);

foreach ($resultado as $row) {
    //CASA
    $NombreCasa = $row["NombreCasa"];
    $Nombre = $row["Nombre"];
    $direccionCasa = $row["direccion"];
    $telefonoCasa = $row["telefono"];
    $rfcCasa = $row["rfc"];
    $correoCasa = $row["CorreoCasa"];
    $paginaCasa = $row["PaginaCasa"];
    $horarioCasa = $row["HorarioCasa"];
    //CONTRATO
    $FechaCreacion = $row["FechaCreacion"];
    $NombreCompleto = $row["NombreCompleto"];
    $Identificacion = $row["Identificacion"];
    $NumIde = $row["NumIde"];
    $Direccion = $row["Direccion"];
    $Telefono = $row["Tel"];
    $Celular = $row["Celular"];
    $Correo = $row["Correo"];
    $Cotitular = $row["Cotitular"];
    $Beneficiario = $row["Beneficiario"];
    //Tabla
    $MontoPrestamo = $row["MontoPrestamo"];
    $MontoTotal = $row["MontoTotal"];
    $Tasa = $row["Tasa"];
    $Almacenaje = $row["Almacenaje"];
    $Seguro = $row["Seguro"];
    $Iva = $row["Iva"];
    //Tabla 2
    $FechaAlmoneda = $row["FechaAlmoneda"];
    $Dias = $row["Dias"];
    $FechaVenc = $row["FechaVenc"];
    $Intereses = $row["Intereses"];
    $Avaluo = $row["Avaluo"];
    $avaluo_Letra = $row["avaluo_Letra"];

    $TipFormulario = $row["TipFormulario"];
    $Aforo = $row["Aforo"];
    $NombreUsuario = $row["NombreUsuario"];
}

if ($Dias == 30) {
    $diasLabel = "1 Mes";
} else if ($Dias == 0) {
    $diasLabel = "1 Día";
    $Dias = 1;
} else {
    $diasLabel = $Dias;
}
$ivaPorcentaje = '.' . $Iva;
$ivaPorcentaje = floatval($ivaPorcentaje);
//Se saca los porcentajes mensuales
//$calculaInteres = round($MontoPrestamo * $Tasa / 100, 2);
$calculaInteres = 30;
$calculaALm = 120;
$calculaSeg = round($MontoPrestamo * $Seguro / 100, 2);
// $calculaIva = round($MontoPrestamo * $ivaPorcentaje / 100, 2);
$calculaIva = round(($calculaInteres + $calculaALm) * $ivaPorcentaje, 2);
$totalInteres = $calculaInteres + $calculaALm + $calculaSeg + $calculaIva;
//interes por dia
$interesDia = $totalInteres / $Dias;
//TASA:
$tasaIvaTotal = $Tasa + $Almacenaje + $Seguro + $Iva;
$tasaDiaria = round($tasaIvaTotal / $Dias, 2);
$FechaCreacion = date("d-m-Y", strtotime($FechaCreacion));
$FechaAlmoneda = date("d-m-Y", strtotime($FechaAlmoneda));
$FechaVenc = date("d-m-Y", strtotime($FechaVenc));

$MontoPrestamo = number_format($MontoPrestamo, 2, '.', ',');
$MontoTotal = number_format($MontoTotal, 2, '.', ',');
$Avaluo = number_format($Avaluo, 2, '.', ',');

$calculaALm = number_format($calculaALm, 2, '.', ',');
$calculaInteres = number_format($calculaInteres, 2, '.', ',');
$calculaIva = number_format($calculaIva, 2, '.', ',');
$Intereses = number_format($Intereses, 2, '.', ',');

$contenido = '
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .letraTitulo{
                font-size: 1.3em;
                font-weight: bold;
            }
            .letraPDF{
                font-size: .5em;
            }
            .letraNormal{
                font-size: .6em;
            }
            .letraCelda{
                font-size: .7em;
            }
            .tableFormat{
                border: 1px solid black; 
                border-collapse: collapse;
                text-align: center;
                 
            }
            .tituloCelda{
                background-color: #ebebe0;
                font-weight: bold;
                text-align: center;
                border-collapse: collapse;
                border: 1px solid black;
            }
            .tituloCeldaPDF{
                background-color: #ebebe0;
                font-size: .6em;
                text-align: left;
                border-collapse: collapse;
                border: 1px solid black;
            }
            body {
                font-family: "Times New Roman", serif;
                margin: 35mm 10mm 25mm 10mm;
            }
                
        </style>
    </head>
    <body>
        <form>
            <table width="90%"  align="center" >
                <tbody >
                    <tr>
                        <td align="right"  >
                            <label class="letraTitulo"> ' . $reimpresion . ' Contrato No. ' . $idContrato . '</label>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <label class="letraPDF">
                                Fecha de celebración del contrato: CIUDAD DE MEXICO a ' . $FechaCreacion . '<br>
                                <b>CONTRATO DE MUTUO CON INTERÉS Y GARANTÍA PRENDARIA (PRÉSTAMO)</b>, que celebran: ' . $NombreCasa . ',<b>"EL PROVEEDOR"</b>, con
                                domicilio en: ' . $direccionCasa . ', R.F.C.: ' . $rfcCasa . ', Tel.: ' . $telefonoCasa . ', correo electrónico: ' . $correoCasa . ', y el <b>"EL CONSUMIDOR"</b>,
                                ' . $NombreCompleto . ' que se identifica con: ' . $Identificacion . ' número: ' . $NumIde . ' con domicilio en: ' . $Direccion . '
                                Tel.: ' . $Telefono . ' y Cel: ' . $Celular . 'correo electrónico:' . $Correo . '
                                quien designa como cotitular a:' . $Cotitular . ' y beneficiario a: ' . $Beneficiario . ' solo para efectos de este contrato.
                            </label>
                               
                        </td>
                    </tr>';
$contenido .= '     <tr>
                        <td>
                            <table class="tableFormat " width="100%">
                                <tr class="tituloCelda">
                                    <th colspan="2"  class="tableFormat"><label class="letraCelda">Cat<br> Costo Anual Total </label></th>
                                    <th colspan="2"  class="tableFormat"><label class="letraCelda">TASA DE <br>INTERÉS <br>ANUAL </label></th>
                                    <th colspan="2"  class="tableFormat"><label class="letraCelda">MONTO DEL<br> PRÉSTAMO<br> (MUTUO) </label></th>
                                    <th colspan="2"  class="tableFormat"><label class="letraCelda">MONTO TOTAL A<br> PAGAR </label></th>
                                    <th colspan="4" class="tableFormat"><label class="letraCelda">COMISIONES<br> Montos y cláusulas  </label></th>
                                </tr>
                                <tr >
<td colspan="2"  class="tableFormat"><label class="letraNormal">Para fines<br>
informativos<br>
y de comparación<br>
155.70 %<br>
FIJO SIN IVA</label></td>
<td colspan="2"  class="tableFormat"><label class="letraNormal"> <u>36.00 % </u><br>
TASA FIJA</label></td>
<td colspan="2"  class="tableFormat"><label class="letraNormal"> <u>$ ' . $MontoPrestamo . '</u><br>
Moneda Nacional </label></td>
<td colspan="2"  class="tableFormat"><label class="letraNormal"> <u>$ ' . $MontoTotal . '</u><br>
Estimado al plazo máximo de desempeño<br>
o refrendo.</label></td>
<td colspan="4" class="tableFormat" style="text-align: left"><label class="letraPDF">Comisión por Almacenaje:<u>' . $Almacenaje . ' % </u>(Claus. 11a)<br>
Comisión por Avalúo <u>$ 0.00</u> (Claus. 11b)<br>
Comisión por Comercialización: <u>10.00%</u> (Claus. 11c)<br>
Comisión por reposición de contrato <u>$ 0.00</u> (Claus. 11d)<br>
Desempeño Extemporáneo: <u>0.00%</u> (Claus. 11e)<br>
Gastos de Administración <u>$ 0.00</u> (Claus 11f)<br> </label></td>
</tr>
                                <tr>
                                    <td colspan="12" class="tituloCelda" style="text-align: left">
                                        <label class="letraCelda">
                                            <b>METODOLOGIA DE CALCULO DE INTERÉS: TASA DE INTERÉS FIJA DIVIDIDA ENTRE 360 DIAS POR EL IMPORTE DEL SALDO INSOLUTO DEL PRÉSTAMO POR EL<br> 
                                            NÚMERO DE DÍAS EFECTIVAMENTE TRANSCURRIDOS.</b>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="12" style="text-align: left">
                                        <label class="letraNormal">
                                            PLAZO DEL PRÉSTAMO (Fecha limite para el refrendo o desempeño):' . $FechaAlmoneda . '. Total de refrendos aplicables:<br>
                                            Su pago sera: ' . $diasLabel . '. Metodos de pago aceptado: efectivo. En caso de que el vencimiento sea en dia inhabil, se considerara el dia habil siguiente.
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>';
$contenido .= '     <tr>
                       <td> 
                            <table class="tableFormat " width="100%">
                                <tr class="tituloCelda">
                                    <th colspan="12" class="tableFormat" >
                                        <label class="letraCelda">
                                            Opciones de pago para refrendo o desempeño
                                        </label>
                                    </th>
                                </tr>
                                <tr class="tituloCelda">
                                    <th colspan="7" class="tableFormat">
                                        <label class="letraCelda">
                                            MONTO
                                        </label>
                                    </th>
                                    <th colspan="5" class="tableFormat">
                                        <label class="letraCelda">
                                            TOTAL A PAGAR
                                        </label>
                                    </th>
                                </tr>
                                <tr class="tituloCelda">
                                    <th class="tableFormat">
                                        <label class="letraCelda">
                                            NÚMERO
                                        </label>
                                    </th>
                                    <th class="tableFormat" colspan="2">
                                        <label class="letraCelda">
                                            IMPORTE MUTUO
                                        </label>
                                    </th>
                                    <th class="tableFormat">
                                        <label class="letraCelda">
                                            INTERESES
                                        </label>
                                    </th>
                                    <th class="tableFormat">
                                        <label class="letraCelda">
                                            ALMACENAJE
                                        </label>
                                    </th>
                                    <th class="tableFormat">
                                        <label class="letraCelda">
                                            IVA
                                        </label>
                                    </th>
                                    <th class="tableFormat">
                                        <label class="letraCelda">
                                            POR REFRENDO
                                        </label>
                                    </th>
                                    <th class="tableFormat" colspan="2">
                                        <label class="letraCelda">
                                            POR DESEMPEÑO
                                        </label>
                                    </th>
                                </tr>
                                <tr>
                                    <td class="tableFormat">
                                        <label  class="letraNormal">
                                            1
                                        </label>
                                    </td>
                                    <td class="tableFormat" colspan="2">
                                        <label class="letraNormal">
                                            $ ' . $MontoPrestamo . '
                                        </label>
                                    <td class="tableFormat">
                                        <label class="letraNormal">
                                            $ ' . $calculaInteres . '
                                        </label>
                                    </td>
                                    <td class="tableFormat">
                                        <label class="letraNormal">
                                            $ ' . $calculaALm . '
                                        </label>
                                    </td align="center">
                                    <td class="tableFormat">
                                        <label class="letraNormal">
                                            $ ' . $calculaIva . '
                                        </label>
                                    </td>
                                    <td class="tableFormat">
                                        <label class="letraNormal">
                                            $ ' . $Intereses . '
                                        </label>
                                    </td>
                                    <td class="tableFormat" colspan="2">
                                        <label class="letraNormal">
                                            $ ' . $MontoTotal . '
                                        </label>
                                    </td>
                                    <td class="tableFormat">
                                        <label class="letraNormal">
                                            ' . $FechaVenc . '
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="tableFormat">
                                        <label class="letraCelda">
                                            <b>COSTO MENSUAL TOTAL</b>
                                        </label>
                                    </td>
                                    <td colspan="6" class="tableFormat">
                                        <label class="letraCelda">
                                            <b>COSTO DIARIO TOTAL</b>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="tableFormat">
                                        <label class="letraNormal">
                                            Para fines informativos y de comparación:<br>
                                            ' . $tasaIvaTotal . '% FIJO SIN IVA
                                        </label>
                                    </td>
                                    <td colspan="6" class="tableFormat">
                                        <label class="letraNormal">
                                            Para fines informativos y de comparación:<br>
                                            ' . $tasaDiaria . '% FIJO SIN IVA
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="12" class="tableFormat" style="text-align: left">
                                        <label class="letraNormal">
                                            <b>"Cuide su capacidad de pago, generalmente no debe de exceder del 35% de sus ingresos".<br>
                                            "Si usted no paga en tiempo y forma corre el riesgo de perder sus prendas".</b>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="12" class="tableFormat" style="text-align: left">
                                        <label class="letraNormal">
                                            GARANTÍA: Para garantizar el pago de este préstamo, EL CONSUMIDOR deja en garantia el bien que se describe a continuacion:
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>';
$contenido .= '     <tr>
                       <td> 
                            <table class="tableFormat " width="100%">
                                <tr class="tituloCelda">
                                    <th colspan="12" class="tableFormat" >
                                       <label class="letraCelda">
                                            DESCRIPCIÓN DE LA PRENDA
                                        </label>
                                    </th>
                                </tr>
                                <tr class="tituloCelda">
                                    <th class="tableFormat" >
                                       <label class="letraCelda">
                                            DESCRIPCIÓN GENÉRICA
                                    </label>
                                    <th colspan="5" class="tableFormat" >
                                        <label class="letraCelda">
                                            CARACTERISTICAS
                                        </label>
                                    </th>
                                    <th colspan="2" class="tableFormat" >
                                        <label class="letraCelda">
                                            AVALÚO
                                        </label>
                                    </th>
                                    <th colspan="2" class="tableFormat" >
                                        <label class="letraCelda">
                                            PRÉSTAMO
                                        </label>
                                    </th>
                                    <th colspan="2" class="tableFormat" >
                                        <label class="letraCelda">
                                            %PRÉSTAMO SOBRE<br>
                                            AVALÚO
                                        </label>
                                    </th>  
                                </tr>';
$i = 1;
$tablaArticulos = '';
$detallePiePagina = '';
$detalleDescripcion = '';
$tipoDescripcion = '';

$query = "SELECT
            CONCAT ( Ar.detalle,' ', TA.descripcion, ' ',TK.descripcion ,' ', TC.descripcion) as detalleMetal,
            CONCAT ( ET.descripcion,' ', EM.descripcion, ' ',EMOD.descripcion ,' ',  Ar.detalle) as detalleElec,
            Ar.observaciones AS ObsArt,
            CONCAT ( Aut.marca,' ', Aut.modelo, ' ',Aut.anio ,' ',  Aut.color, ' ' , Aut.placas, ' ',Aut.factura, ' ',Aut.num_motor) as detalleAuto, 
            Aut.observaciones AS ObsAuto, Ar.prestamo as PrestamoArt, Ar.avaluo as AvaluoArt
            FROM contratos_tbl as Con 
            INNER JOIN articulo_tbl as Ar on Con.id_Contrato =  Ar.id_Contrato
            LEFT JOIN cat_tipoarticulo as TA on AR.tipo = TA.id_tipo
            LEFT JOIN cat_kilataje as TK on AR.kilataje = TK.id_Kilataje
            LEFT JOIN cat_calidad as TC on AR.calidad = TC.id_calidad
            LEFT JOIN cat_electronico_tipo as ET on Ar.tipo = ET.id_tipo
            LEFT JOIN cat_electronico_marca as EM on Ar.marca = EM.id_marca
            LEFT JOIN cat_electronico_modelo as EMOD on Ar.modelo = EMOD.id_modelo
            LEFT JOIN auto_tbl AS Aut on Con.id_Contrato = Aut.id_Contrato
            WHERE Con.id_Contrato =$idContrato ";
$tablaArt = $db->query($query);

foreach ($tablaArt as $row) {
    if ($TipFormulario == 1) {
        $tipoDescripcion = 'METALES';
        $detalle = $row["detalleMetal"];
        $Obs = $row["ObsArt"];

        $avaluoArt = $row["PrestamoArt"];
        $prestamoArt = $row["AvaluoArt"];
    }elseif ($TipFormulario == 2) {
        $tipoDescripcion = 'ELECTRÓNICOS';
        $detalle = $row["detalleElec"];
        $Obs = $row["ObsArt"];
        $avaluoArt = $row["PrestamoArt"];
        $prestamoArt = $row["AvaluoArt"];
    }elseif ($TipFormulario == 3) {
        $tipoDescripcion = 'AUTO';
        $detalle = $row["detalleAuto"];
        $Obs = $row["ObsAuto"];
        $avaluoArt = $Avaluo;
        $prestamoArt = $MontoPrestamo;
    }
    $detalleDescripcion = $detalle . " " . $Obs;
    $tablaArticulos .= '
                                <tr>
                                    <td class="tableFormat " ><label  class="letraNormal">' . $tipoDescripcion . '</label></td>
                                    <td class="tableFormat"  colspan="5"><label  class="letraNormal">' . $detalleDescripcion . '</label></td>
                                    <td class="tableFormat"  colspan="2"><label  class="letraNormal">$ ' . $Avaluo . '</label></td>
                                    <td class="tableFormat"  colspan="2"><label  class="letraNormal">$ ' . $MontoPrestamo . '</label></td>
                                    <td class="tableFormat"  colspan="2"><label  class="letraNormal">' . $Aforo . ' %</label></td>
                                </tr>';

    if($i==1){
        $detallePiePagina .= $detalleDescripcion;
    }else{
        $detallePiePagina .= ' // ' . $detalleDescripcion;
    }
    $i++;
}
$contenido .= $tablaArticulos;
$contenido .= ' 
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <table class="tableFormat " width="100%">
                                <tr>
                                    <td colspan="6" class="tableFormat" style="text-align: left">
                                        <label class="letraCelda">
                                            MONTO DEL AVALUO: $ ' . $Avaluo . '
                                        </label>
                                    </td>
                                    <td colspan="6" class="tableFormat" style="text-align: left">
                                        <label class="letraCelda">
                                            ' . $avaluo_Letra . '
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="tableFormat" style="text-align: left">
                                        <label class="letraCelda">
                                           PORCENTAJE DEL PRÉSTAMO SOBRE EL AVALÚO:
                                        </label>
                                    </td>
                                    <td colspan="6" class="tableFormat" style="text-align: left">
                                        <label class="letraCelda">
                                            ' . $Aforo . ' %
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="tableFormat" style="text-align: left">
                                        <label class="letraCelda">
                                           FECHA DE INICIO DE COMERCIALIZACIÓN:
                                        </label>
                                    </td>
                                    <td colspan="6" class="tableFormat" style="text-align: left">
                                        <label class="letraCelda">
                                            ' . $FechaAlmoneda . '
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="tableFormat" style="text-align: left">
                                         <label class="letraCelda">
                                           El monto del préstamo se realizara en:
                                        </label>
                                    </td>
                                    <td colspan="6" class="tableFormat" style="text-align: left">
                                         <label class="letraCelda">
                                           Efectivo
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="tableFormat" style="text-align: left">
                                         <label class="letraCelda">
                                           FECHA LÍMITE DE FINIQUITO:
                                        </label>
                                    </td>
                                    <td colspan="6" class="tableFormat" style="text-align: left">
                                        <label class="letraPDF">
                                           Terminos y condiciones para recibir pagos anticipados: Clausula 13 (decimo Tercera, Inciso b)
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="12" class="tableFormat" style="text-align: left">
                                         <label class="letraCelda">
                                           Estos conceptos causaran el pago al impuesto del valor agregado (IVA) a la tasa del ' . $Iva . '%
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="letraPDF">
                                *EL PROCEDIMIENTO PARA DESEMPEÑO, REFRENDO, FINIQUITO Y RECLAMO DEL REMANENTE SE ENCUENTRA DESCRITO EN EL CONTRATO.
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="tableFormat " width="100%">
                                <tr>
                                    <td colspan="12" style="text-align: left">
                                        <label class="letraPDF">
                                            <b>DUDAS, ACLARACIONES Y RECLAMACIONES:</b><br>
                                            * PARA CUALQUIER DUDA, ACLARACIÓN O RECLAMACIÓN, FAVOR DE DIRIGIRSE A:<br>
                                            Domicilio: ' . $direccionCasa .'<br>
                                            Telefono: ' . $telefonoCasa .', Correo electronico: ' . $correoCasa . ', Pagina de internet: ' . $paginaCasa .'<br>
                                            ' . $horarioCasa .'<br>
                                            * O EN SU CASO A PROFECO A LOS TELEFONOS: 55 68 87 22 O AL 01 800 468 87 22 , PAGINA DE INTERNET:  www.gob.mx/profeco <br>  
                                            ESTADO DE CUENTA/CONSULTA DE MOVIMIENTOS: NO APLICA O CONSULTA EN ____________
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <table class="tableFormat " width="100%">
                                <tr class="tituloCeldaPDF">
                                    <th colspan="12" >
                                        <label>
                                            Contrato de Adhesión registrado en el Registro Público de Contratos de Adhesión de la Procuraduría Federal del Consumidor, bajo el número 11327-2018 de fecha 29-oct-2018. <br>
                                            El proveedor tiene la obligación de entregar al consumidor el documento en el cual se señale la descripción del préstamo, saldos, movimientos y la descripción de la Prenda en garantía.
                                        </label>
                                    </th>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <table class="tableFormat" width="100%">
                                <tr>
                                    <td colspan="6" class="tableFormat" >
                                         <label class="letraCelda">DESEMPEÑO</label></td>
                                    <td colspan="6" class="tableFormat" >
                                         <label class="letraCelda">FIRMAS</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="tableFormat" style="text-align: left">
                                        <label class="letraNormal">
                                            El CONSUMIDOR recoge en el acto y a su entera satisfacción la(s) prenda(s) arriba descritas, por <br>
                                            lo que otorga a ' . $NombreCasa . ' el finiquito más amplio que en derecho corresponda, <br>
                                            liberándolo de cualquier responsabilidad jurídica que hubiere surgido ó pudiese surgir en relación <br>
                                            al contrato y la prenda. ' . $FechaAlmoneda . '
                                        </label>
                                    </td>
                                    <td colspan="6" class="tableFormat" >
                                         <label class="letraCelda">
                                            FECHA: ' . $FechaCreacion . ' <br>
                                            <u>'.  $NombreCompleto . '</u><br>
                                            "EL CONSUMIDOR"
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="tableFormat" style="width: 33%" >
                                        <label class="letraNormal">
                                            ' . $NombreCompleto . '<br>
                                            <br>
                                            EL CONSUMIDOR
                                        </label>
                                    </td>
                                     <td colspan="4" class="tableFormat" style="width: 33%" >
                                        <label class="letraNormal">
                                            ' . $NombreCasa . '<br>
                                            <br>
                                             EL PROVEEDOR
                                        </label>
                                    </td>
                                     <td colspan="4" class="tableFormat" style="width: 33%" >
                                        <label class="letraNormal">
                                            ' . $NombreUsuario . '<br>
                                            <br>
                                            EL VALUADOR
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <label class="letraPDF">
                                ' . $horarioCasa .'<br>
                                Para todo lo relativo a la interpretación, aplicación y cumplimiento del contrato, LAS PARTES acuerdan
                                someterse en la vía administrativa a la Procuraduría Federal del Consumidor, y en caso de subsistir
                                diferencias, a la jurisdicción de los tribunales competentes del lugar donde se celebra este Contrato.
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <hr style="border-top: 1px dashed black;"  />
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <table width="100%">
                                <tr>
                                    <td colspan="4">
                                        <label>&nbsp;</label>
                                    </td>
                                    <td colspan="4" style="text-align: right">
                                        <label class="letraTitulo">
                                            NO. ' . $idContrato . '
                                        </label>
                                    </td>
                                    <td colspan="4" style="text-align: right">
                                        <label class="letraTitulo">
                                            NO. ' . $idContrato . '
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8" style="text-align: left">
                                        <label class="letraTitulo">
                                            NOMBRE:' . $NombreCompleto . '
                                        </label>
                                    </td>
                                    <td colspan="4">
                                        <label class="letraTitulo">
                                            PRÉSTAMO:&nbsp;$ ' . $MontoPrestamo . '
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="12" style="text-align: left">
                                        <label class="letraTitulo">
                                             FECHA: ' . $FechaCreacion . ' PLAZO: 1 MENSUAL
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="12" style="text-align: left">
                                        <label class="letraTitulo" >
                                             PRENDA:' . $detallePiePagina . '
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </body>
</html>';
//echo $contenido;
//exit;

$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
//letter carta, legal oficio
//Vertical
$dompdf->setPaper("legal", "portrait");
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);