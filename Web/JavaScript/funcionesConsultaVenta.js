var radioSelectGlb = 0;
var VentaReimprimirGlb = 0;

function fnEnterBusquedaVenta(e) {
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
        BusquedaConsulta();
    }
    return patron.test(te);
}

function fnRadioVenta() {
    fnLimpiarConsultaV();
    $('#idVentaRadio').prop('checked', true);
    $("#idVentaConsulta").prop('disabled', false);
    $("#btnBuscarConsulta").prop('disabled', false);
    $("#idNombreConsulta").prop('disabled', true);
    $("#idFechaInicial").prop('disabled', true);
    $("#idFechaFinal").prop('disabled', true);
    radioSelectGlb = 1;
}

function fnRadioNombre() {
    fnLimpiarConsultaV();
    $('#idNombreRadio').prop('checked', true);
    $("#idNombreConsulta").prop('disabled', false);
    $("#btnBuscarConsulta").prop('disabled', false);
    $("#idVentaConsulta").prop('disabled', true);
    $("#idFechaInicial").prop('disabled', true);
    $("#idFechaFinal").prop('disabled', true);
    radioSelectGlb = 2;
}

function fnRadioFecha() {
    fnLimpiarConsultaV();
    $('#idFechaRadio').prop('checked', true);
    $("#idNombreConsulta").prop('disabled', true);
    $("#btnBuscarConsulta").prop('disabled', false);
    $("#idVentaConsulta").prop('disabled', true);
    radioSelectGlb = 3;
}

function fnClienteAutoCompleteVen() {
    $('#idNombreConsulta').on('keyup', function () {
        var key = $('#idNombreConsulta').val();
        var dataEnviar = {
            "idNombres": key
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Cliente/AutocompleteCliente.php',
            data: dataEnviar,
            success: function (data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestionsNombreEmpeno').fadeIn(1000).html(data);
                //Al hacer click en alguna de las sugerencias
                $('.suggest-element').on('click', function () {
                    //Obtenemos la id unica de la sugerencia pulsada
                    var id = $(this).attr('id');
                    //var celular = $('#' + id).attr('celular');
                    var direccionComp = $('#' + id).attr('direccionCompleta');
                    //var estado = $('#' + id).attr('estadoDesc');
                    //Editamos el valor del input con data de la sugerencia pulsada
                    $('#idClienteConsulta').val(id);
                    $('#idNombreConsulta').val($('#' + id).attr('data'));
                    //$("#idCelularEmpeno").val(celular);
                    $("#idDireccionConsulta").val(direccionComp);
                    //Hacemos desaparecer el resto de sugerencias
                    $('#suggestionsNombreEmpeno').fadeOut(1000);
                    BusquedaConsulta();
                    return false;

                });
            }
        });
    });
}


function fnBusquedaVenta() {
    if (radioSelectGlb == 1) {
        //Por contrato
        fnBusquedaDatosCliente();
    } else if (radioSelectGlb == 2) {
        //Por Nombre
        fnCargarTblNombre();
    } else if (radioSelectGlb == 3) {
        //Por fechas

        fnCargarTblFechas();
    }
}

function fnBusquedaDatosCliente() {
    var idVentaBusqueda = $("#idVentaConsulta").val();
    var dataEnviar = {
        "idVentaBusqueda": idVentaBusqueda,

    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Consulta/busquedaDatos.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            if (datos.length > 0) {
                var i = 0;
                for (i; i < datos.length; i++) {
                    var Cliente = datos[i].Cliente;
                    var NombreCompleto = datos[i].NombreCompleto;
                    var direccionCompleta = datos[i].direccionCompleta;
                    $('#idClienteConsulta').val(Cliente);
                    $('#idNombreConsulta').val(NombreCompleto);
                    $("#idDireccionConsulta").val(direccionCompleta);
                    $("#idVentaBusqueda").val(idVentaBusqueda);
                }
                fnCargarTblVenta(idVentaBusqueda);

            } else {
                alertify.error("El contrato no existe.");
            }

        }
    });
}

function fnCargarTblVenta(idVentaBusqueda) {
    var dataEnviar = {
        "idVentaBusqueda": idVentaBusqueda,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Consulta/ConTblVenta.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var html = '';
            var i = 0;
            alert("Refrescando tabla.");
            for (i; i < datos.length; i++) {
                var id_Bazar = datos[i].id_Bazar;
                var FechaCreacion = datos[i].FechaCreacion;
                var subTotal = datos[i].subTotal;
                var iva = datos[i].ivaVenta;
                var descuento_Venta = datos[i].descuento_Venta;
                var total = datos[i].totalVenta;
                var tipo_movimiento = datos[i].tipo_movimientoVenta;

                subTotal = formatoMoneda(subTotal);
                iva = formatoMoneda(iva);
                descuento_Venta = formatoMoneda(descuento_Venta);
                total = formatoMoneda(total);

                VentaReimprimirGlb = id_Bazar;

                html += '<tr>' +
                    '<td >' + id_Bazar + '</td>' +
                    '<td>' + FechaCreacion + '</td>' +
                    '<td>' + subTotal + '</td>' +
                    '<td>' + iva + '</td>' +
                    '<td>' + descuento_Venta + '</td>' +
                    '<td>' + total + '</td>' +
                    '<td align="center">' +
                    '<img src="../../style/Img/seleccionarNor.png"  alt="Seleccionar"  onclick="fnCargarTblDetalleVenta(' + id_Bazar + ')">' +
                    '</td>' +
                    '<td align="center">' +
                    '<img src="../../style/Img/impresoraNor.png"  alt="Imprimir" onclick="fnReimprimirVentas(' + id_Bazar + ',' + tipo_movimiento + ')">' +
                    '</td></tr>';
            }
            $('#idTBodyVenta').html(html);

            /* var contrato = idVentaBusqueda;
             var clienteEmpeno = 0;
             var BitfechaIni = null;
             var BitfechaFin = null;
            // BitacoraUsuarioConsulta(id_Bazar, clienteEmpeno, BitfechaIni, BitfechaFin);*/
            fnCargarTblDetalleVenta(id_Bazar)
        }
    });


}

function fnCargarTblDetalleVenta(idVentaBusqueda) {
    var dataEnviar = {
        "idVentaBusqueda": idVentaBusqueda,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Consulta/ConDetalleVenta.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            alert("Refrescando tabla detalle de contrato.");
            var html = '';
            var i = 0;
            for (i; i < datos.length; i++) {
                var id_serie = datos[i].id_serie;
                var descripcionCorta = datos[i].descripcionCorta;
                var vitrina = datos[i].vitrina;
                var vitrinaVenta = datos[i].vitrinaVenta;
                vitrina = formatoMoneda(vitrina);
                vitrinaVenta = formatoMoneda(vitrinaVenta);

                html += '<tr align="center">' +
                    '<td>' + id_serie + '</td>' +
                    '<td>' + descripcionCorta + '</td>' +
                    '<td>' + vitrina + '</td>' +
                    '<td>' + vitrinaVenta + '</td>' +
                    '<td align="center">' +
                    '<img src="../../style/Img/fotos_Nor.png"   alt="Ver Fotos" onclick="verFotosContrato(' + id_serie + ')">' +
                    '</td>' +
                    '</tr>';

            }
            $('#idTBodyVentaDet').html(html);
        }
    });

}

function fnCargarTblNombre() {
    var idClienteConsulta = $("#idClienteConsulta").val();
    var dataEnviar = {
        "idClienteConsulta": idClienteConsulta,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Consulta/ConTblNombres.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var html = '';
            var i = 0;
            alert("Refrescando tabla.");
            for (i; i < datos.length; i++) {
                var id_Bazar = datos[i].id_Bazar;
                var FechaCreacion = datos[i].FechaCreacion;
                var subTotal = datos[i].subTotal;
                var iva = datos[i].ivaVenta;
                var descuento_Venta = datos[i].descuento_Venta;
                var total = datos[i].totalVenta;
                var tipo_movimiento = datos[i].tipo_movimientoVenta;

                subTotal = formatoMoneda(subTotal);
                iva = formatoMoneda(iva);
                descuento_Venta = formatoMoneda(descuento_Venta);
                total = formatoMoneda(total);

                VentaReimprimirGlb = id_Bazar;

                html += '<tr>' +
                    '<td >' + id_Bazar + '</td>' +
                    '<td>' + FechaCreacion + '</td>' +
                    '<td>' + subTotal + '</td>' +
                    '<td>' + iva + '</td>' +
                    '<td>' + descuento_Venta + '</td>' +
                    '<td>' + total + '</td>' +
                    '<td align="center">' +
                    '<img src="../../style/Img/seleccionarNor.png"  alt="Seleccionar"  onclick="fnCargarTblDetalleVenta(' + id_Bazar + ')">' +
                    '</td>' +
                    '<td align="center">' +
                    '<img src="../../style/Img/impresoraNor.png"  alt="Imprimir" onclick="fnReimprimirVentas(' + id_Bazar + ',' + tipo_movimiento + ')">' +
                    '</td></tr>';
            }
            $('#idTBodyVenta').html(html);

            /* var contrato = idVentaBusqueda;
             var clienteEmpeno = 0;
             var BitfechaIni = null;
             var BitfechaFin = null;
            // BitacoraUsuarioConsulta(id_Bazar, clienteEmpeno, BitfechaIni, BitfechaFin);*/
        }
    });

}

function fnCargarTblFechas() {
    var fechaInicio = $("#idFechaInicial").val();
    var fechaFinal = $("#idFechaFinal").val();
    if (fechaInicio == "") {
        alert("Por favor. Ingresa la fecha inicial.");
    } else if (fechaFinal == "") {
        alert("Por favor. Ingresa la fecha final.");

    } else {
        var nuevaFechaInicio = fechaSQL(fechaInicio);
        var nuevaFechaFinal = fechaSQL(fechaFinal);
        var dataEnviar = {
            "fechaInicio": nuevaFechaInicio,
            "fechaFinal": nuevaFechaFinal,
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Consulta/ConTblFechas.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var html = '';
                var i = 0;
                alert("Refrescando tabla.");
                for (i; i < datos.length; i++) {
                    var id_Bazar = datos[i].id_Bazar;
                    var FechaCreacion = datos[i].FechaCreacion;
                    var subTotal = datos[i].subTotal;
                    var iva = datos[i].ivaVenta;
                    var descuento_Venta = datos[i].descuento_Venta;
                    var total = datos[i].totalVenta;
                    var tipo_movimiento = datos[i].tipo_movimientoVenta;

                    subTotal = formatoMoneda(subTotal);
                    iva = formatoMoneda(iva);
                    descuento_Venta = formatoMoneda(descuento_Venta);
                    total = formatoMoneda(total);

                    VentaReimprimirGlb = id_Bazar;

                    html += '<tr>' +
                        '<td >' + id_Bazar + '</td>' +
                        '<td>' + FechaCreacion + '</td>' +
                        '<td>' + subTotal + '</td>' +
                        '<td>' + iva + '</td>' +
                        '<td>' + descuento_Venta + '</td>' +
                        '<td>' + total + '</td>' +
                        '<td align="center">' +
                        '<img src="../../style/Img/seleccionarNor.png"  alt="Seleccionar"  onclick="fnCargarTblDetalleVenta(' + id_Bazar + ')">' +
                        '</td>' +
                        '<td align="center">' +
                        '<img src="../../style/Img/impresoraNor.png"  alt="Imprimir" onclick="fnReimprimirVentas(' + id_Bazar + ',' + tipo_movimiento + ')">' +
                        '</td></tr>';
                }
                $('#idTBodyVenta').html(html);

                /* var contrato = idVentaBusqueda;
                 var clienteEmpeno = 0;
                 var BitfechaIni = null;
                 var BitfechaFin = null;
                // BitacoraUsuarioConsulta(id_Bazar, clienteEmpeno, BitfechaIni, BitfechaFin);*/
            }
        });
    }
}

function buscarDatosPorFecha(idVentaBusqueda) {
    var dataEnviar = {
        "idVentaBusqueda": idVentaBusqueda,

    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Consulta/busquedaDatos.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            if (datos.length > 0) {
                var i = 0;
                for (i; i < datos.length; i++) {
                    var Cliente = datos[i].Cliente;
                    var NombreCompleto = datos[i].NombreCompleto;
                    var direccionCompleta = datos[i].direccionCompleta;
                    $('#idClienteConsulta').val(Cliente);
                    $('#idNombreConsulta').val(NombreCompleto);
                    $("#idDireccionConsulta").val(direccionCompleta);
                    $("#idVentaBusqueda").val(idVentaBusqueda);
                }
                fnCargarTblDetalleVenta(idVentaBusqueda);
            } else {
                alertify.error("El contrato no existe.");
            }

        }
    });
}

function fnLimpiarConsultaV() {
    $("#idFormConsulta")[0].reset();
    $("#idVentaConsulta").prop('disabled', true);
    $("#idNombreConsulta").prop('disabled', true);
    $("#idFechaInicial").prop('disabled', true);
    $("#idFechaFinal").prop('disabled', true);
    $('#idAutoCheck').prop('checked', false);
    LimpiarTablas();
}
function LimpiarTablas() {
    var htmlVenta = '<tr>' +
        '<td colspan="8"></td></tr>';
    $('#idTBodyVenta').html(htmlVenta);
    var htmlVentaDetalle = '<tr>' +
        '<td colspan="5"></td></tr>';
    $('#idTBodyVentaDet').html(htmlVentaDetalle);
}

function fnReimprimirVentas(idBazar, idMovimiento) {
    VentaReimprimirGlb = Contrato;
    if (tipoMovimiento == 3) {
        //3 = Empeño
        window.open('../PDF/callPdfContrato.php?contrato=' + VentaReimprimirGlb + '&reimpresion=1');
    } else if (tipoMovimiento == 4) {
        //4 = Refrendo
        window.open('../PDF/callPdfRefrendo.php?contrato=' + VentaReimprimirGlb + '&ultimoMovimiento=' + idMovimiento + '&reimpresion=1');
    } else if (tipoMovimiento == 5) {
        //5 = Desempeño
        window.open('../PDF/callPdfDesempeno.php?contrato=' + VentaReimprimirGlb + '&ultimoMovimiento=' + idMovimiento + '&reimpresion=1');
    } else if (tipoMovimiento == 6) {
        //6 = Vent8a
    } else if (tipoMovimiento == 7) {
        //7 = Empeño Auto
        window.open('../PDF/callPdfContrato.php?contrato=' + VentaReimprimirGlb + '&reimpresion=1');
    } else if (tipoMovimiento == 8) {
        //8 = Refrendo Auto
        window.open('../PDF/callPdfRefrendo.php?contrato=' + VentaReimprimirGlb + '&ultimoMovimiento=' + idMovimiento + '&reimpresion=1');
    } else if (tipoMovimiento == 9) {
        //9 = Desempeño Auto
        window.open('../PDF/callPdfDesempeno.php?contrato=' + VentaReimprimirGlb + '&ultimoMovimiento=' + idMovimiento + '&reimpresion=1');
    } else if (tipoMovimiento == 10) {
        //10 = Venta Auto
    } else if (tipoMovimiento == 21) {
        //21 = Desempeño sin interes
        window.open('../PDF/callPdfDesempenoSinInteres.php?contrato=' + VentaReimprimirGlb + '&ultimoMovimiento=' + idMovimiento + '&reimpresion=1');
    } else if (tipoMovimiento == 20) {
        //20 = Cancelado
    }
}

function BitacoraUsuarioConsulta(contrato, clienteEmpeno, BitFechaIni, BitFechaFin) {
    var movimiento = 0;
    var id_contrato = contrato;
    var id_almoneda = 0;
    var id_cliente = clienteEmpeno;
    var consulta_fechaInicio = BitFechaIni;
    var consulta_fechaFinal = BitFechaFin;

    if (radioSelectGlb == 1) {
        movimiento = 11;
    } else if (radioSelectGlb == 2) {
        movimiento = 12;
    } else if (radioSelectGlb == 3) {
        movimiento = 13;
    }

    var id_Movimiento = movimiento;
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
                alertify.success("Consulta generada.");
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
        }
    });
}

function verFotosContrato(id_serie) {
    location.href = '../ImagenContrato/vImagenesContrato.php?idContrato=' + idContrato + '&articulo=' + id_serie;
}
