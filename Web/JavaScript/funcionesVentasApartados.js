var errorToken = 0;
var id_ContratoGlb = 0;
var id_serieGlb = "";
var id_ClienteGlb = 0;
var tipo_movimientoGlb = 22;


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

function busquedaCodigoApartados(e) {
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
        busquedaCodigoBazar();
    }
}

function busquedaCodigoBazar() {
    var codigo = $("#idCodigoApartado").val();
    var dataEnviar = {
        "codigo": codigo,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Ventas/busquedaCodigoApartados.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            if (datos.length > 0) {
                var html = '';
                var i = 0;
                for (i; i < datos.length; i++) {
                    var id_Bazar = datos[i].id_Bazar;
                    var id_Contrato = datos[i].id_ContratoApartado;
                    var id_serie = datos[i].id_serieApartado;
                    var descripcionCorta = datos[i].descripcionCorta;
                    var observaciones = datos[i].observaciones;
                    var empeno = datos[i].empeno;
                    var avaluo = datos[i].avaluo;
                    var precio_venta = datos[i].precio_venta;

                    var precioEnviar = precio_venta;
                    var empeno = formatoMoneda(empeno);
                    var avaluo = formatoMoneda(avaluo);
                    var precio_venta = formatoMoneda(precio_venta);

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

    var precioFinal = Math.floor(precio * 100) / 100;
    var calculaIva = Math.floor(precioFinal * 16) / 100;
    var totalPagar = precioFinal + calculaIva;
    totalPagar = Math.floor(totalPagar * 100) / 100;
    var precioFinalFormat = formatoMoneda(precioFinal);
    var calculaIvaFormat = formatoMoneda(calculaIva);
    var totalPagarFormat = formatoMoneda(totalPagar);

    id_ContratoGlb = id_Contrato;
    id_serieGlb = id_serie;
    idBazarGlb = id_Bazar;

    $("#idSubTotal").val(precioFinalFormat);
    $("#idIva").val(calculaIvaFormat);
    $("#idTotalPagar").val(totalPagarFormat);
    $("#idSubTotalValue").val(precioFinal);
    $("#idIvaValue").val(calculaIva);
    $("#idTotalValue").val(totalPagar);
    $("#idTotalBase").val(totalPagar);

}

function apartadoInicial(e) {
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

        var subtotalValue = $("#idTotalValue").val();
        var apartado = $("#idApartadoInicial").val();
        var totalPagar = 0;
        subtotalValue = Math.floor(subtotalValue * 100) / 100;
        apartado = Math.floor(apartado * 100) / 100;

        if (subtotalValue > apartado) {
            totalPagar = subtotalValue - apartado;
            totalPagar = Math.floor(totalPagar * 100) / 100;
            $("#idEfectivo").val("");
            $("#idCambio").val("");

            $("#idApartadoInicialValue").val(apartado);
            $("#idTotalValue").val(totalPagar);

            var apartadoFormat = formatoMoneda(apartado);
            var totalPagarFormat = formatoMoneda(totalPagar);

            $("#idApartadoInicial").val(apartadoFormat);
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
    if (tecla === 8) {
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
    $("#idSubTotalValue").val("");
    $("#idIvaValue").val("");
    $("#idTotalBase").val("");
    $("#idApartadoInicialValue").val("");
    $("#idTotalValue").val("");
    $("#idEfectivoValue").val("");
    $("#idCambioValue").val("");
    busquedaCodigoBazar();
    $("#idApartadoInicial").val("");
    $("#idEfectivo").val("");
    $("#idCambio").val("");
    $("#idEfectivo").prop('disabled', false);
    alertify.success("Se limpiaron descuento y pago.");
}

function guardarApartado() {
    /*
     22->Apartado
     */
    id_ClienteGlb = $("#idClienteVenta").val();
    if (id_ClienteGlb === 0) {
        alert("Debe seleccionar un cliente para el apartado.");
    } else {
        var vendedor = $("#idVendedor").val();
        if (vendedor === 0) {
            alert("Debe seleccionar un vendedor para el apartado.");
        } else {
            var apartado = $("#idApartadoInicialValue").val();
            if (apartado === 0) {
                alert("Debe calcular el apartado inicial.");
            } else {
                var efectivo = $("#idEfectivoValue").val();
                if (efectivo === 0) {
                    alert("Debe calcular el cambio del cliente.");
                } else {
                    var iva = $("#idIvaValue").val();
                    var totalValue = $("#idTotalValue").val();
                    var fechaVencimiento = $("#idFechaVencimiento").val();
                    var cambio = $("#idCambioValue").val();
                    var precioVenta = $("#idSubTotalValue").val();

                    var dataEnviar = {
                        "id_ContratoGlb": id_ContratoGlb,
                        "id_serieGlb": id_serieGlb,
                        "id_ClienteGlb": id_ClienteGlb,
                        "precio_ActualGlb": totalValue,
                        "apartadoGlb": apartado,
                        "fechaVencimiento": fechaVencimiento,
                        "ivaGlb": iva,
                        "tipo_movimientoGlb": tipo_movimientoGlb,
                        "vendedorGlb": vendedor,
                        "efectivo": efectivo,
                        "cambio": cambio,
                        "precioVenta": precioVenta,
                    };

                    $.ajax({
                        data: dataEnviar,
                        url: '../../../com.Mexicash/Controlador/Ventas/guardarApartado.php',
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
}

function BitacoraApartado() {
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
                cargarPDFApartado(idBazarGlb);
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
        }
    });
}

//Generar PDF
function cargarPDFApartado(idBazar) {
    window.open('../PDF/callPdfApartados.php?idBazar=' + idBazar);
    alert("Apartado realizado");
    $("#idFormApartados")[0].reset();
    $("#divTablaMetales").load('tablaMetales.php');
}

function configurarRango() {
    alert("configuración")
}

function test() {
    var fechaVencimiento = $("#idFechaVencimiento").text();
    alert(fechaVencimiento)
}
