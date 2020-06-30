var errorToken = 0;
//VENTA 6
var tipo_movimientoGlb = 6;
var id_ClienteGlb = 0;
var id_ContratoGlb = 0;
var id_serieGlb = 0;
var idBazarGlb = 0;

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
                    $('#idClienteSeleccion').val(id);
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

function busquedaCodigoMostrador() {
    var idCodigo = $("#idCodigoMostrador").val();
    var tipoTabla = 0;
    var dataEnviar = {
        "idCodigo": idCodigo,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Ventas/busquedaCodigo.php',
        data: dataEnviar,
        dataType: "json",

        success: function (datos) {
            if (datos.length > 0) {
                var html = '';
                var i = 0;
                for (i; i < datos.length; i++) {
                    var id_Contrato = datos[i].id_Contrato;
                    var id_Bazar = datos[i].id_Bazar;
                    var id_serie = datos[i].id_serie;
                    var detalle = datos[i].detalle;
                    var kilataje = datos[i].kilataje;
                    var empeno = datos[i].empeno;
                    var avaluo = datos[i].avaluo;
                    var precio_venta = datos[i].precio_venta;
                    var ubicacion = datos[i].ubicacion;
                    var marca = datos[i].marca;
                    var modelo = datos[i].modelo;
                    var tipo = datos[i].tipoArt;
                    var precioEnviar = precio_venta;
                    var empeno = formatoMoneda(empeno);
                    var avaluo = formatoMoneda(avaluo);
                    var precio_venta = formatoMoneda(precio_venta);


                    tipoTabla = tipo;

                    if (tipo == 1) {
                        html += '<tr>' +
                            '<td>' + id_serie + '</td>' +
                            '<td>' + detalle + '</td>' +
                            '<td>' + kilataje + '</td>' +
                            '<td>' + empeno + '</td>' +
                            '<td>' + avaluo + '</td>' +
                            '<td>' + precio_venta + '</td>' +
                            '<td>' + ubicacion + '</td>' +
                            '<td><input type="button" class="btn btn-info" data-dismiss="modal" value="Seleccionar" ' +
                            'onclick="calcularIva(' + id_Bazar + ',' + precioEnviar + ',' + id_Contrato + ',\'' + id_serie + '\')"></td>' +
                            '</tr>';
                    } else if (tipo == 2) {
                        html += '<tr>' +
                            '<td>' + id_serie + '</td>' +
                            '<td>' + modelo + '</td>' +
                            '<td>' + marca + '</td>' +
                            '<td>' + empeno + '</td>' +
                            '<td>' + avaluo + '</td>' +
                            '<td>' + precio_venta + '</td>' +
                            '<td>' + ubicacion + '</td>' +
                            '<td><input type="button" class="btn btn-info" data-dismiss="modal" value="Seleccionar" ' +
                            'onclick="calcularIva(' + id_Bazar + ',' + precioEnviar + ',' + id_Contrato + ',\'' + id_serie + '\')"></td>' +
                            '</tr>';
                    }

                }
                if (tipoTabla == 1) {
                    $("#divTablaArticulos").hide();
                    $("#divTablaMetales").show();
                    $('#idTBodyMetales').html(html);
                } else if (tipoTabla == 2) {
                    $("#divTablaMetales").hide();
                    $("#divTablaArticulos").show();
                    $('#idTBodyArticulos').html(html);
                }
                $("#btnVenta").prop('disabled', false);
            } else {
                alertify.error("No se encontro ningún artiículo en bazar.");
            }
        }
    });
}

function calcularIva(id_Bazar, precio, id_Contrato, id_serie) {
    $("#idDescuento").prop('disabled', false);
    var precioFinal = Math.floor(precio * 100) / 100;
    var calculaIva = Math.floor(precioFinal * 16) / 100;
    var totalPagar = precioFinal + calculaIva;
    totalPagar = Math.floor(totalPagar * 100) / 100;
    var precioFinalFormat = formatoMoneda(precioFinal);
    var calculaIvaFormat = formatoMoneda(calculaIva);
    var totalPagarFormat = formatoMoneda(totalPagar);

    id_ContratoGlb = id_Contrato;
    id_serieGlb = id_serie;

    $("#idSubTotal").val(precioFinalFormat);
    $("#idIva").val(calculaIvaFormat);
    $("#idTotalPagar").val(totalPagarFormat);
    $("#idSubTotalValue").val(precioFinal);
    $("#idIvaValue").val(calculaIva);
    $("#idTotalValue").val(totalPagar);
    $("#idTotalBase").val(totalPagar);

}

function descuentoVenta(e) {
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
        var subTotal = $("#idSubTotalValue").val();
        var descuento = $("#idDescuento").val();

        subTotal = Math.floor(subTotal * 100) / 100;
        descuento = Math.floor(descuento * 100) / 100;

        if (subTotal < descuento) {
            alert("El descuento no puede ser mayor que el total a pagar.")
        } else if (subTotal == descuento) {
            alert("El descuento no puede ser igual que el total a pagar.")
        } else {
            $("#idEfectivo").val("");
            $("#idCambio").val("");
            $("#idEfectivoValue").val("");
            $("#idCambioValue").val("");
            var nuevoTotal = subTotal - descuento;
            var precioFinal = Math.floor(nuevoTotal * 100) / 100;
            var calculaIva = Math.floor(precioFinal * 16) / 100;
            var totalPagar = precioFinal + calculaIva;
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
            $("#idDescuentoValue").val(descuento);
            $("#idDescuento").prop('disabled', true);

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

        var totalValue = $("#idTotalValue").val();
        var efectivo = $("#idEfectivo").val();

        totalValue = Math.floor(totalValue * 100) / 100;
        efectivo = Math.floor(efectivo * 100) / 100;

        if (efectivo < totalValue) {
            alert("El efectivo no puede ser menor que el total a pagar.")
        } else {
            $("#idEfectivo").val("");
            $("#idCambio").val("");
            $("#idEfectivoValue").val("");
            $("#idCambioValue").val("");
            var cambio = efectivo - totalValue;
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

function validaVenta() {
    var descuento = $("#idDescuentoValue").val();
    var efectivo = $("#idEfectivo").val();
    var efectivoValue = $("#idEfectivoValue").val();
    var vendedor = $("#idVendedor").val();
    var cliente = $("#idClienteSeleccion").val();
    if (cliente == 0) {
        alertify.warning("Favor de seleccionar el cliente.");
    } else if (vendedor == 0) {
        alertify.warning("Favor de seleccionar el vendedor.");
    } else if (efectivo == "" || idEfectivo == null) {
        alertify.warning("Favor de llenar el campo de efectivo.");
    } else {
        if (efectivoValue == 0) {
            alertify.warning("Favor de calcular el cambio.");
        } else {
            descuento = Math.floor(descuento * 100) / 100;
            if (descuento == 0) {
                guardarVenta();
            } else {
                $("#modalDescuentoVenta").modal();
            }
        }
    }

}

function tokenVenta() {
    var tokenDes = $("#idCodigoVenta").val();
    var dataEnviar = {
        "token": tokenDes
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Token/TokenValidar.php',
        type: 'post',
        success: function (response) {
            if (response > 0) {
                $("#idToken").val(response);
                $("#tokenDescripcion").val(tokenDes);
                // var token = parseInt(response);
                var token = response;
                if (token > 20) {
                    alert("Los Token se estan terminando, favor de avisar al administrador");
                }
                alertify.success("Código correcto.");
                guardarVenta();
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

function guardarVenta() {
    /*
     22->Apartado
     */
    id_ClienteGlb = $("#idClienteSeleccion").val();
    if (id_ClienteGlb == 0) {
        alert("Debe seleccionar un cliente para el apartado.");
    } else {
        var vendedor = $("#idVendedor").val();
        if (vendedor == 0) {
            alert("Debe seleccionar un vendedor para el apartado.");
        } else {
            var efectivo = $("#idEfectivoValue").val();
            if (efectivo == 0) {
                alert("Debe calcular el cambio del cliente.");
            } else {

                var iva = $("#idIvaValue").val();
                var cambio = $("#idCambioValue").val();
                var precioVenta = $("#idSubTotalValue").val();
                var descuento = $("#idDescuentoValue").val();
                var idToken = $("#idToken").val();
                var tokenDesc = "";

                if (idToken != 0) {
                    tokenDesc = $("#tokenDescripcion").val();
                }

                var dataEnviar = {
                    "id_ContratoGlb": id_ContratoGlb,
                    "id_serieGlb": id_serieGlb,
                    "id_ClienteGlb": id_ClienteGlb,
                    "ivaGlb": iva,
                    "tipo_movimientoGlb": tipo_movimientoGlb,
                    "vendedorGlb": vendedor,
                    "efectivo": efectivo,
                    "cambio": cambio,
                    "precioVenta": precioVenta,
                    "descuento": descuento,
                    "idToken": idToken,
                    "tokenDesc": tokenDesc,
                };

                $.ajax({
                    data: dataEnviar,
                    url: '../../../com.Mexicash/Controlador/Ventas/guardarVenta.php',
                    type: 'post',
                    success: function (response) {
                        if (response > 0) {
                            idBazarGlb = response;
                            alertify.success("El artículo se ha apartado correctamente.")
                            BitacoraApartado()
                        } else {
                            alertify.error("Error al guardar el apartado");
                        }
                    },
                })
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