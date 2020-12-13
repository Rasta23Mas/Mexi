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
$nombreContrato = 'Contrato_Num_' . $idContrato . ".pdf";
$query = "SELECT Con.fecha_creacion AS FechaCreacion, CONCAT ( Cli.nombre,' ',Cli.apellido_Pat, ' ',Cli.apellido_Mat) as NombreCompleto,
 CatCli.descripcion AS Identificacion, Cli.num_Identificacion AS NumIde, 
 CONCAT(Cli.calle, ', ',Cli.num_interior,', ', Cli.num_exterior, ', ',Cli.localidad, ', ', Cli.municipio, ', ', CatEst.descripcion ) AS Direccion,
  Cli.telefono AS Tel, Cli.celular AS Celular,Cli.correo AS Correo, 
  Con.cotitular AS Cotitular,Con.beneficiario AS Beneficiario, Con.total_Prestamo AS MontoPrestamo, 
  Con.suma_InteresPrestamo AS MontoTotal, Con.total_Interes AS Intereses,Con.tasa AS Tasa,
  Con.alm AS Almacenaje, Con.seguro AS Seguro,Con.Iva AS Iva,Con.fecha_almoneda AS FechaAlmoneda, 
  Con.dias AS Dias,Con.fecha_vencimiento AS FechaVenc, Con.total_Avaluo AS Avaluo,avaluo_Letra,
  CONCAT(Con.plazo, ' ' ,Con.periodo ) AS PlazoMov, 
  CONCAT (Usu.apellido_Pat, ' ',Usu.apellido_Mat,' ', Usu.nombre) as NombreUsuario, 
  Con.id_Formulario AS TipFormulario, Con.Aforo AS Aforo,CATS.NombreCasa, 
  CATS.Nombre,CATS.direccion, CATS.telefono,CATS.rfc, CATS.correo as CorreoCasa, 
  CATS.pagina as PaginaCasa,CATS.horario as HorarioCasa , CCC.costo AS GastoAdmin
  FROM contratos_tbl AS Con 
  LEFT JOIN cliente_tbl AS Cli on Con.id_Cliente = Cli.id_Cliente AND Cli.sucursal= $sucursal
  LEFT JOIN cat_cliente AS CatCli on Cli.tipo_Identificacion = CatCli.id_Cat_Cliente 
  LEFT JOIN cat_estado As CatEst on Cli.estado = CatEst.id_Estado
  LEFT JOIN bit_cierrecaja AS Caj on Con.id_cierreCaja = Caj.id_CierreCaja AND Caj.sucursal= $sucursal 
  LEFT JOIN usuarios_tbl AS Usu on Caj.usuario = Usu.id_User 
  LEFT JOIN cat_sucursal CATS ON Con.sucursal= CATS.id_Sucursal
  LEFT JOIN cat_costo_contrato CCC ON Con.id_Formulario= CCC.id_formulario AND CCC.sucursal =$sucursal  
  WHERE Con.id_Contrato =$idContrato AND Con.sucursal = $sucursal  ";

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
    $PlazoMov = $row["PlazoMov"];
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

    $GastoAdmin = $row["GastoAdmin"];
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
$calculaInteres = round($MontoPrestamo * $Tasa / 100, 2);
$calculaALm = round($MontoPrestamo * $Almacenaje / 100, 2);
$calculaSeg = round($MontoPrestamo * $Seguro / 100, 2);
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


$porRefrendo = $calculaALm + $calculaInteres + $calculaIva;
$porDesempeño = $MontoPrestamo +$porRefrendo;
$calculaALm = number_format($calculaALm, 2, '.', ',');
$calculaInteres = number_format($calculaInteres, 2, '.', ',');
$calculaIva = number_format($calculaIva, 2, '.', ',');
$Intereses = number_format($Intereses, 2, '.', ',');
$porRefrendo = number_format($porRefrendo, 2, '.', ',');

$porDesempeño = number_format($porDesempeño, 2, '.', ',');
$MontoPrestamo = number_format($MontoPrestamo, 2, '.', ',');
$MontoTotal = number_format($MontoTotal, 2, '.', ',');
$Avaluo = number_format($Avaluo, 2, '.', ',');
$GastoAdmin = number_format($GastoAdmin, 2, '.', ',');

$i = 1;
$tablaArticulos = '';
$detallePiePagina = '';
$detalleDescripcion = '';
$tipoDescripcion = '';

$query = "SELECT Ar.descripcionCorta,
    Ar.observaciones AS ObsArt, 
    CONCAT ( Aut.marca,' ', Aut.modelo, ' ',Aut.anio ,' ', Aut.color, ' ' , Aut.placas, ' ',Aut.factura, ' ',Aut.num_motor) as detalleAuto, Aut.observaciones AS ObsAuto, 
    Ar.prestamo as PrestamoArt, Ar.avaluo as AvaluoArt,Ar.IMEI, Ar.num_Serie
FROM contratos_tbl as Con 
LEFT JOIN articulo_tbl as Ar on Con.id_Contrato = Ar.id_Contrato 
LEFT JOIN auto_tbl AS Aut on Con.id_Contrato = Aut.id_Contrato 
            WHERE Con.id_Contrato =$idContrato AND Con.sucursal = $sucursal AND Ar.sucursal = $sucursal";
$tablaArt = $db->query($query);


foreach ($tablaArt as $row) {
    if ($TipFormulario == "1") {
        $tipoDescripcion = 'METALES';
        $detalle = $row["descripcionCorta"];
        $Obs = $row["ObsArt"];
        $avaluoArt = $row["AvaluoArt"];
        $prestamoArt = $row["PrestamoArt"];
        $prestamoArt = number_format($prestamoArt, 2, '.', ',');

    }elseif ($TipFormulario == "2") {
        $tipoDescripcion = 'ELECTRÓNICOS';
        $descripcionCorta = $row["descripcionCorta"];
        $IMEI = $row["IMEI"];
        $num_Serie = $row["num_Serie"];
        $detalle = $descripcionCorta . ',Serie/IMEI: '. $num_Serie .' '. $IMEI ;

        $Obs = $row["ObsArt"];
        $avaluoArt = $row["AvaluoArt"];
        $prestamoArt = $row["PrestamoArt"];
        $prestamoArt = number_format($prestamoArt, 2, '.', ',');

    }elseif ($TipFormulario == "3") {
        $tipoDescripcion = 'AUTO';
        $detalle = $row["detalleAuto"];
        $Obs = $row["ObsAuto"];
        $avaluoArt = $Avaluo;
        $prestamoArt = $MontoPrestamo;
    }

    $detalleDescripcion = $detalle . " " . $Obs;
    $tablaArticulos .= '
                                <tr>
                                    <td class="tableFormat " colspan="2" align="center"><label  class="letraNormal">' . $tipoDescripcion . '</label></td>
                                    <td class="tableFormat"  colspan="5"><label  class="letraNormal">' . $detalleDescripcion . '</label></td>
                                    <td class="tableFormat" colspan="2" align="center"><label  class="letraNormal">$ ' . $avaluoArt . '</label></td>
                                    <td class="tableFormat" colspan="2" align="center"><label  class="letraNormal">$ ' . $prestamoArt . '</label></td>
                                    <td class="tableFormat" align="center"><label  class="letraNormal">' . $Aforo . ' %</label></td>
                                </tr>';

    if($i==1){
        $detallePiePagina .= $detalleDescripcion;
    }else{
        $detallePiePagina .= ' // ' . $detalleDescripcion;
    }
    $i++;
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
         
          .letraExtraGrandeNegrita {
            font-size: 1.8em;
            font-weight: bold;
            }
            
          .letraGrandeNegrita{
          font-size: 1.1em;
          font-weight: bold;
         }
          .letraChicaNegrita{
          font-size: .5em;
          font-weight: bold;
         }
          .letraNormal{
          font-size: .6em;
         }
          .letraGrande{
          font-size: 1.1em;
         }
          .letraChica{
          font-size: .5em;
         }
            
          .tituloCelda{
              background-color: #ebebe0
            }
            
            html {
                margin: 35mm 10mm 25mm 10mm;
            }
    </style>
</head>
<body><form>
    <table width="80%" border="1" align="center">
        <tbody>
        <tr>
            <td colspan="12" align="right">
                <label class="letraGrandeNegrita"> ' . $reimpresion . ' Contrato No. ' . $idContrato . '</label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <label class="letraChica">
                    Fecha de celebración del contrato: CIUDAD DE MEXICO a ' . $FechaCreacion . '<br>
                    <b>CONTRATO DE MUTUO CON INTERÉS Y GARANTÍA PRENDARIA (PRÉSTAMO)</b>, que celebran: ' . $NombreCasa . ',<b>"EL PROVEEDOR"</b>, con
                    domicilio en: ' . $direccionCasa . ', R.F.C.: ' . $rfcCasa . ', Tel.: ' . $telefonoCasa . ', correo electrónico: ' . $correoCasa . ', y el <b>"EL CONSUMIDOR"</b>,
                   <u><b> ' . $NombreCompleto . '</b></u> que se identifica con: ' . $Identificacion . ' número: ' . $NumIde . ' con domicilio en: ' . $Direccion . '
                    Tel.: ' . $Telefono . ' y Cel: ' . $Celular . 'correo electrónico:' . $Correo . '<br>
                    quien designa como cotitular a:' . $Cotitular . ' y beneficiario a: ' . $Beneficiario . ' solo para efectos de este contrato.
                </label>
            </td>
        </tr>
        <tr class="tituloCelda">
            <td colspan="2" rowspan="2" align="center"><label class="letraNormalNegrita">Cat<br> Costo Anual Total </label></td>
            <td colspan="2" rowspan="2" align="center"><label class="letraNormalNegrita">TASA DE <br>INTERÉS <br>ANUAL </label></td>
            <td colspan="2" rowspan="2" align="center"><label class="letraNormalNegrita">MONTO DEL<br> PRÉSTAMO<br> (MUTUO) </label></td>
            <td colspan="2" rowspan="2" align="center"><label class="letraNormalNegrita">MONTO TOTAL A<br> PAGAR </label></td>
            <td colspan="4" align="center"><label class="letraNormalNegrita">COMISIONES</label></td>
        </tr>
        <tr class="tituloCelda">
            <td colspan="4" align="center"><label class="letraNormalNegrita"> Montos y cláusulas </label></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <label class="letraNormal" >
                    Para fines<br>
                    informativos<br>
                    y de comparación<br>
                    155.70 %<br>
                    FIJO SIN IVA
                </label>
            </td>
            <td colspan="2" align="center">
                <label class="letraNormal">
                    <u>36.00 % </u><br>
                    TASA FIJA
                </label>
            </td>
            <td colspan="2" align="center">
                <label class="letraNormal">
                    <u>$ ' . $MontoPrestamo . '</u><br>
                    Moneda Nacional </label>
                </label>
            </td>
            <td colspan="2" align="center"><label class="letraNormal">
                $ ' . $porDesempeño . '</u><br>
                Estimado al plazo máximo de desempeño<br>
                o refrendo.</label>
            </td>
            <td colspan="4">
                <label class="letraChica">
                    Comisión por Almacenaje:
                    <u>' . $Almacenaje . ' % </u>(Claus. 11a)<br>
                    Comisión por Avalúo <u>$ 0.00</u> (Claus. 11b)<br>
                    Comisión por Comercialización: <u>10.00%</u> (Claus. 11c)<br>
                    Comisión por reposición de contrato <u>$ 0.00</u> (Claus. 11d)<br>
                    Desempeño Extemporáneo: <u>0.00%</u> (Claus. 11e)<br>
                    Gastos de Administración <u>$ '. $GastoAdmin .'</u> (Claus 11f)<br> 
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12" class="tituloCelda">
                <label class="letraChica">
                    <b>METODOLOGIA DE CALCULO DE INTERÉS: TASA DE INTERÉS FIJA DIVIDIDA ENTRE 360 DIAS POR EL IMPORTE DEL SALDO INSOLUTO DEL PRÉSTAMO POR EL<br> 
                                NÚMERO DE DÍAS EFECTIVAMENTE TRANSCURRIDOS.</b>
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <label class="letraChica">
                    PLAZO DEL PRÉSTAMO (Fecha limite para el refrendo o desempeño):' . $FechaAlmoneda . '. Total de refrendos aplicables:<br>
                                Su pago sera: ' . $diasLabel . '. Metodos de pago aceptado: efectivo. En caso de que el vencimiento sea en dia inhabil, se considerara el dia habil siguiente.
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12" class="tituloCelda" align="center">
                <label class="letraNormal">
                    Opciones de pago para refrendo o desempeño
                </label>
            </td>
        </tr>
        <tr class="tituloCelda">
            <td colspan="6" align="center">
                <label class="letraNormal">
                    MONTO
                </label>
            </td>
            <td colspan="6" align="center">
                <label class="letraNormal">
                    TOTAL A PAGAR
                </label>
            </td>
        </tr>
        <tr class="tituloCelda" align="center">
            <td>
                <label class="letraNormal">
                    NÚMERO
                </label>
            </td>
            <td colspan="2">
                <label class="letraNormal">
                    IMPORTE MUTUO
                </label>
            </td>
            <td>
                <label class="letraNormal">
                    INTERESES
                </label>
            </td>
            <td>
                <label class="letraNormal">
                    ALMACENAJE
                </label>
            </td>
            <td><label class="letraNormal">
                    IVA
                </label>
            </td>
            <td colspan="2">
                <label class="letraNormal">
                    POR REFRENDO
                </label>
            </td>
            <td colspan="2">
                <label class="letraNormal">
                    POR DESEMPEÑO
                </label>
            </td>
            <td colspan="2">
                <label class="letraNormal">
                    CUANDO SE<br>
                    REALIZAN LOS<br>
                    PAGOS
                </label>
            </td>
        </tr>
        <tr>
            <td align="center">
                <label class="letraNormal">
                    1
                </label>
            </td>
            <td colspan="2" align="center">
                <label class="letraNormal">
                    $ ' . $MontoPrestamo . '
                </label>
            </td>
            <td align="center">
                <label class="letraNormal">
                    $ ' . $calculaInteres . '
                </label>
            </td>
            <td align="center">
                <label class="letraNormal">
                    $ ' . $calculaALm . '
                </label>
            </td align="center">
            <td width="80px"><label class="letraNormal">
                    $ ' . $calculaIva . '
                </label>
            </td>
            <td colspan="2" align="center">
                <label class="letraNormal">
                    $ ' . $porRefrendo . '
                </label>
            </td>
            <td colspan="2" align="center">
                <label class="letraNormal">
                    $ ' . $porDesempeño . '
                </label>
            </td>
            <td colspan="2" align="center">
                <label class="letraNormal">
                    ' . $FechaVenc . '
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="5"><label class="letraNormalNegrita"> <b>COSTO MENSUAL TOTAL</b></label></td>
            <td colspan="7"><label class="letraNormalNegrita"> <b>COSTO DIARIO TOTAL</b></label></td>
        </tr>
        <tr>
            <td colspan="5">
                <label class="letraNormalNegrita"> 
                    Para fines informativos y de comparación:<br>
                    ' . $tasaIvaTotal . '% FIJO SIN IVA
                </label>
            </td>
            <td colspan="7">
                <label class="letraNormalNegrita"> 
                    Para fines informativos y de comparación:<br>
                    ' . $tasaDiaria . '% FIJO SIN IVA
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <label class="letraChicaNegrita">
                    <b>"Cuide su capacidad de pago, generalmente no debe de exceder del 35% de sus ingresos".<br>
                    "Si usted no paga en tiempo y forma corre el riesgo de perder sus prendas".</b>
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <label class="letraChicaNegrita">
                    GARANTÍA: Para garantizar el pago de este préstamo, EL CONSUMIDOR deja en garantia el bien que se describe a continuacion:
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12" class="tituloCelda" align="center">
                <label class="letraNormalNegrita">
                    DESCRIPCIÓN DE LA PRENDA
                </label>
            </td>
        </tr>
        <tr class="tituloCelda" align="center">
            <td colspan="2"><label class="letraNormalNegrita">DESCRIPCIÓN GENÉRICA</label></td>
            <td colspan="5"><label class="letraNormalNegrita">CARACTERISTICAS</label></td>
            <td colspan="2"><label class="letraNormalNegrita">AVALÚO</label></td>
            <td colspan="2"><label class="letraNormalNegrita">PRÉSTAMO</label></td>
            <td ><label class="letraNormalNegrita">%PRÉSTAMO SOBRE<br>AVALÚO</label>
            </td>
        </tr>';
$contenido .= $tablaArticulos;
$contenido .= ' 
        <tr>
            <td colspan="5"><label class="letraNormalNegrita">MONTO DEL AVALUO: </label></td>
            <td colspan="7"><label class="letraNormalNegrita">$ ' . $Avaluo . '</label></td>
        </tr>
        <tr>
            <td colspan="5"><label class="letraNormalNegrita">PORCENTAJE DEL PRÉSTAMO SOBRE EL AVALÚO:</label></td>
            <td colspan="7"><label class="letraNormalNegrita">&nbsp;' . $Aforo . '%</label></td>
        </tr>
        <tr>
            <td colspan="5"><label class="letraNormalNegrita">FECHA DE INICIO DE COMERCIALIZACIÓN:</label></td>
            <td colspan="7"><label class="letraNormalNegrita">' . $FechaAlmoneda . '</label></td>
        </tr>
        <tr>
            <td colspan="5"><label class="letraChicaNegrita">El monto del préstamo se realizara en:</label></td>
            <td colspan="7"><label class="letraChicaNegrita">Efectivo</label>
            </td>
        </tr>
        <tr>
            <td colspan="5"><label class="letraChicaNegrita">FECHA LÍMITE DE FINIQUITO: </label></td>
            <td colspan="7"><label class="letraChicaNegrita">Terminos y condiciones para recibir pagos anticipados: Clausula 13 (decimo Tercera, Inciso b)</label>
            </td>
        </tr>
        <tr>
            <td colspan="12"><label class="letraChicaNegrita">Estos conceptos causaran el pago al impuesto del valor agregado (IVA) a la tasa del ' . $Iva . '%
            </label></td>
        </tr>
        <tr>
            <td colspan="12"><label class="letraChicaNegrita">*EL PROCEDIMIENTO PARA DESEMPEÑO, REFRENDO, FINIQUITO Y RECLAMO DEL REMANENTE SE ENCUENTRA
                DESCRITO EN EL CONTRATO.</label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <label class="letraChicaNegrita">
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
        <tr>
            <td colspan="12" class="tituloCelda">
                <label class="letraChicaNegrita">
                    Contrato de Adhesión registrado en el Registro Público de Contratos de Adhesión de la Procuraduría Federal del Consumidor, bajo el número 11327-2018 <br>
                    de fecha 29-oct-2018.  El proveedor tiene la obligación de entregar al consumidor el documento en el cual se señale la descripción del préstamo, saldos, <br>
                    movimientos y la descripción de la Prenda en garantía.
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraChicaNegrita">DESEMPEÑO</label></td>
            <td colspan="6"><label class="letraChicaNegrita">FIRMAS</label></td>
        </tr>
        <tr>
            <td colspan="6">
                <label class="letraChicaNegrita">
                    El CONSUMIDOR recoge en el acto y a su entera satisfacción la(s) prenda(s) arriba descritas, por <br>
                    lo que otorga a ' . $NombreCasa . ' el finiquito más amplio que en derecho corresponda, <br>
                    liberándolo de cualquier responsabilidad jurídica que hubiere surgido ó pudiese surgir en relación <br>
                    al contrato y la prenda. ' . $FechaAlmoneda . '
                </label>    
            </td>
            <td colspan="6">
                <label class="letraChicaNegrita">
                    FECHA: ' . $FechaCreacion . ' <br>
                    ' . $NombreCompleto . '
                    "EL CONSUMIDOR"
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center"><label class="letraChicaNegrita">' . $NombreCompleto . '<br>
                    <br>
                     <br>  
                      <br>              
                EL CONSUMIDOR</label>
            </td>
            <td colspan="4" align="center"><label class="letraChicaNegrita">
                    ' . $NombreCasa . '<br>
                    <br>
                     <br>  
                      <br>             
                    EL PROVEEDOR
                </label>
            </td>
            <td colspan="4" align="center"><label class="letraChicaNegrita">' . $NombreUsuario . '
                <br>
                <br>
                <br>  
                <br>  
                EL VALUADOR</label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <label class="letraChicaNegrita">
                    ' . $horarioCasa .'<br>
                    Para todo lo relativo a la interpretación, aplicación y cumplimiento del contrato, LAS PARTES acuerdan
                    someterse en la vía administrativa a la Procuraduría Federal del Consumidor, y en caso de subsistir
                    diferencias, a la jurisdicción de los tribunales competentes del lugar donde se celebra este Contrato.
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12" align="center">
             <hr style="border-style: dashed;">
            </td>
        </tr>
        <tr>
            <td colspan="4">
            </td>
            <td colspan="4">
            <label class="letraExtraGrandeNegrita">NO.
              ' . $idContrato . '</label>
            </td>
            <td colspan="4">
                 <label class="letraExtraGrandeNegrita">NO.
              ' . $idContrato . '</label>
            </td>
        </tr>
        <tr>
            <td colspan="12"><label class="letraNormalNegrita">
                NOMBRE:   
              ' . $NombreCompleto . '
              &nbsp;&nbsp;&nbsp;&nbsp;
                PRÉSTAMO:&nbsp;$ ' . $MontoPrestamo . '</label>
            </td>
        </tr>
        <tr>
            <td colspan="12"><label class="letraNormalNegrita">
                FECHA: ' . $FechaCreacion . ' PLAZO: ' . $PlazoMov . ' <br>
                PRENDA:' . $detallePiePagina . '</label>
            </td>
        </tr>';
$contenido .= ' </tbody></table></form></body></html>';
echo $contenido;
exit;

$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
//letter carta, legal oficio
//Vertical
if($sucursal==1){
    $dompdf->setPaper("legal", "portrait");
}else if($sucursal==2){
    $dompdf->setPaper("legal", "portrait");
}
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);