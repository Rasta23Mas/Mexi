var radioSelectGlb = 0;
var VentaReimprimirGlb = 0;

function ventaBusquedaCon(e) {
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

function radioContrato() {
    LimpiarConsulta();
    $('#idVentaRadio').prop('checked', true);
    $("#idVentaConsulta").prop('disabled', false);
    $("#btnBuscarConsulta").prop('disabled', false);
    $("#idNombreConsulta").prop('disabled', true);
    $("#idFechaInicial").prop('disabled', true);
    $("#idFechaFinal").prop('disabled', true);
    radioSelectGlb = 1;
}

function radioNombre() {
    LimpiarConsulta();
    $('#idNombreRadio').prop('checked', true);
    $("#idNombreConsulta").prop('disabled', false);
    $("#btnBuscarConsulta").prop('disabled', false);
    $("#idVentaConsulta").prop('disabled', true);
    $("#idFechaInicial").prop('disabled', true);
    $("#idFechaFinal").prop('disabled', true);
    radioSelectGlb = 2;
}

function radioFecha() {
    LimpiarConsulta();
    $('#idFechaRadio').prop('checked', true);
    $("#idNombreConsulta").prop('disabled', true);
    $("#btnBuscarConsulta").prop('disabled', false);
    $("#idVentaConsulta").prop('disabled', true);
    radioSelectGlb = 3;
}

//Funcion autocompletar nombre de cliente
function nombreAutocompletarConsulta() {
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


function BusquedaConsulta() {
    if (radioSelectGlb == 1) {
        //Por contrato
        buscarDatosPorVenta();
    } else if (radioSelectGlb == 2) {
        //Por Nombre
        cargarTablaNombre();
    } else if (radioSelectGlb == 3) {
        //Por fechas

        cargarTablaFechas();
    }
}

function buscarDatosPorVenta() {
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
                    '<img src="../../style/Img/seleccionarNor.png"  alt="Seleccionar"  onclick="cargarTablaDetalleNombre(' + id_Bazar + ')">' +
                    '</td>' +
                    '<td align="center">' +
                    '<img src="../../style/Img/impresoraNor.png"  alt="Imprimir" onclick="reimprimirVentas(' + id_Bazar + ',' + tipo_movimiento + ')">' +
                    '</td></tr>';
            }
                $('#idTBodyVenta').html(html);

           /* var contrato = idVentaBusqueda;
            var clienteEmpeno = 0;
            var BitfechaIni = null;
            var BitfechaFin = null;
           // BitacoraUsuarioConsulta(id_Bazar, clienteEmpeno, BitfechaIni, BitfechaFin);*/
            cargarTablaDetalleNombre(id_Bazar)
        }
    });

        $("#divVenta").load('tblVenta.php');

}

function cargarTablaDetalleNombre(idVentaBusqueda) {
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
            var Num = 1;
            var llenatabla = 0;
            if (datos.length > 0) {
                for (i; i < datos.length; i++) {
                    llenatabla++

                        var serieArticulo = datos[i].id_SerieArticulo;
                        var DescripcionCorta = datos[i].DescripcionCorta;
                         Obs = datos[i].Obs;
                        html += '<tr align="center">' +
                            '<td>' + idVentaBusqueda + '</td>' +
                            '<td>' + serieArticulo + '</td>' +
                            '<td>' + DescripcionCorta + '</td>' +
                            '<td>' + Obs + '</td>' +
                            '<td align="center">' +
                            '<img src="../../style/Img/fotos_Nor.png"   alt="Ver Fotos" onclick="verFotosContrato(' + idVentaBusqueda + ',' + serieArticulo + ')">' +
                            '</td>' +
                            '</tr>';



                    Num++;
                }
                $('#idTBodyVentaDetalle').html(html);
            } else {
                alertify.error("El contrato no existe.");
            }
        }
    });
    $("#divDetallesVenta").load('idTBodyVentaDetalle.php');
}

function cargarTablaNombre() {
    var idClienteConsulta = $("#idClienteConsulta").val();
    var dataEnviar = {
        "idClienteConsulta": idClienteConsulta,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Consulta/tblDetalleNombre.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            alert("Refrescando tabla.");
            var html = '';
            var htmlAuto = '';
            var htmlfinal = '';
            var i = 0;
            var Num = 1;
            for (i; i < datos.length; i++) {
                var Contrato = datos[i].Contrato;
                var FechaCreacion = datos[i].FechaCreacion;
                var Movimiento = datos[i].Movimiento;
                var idMovimiento = datos[i].idMovimiento;
                var Prestamo = datos[i].Prestamo;
                var Abono = datos[i].Abono;
                var Interes = datos[i].Interes;
                var Moratorios = datos[i].Moratorios;
                var Descuento = datos[i].Descuento;
                var Pago = datos[i].Pago;
                var Plazo = datos[i].Plazo;
                var CostoContrato = datos[i].CostoContrato;
                var MovimientoTipo = datos[i].MovimientoTipo;
                var VentaReimprimirGlb = Contrato;
                var MovimientoReimprimir = idMovimiento;

                Prestamo = formatoMoneda(Prestamo);
                Abono = formatoMoneda(Abono);
                Interes = formatoMoneda(Interes);
                Moratorios = formatoMoneda(Moratorios);
                Descuento = formatoMoneda(Descuento);
                Pago = formatoMoneda(Pago);
                CostoContrato = formatoMoneda(CostoContrato);


                html = '<tr>' +
                    '<td >' + Contrato + '</td>' +
                    '<td>' + FechaCreacion + '</td>' +
                    '<td>' + Movimiento + '</td>' +
                    '<td>' + idMovimiento + '</td>' +
                    '<td>' + Prestamo + '</td>' +
                    '<td>' + Abono + '</td>' +
                    '<td>' + Pago + '</td>' +
                    '<td>' + Interes + '</td>' +
                    '<td>' + Moratorios + '</td>' +
                    '<td>' + CostoContrato + '</td>' +
                    '<td>' + Descuento + '</td>' +
                    '<td>' + Plazo + '</td>' +
                    '<td align="center">' +
                    '<img src="../../style/Img/seleccionarNor.png"   alt="Seleccionar"  onclick="cargarTablaDetalleNombre(' + Contrato + ')">' +
                    '</td>' +
                    '<td align="center">' +
                    '<img src="../../style/Img/impresoraNor.png"  alt="Imprimir" onclick="reimprimirVentas(' + MovimientoTipo + ',' + idMovimiento + ',' + Contrato + ')">' +
                    '</td>';

                htmlfinal += html + htmlAuto + '</tr>';
                Num++;
            }

                $('#idTBodyVenta').html(htmlfinal);

            var contrato = 0;
            var clienteEmpeno = idClienteConsulta;
            var BitfechaIni = null;
            var BitfechaFin = null;
            BitacoraUsuarioConsulta(contrato, clienteEmpeno, BitfechaIni, BitfechaFin);
        }
    });

        $("#divVenta").load('tblVenta.php');

}

function cargarTablaFechas() {
    var fechaInicio = $("#idFechaInicial").val();
    var fechaFinal = $("#idFechaFinal").val();
    if (fechaInicio == "") {
        alert("Por favor. Ingresa la fecha inicial.");
    } else if (fechaFinal == "") {
        alert("Por favor. Ingresa la fecha final.");

    } else {
        var nuevaFechaInicio = fechaSQL(fechaInicio);
        var nuevaFechaFinal = fechaSQL(fechaFinal);
        //nuevaFechaInicio = formatStringToDate(nuevaFechaInicio);
        //nuevaFechaFinal = formatStringToDate(nuevaFechaFinal);
        var dataEnviar = {
            "fechaInicio": nuevaFechaInicio,
            "fechaFinal": nuevaFechaFinal,
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Consulta/tblDetalleFechas.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var html = '';
                var htmlAuto = '';
                var htmlfinal = '';
                var i = 0;
                var Num = 1;
                alert("Refrescando tabla.");
                for (i; i < datos.length; i++) {
                    var Contrato = datos[i].Contrato;
                    var FechaCreacion = datos[i].FechaCreacion;
                    var Movimiento = datos[i].Movimiento;
                    var idMovimiento = datos[i].idMovimiento;
                    var Prestamo = datos[i].Prestamo;
                    var PrestamoActual = datos[i].PrestamoActual;
                    var Abono = datos[i].Abono;
                    var Interes = datos[i].Interes;
                    var Moratorios = datos[i].Moratorios;
                    var Descuento = datos[i].Descuento;
                    var Pago = datos[i].Pago;
                    var Plazo = datos[i].Plazo;
                    var CostoContrato = datos[i].CostoContrato;
                    var MovimientoTipo = datos[i].MovimientoTipo;

                    var VentaReimprimirGlb = Contrato;
                    var MovimientoReimprimir = idMovimiento;

                    Prestamo = formatoMoneda(Prestamo);
                    Abono = formatoMoneda(Abono);
                    Interes = formatoMoneda(Interes);
                    Moratorios = formatoMoneda(Moratorios);
                    Descuento = formatoMoneda(Descuento);
                    Pago = formatoMoneda(Pago);
                    CostoContrato = formatoMoneda(CostoContrato);


                    html = '<tr>' +
                        '<td >' + Contrato + '</td>' +
                        '<td>' + FechaCreacion + '</td>' +
                        '<td>' + Movimiento + '</td>' +
                        '<td>' + idMovimiento + '</td>' +
                        '<td>' + PrestamoActual + '</td>' +
                        '<td>' + Abono + '</td>' +
                        '<td>' + Pago + '</td>' +
                        '<td>' + Interes + '</td>' +
                        '<td>' + Moratorios + '</td>' +
                        '<td>' + CostoContrato + '</td>' +
                        '<td>' + Descuento + '</td>' +
                        '<td>' + Plazo + '</td>' +
                        '<td align="center">' +
                        '<img src="../../style/Img/seleccionarNor.png"  data-dismiss="modal" alt="Seleccionar"  onclick="buscarDatosPorFecha(' + Contrato + ')">' +
                        '</td>' +
                        '<td align="center">' +
                        '<img src="../../style/Img/impresoraNor.png"  data-dismiss="modal" alt="impromor" onclick="reimprimirVentas(' + MovimientoTipo + ',' + idMovimiento + ',' + Contrato + ')">' +
                        '</td>';


                    htmlfinal += html + htmlAuto + '</tr>';
                    Num++;
                }


                    $('#idTBodyVentaAuto').html(htmlfinal);
                var contrato = 0;
                var clienteEmpeno = 0;
                var BitfechaIni = nuevaFechaInicio;
                var BitfechaFin = nuevaFechaFinal;
                BitacoraUsuarioConsulta(contrato, clienteEmpeno, BitfechaIni, BitfechaFin);
            }
        });
            $("#divVenta").load('tblVenta.php');

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
                cargarTablaDetalleNombre(idVentaBusqueda);
            } else {
                alertify.error("El contrato no existe.");
            }

        }
    });
}

function LimpiarConsulta() {
    $("#idFormConsulta")[0].reset();
    $("#idVentaConsulta").prop('disabled', true);
    $("#idNombreConsulta").prop('disabled', true);
    $("#idFechaInicial").prop('disabled', true);
    $("#idFechaFinal").prop('disabled', true);
    $('#idAutoCheck').prop('checked', false);
    $("#divVenta").load('tblVenta.php');
    $("#divDetallesVenta").load('tblDetalleVenta.php');
}

function reimprimirVentas(tipoMovimiento, idMovimiento, Contrato) {
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

function verFotosContrato(idContrato, SerieArticulo) {
    location.href = '../ImagenContrato/vImagenesContrato.php?idContrato=' + idContrato + '&articulo=' + SerieArticulo;
}
