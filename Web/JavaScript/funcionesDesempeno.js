var errorToken = 0;
//tipo de contrato articulo
var tipoContrato = 0;
var contratoGbl = 0;
var tipeFormulario = 0;
var tipoSinInteres = 0;
//tipo de contrato auto
// var tipoContrato = 2;
//Estatus 1 es Empeño
var estatus = 1;
var tipoMovimientoGbl = 0;
var IdMovimientoGbl = 0;
// tipe 1 refrendo,tipe 2 refrendo auto,tipe 3 desempeño,tipe 4 desempeño auto,

//Variables Globales para la bitacora de pagos
var id_ClientePDF = 0;
var prestamoPDF = 0;
var abonoCapitalPDF = 0;
var interesesPDF = 0;
var almacenajePDF = 0;
var seguroPDF = 0;
var desempeñoExtPDF = 0;
var moratoriosPDF = 0;
var otrosCobrosPDF = 0;
var descuentoAplicadoPDF = 0;
var descuentoPuntosPDF = 0;
var ivaPDF = 0;
var efectivoPDF = 0;
var cambioPDF = 0;
var mutuoPDF = 0;
var refrendoPDF = 0;
//Bitacora Token
//Cat_Token_Movimiento
//id = 1;tipo =Descuento; descripcion =Descuento
var token_interes = 0;
var token_moratorio = 0;
var token_gps = 0;
var token_pension = 0;
var token_poliza = 0;
var token_movimiento = 1;
//
var totalAvaluoGbl = 0;
var prestamoInfoGbl = 0;
var PlazoDescGlb = 0;
var TasaDescGlb = 0;
var AlmacDescGlb = 0;
var SeguDescGlb = 0;
//tipo de contrato 1 normal; 2 auto
//tipo de formulario 1 refrendo normal, 2 refrendo auto; 3 desempeño normal, 4 desempeño auto

function busquedaRefrendo(e) {
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) {
        return true;
    }
    var patron;
    patron = /[0-9.]/
    var te;
    te = String.fromCharCode(tecla);
    if (e.keyCode === 13 && !e.shiftKey) {
        busquedaMovimiento();
    }
    return patron.test(te);
}

function busquedaMovimiento() {
    contratoGbl = $("#idContrato").val();
    tipoContrato = $("#idTipoDeContrato").val();
    tipoContrato = parseInt(tipoContrato);
    var dataEnviar = {
        "contrato": contratoGbl,
        "tipoContrato": tipoContrato,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Desempeno/busquedaMovimiento.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            if (datos.length > 0) {
                for (i = 0; i < datos.length; i++) {
                    IdMovimientoGbl = datos[i].IdMovimiento;
                    estatusContrato();
                }
            } else {
                $("#idContrato").prop('disabled', false);
                $("#btnBuscar").prop('disabled', false);
                alertify.error("No se encontro ningun contrato activo con ese número.");
            }
        }
    });
}

function estatusContrato() {
    tipeFormulario = $("#idFormulario").val();
    tipeFormulario = parseInt(tipeFormulario);
    $("#idFormDesRef")[0].reset();
    $("#idConTDDes").text('')
    $("#idPresTDDes").text('')
    $("#idInteresTDDes").text('');
    $("#idAbonoTDDes").text('');
    $("#btnGenerar").prop('disabled', true);
    $("#idContrato").prop('disabled', true);
    $("#btnBuscar").prop('disabled', true);

    if (contratoGbl != '') {
        var dataEnviar = {
            "tipe": 1,
            "IdMovimiento": IdMovimientoGbl,
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Desempeno/busquedaDesempeno.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                if (datos.length > 0) {
                    for (i = 0; i < datos.length; i++) {
                        var Fecha = datos[i].Fecha;
                        var NombreCompleto = datos[i].NombreCompleto;
                        var Movimiento = datos[i].Movimiento;
                        var tipoMovimiento = datos[i].tipoMovimiento;
                        if (tipoMovimiento == 3 || tipoMovimiento == 4 || tipoMovimiento == 7 || tipoMovimiento == 8) {
                            tipoMovimientoGbl = tipoMovimiento;
                            buscarCliente();
                            buscarDatosContrato();
                            if (tipoContrato == 1) {
                                buscarDetalle();
                            } else if (tipoContrato == 2) {
                                buscarDetalleAuto();
                            }

                        } else {
                            alert("El contrato No. : " + contratoGbl + ", creado el " + Fecha + "\n" +
                                " del cliente:   " + NombreCompleto + "\n" +
                                " se encuentra en estatus de:" + Movimiento + ". \n");
                            cancelar();
                        }
                    }
                } else {
                    $("#idContrato").prop('disabled', false);
                    $("#btnBuscar").prop('disabled', false);
                    alertify.error("No se encontro ningun contrato con ese número.");
                }
            }
        });
    } else {
        alertify.error("Ingrese un contrato a buscar.");
        $("#idContrato").prop('disabled', false);
        $("#btnBuscar").prop('disabled', false);


    }
}

function buscarCliente() {
    if (contratoGbl != '') {
        var dataEnviar = {
            "tipe": 2,
            "IdMovimiento": IdMovimientoGbl,
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Desempeno/busquedaDesempeno.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                if (datos.length > 0) {
                    for (i = 0; i < datos.length; i++) {
                        id_ClientePDF = datos[i].Cliente;
                        var NombreCompleto = datos[i].NombreCompleto;
                        var DireccionCompleta = datos[i].DireccionCompleta;
                        var DireccionCompletaEst = datos[i].DireccionCompletaEst;
                        var Cotitular = datos[i].Cotitular;
                        var UsuarioName = datos[i].UsuarioName;

                        if (NombreCompleto === null) {
                            NombreCompleto = '';
                        }
                        if (DireccionCompleta === null) {
                            DireccionCompleta = '';
                        }
                        if (DireccionCompletaEst === null) {
                            DireccionCompletaEst = '';
                        }
                        if (Cotitular === null) {
                            Cotitular = '';
                        }
                        if (UsuarioName === null) {
                            UsuarioName = '';
                        }

                        NombreCompleto = NombreCompleto.bold();
                        document.getElementById('lblNombreCliente').innerHTML = NombreCompleto;

                        $("#idDatosClienteDes").val(DireccionCompleta + "\n" + DireccionCompletaEst + "\n" + "Cotitular: " + Cotitular + "\n" + "Usuario: " + UsuarioName);
                    }
                } else {

                    $("#idDatosClienteDes").val('');
                    $("#idDatosContratoDes").val('');
                    $("#idDetalleContratoDes").val('');

                    document.getElementById('idConTDDes').innerHTML = '';
                    document.getElementById('idPresTDDes').innerHTML = '';
                    document.getElementById('idInteresTDDes').innerHTML = '';
                    document.getElementById('totalAPagarTD').innerHTML = '';
                    alertify.error("Sin resultados para mostrar.");
                }
            }
        });
    }
}

function buscarDatosContrato() {
    if (contratoGbl != '') {
        var dataEnviar = {
            "tipe": 3,
            "IdMovimiento": IdMovimientoGbl,
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Desempeno/busquedaDesempeno.php',
            data: dataEnviar,
            dataType: "json",

            success: function (datos) {
                for (i = 0; i < datos.length; i++) {
                    var FechaEmp = datos[i].FechaEmpMovimiento;
                    var FechaVenConvert = datos[i].FechaVenConvertMovimiento;
                    var FechaEmpConvert = datos[i].FechaEmpConvertMovimiento;
                    var FechaAlm = datos[i].FechaAlmMovimiento;
                    var PlazoDesc = datos[i].PlazoDesc;
                    var TasaDesc = datos[i].TasaDesc;
                    var AlmacDesc = datos[i].AlmacDesc;
                    var SeguDesc = datos[i].SeguDesc;
                    var IvaDesc = datos[i].IvaDesc;
                    var DiasContrato = datos[i].Dias;
                    var TotalInteresPrestamo = datos[i].TotalInteresPrestamo;
                    totalAvaluoGbl = datos[i].TotalAvaluo;
                    prestamoInfoGbl = datos[i].PrestamoInfo;
                    var TotalPrestamo = datos[i].TotalPrestamoMovimiento;
                    prestamoPDF = TotalPrestamo;
                    var Abono = datos[i].AbonoMovimiento;
                    var Descuento = datos[i].DescuentoMovimiento;
                    var DiasAlmoneda = datos[i].DiasAlmoneda;
                    var PolizaSeguro = datos[i].PolizaSeguro;
                    var GPS = datos[i].GPS;
                    var Pension = datos[i].Pension;
                    var fechaHoy = new Date();
                    var diasForInteres = 0;
                    var prestamoNuevoNota = TotalPrestamo;
                    $("#idPrestamoSinInteres").val(TotalPrestamo);
                    var interesNuevoNota = 0;
                    var moratoriosNuevoNota = 0;
                    var totalInteresNuevoNota = 0;
                    var interesPagarNuevoNota = 0;
                    var totalPagarNuevoNota = 0;
                    var descuentoNuevoNota = 0;
                    var abonoCapitalNuevoNota = 0;
                    var efectivoNuevoNota = 0;
                    var cambioNuevoNota = 0;

                    //SE obtienen los intereses en  porcentajes
                    //var IvaDesc = "0." + IvaDescripcion;
                    TasaDesc = parseFloat(TasaDesc);
                    AlmacDesc = parseFloat(AlmacDesc);
                    SeguDesc = parseFloat(SeguDesc);
                    IvaDesc = parseFloat(IvaDesc);
                    DiasContrato = parseInt(DiasContrato);

                    TotalPrestamo = parseFloat(TotalPrestamo);
                    TotalInteresPrestamo = parseFloat(TotalInteresPrestamo);
                    var FechaVencFormat = formatStringToDate(FechaVenConvert);
                    var FechaEmpFormat = formatStringToDate(FechaEmpConvert);
                    var fechaHoyText = fechaFormato();
                    var diasMoratorios = 0;
                    var diasInteresMor = 0;
                    Abono = Number(Abono);

                    if (FechaEmpConvert == fechaHoyText) {
                        //Si la fecha es igual el dia de interes generado es 1
                        diasForInteres = 0;
                        if (DiasContrato != 0) {
                            if (tipeFormulario == 1 || tipeFormulario == 2) {
                                refrendoConfirmar();
                            } else {
                                costoContrato(contratoGbl);
                            }
                        }
                    } else {
                        //Si la fecha es menor que hoy  el dia de interes generado es  el total -1
                        var diasdif = fechaHoy.getTime() - FechaEmpFormat.getTime();
                        diasForInteres = Math.floor(diasdif / (1000 * 60 * 60 * 24));
                    }

                    // Dias trasncurridos con dias moratorios
                    if (FechaVencFormat < fechaHoy) {
                        diasMoratorios = diasForInteres - DiasContrato;
                        diasForInteres = diasForInteres - diasMoratorios;
                    }

                    //Plazo
                    if (DiasContrato == 30) {
                        PlazoDesc = PlazoDesc + " Mensual";
                    } else if (DiasContrato == 1) {
                        PlazoDesc = PlazoDesc + " Diario";
                    }


                    if (Abono == '' || Abono == null) {
                        Abono = 0.00;
                    }
                    if (Descuento == '' || Descuento == null) {
                        Descuento = 0.00;
                    }

                    if (DiasAlmoneda == 0) {
                        DiasAlmoneda = 1;
                    }
                    $("#descuentoAnteriorNuevoNota").val(Descuento);
                    var nuevaFechaVencimiento = sumarDias(DiasContrato);
                    var nuevaFechaAlm = calcularDiasAlmoneda(DiasContrato, DiasAlmoneda)
                    $("#fechaVencimientoNuevoNota").val(nuevaFechaVencimiento);
                    $("#fechaAlmNuevoNota").val(nuevaFechaAlm);
                    //INTERES DIARIO
                    PlazoDescGlb = PlazoDesc;
                    TasaDescGlb = TasaDesc;
                    AlmacDescGlb = AlmacDesc;
                    SeguDescGlb = SeguDesc;
                    //Se saca los porcentajes mensuales
                    //alert("Se calcula");
                    //alert(TotalPrestamo);
                    //alert("por ")
                    //alert(TasaDesc);
                    //alert("Entre")
                    // alert("100")
                    //alert("igual a")

                    var calculaInteres = Math.floor(TotalPrestamo * TasaDesc) / 100;
                    var calculaALm = Math.floor(TotalPrestamo * AlmacDesc) / 100;
                    var calculaSeg = Math.floor(TotalPrestamo * SeguDesc) / 100;
                    //var calculaIva = Math.floor(TotalPrestamo * IvaDesc) / 100;

                    //alert(calculaInteres)
                    //alert("por ")
                    //alert(DiasContrato)
                    //alert("igual a")
                    var totalInteres = calculaInteres + calculaALm + calculaSeg;
                    //interes por dia
                    var interesDia = totalInteres / DiasContrato;
                    //TASA:
                    var tasaIvaTotal = TasaDesc + AlmacDesc + SeguDesc;

                    //Porcentajes por dia
                    var diaInteres = calculaInteres / DiasContrato;
                    //alert(diaInteres)
                    var diaAlm = calculaALm / DiasContrato;
                    var diaSeg = calculaSeg / DiasContrato;
                    //var diaIva = calculaIva / DiasContrato;
                    //INTERES:
                    //alert("dia interes = " + diaInteres);
                    //alert("dia diasForInteres = " + diasForInteres)
                    //alert(totalVencInteres)
                    var totalVencInteres = diaInteres * diasForInteres;
                    //ALMACENAJE
                    var totalVencAlm = diaAlm * diasForInteres;
                    //SEGURO
                    var totalVencSeg = diaSeg * diasForInteres;

                    //MORATORIOS
                    diasInteresMor = diasMoratorios * interesDia;
                    var diasInteresMorBit = diasInteresMor;
                    diasInteresMorBit = Math.round(diasInteresMorBit * 100) / 100;
                    moratoriosPDF = diasInteresMorBit;
                    //IVA
                    //var totalVencIVA = diaIva * diasForInteres;
                    //var totalVencIVABit = totalVencIVA;
                    //totalVencIVABit = Math.round(totalVencIVABit * 100) / 100;
                    //ivaPDF = totalVencIVABit;
                    var gpsSumarAInteres = 0.00;
                    var pensionSumarAInteres = 0.00;
                    var polizaSumarAInteres = 0.00;
                    //Si es auto

                    if (tipeFormulario == 2 || tipeFormulario == 4) {
                        if (PolizaSeguro == '' || PolizaSeguro == null) {
                            PolizaSeguro = 0.00;
                        }
                        if (GPS == '' || GPS == null) {
                            GPS = 0.00;
                        }
                        if (Pension == '' || Pension == null) {
                            Pension = 0.00;
                        }
                        var gpsDiario = GPS / DiasContrato;
                        var pensionDiario = Pension / DiasContrato;
                        var polizaDiario = PolizaSeguro / DiasContrato;

                        var gpsInteresDiario = gpsDiario * diasForInteres;
                        var pensionInteresDiario = pensionDiario * diasForInteres;
                        var polizaInteresDiario = polizaDiario * diasForInteres;

                        var gpsInteresMoratorio = gpsDiario * diasMoratorios;
                        var pensionInteresMoratorio = pensionDiario * diasMoratorios;
                        var polizaInteresMoratorio = polizaDiario * diasMoratorios;

                        var gpsInteresFinal = gpsInteresDiario + gpsInteresMoratorio;
                        var pensionInteresFinal = pensionInteresDiario + pensionInteresMoratorio;
                        var polizaInteresFinal = polizaInteresDiario + polizaInteresMoratorio;

                        gpsSumarAInteres = gpsInteresFinal;
                        pensionSumarAInteres = pensionInteresFinal;
                        polizaSumarAInteres = polizaInteresFinal;

                        GPS = formatoMoneda(GPS);
                        Pension = formatoMoneda(Pension);
                        PolizaSeguro = formatoMoneda(PolizaSeguro);
                        document.getElementById('idGPSTDDes').innerHTML = GPS;
                        document.getElementById('idPensionTDDes').innerHTML = Pension;
                        document.getElementById('idPolizaTDDes').innerHTML = PolizaSeguro;
                        $("#idGPSNota").val(formatoMoneda(gpsInteresFinal));
                        $("#idPolizaNota").val(formatoMoneda(pensionInteresFinal));
                        $("#idPensionNota").val(formatoMoneda(polizaInteresFinal));
                    }

                    //INTERES TABLA
                    var interesGenerado = totalVencInteres + totalVencAlm + totalVencSeg;
                    //Mas auto
                    var interesAutoNuevoNota = gpsSumarAInteres + pensionSumarAInteres + polizaSumarAInteres;
                    gpsSumarAInteres = Math.round(gpsSumarAInteres * 100) / 100;
                    pensionSumarAInteres = Math.round(pensionSumarAInteres * 100) / 100;
                    polizaSumarAInteres = Math.round(polizaSumarAInteres * 100) / 100;
                    $("#gpsNuevoNota").val(gpsSumarAInteres);
                    $("#polizaNuevoNota").val(pensionSumarAInteres);
                    $("#pensionNuevoNota").val(polizaSumarAInteres);

                    token_gps = gpsSumarAInteres;
                    token_pension = pensionSumarAInteres;
                    token_poliza = polizaSumarAInteres;

                    interesGenerado = Math.round(interesGenerado * 100) / 100;
                    TotalPrestamo = Math.round(TotalPrestamo * 100) / 100;
                    diasInteresMor = Math.round(diasInteresMor * 100) / 100;

                    totalVencInteres = Math.round(totalVencInteres * 100) / 100;
                    totalVencAlm = Math.round(totalVencAlm * 100) / 100;
                    totalVencSeg = Math.round(totalVencSeg * 100) / 100;

                    $("#idTblInteresDesc").val(totalVencInteres);
                    $("#idTblAlmacenajeDesc").val(totalVencAlm);
                    $("#idTblSeguroDesc").val(totalVencSeg);
                    var TotalFinal = TotalPrestamo + interesGenerado;
                    totalFinal = TotalFinal;

                    //Nuevo
                    interesNuevoNota = interesGenerado;
                    moratoriosNuevoNota = diasInteresMor;
                    interesDia = formatoMoneda(interesDia);
                    totalVencInteres = formatoMoneda(totalVencInteres);
                    totalVencAlm = formatoMoneda(totalVencAlm);
                    totalVencSeg = formatoMoneda(totalVencSeg);
                    diasInteresMor = formatoMoneda(diasInteresMor);
                    //totalVencIVA = formatoMoneda(totalVencIVA);
                    interesGenerado = formatoMoneda(interesGenerado);
                    TotalFinal = formatoMoneda(TotalFinal);
                    TotalPrestamo = formatoMoneda(TotalPrestamo);
                    $("#abonoAnteriorNuevoNota").val(Abono)
                    Abono = formatoMoneda(Abono);


                    //Valida si esta en almoneda
                    var FechaAlmFormat = formatStringToDate(FechaAlm);
                    FechaEmp = fechaVista(FechaEmp);
                    FechaVenConvert = fechaVista(FechaVenConvert);
                    FechaAlm = fechaVista(FechaAlm);
                    $("#idTblFechaEmpeno").val(FechaEmp);
                    $("#idTblFechaVenc").val(FechaVenConvert);
                    $("#idTblFechaComer").val(FechaAlm);
                    $("#idTblDiasTransc").val(diasForInteres);
                    $("#idTblDiasTransInt").val(diasMoratorios);
                    $("#idTblPlazo").val(PlazoDesc);
                    $("#idTblTasa").val(tasaIvaTotal);
                    $("#idTblInteresDiario").val(interesDia);
                    $("#idTblInteres").val(totalVencInteres);
                    $("#idTblAlmacenaje").val(totalVencAlm);
                    $("#idTblSeguro").val(totalVencSeg);
                    $("#idTblMoratorios").val(diasInteresMor);
                    $("#idTblIva").val(IvaDesc);

                    document.getElementById('idConTDDes').innerHTML = contratoGbl;
                    document.getElementById('idPresTDDes').innerHTML = TotalPrestamo;
                    document.getElementById('idInteresTDDes').innerHTML = interesGenerado;
                    document.getElementById('idAbonoTDDes').innerHTML = Abono;


                    //NUEVA NOTA

                    totalInteresNuevoNota = interesNuevoNota + moratoriosNuevoNota + interesAutoNuevoNota;
                    interesPagarNuevoNota = totalInteresNuevoNota;
                    totalPagarNuevoNota = totalInteresNuevoNota;
                    var saldoPendiente = prestamoNuevoNota;
                    if (tipeFormulario == 3 || tipeFormulario == 4) {
                        prestamoNuevoNota = Number(prestamoNuevoNota);
                        interesPagarNuevoNota = Number(interesPagarNuevoNota)
                        totalPagarNuevoNota = prestamoNuevoNota + interesPagarNuevoNota;
                        saldoPendiente = 0;
                    }

                    var interesParaIva = totalInteresNuevoNota;
                    var prestamoParaIva = prestamoNuevoNota;
                    interesParaIva = Number(interesParaIva);
                    prestamoParaIva = Number(prestamoParaIva);

                    var interesParaIva = Math.round(interesParaIva * 100) / 100;
                    var prestamoParaIva = Math.round(prestamoParaIva * 100) / 100;
                    var totalPagarConIva = interesParaIva;
                    var ivaTotal = Math.round(IvaDesc * totalPagarConIva) / 100;

                    interesPagarNuevoNota = interesPagarNuevoNota + ivaTotal;
                    var interesPagarNuevoNota = Math.round(interesPagarNuevoNota * 100) / 100;

                    totalPagarNuevoNota = totalPagarNuevoNota + ivaTotal;
                    totalPagarNuevoNota = Math.round(totalPagarNuevoNota * 100) / 100;

                    $("#prestamoNuevoNota").val(prestamoNuevoNota);
                    $("#interesNuevoNota").val(interesNuevoNota);
                    //$("#idIVANotaNuevo").val(totalVencIVA);
                    token_interes = interesNuevoNota;
                    $("#moratoriosNuevoNota").val(moratoriosNuevoNota);
                    token_moratorio = moratoriosNuevoNota;
                    $("#totalInteresNuevoNota").val(totalInteresNuevoNota);
                    $("#descuentoNuevoNota").val(descuentoNuevoNota);
                    $("#interesPagarNuevoNota").val(interesPagarNuevoNota);
                    $("#abonoCapitalNuevoNota").val(abonoCapitalNuevoNota);
                    $("#totalPagarNuevoNota").val(totalPagarNuevoNota);
                    $("#efectivoNuevoNota").val(efectivoNuevoNota);
                    $("#cambioNuevoNota").val(cambioNuevoNota);
                    $("#saldoPendienteNuevoNota").val(saldoPendiente);
                    $("#idIVAValue").val(ivaTotal);

                    prestamoNuevoNota = formatoMoneda(prestamoNuevoNota);
                    interesNuevoNota = formatoMoneda(interesNuevoNota);
                    moratoriosNuevoNota = formatoMoneda(moratoriosNuevoNota);
                    totalInteresNuevoNota = formatoMoneda(totalInteresNuevoNota);
                    interesPagarNuevoNota = formatoMoneda(interesPagarNuevoNota);
                    totalPagarNuevoNota = formatoMoneda(totalPagarNuevoNota);
                    ivaTotal = formatoMoneda(ivaTotal);


                    $("#idPrestamoNotaNuevo").val(prestamoNuevoNota);
                    $("#idInteresNotaNuevo").val(interesNuevoNota);
                    $("#idMoratorioNotaNuevo").val(diasInteresMor);
                    $("#idIVANotaNuevo").val(ivaTotal);

                    $("#idTotalInteresNotaNuevo").val(totalInteresNuevoNota);
                    $("#idInteresAPagarNotaNuevo").val(interesPagarNuevoNota);
                    $("#idTotalAPagarNotaNuevo").val(totalPagarNuevoNota);


                    $("#btnLimpiar").prop('disabled', false);
                    $("#idDescuentoNotaNuevo").prop('disabled', false);
                    $("#idDescuentoNotaNuevo").focus();

                }
            }
        });
    }
}

function buscarDetalle() {
    if (contratoGbl != '') {
        var dataEnviar = {
            "tipe": 4,
            "IdMovimiento": IdMovimientoGbl,
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Desempeno/busquedaDesempeno.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var detalleContrato;
                var detallePiePagina = "";
                for (i = 0; i < datos.length; i++) {
                    var Detalle = datos[i].Detalle;
                    var Ubicacion = datos[i].Ubicacion;

                    if (Detalle === null) {
                        Detalle = '';
                    }
                    if (Ubicacion === null) {
                        Ubicacion = '';
                    }
                    detalleContrato = Detalle + "\n" + " Observaciones:" + Ubicacion + "\n";
                    detallePiePagina = detallePiePagina + detalleContrato
                    $("#idContrato").val(contratoGbl);
                }
                $("#idDetalleContratoDes").val(detallePiePagina);
            }
        });
    }
}

function buscarDetalleAuto() {
    if (contratoGbl != '') {
        var dataEnviar = {
            "tipe": 5,
            "IdMovimiento": IdMovimientoGbl,
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Desempeno/busquedaDesempeno.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var detalleContrato;
                for (i = 0; i < datos.length; i++) {
                    var Marca = datos[i].Marca;
                    var Modelo = datos[i].Modelo;
                    var Anio = datos[i].Anio;
                    var ColorAuto = datos[i].ColorAuto;
                    var Obs = datos[i].Obs;


                    if (Marca === null) {
                        Marca = '';
                    }
                    if (Modelo === null) {
                        Modelo = '';
                    }
                    if (Anio === null) {
                        Anio = '';
                    }
                    if (ColorAuto === null) {
                        ColorAuto = '';
                    }
                    if (Obs === null) {
                        Obs = '';
                    }

                    detalleContrato = "Marca: " + Marca + ", Modelo: " + Modelo + "\n" + "Año: " + Anio +
                        ColorAuto + "\n" +
                        Obs + "\n";
                }
                $("#idDetalleContratoDes").val(detalleContrato);
                $("#idContrato").val(contratoGbl);
            }
        });
    }
}

function cancelar() {
    location.reload();
}

function descuentoNuevo(e) {
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) {
        return true;
    }
    var patron;
    patron = /[0-9.]/
    var te;
    te = String.fromCharCode(tecla);
    if (e.keyCode === 13 && !e.shiftKey) {
        var descuento = $("#idDescuentoNotaNuevo").val();
        descuento = Number(descuento);

        var interes = $("#interesPagarNuevoNota").val();
        interes = Number(interes);
        if (descuento <= interes) {


            calcularTotalPagar(descuento, interes, 0)
            $("#descuentoNuevoNota").val(descuento);
            var descuentoFormat = formatoMoneda(descuento)
            $("#idDescuentoNotaNuevo").val(descuentoFormat);
            $("#idDescuentoNotaNuevo").prop('disabled', true);
            $("#idEfectivoNotaNuevo").prop('disabled', false);
            $("#idEfectivoNotaNuevo").focus();


            var ivaDesc = $("#idTblIva").val();
            var totalInteres = $("#interesPagarNuevoNota").val();
            var ivaValue = $("#idIVAValue").val();
            ivaDesc = Number(ivaDesc);
            var ivaPorc = "." + ivaDesc;
            ivaPorc = Number(ivaPorc);
            totalInteres = totalInteres - descuento;
            totalInteres = Math.round(totalInteres * 100) / 100;
            $("#interesPagarNuevoNota").val(totalInteres);
            var totalInteresFormat = formatoMoneda(totalInteres)
            $("#idInteresAPagarNotaNuevo").val(totalInteresFormat);
            ivaDesc += 100;
            var totalInteresDescuento = totalInteres / ivaDesc;
            totalInteresDescuento = totalInteresDescuento * 100;

            ivaValue = totalInteresDescuento * ivaPorc;
            totalInteresDescuento = Math.round(totalInteresDescuento * 100) / 100;
            ivaValue = Math.round(ivaValue * 100) / 100;

            $("#totalInteresNuevoNota").val(totalInteresDescuento);
            $("#idIVAValue").val(ivaValue);
            descuentoTabla();

        } else {
            alert("El descuento no puede ser mayor al interes.");
            $("#idEfectivoNotaNuevo").val('');
            $("#efectivoNuevoNota").val('');
        }

    }
    return patron.test(te);
}

function descuentoTabla() {
    var totalInteres = $("#totalInteresNuevoNota").val();
    var tasaTotal = $("#idTblTasa").val();
    totalInteres = Number(totalInteres);
    tasaTotal = Number(tasaTotal);
    TasaDescGlb = Number(TasaDescGlb);
    AlmacDescGlb = Number(AlmacDescGlb);
    SeguDescGlb = Number(SeguDescGlb);
    tasaPorcentaje = (TasaDescGlb / tasaTotal) * 100;
    almPorcentaje = (AlmacDescGlb / tasaTotal) * 100;
    tasaPorcentaje = Math.round(tasaPorcentaje * 100) / 100;
    almPorcentaje = Math.round(almPorcentaje * 100) / 100;
    seguroPorcentaje = 100 - (tasaPorcentaje + almPorcentaje)
    var tasaDescuento = (totalInteres * tasaPorcentaje) / 100
    var almDescuento = (totalInteres * almPorcentaje) / 100
    var segDescuento = (totalInteres * seguroPorcentaje) / 100
    tasaDescuento = Math.round(tasaDescuento * 100) / 100;
    almDescuento = Math.round(almDescuento * 100) / 100;
    segDescuento = Math.round(segDescuento * 100) / 100;
    $("#idTblInteresDesc").val(tasaDescuento);
    $("#idTblAlmacenajeDesc").val(almDescuento);
    $("#idTblSeguroDesc").val(segDescuento);
}

function cambioNuevo(e) {
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) {
        return true;
    }
    var patron;
    patron = /[0-9.]/
    var te;
    te = String.fromCharCode(tecla);
    if (e.keyCode === 13 && !e.shiftKey) {
        var totalPagarNuevoNota = 0;
        if (tipoSinInteres == 0) {
            totalPagarNuevoNota = $("#totalPagarNuevoNota").val();
        } else {
            totalPagarNuevoNota = $("#totalSinInteresValue").val();
        }
        var idEfectivoNotaNuevo = $("#idEfectivoNotaNuevo").val();
        totalPagarNuevoNota = Number(totalPagarNuevoNota);
        idEfectivoNotaNuevo = Number(idEfectivoNotaNuevo);
        if (totalPagarNuevoNota <= idEfectivoNotaNuevo) {

            idEfectivoNotaNuevo = Math.round(idEfectivoNotaNuevo * 100) / 100;
            totalPagarNuevoNota = Math.round(totalPagarNuevoNota * 100) / 100;
            var cambioNuevoNota = (idEfectivoNotaNuevo - totalPagarNuevoNota);
            cambioNuevoNota = Math.round(cambioNuevoNota * 100) / 100;
            $("#efectivoNuevoNota").val(idEfectivoNotaNuevo);
            $("#cambioNuevoNota").val(cambioNuevoNota);
            cambioNuevoNota = formatoMoneda(cambioNuevoNota)
            $("#idCambioNotaNuevo").val(cambioNuevoNota);

            idEfectivoNotaNuevo = formatoMoneda(idEfectivoNotaNuevo)
            $("#idEfectivoNotaNuevo").val(idEfectivoNotaNuevo);
            $("#idEfectivoNotaNuevo").prop('disabled', true);
            $("#btnGenerar").prop('disabled', false);
            $("#btnGenerar").focus();
        } else {
            alert("El pago en efectivo no puede ser menor al total a pagar.");
        }
    }
    return patron.test(te);
}

function calcularTotalPagar(descuento, interesTotal, abono) {
    var prestamo = $("#prestamoNuevoNota").val();
    prestamo = Number(prestamo);

    var totalPagar = interesTotal + abono + prestamo;
    totalPagar = totalPagar - descuento;
    totalPagar = Math.round(totalPagar * 100) / 100;
    var totalPagarFormat = formatoMoneda(totalPagar)
    $("#idTotalAPagarNotaNuevo").val(totalPagarFormat);
    $("#totalPagarNuevoNota").val(totalPagar);
}

function limpiarRefrendo() {
    if (tipoSinInteres == 0) {
        var totalInteresNuevoNota = $("#totalInteresNuevoNota").val()
        $("#descuentoNuevoNota").val(0);
        $("#interesPagarNuevoNota").val(0);
        $("#abonoCapitalNuevoNota").val(0);
        $("#cambioNuevoNota").val(0);
        $("#interesPagarNuevoNota").val(totalInteresNuevoNota);
        $("#totalPagarNuevoNota").val(totalInteresNuevoNota);
        totalInteresNuevoNota = formatoMoneda(totalInteresNuevoNota);
        $("#idDescuentoNotaNuevo").val('');
        $("#idAbonoCapitalNotaNuevo").val('');
        $("#idEfectivoNotaNuevo").val('');
        $("#idCambioNotaNuevo").val('');
        $("#idInteresAPagarNotaNuevo").val(totalInteresNuevoNota);
        $("#idTotalAPagarNotaNuevo").val(totalInteresNuevoNota);

        $("#idValidaToken").val(0);
        $("#idDescuentoNotaNuevo").prop('disabled', false);
        $("#idAbonoCapitalNotaNuevo").prop('disabled', false);
        $("#idEfectivoNotaNuevo").prop('disabled', false);
    } else {
        $("#idEfectivoNotaNuevo").val('');
        $("#idCambioNotaNuevo").val('');
        $("#efectivoNuevoNota").val(0);
        $("#cambioNuevoNota").val(0);
        $("#idEfectivoNotaNuevo").prop('disabled', false);
    }
}

function validaDescuentoNuevo() {
    var idValidaToken = $("#idValidaToken").val();
    idValidaToken = parseFloat(idValidaToken);
    if (idValidaToken == 0) {
        generarNuevo();
    } else {
        $("#modalDescuento").modal();
    }
}

function tokenNuevo() {
    var tokenDes = $("#idCodigoAut").val();
    var dataEnviar = {
        "token": tokenDes
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Desempeno/Token.php',
        type: 'post',
        success: function (response) {
            if (response > 0) {
                $("#idToken").val(response);
                // var token = parseInt(response);
                var token = response;
                if (token > 20) {
                    alert("Los Token se estan terminando, favor de avisar al administrador");
                }
                alertify.success("Código correcto.");
                $("#tokenDescripcion").val(tokenDes);
                generarNuevo();

            } else {
                if (errorToken < 3) {
                    errorToken += 1;
                    alertify.warning("Error de código. Por favor Verifique.");

                } else {
                    alertify.error("Demasiados intentos. Intente más tarde.");
                }
            }
        },
    })

}

function generarNuevo() {
    //$tipe == 1 es refrendo normal
    //$tipe == 2 es refrendo auto
    //$tipe == 3 es desempeño normal
    //$tipe == 4 es desempeño auto

    var efectivoNuevoNota = $("#efectivoNuevoNota").val();
    efectivoNuevoNota = parseFloat(efectivoNuevoNota);
    var token = 0;
    var tokenDescripcion = "";
    var validate = 1;
    var nombreMensaje = "";
    //Descuento para guardar en bitacora y movimientos
    var descuentoAplicado = $("#descuentoNuevoNota").val();
    //Descuento para guardar en el contrato
    var descuentoAnterior = $("#descuentoAnteriorNuevoNota").val();
    descuentoAplicado = parseFloat(descuentoAplicado);
    descuentoAnterior = parseFloat(descuentoAnterior);
    var descuentoFinal = descuentoAplicado + descuentoAnterior;
    descuentoFinal = Math.round(descuentoFinal * 100) / 100;
    //Abono para guardar en bitacora y movimientos
    var abonoCapitalNuevoNota = 0;
    var abonoFinal = 0;
    var gps = null;
    var pension = null;
    var poliza = null;
    var newFechaVencimiento = null;
    var newFechaAlm = null;
    var idEstatusArt = 2;

    nombreMensaje = "Desempeño";
    gps = $("#gpsNuevoNota").val();
    poliza = $("#polizaNuevoNota").val();
    pension = $("#pensionNuevoNota").val();
    gps = Math.round(gps * 100) / 100;
    poliza = Math.round(poliza * 100) / 100;
    pension = Math.round(pension * 100) / 100;


    if (efectivoNuevoNota == 0) {
        alert("Por favor. Capture el pago en efectivo. ");
        validate = 0;
    }

    if (validate == 1) {
        var idValidaToken = $("#idValidaToken").val();
        idValidaToken = parseFloat(idValidaToken);
        if (idValidaToken != 0) {


            var totalVencInteres = $("#idTblInteresDesc").val();
            var totalVencAlm = $("#idTblAlmacenajeDesc").val();
            var totalVencSeg = $("#idTblSeguroDesc").val();

            totalVencInteres = Math.round(totalVencInteres * 100) / 100;
            totalVencAlm = Math.round(totalVencAlm * 100) / 100;
            totalVencSeg = Math.round(totalVencSeg * 100) / 100;
            var interesGenerado = totalVencInteres + totalVencAlm + totalVencSeg;

            token = $("#idToken").val();
            tokenDescripcion = $("#tokenDescripcion").val();
            var dataEnviar = {
                "tipeFormulario": tipeFormulario,
                "descuento": descuentoAplicado,
                "contrato": contratoGbl,
                "token": token,
                "tipoContrato": tipoContrato,
                "token_interes": interesGenerado,
                "token_moratorio": token_moratorio,
                "token_gps": token_gps,
                "token_pension": token_pension,
                "token_poliza": token_poliza,
                "token_movimiento": token_movimiento,
                "token_decripcion": tokenDescripcion,
                "gps": gps,
                "pension": pension,
                "poliza": poliza,
            };

            $.ajax({
                data: dataEnviar,
                url: '../../../com.Mexicash/Controlador/Desempeno/generarDesempeno.php',
                type: 'post',
                success: function (response) {
                    if (response > 0) {
                        alertify.success(nombreMensaje + " generado.")
                        MovimientosRefrendo(descuentoAplicado,descuentoFinal, abonoFinal, newFechaVencimiento, newFechaAlm);
                    } else {
                        alertify.error("Error al generar " + nombreMensaje);
                    }
                },
            })
        } else {
            alertify.success(nombreMensaje + " generado.")
            MovimientosRefrendo(descuentoAplicado,descuentoFinal, abonoFinal, newFechaVencimiento, newFechaAlm);
        }
    }
}

function MovimientosRefrendo(descuentoAplicado,descuentoFinal, abonoFinal, newFechaVencimiento, newFechaAlm) {
    // var descuento_aplicado = $("#descuentoNuevoNota").val();
    var e_capital_recuperado = $("#totalPagarNuevoNota").val();
    var intereses = $("#interesPagarNuevoNota").val();
    var e_moratorios = $("#moratoriosNuevoNota").val();
    var e_ivaValue = $("#idIVAValue").val();
    var prestamo_actual = $("#saldoPendienteNuevoNota").val();
    var e_pagoDesempeno = $("#prestamoNuevoNota").val();
    var e_gps = 0;
    var e_poliza = 0;
    var e_pension = 0;
    var movimiento = 0;
    if (tipeFormulario == 1) {
        movimiento = 5;
    } else if (tipeFormulario == 2) {
        movimiento = 9;
        e_gps = $("#gpsNuevoNota").val();
        e_poliza = $("#polizaNuevoNota").val();
        e_pension = $("#pensionNuevoNota").val();
        e_gps = Math.round(e_gps * 100) / 100;
        e_poliza = Math.round(e_poliza * 100) / 100;
        e_pension = Math.round(e_pension * 100) / 100;
    }
    var totalVencInteres = $("#idTblInteresDesc").val();
    var totalVencAlm = $("#idTblAlmacenajeDesc").val();
    var totalVencSeg = $("#idTblSeguroDesc").val();
    efectivoPDF = $("#efectivoNuevoNota").val();
    cambioPDF = $("#cambioNuevoNota").val();

    totalVencInteres = Math.round(totalVencInteres * 100) / 100;
    totalVencAlm = Math.round(totalVencAlm * 100) / 100;
    totalVencSeg = Math.round(totalVencSeg * 100) / 100;

    efectivoPDF = Math.round(efectivoPDF * 100) / 100;
    cambioPDF = Math.round(cambioPDF * 100) / 100;
    var totalPagar = $("#totalPagarNuevoNota").val();
    totalPagar = Math.round(totalPagar * 100) / 100;
    var subtotal = totalPagar -e_ivaValue ;
    subtotal = Math.round(subtotal * 100) / 100;
    e_pagoDesempeno = Math.round(e_pagoDesempeno * 100) / 100;

    e_capital_recuperado = Math.round(e_capital_recuperado * 100) / 100;
    intereses = Math.round(intereses * 100) / 100;
    e_moratorios = Math.round(e_moratorios * 100) / 100;
    e_ivaValue = Math.round(e_ivaValue * 100) / 100;
    prestamo_actual = Math.round(prestamo_actual * 100) / 100;

    var mov_contrato = contratoGbl;
    var mov_fechaVencimiento = newFechaVencimiento;
    var mov_fechaAlmoneda = newFechaAlm;
    var mov_prestamo_actual = prestamo_actual;
    var mov_prestamo_nuevo = 0;
    var mov_descuentoApl = descuentoAplicado;
    var mov_descuentoTotal = descuentoFinal;
    var mov_abonoTotal = 0;
    var mov_capitalRecuperado = e_capital_recuperado;
    var mov_pagoDesempeno = e_pagoDesempeno;
    var mov_abono = 0;
    var mov_intereses = intereses;
    var mov_interes = totalVencInteres;
    var mov_almacenaje = totalVencAlm;
    var mov_seguro = totalVencSeg;
    var mov_moratorios = e_moratorios;
    var mov_iva = e_ivaValue;
    var mov_gps = e_gps;
    var mov_poliza = e_poliza;
    var mov_pension = e_pension;
    var mov_costoContrato = 0;
    var mov_tipoContrato = tipoContrato;
    var mov_tipoMovimiento = movimiento;//Empeño
    var mov_Informativo = prestamoInfoGbl;
    var mov_subtotal = subtotal;
    var mov_total = totalPagar;
    var mov_efectivo = efectivoPDF;
    var mov_cambio = cambioPDF;

    Contrato_Mov(mov_contrato,mov_fechaVencimiento,mov_fechaAlmoneda,mov_prestamo_actual,mov_prestamo_nuevo,mov_descuentoApl,mov_descuentoTotal,
        mov_abonoTotal,mov_capitalRecuperado,mov_pagoDesempeno,mov_abono,mov_intereses,mov_interes,mov_almacenaje,mov_seguro,
        mov_moratorios,mov_iva,mov_gps,mov_poliza,mov_pension,mov_costoContrato,mov_tipoContrato,mov_tipoMovimiento,mov_Informativo,
        mov_subtotal,mov_total,mov_efectivo,mov_cambio);
    BitacoraUsuarioRefrendo();
}

function BitacoraUsuarioRefrendo() {
    //id_Movimiento = 3 cat_movimientos-->Operacion-->Empeño
    var movimiento = 0;
    if (tipoContrato == 1) {
        movimiento = 5;
    }
    if (tipoContrato == 2) {
        movimiento = 9;
    }

    var id_Movimiento = movimiento;
    var id_almoneda = 0;
    var id_cliente = id_ClientePDF;
    var consulta_fechaInicio = null;
    var consulta_fechaFinal = null;
    var idArqueo = 0;

    var dataEnviar = {
        "id_Movimiento": id_Movimiento,
        "id_contrato": contratoGbl,
        "id_almoneda": id_almoneda,
        "id_cliente": id_cliente,
        "consulta_fechaInicio": consulta_fechaInicio,
        "consulta_fechaFinal": consulta_fechaFinal,
        "idArqueo": idArqueo,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Bitacora/bitacoraUsuario.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                var  pdf = setTimeout(function(){ verPDFDesempeno(contratoGbl);}, 2000);
                var  recargar = setTimeout(function(){  location.reload(); }, 3000);
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
        }
    });
}

function verPDFDesempeno(contratoGbl) {
    window.open('../PDF/callPdfDesempeno.php?pdf=1&contrato=' + contratoGbl);
}

function MovimientosRefrendoSinInteres() {

    var newFechaVencimiento = null;
    var newFechaAlm = null;
    var prestamo_actual = $("#saldoPendienteNuevoNota").val();
    var prestamo_nuevo = 0;
    var s_descuento_aplicado = 0;
    var descuentoFinal = 0;
    var abonoFinal  = 0;
    var e_capital_recuperado = $("#totalSinInteresValue").val();
    var e_pagoDesempeno = $("#prestamoNuevoNota").val();
    var abono  = 0;
    var intereses = 0;
    var totalVencInteres = $("#idTblInteresDesc").val();
    var totalVencAlm = $("#idTblAlmacenajeDesc").val();
    var totalVencSeg = $("#idTblSeguroDesc").val();
    var e_moratorios = 0;
    var e_ivaValue = $("#idIVAValue").val();
    var e_gps = 0;
    var e_poliza = 0;
    var e_pension = 0;
    var costo_Contrato = $("#idCostoContratoValue").val();
    var totalPagar = $("#totalPagarNuevoNota").val();
    efectivoPDF = $("#efectivoNuevoNota").val();
    cambioPDF = $("#cambioNuevoNota").val();



    prestamo_actual = Math.round(prestamo_actual * 100) / 100;
    e_capital_recuperado = Math.round(e_capital_recuperado * 100) / 100;
    e_pagoDesempeno = Math.round(e_pagoDesempeno * 100) / 100;
    totalVencInteres = Math.round(totalVencInteres * 100) / 100;
    totalVencAlm = Math.round(totalVencAlm * 100) / 100;
    totalVencSeg = Math.round(totalVencSeg * 100) / 100;
    e_moratorios = Math.round(e_moratorios * 100) / 100;
    e_ivaValue = Math.round(e_ivaValue * 100) / 100;
   if (tipeFormulario == 2) {
        e_gps = $("#gpsNuevoNota").val();
        e_poliza = $("#polizaNuevoNota").val();
        e_pension = $("#pensionNuevoNota").val();
        e_gps = Math.round(e_gps * 100) / 100;
        e_poliza = Math.round(e_poliza * 100) / 100;
        e_pension = Math.round(e_pension * 100) / 100;
    }
    costo_Contrato = Math.round(costo_Contrato * 100) / 100;
    totalPagar = Math.round(totalPagar * 100) / 100;
    var subtotal = totalPagar -e_ivaValue ;
    subtotal = Math.round(subtotal * 100) / 100;
    efectivoPDF = Math.round(efectivoPDF * 100) / 100;
    cambioPDF = Math.round(cambioPDF * 100) / 100;

    var mov_contrato = contratoGbl;
    var mov_fechaVencimiento = newFechaVencimiento;
    var mov_fechaAlmoneda = newFechaAlm;
    var mov_prestamo_actual = prestamo_actual;
    var mov_prestamo_nuevo = prestamo_nuevo;
    var mov_descuentoApl = s_descuento_aplicado;
    var mov_descuentoTotal = descuentoFinal;
    var mov_abonoTotal = abonoFinal;
    var mov_capitalRecuperado = e_capital_recuperado;
    var mov_pagoDesempeno = e_pagoDesempeno;
    var mov_abono = abono;
    var mov_intereses = intereses;
    var mov_interes = totalVencInteres;
    var mov_almacenaje = totalVencAlm;
    var mov_seguro = totalVencSeg;
    var mov_moratorios = e_moratorios;
    var mov_iva = e_ivaValue;
    var mov_gps = e_gps;
    var mov_poliza = e_poliza;
    var mov_pension = e_pension;
    var mov_costoContrato = costo_Contrato;
    var mov_tipoContrato = tipoContrato;
    var mov_tipoMovimiento = 21;//Desempeño sin interes
    var mov_Informativo = prestamoInfoGbl;
    var mov_subtotal = subtotal;
    var mov_total = totalPagar;
    var mov_efectivo = efectivoPDF;
    var mov_cambio = cambioPDF;

    Contrato_Mov(mov_contrato,mov_fechaVencimiento,mov_fechaAlmoneda,mov_prestamo_actual,mov_prestamo_nuevo,mov_descuentoApl,mov_descuentoTotal,
        mov_abonoTotal,mov_capitalRecuperado,mov_pagoDesempeno,mov_abono,mov_intereses,mov_interes,mov_almacenaje,mov_seguro,
        mov_moratorios,mov_iva,mov_gps,mov_poliza,mov_pension,mov_costoContrato,mov_tipoContrato,mov_tipoMovimiento,mov_Informativo,
        mov_subtotal,mov_total,mov_efectivo,mov_cambio);
    BitacoraUsuarioRefrendoSinInteres();
}

function BitacoraUsuarioRefrendoSinInteres() {
    //id_Movimiento = 3 cat_movimientos-->Operacion-->Empeño

    var id_Movimiento = 21;
    var id_almoneda = 0;
    var id_cliente = id_ClientePDF;
    var consulta_fechaInicio = null;
    var consulta_fechaFinal = null;
    var idArqueo = 0;


    var dataEnviar = {
        "id_Movimiento": id_Movimiento,
        "id_contrato": contratoGbl,
        "id_almoneda": id_almoneda,
        "id_cliente": id_cliente,
        "consulta_fechaInicio": consulta_fechaInicio,
        "consulta_fechaFinal": consulta_fechaFinal,
        "idArqueo": idArqueo,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Bitacora/bitacoraUsuario.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                var  pdf = setTimeout(function(){ verPDFDesempenoSinInteres(contratoGbl);}, 2000);
                limpiarRefrendo()
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
        }
    });
}

function verPDFDesempenoSinInteres(contratoGbl) {
    window.open('../PDF/callPdfDesempenoSinInteres.php?pdf=1&contrato=' + contratoGbl);
}

//Alerta para confirmar la Eliminacion
function refrendoConfirmar() {
    alertify.confirm('Atención',
        'El contrato tiene fecha de movimiento del día de hoy, y no es posible refrendar, ¿Desea ir al módulo de desempeño?',
        function () {
            if (tipoContrato == 1) {
                location.href = 'vRefrendo.php?tipoFormGet=3&contrato=' + contratoGbl;

            } else if (tipoContrato == 2) {
                location.href = 'vRefrendo.php?tipoFormGet=4&contrato=' + contratoGbl;
            }
        },
        function () {
            if (tipoContrato == 1) {
                location.href = 'vRefrendo.php?tipoFormGet=1';

            } else if (tipoContrato == 2) {
                location.href = 'vRefrendo.php?tipoFormGet=2';
            }
        });
}

function desempenoSinInteres() {
    tipoSinInteres = 1;
    $("#trInteresNovo").hide();
    $("#trIva").hide();
    $("#trMoratorioNovo").hide();
    $("#trGPSNota").hide();
    $("#trPolizaNota").hide();
    $("#trPensionNota").hide();
    $("#trtotalInteresNovo").hide();
    $("#trDescuentoInteresNovo").hide();
    $("#trInteresPagarNovo").hide();
    $("#trAbonoNotaNuevo").hide();
    $("#trTotalAPagarNovo").hide();
    $("#btnGenerar").hide();

    $("#btnGenerarSinInteres").show();
    $("#trCostoContrato").show();
    $("#trTotalSinInteres").show();
    $("#trIvaSinInteres").show();
    var costoContrato = $("#idCostoContratoValue").val();
    var prestamoNuevoNota = $("#idPrestamoSinInteres").val();
    costoContrato = Number(costoContrato);
    prestamoNuevoNota = Number(prestamoNuevoNota);
    var totalSinInteres = costoContrato + prestamoNuevoNota;

    //Calculo de IVA
    var idIVAValue = $("#idTblIva").val();
    idIVAValue = Number(idIVAValue);
    idIVAValue = Math.round(idIVAValue * totalSinInteres) / 100;
    totalSinInteres = totalSinInteres + idIVAValue;
    $("#idIVAValue").val(idIVAValue);
    idIVAValue = formatoMoneda(idIVAValue);
    $("#idIVANotaNuevoSinInteres").val(idIVAValue);

    $("#totalSinInteresValue").val(totalSinInteres)
    totalSinInteres = formatoMoneda(totalSinInteres);
    $("#totalSinInteres").val(totalSinInteres);
}

function costoContrato($ContratoEnviado) {
    $("#idEfectivoNotaNuevo").prop('disabled', false);
    $("#idEfectivoNotaNuevo").focus();
    var dataEnviar = {
        "contrato": $ContratoEnviado,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Desempeno/CostoContrato.php',
        type: 'post',
        success: function (response) {
            if (response > 0) {
                $("#idCostoContratoValue").val(response);
                response = formatoMoneda(response);
                $("#idCostoContrato").val(response);
                desempenoSinInteres();
            } else {
                alertify.error("Error al validar el costo del contrato.");
            }
        },
    })

}


