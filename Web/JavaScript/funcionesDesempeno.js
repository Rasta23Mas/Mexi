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
//tipo de contrato 1 normal; 2 auto
//tipo de formulario 1 refrendo normal, 2 refrendo auto; 3 desempeño normal, 4 desempeño auto

function busquedaRefrendo(e) {
    if (e.keyCode === 13 && !e.shiftKey) {
        //estatusContrato();
        busquedaMovimiento();
    }
}

function busquedaMovimiento() {
   // alert("busqueda mov");
    //contratoGbl = $("#idContrato").val();
    contratoGbl = 117;

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
                    IdMovimientoGbl= datos[i].IdMovimiento;
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
//Consultar contrato
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
                        if (tipoMovimiento == 3||tipoMovimiento == 4||tipoMovimiento == 7||tipoMovimiento == 8) {
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

//Buscar cliente
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

//Buscar datos del contrato
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
                    //$("#idEstatusAnterior").val(datos[i].EstatusAnterior);

                    if (FechaEmpConvert == fechaHoyText) {
                        //Si la fecha es igual el dia de interes generado es 1
                        diasForInteres = 0;
                        if(DiasContrato!=0){
                            if (tipeFormulario == 1 || tipeFormulario == 2) {
                                refrendoConfirmar();
                            } else {
                                costoContrato(contratoGbl);
                            }
                        }
                    } else {
                        //Si la fecha es menor que hoy  el dia de interes generado es  el total -1
                        var diasdif = fechaHoy.getTime() - FechaEmpFormat.getTime();
                        diasForInteres = Math.round(diasdif / (1000 * 60 * 60 * 24));
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

                    if(DiasAlmoneda==0){
                        DiasAlmoneda=1;
                    }
                    $("#descuentoAnteriorNuevoNota").val(Descuento);
                    var nuevaFechaVencimiento = sumarDias(DiasContrato);
                    var nuevaFechaAlm = calcularDiasAlmoneda(DiasContrato, DiasAlmoneda)
                    $("#fechaVencimientoNuevoNota").val(nuevaFechaVencimiento);
                    $("#fechaAlmNuevoNota").val(nuevaFechaAlm);
                    //INTERES DIARIO
                    //Se saca los porcentajes mensuales
                    var calculaInteres = Math.floor(TotalPrestamo * TasaDesc) / 100;
                    var calculaALm = Math.floor(TotalPrestamo * AlmacDesc) / 100;
                    var calculaSeg = Math.floor(TotalPrestamo * SeguDesc) / 100;
                    //var calculaIva = Math.floor(TotalPrestamo * IvaDesc) / 100;

                    var totalInteres = calculaInteres + calculaALm + calculaSeg ;
                    //interes por dia
                    var interesDia = totalInteres / DiasContrato;
                    //TASA:
                    var tasaIvaTotal = TasaDesc + AlmacDesc + SeguDesc ;


                    //Porcentajes por dia
                    var diaInteres = calculaInteres / DiasContrato;
                    var diaAlm = calculaALm / DiasContrato;
                    var diaSeg = calculaSeg / DiasContrato;
                    //var diaIva = calculaIva / DiasContrato;
                    //INTERES:
                    var totalVencInteres = diaInteres * diasForInteres;
                    var totalVencInteresBit = totalVencInteres;
                    totalVencInteresBit = Math.round(totalVencInteresBit * 100) / 100;
                    interesesPDF = totalVencInteresBit;


                    //ALMACENAJE
                    var totalVencAlm = diaAlm * diasForInteres;
                    var totalVencAlmBit = totalVencAlm;
                    totalVencAlmBit = Math.round(totalVencAlmBit * 100) / 100;
                    almacenajePDF = totalVencAlmBit;


                    //SEGURO
                    var totalVencSeg = diaSeg * diasForInteres;
                    var totalVencSegBit = totalVencSeg;
                    totalVencSegBit = Math.round(totalVencSegBit * 100) / 100;
                    seguroPDF = totalVencSegBit;
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

                    /*
                                      document.getElementById('totalAPagarTD').innerHTML = TotalFinal;*/
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

                    totalPagarNuevoNota = totalPagarNuevoNota +ivaTotal;
                    $("#prestamoNuevoNota").val(prestamoNuevoNota);
                    $("#interesNuevoNota").val(interesNuevoNota);
                    //$("#idIVANotaNuevo").val(totalVencIVA);
                    token_interes = interesNuevoNota ;
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
                    //$("#idDescuentoNotaNuevo").val(TotalPrestamo);
                    $("#idInteresAPagarNotaNuevo").val(interesPagarNuevoNota);
                    //$("#idAbonoCapitalNotaNuevo").val(TotalPrestamo);
                    $("#idTotalAPagarNotaNuevo").val(totalPagarNuevoNota);


                    $("#btnLimpiar").prop('disabled', false);
                    $("#btnGenerar").prop('disabled', false);
                    $("#idDescuentoNotaNuevo").prop('disabled', false);
                    $("#idAbonoCapitalNotaNuevo").prop('disabled', false);
                    $("#idEfectivoNotaNuevo").prop('disabled', false);
                }
            }
        });
    }
}

//Buscar detalle del contrato
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

//Buscar detalle del auto
function buscarDetalleAuto() {
    if (contratoGbl != '') {
        var dataEnviar = {
            "tipe": 5,
            "contrato": contratoGbl,
            "tipoContrato": tipoContrato,
            "estatus": estatus
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
            }
        });
    }
}

function cancelar() {
    location.reload();
    //alertify.success(nombreMensaje + " generado.");
}

function cancelarSinInteres() {
    if (tipoContrato == 1) {
        location.href = 'vRefrendo.php?tipoFormGet=3';
    } else if (tipoContrato == 2) {
        location.href = 'vRefrendo.php?tipoFormGet=4';
    }
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
        var totalInteresNuevoNota = $("#totalInteresNuevoNota").val();
        var idDescuentoNotaNuevo = $("#idDescuentoNotaNuevo").val();
        var idIVAValue = $("#idTblIva").val();
        var prestamoNuevoNota = $("#prestamoNuevoNota").val();

        totalInteresNuevoNota = Number(totalInteresNuevoNota);
        idDescuentoNotaNuevo = Number(idDescuentoNotaNuevo);
        idIVAValue = Number(idIVAValue);
        prestamoNuevoNota = Number(prestamoNuevoNota);


        if (idDescuentoNotaNuevo != 0) {

            if (idDescuentoNotaNuevo <= totalInteresNuevoNota) {
                totalInteresNuevoNota = Math.round(totalInteresNuevoNota * 100) / 100;
                idDescuentoNotaNuevo = Math.round(idDescuentoNotaNuevo * 100) / 100;
                var idInteresAPagarNotaNuevo = (totalInteresNuevoNota - idDescuentoNotaNuevo);
                idInteresAPagarNotaNuevo = Math.round(idInteresAPagarNotaNuevo * 100) / 100;
                var idTotalAPagarNotaNuevo = 0;
                if (tipeFormulario == 1 || tipeFormulario == 2) {
                    var abonoCapitalNuevoNota = $("#abonoCapitalNuevoNota").val();
                    abonoCapitalNuevoNota = Number(abonoCapitalNuevoNota);
                    idTotalAPagarNotaNuevo = (idInteresAPagarNotaNuevo + abonoCapitalNuevoNota);
                    var prestamoParaIva = prestamoNuevoNota + idTotalAPagarNotaNuevo;

                    idIVAValue = Math.round(idIVAValue * prestamoParaIva) / 100;
                    idTotalAPagarNotaNuevo = idTotalAPagarNotaNuevo + idIVAValue;
                } else {
                    var prestamoNuevoNota = $("#prestamoNuevoNota").val();
                    prestamoNuevoNota = Number(prestamoNuevoNota);
                    idTotalAPagarNotaNuevo = (idInteresAPagarNotaNuevo + prestamoNuevoNota);

                    idIVAValue = Math.round(idIVAValue * idTotalAPagarNotaNuevo) / 100;
                    idTotalAPagarNotaNuevo = idTotalAPagarNotaNuevo + idIVAValue;
                }

                $("#idValidaToken").val(1);
                $("#descuentoNuevoNota").val(idDescuentoNotaNuevo);
                $("#interesPagarNuevoNota").val(idInteresAPagarNotaNuevo);
                $("#totalPagarNuevoNota").val(idTotalAPagarNotaNuevo);
                $("#idIVAValue").val(idIVAValue);

                idInteresAPagarNotaNuevo = formatoMoneda(idInteresAPagarNotaNuevo)
                idTotalAPagarNotaNuevo = formatoMoneda(idTotalAPagarNotaNuevo)
                idIVAValue = formatoMoneda(idIVAValue);

                $("#idInteresAPagarNotaNuevo").val(idInteresAPagarNotaNuevo);
                $("#idTotalAPagarNotaNuevo").val(idTotalAPagarNotaNuevo);
                $("#idIVANotaNuevo").val(idIVAValue);

            } else {
                alert("El descuento no puede ser mayor al interes.");
                $("#idEfectivoNotaNuevo").val('');
                $("#efectivoNuevoNota").val('');
            }
        }
    }
    return patron.test(te);
}

function abonoNuevo(e) {
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
        var prestamoNuevoNota = $("#prestamoNuevoNota").val();
        var idAbonoCapitalNotaNuevo = $("#idAbonoCapitalNotaNuevo").val();
        idAbonoCapitalNotaNuevo = Number(idAbonoCapitalNotaNuevo);
        prestamoNuevoNota = Number(prestamoNuevoNota);
        if (idAbonoCapitalNotaNuevo <= prestamoNuevoNota) {
            idAbonoCapitalNotaNuevo = Math.round(idAbonoCapitalNotaNuevo * 100) / 100;
            var interesPagarNuevoNota = $("#interesPagarNuevoNota").val();
            var idIVAValue = $("#idTblIva").val();
            idIVAValue = Number(idIVAValue);
            interesPagarNuevoNota = Number(interesPagarNuevoNota);
            var idTotalAPagarNotaNuevo = (interesPagarNuevoNota + idAbonoCapitalNotaNuevo);
            idTotalAPagarNotaNuevo = Math.round(idTotalAPagarNotaNuevo * 100) / 100;
            var saldoPendienteNuevoNota = (prestamoNuevoNota - idAbonoCapitalNotaNuevo);


            //Calculo de IVA
            var prestamoParaIva = prestamoNuevoNota + idTotalAPagarNotaNuevo;
            idIVAValue = Math.round(idIVAValue * prestamoParaIva) / 100;
            idTotalAPagarNotaNuevo = idTotalAPagarNotaNuevo + idIVAValue;
            $("#idIVAValue").val(idIVAValue);
            idIVAValue = formatoMoneda(idIVAValue);
            $("#idIVANotaNuevo").val(idIVAValue);



            $("#saldoPendienteNuevoNota").val(saldoPendienteNuevoNota);
            $("#totalPagarNuevoNota").val(idTotalAPagarNotaNuevo);
            $("#abonoCapitalNuevoNota").val(idAbonoCapitalNotaNuevo);

            idTotalAPagarNotaNuevo = formatoMoneda(idTotalAPagarNotaNuevo)
            $("#idTotalAPagarNotaNuevo").val(idTotalAPagarNotaNuevo);
        } else {
            alert("El abono no puede ser mayor al prestamo.");
        }
    }
    return patron.test(te);
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
        if (tipoSinInteres == 0) {
            descuentoNuevo(e);
            if (tipeFormulario == 1 || tipeFormulario == 2) {
                abonoNuevo(e);
            }
            var totalPagarNuevoNota = $("#totalPagarNuevoNota").val();
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

                var idDescuentoNotaNuevo = $("#idDescuentoNotaNuevo").val();
                var idAbonoCapitalNotaNuevo = $("#idAbonoCapitalNotaNuevo").val();
                idDescuentoNotaNuevo = formatoMoneda(idDescuentoNotaNuevo);
                idEfectivoNotaNuevo = formatoMoneda(idEfectivoNotaNuevo)
                idAbonoCapitalNotaNuevo = formatoMoneda(idAbonoCapitalNotaNuevo);
                $("#idDescuentoNotaNuevo").val(idDescuentoNotaNuevo);
                $("#idAbonoCapitalNotaNuevo").val(idAbonoCapitalNotaNuevo);
                $("#idEfectivoNotaNuevo").val(idEfectivoNotaNuevo);

                $("#idDescuentoNotaNuevo").prop('disabled', true);
                $("#idAbonoCapitalNotaNuevo").prop('disabled', true);
                $("#idEfectivoNotaNuevo").prop('disabled', true);
            } else {
                alert("El pago en efectivo no puede ser menor al total a pagar.");
            }
        } else {
            var totalSinInteresValue = $("#totalSinInteresValue").val();
            var idEfectivoNotaNuevo = $("#idEfectivoNotaNuevo").val();
            totalSinInteresValue = Number(totalSinInteresValue);
            idEfectivoNotaNuevo = Number(idEfectivoNotaNuevo);
            if (totalSinInteresValue <= idEfectivoNotaNuevo) {
                idEfectivoNotaNuevo = Math.round(idEfectivoNotaNuevo * 100) / 100;
                totalSinInteresValue = Math.round(totalSinInteresValue * 100) / 100;
                var cambioNuevoNota = (idEfectivoNotaNuevo - totalSinInteresValue);
                cambioNuevoNota = Math.round(cambioNuevoNota * 100) / 100;
                $("#efectivoNuevoNota").val(idEfectivoNotaNuevo);
                $("#cambioNuevoNota").val(cambioNuevoNota);
                cambioNuevoNota = formatoMoneda(cambioNuevoNota);
                idEfectivoNotaNuevo = formatoMoneda(idEfectivoNotaNuevo)
                $("#idCambioNotaNuevo").val(cambioNuevoNota);
                $("#idEfectivoNotaNuevo").val(idEfectivoNotaNuevo);
                $("#idEfectivoNotaNuevo").prop('disabled', true);
            } else {
                alert("El pago en efectivo no puede ser menor al total a pagar.");
            }
        }

    }
    return patron.test(te);
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

//Generar pago
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
    var descuento = $("#descuentoNuevoNota").val();
    //Descuento para guardar en el contrato
    var descuentoAnterior = $("#descuentoAnteriorNuevoNota").val();
    descuento = parseFloat(descuento);
    descuentoAnterior = parseFloat(descuentoAnterior);
    var descuentoFinal = descuento + descuentoAnterior;
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


    if (tipeFormulario == 1 || tipeFormulario == 2) {
        nombreMensaje = "Refrendo";
        abonoCapitalNuevoNota = $("#abonoCapitalNuevoNota").val();
        abonoCapitalPDF = abonoCapitalNuevoNota;
        //Abono para guardar en el contrato
        var abonoAnteriorNuevoNota = $("#abonoAnteriorNuevoNota").val();
        abonoCapitalNuevoNota = parseFloat(abonoCapitalNuevoNota);
        abonoAnteriorNuevoNota = parseFloat(abonoAnteriorNuevoNota);
        abonoFinal = abonoCapitalNuevoNota + abonoAnteriorNuevoNota;
        abonoFinal = Math.round(abonoFinal * 100) / 100;
        newFechaVencimiento = $("#fechaVencimientoNuevoNota").val();
        newFechaAlm = $("#fechaAlmNuevoNota").val();
    }   else if (tipeFormulario == 3 || tipeFormulario == 4) {
        nombreMensaje = "Desempeño";
        gps = $("#gpsNuevoNota").val();
        poliza = $("#polizaNuevoNota").val();
        pension = $("#pensionNuevoNota").val();
        gps = Math.round(gps * 100) / 100;
        poliza = Math.round(poliza * 100) / 100;
        pension = Math.round(pension * 100) / 100;
    }


    if (efectivoNuevoNota == 0) {
        alert("Por favor. Capture el pago en efectivo. ");
        validate = 0;
    }

    if (validate == 1) {
        var idValidaToken = $("#idValidaToken").val();
        idValidaToken = parseFloat(idValidaToken);
        if(idValidaToken != 0){
             token = $("#idToken").val();
             tokenDescripcion = $("#tokenDescripcion").val();
            var dataEnviar = {
                "tipeFormulario": tipeFormulario,
                "descuento": descuento,
                "contrato": contratoGbl,
                "token": token,
                "tipoContrato": tipoContrato,
                "token_interes": token_interes,
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
                        MovimientosRefrendo(descuentoFinal, abonoFinal, newFechaVencimiento, newFechaAlm);
                    } else {
                        alertify.error("Error al generar " + nombreMensaje);
                    }
                },
            })
        }else{
            alertify.success(nombreMensaje + " generado.")
            MovimientosRefrendo(descuentoFinal, abonoFinal, newFechaVencimiento, newFechaAlm);
        }
    }
}

/*function generarSinIntereses() {

    var efectivoNuevoNota = $("#efectivoNuevoNota").val();
    efectivoNuevoNota = parseFloat(efectivoNuevoNota);
    var validate = 1;

    if (efectivoNuevoNota == 0) {
        alert("Por favor. Capture el pago en efectivo. ");
        validate = 0;
    }

    if (validate == 1) {
        var saldoPendienteNuevoNota = 0;
        var descuentoFinal = 0;
        var idEstatusArt = 3;
        var estatusAnterior = $("#idEstatusAnterior").val();

        var nombreMensaje = "Desempeño sin interés";

        var dataEnviar = {
            "tipeFormulario": tipeFormulario,
            "saldoPendiente": saldoPendienteNuevoNota,
            "descuentoFinal": descuentoFinal,
            "contrato": contratoGbl,
            "idEstatusArt": idEstatusArt,
            "estatusAnterior": estatusAnterior,
        };


        $.ajax({
            data: dataEnviar,
            url: '../../../com.Mexicash/Controlador/Desempeno/generarDesempenoSinInteres.php',
            type: 'post',
            success: function (response) {
                alert(response)
                if (response > 0) {
                    alertify.success(nombreMensaje + " generado.")
                    MovimientosRefrendoSinInteres();
                } else {
                    alertify.error("Error al generar " + nombreMensaje);
                }
            },
        })
    }
}*/

function MovimientosRefrendo(descuentoFinal, abonoFinal, newFechaVencimiento, newFechaAlm) {
    //tipo_movimiento = 3 cat_movimientos-->Operacion-->Empeño
    var movimiento = 0;
    if (tipoContrato == 1) {
        if (tipeFormulario == 1) {
            movimiento = 4;
        } else if (tipeFormulario == 3) {
            movimiento = 5;
        }
    } else if (tipoContrato == 2) {
        if (tipeFormulario == 2) {
            movimiento = 8;
        } else if (tipeFormulario == 4) {
            movimiento = 9;
        }
    }


    var plazo = '';
    var periodo = '';
    var tipoInteres = '';
    var s_prestamo_nuevo = 0;
    var s_descuento_aplicado = $("#descuentoNuevoNota").val();
    var e_capital_recuperado = $("#totalPagarNuevoNota").val();
    var e_pagoDesempeno = 0;
    var e_abono = abonoCapitalPDF;
    var e_intereses = $("#interesPagarNuevoNota").val();
    var e_moratorios = $("#moratoriosNuevoNota").val();
    var e_ivaValue = $("#idIVAValue").val();
    var e_venta_mostrador = 0;
    var e_venta_iva = 0;
    var e_venta_apartados = 0;
    var e_gps = 0;
    var e_poliza = 0;
    var e_pension = 0;
    var prestamo_actual = $("#saldoPendienteNuevoNota").val();
    var tipo_Contrato = tipoContrato;
    var tipo_movimiento = movimiento;
    var costo_Contrato = 0;
    e_capital_recuperado = Math.round(e_capital_recuperado * 100) / 100;
    e_intereses = Math.round(e_intereses * 100) / 100;
    e_moratorios = Math.round(e_moratorios * 100) / 100;
    e_ivaValue = Math.round(e_ivaValue * 100) / 100;
    s_descuento_aplicado = Math.round(s_descuento_aplicado * 100) / 100;
    prestamo_actual = Math.round(prestamo_actual * 100) / 100;

    if (tipoContrato == 2) {
        e_gps = $("#gpsNuevoNota").val();
        e_poliza = $("#polizaNuevoNota").val();
        e_pension = $("#pensionNuevoNota").val();
        e_gps = Math.round(e_gps * 100) / 100;
        e_poliza = Math.round(e_poliza * 100) / 100;
        e_pension = Math.round(e_pension * 100) / 100;
    }

    if (tipeFormulario == 3 || tipeFormulario == 4) {
        prestamo_actual = 0;
        e_pagoDesempeno = $("#prestamoNuevoNota").val();
        e_abono = 0

    }
    var dataEnviar = {
        "id_contrato": contratoGbl,
        "fechaVencimiento": newFechaVencimiento,
        "fechaAlmoneda": newFechaAlm,
        "plazo": plazo,
        "periodo": periodo,
        "tipoInteres": tipoInteres,
        "prestamo_actual": prestamo_actual,
        "totalAvaluo": totalAvaluoGbl,
        "s_prestamo_nuevo": s_prestamo_nuevo,
        "s_descuento_aplicado": s_descuento_aplicado,
        "e_capital_recuperado": e_capital_recuperado,
        "e_pagoDesempeno": e_pagoDesempeno,
        "e_abono": e_abono,
        "e_intereses": e_intereses,
        "e_moratorios": e_moratorios,
        "e_iva": e_ivaValue,
        "e_venta_mostrador": e_venta_mostrador,
        "e_venta_iva": e_venta_iva,
        "e_venta_apartados": e_venta_apartados,
        "e_gps": e_gps,
        "e_poliza": e_poliza,
        "e_pension": e_pension,
        "tipo_Contrato": tipo_Contrato,
        "tipo_movimiento": tipo_movimiento,
        "abonoFinal": abonoFinal,
        "descuentoFinal": descuentoFinal,
        "costo_Contrato": costo_Contrato,
        "prestamo_Informativo": prestamoInfoGbl,

    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Movimientos/movimientosContrato.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                bitacoraPagosNuevo(response);
            } else {
                alertify.error("Error al conectar con el servidor. #fR01")
            }
        }
    });
}

function MovimientosRefrendoSinInteres() {
    //tipo_movimiento = 3 cat_movimientos-->Operacion-->Empeño
    var id_contrato = contratoGbl;
    var plazo = '';
    var periodo = '';
    var tipoInteres = '';
    var s_prestamo_nuevo = 0;
    var s_descuento_aplicado = 0;
    var e_capital_recuperado = $("#totalSinInteresValue").val();
    var e_pagoDesempeno = $("#prestamoNuevoNota").val();
    var e_abono = abonoCapitalPDF;
    var e_intereses = 0;
    var e_moratorios = 0;
    var e_iva = $("#idIVAValue").val();
    var e_venta_mostrador = 0;
    var e_venta_iva = 0;
    var e_venta_apartados = 0;
    var e_gps = 0;
    var e_poliza = 0;
    var e_pension = 0;
    var prestamo_actual = 0;
    var tipo_Contrato = tipoContrato;
    var tipo_movimiento = 21;
    var costo_Contrato = $("#idCostoContratoValue").val();
    var newFechaVencimiento = null;
    var newFechaAlm = null;
    var abonoFinal  = 0;
    var descuentoFinal  = 0;

    e_capital_recuperado = Math.round(e_capital_recuperado * 100) / 100;
    e_pagoDesempeno = Math.round(e_pagoDesempeno * 100) / 100;
    costo_Contrato = Math.round(costo_Contrato * 100) / 100;
    e_iva = Math.round(e_iva * 100) / 100;


    var dataEnviar = {
        "id_contrato": id_contrato,
        "fechaVencimiento": newFechaVencimiento,
        "fechaAlmoneda": newFechaAlm,
        "plazo": plazo,
        "periodo": periodo,
        "tipoInteres": tipoInteres,
        "prestamo_actual": prestamo_actual,
        "totalAvaluo": totalAvaluoGbl,
        "s_prestamo_nuevo": s_prestamo_nuevo,
        "s_descuento_aplicado": s_descuento_aplicado,
        "e_capital_recuperado": e_capital_recuperado,
        "e_pagoDesempeno": e_pagoDesempeno,
        "e_abono": e_abono,
        "e_intereses": e_intereses,
        "e_moratorios": e_moratorios,
        "e_iva": e_iva,
        "e_venta_mostrador": e_venta_mostrador,
        "e_venta_iva": e_venta_iva,
        "e_venta_apartados": e_venta_apartados,
        "e_gps": e_gps,
        "e_poliza": e_poliza,
        "e_pension": e_pension,
        "tipo_Contrato": tipo_Contrato,
        "tipo_movimiento": tipo_movimiento,
        "abonoFinal": abonoFinal,
        "descuentoFinal": descuentoFinal,
        "costo_Contrato": costo_Contrato,
        "prestamo_Informativo": prestamoInfoGbl,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Movimientos/movimientosContrato.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                bitacoraPagosNuevoSinInteres(response);
            } else {
                alertify.error("Error al conectar con el servidor. #fR01")
            }
        }
    });
}

//Guardar Bitacora Pagos
function bitacoraPagosNuevo(ultimoMovimiento) {
    //$tipe == 1 es refrendo normal
    //$tipe == 2 es refrendo auto
    //$tipe == 3 es desempeño normal
    //$tipe == 4 es desempeño auto
    efectivoPDF = $("#efectivoNuevoNota").val();
    cambioPDF = $("#cambioNuevoNota").val();
    descuentoAplicadoPDF = $("#descuentoNuevoNota").val();
    var e_iva = $("#idIVAValue").val();
    e_iva = Math.round(e_iva * 100) / 100;

    if (descuentoAplicadoPDF == '' || descuentoAplicadoPDF == null) {
        descuentoAplicadoPDF = 0;
    }
    var newFechaVencimiento = $("#fechaVencimientoNuevoNota").val();
    var newFechaAlm = $("#fechaAlmNuevoNota").val();

    if (tipeFormulario == 3 || tipeFormulario == 4) {
        abonoCapitalPDF = 0;
        newFechaVencimiento = null;
        newFechaAlm = null;
    }
    var costo_Contrato = 0;

    var dataEnviar = {
        "id_ContratoPDF": contratoGbl,
        "id_ClientePDF": id_ClientePDF,
        "prestamoPDF": prestamoPDF,
        "abonoCapitalPDF": abonoCapitalPDF,
        "interesesPDF": interesesPDF,
        "almacenajePDF": almacenajePDF,
        "seguroPDF": seguroPDF,
        "desempeñoExtPDF": desempeñoExtPDF,
        "moratoriosPDF": moratoriosPDF,
        "otrosCobrosPDF": otrosCobrosPDF,
        "descuentoAplicadoPDF": descuentoAplicadoPDF,
        "descuentoPuntosPDF": descuentoPuntosPDF,
        "ivaPDF": e_iva,
        "efectivoPDF": efectivoPDF,
        "cambioPDF": cambioPDF,
        "mutuoPDF": mutuoPDF,
        "refrendoPDF": refrendoPDF,
        "newFechaVencimiento": newFechaVencimiento,
        "newFechaAlm": newFechaAlm,
        "tipeFormulario": tipeFormulario,
        "costo_Contrato": costo_Contrato,
        "ultimoMovimiento" : ultimoMovimiento,
    };

    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Pagos/bitPagos.php',
        type: 'post',
        success: function (response) {
            if (response == 1) {
                BitacoraUsuarioRefrendo();
            }
        },
    })
}

function bitacoraPagosNuevoSinInteres(ultimoMovimiento) {
    //$tipe == 1 es refrendo normal
    //$tipe == 2 es refrendo auto
    //$tipe == 3 es desempeño normal
    //$tipe == 4 es desempeño auto
    var prestamoSinInteres = $("#idPrestamoSinInteres").val();
    var abonoCapitalPDFSinInteres = 0;
    var interesesPDFSinInteres = 0;
    var almacenajePDFSinInteres = 0;
    var seguroPDFSinInteres = 0;
    var desempeñoExtPDFSinInteres = 0;
    var moratoriosPDFSinInteres = 0;
    var otrosCobrosPDFSinInteres = 0;
    var descuentoAplicadoPDFSinInteres = 0;
    var descuentoPuntosPDFSinInteres = 0;
    var e_iva = $("#idIVAValue").val();
    e_iva = Math.round(e_iva * 100) / 100;
    efectivoPDF = $("#efectivoNuevoNota").val();
    cambioPDF = $("#cambioNuevoNota").val();


    var mutuoPDFSinInteres = 0;
    var refrendoPDFSinInteres = 0;
    var newFechaVencimiento =null;
    var newFechaAlm = null;
    var costo_Contrato = $("#idCostoContratoValue").val();
    costo_Contrato = Math.round(costo_Contrato * 100) / 100;
    efectivoPDF = Math.round(efectivoPDF * 100) / 100;
    cambioPDF = Math.round(cambioPDF * 100) / 100;

    var dataEnviar = {
        "id_ContratoPDF": contratoGbl,
        "id_ClientePDF": id_ClientePDF,
        "prestamoPDF": prestamoSinInteres,
        "abonoCapitalPDF": abonoCapitalPDFSinInteres,
        "interesesPDF": interesesPDFSinInteres,
        "almacenajePDF": almacenajePDFSinInteres,
        "seguroPDF": seguroPDFSinInteres,
        "desempeñoExtPDF": desempeñoExtPDFSinInteres,
        "moratoriosPDF": moratoriosPDFSinInteres,
        "otrosCobrosPDF": otrosCobrosPDFSinInteres,
        "descuentoAplicadoPDF": descuentoAplicadoPDFSinInteres,
        "descuentoPuntosPDF": descuentoPuntosPDFSinInteres,
        "ivaPDF": e_iva,
        "efectivoPDF": efectivoPDF,
        "cambioPDF": cambioPDF,
        "mutuoPDF": mutuoPDFSinInteres,
        "refrendoPDF": refrendoPDFSinInteres,
        "newFechaVencimiento": newFechaVencimiento,
        "newFechaAlm": newFechaAlm,
        "tipeFormulario": tipeFormulario,
        "costo_Contrato": costo_Contrato,
        "ultimoMovimiento" : ultimoMovimiento,

    };

    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Pagos/bitPagos.php',
        type: 'post',
        success: function (response) {
            if (response == 1) {
                BitacoraUsuarioRefrendoSinInteres();
            }
        },
    })
}

function BitacoraUsuarioRefrendo() {
    //id_Movimiento = 3 cat_movimientos-->Operacion-->Empeño
    var movimiento = 0;
    if (tipoContrato == 1) {
        if (tipeFormulario == 1) {
            movimiento = 4;
        } else if (tipeFormulario == 3) {
            movimiento = 8;
        }
    } else if (tipoContrato == 2) {
        if (tipeFormulario == 2) {
            movimiento = 8;
        } else if (tipeFormulario == 4) {
            movimiento = 9;
        }
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
                if (tipeFormulario == 1 || tipeFormulario == 2) {
                    cargarPDFRefrendo(contratoGbl);
                } else if (tipeFormulario == 3 || tipeFormulario == 4) {
                    cargarPDFDesempeno(contratoGbl);
                }
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
            cancelar();
        }
    });
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
                    cargarPDFDesempenoSinInteres(contratoGbl);
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
            cancelarSinInteres();
        }
    });
}

//Generar PDF
function cargarPDFRefrendo(contratoGbl) {
    window.open('../PDF/callPdfRefrendo.php?contrato=' + contratoGbl);
}

function verPDFRefrendo(contratoGbl) {
    window.open('../PDF/callPdfRefrendo.php?pdf=1&contrato=' + contratoGbl);
}

function cargarPDFDesempeno(contratoGbl) {
    window.open('../PDF/callPdfDesempeno.php?contrato=' + contratoGbl);
}

function verPDFDesempeno(contratoGbl) {
    window.open('../PDF/callPdfDesempeno.php?pdf=1&contrato=' + contratoGbl);
}

function cargarPDFDesempenoSinInteres(contratoGbl) {
    window.open('../PDF/callPdfDesempenoSinInteres.php?contrato=' + contratoGbl);
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
    alert("des sin in")
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


