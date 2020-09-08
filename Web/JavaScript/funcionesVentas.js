var errorToken = 0;
//VENTA 6
var tipo_movimientoGlb = 6;
var id_ClienteGlb = 0;
var id_ContratoGlb = 0;
var id_serieGlb = 0;
var idBazarGlb = 0;
var idSubtotalGlb = 0;
var idIvaGlb = 0;

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
    if (tecla == 8) {
        return true;
    }
    var patron;
    patron = /[0-9.]/
    var te;
    te = String.fromCharCode(tecla);
    if (e.keyCode == 13 && !e.shiftKey) {
        busquedaCodigoMostradorBoton(1);
    }
}

function busquedaCodigoMostradorBoton(tipoBusqueda) {
    var idCodigo = $("#idCodigoMostrador").val();
    var dataEnviar = {
        "idCodigo": idCodigo,
        "tipoBusqueda": tipoBusqueda,
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
                    var id_ArticuloBazar = datos[i].id_ArtBazar;
                    var id_serie = datos[i].id_serieBaz;
                    var Adquisicion = datos[i].Adquisicion;
                    var empeno = datos[i].empeno;
                    var avaluo = datos[i].avaluo;
                    var precio_Actual = datos[i].precio_Actual;
                    var descripcionCorta = datos[i].descripcionCorta;
                    var observaciones = datos[i].observaciones;

                    var empeno = formatoMoneda(empeno);
                    var avaluo = formatoMoneda(avaluo);
                    var precio_ActualFormat = formatoMoneda(precio_Actual);

                    html += '<tr>' +
                        '<td>' + id_serie + '</td>' +
                        '<td>' + id_Contrato + '</td>' +
                        '<td>' + descripcionCorta + '</td>' +
                        '<td>' + Adquisicion + '</td>' +
                        '<td>' + empeno + '</td>' +
                        '<td>' + avaluo + '</td>' +
                        '<td>' + precio_ActualFormat + '</td>' +
                        '<td>' + observaciones + '</td>' +
                        '<td align="center">' +
                        '<img src="../../style/Img/carritoNor.png"  data-dismiss="modal" alt="Agregar"' +
                        'onclick="validarCarrito(' + id_ArticuloBazar + ',' + precio_Actual + ')"> ' +
                        '</td></tr>';

                }

                $('#idTBodyMetales').html(html);

                $("#btnVenta").prop('disabled', false);
            } else {
                alertify.error("No se encontro ningún artiículo en bazar.");
            }
        }
    });
}

//Carrito
function validarCarrito(id_ArticuloBazar, precio_Enviado) {
    var vendedor = $("#idVendedor").val();
    var cliente = $("#idClienteSeleccion").val();

    if (cliente == 0) {
        alertify.warning("Favor de seleccionar el cliente.");
    } else if (vendedor == 0) {
        alertify.warning("Favor de seleccionar el vendedor.");
    } else {
        $("#idNombreVenta").prop('disabled', true);
        $("#idClienteSeleccion").prop('disabled', true);
        var dataEnviar = {
            "id_ArticuloBazar": id_ArticuloBazar,
        };
        $.ajax({
            data: dataEnviar,
            url: '../../../com.Mexicash/Controlador/Ventas/CarritoValidar.php',
            type: 'post',
            success: function (respuesta) {
                if (respuesta == 0) {
                    agregarCarrito(id_ArticuloBazar, precio_Enviado,cliente,vendedor)
                } else {
                    alertify.error("El artículo ya esta en el carrito de compras.");
                }
            },
        })
    }
}

function agregarCarrito(id_ArticuloBazar, precio_Enviado,cliente,vendedor) {
        var tipoCarrito = 1;
        var dataEnviar = {
            "id_ArticuloBazar": id_ArticuloBazar,
            "idCliente": cliente,
            "idVendedor": vendedor,
        };
        $.ajax({
            data: dataEnviar,
            url: '../../../com.Mexicash/Controlador/Ventas/CarritoAgregar.php',
            type: 'post',
            success: function (respuesta) {
                if (respuesta == 1) {
                    busquedaCodigoMostradorBoton(3);
                    refrescarCarrito(precio_Enviado, tipoCarrito);
                } else {
                    alertify.error("Error al agregar el artículo.");
                }
            },
        })
}

function eliminarDelCarrito(id_Ventas, precio_Enviado) {
    var tipoCarrito = 2;
    var dataEnviar = {
        "id_Ventas": id_Ventas,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Ventas/CarritoEliminar.php',
        type: 'post',
        success: function (respuesta) {
            if (respuesta == 1) {
                refrescarCarrito(precio_Enviado, tipoCarrito);
            } else {
                alertify.error("Error al eliminar el artículo.");
            }
        },
    })
}

function limpiarCarrito() {
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Ventas/CarritoLimpiar.php',
        type: 'post',
        success: function (respuesta) {
            if (respuesta == 1) {
                refrescarCarrito(0, 3);
            }
        },
    })

}

function refrescarCarrito(precio_Enviado, tipoCarrito) {
    calcularIva(precio_Enviado, tipoCarrito);
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Ventas/CarritoRefrescar.php',
        type: 'post',
        dataType: "json",
        success: function (datos) {
            if (datos.length > 0) {
                var html = '';
                var i = 0;
                for (i; i < datos.length; i++) {
                    var id_ventas = datos[i].id_ventas;
                    var Codigo = datos[i].Codigo;
                    var id_Contrato = datos[i].id_ContratoVentas;
                    var descripcionCorta = datos[i].descripcionCorta;
                    var precio_Actual = datos[i].precio_Actual;
                    var precio_ActualFormat = formatoMoneda(precio_Actual);

                    html += '<tr>' +
                        '<td>' + Codigo + '</td>' +
                        '<td>' + id_Contrato + '</td>' +
                        '<td>' + descripcionCorta + '</td>' +
                        '<td>' + precio_ActualFormat + '</td>' +
                        '<td align="center">' +
                        '<img src="../../style/Img/eliminarNor.jpg"  data-dismiss="modal" alt="Eliminar"' +
                        'onclick="eliminarDelCarrito(' + id_ventas + ',' + precio_Actual + ')"> ' +
                        '</td></tr>';
                }
                $('#idTBodyArticulosCarrito').html(html);
                $("#btnVenta").prop('disabled', false);

            } else {
                var html = '';
                html += '<tr>' +
                    '<td colspan="5" align="center">Sin artículos en el carrito.</td></tr>';
                $('#idTBodyArticulosCarrito').html(html);
                $("#btnVenta").prop('disabled', true);

            }
        },
    })
}

function calcularIva(precio_Enviado, tipoCarrito) {
    $("#idDescuento").prop('disabled', false);
    if (tipoCarrito == 1) {
        idSubtotalGlb += precio_Enviado;
    } else if (tipoCarrito == 2) {
        idSubtotalGlb -= precio_Enviado;
    } else if (tipoCarrito == 3) {
        idSubtotalGlb = 0;
    }
    var precioFinal = Math.floor(idSubtotalGlb * 100) / 100;
    var calculaIva = Math.floor(precioFinal * 16) / 100;
    idIvaGlb = calculaIva;
    var precioFinalFormat = formatoMoneda(idSubtotalGlb);
    var calculaIvaFormat = formatoMoneda(idIvaGlb);
    var totalPagarFormat = formatoMoneda(idSubtotalGlb);
    $("#idSubTotal").val(precioFinalFormat);
    $("#idIva").val(calculaIvaFormat);
    $("#idTotalPagar").val(totalPagarFormat);
    $("#idSubTotalValue").val(idSubtotalGlb);
    $("#idIvaValue").val(idIvaGlb);
    $("#idTotalValue").val(idSubtotalGlb);
    $("#idTotalBase").val(idSubtotalGlb);


    $("#idDescuento").val("");
    $("#idEfectivo").val("");
    $("#idCambio").val("");
    $("#idDescuentoValue").val(0);
    $("#idEfectivoValue").val(0);
    $("#idCambioValue").val(0);


}

function cancelarVenta() {
    location.reload()
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
    if (e.keyCode == 13 && !e.shiftKey) {
        var totalPagar = $("#idTotalValue").val();
        var descuento = $("#idDescuento").val();

        totalPagar = Math.floor(totalPagar * 100) / 100;
        descuento = Math.floor(descuento * 100) / 100;

        if (totalPagar < descuento) {
            alert("El descuento no puede ser mayor que el total a pagar.")
        } else if (totalPagar == descuento) {
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
            $("#idEfectivo").prop('disabled', false);

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
    if (e.keyCode == 13 && !e.shiftKey) {

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
    if (efectivo == "" || idEfectivo == null) {
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


function guardarVenta() {
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