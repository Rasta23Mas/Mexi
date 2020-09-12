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
        fnBusquedaVenta();
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
                    fnBusquedaVenta();
                    return false;

                });
            }
        });
    });
}

function fnBusquedaVenta() {
    if (radioSelectGlb == 1) {
        //Por contrato
        fnBusquedaDatosCliente(0);
    } else if (radioSelectGlb == 2) {
        //Por Nombre
        fnCargarTblNombre();
    } else if (radioSelectGlb == 3) {
        //Por fechas
        fnCargarTblFechas();
    }
}

function fnBusquedaDatosCliente(idVenta) {
    var idVentaBusqueda = "";
    if(idVenta==0){
        idVentaBusqueda = $("#idVentaConsulta").val();
    }else{
        idVentaBusqueda = idVenta;
    }
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
                if(radioSelectGlb!=3) {
                    fnCargarTblVenta(idVentaBusqueda);
                }
            } else {
                alertify.error("La venta no existe.");
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

             var venta = idVentaBusqueda;
             var clienteVenta = 0;
             var BitfechaIni = null;
             var BitfechaFin = null;
            fnBitacoraConsultaVenta(venta, clienteVenta, BitfechaIni, BitfechaFin);
            fnCargarTblDetalleVenta(idVentaBusqueda);
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

            var venta = 0;
            var clienteVenta = idClienteConsulta;
            var BitfechaIni = null;
            var BitfechaFin = null;
            fnBitacoraConsultaVenta(venta, clienteVenta, BitfechaIni, BitfechaFin);
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

                var venta = 0;
                var clienteVenta = 0;
                var BitfechaIni = nuevaFechaInicio;
                var BitfechaFin = nuevaFechaFinal;
                fnBitacoraConsultaVenta(venta, clienteVenta, BitfechaIni, BitfechaFin);
            }
        });
    }
}

function fnCargarTblDetalleVenta(idVentaBusqueda) {
    if(radioSelectGlb==3){
        fnBusquedaDatosCliente(idVentaBusqueda);
    }
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
                    '<img src="../../style/Img/fotos_Nor.png"   alt="Ver Fotos" onclick="verFotosContrato(\'' + id_serie + '\')">' +
                    '</td>' +
                    '</tr>';

            }
            $('#idTBodyVentaDet').html(html);
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

function fnBitacoraConsultaVenta(venta, clienteVenta, BitfechaIni, BitfechaFin) {
    var movimiento = 0;
    var venta = venta;
    var cliente = clienteVenta;
    var consulta_fechaInicio = BitfechaIni;
    var consulta_fechaFinal = BitfechaFin;

    if (radioSelectGlb == 1) {
        movimiento = 25;
    } else if (radioSelectGlb == 2) {
        movimiento = 26;
    } else if (radioSelectGlb == 3) {
        movimiento = 27;
    }

    var id_Movimiento = movimiento;

    var dataEnviar = {
        "id_Movimiento": id_Movimiento,
        "idContrato": 0,
        "venta": venta,
        "cliente": cliente,
        "consulta_fechaInicio": consulta_fechaInicio,
        "consulta_fechaFinal": consulta_fechaFinal,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Bitacora/ConBitacoraConsulta.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                alertify.success("Consulta generada.");
            } else {
                alertify.error("Error en al conectar con el servidors.")
            }
        }
    });
}

function fnReimprimirVentas(idBazar, idMovimiento) {
    if (idMovimiento == 6) {
        //6 = Venta
        window.open('../PDF/callPdfVenta.php?reimpresion=1&idBazar=' + idBazar);
    } else if (idMovimiento == 22) {
        //4 = Abono
        window.open('../PDF/callPdfAbono.php?reimpresion=1&idBazar=' + idBazar);
    } else if (idMovimiento == 23) {
        //6 = Apartado
        window.open('../PDF/callPdfApartados.php?reimpresion=1&idBazar=' + idBazar);
    }
}

function verFotosContrato(id_serie) {
    location.href = '../ImagenContrato/vImagenesContrato.php?tipo=2&articulo=' + id_serie;
}