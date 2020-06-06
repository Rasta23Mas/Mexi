var errorToken = 0;

var id_ClienteGlb = 0;
//ABONO 23
var id_ContratoGlb = 0;
var id_serieGlb = 0;
var tipo_movimientoGlb = 23;
var sucursalGlb = 0;
var idBazarGlb = 0;


function nombreAutocompletarAbono() {
    $('#idNombreVenta').on('keyup', function () {
        var key = $('#idNombreVenta').val();
        var dataString = 'idNombres=' + key;
        var dataEnviar = {
            "idNombres": key
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Cliente/AutocompleteClienteAbono.php',
            data: dataEnviar,
            success: function (data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestionsNombreVenta').fadeIn(1000).html(data);
                //Al hacer click en alguna de las sugerencias
                $('.suggest-element').on('click', function () {
                    //Obtenemos la id unica de la sugerencia pulsada
                    var id = $(this).attr('id');
                    id_ClienteGlb = id;
                    $('#idNombreVenta').val($('#' + id).attr('data'));
                    //Hacemos desaparecer el resto de sugerencias
                    $('#suggestionsNombreVenta').fadeOut(1000);
                    $("#idNombreVenta").prop('disabled', true);
                    busquedaClienteBazar()
                    return false;
                });
            }
        });
    });
}

function busquedaClienteBazar() {
    var dataEnviar = {
        "id_ClienteGlb": id_ClienteGlb,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Ventas/busquedaClienteAbono.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            if (datos.length > 0) {
                var html = '';
                var i = 0;
                for (i; i < datos.length; i++) {
                    var id_Contrato = datos[i].id_Contrato;
                    var tipoArticulo = datos[i].tipoArticulo;
                    var ElectronicoArt = datos[i].ElectronicoArt;
                    var ElectronicoMetal = datos[i].ElectronicoMetal;
                    var articulo = "";
                    if (tipoArticulo == 1) {
                        articulo = ElectronicoMetal;
                    } else if (tipoArticulo == 2) {
                        articulo = ElectronicoArt;
                    }
                    html += '<tr>' +
                        '<td>' + id_Contrato + '</td>' +
                        '<td>' + articulo + '</td>' +
                        '<td align="center">' +
                        '<img src="../../style/Img/seleccionarNor.png"  ' +
                        'alt="Seleccionar"  ' +
                        'onclick="busquedaAbonos(' + id_Contrato + ')">' +
                        '</td>' +
                        '</tr>';
                }
                $('#idTBodyApartado').html(html);
                $("#btnAbono").prop('disabled', false);
            } else {
                alertify.error("No se encontro articulo apartado.");
            }
        }
    });
}

function busquedaAbonos(id_Contrato) {
    id_ContratoGlb = id_Contrato;
    var dataEnviar = {
        "id_Contrato": id_Contrato,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Ventas/busquedaAbonos.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var apartadoTotal = 0;
            var abonoTotal = 0;
            var ultimoSaldo = 0;
            var tablaAbono = 0;
            var fechaAbono = "";
            var prestamoVenta = "";
            if (datos.length > 0) {
                var html = '';
                var i = 0;
                for (i; i < datos.length; i++) {
                    var fecha_Modificacion = datos[i].fecha_Modificacion;
                    var abono = datos[i].abono;
                    var precio_Actual = datos[i].precio_Actual;
                    var apartado = datos[i].apartado;
                    var tipo_movimiento = datos[i].tipo_movimiento;
                    abono = Math.floor(abono * 100) / 100;


                    id_serieGlb = datos[i].id_serie;
                    sucursalGlb = datos[i].sucursal;


                    if (tipo_movimiento == 22) {
                        apartadoTotal = apartado;
                        prestamoVenta = datos[i].precio_venta;

                    } else if (tipo_movimiento == 23) {
                        abonoTotal += abono;
                        fechaAbono = fecha_Modificacion;
                        tablaAbono++;

                        var abonoTabla = formatoMoneda(abono);
                        var precioTabla = formatoMoneda(precio_Actual);
                        html += '<tr>' +
                            '<td>' + fecha_Modificacion + '</td>' +
                            '<td align="right">' + abonoTabla + '</td>' +
                            '<td align="right">' + precioTabla + '</td>' +
                            '</tr>';
                    }
                    ultimoSaldo = precio_Actual;

                }

                if (tablaAbono == 0) {
                    html += '<tr>' +
                        '<td colspan="3" align="center"> <label>Sin abonos para mostrar.</label></td>' +
                        '</tr>';
                }

                apartadoTotal = Math.floor(apartadoTotal * 100) / 100;
                abonoTotal = Math.floor(abonoTotal * 100) / 100;

                $("#idTotalApartadoValue").val(apartadoTotal);
                $("#idTotalAbonadoValue").val(abonoTotal);
                $("#idUltimoSaldoValue").val(ultimoSaldo);
                $("#idPrestamoVenta").val(prestamoVenta);
                var apartadoFormat = formatoMoneda(apartadoTotal);
                var abonoFormat = formatoMoneda(abonoTotal);
                var ultimoSaldoFormat = formatoMoneda(ultimoSaldo);
                $("#idTotalApartado").val(apartadoFormat);
                $("#idTotalAbonado").val(abonoFormat);
                $("#idUltimoSaldo").val(ultimoSaldoFormat);
                fechaAbono = fechaFormato(fechaAbono)
                $("#fechaAbono").val(fechaAbono);
                $("#idImporteAbono").prop('disabled', false);

                $('#idTBodyAbono').html(html);
            } else {
                alertify.warning("No se encontro ningún abono para el artículo");
            }

        }
    });
}

function nuevoAbono(e) {
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

        var ultimoSaldo = $("#idUltimoSaldoValue").val();
        var abono = $("#idImporteAbono").val();

        ultimoSaldo = Math.floor(ultimoSaldo * 100) / 100;
        abono = Math.floor(abono * 100) / 100;

        if (ultimoSaldo > abono) {
            var nuevoSaldo = ultimoSaldo - abono;
            nuevoSaldo = Math.floor(nuevoSaldo * 100) / 100;
            $("#idEfectivo").val("");
            $("#idCambio").val("");

            $("#idImporteAbonoValue").val(abono);
            $("#idNuevoSaldoValue").val(nuevoSaldo);

            var abonoFormat = formatoMoneda(abono);
            var nuevoSaldoFormat = formatoMoneda(nuevoSaldo);

            $("#idImporteAbono").val(abonoFormat);
            $("#idNuevoSaldo").val(nuevoSaldoFormat);
            $("#idTotalPagar").val(abonoFormat);
            $("#idImporteAbono").prop('disabled', true);
            $("#idEfectivo").prop('disabled', false);


        } else {
            alert("El apartado tiene que ser menor al total.")
        }

    }
    return patron.test(te);
}

function efectivoAbono(e) {
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

        var abono = $("#idImporteAbonoValue").val();
        var efectivo = $("#idEfectivo").val();

        abono = Math.floor(abono * 100) / 100;
        efectivo = Math.floor(efectivo * 100) / 100;

        if (efectivo < abono) {
            alert("El efectivo no puede ser menor que el abono a pagar.")
        } else {
            $("#idEfectivo").val("");
            $("#idCambio").val("");
            $("#idEfectivoValue").val("");
            $("#idCambioValue").val("");
            var cambio = efectivo - abono;
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

function cancelarVentaAbono() {
    $("#idNuevoSaldoValue").val("");
    $("#idImporteAbonoValue").val("");
    $("#idEfectivoValue").val("");
    $("#idCambioValue").val("");
    $("#idImporteAbono").val("");
    $("#idNuevoSaldo").val("");
    $("#idTotalPagar").val("");
    $("#idEfectivo").val("");
    $("#idCambio").val("");
    $("#idNombreVenta").val("");
    $("#idNombreVenta").prop('disabled', false);
    $("#idImporteAbono").prop('disabled', false);
    alertify.success("Se ha limpiado el abono y pago de efectivo.");
}

function guardarAbono() {
    /*
     23->Apartado
     */

    var abono = $("#idImporteAbonoValue").val();
    if (abono == 0) {
        alert("Debe calcular el abono.");
    } else {
        var efectivo = $("#idEfectivoValue").val();
        if (efectivo == 0) {
            alert("Debe calcular el cambio del cliente.");
        } else {

            var nuevoSaldo = $("#idNuevoSaldoValue").val();
            var abonoAnterior = $("#idTotalAbonadoValue").val();
            var efectivo = $("#idEfectivoValue").val();
            var cambio = $("#idCambioValue").val();
            var prestamo = $("#idPrestamoVenta").val();

            abonoAnterior = Math.floor(abonoAnterior * 100) / 100;
            abono = Math.floor(abono * 100) / 100;
            var abonoTotal = abonoAnterior + abono;
            abonoTotal = Math.floor(abonoTotal * 100) / 100;
            var dataEnviar = {
                "id_Cliente": id_ClienteGlb,
                "id_Contrato": id_ContratoGlb,
                "id_serie": id_serieGlb,
                "tipo_movimiento": tipo_movimientoGlb,
                "precio_Actual": nuevoSaldo,
                "idPrestamo": prestamo,
                "abono": abono,
                "abono_Total": abonoTotal,
                "efectivo": efectivo,
                "cambio": cambio,
                "sucursal": sucursalGlb,
            };

            $.ajax({
                data: dataEnviar,
                url: '../../../com.Mexicash/Controlador/Ventas/guardarAbono.php',
                type: 'post',
                success: function (response) {
                    if (response > 0) {
                        idBazarGlb = response;
                        alertify.success("El artículo se ha abonado correctamente.")
                        BitacoraApartado()
                    } else {
                        alertify.error("Error al guardar el apartado");
                    }
                },
            })
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
                cargarPDFAbono(idBazarGlb);
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
        }
    });
}

//Generar PDF
function cargarPDFAbono(idBazar) {
    window.open('../PDF/callPdfAbono.php?idBazar=' + idBazar);
    alert("Abono realizado");
    $("#idFormAbonos")[0].reset();
    $("#divTablaAbono").load('tablaAbono.php');
    $("#divTablaApartado").load('tablaApartados.php');
    $("#idNombreVenta").prop('disabled', false);
}

function verPDFAbono(idBazar) {
    window.open('../PDF/callPdfAbono.php?pdf=1&idBazar=' + idBazar);
}

function configurarRango() {
    alert("configuración")
}
