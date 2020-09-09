var errorToken = 0;
//APARTADO 22
var tipo_movimientoGlb = 22;
var idBazarGlb = 0;
var id_ClienteGlb = 0;
var id_VendedorGlb = 0;
var idSubtotalGlb = 0;
var idApartadoGlb = 0;
var idFaltaPagarGlb = 0;
var idIvaGlb = 0;
var idTokenGLb = 0;

function buscaridBazarApartado() {
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Ventas/BuscarIdBazar.php',
        type: 'post',
        success: function (respuesta) {
            if (respuesta == 0) {
                location.reload();
            } else {
                $("#idBazar").val(respuesta);
            }
        },
    })
}

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

function busquedaCodigoApartado(e) {
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
        busquedaCodigoApartadoBoton(1);
    }
}

function busquedaCodigoApartadoBoton(tipoBusqueda) {
    var idCodigo = $("#idCodigoApartado").val();
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
        $("#idVendedor").prop('disabled', true);
        var dataEnviar = {
            "id_ArticuloBazar": id_ArticuloBazar,
        };
        $.ajax({
            data: dataEnviar,
            url: '../../../com.Mexicash/Controlador/Ventas/CarritoValidar.php',
            type: 'post',
            success: function (respuesta) {
                if (respuesta == 0) {
                    agregarCarrito(id_ArticuloBazar, precio_Enviado, cliente, vendedor)
                } else {
                    alertify.error("El artículo ya esta en el carrito de compras.");
                }
            },
        })
    }
}

function agregarCarrito(id_ArticuloBazar, precio_Enviado, cliente, vendedor) {
    id_ClienteGlb = cliente;
    id_VendedorGlb = vendedor;
    var tipoCarrito = 1;
    var idBazar = $("#idBazar").val();
    var dataEnviar = {
        "id_ArticuloBazar": id_ArticuloBazar,
        "idCliente": cliente,
        "idVendedor": vendedor,
        "idBazar": idBazar,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Ventas/CarritoAgregar.php',
        type: 'post',
        success: function (respuesta) {
            if (respuesta == 1) {
                busquedaCodigoApartadoBoton(3);
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

function limpiarCarritoApartado() {
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


            } else {
                var html = '';
                html += '<tr>' +
                    '<td colspan="5" align="center">Sin artículos en el carrito.</td></tr>';
                $('#idTBodyArticulosCarrito').html(html);
            }
        },
    })
}

function calcularIva(precio_Enviado, tipoCarrito) {
    $("#idApartadoInicial").prop('disabled', false);
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
    $("#idApartadoInicial").val("");
    $("#idfaltaPagar").val("");
    $("#idEfectivo").val("");
    $("#idCambio").val("");
    $("#idApartadoInicialValue").val(0);
    $("#faltaPagarValue").val(0);
    $("#idEfectivoValue").val(0);
    $("#idCambioValue").val(0);


}

function cancelarApartado() {
    location.reload();
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
    if (e.keyCode == 13 && !e.shiftKey) {

        var total = $("#idTotalValue").val();
        var apartado = $("#idApartadoInicial").val();
        total = Math.floor(total * 100) / 100;
        apartado = Math.floor(apartado * 100) / 100;

        if (total > apartado) {
            var faltaPagar = total - apartado;
            faltaPagar = Math.floor(faltaPagar * 100) / 100;
            $("#idEfectivo").val("");
            $("#idCambio").val("");

            $("#idApartadoInicialValue").val(apartado);
            $("#faltaPagarValue").val(faltaPagar);

            var apartadoFormat = formatoMoneda(apartado);
            var faltaPagarFormat = formatoMoneda(faltaPagar);

            $("#idApartadoInicial").val(apartadoFormat);
            $("#idfaltaPagar").val(faltaPagarFormat);
            $("#idApartadoInicial").prop('disabled', true);
            $("#idEfectivo").prop('disabled', false);

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
    if (e.keyCode == 13 && !e.shiftKey) {

        var totalValue = $("#idApartadoInicialValue").val();
        var efectivo = $("#idEfectivo").val();

        totalValue = Math.floor(totalValue * 100) / 100;
        efectivo = Math.floor(efectivo * 100) / 100;

        if (efectivo < totalValue) {
            alert("El efectivo no puede ser menor que el apartado inicial.")
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
            $("#btnVenta").prop('disabled', false);
        }
    }
    return patron.test(te);
}

function validaApartado() {
    var faltaPagar = $("#faltaPagarValue").val();
    var efectivo = $("#idEfectivo").val();
    var efectivoValue = $("#idEfectivoValue").val();
    if (efectivo == "" || idEfectivo == null) {
        alertify.warning("Favor de llenar el campo de efectivo.");
    } else {
        if (efectivoValue == 0) {
            alertify.warning("Favor de calcular el cambio.");
        } else {
            faltaPagar = Math.floor(faltaPagar * 100) / 100;
            if (faltaPagar == 0) {
                alertify.warning("Favor de calcular el apartado.");
            } else {
                guardarApartado();
            }
        }
    }

}

function guardarApartado() {
    var efectivo = $("#idEfectivoValue").val();
    var subtotal = $("#idSubTotalValue").val();
    var iva = $("#idIvaValue").val();
    var apartado = $("#idApartadoInicialValue").val();
    var total = $("#idTotalValue").val();
    var cambio = $("#idCambioValue").val();
    var cliente = $("#idClienteSeleccion").val();
    var vendedor = $("#idVendedor").val();
    var idBazar = $("#idBazar").val();
    var vencimiento = $("#idFechaVen").text();
    var dataEnviar = {
        "tipo_movimiento": tipo_movimientoGlb,
        "subTotal": subtotal,
        "iva": iva,
        "apartado": apartado,
        "total": total,
        "efectivo": efectivo,
        "cambio": cambio,
        "cliente": cliente,
        "vendedor": vendedor,
        "idBazar": idBazar,
        "vencimiento": vencimiento,
    };

    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Ventas/GuardarApartado.php',
        type: 'post',
        success: function (response) {
            if (response == 1) {
                idBazarGlb = idBazar;
                ArticulosUpdateVenta()
            } else {
                alertify.error("Error en al conectar con el servidor.");
            }
        },
    })

}

function ArticulosUpdateVenta() {
    var dataEnviar = {
        "idBazar": idBazarGlb,
        "tipo_movimiento": tipo_movimientoGlb,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Ventas/UpdateArticulos.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                alertify.success("Artículos actualizados correctamente.")
                fnBitacoraVenta();
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
        }
    });
}

function fnBitacoraVenta() {
    var dataEnviar = {
        "id_Movimiento": tipo_movimientoGlb,
        "id_bazar": idBazarGlb,
        "id_cliente": id_ClienteGlb,
        "id_vendedor": id_VendedorGlb,
        "idToken": idTokenGLb,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Bitacora/ConBitacoraVentas.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                verPDFApartado(idBazarGlb);
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
        }
    });
}

//Generar PDF
function verPDFApartado(idBazar) {
    window.open('../PDF/callPdfApartados.php?pdf=1&idBazar=' + idBazar);
    alert("Apartado realizado.");
   fnRecargarApartado();
}
function fnRecargarApartado() {
    location.reload();
}
function configurarRango() {
    alert("configuración")
}