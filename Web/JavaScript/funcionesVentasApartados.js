var errorToken = 0;
var id_ContratoGlb = 0;
var id_serieGlb = 0;
var id_ClienteGlb = 0;
var tipo_movimientoGlb = 22;
var sucursalGlb = 0;
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
            if (datos.length > 0) {
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
                    var fecha_Modificacion = datos[i].fecha_Modificacion;
                    var id_Articulo = datos[i].id_Articulo;
                    var precio_venta = datos[i].precio_venta;
                    var precioCat = datos[i].precioCat;


                    id_ContratoGlb = id_Contrato
                    id_serieGlb = id_serie;
                    tipo_movimientoGlb = 22;
                    sucursalGlb = sucursal;
                    idSubTotalValue

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
                    $("#precioVenta").val(precio_venta);
                    if (tipo_movimiento == 6) {
                        alert("El articulo fue vendido el día: " + fecha_Modificacion)
                    }

                    tipoTabla = tipo;
alert(tipoTabla)
                    if (tipo == 1) {
                        html += '<tr>' +
                            '<td>' + id_serie + '</td>' +
                            '<td>' + detalle + '</td>' +
                            '<td>' + kilataje + '</td>' +
                            '<td>' + avaluo + '</td>' +
                            '<td>' + precio_venta + '</td>' +
                            '<td>' + ubicacion + '</td>' +
                            '</tr>';
                    } else if (tipo == 2) {
                        html += '<tr>' +
                            '<td>' + id_serie + '</td>' +
                            '<td>' + modelo + '</td>' +
                            '<td>' + marca + '</td>' +
                            '<td>' + avaluo + '</td>' +
                            '<td>' + precio_venta + '</td>' +
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
            } else {
                alertify.error("No se encontro ningún artiículo en bazar.");
            }

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
    if(id_ClienteGlb==0){
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
                var efectivo = $("#idEfectivoValue").val();
                if(efectivo==0){
                    alert("Debe calcular el cambio del cliente.");
                }else{
                    var iva = $("#idIvaValue").val();
                    var totalValue = $("#idTotalValue").val();
                    var fechaVencimiento = $("#idFechaVencimiento").val();
                    var cambio = $("#idCambioValue").val();
                    var precioVenta = $("#precioVenta").val();
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
                        "sucursalGlb": sucursalGlb,
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
                                idBazarGlb=response;
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
            cancelarSinInteres();
        }
    });
}

//Generar PDF
function cargarPDFApartado(idBazar) {
    window.open('../PDF/callPdfApartados.php?idBazar=' + idBazar);
}

function verPDFApartado(idBazar) {
    window.open('../PDF/callPdfApartados.php?pdf=1&idBazar=' + idBazar);
}

function configurarRango() {
    alert("configuración")
}

function test() {
    var fechaVencimiento = $("#idFechaVencimiento").text();
    alert(fechaVencimiento)
}
