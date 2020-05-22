<?php

if (!isset($_SESSION)) {
    session_start();
}
$usuario = $_SESSION["idUsuario"];
$sucursal = $_SESSION["sucursal"];

$server = "localhost";
$user = "root";
$password = "";
$db = "mexicash";
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

$buscarContrato = "select max(id_Contrato) as idContrato from contrato_tbl where usuario=$usuario and $sucursal=1";
$contrato = $mysql->query($buscarContrato);
foreach ($contrato as $fila) {
    $idContrato = $fila['idContrato'];
}


$query = "SELECT Con.fecha_creacion AS FechaCreacion, CONCAT (Cli.apellido_Mat, ' ',Cli.apellido_Pat,' ', Cli.nombre) as NombreCompleto, 
                            CatCli.descripcion AS Identificacion, Cli.num_Identificacion AS NumIde, CONCAT(Cli.calle, ', ',Cli.num_interior,', ', Cli.num_exterior, ', ',Cli.localidad, ', ', Cli.municipio, ', ', CatEst.descripcion ) AS Direccion,
                            CLi.telefono AS CliTelefono, Cli.celular AS CliCelular,Cli.correo AS CliCorreo, Con.cotitular AS CliCotitular,Con.beneficiario AS CliBeneficiario,
                            Con.total_PrestamoInicial AS MontoPrestamo,Con.suma_InteresPrestamo AS MontoTotal,Con.tasa AS Tasa,Con.alm AS Almacenaje, Con.seguro AS Seguro,Con.Iva AS Iva,
                            Con.fecha_Alm AS FechaAlmoneda, Con.dias AS Dias,Con.fecha_Vencimiento AS FechaVenc,
                            Con.total_Interes AS Intereses,
                            ET.descripcion AS TipoElectronico, EM.descripcion AS MarcaElectronico, EMOD.descripcion AS ModeloElectronico,
                            Ar.detalle AS Detalle, TA.descripcion AS TipoMetal, TK.descripcion as Kilataje,
                            TC.descripcion as Calidad, Con.Total_Avaluo AS Avaluo,CONCAT (Usu.apellido_Pat, ' ',Usu.apellido_Mat,' ', Usu.nombre) as NombreUsuario
                            FROM contrato_tbl as Con 
                            INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente 
                            INNER JOIN cat_cliente as CatCli on Cli.tipo_Identificacion = CatCli.id_Cat_Cliente
                            INNER JOIN cat_estado as CatEst on Cli.estado = CatEst.id_Estado
                            INNER JOIN articulo_tbl as Ar on Con.id_Contrato =  Ar.id_Contrato
                            LEFT JOIN cat_electronico_tipo as ET on Ar.tipo = ET.id_tipo
                            LEFT JOIN cat_electronico_marca as EM on Ar.marca = EM.id_marca
                            LEFT JOIN cat_electronico_modelo as EMOD on Ar.modelo = EMOD.id_modelo
                            LEFT JOIN cat_tipoarticulo as TA on AR.tipo = TA.id_tipo
                            LEFT JOIN cat_kilataje as TK on AR.kilataje = TK.id_Kilataje
                            LEFT JOIN cat_calidad as TC on AR.calidad = TC.id_calidad
                            INNER JOIN usuarios_tbl as Usu on Con.usuario = Usu.id_User 
                            WHERE Con.id_Contrato =$idContrato ";
$resultado = $mysql->query($query);
foreach ($resultado as $row) {
    //echo $fila['Contrato'];
    $FechaCreacion = $row["FechaCreacion"];
                        $NombreCompleto =$row["NombreCompleto"];
                       $Identificacion = $row["Identificacion"];
                       $NumIde =$row["NumIde"];
                        $Direccion =  $row["Direccion"];
                    $Telefono = $row["CliTelefono"];
                       $Celular = $row["CliCelular"];
                       $Correo = $row["CliCorreo"];
                       $Cotitular =  $row["CliCotitular"];
                        $Beneficiario = ''; $row["CliBeneficiario"];

                      /*  //Tabla
                        "MontoPrestamo" => $row["MontoPrestamo"],
                        "MontoTotal" => $row["MontoTotal"],
                        "Tasa" => $row["Tasa"],
                        "Almacenaje" => $row["Almacenaje"],
                        "Seguro" => $row["Seguro"],
                        "Iva" => $row["Iva"],
                        //Tabla 2
                        "FechaAlmoneda" => $row["FechaAlmoneda"],
                        "Dias" => $row["Dias"],
                        "FechaVenc" => $row["FechaVenc"],
                        "Intereses" => $row["Intereses"],
                        //Tabla Art
                        "TipoElectronico" => $row["TipoElectronico"],
                        "MarcaElectronico" => $row["MarcaElectronico"],
                        "ModeloElectronico" => $row["ModeloElectronico"],
                        "Detalle" => $row["Detalle"],
                        //Tabla MEt
                        "TipoMetal" => $row["TipoMetal"],
                        "Kilataje" => $row["Kilataje"],
                        "Calidad" => $row["Calidad"],
                        "Avaluo" => $row["Avaluo"],
                        "NombreUsuario" => $row["NombreUsuario"]*/
}
?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../librerias/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../librerias/bootstrap/css/bootstrapNav.css">
    <script src="../../librerias/jquery-3.4.1.min.js"></script>
    <script src="../../librerias/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../librerias/bootstrap/js/bootstrapNav.js"></script>
    <script src="../../librerias/popper.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../style/General/StyloGeneral.css">
    <script src="../../JavaScript/funcionesContrato.js"></script>
</head>
<body>
<form>
    <table width="70%" border="1">
        <tbody>
        <tr>
            <td colspan="12" align="right">
                <h3>Contrato No.<?php echo $idContrato ?></h3>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <p>
                    Fecha de celebración del contrato: CIUDAD DE MEXICO NA a <?php echo $FechaCreacion ?></label>
                    CONTRATO DE MUTUO CON INTERÉS Y GARANTÍA PRENDARIA (PRESTAMO), que celebran: MIRIAM GAMA VAZQUEZ,
                    "EL PROVEEDOR", con
                    domicilio en: AV. AZTECAS 4380 CIUDAD DE MEXICO NA , R.F.C.: GAVM800428KQ3, Tel.: 5525252125, correo
                    electrónico: na, y el "EL CONSUMIDOR",
                    <label id="NombreCompleto"></label> que se identifica con: <label id="Identificacion"></label>
                    número: <label id="NumIde"></label> con domicilio en:
                    <label id="Direccion"></label>
                    Tel.: <label id="Telefono"></label> y Cel: <label id="Celular"></label> correo electrónico: <label
                            id="Correo"></label> quien designa como cotitular a:<label id="Cotitular"></label>
                    y beneficiario a: <label id="Beneficiario"></label>

                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2">Cat Costo Anual Total</td>
            <td colspan="2">TASA DE INTERES ANUAL</td>
            <td colspan="2">MONTO DEL PRETAMO(MUTUO)</td>
            <td colspan="2">MONTO TOTAL A PAGAR</td>
            <td colspan="4">COMISIONES Montos y cláusulas</td>
        </tr>
        <tr>
            <td colspan="2">Para fines
                informativos
                y de comparación
                155.70 %
                <label id="CAT">Preguntar</label>
                FIJO SIN IVA
            </td>
            <td colspan="2">
                36.00 %
                <label id="TasaInteresAnual">Preguntar</label>
                TASA FIJA
            </td>
            <td colspan="2"><label id="MontoPrestamo"></label>
                Moneda Nacional
            </td>
            <td colspan="2"><label id="MontoTotal"></label>
                Estimado al plazo máximo de desempeño
                o refrendo.
            </td>
            <td colspan="4">
                Comisión por Almacenaje:<label id="Almacenaje"></label> % (Claus. 11 a)
                Comisión por Avalúo $ 0.00 <label id="AvaluoComision">Preguntar</label>(Claus. 11 b)
                Comisión por Comercialización: 10.00% <label id="ComercialuzacionComision">Preguntar</label>(Claus. 11
                c)
                Comisión por reposición de contrato $ 0.00 <label id="ReposicionComision">Preguntar</label>(Claus. 11 d)
                Desempeño Extemporáneo: 0.00% <label id="DesempeñoExtem">Preguntar</label>(Claus. 11 e)
                Gastos de Administración $ 0.00 <label id="Administracion">Preguntar</label>(Claus 11 f)

            </td>
        </tr>
        <tr>
            <td colspan="12">
                METODOLOGIA DE CALCULO DE INTERES: TASA DE INTERES FIJA DIVIDIDA ENTRE 360 DIAS POR EL
                IMPORTE DEL SALDO INSOLUTO DEL PRESTAMO POR EL
                NUMERO DE DIAS EFECTIVAMENTE TRANSCURRIDOS.
            </td>
        </tr>
        <tr>
            <td colspan="12">
                PLAZO DEL PRESTAMO (Fecha limite para el refrendo o desempeño): <label id="FechaAlmoneda"></label>.
                Total de
                refrendos aplicables:
                Su pago sera: <label id="diasLabel"></label>. Metodos de pago aceptado: efectivo, tarjetas de credito y
                debito,
                transferencias. En caso de que el vencimiento sea en dia inhabil, se
                considerara el dia habil siguiente.
            </td>
        </tr>
        <tr>
            <td colspan="2" rowspan="3">
                Opciones de pago
                para refrendo o
                desempeño
            </td>
            <td colspan="6">
                MONTO
            </td>
            <td colspan="2">
                TOTAL A PAGAR
            </td>
            <td colspan="2" rowspan="2">
                CUANDO SE
                REALIZAN LOS
                PAGOS
            </td>
        </tr>
        <tr>
            <td>
                NÚMERO
            </td>
            <td colspan="2">
                IMPORTE MUTUO
            </td>
            <td>
                INTERESES
            </td>
            <td>
                ALMACENAJE
            </td>
            <td>
                IVA
            </td>
            <td>
                POR REFRENDO
            </td>
            <td>
                POR DESEMPEÑO
            </td>
        </tr>
        <tr>
            <td>
                1
            </td>
            <td colspan="2">
                <label id="importeMutuo"></label>
            </td>
            <td>
                <label id="intereses"></label>
            </td>
            <td>
                <label id="almacenaje"></label>
            </td>
            <td>
                <label id="iva"></label>
            </td>
            <td>
                <label id="porRefrendo"></label>
            </td>
            <td>
                <label id="porDesempeño"></label>
            </td>
            <td COLSPAN="2">
                <label id="fechaVencimiento"></label>
            </td>
        </tr>
        <tr>
            <td colspan="6">COSTO MENSUAL TOTAL</td>
            <td colspan="6">COSTO DIARIO TOTAL</td>
        </tr>
        <tr>
            <td colspan="6">Para fines informativos y de comparación:
                <label id="CostoMensualTotal"></label>% FIJO SIN IVA
            </td>
            <td colspan="6">Para fines informativos y de comparación:
                <label id="CostoDiarioTotal"></label>% FIJO SIN IVA
            </td>
        </tr>
        <tr>
            <td colspan="12">
                "Cuide su capacidad de pago, generalmente no debe de exceder del 35% de sus ingresos".
                "Si usted no paga en tiempo y forma corre el riesgo de perder sus prendas".
            </td>
        </tr>
        <tr>
            <td colspan="12">
                GARANTÍA: Para garantizar el pago de este prestamo, EL CONSUMIDOR deja en garantia el bien que se
                describe a continuacion:
            </td>
        </tr>
        <tr>
            <td colspan="12">
                DESCRIPCION DE LA PRENDA
            </td>
        </tr>
        <tr>
            <td colspan="3">DESCRIPCIÓN
                GENÉRICA
            </td>
            <td colspan="5">CARACTERISTICAS</td>
            <td>AVALÚO</td>
            <td>PRÉSTAMO</td>
            <td colspan="2">%PRÉSTAMO SOBRE
                AVALÚO
            </td>
        </tr>
        <tr>
            <td colspan="3"><label id="tipoArticulo"></label></td>
            <td colspan="5"><label id="descripcionArt"></label></td>
            <td><label id="Avaluo"></label></td>
            <td><label id="PrestamoArticulo"></label></td>
            <td colspan="2">75.00
            </td>
        </tr>
        <tr>
            <td colspan="6">MONTO DEL AVALUO: <label id="MontoAvaluo"></label></td>
            <td colspan="6"><label id="AvaluoLetra"></label>.</td>
        </tr>
        <tr>
            <td colspan="6">PORCENTAJE DEL PRÉSTAMO SOBRE EL AVALÚO:</td>
            <td colspan="6">75.00</td>
        </tr>
        <tr>
            <td colspan="6">FECHA DE INICIO DE COMERCIALIZACIÓN:</td>
            <td colspan="6"><label id="FechaComer"></label></td>
        </tr>
        <tr>
            <td colspan="6">El monto del prestamo se realizara en::</td>
            <td colspan="6">Efectivo X o a la cuenta bancaria del consumidor al numero
                __________________, de la Institucion Financiera __________________.
            </td>
        </tr>
        <tr>
            <td colspan="6">FECHA LÍMITE DE FINIQUITO:</td>
            <td colspan="6">Terminos y condiciones para recibir pagos anticipados: Clausula 13 (decimo Tercera, Inciso
                b)
            </td>
        </tr>
        <tr>
            <td colspan="12">Estos conceptos causaran el pago al impuesto del valor agregado (IVA) a la tasa del 16%
            </td>
        </tr>
        <tr>
            <td colspan="12">*EL PROCEDIMIENTO PARA DESEMPEÑO, REFRENDO, FINIQUITO Y RECLAMO DEL REMANENTE SE ENCUENTRA
                DESCRITO EN EL CONTRATO.
            </td>
        </tr>
        <tr>
            <td colspan="12">
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
                FECHA: 09/ene/2020
                3,500.00
                Contrato de Adhesión registrado en el Registro Público de Contratos de Adhesión de la Procuraduría
                Federal del Consumidor,
            </td>
        </tr>
        <tr>
            <td colspan="12">
                Contrato de Adhesión registrado en el Registro Público de Contratos de Adhesión de la Procuraduría
                Federal del Consumidor, bajo el número 11327-2018 de fecha 29/oct/2018. El
                proveedor tiene la obligación de entregar al consumidor el documento en el cual se señale la descripción
                del prestamo, saldos, movimientos y la descripción de la Prenda en garantía .
            </td>
        </tr>
        <tr>
            <td colspan="6">DESEMPEÑO</td>
            <td colspan="6">FIRMAS</td>
        </tr>
        <tr>
            <td colspan="6">El CONSUMIDOR recoge en el acto y a su entera satisfacción la(s) prenda(s) arriba descritas,
                por
                lo que otorga a MIRIAM GAMA VAZQUEZ el finiquito más amplio que en derecho corresponda,
                liberándolo de cualquier responsabilidad jurídica que hubiere surgido ó pudiese surgir en relación
                al contrato y la prenda.
                <label id="FechaPieAlmoneda"></label></td>
            <td colspan="6">FECHA: <label id="FechaPieContrato"></label>
                <label id="NombrePieContrato"></label>
                "EL CONSUMIDOR"
            </td>
        </tr>
        <tr>
            <td colspan="4"><label id="NombrePieContrato2"></label>
                EL CONSUMIDOR
            </td>
            <td colspan="4">MIRIAM GAMA VAZQUEZ
                EL PROVEEDOR
            </td>
            <td colspan="4"><label id="nombreUsuario"></label>
                EL VALUADOR
            </td>
        </tr>
        <tr>
            <td colspan="12">
                EL HORARIO DE SERVICIO AL PUBLICO EN ESTE ESTABLECIMIENTO ES DE : EL HORARIO DE SERVICIO AL PÚBLICO DE
                ESTE ESTABLECIMIENTO ES DE LUNES A
                VIERNES DE 8:30 A 20:00 HRS Y SABADOS DE 09:00 A 15:00 HRS. Para todo lo relativo a la interpretación,
                aplicación y cumplimiento del contrato, LAS PARTES acuerdan
                someterse en la vía administrativa a la Procuraduría Federal del Consumidor, y en caso de subsistir
                diferencias, a la jurisdicción de los tribunales competentes del lugar donde se
                celebra este Contrato.
            </td>
        </tr>
        <tr>
            <td colspan="12">
                -------------------------------------------------------------------------------------------------------------------
            </td>
        </tr>
        <tr>
            <td colspan="4">

            </td>
            <td colspan="4">
                <label id="idContratoPie"></label>
            </td>
            <td colspan="4">
                <label id="idContratoPie2"></label>

            </td>
        </tr>
        <tr>
            <td colspan="12">
                NOMBRE: <label id="idNombrePie"></label>
                FECHA: <label id="fechaCreacionPie"></label>PLAZO: 1 MENSUAL
                PRESTAMO: <label id="prestmoPie"></label>
                PRENDA:<label id="descripcionPie"></label>
            </td>
        </tr>
        </tbody>
    </table>
</form>
</body>
</html>
<div>
    <input type="button" class="btn btn-danger" value="prueba" onclick=" window.open('../PDF/pdfPrueba.php')">&nbsp;
</div>
