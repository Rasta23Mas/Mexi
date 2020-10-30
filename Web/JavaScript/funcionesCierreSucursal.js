var idCierreSucursalGlb = 0;
var saldoInicialGbl = 0;

var CantAportacionesBovedaGlb = 0;
var aportacionesBovedaGlb = 0;
var CantRetirosBovedaGlb = 0;
var retirosBovedaGlb = 0;
var DotacionesCajaGlb = 0;
var CantCapitalRecuperadoGlb = 0;
var capitalRecuperadoGlb = 0;
var CantAbonoCapitalGlb = 0;
var abonoCapitalGlb = 0;
var interesesGlb = 0;
var ivaGlb = 0;
var CantVentasMostradorGlb = 0;
var ventasMostradorGlb = 0;
var ivaVentasGlb = 0;
var CantApartadoGlb = 0;
var apartadosVentasGlb = 0;
var CantAbonoGlb = 0;
var abonoVentaGlb = 0;
var gpsGlb = 0;
var polizaGlb = 0;
var pensionGlb = 0;
var CantAjustesGlb = 0;
var ajustesGlb = 0;
var CantIncrementoGlb = 0;
var incrementoGlb = 0;
var CantRetirosCajaGlb = 0;
var retirosCajaGlb = 0;
var CantPrestamosNuevosGlb = 0;
var prestamosNuevosGlb = 0;
var CantDescuentosGlb = 0;
var descuentosGlb = 0;
var CantDescuentosVentasGlb = 0;
var descuentosVentasGlb = 0;
var CantCostoContratoGbl = 0;
var costoContratoGbl = 0;
var totalEntradasGlb = 0;
var totalIVAGLB = 0;
var totalSalidasGlb = 0;
var saldoFinalGlb = 0;

//INFORMATIVOS
var InfoSaldoInicialGbl = 0;
var InfoEntradasGbl = 0;
var InfoSalidasGbl = 0;
var InfoSaldoFinalGbl = 0;
var totalAbonosGbl = 0;
var totalApartadosGbl = 0;
var totalInventarioGbl = 0;
var utilidadVentaGlb = 0;
var folioCierreSucursal = 0;
function validarEsatusSucursal() {
    var tipo = 1;
    idCierreSucursalGlb = $("#idCierreSucursal").text();
    var dataEnviar = {
        "tipo": tipo,
        "idCierreSucursal": idCierreSucursalGlb,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreSucursal.php',
        type: 'post',
        dataType: "json",
        success: function (response) {
            if (response.status == 'ok') {
                 folioCierreSucursal = response.result.folio_CierreSucursal;
                if (folioCierreSucursal > 0) {
                    llenarSaldosSucursal();
                } else {
                    alert("El proceso de Cierre de Sucursal ya fue realizado.");
                }
            } else {
                alertify.error('El cierre de sucursal ya fue realizado.')
            }
        },
    })
}
function llenarSaldosSucursal() {
    $("#guardarCaja").prop('disabled', false);
    $("#cargarUsuario").prop('disabled', true);
    var tipo = 2;
    var saldo_Inicial = 0;
    var InfoSaldoInicial = 0;
    var dataEnviar = {
        "tipo": tipo,
        "idCierreSucursal": idCierreSucursalGlb,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreSucursal.php',
        type: 'post',
        dataType: "json",
        success: function (response) {
            if (response.status == 'ok') {
                saldoInicialGbl = response.result.saldo_Inicial;
                InfoSaldoInicialGbl = response.result.InfoSaldoInicial;

                saldoInicialGbl = Math.round(saldoInicialGbl * 100) / 100;
                InfoSaldoInicialGbl = Math.round(InfoSaldoInicialGbl * 100) / 100;


                saldo_Inicial = formatoMoneda(saldoInicialGbl);
                InfoSaldoInicial = formatoMoneda(InfoSaldoInicialGbl);

                document.getElementById('saldoInicial').innerHTML = saldo_Inicial;
                document.getElementById('saldoInicialInfo').innerHTML = InfoSaldoInicial;

                llenarEntradasSalidas()
            } else {
                alertify.error("Error al generar cierre de sucursal.");
            }
        },
    })
}
function llenarEntradasSalidas() {
    var tipo = 3;
    var dataEnviar = {
        "tipo": tipo,
        "idCierreSucursal": idCierreSucursalGlb,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreSucursal.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var dotacionesA_CajaSuma = 0;
            var cantCapitalRecuperadoSuma = 0;
            var capitalRecuperadoSuma = 0;
            var cantAbonoSuma = 0;
            var abonoCapitalSuma = 0;
            var interesesSuma = 0;
            var ivaSuma = 0;
            var cantMostradorSuma = 0;
            var mostradorSuma = 0;
            var iva_ventaSuma = 0;
            var cantApartadosSuma = 0;
            var apartadosVentasSuma = 0;
            var cantAbonoVentasSuma = 0;
            var abonoVentasSuma = 0;
            var gpsSuma = 0;
            var polizaSuma = 0;
            var pensionSuma = 0;
            var CantAjustesSuma = 0;
            var ajustesSuma = 0;
            var CantIncrementoSuma = 0;
            var incrementoSuma = 0;
            var cantRetirosSuma = 0;
            var retirosCajaSuma = 0;
            var cantPrestamosSuma = 0;
            var prestamosNuevosSuma = 0;
            var cantDescuentosSuma = 0;
            var descuentosAplicadosSuma = 0;
            var cantDescuentosVentasSuma = 0;
            var descuento_VentasSuma = 0;
            var cantCostoContratoSuma = 0;
            var costoContratoSuma = 0;
            var total_SalidaSuma = 0;
            var total_EntradaSuma = 0;
            var total_IVASuma = 0;

            for (i; i < datos.length; i++) {
                var dotacionesA_Caja = datos[i].dotacionesA_Caja;
                var cantCapitalRecuperado = datos[i].cantCapitalRecuperado;
                var capitalRecuperado = datos[i].capitalRecuperado;
                var cantAbono = datos[i].cantAbono;
                var abonoCapital = datos[i].abonoCapital;
                var intereses = datos[i].intereses;
                var iva = datos[i].iva;
                var cantMostrador = datos[i].cantMostrador;
                var mostrador = datos[i].mostrador;
                var iva_venta = datos[i].iva_venta;
                var cantApartados = datos[i].cantApartados;
                var apartadosVentas = datos[i].apartadosVentas;
                var cantAbonoVentas = datos[i].cantAbonoVentas;
                var abonoVentas = datos[i].abonoVentas;
                var gps = datos[i].gps;
                var poliza = datos[i].poliza;
                var pension = datos[i].pension;
                var CantAjustes = datos[i].cantAjustes;
                var ajustes = datos[i].ajuste;
                var CantIncremento = datos[i].CantIncremento;
                var incrementoPatrimonio = datos[i].incrementoPatrimonio;
                var cantRetiros = datos[i].cantRetiros;
                var retirosCaja = datos[i].retirosCaja;
                var cantPrestamos = datos[i].cantPrestamos;
                var prestamosNuevos = datos[i].prestamosNuevos;
                var cantDescuentos = datos[i].cantDescuentos;
                var descuentosAplicados = datos[i].descuentosAplicados;
                var cantDescuentosVentas = datos[i].cantDescuentosVentas;
                var descuento_Ventas = datos[i].descuento_Ventas;
                var cantCostoContrato = datos[i].cantCostoContrato;
                var costoContrato = datos[i].costoContrato;
                var total_Salida = datos[i].total_Salida;
                var total_Entrada = datos[i].total_Entrada;
                var total_Iva = datos[i].totalIVA;


                dotacionesA_Caja = Math.round(dotacionesA_Caja * 100) / 100;
                cantCapitalRecuperado = Math.round(cantCapitalRecuperado * 100) / 100;
                capitalRecuperado = Math.round(capitalRecuperado * 100) / 100;
                cantAbono = Math.round(cantAbono * 100) / 100;
                abonoCapital = Math.round(abonoCapital * 100) / 100;
                intereses = Math.round(intereses * 100) / 100;
                iva = Math.round(iva * 100) / 100;
                cantMostrador = Math.round(cantMostrador * 100) / 100;
                mostrador = Math.round(mostrador * 100) / 100;
                iva_venta = Math.round(iva_venta * 100) / 100;
                cantApartados = Math.round(cantApartados * 100) / 100;
                apartadosVentas = Math.round(apartadosVentas * 100) / 100;
                cantAbonoVentas = Math.round(cantAbonoVentas * 100) / 100;
                abonoVentas = Math.round(abonoVentas * 100) / 100;
                gps = Math.round(gps * 100) / 100;
                poliza = Math.round(poliza * 100) / 100;
                pension = Math.round(pension * 100) / 100;
                CantAjustes = Math.round(CantAjustes * 100) / 100;
                ajustes = Math.round(ajustes * 100) / 100;
                CantIncremento = Math.round(CantIncremento * 100) / 100;
                incrementoPatrimonio = Math.round(incrementoPatrimonio * 100) / 100;
                cantRetiros = Math.round(cantRetiros * 100) / 100;
                retirosCaja = Math.round(retirosCaja * 100) / 100;
                cantPrestamos = Math.round(cantPrestamos * 100) / 100;
                prestamosNuevos = Math.round(prestamosNuevos * 100) / 100;
                cantDescuentos = Math.round(cantDescuentos * 100) / 100;
                descuentosAplicados = Math.round(descuentosAplicados * 100) / 100;
                cantDescuentosVentas = Math.round(cantDescuentosVentas * 100) / 100;
                descuento_Ventas = Math.round(descuento_Ventas * 100) / 100;
                cantCostoContrato = Math.round(cantCostoContrato * 100) / 100;
                costoContrato = Math.round(costoContrato * 100) / 100;
                total_Salida = Math.round(total_Salida * 100) / 100;
                total_Entrada = Math.round(total_Entrada * 100) / 100;
                dotacionesA_CajaSuma += dotacionesA_Caja;
                cantCapitalRecuperadoSuma += cantCapitalRecuperado;
                capitalRecuperadoSuma += capitalRecuperado;
                cantAbonoSuma += cantAbono;
                abonoCapitalSuma += abonoCapital;
                interesesSuma += intereses;
                ivaSuma += iva;
                cantMostradorSuma += cantMostrador;
                mostradorSuma += mostrador;
                iva_ventaSuma += iva_venta;
                cantApartadosSuma += cantApartados;
                apartadosVentasSuma += apartadosVentas;
                cantAbonoVentasSuma += cantAbonoVentas;
                abonoVentasSuma += abonoVentas;
                gpsSuma += gps;
                polizaSuma += poliza;
                pensionSuma += pension;
                CantAjustesSuma += CantAjustes;
                ajustesSuma += ajustes;
                CantIncrementoSuma += CantIncremento;
                incrementoSuma += incrementoPatrimonio;
                cantRetirosSuma += cantRetiros;
                retirosCajaSuma += retirosCaja;
                cantPrestamosSuma += cantPrestamos;
                prestamosNuevosSuma += prestamosNuevos;
                cantDescuentosSuma += cantDescuentos;
                descuentosAplicadosSuma += descuentosAplicados;
                cantDescuentosVentasSuma += cantDescuentosVentas;
                descuento_VentasSuma += descuento_Ventas;
                cantCostoContratoSuma += cantCostoContrato;
                costoContratoSuma += costoContrato;
                total_EntradaSuma += total_Entrada;
                total_SalidaSuma += total_Salida;
                total_IVASuma += total_Iva;
            }

            DotacionesCajaGlb += dotacionesA_CajaSuma;
            CantCapitalRecuperadoGlb += cantCapitalRecuperadoSuma;
            capitalRecuperadoGlb += capitalRecuperadoSuma;
            CantAbonoCapitalGlb += cantAbonoSuma;
            abonoCapitalGlb += abonoCapitalSuma;
            interesesGlb += interesesSuma;
            ivaGlb += ivaSuma;
            CantVentasMostradorGlb += cantMostradorSuma;
            ventasMostradorGlb += mostradorSuma;
            ivaVentasGlb += iva_ventaSuma;
            CantApartadoGlb += cantApartadosSuma;
            apartadosVentasGlb += apartadosVentasSuma;
            CantAbonoGlb += cantAbonoVentasSuma;
            abonoVentaGlb += abonoVentasSuma;
            gpsGlb += gpsSuma;
            polizaGlb += polizaSuma;
            pensionGlb += pensionSuma;
            CantAjustesGlb += CantAjustesSuma;
            ajustesGlb += ajustesSuma;
            CantIncrementoGlb += CantIncrementoSuma;
            incrementoGlb +=  incrementoSuma;
            CantRetirosCajaGlb += cantRetirosSuma;
            retirosCajaGlb += retirosCajaSuma;
            CantPrestamosNuevosGlb += cantPrestamosSuma;
            prestamosNuevosGlb += prestamosNuevosSuma;
            CantDescuentosGlb += cantDescuentosSuma;
            descuentosGlb += descuentosAplicadosSuma;
            CantDescuentosVentasGlb += cantDescuentosVentasSuma;
            descuentosVentasGlb += descuento_VentasSuma;
            CantCostoContratoGbl += cantCostoContratoSuma;
            costoContratoGbl += costoContratoSuma;
            totalEntradasGlb += total_EntradaSuma;
            totalIVAGLB += total_IVASuma;
            totalSalidasGlb += total_SalidaSuma;
            saldoFinalGlb = totalEntradasGlb - totalSalidasGlb;
            var saldoFinal = saldoFinalGlb;
            var dotacionesNew = dotacionesA_CajaSuma - cantRetirosSuma;
            var saldoFinalOper = dotacionesNew - saldoFinal;
            dotacionesA_CajaSuma = formatoMoneda(dotacionesA_CajaSuma);
            capitalRecuperadoSuma = formatoMoneda(capitalRecuperadoSuma);
            abonoCapitalSuma = formatoMoneda(abonoCapitalSuma);
            interesesSuma = formatoMoneda(interesesSuma);
            ivaSuma = formatoMoneda(ivaSuma);
            mostradorSuma = formatoMoneda(mostradorSuma);
            iva_ventaSuma = formatoMoneda(iva_ventaSuma);
            apartadosVentasSuma = formatoMoneda(apartadosVentasSuma);
            abonoVentasSuma = formatoMoneda(abonoVentasSuma);
            gpsSuma = formatoMoneda(gpsSuma);
            polizaSuma = formatoMoneda(polizaSuma);
            pensionSuma = formatoMoneda(pensionSuma);
            ajustesSuma = formatoMoneda(ajustesSuma);
            incrementoSuma = formatoMoneda(incrementoSuma);
            retirosCajaSuma = formatoMoneda(retirosCajaSuma);
            prestamosNuevosSuma = formatoMoneda(prestamosNuevosSuma);
            descuentosAplicadosSuma = formatoMoneda(descuentosAplicadosSuma);
            descuento_VentasSuma = formatoMoneda(descuento_VentasSuma);
            costoContratoSuma = formatoMoneda(costoContratoSuma);
            total_EntradaSuma = formatoMoneda(total_EntradaSuma);
            total_IVASuma = formatoMoneda(total_IVASuma);

            total_SalidaSuma = formatoMoneda(total_SalidaSuma);
            saldoFinal = formatoMoneda(saldoFinal);

            document.getElementById('totalDotacionesNew').innerHTML = dotacionesNew;
            document.getElementById('dotaciones').innerHTML = dotacionesA_CajaSuma;
            document.getElementById('CantRetirosCaja').innerHTML = "( " + cantRetirosSuma + " )";
            document.getElementById('retirosCaja').innerHTML = retirosCajaSuma;
            document.getElementById('CantRecuperado').innerHTML = "( " + cantCapitalRecuperadoSuma + " )";
            document.getElementById('recuperado').innerHTML = capitalRecuperadoSuma;
            document.getElementById('CantPrestamos').innerHTML = "( " + cantPrestamosSuma + " )";
            document.getElementById('prestamos').innerHTML = prestamosNuevosSuma;
            document.getElementById('CantAbono').innerHTML = "( " + cantAbonoSuma + " )";
            document.getElementById('abono').innerHTML = abonoCapitalSuma;
            document.getElementById('CantDescuentos').innerHTML = "( " + cantDescuentosSuma + " )";
            document.getElementById('descuentos').innerHTML = descuentosAplicadosSuma;
            document.getElementById('interes').innerHTML = interesesSuma;
            document.getElementById('CantDescVentas').innerHTML = "( " + cantDescuentosVentasSuma + " )";
            document.getElementById('descuentosVentas').innerHTML = descuento_VentasSuma;
            document.getElementById('CantCostoContrato').innerHTML = "( " + cantCostoContratoSuma + " )";
            document.getElementById('costoContrato').innerHTML = costoContratoSuma;
            document.getElementById('iva').innerHTML = ivaSuma;
            document.getElementById('CantVentas').innerHTML = "( " + cantMostradorSuma + " )";
            document.getElementById('ventas').innerHTML = mostradorSuma;
            document.getElementById('ivaVentas').innerHTML = iva_ventaSuma;
            document.getElementById('CantApartados').innerHTML = "( " + cantApartadosSuma + " )";
            document.getElementById('apartadoVenta').innerHTML = apartadosVentasSuma;
            document.getElementById('CantAbonoVenta').innerHTML = "( " + cantAbonoVentasSuma + " )";
            document.getElementById('abonoVenta').innerHTML = abonoVentasSuma;
            document.getElementById('gps').innerHTML = gpsSuma;
            document.getElementById('poliza').innerHTML = polizaSuma;
            document.getElementById('pension').innerHTML = pensionSuma;
            document.getElementById('CantAjustes').innerHTML = "( " + CantAjustesSuma + " )";
            document.getElementById('ajustes').innerHTML = ajustesSuma;
            document.getElementById('CantPatrimonio').innerHTML = "( " + CantIncrementoSuma + " )";
            document.getElementById('patrimonio').innerHTML = incrementoSuma;
            document.getElementById('totalEntrados').innerHTML = total_EntradaSuma;
            document.getElementById('totalIVA').innerHTML = total_IVASuma;
            document.getElementById('totalSalidas').innerHTML = total_SalidaSuma;
            document.getElementById('diferenciaOper').innerHTML = saldoFinal;


            document.getElementById('saldoFinal').innerHTML = saldoFinalOper;
            llenarGeneral();
        }
    })
}
function llenarGeneral() {
    var tipo = 4;
    var dataEnviar = {
        "tipo": tipo,
        "idCierreSucursal": idCierreSucursalGlb,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreSucursal.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            for (i; i < datos.length; i++) {
                var importe = datos[i].importe;
                var id_cat_flujo = datos[i].id_cat_flujo;
                var aportacionesBov =0;
                var retirosBoveda =0;
                importe = Math.round(importe * 100) / 100;
                id_cat_flujo = Math.round(id_cat_flujo * 100) / 100;

                if (id_cat_flujo == 3) {
                    //Aportaciones a Boveda
                    CantAportacionesBovedaGlb++;
                    aportacionesBovedaGlb += importe;
                }
                if (id_cat_flujo == 4) {
                    //Retiros de Boveda
                    CantRetirosBovedaGlb++;
                    retirosBovedaGlb += importe;
                }
            }

            aportacionesBov = formatoMoneda(aportacionesBovedaGlb);
            retirosBoveda = formatoMoneda(retirosBovedaGlb);
            document.getElementById('CantAportaciones').innerHTML = "( " + CantAportacionesBovedaGlb + " )";
            document.getElementById('aportaciones').innerHTML = aportacionesBov;
            document.getElementById('CantRetiros').innerHTML = "( " + CantRetirosBovedaGlb + " )";
            document.getElementById('retiros').innerHTML = retirosBoveda;
            llenarInformativo();
        }
    })
}
function llenarInformativo() {
    var tipo = 5;
    var dataEnviar = {
        "tipo": tipo,
        "idCierreSucursal": idCierreSucursalGlb,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreSucursal.php',
        type: 'post',
       dataType: "json",

        success: function (datos) {
            var i = 0;
            var abonosTotal = 0;
            var apartadosTotal = 0;

            for (i; i < datos.length; i++) {
                var apartado = datos[i].apartado;
                var abono = datos[i].abono;
                var tipo_movimiento = datos[i].tipo_movimiento;

                prestamo_EmpenoVenta = Math.round(prestamo_EmpenoVenta * 100) / 100;

                if(tipo_movimiento==22){
                    apartadosTotal += apartado;
                }
                else if(tipo_movimiento==23){
                    abonosTotal += abono;
                }
            }
            apartadosTotal = Math.round(apartadosTotal * 100) / 100;
            abonosTotal = Math.round(abonosTotal * 100) / 100;

            totalAbonosGbl = abonosTotal;
            totalApartadosGbl = apartadosTotal;

            abonosTotal = formatoMoneda(abonosTotal);
            apartadosTotal = formatoMoneda(apartadosTotal);


            document.getElementById('apartadosInfo').innerHTML = apartadosTotal;
            document.getElementById('abonosInfo').innerHTML = abonosTotal;
            llenarTotalInventario();
        }
    })
}
function llenarTotalInventario() {
    var tipo = 8;
    var dataEnviar = {
        "tipo": tipo,
        "idCierreSucursal": idCierreSucursalGlb,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreSucursal.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var totalInventario= 0;


            for (i; i < datos.length; i++) {
                var prestamo_Empeno = datos[i].s_prestamo_nuevo;
                var tipo_movimiento = datos[i].tipo_movimiento;
                prestamo_Empeno = Math.round(prestamo_Empeno * 100) / 100;
                if(tipo_movimiento==3){
                    totalInventario += prestamo_Empeno;
                }
            }

            totalInventario = Math.round(totalInventario * 100) / 100;
            totalInventarioGbl = totalInventario;
            totalInventario = formatoMoneda(totalInventario);
            document.getElementById('totalInventarioInfo').innerHTML = totalInventario;
            llenarVentas();
        }
    })
}
function llenarVentas() {
    alert("llenarVentas")
    var tipo = 6;
    var dataEnviar = {
        "tipo": tipo,
        "idCierreSucursal": idCierreSucursalGlb,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreSucursal.php',
        type: 'post',
        //dataType: "json",

        success: function (datos) {
            alert(datos)
            var i = 0;
            var salidasInfo = 0;
            var utilidadVenta = 0;


            for (i; i < datos.length; i++) {
                var prestamo_Informativo = datos[i].prestamo_Informativo;
                var v_PrecioVenta = datos[i].v_PrecioVenta;

                prestamo_Informativo = Math.round(prestamo_Informativo * 100) / 100;
                v_PrecioVenta = Math.round(v_PrecioVenta * 100) / 100;

                salidasInfo += prestamo_Informativo;
                var utilidad = v_PrecioVenta-prestamo_Informativo;

                utilidadVenta+=utilidad;
            }
            utilidadVenta = Math.round(utilidadVenta * 100) / 100;
            salidasInfo = Math.round(salidasInfo * 100) / 100;

            utilidadVentaGlb = utilidadVenta;
            InfoSalidasGbl = salidasInfo;

            utilidadVenta = formatoMoneda(utilidadVenta);
            salidasInfo = formatoMoneda(salidasInfo);


            document.getElementById('utilidad').innerHTML = utilidadVenta;
            document.getElementById('salidasInfo').innerHTML = salidasInfo;
            pasarBazar();
        }
    })
}
function pasarBazar() {
    alert("pasar")
    var tipo = 7;
    var dataEnviar = {
        "tipo": tipo,
        "idCierreSucursal": idCierreSucursalGlb,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreSucursal.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var entradasInfo = 0;
            for (i; i < datos.length; i++) {
                var prestamo_Informativo = datos[i].prestamo_Informativo;

                prestamo_Informativo = Math.round(prestamo_Informativo * 100) / 100;
                entradasInfo += prestamo_Informativo;
            }
            entradasInfo = Math.round(entradasInfo * 100) / 100;

            InfoEntradasGbl = entradasInfo;

            var saldofinal = InfoSaldoInicialGbl +InfoEntradasGbl;
            saldofinal = saldofinal - InfoSalidasGbl;
            saldofinal = Math.round(saldofinal * 100) / 100;
            InfoSaldoFinalGbl = saldofinal;

            entradasInfo = formatoMoneda(entradasInfo);
            saldofinal = formatoMoneda(saldofinal);

            document.getElementById('entradasInfo').innerHTML = entradasInfo;
            document.getElementById('saldoFinalInfo').innerHTML = saldofinal;

        }
    })
}
function confirmarCierreSucursal() {
    alertify.confirm('Cierre de Sucursal',
        'Al realizar el cierre de la sucursal, no podran volver a iniciar sesión el día de hoy. ' + '<br>' + '\n¿Desea continuar?',
        function () {
            guardarCierreSucursal();
        },
        function () {
            alertify.error('Cierre cancelado.')
        });
}
function guardarCierreSucursal() {
    var dataEnviar = {
        "dotacionesA_Caja": DotacionesCajaGlb,
        "cantAportacionesBoveda": CantAportacionesBovedaGlb,
        "aportaciones_Boveda": aportacionesBovedaGlb,
        "CantCapitalRecuperado": CantCapitalRecuperadoGlb,
        "capitalRecuperado": capitalRecuperadoGlb,
        "CantAbono": CantAbonoCapitalGlb,
        "abonoCapital": abonoCapitalGlb,
        "intereses": interesesGlb,
        "iva": ivaGlb,
        "CantVentasMostrador": CantVentasMostradorGlb,
        "mostrador": ventasMostradorGlb,
        "iva_venta": ivaVentasGlb,
        "cantCostoContrato": CantCostoContratoGbl,
        "costoContrato": costoContratoGbl,
        "utilidadVenta": utilidadVentaGlb,
        "CantApartados": CantApartadoGlb,
        "apartados": apartadosVentasGlb,
        "CantAbonosVenta": CantAbonoGlb,
        "abonoVenta": abonoVentaGlb,
        "gps": gpsGlb,
        "poliza": polizaGlb,
        "pension": pensionGlb,
        "cantAjustes": CantAjustesGlb,
        "ajustes": ajustesGlb,
        "CantRetirosCaja": CantRetirosCajaGlb,
        "retirosCaja": retirosCajaGlb,
        "CantRetirosBoveda": CantRetirosBovedaGlb,
        "retiros_boveda": retirosBovedaGlb,
        "CantPrestamosNuevos": CantPrestamosNuevosGlb,
        "prestamosNuevos": prestamosNuevosGlb,
        "CantDescuentos": CantDescuentosGlb,
        "descuentosAplicados": descuentosGlb,
        "CantDescuentosVentas": CantDescuentosVentasGlb,
        "descuentos_ventas": descuentosVentasGlb,
        "cantIncremento": CantIncrementoGlb,
        "incrementoPatrimonio": incrementoGlb,
        "total_Entrada": totalEntradasGlb,
        "total_Iva": totalIVAGLB,
        "total_Salida": totalSalidasGlb,
        "saldo_final": saldoFinalGlb,
        "InfoSaldoInicial": InfoSaldoInicialGbl,
        "InfoEntradas": InfoEntradasGbl,
        "InfoSalidas": InfoSalidasGbl,
        "InfoSaldoFinal": InfoSaldoFinalGbl,
        "InfoApartados": totalAbonosGbl,
        "InfoAbono": totalAbonosGbl,
        "InfoTotalInventario": totalInventarioGbl,
        "idCierreSucursal": idCierreSucursalGlb,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Cierre/GuardarSucursal.php',
        data: dataEnviar,
        success: function (response) {
            alert(response)
            if (response > 0) {
                guardarBazar();
            } else {
                alertify.error("Error de conexion, intente más tarde.")
            }
        }
    });
}
function guardarBazar() {
    //1 llena movimientos de dotacion y retiro
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Cierre/GuardarBazar.php',
        type: 'post',
        dataType: "json",
        success: function (response) {
            if(response==1){
                alertify.success("Se guardaron en bazar los articulos.")
                actualizarBazar();
            }else if(response==0){
                BitacoraUsuarioCierreSucursal();
            }
        },
    })
}
function actualizarBazar() {
    //1 llena movimientos de dotacion y retiro
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Cierre/ActualizaBazar.php',
        type: 'post',
        dataType: "json",
        success: function (response) {
            if(response>0){
                alertify.success("Se actualizaron en bazar los articulos.")
                BitacoraUsuarioCierreSucursal();
            }
        },
    })
}
function BitacoraUsuarioCierreSucursal() {
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
                cargarPDFCaja()
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
    window.open('../PDF/callPdfCierreSucursal.php?folioCierreSucursal=' + folioCierreSucursal);
}
function cargarPDFCajaDesdeBusqueda(folio) {
    window.open('../PDF/callPdfCierreSucursal.php?folioCierreSucursal=' + folio);
}

