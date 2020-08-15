<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
require_once(WEB_PATH . "dompdf/autoload.inc.php");
include_once(BASE_PATH . "Conexion.php");
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
    $db = "u672450412_Mexicash";
}

$mysql = new  mysqli($server, $user, $password, $db);


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

$reimpresion='';
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
                Con.total_Prestamo AS MontoPrestamo,Con.tasa AS Tasa,Con.alm AS Almacenaje, 
                Con.seguro AS Seguro,Con.Iva AS Iva,Mov.fechaAlmoneda AS FechaAlmoneda, Con.dias AS Dias,Mov.fechaVencimiento AS FechaVenc,
                Con.total_Avaluo AS Avaluo,CONCAT (Usu.apellido_Pat, ' ',Usu.apellido_Mat,' ', Usu.nombre) as NombreUsuario,
                Con.id_Formulario AS TipFormulario, Con.Aforo AS Aforo
                FROM contratos_tbl AS Con 
                INNER JOIN cliente_tbl AS Cli on Con.id_Cliente = Cli.id_Cliente 
                INNER JOIN cat_cliente AS CatCli on Cli.tipo_Identificacion = CatCli.id_Cat_Cliente
                INNER JOIN cat_estado As CatEst on Cli.estado = CatEst.id_Estado
                INNER JOIN contrato_mov_tbl AS Mov on Con.id_Contrato = Mov.id_contrato 
                INNER JOIN bit_cierrecaja AS Caj on Con.id_cierreCaja = Caj.id_CierreCaja  
                INNER JOIN usuarios_tbl AS Usu on Caj.usuario = Usu.id_User 
                WHERE Con.id_Contrato =$idContrato ";
$resultado = $mysql->query($query);
foreach ($resultado as $row) {
    //echo $fila['Contrato'];
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
    //$MontoTotal = $row["MontoTotal"];
    $MontoTotal = 0;
    $Tasa = $row["Tasa"];
    $Almacenaje = $row["Almacenaje"];
    $Seguro = $row["Seguro"];
    $Iva = $row["Iva"];
    //Tabla 2
    $FechaAlmoneda = $row["FechaAlmoneda"];
    $Dias = $row["Dias"];
    $FechaVenc = $row["FechaVenc"];
    //$Intereses = $row["Intereses"];
    $Intereses = 0;
    $Avaluo = $row["Avaluo"];

    $TipFormulario = $row["TipFormulario"];
    $Aforo = $row["Aforo"];

    $NombreUsuario = $row["NombreUsuario"];

    if ($Dias == 30) {
        $diasLabel = "1 Mes";
    } else if ($Dias == 0) {
        $diasLabel = "1 Día";
        $Dias =1;
    }else {
        $diasLabel = $Dias;
    }
    $ivaPorcentaje = '.' . $Iva;
    $ivaPorcentaje = floatval($ivaPorcentaje);
    //Se saca los porcentajes mensuales
    $calculaInteres = round($MontoPrestamo*$Tasa/100,2);
    $calculaALm = round($MontoPrestamo*$Almacenaje/100,2);
    $calculaSeg = round($MontoPrestamo*$Seguro/100,2);
    $calculaIva = round($MontoPrestamo*$ivaPorcentaje/100,2);
    $totalInteres = $calculaInteres + $calculaALm + $calculaSeg + $calculaIva;

    //interes por dia

    $interesDia = $totalInteres / $Dias;
    //TASA:
    $tasaIvaTotal = $Tasa + $Almacenaje + $Seguro + $Iva;
    $tasaDiaria = round($tasaIvaTotal /$Dias,2);


}
$FechaCreacion = date("d-m-Y", strtotime($FechaCreacion));
$FechaAlmoneda = date("d-m-Y", strtotime($FechaAlmoneda));
$FechaVenc = date("d-m-Y", strtotime($FechaVenc));

$MontoPrestamo = number_format($MontoPrestamo, 2,'.',',');
$MontoTotal = number_format($MontoTotal, 2,'.',',');
$Avaluo = number_format($Avaluo, 2,'.',',');

$calculaALm = number_format($calculaALm, 2,'.',',');
$calculaInteres = number_format($calculaInteres, 2,'.',',');
$calculaIva = number_format($calculaIva, 2,'.',',');
$Intereses = number_format($Intereses, 2,'.',',');

if (!isset($_GET['pdf'])) {

    if (!isset($_GET['pdf'])) {

        $contenido = '<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../../JavaScript/funcionesContrato.js"></script>
    <style>
        .letraExtraGrandeNegrita {
            font-size: 1.9em;
            font-weight: bold;
        }
    
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
        .tituloCelda{
          background-color: #ebebe0
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
<body><form>
    <table width="80%" border="1" align="center">
        <tbody>
        <tr>
            <td colspan="12" align="right">
                <label class="letraGrandeNegrita"> Contrato No. ' . $idContrato . '</label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <label class="letraChica">
                    Fecha de celebración del contrato: CIUDAD DE MEXICO a ' . $FechaCreacion . '
                </label>
                <label class="letraChicaNegrita">
                    CONTRATO DE MUTUO CON INTERÉS Y GARANTÍA PRENDARIA (PRESTAMO),</label>
                <label class="letraChica">
                    que celebran: MIRIAM GAMA VAZQUEZ,
                    "EL PROVEEDOR", con
                    domicilio en: AV. AZTECAS 4380 CIUDAD DE MEXICO NA , R.F.C.: GAVM800428KQ3, Tel.: 5525252125, correo
                    electrónico: na, y el "EL CONSUMIDOR",
                    ' . $NombreCompleto . ' que se identifica con:
                    número: ' . $NumIde . ' con domicilio en:
                    ' . $Direccion . '
                    Tel.: ' . $Telefono . ' y Cel: ' . $Celular . 'correo electrónico:' . $Correo . '
                    quien designa como cotitular a:' . $Cotitular . '
                    y beneficiario a: ' . $Beneficiario . '
                </label>
            </td>
        </tr>
        <tr class="tituloCelda">
            <td colspan="2" rowspan="2"><label class="letraNormalNegrita">Cat Costo Anual Total </label></td>
            <td colspan="2" rowspan="2"><label class="letraNormalNegrita">TASA DE INTERES ANUAL </label></td>
            <td colspan="2" rowspan="2"><label class="letraNormalNegrita">MONTO DEL PRESTAMO (MUTUO) </label></td>
            <td colspan="2" rowspan="2"><label class="letraNormalNegrita">MONTO TOTAL A PAGAR </label></td>
            <td colspan="4" ><label class="letraNormalNegrita">COMISIONES Montos y cláusulas </label></td>
        </tr>
        <tr class="tituloCelda">
            <td colspan="4"><label class="letraNormalNegrita"> Montos y cláusulas </label></td>
        </tr>
        <tr>
            <td colspan="2"><label class="letraNormal">Para fines
                    informativos
                    y de comparación
                    155.70 %???
                    FIJO SIN IVA
            </td>
            <td colspan="2">
                <label class="letraNormal">
                    36.00 % ????
                    TASA FIJA
                </label>
            </td>
            <td colspan="2"><label class="letraNormal">$ ' . $MontoPrestamo . '<br>
                    Moneda Nacional
                </label>
            </td>
            <td colspan="2"><label class="letraNormal">$ ' . $MontoTotal . '<br>
                    Estimado al plazo máximo de desempeño
                    o refrendo.
                </label>
            </td>
            <td colspan="4">
                <label class="letraChica">
                    Comisión por Almacenaje:' . $Almacenaje . ' % (Claus. 11 a)
                    Comisión por Avalúo $ 0.00 ??(Claus. 11 b)
                    Comisión por Comercialización: 10.00% ??(Claus. 11
                    c)
                    Comisión por reposición de contrato $ 0.00 ??(Claus. 11 d)
                    Desempeño Extemporáneo: 0.00% ??(Claus. 11 e)
                    Gastos de Administración $ 0.00 ???(Claus 11 f)
                </label>

            </td>
        </tr>
        <tr>
            <td colspan="12" class="tituloCelda">
                <label class="letraChica">
                    METODOLOGIA DE CALCULO DE INTERES: TASA DE INTERES FIJA DIVIDIDA ENTRE 360 DIAS POR EL
                    IMPORTE DEL SALDO INSOLUTO DEL PRESTAMO POR EL
                    NUMERO DE DIAS EFECTIVAMENTE TRANSCURRIDOS.
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <label class="letraChica">
                    PLAZO DEL PRESTAMO (Fecha limite para el refrendo o desempeño):' . $FechaAlmoneda . '.
                    Total de
                    refrendos aplicables:
                    Su pago sera: ' . $diasLabel . '. En caso de que el vencimiento sea en dia inhabil, se
                    considerara el dia habil siguiente.
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12" class="tituloCelda" align="center">
                <label class="letraNormal">
                    Opciones de pago
                    para refrendo o
                    desempeño
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
                    CUANDO SE
                    REALIZAN LOS
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
                    $ '. $MontoPrestamo .'
                </label>
            </td>
            <td align="center">
                <label class="letraNormal">
                    $ ' .$calculaALm. '
                </label>
            </td>
            <td align="center">
                <label class="letraNormal">
                    $ ' .$calculaInteres. '
                </label>
            </td align="center">
            <td width="80px"><label class="letraNormal">
                    $ ' .$calculaIva. '
                </label>
            </td>
            <td colspan="2" align="center">
                <label class="letraNormal">
                    $ ' .$Intereses. '
                </label>
            </td>
            <td colspan="2" align="center">
                <label class="letraNormal">
                    $ ' .$MontoTotal. '
                </label>
            </td>
            <td colspan="2" align="center">
                <label class="letraNormal">
                    ' .$FechaVenc. '
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraNormalNegrita"> COSTO MENSUAL TOTAL</label></td>
            <td colspan="6"><label class="letraNormalNegrita"> COSTO DIARIO TOTAL</label></td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraNormalNegrita"> Para fines informativos y de comparación:
                    '.$tasaIvaTotal.'% FIJO SIN IVA</label>
            </td>
            <td colspan="6"><label class="letraNormalNegrita"> Para fines informativos y de comparación:
                    '.$tasaDiaria.'% FIJO SIN IVA</label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <label class="letraChicaNegrita">
                    "Cuide su capacidad de pago, generalmente no debe de exceder del 35% de sus ingresos".
                    "Si usted no paga en tiempo y forma corre el riesgo de perder sus prendas".
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <label class="letraChicaNegrita">
                    GARANTÍA: Para garantizar el pago de este prestamo, EL CONSUMIDOR deja en garantia el bien que se
                    describe a continuacion:
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12" class="tituloCelda" align="center">
                <label class="letraNormalNegrita">
                    DESCRIPCION DE LA PRENDA
                </label>
            </td>
        </tr>
        <tr class="tituloCelda" align="center">
            <td>
                <label class="letraNormalNegrita">DESCRIPCIÓN
                    GENÉRICA
                </label>
            </td>
            <td colspan="5"><label class="letraNormalNegrita">CARACTERISTICAS</label></td>
            <td colspan="2"><label class="letraNormalNegrita">AVALÚO</label></td>
            <td colspan="2"><label class="letraNormalNegrita">PRÉSTAMO</label></td>
            <td colspan="2"><label class="letraNormalNegrita">%PRÉSTAMO SOBRE
                    AVALÚO</label>
            </td>
        </tr>';
        $i = 1;
        $tablaArticulos = '';
        $detallePiePagina = '';
        $detalleDescripcion ='';
        $tipoDescripcion ='';
        if($TipFormulario==1){
            $query = "SELECT Ar.detalle AS Detalle, TA.descripcion AS TipoMetal, TK.descripcion as Kilataje,
                            TC.descripcion as Calidad FROM contratos_tbl as Con 
                            INNER JOIN articulo_tbl as Ar on Con.id_Contrato =  Ar.id_Contrato
                            LEFT JOIN cat_tipoarticulo as TA on AR.tipo = TA.id_tipo
                            LEFT JOIN cat_kilataje as TK on AR.kilataje = TK.id_Kilataje
                            LEFT JOIN cat_calidad as TC on AR.calidad = TC.id_calidad
                            WHERE Con.id_Contrato =$idContrato ";
            $tablaArt = $mysql->query($query);
            foreach ($tablaArt as $row) {
                $tipoDescripcion = 'Metales';
                $TipoMetal = $row["TipoMetal"];
                $Kilataje = $row["Kilataje"];
                $Calidad = $row["Calidad"];
                $Detalle = $row["Detalle"];
                $detalleDescripcion = $TipoMetal . ' '. $Kilataje  . ' '. $Calidad . ' '. $Detalle;
                $detallePiePagina .= $detalleDescripcion . '//';
                $tablaArticulos .= '<tr>
            <td align="center">' . $tipoDescripcion . '</td>
            <td align="center" colspan="5">' . $detalleDescripcion . '</td>
            <td align="center" colspan="2">$ ' . $Avaluo . '</td>
            <td align="center" colspan="2">$ ' . $MontoPrestamo . '</td>
            <td align="center" colspan="2">&nbsp;'. $Aforo .' %</td></tr>';
                $i++;
            }

        }else if ($TipFormulario==2){

            $query = "SELECT ET.descripcion AS TipoElectronico, EM.descripcion AS MarcaElectronico, EMOD.descripcion AS ModeloElectronico,
                            Ar.detalle AS Detalle FROM contrato_tbl as Con 
                            INNER JOIN articulo_tbl as Ar on Con.id_Contrato =  Ar.id_Contrato
                            LEFT JOIN cat_electronico_tipo as ET on Ar.tipo = ET.id_tipo
                            LEFT JOIN cat_electronico_marca as EM on Ar.marca = EM.id_marca
                            LEFT JOIN cat_electronico_modelo as EMOD on Ar.modelo = EMOD.id_modelo
                            WHERE Con.id_Contrato =$idContrato ";
            $tablaArt = $mysql->query($query);
            foreach ($tablaArt as $row) {
                $tipoDescripcion = 'Electronicos';
                $TipoElectronico = $row["TipoElectronico"];
                $MarcaElectronico = $row["MarcaElectronico"];
                $ModeloElectronico = $row["ModeloElectronico"];
                $detalleDescripcion = $TipoElectronico . ' '. $MarcaElectronico  . ' '. $ModeloElectronico . ' '. $Detalle;
                $detallePiePagina .= $detalleDescripcion . '//';
                $tablaArticulos .= '<tr>
            <td  align="center">' . $tipoDescripcion . '</td>
            <td colspan="5"  align="center">' . $detalleDescripcion . '</td>
            <td colspan="2"  align="center">$ ' . $Avaluo . '</td>
            <td colspan="2"  align="center">$ ' . $MontoPrestamo . '</td>
            <td colspan="2" align="center" >&nbsp; '. $Aforo .'%</td></tr>';
                $i++;
            }

        }else if ($TipFormulario==3){
            $query = "SELECT Aut.marca AS Marca, Aut.modelo AS Modelo, Aut.anio AS Anio,
                    Aut.placas AS Placas, Aut.factura AS Factura, Aut.num_motor AS NumMotor,Aut.observaciones AS Detalle,
                    Aut.color as Color 
                    FROM auto_tbl AS Aut
                    WHERE Aut.id_Contrato  =$idContrato ";
            $tablaArt = $mysql->query($query);
            foreach ($tablaArt as $row) {
                $tipoDescripcion = 'Auto';
                $Marca = $row["Marca"];
                $Modelo = $row["Modelo"];
                $Anio = $row["Anio"];
                $Color = $row["Color"];
                $Placas = $row["Placas"];
                $Factura = $row["Factura"];
                $NumMotor = $row["NumMotor"];
                $Detalle = $row["Detalle"];
                $detalleDescripcion = $Marca . ' '. $Modelo  . ' '. $Anio . ' '. $Color. ' '. $Placas. ' '. $Factura. ' '. $NumMotor. ' '. $Detalle;
                $detallePiePagina .= $detalleDescripcion . '//';
                $tablaArticulos .= '<tr>
            <td  align="center">' . $tipoDescripcion . '</td>
            <td colspan="5"  align="center">' . $detalleDescripcion . '</td>
            <td colspan="2"  align="center">$ ' . $Avaluo . '</td>
            <td colspan="2"  align="center">$ ' . $MontoPrestamo . '</td>
            <td colspan="2"  align="center"> &nbsp;'. $Aforo .'%</td></tr>';
                $i++;
            }
        }
        $contenido .= $tablaArticulos;
        $contenido .=' 
        <tr>
            <td colspan="6"><label class="letraNormalNegrita">MONTO DEL AVALUO: </label></td>
            <td colspan="6"><label class="letraNormalNegrita">$ '. $Avaluo . '</label></td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraNormalNegrita">PORCENTAJE DEL PRÉSTAMO SOBRE EL AVALÚO:</label></td>
            <td colspan="6"><label class="letraNormalNegrita">&nbsp;'. $Aforo .'%</label></td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraNormalNegrita">FECHA DE INICIO DE COMERCIALIZACIÓN:</label></td>
            <td colspan="6"><label class="letraNormalNegrita">'. $FechaAlmoneda.'</label></td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraChicaNegrita">El monto del prestamo se realizara en:</label></td>
            <td colspan="6"><label class="letraChicaNegrita">Efectivo X o a la cuenta bancaria del consumidor al numero
                __________________, de la Institucion Financiera __________________.</label>
            </td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraChicaNegrita">FECHA LÍMITE DE FINIQUITO: ???</label></td>
            <td colspan="6"><label class="letraChicaNegrita">Terminos y condiciones para recibir pagos anticipados: Clausula 13 (decimo Tercera, Inciso
                b)</label>
            </td>
        </tr>
        <tr>
            <td colspan="12"><label class="letraChicaNegrita">Estos conceptos causaran el pago al impuesto del valor agregado (IVA) a la tasa del 16%
            </label></td>
        </tr>
        <tr>
            <td colspan="12"><label class="letraChicaNegrita">*EL PROCEDIMIENTO PARA DESEMPEÑO, REFRENDO, FINIQUITO Y RECLAMO DEL REMANENTE SE ENCUENTRA
                DESCRITO EN EL CONTRATO.</label>
            </td>
        </tr>
        <tr>
            <td colspan="12"><label class="letraChicaNegrita">
                DUDAS, ACLARACIONES Y RECLAMACIONES:
                • PARA CUALQUIER DUDA, ACLARACION O RECLAMACION, FAVOR DE DIRIGIRSE A:
                Domicilio: AV. AZTECAS CIUDAD DE MEXICO NA 4,380 .
                Telefono: 5525252125, Correo electronico: na, Pagina de internet: en un horario de EL HORARIO DE
                SERVICIO AL PÚBLICO DE ESTE ESTABLECIMIENTO ES DE LUNES A VIERNES DE
                8:30 A 20:00 HRS Y SABADOS DE 09:00 A 15:00 HRS.
                • O EN SU CASO A PROFECO A LOS TELEFONOS: 55 68 87 22 O AL 01 800 468 87 22 , PAGINA DE INTERNET:
                www.gob.mx/profeco
                ESTADO DE CUENTA/CONSULTA DE MOVIMIENTOS: NO APLICA O CONSULTA EN _______________________________.
                EL HORARIO DE SERVICIO AL PUBLICO EN ESTE ESTABLECIMIENTO ES DE : EL HORARIO DE SERVICIO AL PÚBLICO DE
                ESTE ESTABLECIMIENTO ES DE LUNES A
                VIERNES DE 8:30 A 20:00 HRS Y SABADOS DE 09:00 A 15:00 HRS. Para todo lo relativo a la interpretación,
                aplicación y cumplimiento del contrato, LAS PARTES acuerdan
                someterse en la vía administrativa a la Procuraduría Federal del Consumidor, y en caso de subsistir
                diferencias, a la jurisdicción de los tribunales competentes del lugar donde se
                celebra este Contrato.
                GERARDO CRUZ PEREZ
                FECHA: 09-ene-2020
                3,500.00
                Contrato de Adhesión registrado en el Registro Público de Contratos de Adhesión de la Procuraduría
                Federal del Consumidor,
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12" class="tituloCelda">
            <label class="letraChicaNegrita">
                Contrato de Adhesión registrado en el Registro Público de Contratos de Adhesión de la Procuraduría
                Federal del Consumidor, bajo el número 11327-2018 de fecha 29-oct-2018. El
                proveedor tiene la obligación de entregar al consumidor el documento en el cual se señale la descripción
                del prestamo, saldos, movimientos y la descripción de la Prenda en garantía.
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraChicaNegrita">DESEMPEÑO</label></td>
            <td colspan="6"><label class="letraChicaNegrita">FIRMAS</label></td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraChicaNegrita">El CONSUMIDOR recoge en el acto y a su entera satisfacción la(s) prenda(s) arriba descritas,
                por
                lo que otorga a MIRIAM GAMA VAZQUEZ el finiquito más amplio que en derecho corresponda,
                liberándolo de cualquier responsabilidad jurídica que hubiere surgido ó pudiese surgir en relación
                al contrato y la prenda. '. $FechaAlmoneda.'</label></td>
            <td colspan="6"><label class="letraChicaNegrita">FECHA: '. $FechaCreacion.' <br>
              '. $NombreCompleto .'
                "EL CONSUMIDOR"
            </td>
        </tr>
        <tr>
            <td colspan="4"><label class="letraChicaNegrita">'. $NombreCompleto .'
                EL CONSUMIDOR</label>
            </td>
            <td colspan="4"><label class="letraChicaNegrita">MIRIAM GAMA VAZQUEZ
                EL PROVEEDOR</label>
            </td>
            <td colspan="4"><label class="letraChicaNegrita">'.$NombreUsuario.'
                EL VALUADOR</label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
            <label class="letraChicaNegrita">F
                EL HORARIO DE SERVICIO AL PUBLICO EN ESTE ESTABLECIMIENTO ES DE : EL HORARIO DE SERVICIO AL PÚBLICO DE
                ESTE ESTABLECIMIENTO ES DE LUNES A
                VIERNES DE 8:30 A 20:00 HRS Y SABADOS DE 09:00 A 15:00 HRS. Para todo lo relativo a la interpretación,
                aplicación y cumplimiento del contrato, LAS PARTES acuerdan
                someterse en la vía administrativa a la Procuraduría Federal del Consumidor, y en caso de subsistir
                diferencias, a la jurisdicción de los tribunales competentes del lugar donde se
                celebra este Contrato.
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12" align="center">
<hr>
            </td>
        </tr>
        <tr>
            <td colspan="4">
            </td>
            <td colspan="4">
            <label class="letraExtraGrandeNegrita">NO.
              '. $idContrato.'</label>
            </td>
            <td colspan="4">
                 <label class="letraExtraGrandeNegrita">NO.
              '. $idContrato.'</label>
            </td>
        </tr>
        <tr>
            <td colspan="12"><label class="letraNormalNegrita">
                NOMBRE:   
              '. $NombreCompleto.'
              &nbsp;&nbsp;&nbsp;&nbsp;
                PRESTAMO:&nbsp;$ '. $MontoPrestamo.'</label>
            </td>
        </tr>
        <tr>
            <td colspan="12"><label class="letraNormalNegrita">
                FECHA: '. $FechaCreacion .' PLAZO: 1 MENSUAL
                DESCRIPCIÓN:'. $detallePiePagina.'</label>
            </td>
        </tr>';
        $contenido .= '<tr><td align="center" colspan="12">
        <input type="button" class="btn btnGenerarPDF" value="Generar PDF"  onclick="verPDF(' . $idContrato . ');" >
        </td></tr>';
        $contenido .=' </tbody></table></form></body></html>';
        echo $contenido;
        exit;
    }
}
$contenido = '<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
          .letraNormalNegrita{
              font-size: .7em;
              font-weight: bold;
            }
         
          .letraExtraGrandeNegrita {
                font-size: 2em;
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
                    Fecha de celebración del contrato: CIUDAD DE MEXICO a ' . $FechaCreacion . '
                </label>
                <label class="letraChicaNegrita">
                    CONTRATO DE MUTUO CON INTERÉS Y GARANTÍA PRENDARIA (PRÉSTAMO),</label>
                <label class="letraChica">
                    que celebran: MIRIAM GAMA VAZQUEZ,
                    "EL PROVEEDOR", con
                    domicilio en: AV. AZTECAS 4380 CIUDAD DE MEXICO NA , R.F.C.: GAVM800428KQ3, Tel.: 5525252125, correo
                    electrónico: na, y el "EL CONSUMIDOR",
                    ' . $NombreCompleto . ' que se identifica con:
                    número: ' . $NumIde . ' con domicilio en:
                    ' . $Direccion . '
                    Tel.: ' . $Telefono . ' y Cel: ' . $Celular . 'correo electrónico:' . $Correo . '
                    quien designa como cotitular a:' . $Cotitular . '
                    y beneficiario a: ' . $Beneficiario . '
                </label>
            </td>
        </tr>
        <tr class="tituloCelda">
            <td colspan="2" rowspan="2"><label class="letraNormalNegrita">Cat Costo Anual Total </label></td>
            <td colspan="2" rowspan="2"><label class="letraNormalNegrita">TASA DE INTERÉS ANUAL </label></td>
            <td colspan="2" rowspan="2"><label class="letraNormalNegrita">MONTO DEL PRÉSTAMO (MUTUO) </label></td>
            <td colspan="2" rowspan="2"><label class="letraNormalNegrita">MONTO TOTAL A PAGAR </label></td>
            <td colspan="4" ><label class="letraNormalNegrita">COMISIONES Montos y cláusulas </label></td>
        </tr>
        <tr class="tituloCelda">
            <td colspan="4"><label class="letraNormalNegrita"> Montos y cláusulas </label></td>
        </tr>
        <tr>
            <td colspan="2"><label class="letraNormal">Para fines
                    informativos
                    y de comparación
                    155.70 %
                    FIJO SIN IVA
            </td>
            <td colspan="2">
                <label class="letraNormal">
                    36.00 % 
                    TASA FIJA
                </label>
            </td>
            <td colspan="2"><label class="letraNormal">$ ' . $MontoPrestamo . '<br>
                    Moneda Nacional
                </label>
            </td>
            <td colspan="2"><label class="letraNormal">$ ' . $MontoTotal . '<br>
                    Estimado al plazo máximo de desempeño
                    o refrendo.
                </label>
            </td>
            <td colspan="4">
                <label class="letraChica">
                    Comisión por Almacenaje:' . $Almacenaje . ' % (Claus. 11 a)
                    Comisión por Avalúo $ 0.00 (Claus. 11 b)
                    Comisión por Comercialización: 10.00% (Claus. 11
                    c)
                    Comisión por reposición de contrato $ 0.00 (Claus. 11 d)
                    Desempeño Extemporáneo: 0.00% (Claus. 11 e)
                    Gastos de Administración $ 0.00 (Claus 11 f)
                </label>

            </td>
        </tr>
        <tr>
            <td colspan="12" class="tituloCelda">
                <label class="letraChica">
                    METODOLOGIA DE CALCULO DE INTERÉS: TASA DE INTERÉS FIJA DIVIDIDA ENTRE 360 DIAS POR EL
                    IMPORTE DEL SALDO INSOLUTO DEL PRÉSTAMO POR EL
                    NUMERO DE DIAS EFECTIVAMENTE TRANSCURRIDOS.
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <label class="letraChica">
                    PLAZO DEL PRÉSTAMO (Fecha limite para el refrendo o desempeño):' . $FechaAlmoneda . '.
                    Total de
                    refrendos aplicables:
                    Su pago sera: ' . $diasLabel . '. En caso de que el vencimiento sea en dia inhabil, se
                    considerara el dia habil siguiente.
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12" class="tituloCelda" align="center">
                <label class="letraNormal">
                    Opciones de pago
                    para refrendo o
                    desempeño
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
                    CUANDO SE
                    REALIZAN LOS
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
                    $ '. $MontoPrestamo .'
                </label>
            </td>
            <td align="center">
                <label class="letraNormal">
                    $ ' .$calculaALm. '
                </label>
            </td>
            <td align="center">
                <label class="letraNormal">
                    $ ' .$calculaInteres. '
                </label>
            </td align="center">
            <td width="80px"><label class="letraNormal">
                    $ ' .$calculaIva. '
                </label>
            </td>
            <td colspan="2" align="center">
                <label class="letraNormal">
                    $ ' .$Intereses. '
                </label>
            </td>
            <td colspan="2" align="center">
                <label class="letraNormal">
                    $ ' .$MontoTotal. '
                </label>
            </td>
            <td colspan="2" align="center">
                <label class="letraNormal">
                    ' .$FechaVenc. '
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraNormalNegrita"> COSTO MENSUAL TOTAL</label></td>
            <td colspan="6"><label class="letraNormalNegrita"> COSTO DIARIO TOTAL</label></td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraNormalNegrita"> Para fines informativos y de comparación:
                    '.$tasaIvaTotal.'% FIJO SIN IVA</label>
            </td>
            <td colspan="6"><label class="letraNormalNegrita"> Para fines informativos y de comparación:
                    '.$tasaDiaria.'% FIJO SIN IVA</label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <label class="letraChicaNegrita">
                    "Cuide su capacidad de pago, generalmente no debe de exceder del 35% de sus ingresos".
                    "Si usted no paga en tiempo y forma corre el riesgo de perder sus prendas".
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <label class="letraChicaNegrita">
                    GARANTÍA: Para garantizar el pago de este préstamo, EL CONSUMIDOR deja en garantia el bien que se
                    describe a continuacion:
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12" class="tituloCelda" align="center">
                <label class="letraNormalNegrita">
                    DESCRIPCION DE LA PRENDA
                </label>
            </td>
        </tr>
        <tr class="tituloCelda" align="center">
            <td>
                <label class="letraNormalNegrita">DESCRIPCIÓN
                    GENÉRICA
                </label>
            </td>
            <td colspan="5"><label class="letraNormalNegrita">CARACTERISTICAS</label></td>
            <td colspan="2"><label class="letraNormalNegrita">AVALÚO</label></td>
            <td colspan="2"><label class="letraNormalNegrita">PRÉSTAMO</label></td>
            <td colspan="2"><label class="letraNormalNegrita">%PRÉSTAMO SOBRE
                    AVALÚO</label>
            </td>
        </tr>';
$i = 1;
$tablaArticulos = '';
$detallePiePagina = '';
$detalleDescripcion ='';
$tipoDescripcion ='';
if($TipFormulario==1){
    $query = "SELECT Ar.detalle AS Detalle, TA.descripcion AS TipoMetal, TK.descripcion as Kilataje,
                            TC.descripcion as Calidad FROM contratos_tbl as Con 
                            INNER JOIN articulo_tbl as Ar on Con.id_Contrato =  Ar.id_Contrato
                            LEFT JOIN cat_tipoarticulo as TA on AR.tipo = TA.id_tipo
                            LEFT JOIN cat_kilataje as TK on AR.kilataje = TK.id_Kilataje
                            LEFT JOIN cat_calidad as TC on AR.calidad = TC.id_calidad
                            WHERE Con.id_Contrato =$idContrato ";
    $tablaArt = $mysql->query($query);
    foreach ($tablaArt as $row) {
        $tipoDescripcion = 'Metales';
        $TipoMetal = $row["TipoMetal"];
        $Kilataje = $row["Kilataje"];
        $Calidad = $row["Calidad"];
        $detalleDescripcion = $TipoMetal . ' '. $Kilataje  . ' '. $Calidad . ' '. $Detalle;
        $detallePiePagina .= $detalleDescripcion . '//';
        $tablaArticulos .= '<tr>
            <td align="center">' . $tipoDescripcion . '</td>
            <td align="center" colspan="5">' . $detalleDescripcion . '</td>
            <td align="center" colspan="2">$ ' . $Avaluo . '</td>
            <td align="center" colspan="2">$ ' . $MontoPrestamo . '</td>
            <td align="center" colspan="2">&nbsp;'. $Aforo .' %</td></tr>';
        $i++;
    }

}else if ($TipFormulario==2){

    $query = "SELECT ET.descripcion AS TipoElectronico, EM.descripcion AS MarcaElectronico, EMOD.descripcion AS ModeloElectronico,
                            Ar.detalle AS Detalle FROM contratos_tbl as Con 
                            INNER JOIN articulo_tbl as Ar on Con.id_Contrato =  Ar.id_Contrato
                            LEFT JOIN cat_electronico_tipo as ET on Ar.tipo = ET.id_tipo
                            LEFT JOIN cat_electronico_marca as EM on Ar.marca = EM.id_marca
                            LEFT JOIN cat_electronico_modelo as EMOD on Ar.modelo = EMOD.id_modelo
                            WHERE Con.id_Contrato =$idContrato ";
    $tablaArt = $mysql->query($query);
    foreach ($tablaArt as $row) {
        $tipoDescripcion = 'Electronicos';
        $TipoElectronico = $row["TipoElectronico"];
        $MarcaElectronico = $row["MarcaElectronico"];
        $ModeloElectronico = $row["ModeloElectronico"];
        $detalleDescripcion = $TipoElectronico . ' '. $MarcaElectronico  . ' '. $ModeloElectronico . ' '. $Detalle;
        $detallePiePagina .= $detalleDescripcion . '//';
        $tablaArticulos .= '<tr>
            <td  align="center">' . $tipoDescripcion . '</td>
            <td colspan="5"  align="center">' . $detalleDescripcion . '</td>
            <td colspan="2"  align="center">$ ' . $Avaluo . '</td>
            <td colspan="2"  align="center">$ ' . $MontoPrestamo . '</td>
            <td colspan="2" align="center" >&nbsp; '. $Aforo .'%</td></tr>';
        $i++;
    }

}else if ($TipFormulario==3){
    $query = "SELECT Aut.marca AS Marca, Aut.modelo AS Modelo, Aut.anio AS Anio, 
                    Aut.placas AS Placas, Aut.factura AS Factura, Aut.num_motor AS NumMotor,Aut.observaciones AS Detalle,
                    Aut.color as Color 
                    FROM auto_tbl AS Aut
                    WHERE Aut.id_Contrato  =$idContrato ";
    $tablaArt = $mysql->query($query);
    foreach ($tablaArt as $row) {
        $tipoDescripcion = 'Auto';
        $Marca = $row["Marca"];
        $Modelo = $row["Modelo"];
        $Anio = $row["Anio"];
        $Color = $row["Color"];
        $Placas = $row["Placas"];
        $Factura = $row["Factura"];
        $NumMotor = $row["NumMotor"];
        $Detalle = $row["Detalle"];
        $detalleDescripcion = $Marca . ' '. $Modelo  . ' '. $Anio . ' '. $Color. ' '. $Placas. ' '. $Factura. ' '. $NumMotor. ' '. $Detalle;
        $detallePiePagina .= $detalleDescripcion . '//';
        $tablaArticulos .= '<tr>
            <td  align="center">' . $tipoDescripcion . '</td>
            <td colspan="5"  align="center">' . $detalleDescripcion . '</td>
            <td colspan="2"  align="center">$ ' . $Avaluo . '</td>
            <td colspan="2"  align="center">$ ' . $MontoPrestamo . '</td>
            <td colspan="2"  align="center"> &nbsp;'. $Aforo .'%</td></tr>';
        $i++;
    }
}
$contenido .= $tablaArticulos;
$contenido .=' 
        <tr>
            <td colspan="6"><label class="letraNormalNegrita">MONTO DEL AVALUO: </label></td>
            <td colspan="6"><label class="letraNormalNegrita">$ '. $Avaluo . '</label></td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraNormalNegrita">PORCENTAJE DEL PRÉSTAMO SOBRE EL AVALÚO:</label></td>
            <td colspan="6"><label class="letraNormalNegrita">&nbsp;'. $Aforo .'%</label></td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraNormalNegrita">FECHA DE INICIO DE COMERCIALIZACIÓN:</label></td>
            <td colspan="6"><label class="letraNormalNegrita">'. $FechaAlmoneda.'</label></td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraChicaNegrita">El monto del préstamo se realizara en:</label></td>
            <td colspan="6"><label class="letraChicaNegrita">Efectivo X o a la cuenta bancaria del consumidor al numero
                __________________, de la Institucion Financiera __________________.</label>
            </td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraChicaNegrita">FECHA LÍMITE DE FINIQUITO: </label></td>
            <td colspan="6"><label class="letraChicaNegrita">Terminos y condiciones para recibir pagos anticipados: Clausula 13 (decimo Tercera, Inciso
                b)</label>
            </td>
        </tr>
        <tr>
            <td colspan="12"><label class="letraChicaNegrita">Estos conceptos causaran el pago al impuesto del valor agregado (IVA) a la tasa del 16%
            </label></td>
        </tr>
        <tr>
            <td colspan="12"><label class="letraChicaNegrita">*EL PROCEDIMIENTO PARA DESEMPEÑO, REFRENDO, FINIQUITO Y RECLAMO DEL REMANENTE SE ENCUENTRA
                DESCRITO EN EL CONTRATO.</label>
            </td>
        </tr>
        <tr>
            <td colspan="12"><label class="letraChicaNegrita">
                DUDAS, ACLARACIONES Y RECLAMACIONES:
                • PARA CUALQUIER DUDA, ACLARACION O RECLAMACION, FAVOR DE DIRIGIRSE A:
                Domicilio: AV. AZTECAS CIUDAD DE MEXICO NA 4,380 .
                Telefono: 5525252125, Correo electronico: na, Pagina de internet: en un horario de EL HORARIO DE
                SERVICIO AL PÚBLICO DE ESTE ESTABLECIMIENTO ES DE LUNES A VIERNES DE
                8:30 A 20:00 HRS Y SABADOS DE 09:00 A 15:00 HRS.
                • O EN SU CASO A PROFECO A LOS TELEFONOS: 55 68 87 22 O AL 01 800 468 87 22 , PAGINA DE INTERNET:
                www.gob.mx/profeco
                ESTADO DE CUENTA/CONSULTA DE MOVIMIENTOS: NO APLICA O CONSULTA EN _______________________________.
                EL HORARIO DE SERVICIO AL PUBLICO EN ESTE ESTABLECIMIENTO ES DE : EL HORARIO DE SERVICIO AL PÚBLICO DE
                ESTE ESTABLECIMIENTO ES DE LUNES A
                VIERNES DE 8:30 A 20:00 HRS Y SABADOS DE 09:00 A 15:00 HRS. Para todo lo relativo a la interpretación,
                aplicación y cumplimiento del contrato, LAS PARTES acuerdan
                someterse en la vía administrativa a la Procuraduría Federal del Consumidor, y en caso de subsistir
                diferencias, a la jurisdicción de los tribunales competentes del lugar donde se
                celebra este Contrato.
                GERARDO CRUZ PEREZ
                FECHA: 09-ene-2020
                3,500.00
                Contrato de Adhesión registrado en el Registro Público de Contratos de Adhesión de la Procuraduría
                Federal del Consumidor,
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12" class="tituloCelda">
            <label class="letraChicaNegrita">
                Contrato de Adhesión registrado en el Registro Público de Contratos de Adhesión de la Procuraduría
                Federal del Consumidor, bajo el número 11327-2018 de fecha 29-oct-2018. El
                proveedor tiene la obligación de entregar al consumidor el documento en el cual se señale la descripción
                del préstamo, saldos, movimientos y la descripción de la Prenda en garantía.
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraChicaNegrita">DESEMPEÑO</label></td>
            <td colspan="6"><label class="letraChicaNegrita">FIRMAS</label></td>
        </tr>
        <tr>
            <td colspan="6"><label class="letraChicaNegrita">El CONSUMIDOR recoge en el acto y a su entera satisfacción la(s) prenda(s) arriba descritas,
                por
                lo que otorga a MIRIAM GAMA VAZQUEZ el finiquito más amplio que en derecho corresponda,
                liberándolo de cualquier responsabilidad jurídica que hubiere surgido ó pudiese surgir en relación
                al contrato y la prenda. '. $FechaAlmoneda.'</label></td>
            <td colspan="6"><label class="letraChicaNegrita">FECHA: '. $FechaCreacion.' <br>
              '. $NombreCompleto .'
                "EL CONSUMIDOR"
            </td>
        </tr>
        <tr>
            <td colspan="4"><label class="letraChicaNegrita">'. $NombreCompleto .'
                EL CONSUMIDOR</label>
            </td>
            <td colspan="4"><label class="letraChicaNegrita">MIRIAM GAMA VAZQUEZ
                EL PROVEEDOR</label>
            </td>
            <td colspan="4"><label class="letraChicaNegrita">'.$NombreUsuario.'
                EL VALUADOR</label>
            </td>
        </tr>
        <tr>
            <td colspan="12">
            <label class="letraChicaNegrita">F
                EL HORARIO DE SERVICIO AL PUBLICO EN ESTE ESTABLECIMIENTO ES DE : EL HORARIO DE SERVICIO AL PÚBLICO DE
                ESTE ESTABLECIMIENTO ES DE LUNES A
                VIERNES DE 8:30 A 20:00 HRS Y SABADOS DE 09:00 A 15:00 HRS. Para todo lo relativo a la interpretación,
                aplicación y cumplimiento del contrato, LAS PARTES acuerdan
                someterse en la vía administrativa a la Procuraduría Federal del Consumidor, y en caso de subsistir
                diferencias, a la jurisdicción de los tribunales competentes del lugar donde se
                celebra este Contrato.
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="12" align="center">
             <hr>
            </td>
        </tr>
        <tr>
            <td colspan="4">
            </td>
            <td colspan="4">
            <label class="letraExtraGrandeNegrita">NO.
              '. $idContrato.'</label>
            </td>
            <td colspan="4">
                 <label class="letraExtraGrandeNegrita">NO.
              '. $idContrato.'</label>
            </td>
        </tr>
        <tr>
            <td colspan="12"><label class="letraNormalNegrita">
                NOMBRE:   
              '. $NombreCompleto.'
              &nbsp;&nbsp;&nbsp;&nbsp;
                PRÉSTAMO:&nbsp;$ '. $MontoPrestamo.'</label>
            </td>
        </tr>
        <tr>
            <td colspan="12"><label class="letraNormalNegrita">
                FECHA: '. $FechaCreacion .' PLAZO: 1 MENSUAL
                DESCRIPCIÓN:'. $detallePiePagina.'</label>
            </td>
        </tr>';
$contenido .=' </tbody></table></form></body></html>';


$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
//letter carta, legal oficio
//Vertical
$dompdf->setPaper("legal", "portrait");
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);