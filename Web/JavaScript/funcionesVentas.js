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

function busquedaCodigoMostrador(e) {
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla === 8) {
        return true;
    }
    var patron;
    patron = /[0-9.]/
    var te;
    te = String.fromCharCode(tecla);
    if (e.keyCode === 13 && !e.shiftKey) {
        busquedaCodigoMostradorBoton();
    }
}

function busquedaCodigoMostradorBoton() {
    var idCodigo = $("#idCodigoMostrador").val();
    var tipoTabla = 0;
    var dataEnviar = {
        "idCodigo": idCodigo,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Ventas/busquedaCodigo.php',
        type: 'post',
        dataType: "json",
        success: function (datos) {
            if (datos.length > 0) {
                var html = '';
                var i = 0;
                for (i; i < datos.length; i++) {
                    var id_Contrato = datos[i].id_ContratoBaz;
                    var id_Bazar = datos[i].id_Bazar;
                    var id_serie = datos[i].id_serieBaz;
                    var empeno = datos[i].empeno;
                    var precio_venta = datos[i].precio_venta;
                    var descripcionCorta = datos[i].descripcionCorta;
                    var observaciones = datos[i].observaciones;
                    var avaluo = datos[i].avaluo;
                    var tipo = datos[i].tipoArt;
                    var precioEnviar = precio_venta;

                    var empeno = formatoMoneda(empeno);
                    var avaluo = formatoMoneda(avaluo);
                    var precio_venta = formatoMoneda(precio_venta);

                    if(observaciones===""){
                        observaciones="1";
                    }
                    tipoTabla = tipo;

                    //observaciones = observaciones.toUpperCase();
                    html += '<tr>' +
                        '<td>' + id_serie + '</td>' +
                        '<td>' + descripcionCorta + '</td>' +
                        '<td>' + empeno + '</td>' +
                        '<td>' + avaluo + '</td>' +
                        '<td>' + precio_venta + '</td>' +
                        '<td>' + observaciones + '</td>' +
                        '<td><input type="button" class="btn btn-info" data-dismiss="modal" value="Seleccionar" ' +
                        'onclick="calcularIva(' + id_Bazar + ',' + precioEnviar + ',' + id_Contrato + ',\'' + id_serie + '\')"></td>' +
                        '</tr>';

                }

                $('#idTBodyMetales').html(html);

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
    if (tecla === 8) {
        return true;
    }
    var patron;
    patron = /[0-9.]/
    var te;
    te = String.fromCharCode(tecla);
    if (e.keyCode === 13 && !e.shiftKey) {
        var totalPagar = $("#idTotalValue").val();
        var descuento = $("#idDescuento").val();

        totalPagar = Math.floor(totalPagar * 100) / 100;
        descuento = Math.floor(descuento * 100) / 100;

        if (totalPagar < descuento) {
            alert("El descuento no puede ser mayor que el total a pagar.")
        } else if (totalPagar === descuento) {
            alert("El descuento no puede ser igual que el total a pagar.")
        } else {
            $("#idEfectivo").val("");
            $("#idCambio").val("");
            $("#idEfectivoValue").val("");
            $("#idCambioValue").val("");
            var nuevoTotal = totalPagar - descuento;
            var precioFinal = Math.floor(nuevoTotal * 100) / 100;
            var precioFinalFormat = formatoMoneda(precioFinal);

            $("#idTotalPagar").val(precioFinalFormat);
            $("#idTotalValue").val(precioFinal);
            $("#idTotalBase").val(precioFinal);
            $("#idDescuentoValue").val(descuento);
            $("#idDescuento").prop('disabled', true);

        }
    }
    return patron.test(te);
}

function efectivoVenta(e) {
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla === 8) {
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
    if (cliente === 0) {
        alertify.warning("Favor de seleccionar el cliente.");
    } else if (vendedor === 0) {
        alertify.warning("Favor de seleccionar el vendedor.");
    } else if (efectivo === "" || idEfectivo == null) {
        alertify.warning("Favor de llenar el campo de efectivo.");
    } else {
        if (efectivoValue === 0) {
            alertify.warning("Favor de calcular el cambio.");
        } else {
            descuento = Math.floor(descuento * 100) / 100;
            if (descuento === 0) {
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
    if (id_ClienteGlb === 0) {
        alert("Debe seleccionar un cliente para el apartado.");
    } else {
        var vendedor = $("#idVendedor").val();
        if (vendedor === 0) {
            alert("Debe seleccionar un vendedor para el apartado.");
        } else {
            var efectivo = $("#idEfectivoValue").val();
            if (efectivo === 0) {
                alert("Debe calcular el cambio del cliente.");
            } else {

                var iva = $("#idIvaValue").val();
                var cambio = $("#idCambioValue").val();
                var precioVenta = $("#idSubTotalValue").val();
                var descuento = $("#idDescuentoValue").val();
                var idToken = $("#idToken").val();
                var tokenDesc = "";

                if (idToken !== 0) {
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
                            BitacoraVenta()
                        } else {
                            alertify.error("Error al guardar el apartado");
                        }
                    },
                })
            }
        }
    }
}

function BitacoraVenta() {
    //id_Movimiento = 22 -> Apartado

    var dataEnviar = {
        "id_Movimiento": tipo_movimientoGlb,
        "id_contrato": id_ContratoGlb,
        "id_almoneda": 0,
        "id_cliente": id_ClienteGlb,
        "consulta_fechaInicio": null,
        "consulta_fechaFinal": null,
        "idArqueo": 0,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Bitacora/bitacoraUsuario.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                verPDFVenta(idBazarGlb);
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
        }
    });
}

//Generar PDF
function verPDFVenta(idBazar) {
    window.open('../PDF/callPdfVenta.php?pdf=1&idBazar=' + idBazar);
    alert("Venta realizada.");
    $("#idFormVentas")[0].reset();
    $("#divTablaMetales").load('tablaMetales.php');
}

function configurarRango() {
    alert("configuración")
}