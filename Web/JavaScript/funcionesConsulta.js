var radioSelect = 0;
var tipoContratoGlobal = 1;

var ContratoReimprimir = 0;
function radioContrato() {
    LimpiarConsulta();
    $('#idContratoRadio').prop('checked', true);
    $("#idContratoConsulta").prop('disabled', false);
    $("#btnBuscarConsulta").prop('disabled', false);
    $("#idNombreConsulta").prop('disabled', true);
    $("#idFechaInicial").prop('disabled', true);
    $("#idFechaFinal").prop('disabled', true);
    radioSelect = 1;
}

function radioNombre() {
    LimpiarConsulta();
    $('#idNombreRadio').prop('checked', true);
    $("#idNombreConsulta").prop('disabled', false);
    $("#btnBuscarConsulta").prop('disabled', false);
    $("#idContratoConsulta").prop('disabled', true);
    $("#idFechaInicial").prop('disabled', true);
    $("#idFechaFinal").prop('disabled', true);
    radioSelect = 2;
}

function radioFecha() {
    LimpiarConsulta();
    $('#idFechaRadio').prop('checked', true);
    $("#idNombreConsulta").prop('disabled', true);
    $("#btnBuscarConsulta").prop('disabled', false);
    $("#idContratoConsulta").prop('disabled', true);
    radioSelect = 3;
}

//Funcion autocompletar nombre de cliente
function nombreAutocompletarConsulta() {
    $('#idNombreConsulta').on('keyup', function () {
        var key = $('#idNombreConsulta').val();
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
                    return false;
                });
            }
        });
    });
}

function checkAuto() {
    $('#idAutoCheck').prop('checked', true);
    tipoContratoGlobal = 2;
}

function BusquedaConsulta() {
    if (radioSelect == 1) {
        //Por contrato
        buscarDatosPorContrato();
    } else if (radioSelect == 2) {
        //Por Nombre
        cargarTablaNombre();
    } else if (radioSelect == 3) {
        //Por fechas

        cargarTablaFechas();
    }
}

function buscarDatosPorContrato() {
    var idContratoBusqueda = $("#idContratoConsulta").val();
    var dataEnviar = {
        "idContratoBusqueda": idContratoBusqueda,
        "tipoContratoGlobal": tipoContratoGlobal

    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Contrato/busquedaDatos.php',
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
                    $("#idContratoBusqueda").val(idContratoBusqueda);
                }
                cargarTablaContrato(idContratoBusqueda);

            } else {
                alertify.error("El contrato no existe.");
            }

        }
    });
}

function buscarDatosPorNombres() {
    //var idClienteConsulta = $("#idClienteConsulta").val();
    var idClienteConsulta = 90;

    var dataEnviar = {
        "idClienteConsulta": idClienteConsulta
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Contrato/busquedaDatosPorCliente.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var i = 0;
            for (i; i < datos.length; i++) {
                var Cliente = datos[i].Cliente;
                var NombreCompleto = datos[i].NombreCompleto;
                var direccionCompleta = datos[i].direccionCompleta;
                $('#idClienteConsulta').val(Cliente);
                $('#idNombreConsulta').val(NombreCompleto);
                $("#idDireccionConsulta").val(direccionCompleta);
                $("#idContratoBusqueda").val(idContratoBusqueda);
            }
        }
    });

}

function cargarTablaDetalleContrato(idContratoBusqueda) {
    var dataEnviar = {
        "idContratoBusqueda": idContratoBusqueda,
        "tipoContratoGlobal": tipoContratoGlobal
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Contrato/tblDetalleContrato.php',
        data: dataEnviar,
        dataType: "json",

        success: function (datos) {
            var html = '';
            var i = 0;
            var Num = 1;

            for (i; i < datos.length; i++) {
                if (tipoContratoGlobal == 1) {
                    var Formulario = datos[i].Formulario;
                    var TipoElectronico = datos[i].TipoElectronico;
                    var MarcaElectronico = datos[i].MarcaElectronico;
                    var ModeloElectronico = datos[i].ModeloElectronico;
                    var TipoMetal = datos[i].TipoMetal;
                    var Kilataje = datos[i].Kilataje;
                    var Calidad = datos[i].Calidad;
                    var Detalle = datos[i].Detalle;

                    Formulario = parseInt(Formulario);
                    if (TipoElectronico === null) {
                        TipoElectronico = '';
                    }
                    if (MarcaElectronico === null) {
                        MarcaElectronico = '';
                    }
                    if (ModeloElectronico === null) {
                        ModeloElectronico = '';
                    }
                    if (TipoMetal === null) {
                        TipoMetal = '';
                    }
                    if (Kilataje === null) {
                        Kilataje = '';
                    }
                    if (Calidad === null) {
                        Calidad = '';
                    }
                    if (Detalle === null) {
                        Detalle = '';
                    }

                    if (Formulario == 1) {
                        var Descripcion = Kilataje + " " + Calidad;
                        html += '<tr>' +
                            '<td>' + Num + '</td>' +
                            '<td>' + TipoMetal + '</td>' +
                            '<td>' + Descripcion + '</td>' +
                            '<td>' + Detalle + '</td>' +
                            '</tr>';
                    } else if (Formulario == 2) {
                        var Descripcion = MarcaElectronico + " " + ModeloElectronico;
                        html += '<tr>' +
                            '<td>' + Num + '</td>' +
                            '<td>' + TipoElectronico + '</td>' +
                            '<td>' + Descripcion + '</td>' +
                            '<td>' + Detalle + '</td>' +
                            '</tr>';
                    }

                    Num++;

                } else if (tipoContratoGlobal == 2) {
                    var Marca = datos[i].Marca;
                    var Modelo = datos[i].Modelo;
                    var Anio = datos[i].Anio;
                    var Vehiculo = datos[i].Vehiculo;
                    var ColorAuto = datos[i].ColorAuto;
                    var Obs = datos[i].Obs;

                    if (Marca === null) {
                        Marca = '';
                    }
                    if (Modelo === null) {
                        Modelo = '';
                    }
                    if (Anio === null) {
                        Anio = '';
                    }
                    if (ColorAuto === null) {
                        ColorAuto = '';
                    }
                    if (Obs === null) {
                        Obs = '';
                    }

                    var Descripcion = Marca + " " + Modelo + " " + Anio + " " + ColorAuto;
                    html += '<tr>' +
                        '<td>' + Num + '</td>' +
                        '<td>' + Vehiculo + '</td>' +
                        '<td>' + Descripcion + '</td>' +
                        '<td>' + Obs + '</td>' +
                        '</tr>';

                }
            }
            $('#idTBodyContratoDetalle').html(html);

        }
    });
    $("#divContrato").load('tablaDetalleContrato.php');

}

function cargarTablaContrato(idContratoBusqueda) {
    var dataEnviar = {
        "idContratoBusqueda": idContratoBusqueda,
        "tipoContratoGlobal": tipoContratoGlobal
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Contrato/tblContrato.php',
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


                Prestamo = formatoMoneda(Prestamo);
                Abono = formatoMoneda(Abono);
                Interes = formatoMoneda(Interes);
                Moratorios = formatoMoneda(Moratorios);
                Descuento = formatoMoneda(Descuento);
                Pago = formatoMoneda(Pago);
                PrestamoActual = formatoMoneda(PrestamoActual);
                CostoContrato = formatoMoneda(CostoContrato);
                ContratoReimprimir = Contrato;

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
                    '<img src="../../style/Img/seleccionarNor.png"  alt="Seleccionar"  onclick="cargarTablaDetalleNombre(' + Contrato + ')">' +
                    '</td>' +
                    '<td align="center">' +
                    '<img src="../../style/Img/impresoraNor.png"  alt="Imprimir" onclick="reimprimir(' + MovimientoTipo + ','+ idMovimiento +','+ Contrato +')">' +
                    '</td>';
                if (tipoContratoGlobal == 2) {
                    htmlAuto = '<td align="center"> ' +
                        '<img src="../../style/Img/docNor.png"  alt="Documentos" onclick="cargarPDFDocumentos(' + Contrato + ')">' +
                        '</td>';
                }

                htmlfinal += html + htmlAuto + '</tr>';
                Num++;
            }
            if (tipoContratoGlobal == 2) {
                $('#idTBodyContratoAuto').html(htmlfinal);
            } else {
                $('#idTBodyContrato').html(htmlfinal);
            }
            var contrato = idContratoBusqueda;
            var clienteEmpeno = 0;
            var BitfechaIni = null;
            var BitfechaFin = null;
            BitacoraUsuarioConsulta(contrato, clienteEmpeno, BitfechaIni, BitfechaFin);
            cargarTablaDetalleNombre(contrato)
        }
    });
    if (tipoContratoGlobal == 2) {
        $("#divContrato").load('tablaContratoAuto.php');
    } else {
        $("#divContrato").load('tablaContrato.php');
    }
}

function cargarTablaDetalleNombre(idContratoBusqueda) {
    var dataEnviar = {
        "idContratoBusqueda": idContratoBusqueda,
        "tipoContratoGlobal": tipoContratoGlobal
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Contrato/tblDetalleContrato.php',
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

                    var Formulario = datos[i].Formulario;
                    if (Formulario == 3) {
                        var Marca = datos[i].Marca;
                        var Modelo = datos[i].Modelo;
                        var Vehiculo = datos[i].Vehiculo;
                        var Anio = datos[i].Anio;
                        var ColorAuto = datos[i].ColorAuto;
                        var Obs = datos[i].Obs;
                        var Descripcion = Marca + " " + Modelo + " " + Anio + " " + ColorAuto;
                        var Detalle = Marca + " " + Modelo;
                        html += '<tr align="center">' +
                            '<td>' + idContratoBusqueda + '</td>' +
                            '<td>' + Num + '</td>' +
                            '<td>' + Vehiculo + '</td>' +
                            '<td>' + Descripcion + '</td>' +
                            '<td>' + Obs + '</td>' +
                            '</tr>';
                    } else {
                        var TipoElectronico = datos[i].TipoElectronico;
                        var MarcaElectronico = datos[i].MarcaElectronico;
                        var ModeloElectronico = datos[i].ModeloElectronico;
                        var TipoMetal = datos[i].TipoMetal;
                        var Kilataje = datos[i].Kilataje;
                        var Calidad = datos[i].Calidad;
                        var Detalle = datos[i].Detalle;

                        Formulario = parseInt(Formulario);
                        if (TipoElectronico === null) {
                            TipoElectronico = '';
                        }
                        if (MarcaElectronico === null) {
                            MarcaElectronico = '';
                        }
                        if (ModeloElectronico === null) {
                            ModeloElectronico = '';
                        }
                        if (TipoMetal === null) {
                            TipoMetal = '';
                        }
                        if (Kilataje === null) {
                            Kilataje = '';
                        }
                        if (Calidad === null) {
                            Calidad = '';
                        }
                        if (Detalle === null) {
                            Detalle = '';
                        }

                        if (Formulario == 1) {
                            var Descripcion = Kilataje + " " + Calidad;
                            html += '<tr align="center">' +
                                '<td>' + idContratoBusqueda + '</td>' +
                                '<td>' + Num + '</td>' +
                                '<td>' + TipoMetal + '</td>' +
                                '<td>' + Descripcion + '</td>' +
                                '<td>' + Detalle + '</td>' +
                                '</tr>';
                        } else if (Formulario == 2) {
                            var Descripcion = MarcaElectronico + " " + ModeloElectronico;
                            html += '<tr align="center">' +
                                '<td>' + idContratoBusqueda + '</td>' +
                                '<td>' + Num + '</td>' +
                                '<td>' + TipoElectronico + '</td>' +
                                '<td>' + Descripcion + '</td>' +
                                '<td>' + Detalle + '</td>' +
                                '</tr>';
                        }
                    }

                    Num++;
                }
                $('#idTBodyContratoDetalle').html(html);
            } else {
                alertify.error("El contrato no existe.");
            }
        }
    });
    $("#divDetallesContrato").load('tablaDetalleContrato.php');
}

function cargarTablaNombre() {
    var idClienteConsulta = $("#idClienteConsulta").val();
    var dataEnviar = {
        "idClienteConsulta": idClienteConsulta,
        "tipoContratoGlobal": tipoContratoGlobal
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Contrato/tblDetalleNombre.php',
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
                var PrestamoActual = datos[i].PrestamoActual;
                var Abono = datos[i].Abono;
                var Interes = datos[i].Interes;
                var Moratorios = datos[i].Moratorios;
                var Descuento = datos[i].Descuento;
                var Pago = datos[i].Pago;
                var Plazo = datos[i].Plazo;
                var CostoContrato = datos[i].CostoContrato;
                var MovimientoTipo = datos[i].MovimientoTipo;
                ContratoReimprimir = Contrato;
                MovimientoReimprimir = idMovimiento;

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
                    '<img src="../../style/Img/impresoraNor.png"  alt="Imprimir" onclick="reimprimir(' + MovimientoTipo + ','+idMovimiento+','+ Contrato +')">' +
                    '</td>';
                if (tipoContratoGlobal == 2) {
                    htmlAuto = '<td align="center"> ' +
                        '<img src="../../style/Img/docNor.png"  alt="Documentos" onclick="cargarPDFDocumentos(' + Contrato + ')">' +
                        '</td>';
                }

                htmlfinal += html + htmlAuto + '</tr>';
                Num++;
            }
            if (tipoContratoGlobal == 2) {
                $('#idTBodyContratoAuto').html(htmlfinal);
            } else {
                $('#idTBodyContrato').html(htmlfinal);
            }
            var contrato = 0;
            var clienteEmpeno = idClienteConsulta;
            var BitfechaIni = null;
            var BitfechaFin = null;
            BitacoraUsuarioConsulta(contrato, clienteEmpeno, BitfechaIni, BitfechaFin);
        }
    });
    if (tipoContratoGlobal == 2) {
        $("#divContrato").load('tablaContratoAuto.php');
    } else {
        $("#divContrato").load('tablaContrato.php');
    }
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
            "tipoContratoGlobal": tipoContratoGlobal
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Contrato/tblDetalleFechas.php',
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

                    ContratoReimprimir = Contrato;
                    MovimientoReimprimir = idMovimiento;

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
                        '<img src="../../style/Img/impresoraNor.png"  data-dismiss="modal" alt="impromor" onclick="reimprimir(' + MovimientoTipo + ','+idMovimiento+','+ Contrato +')">' +
                        '</td>';
                    if (tipoContratoGlobal == 2) {
                        htmlAuto = '<td align="center"> ' +
                            '<img src="../../style/Img/docNor.png"  alt="Documentos" onclick="cargarPDFDocumentos(' + Contrato + ')">' +
                            '</td>';
                    }

                    htmlfinal += html + htmlAuto + '</tr>';
                    Num++;
                }

                if (tipoContratoGlobal == 2) {
                    $('#idTBodyContratoAuto').html(htmlfinal);
                } else {
                    $('#idTBodyContrato').html(htmlfinal);
                }
                var contrato = 0;
                var clienteEmpeno = 0;
                var BitfechaIni = nuevaFechaInicio;
                var BitfechaFin = nuevaFechaFinal;
                BitacoraUsuarioConsulta(contrato, clienteEmpeno, BitfechaIni, BitfechaFin);
            }
        });
        if (tipoContratoGlobal == 2) {
            $("#divContrato").load('tablaContratoAuto.php');
        } else {
            $("#divContrato").load('tablaContrato.php');
        }
    }
}

function buscarDatosPorFecha(idContratoBusqueda) {
    var dataEnviar = {
        "idContratoBusqueda": idContratoBusqueda,
        "tipoContratoGlobal": tipoContratoGlobal

    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Contrato/busquedaDatos.php',
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
                    $("#idContratoBusqueda").val(idContratoBusqueda);
                }
                // cargarTablaDetalleContrato(idContratoBusqueda);
                cargarTablaDetalleNombre(idContratoBusqueda);
            } else {
                alertify.error("El contrato no existe.");
            }

        }
    });
}

function LimpiarConsulta() {
    $("#idFormConsulta")[0].reset();
    $("#idContratoConsulta").prop('disabled', true);
    $("#idNombreConsulta").prop('disabled', true);
    $("#idFechaInicial").prop('disabled', true);
    $("#idFechaFinal").prop('disabled', true);
    $('#idAutoCheck').prop('checked', false);
    tipoContratoGlobal = 1;
    $("#divContrato").load('tablaContrato.php');
    $("#divDetallesContrato").load('tablaDetalleContrato.php');
}

function reimprimir(tipoMovimiento,idMovimiento,Contrato) {
    ContratoReimprimir = Contrato;
    if (tipoMovimiento == 3) {
        //3 = Empeño
        window.open('../PDF/callPdfContrato.php?contrato=' + ContratoReimprimir);
    } else if (tipoMovimiento == 4) {
        //4 = Refrendo
        window.open('../PDF/callPdfRefrendo.php?contrato=' + ContratoReimprimir+'&ultimoMovimiento=' + idMovimiento);
    } else if (tipoMovimiento == 5) {
        //5 = Desempeño
        window.open('../PDF/callPdfDesempeno.php?contrato=' + ContratoReimprimir+'&ultimoMovimiento=' + idMovimiento);
    } else if (tipoMovimiento == 6) {
        //6 = Vent8a
    } else if (tipoMovimiento == 7) {
        //7 = Empeño Auto
        window.open('../PDF/callPdfContrato.php?contrato=' + ContratoReimprimir);
    } else if (tipoMovimiento == 8) {
        //8 = Refrendo Auto
        window.open('../PDF/callPdfRefrendo.php?contrato=' + ContratoReimprimir+'&ultimoMovimiento=' + idMovimiento);
    } else if (tipoMovimiento == 9) {
        //9 = Desempeño Auto
        window.open('../PDF/callPdfDesempeno.php?contrato=' + ContratoReimprimir+'&ultimoMovimiento=' + idMovimiento);
    } else if (tipoMovimiento == 10) {
        //10 = Venta Auto
    } else if (tipoMovimiento == 21) {
        //21 = Desempeño sin interes
        window.open('../PDF/callPdfDesempenoSinInteres.php?contrato=' + ContratoReimprimir+'&ultimoMovimiento=' + idMovimiento);
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
    if (tipoContratoGlobal == 1) {
        if (radioSelect == 1) {
            movimiento = 11;
        } else if (radioSelect == 2) {
            movimiento = 12;
        } else if (radioSelect == 3) {
            movimiento = 13;
        }
    } else if (tipoContratoGlobal == 2) {
        if (radioSelect == 1) {
            movimiento = 14;
        } else if (radioSelect == 2) {
            movimiento = 15;
        } else if (radioSelect == 3) {
            movimiento = 16;
        }
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
