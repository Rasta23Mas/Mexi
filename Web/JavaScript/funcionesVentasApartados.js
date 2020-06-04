var errorToken = 0;
var id_ContratoGlb = 0;
var id_serieGlb = 0;
var tipo_movimientoGlb = 22;
var sucursalGlb = 0;


function nombreAutocompletarVenta() {
    $('#idNombreVenta').on('keyup', function () {
        var key = $('#idNombreVenta').val();
        var dataString = 'idNombres=' + key;
        var dataEnviar = {
            "idNombres": key
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Cliente/AutocompleteCliente.php',
            data: dataEnviar,
            success: function (data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestionsNombreVenta').fadeIn(1000).html(data);
                //Al hacer click en alguna de las sugerencias
                $('.suggest-element').on('click', function () {
                    //Obtenemos la id unica de la sugerencia pulsada
                    var id = $(this).attr('id');
                    var celular = $('#' + id).attr('celular');
                    var direccionComp = $('#' + id).attr('direccionCompleta');
                    //var estado = $('#' + id).attr('estadoDesc');
                    //Editamos el valor del input con data de la sugerencia pulsada
                    $('#idClienteVenta').val(id);
                    $('#idNombreVenta').val($('#' + id).attr('data'));
                    $("#idCelularVenta").val(celular);
                    $("#idDireccionVenta").val(direccionComp);
                    $("#btnEditar").prop('disabled', false);
                    //Hacemos desaparecer el resto de sugerencias
                    $('#suggestionsNombreVenta').fadeOut(1000);
                    return false;
                });

            }
        });
    });
}

function busquedaCodigoBazar() {
    // alert("busqueda mov");
    var codigo = $("#idCodigoApartado").val();
    var tipoTabla = 0;
    var dataEnviar = {
        "codigo": codigo,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Ventas/busquedaCodigoApartados.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var html = '';
            var i = 0;
            for (i; i < datos.length; i++) {
                var id_Contrato = datos[i].id_Contrato;
                var sucursal = datos[i].sucursal;
                var id_serie = datos[i].id_serie;
                var tipo_movimiento = datos[i].tipo_movimiento;
                var tipo = datos[i].tipoArt;
                var kilataje = datos[i].kilataje;
                var marca = datos[i].marca;
                var modelo = datos[i].modelo;
                var ubicacion = datos[i].ubicacion;
                var detalle = datos[i].detalle;
                var avaluo = datos[i].avaluo;
                var vitrina = datos[i].vitrina;
                var fecha_Modificacion = datos[i].fecha_Modificacion;
                var id_Articulo = datos[i].id_Articulo;
                var precio_venta = datos[i].precio_venta;
                var precioCat = datos[i].precioCat;


                id_ContratoGlb = id_Contrato
                id_serieGlb = id_serie;
                tipo_movimientoGlb = 22;
                sucursalGlb = sucursal;


                var precioFinal = precio_venta;
                var totalPagar = 0;
                precioFinal = Math.floor(precioFinal * 100) / 100;
                var calculaIva = Math.floor(precioFinal * 16) / 100;
                totalPagar = precioFinal + calculaIva;
                totalPagar = Math.floor(totalPagar * 100) / 100;
                var precioFinalFormat = formatoMoneda(precioFinal);
                var calculaIvaFormat = formatoMoneda(calculaIva);
                var totalPagarFormat = formatoMoneda(totalPagar);


                $("#idSubTotal").val(precioFinalFormat);
                $("#idIva").val(calculaIvaFormat);
                $("#idTotalPagar").val(totalPagarFormat);
                $("#idSubTotalValue").val(precioFinal);
                $("#idIvaValue").val(calculaIva);
                $("#idTotalValue").val(totalPagar);
                $("#idTotalBase").val(totalPagar);

                if (tipo_movimiento == 6) {
                    alert("El articulo fue vendido el día: " + fecha_Modificacion)
                }

                tipoTabla = tipo;

                if (tipo == 1) {
                    html += '<tr>' +
                        '<td>' + id_serie + '</td>' +
                        '<td>' + detalle + '</td>' +
                        '<td>' + kilataje + '</td>' +
                        '<td>' + avaluo + '</td>' +
                        '<td>' + vitrina + '</td>' +
                        '<td>' + ubicacion + '</td>' +
                        '</tr>';
                } else if (tipo == 2) {
                    html += '<tr>' +
                        '<td>' + id_serie + '</td>' +
                        '<td>' + modelo + '</td>' +
                        '<td>' + marca + '</td>' +
                        '<td>' + avaluo + '</td>' +
                        '<td>' + vitrina + '</td>' +
                        '<td>' + ubicacion + '</td>' +
                        '</tr>';
                }

            }
            if (tipoTabla == 1) {
                $('#idTBodyMetales').html(html);
            } else if (tipoTabla == 2) {
                $('#idTBodyArticulos').html(html);
            }
            $("#btnVenta").prop('disabled', false);
        }
    });
    if (tipoTabla == 1) {
        $("#divTablaMetales").load('tablaMetales.php');
    } else if (tipoTabla == 2) {
        $("#divTablaArticulos").load('tablaArticulos.php');
    }
}

function apartadoInicial(e) {
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

        var subtotalValue = $("#idSubTotalValue").val();
        var apartado = $("#idApartadoInicial").val();
        var totalPagar = 0;
        subtotalValue = Math.floor(subtotalValue * 100) / 100;
        apartado = Math.floor(apartado * 100) / 100;

        if (subtotalValue > apartado) {
            var totalApartado = subtotalValue - apartado;
            var calculaIva = Math.floor(totalApartado * 16) / 100;
            totalPagar = totalApartado + calculaIva;
            totalPagar = Math.floor(totalPagar * 100) / 100;
            $("#idEfectivo").val("");
            $("#idCambio").val("");

            $("#idApartadoInicialValue").val(apartado);
            $("#idSubTotalValue").val(totalApartado);
            $("#idIvaValue").val(calculaIva);
            $("#idTotalValue").val(totalPagar);

            var apartadoFormat = formatoMoneda(apartado);
            var totalApartadoFormat = formatoMoneda(totalApartado);
            var calculaIvaFormat = formatoMoneda(calculaIva);
            var totalPagarFormat = formatoMoneda(totalPagar);

            $("#idApartadoInicial").val(apartadoFormat);
            $("#idSubTotal").val(totalApartadoFormat);
            $("#idIva").val(calculaIvaFormat);
            $("#idTotalPagar").val(totalPagarFormat);

        } else {
            alert("El apartado tiene que ser menor al total.")
        }

    }
    return patron.test(te);
}

function efectivoVenta(e) {
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

        var apartado = $("#idApartadoInicialValue").val();
        var efectivo = $("#idEfectivo").val();

        apartado = Math.floor(apartado * 100) / 100;
        efectivo = Math.floor(efectivo * 100) / 100;

        if (efectivo < apartado) {
            alert("El efectivo no puede ser menor que el apartado a pagar.")
        } else {
            $("#idEfectivo").val("");
            $("#idCambio").val("");
            $("#idEfectivoValue").val("");
            $("#idCambioValue").val("");
            var cambio = efectivo - apartado;
            cambio = Math.floor(cambio * 100) / 100;

            $("#idEfectivoValue").val(efectivo);
            $("#idCambioValue").val(cambio);
            cambio = formatoMoneda(cambio);
            efectivo = formatoMoneda(efectivo);
            $("#idCambio").val(cambio);
            $("#idEfectivo").val(efectivo);
            $("#idEfectivo").prop('disabled', true);
        }
    }
    return patron.test(te);
}

function cancelarVenta() {
    //$("#idFormVentas")[0].reset();
    var totalBase = $("#idTotalBase").val();
    $("#idDescuento").val("");
    $("#idTotalPagar").val(totalBase);
    $("#idEfectivo").val("");
    $("#idCambio").val("");
    $("#idTotalValue").val(totalBase);
    $("#idDescuentoValue").val(0);
    $("#idEfectivoValue").val("");
    $("#idCambioValue").val("");
    $("#idDescuento").prop('disabled', false);
    $("#idEfectivo").prop('disabled', false);

    alertify.success("Se limpiaron descuento y pago.");
}

function guardarApartado() {
    /*
     22->Apartado
     */
    var cliente = $("#idClienteVenta").val();
    if(cliente==0){
        alert("Debe seleccionar un cliente para la venta.");
    }else{
        var vendedor = $("#idVendedor").val();
        if(vendedor==0){
            alert("Debe seleccionar un vendedor para la venta.");
        }else{
            var apartado = $("#idApartadoInicialValue").val();
            if(apartado==0){
                alert("Debe calcular el apartado inicial.");
            }else{

                if(apartado==0){
                    alert("Debe calcular el apartado inicial.");
                }else{
                    var iva = $("#idIvaValue").val();
                    var totalValue = $("#idTotalValue").val();
                    var fechaVencimiento = $("#idFechaVencimiento").text();
                    var dataEnviar = {
                        "id_ContratoGlb": id_ContratoGlb,
                        "id_serieGlb": id_serieGlb,
                        "id_ClienteGlb": cliente,
                        "precio_ActualGlb": totalValue,
                        "apartadoGlb": apartado,
                        "fechaVencimiento": fechaVencimiento,
                        "ivaGlb": iva,
                        "tipo_movimientoGlb": tipo_movimientoGlb,
                        "vendedorGlb": vendedor,
                        "sucursalGlb": sucursalGlb,
                    };

                    $.ajax({
                        data: dataEnviar,
                        url: '../../../com.Mexicash/Controlador/Ventas/guardarApartado.php',
                        type: 'post',
                        success: function (response) {
                            alert(response)
                            if (response > 0) {
                                alertify.success(nombreMensaje + " generado.")
                                MovimientosRefrendo(descuentoFinal, abonoFinal, newFechaVencimiento, newFechaAlm);
                            } else {
                                alertify.error("Error al generar " + nombreMensaje);
                            }
                        },
                    })
                }
            }
        }
    }
}

function MovimientosVenta(descuentoFinal, abonoFinal, newFechaVencimiento, newFechaAlm) {
    //tipo_movimiento = 6 cat_movimientos-->Operacion-->Venta
    var movimiento = 6;

    var id_contrato = id_ContratoPDF;
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
        "id_contrato": id_contrato,
        "fechaVencimiento": newFechaVencimiento,
        "fechaAlmoneda": newFechaAlm,
        "plazo": plazo,
        "periodo": periodo,
        "tipoInteres": tipoInteres,
        "prestamo_actual": prestamo_actual,
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


function configurarRango() {
    alert("configuración")
}
