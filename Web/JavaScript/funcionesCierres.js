var saldoCajaGlobal = 0;
var efectivoCajaGlobal = 0;

var CantDotacionesGlb = 0;
var dotacionesCajaGlb = 0;
var CantCapitalRecuperadoGlb = 0;
var capitalRecuperadoGlb = 0;
var CantAbonoCapitalGlb = 0;
var abonoCapitalGlb = 0;
var CantInteresesGlb = 0;
var interesesGlb = 0;
var CantIvaGlb = 0;
var ivaGlb = 0;

var CantGPSGlb = 0;
var gpsGlb = 0;
var CantPolizaGlb = 0;
var polizaGlb = 0;
var CantPensionGlb = 0;
var pensionGlb = 0;
var CantRetirosGlb = 0;
var retirosGlb = 0;
var CantPrestamoNuevoGlb = 0;
var prestamoNuevoGlb = 0;
var CantDescuentoGlb = 0;
var descuentoGlb = 0;
var CantCostoContratoGlb = 0;
var costoContratoGlb = 0;
var TotalEntradaGlb = 0;
var TotalSalidaGlb = 0;
var SaldoCajaGlb = 0;
var EfectivoCajaGlb = 0;
var cantAjustesGlb = 0;
var ajustesGlb = 0;
var cantIncrementosGlb = 0;
var incrementoGlb = 0;
var CantRefrendosGlb = 0;
var refrendosGlb = 0;
//Guardar Cierre de Caja
//VENTA
var CantMostradorGlb = 0;
var mostradorGlb = 0;
var CantIvaVentaGlb = 0;
var ivaVentaGlb = 0;
var CantApartadosGlb = 0;
var abonoApartadosGlb = 0;
var CantAbonosGlb = 0;
var abonoAbonosGlb = 0;
var CantDescuentoVentasGlb = 0;
var descuentoVentasGlb = 0;
var CantRefrendoMigGlb = 0;
var refrendoMigGlb = 0;

var folioCierreCaja = 0;
var NombreUsuarioGlb = "";
var cerradoPorGerenteGlb = 0;
var efectivoGlobalNuevo = 0;
var idMaxArqueoGlb = 0;
var TotalIvaGlb = 0;

function validarEsatusCaja() {
//1 llena movimientos de dotacion y retiro
    var tipo = 4;
    var idUsuarioSelect = $("#idUsuarioCaja").val();
    var idCierreCaja = $("#idCierreCaja").text();
    var dataEnviar = {
        "tipo": tipo,
        "idUsuarioSelect": idUsuarioSelect,
        "idCierreCaja": idCierreCaja,

    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreCaja.php',
        type: 'post',
        dataType: "json",
        success: function (response) {
            if (response.status == 'ok') {
                var estatus = response.result.estatus;
                estatus = Number(estatus);
                folioCierreCaja = response.result.folio_CierreCaja;
                if (estatus == 2) {
                    alert("El proceso de Cierre de Caja ya fue realizado.");
                } else {
                    validarArqueoCierre();
                }
            }
        },
    })
}

function validarArqueoCierre() {
//1 llena movimientos de dotacion y retiro
    var tipo = 8;
    var idUsuarioSelect = $("#idUsuarioCaja").val();
    var idCierreCaja = $("#idCierreCaja").text();
    NombreUsuarioGlb = $('select[name="usuarioCaja"] option:selected').text();
    var dataEnviar = {
        "tipo": tipo,
        "idUsuarioSelect": idUsuarioSelect,
        "idCierreCaja": idCierreCaja,

    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreCaja.php',
        type: 'post',
        dataType: "json",
        success: function (response) {
            if (response.status == 'ok') {
                idMaxArqueoGlb = response.result.idArqueo;
                if(idMaxArqueoGlb!=null){
                    $("#guardarCaja").prop('disabled', false);
                    movimientosEfectivo();
                }else{
                    alert("El usuario: " + NombreUsuarioGlb + ", no tiene guardado el arqueo a caja.");
                    location.href = '../Cierre/vArqueo.php'
                }
            }else{
                alert("El usuario: " + NombreUsuarioGlb + ", no tiene guardado el arqueo a caja.");
                location.href = '../Cierre/vArqueo.php'
            }
        },
    })
}


function movimientosEfectivo() {
    //1 llena movimientos de dotacion y retiro
    var tipo = 1;
    var idUsuarioSelect = $("#idUsuarioCaja").val();
    var validaFlujo = 0;

    var idCierreCaja = $("#idCierreCaja").text();
    var dataEnviar = {
        "tipo": tipo,
        "idUsuarioSelect": idUsuarioSelect,
        "idCierreCaja": idCierreCaja,

    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreCaja.php',
        type: 'post',
        dataType: "json",
        success: function (datos) {
            var i = 0;
            var cantDotacion = 0;
            var cantRetiro = 0;
            var dotacionImporte = 0;
            var retiroImporte = 0;

            for (i; i < datos.length; i++) {
                validaFlujo = 1;
                var id_flujo = datos[i].id_cat_flujo;
                var importe = datos[i].importe;
                importe = Number(importe);
                if (id_flujo == 5) {
                    cantDotacion++;
                    dotacionImporte += importe;
                } else if (id_flujo == 6) {
                    cantRetiro++;
                    retiroImporte += importe;
                }
            }

            if (validaFlujo == 0) {
                alert("El usuario: " + NombreUsuarioGlb + ", no tiene dotaciones a caja.");
                location.href = '../Dotacion/vMovimientosCentral.php'
            } else {
                efectivoCajaGlobal = retiroImporte;


                saldoCajaGlobal = dotacionImporte - retiroImporte;

                //Guardar Cierre en Caja
                CantDotacionesGlb = cantDotacion;
                dotacionesCajaGlb = dotacionImporte;
                CantRetirosGlb = cantRetiro;
                retirosGlb = retiroImporte;

                dotacionImporte = formatoMoneda(dotacionImporte);
                retiroImporte = formatoMoneda(retiroImporte);

                document.getElementById('CantDotacionesCaja').innerHTML = "( " + cantDotacion + " )";
                document.getElementById('dotacionCajaVal').innerHTML = dotacionImporte;
                document.getElementById('CantRetiroCaja').innerHTML = "( " + cantRetiro + " )";
                document.getElementById('retiroCaja').innerHTML = retiroImporte;
                entradasSalidas();
            }
        }

    })


}

function entradasSalidas() {
    //1 llena entradas y salidas
    var tipo = 2;
    var idUsuarioSelect = $("#idUsuarioCaja").val();
    var idCierreCaja = $("#idCierreCaja").text();
    var dataEnviar = {
        "tipo": tipo,
        "idUsuarioSelect": idUsuarioSelect,
        "idCierreCaja": idCierreCaja,

    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreCaja.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var CantCapitalRecuperado = 0;
            var capitalRecuperado = 0;
            var CantAbonoCapital = 0;
            var abonoCapital = 0;
            var CantIva = 0;
            var iva = 0;
            var CantIntereses = 0;
            var intereses = 0;
            var CantCostoContrato = 0;
            var costoContrato = 0;
            var CantDescuento = 0;
            var descuento = 0;
            var CantPrestamoNuevo = 0;
            var prestamoNuevo = 0;

            var CantGPS = 0;
            var gps = 0;
            var CantPoliza = 0;
            var poliza = 0;
            var CantPension = 0;
            var pension = 0;

            var CantRefrendoMig = 0;
            var refrendoMig = 0;

            for (i; i < datos.length; i++) {
                var tipo_movimiento = datos[i].tipo_movimiento;
                var e_capital_recuperado = datos[i].e_capital_recuperado;

                var e_pagoDesempeno = datos[i].e_pagoDesempeno;
                var e_costoContrato = datos[i].e_costoContrato;
                var e_abono = datos[i].e_abono;
                var e_IVA = datos[i].e_iva;
                var s_descuento_aplicado = datos[i].s_descuento_aplicado;
                var s_prestamo_nuevo = datos[i].s_prestamo_nuevo;
                var e_intereses = datos[i].e_intereses;
                var e_moratorios = datos[i].e_moratorios;
                var e_gps = datos[i].e_gps;
                var e_poliza = datos[i].e_poliza;
                var e_pension = datos[i].e_pension;

                var migracion = datos[i].migracion;
                var e_refrendoMig = datos[i].refrendoMig;


                e_capital_recuperado = Math.round(e_capital_recuperado * 100) / 100;
                e_pagoDesempeno = Math.round(e_pagoDesempeno * 100) / 100;
                e_costoContrato = Math.round(e_costoContrato * 100) / 100;
                e_abono = Math.round(e_abono * 100) / 100;
                e_IVA = Math.round(e_IVA * 100) / 100;
                s_descuento_aplicado = Math.round(s_descuento_aplicado * 100) / 100;
                s_prestamo_nuevo = Math.round(s_prestamo_nuevo * 100) / 100;
                e_intereses = Math.round(s_descuento_aplicado * 100) / 100;
                e_moratorios = Math.round(s_prestamo_nuevo * 100) / 100;
                e_gps = Math.round(e_gps * 100) / 100;
                e_poliza = Math.round(e_poliza * 100) / 100;
                e_pension = Math.round(e_pension * 100) / 100;


                //Empeño y Empeño Auto 3 y 7
                if (tipo_movimiento == 3 || tipo_movimiento == 7) {
                    //Empeño y Empeño Auto
                    if(migracion==1){
                        e_refrendoMig = Math.round(e_refrendoMig * 100) / 100;
                        CantRefrendoMig++;
                        refrendoMig += e_refrendoMig;
                    }else{
                        CantPrestamoNuevo++;
                        prestamoNuevo += s_prestamo_nuevo;
                    }

                }
                //Refrendo 4
                if (tipo_movimiento == 4) {
                    CantAbonoCapital++;
                    abonoCapital += e_abono;
                    CantCapitalRecuperado++;
                    capitalRecuperado += e_capital_recuperado;
                    CantIva++;
                    iva += e_IVA;
                    CantIntereses++;
                    intereses += e_intereses;
                    if (e_moratorios !== 0) {
                        CantIntereses++;
                        intereses += e_moratorios;
                    }
                    if (s_descuento_aplicado !== 0) {
                        CantDescuento++;
                        descuento += s_descuento_aplicado;
                    }
                }

                //DESEMPEÑO 5
                if (tipo_movimiento == 5) {
                    //DESEMPEÑO
                    CantCapitalRecuperado++;
                    capitalRecuperado += e_capital_recuperado;
                    CantIva++;
                    iva += e_IVA;
                    CantIntereses++;
                    intereses += e_intereses;

                    if (e_moratorios !== 0) {
                        CantIntereses++;
                        intereses += e_moratorios;
                    }

                    if (s_descuento_aplicado !== 0) {
                        CantDescuento++;
                        descuento += s_descuento_aplicado;
                    }
                }
                //Refrendo AUTO 8
                if (tipo_movimiento == 8) {
                    CantAbonoCapital++;
                    abonoCapital += e_abono;
                    CantIva++;
                    iva += e_IVA;
                    CantIntereses++;
                    intereses += e_intereses;
                    CantCapitalRecuperado++;
                    capitalRecuperado += e_capital_recuperado;
                    //AUTO
                    CantGPS++;
                    gps += e_gps;
                    CantPoliza++;
                    poliza += e_poliza;
                    CantPension++;
                    pension += e_pension;

                    if (e_moratorios !== 0) {
                        CantIntereses++;
                        intereses += e_moratorios;
                    }

                    if (s_descuento_aplicado !== 0) {
                        CantDescuento++;
                        descuento += s_descuento_aplicado;
                    }

                }
                //DESEMPEÑO AUTO 9
                if (tipo_movimiento == 9) {
                    //DESEMPEÑO AUTO
                    CantCapitalRecuperado++;
                    capitalRecuperado += e_capital_recuperado;
                    CantIva++;
                    iva += e_IVA;
                    CantIntereses++;
                    intereses += e_intereses;

                    //AUTO
                    CantGPS++;
                    gps += e_gps;
                    CantPoliza++;
                    poliza += e_poliza;
                    CantPension++;
                    pension += e_pension;

                    if (e_moratorios !== 0) {
                        CantIntereses++;
                        intereses += e_moratorios;
                    }

                    if (s_descuento_aplicado !== 0) {
                        CantDescuento++;
                        descuento += s_descuento_aplicado;
                    }
                }
                //Desempeño sin interes 21
                if (tipo_movimiento == 21) {
                    //Desempeño sin interes
                    CantCapitalRecuperado++;
                    capitalRecuperado += e_capital_recuperado;
                    CantCostoContrato++;
                    costoContrato += e_costoContrato;
                    CantIva++;
                    iva += e_IVA;
                }

            }

            var totalEntrada = capitalRecuperado + costoContrato + refrendoMig;
            var totalSalidas = prestamoNuevo ;
            saldoCajaGlobal = saldoCajaGlobal + totalEntrada;
            saldoCajaGlobal = saldoCajaGlobal - totalSalidas;
            //Guardar Cierre en Caja
            CantRefrendoMigGlb = CantRefrendoMig;
            refrendoMigGlb = refrendoMig;

            CantCapitalRecuperadoGlb = CantCapitalRecuperado;
            capitalRecuperadoGlb = capitalRecuperado;
            CantAbonoCapitalGlb = CantAbonoCapital;
            abonoCapitalGlb = abonoCapital;
            CantInteresesGlb = CantIntereses;
            interesesGlb = intereses;
            CantIvaGlb = CantIva;
            ivaGlb = iva;
            CantGPSGlb = CantGPS;
            gpsGlb = gps;
            CantPolizaGlb = CantPoliza;
            polizaGlb = poliza;
            CantPensionGlb = CantPension;
            pensionGlb = pension;
            CantPrestamoNuevoGlb = CantPrestamoNuevo;
            prestamoNuevoGlb = prestamoNuevo;
            CantDescuentoGlb = CantDescuento;
            descuentoGlb = descuento;
            CantCostoContratoGlb = CantCostoContrato;
            costoContratoGlb = costoContrato;
            TotalSalidaGlb = totalSalidas;
            TotalEntradaGlb = totalEntrada;
            SaldoCajaGlb = saldoCajaGlobal;
            EfectivoCajaGlb = prestamoNuevo;
            TotalIvaGlb = ivaGlb +ivaVentaGlb;
            var totalIvaFormato = formatoMoneda(TotalIvaGlb);
            capitalRecuperado = formatoMoneda(capitalRecuperado);
            costoContrato = formatoMoneda(costoContrato);
            abonoCapital = formatoMoneda(abonoCapital);
            iva = formatoMoneda(iva);
            intereses = formatoMoneda(intereses);
            descuento = formatoMoneda(descuento);
            prestamoNuevo = formatoMoneda(prestamoNuevo);
            totalSalidas = formatoMoneda(totalSalidas);
            totalEntrada = formatoMoneda(totalEntrada);
            //AUTO
            gps = formatoMoneda(gps);
            poliza = formatoMoneda(poliza);
            pension = formatoMoneda(pension);

            var saldoCaja = formatoMoneda(saldoCajaGlobal);
            refrendoMig = formatoMoneda(refrendoMig);
            document.getElementById('CantRefrendoMig').innerHTML = "( " + CantRefrendoMig + " )";
            document.getElementById('refrendoMig').innerHTML = refrendoMig;
            //DESEMPEÑO SIN INTERES 21
            document.getElementById('CantCapitalRecuperado').innerHTML = "( " + CantCapitalRecuperado + " )";
            document.getElementById('capitalRecuperado').innerHTML = capitalRecuperado;
            document.getElementById('CantCostoContrato').innerHTML = "( " + CantCostoContrato + " )";
            document.getElementById('costoContrato').innerHTML = costoContrato;
            //REFRENDO 4
            document.getElementById('CantAbonoCapital').innerHTML = "( " + CantAbonoCapital + " )";
            document.getElementById('abonoCapital').innerHTML = abonoCapital;
            document.getElementById('CantIVA').innerHTML = "( " + CantIva + " )";
            document.getElementById('iva').innerHTML = iva;
            document.getElementById('CantIntereses').innerHTML = "( " + CantIntereses + " )";
            document.getElementById('intereses').innerHTML = intereses;
            //REFRENDO AUTO 8
            document.getElementById('CantGps').innerHTML = "( " + CantGPS + " )";
            document.getElementById('gps').innerHTML = gps;
            document.getElementById('CantPoliza').innerHTML = "( " + CantPoliza + " )";
            document.getElementById('poliza').innerHTML = poliza;
            document.getElementById('CantPension').innerHTML = "( " + CantPension + " )";
            document.getElementById('pension').innerHTML = pension;
            //DESCUENTO
            document.getElementById('CantDescuentos').innerHTML = "( " + CantDescuento + " )";
            document.getElementById('descuentos').innerHTML = descuento;
            //EMPEÑO Y EMPEÑO AUTO
            document.getElementById('CantPrestamosNuevos').innerHTML = "( " + CantPrestamoNuevo + " )";
            document.getElementById('prestamosNuevos').innerHTML = prestamoNuevo;
            //TOTAL ENTRADAS
            document.getElementById('totalEntradas').innerHTML = totalEntrada;
            //TOTAL IVA
            document.getElementById('totalIVA').innerHTML = totalIvaFormato;
            //TOTAL SALIDAS
            document.getElementById('totalSalidas').innerHTML = totalSalidas;
            //SALDO EN CAJA
            document.getElementById('saldoCaja').innerHTML = saldoCaja;

            entradasSalidasVentas()
        }
    })
}


function entradasSalidasVentas() {
    //1 llena entradas y salidas
    var tipo = 9;
    var idUsuarioSelect = $("#idUsuarioCaja").val();
    var idCierreCaja = $("#idCierreCaja").text();
    var dataEnviar = {
        "tipo": tipo,
        "idUsuarioSelect": idUsuarioSelect,
        "idCierreCaja": idCierreCaja,

    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreCaja.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;

            //VENTA
            var CantVenta = 0;
            var venta = 0;
            var CantVentaIVA = 0;
            var ventaIVA = 0;
            var CantApartado = 0;
            var ventaApartado = 0;
            var CantAbono = 0;
            var ventaAbono = 0;
            var CantDescuentoVenta = 0;
            var ventaDescuento = 0;

            for (i; i < datos.length; i++) {
                var tipo_movimiento = datos[i].tipo_movimiento;
                //VENTA
                var s_descuento_venta = datos[i].descuento_Venta;
                var e_venta_mostrador = datos[i].total;
                var e_venta_iva = datos[i].iva;
                var e_venta_apartados = datos[i].apartado;
                var e_venta_abono = datos[i].abono;

                //VENTA

                //Venta y Venta Auto 6 y 10
                if (tipo_movimiento == 6) {
                    e_venta_mostrador = Math.round(e_venta_mostrador * 100) / 100;
                    e_venta_iva = Math.round(e_venta_iva * 100) / 100;

                    CantVenta++;
                    venta += e_venta_mostrador;
                    CantVentaIVA++;
                    ventaIVA = e_venta_iva;
                    if (s_descuento_venta != 0) {
                        s_descuento_venta = Math.round(s_descuento_venta * 100) / 100;
                        CantDescuentoVenta++;
                        ventaDescuento += s_descuento_venta;
                    }
                }
                //Venta apartado 22
                if (tipo_movimiento == 22) {
                    e_venta_apartados = Math.round(e_venta_apartados * 100) / 100;
                    CantApartado++;
                    ventaApartado += e_venta_apartados;
                }
                //Venta apartado 23
                if (tipo_movimiento == 23) {
                    e_venta_abono = Math.round(e_venta_abono * 100) / 100;
                    CantAbono++;
                    ventaAbono += e_venta_abono;
                }
            }

            var totalEntrada = venta + ventaApartado + ventaAbono;
            TotalEntradaGlb += totalEntrada;
            TotalIvaGlb += ventaIVA;
            //Guardar Cierre en Caja

            //SaldoCajaGlb += saldoCajaGlobal;

            saldoCajaGlobal += totalEntrada;
            //Venta
            venta = formatoMoneda(venta);
            ventaIVA = formatoMoneda(ventaIVA);
            ventaDescuento = formatoMoneda(ventaDescuento);
            ventaApartado = formatoMoneda(ventaApartado);
            ventaAbono = formatoMoneda(ventaAbono);
            totalEntrada = formatoMoneda(TotalEntradaGlb);
            var iva = formatoMoneda(TotalIvaGlb);
            var saldoCaja = formatoMoneda(saldoCajaGlobal);

            //Venta
            document.getElementById('CantMostrador').innerHTML = "( " + CantVenta + " )";
            document.getElementById('mostrador').innerHTML = venta;
            document.getElementById('CantIvaVenta').innerHTML = "( " + CantVentaIVA + " )";
            document.getElementById('ivaVenta').innerHTML = ventaIVA;
            document.getElementById('CantDescuentosVentas').innerHTML = "( " + CantDescuentoVenta + " )";
            document.getElementById('descuentosVentas').innerHTML = ventaDescuento;
            document.getElementById('CantApartados').innerHTML = "( " + CantApartado + " )";
            document.getElementById('apartados').innerHTML = ventaApartado;
            document.getElementById('CantAbono').innerHTML = "( " + CantAbono + " )";
            document.getElementById('abono').innerHTML = ventaAbono;

            document.getElementById('totalEntradas').innerHTML = totalEntrada;
            document.getElementById('totalIVA').innerHTML = iva;
            document.getElementById('saldoCaja').innerHTML = saldoCaja;
            movimientosCaja()
        }
    })
}

function movimientosCaja() {
    //1 llena movimientos de dotacion y retiro
    var tipo = 3;
    var idUsuarioSelect = $("#idUsuarioCaja").val();
    var idCierreCaja = $("#idCierreCaja").text();
    var dataEnviar = {
        "tipo": tipo,
        "idUsuarioSelect": idUsuarioSelect,
        "idCierreCaja": idCierreCaja,

    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreCaja.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var efectivoSinRetiros = 0;
            var validaArqueo = 0;
            for (i; i < datos.length; i++) {
                validaArqueo = 1;
                var total_Cierre = datos[i].total_Cierre;
                total_Cierre = Number(total_Cierre);
                efectivoSinRetiros += total_Cierre;

            }
            if (validaArqueo == 0) {
                alert("El usuario: " + NombreUsuarioGlb + ", no tiene guardado el arqueo a caja.");
                location.href = '../Cierre/vArqueo.php'
            } else {
                $("#idUsuarioCaja").prop('disabled', true);
                efectivoGlobalNuevo = efectivoSinRetiros;
                efectivoSinRetiros = formatoMoneda(efectivoSinRetiros);
                document.getElementById('efectivoCaja').innerHTML = efectivoSinRetiros;
                cajaAjustes();
            }
        }
    })
}

function cajaAjustes() {
    //1 llena movimientos de dotacion y retiro
    var tipo = 7;
    var idUsuarioSelect = $("#idUsuarioCaja").val();
    var idCierreCaja = $("#idCierreCaja").text();
    var dataEnviar = {
        "tipo": tipo,
        "idUsuarioSelect": idUsuarioSelect,
        "idCierreCaja": idCierreCaja,

    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreCaja.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var CantAjustes = 0;
            var CantIncremento = 0;
            var ajusteTot = 0;
            var incrementoTot = 0;


            for (i; i < datos.length; i++) {
                var ajustes = datos[i].ajustes;
                var incremento_pat = datos[i].incremento_pat;
                ajustes = Number(ajustes);
                incremento_pat = Number(incremento_pat);
                if(ajustes!==0){
                    CantAjustes++;
                }
                if(incremento_pat!==0){
                    CantIncremento++;
                }
                ajusteTot += ajustes;
                incrementoTot += incremento_pat;
            }
            cantAjustesGlb = CantAjustes;
            ajustesGlb=ajusteTot;
            cantIncrementosGlb = CantIncremento;
            incrementoGlb=incrementoTot;

            ajusteTot = formatoMoneda(ajusteTot);
            incrementoTot = formatoMoneda(incrementoTot);
            document.getElementById('CantAjuste').innerHTML = "( " + CantAjustes + " )";
            document.getElementById('ajustesArq').innerHTML = ajusteTot;
            document.getElementById('CantPatrimonio').innerHTML = "( " + CantIncremento + " )";
            document.getElementById('patrimonio').innerHTML = incrementoTot;
            informeRefrendos();

        }
    })
}

function informeRefrendos() {
    //1 llena movimientos de dotacion y retiro
    var tipo = 6;
    var idUsuarioSelect = $("#idUsuarioCaja").val();
    var idCierreCaja = $("#idCierreCaja").text();
    var dataEnviar = {
        "tipo": tipo,
        "idUsuarioSelect": idUsuarioSelect,
        "idCierreCaja": idCierreCaja,

    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreCaja.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var informeRefrendo = 0;
            var CantInformaRefrendo = 0;

            for (i; i < datos.length; i++) {
                var Prestamo = datos[i].Prestamo;
                Prestamo = Number(Prestamo);
                CantInformaRefrendo++;
                informeRefrendo += Prestamo;
            }

            CantRefrendosGlb = CantInformaRefrendo;
            refrendosGlb = informeRefrendo;

            informeRefrendo = formatoMoneda(informeRefrendo);

            //INFORMES REFRENDOS
            document.getElementById('CantRefrendos').innerHTML = "( " + CantInformaRefrendo + " )";
            document.getElementById('refrendos').innerHTML = informeRefrendo;

        }
    })
}

function buscarCierreCaja() {
    var fechaInicial = fechaSQL($("#idFechaInicial").val());
    var fechaFinal = fechaSQL($("#idFechaFinal").val());
    var validate = 1;
    if (fechaInicial == "" && fechaFinal == "") {
        alert("Por favor, ingrese fechas para realizar la busqueda");
        validate = 0;
    } else if (fechaInicial == "") {
        alert("Por favor, ingrese fecha inicial para realizar la busqueda");
        validate = 0;
    } else if (fechaFinal == "") {
        alert("Por favor, ingrese fecha final para realizar la busqueda");
        validate = 0;
    }

    if (validate == 1) {
        var dataEnviar = {
            "tipe": 2,
            "fechaInicial": fechaInicial,
            "fechaFinal": fechaFinal
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Cierre/busqueda.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var html = '';
                var i = 0;
                for (i; i < datos.length; i++) {
                    var folio_CierreCaja = datos[i].folio_CierreCaja;
                    var id_CierreCaja = datos[i].id_CierreCaja;
                    var id_CierreSucursal = datos[i].id_CierreSucursal;
                    var usuario = datos[i].usuario;
                    var CerradoPorGerente = datos[i].CerradoPorGerente;
                    var fecha_Creacion = datos[i].fecha_Creacion;

                    if (CerradoPorGerente !== 0) {
                        CerradoPorGerente = "SI"
                    } else {
                        CerradoPorGerente = "";
                    }


                    html += '<tr align="center">' +
                        '<td>' + folio_CierreCaja + '</td>' +
                        '<td>' + id_CierreCaja + '</td>' +
                        '<td>' + id_CierreSucursal + '</td>' +
                        '<td>' + usuario + '</td>' +
                        '<td>' + CerradoPorGerente + '</td>' +
                        '<td>' + fecha_Creacion + '</td>' +
                        '<td><img src="../../style/Img/impresoraNor.png"  ' +
                        'alt="Imprimir" onclick="cargarPDFCajaDesdeBusqueda(' + folio_CierreCaja + ')"></td>' +
                        '</tr>';
                }
                $('#idCierreCajaModal').html(html);
            }
        });
    }
}

function limpiarCierreCaja() {
    location.reload();
}

function confirmarGuardarCierre() {
    var tipoSesion = $("#idTipoSesion").val();
    if (tipoSesion == 4) {
        if (folioCierreCaja == 0) {
            alert("Debe generar el  cargar la información de la caja.");
        } else {
            alertify.confirm('Cierre de caja',
                'Al realizar el cierre de la caja, no podra volver a iniciar sesión el día de hoy. ' + '<br>' + '\n¿Desea continuar?',
                function () {
                    guardarCierreCaja();
                },
                function () {
                    alertify.error('Cierre cancelado.')
                });
        }
    } else {
        guardarCierreCaja();
    }

}

function guardarCierreCaja() {
    var idCierreCaja = $("#idCierreCaja").text();
    var dataEnviar = {
        "cantDotaciones": CantDotacionesGlb,
        "dotacionesA_Caja": dotacionesCajaGlb,
        "cantCapitalRecuperado": CantCapitalRecuperadoGlb,
        "capitalRecuperado": capitalRecuperadoGlb,
        "cantAbono": CantAbonoCapitalGlb,
        "abonoCapital": abonoCapitalGlb,
        "cantInteres": CantInteresesGlb,
        "intereses": interesesGlb,
        "cantIva": CantIvaGlb,
        "iva": ivaGlb,
        "cantMostrador": CantMostradorGlb,
        "mostrador": mostradorGlb,
        "cantIvaVenta": CantIvaVentaGlb,
        "iva_venta": ivaVentaGlb,
        "cantApartados": CantApartadosGlb,
        "apartadosVenta": abonoApartadosGlb,
        "cantAbonoVenta": CantAbonosGlb,
        "abonoVentas": abonoAbonosGlb,
        "cantGps": CantGPSGlb,
        "gps": gpsGlb,
        "cantPoliza": CantPolizaGlb,
        "poliza": polizaGlb,
        "cantPension": CantPensionGlb,
        "pension": pensionGlb,
        "cantRetiros": CantRetirosGlb,
        "retirosCaja": retirosGlb,
        "cantPrestamos": CantPrestamoNuevoGlb,
        "prestamosNuevos": prestamoNuevoGlb,
        "cantDescuentos": CantDescuentoGlb,
        "descuentosAplicados": descuentoGlb,
        "cantDescuentosVentas": CantDescuentoVentasGlb,
        "descuento_Ventas": descuentoVentasGlb,
        "cantCostoContrato": CantCostoContratoGlb,
        "costoContrato": costoContratoGlb,
        "total_Salida": TotalSalidaGlb,
        "total_Entrada": TotalEntradaGlb,
        "total_Iva": TotalIvaGlb,
        "saldo_Caja": SaldoCajaGlb,
        "efectivo_Caja": efectivoGlobalNuevo,
        "cantRefrendos": CantRefrendosGlb,
        "informeRefrendo": refrendosGlb,
        "cantAjustes": cantAjustesGlb,
        "ajustes": ajustesGlb,
        "cantIncremento": cantIncrementosGlb,
        "incrementoPatrimonio": incrementoGlb,
        "idCierreCaja": idCierreCaja,
        "cerradoPorGerenteGlb": cerradoPorGerenteGlb,

    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Cierre/GuardarCaja.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                guardarFlujoCaja()
            } else {
                alertify.error("Error de conexion, intente más tarde.")
            }
        }

    });
}

function validarFolioCaja(){
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Cierre/ConValidarFolioCaja.php',
        type: 'post',
        success: function (response) {
            if (response < 0) {
                generarFolioCaja(2);
            }
        },
    })
}
function guardarFlujoCaja() {
    var importeLetra = NumeroALetras(efectivoGlobalNuevo);
    var idUsuarioCaja = $("#idUsuarioCaja").val();
    var dataEnviar = {
        "id_catFlujo": 9,
        "importe": efectivoGlobalNuevo,
        "importeLetra": importeLetra,
        "usuarioCaja": idUsuarioCaja,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/GuardarFlujoCaja.php',
        type: 'post',
        success: function (response) {
            if (response > 0) {
                generarFolioCaja(1);
            } else {
                alertify.error("Error al guardar la recolección de efectivo.");
            }
        },
    })
}

function generarFolioCaja(tipo) {
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Flujo/generarFolio.php',
        success: function (respuesta) {
            if(respuesta>0){
                if(tipo==1){
                    alert("Movimiento guardado.");
                    BitacoraUsuarioCierreCaja();
                }
            }else {
                alertify.error("Error al guardar el arqueo.");
            }
        }
    });
}


function BitacoraUsuarioCierreCaja() {
    //id_Movimiento = 18 Ciere de Caja
    //FEErr08
    var id_Movimiento = 18;
    var id_contrato = 0;
    var id_almoneda = 0;
    var id_cliente = 0;
    var consulta_fechaInicio = null;
    var consulta_fechaFinal = null;
    var idArqueo = 0;


    var dataEnviar = {
        "id_Movimiento": id_Movimiento,
        "id_contrato": id_contrato,
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
                cargarPDFCaja(folioCierreCaja)
                var tipoSesion = $("#idTipoSesion").val();
                if (tipoSesion == 4) {
                    cerrarSesion();
                } else {
                    setTimeout('location.reload();', 700)
                }

            } else {
                alertify.error("Error en al conectar con el servidor. (FEErr08)")
            }
        }
    });
}

function cargarPDFCaja() {
    window.open('../PDF/callPdfCierreCaja.php?folioCierreCaja=' + folioCierreCaja);
}

function cargarPDFCajaDesdeBusqueda(folio) {
    window.open('../PDF/callPdfCierreCaja.php?folioCierreCaja=' + folio);
}

function cambioDeCaja() {
    var idUserSesion = $("#idUserSesion").val();
    var idUsuarioCaja = $("#idUsuarioCaja").val();
    var id_cierreCaja = $("#idCierreCajaSesion").val();
    var NombreUsuario = $('select[name="usuarioCaja"] option:selected').text();
    if (idUserSesion !== idUsuarioCaja) {
        var idCierreCaja = $("#idCierreCaja").text();

        //1 llena movimientos de dotacion y retiro
        var tipo = 5;
        var dataEnviar = {
            "tipo": tipo,
            "idUsuarioSelect": idUsuarioCaja,
            "idCierreCaja": idCierreCaja,

        };
        $.ajax({
            data: dataEnviar,
            url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreCaja.php',
            type: 'post',
            dataType: "json",
            success: function (response) {
                if (response.status == 'ok') {
                    id_cierreCaja = response.result.id_cierreCaja;
                    document.getElementById('idCierreCaja').innerHTML = id_cierreCaja;
                    cerradoPorGerenteGlb = idUserSesion;
                } else {
                    alert("El usuario: " + NombreUsuario + " no cuenta con un cierre de caja activo.");
                }
                alert("Atención, Se ha cambiado el usuario para el cierre de caja." +
                    " Usuario : " + NombreUsuario + " Cierre Caja: " + id_cierreCaja);
            },
        })
    } else {
        document.getElementById('idCierreCaja').innerHTML = id_cierreCaja;

    }
}


