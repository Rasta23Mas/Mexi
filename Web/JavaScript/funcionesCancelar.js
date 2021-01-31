var tipoContratoGlobal = 1;
var movimientoCancelado = 20;

var ContratoCancelar = 0;
var tipoCancelar = 0;
var idMovimientoCancelar = 0;
var errorToken = 0;

var ventaCancelarglb = 0;
var ventaArtCancelarglb = 0;
var ventaBazCancelarglb = 0;
var ventaMovimientoCancelarglb = 0;
function cancelarEmpeno() {
    $("#divCancelados").load('tablaCancelacionEmpeno.php');
    var tipoMovimiento = 0;
    if (tipoContratoGlobal == 1) {
         tipoMovimiento = 3;
    } else if (tipoContratoGlobal == 2) {
         tipoMovimiento = 7;
    }
    buscarContratos(tipoMovimiento);
}

function cancelarRefrendo() {
    $("#divCancelados").load('tablaCancelacionEmpeno.php');
    var tipoMovimiento = 0;

    if (tipoContratoGlobal == 1) {
         tipoMovimiento = 4;
    } else if (tipoContratoGlobal == 2) {
         tipoMovimiento = 8;
    }
    buscarContratos(tipoMovimiento);
}

function cancelarDesempeno() {
    $("#divCancelados").load('tablaCancelacionEmpeno.php');
    var tipoMovimiento = 0;

    if (tipoContratoGlobal == 1) {
         tipoMovimiento = 5;
    } else if (tipoContratoGlobal == 2) {
         tipoMovimiento = 9;
    }
    buscarContratos(tipoMovimiento);
}

function cancelarTodos() {
    $("#divCancelados").load('tablaCancelacionEmpeno.php');
    buscarTodosContratos();
}

function cancelarCompra() {
    $("#divCancelados").load('tablaCancelacionCompras.php');
    fnBuscarCompras(1);
}

function cancelarVenta() {
    $("#divCancelados").load('tablaCancelacionCompras.php');
    fnBuscarVentas(2);
}

function cancelarApartado() {
    $("#divCancelados").load('tablaCancelacionCompras.php');
    fnBuscarVentas(3);
}

function cancelarAbono() {
    $("#divCancelados").load('tablaCancelacionCompras.php');
    fnBuscarVentas(4);
}

function cancelarCierreCaja() {
    $("#divCancelados").load('tablaCancelacionCierre.php');
    buscarCierreCaja();
}

function cancelarCierreSucursal() {
    $("#divCancelados").load('tablaCancelacionCierre.php');

}

function clickAuto() {
    $('#idAutoCheck').prop('checked', true);
    tipoContratoGlobal = 2;
}

function limpiarCancelado() {
    $('#idAutoCheck').prop('checked', false);
    tipoContratoGlobal = 1;
    $('#idTBodyCancelaciones').html('');
}

function buscarContratos(tipoMovimiento) {
    if (tipoContratoGlobal == 2) {
        $('#idAutoCheck').prop('checked', true);
    } else if (tipoContratoGlobal == 1) {
        $('#idAutoCheck').prop('checked', false);
    }
    var dataEnviar = {
        "tipoMovimiento": tipoMovimiento,
        "tipoContratoGlobal": tipoContratoGlobal
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Cancelar/busquedaCancelar.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            alert("Refrescando tabla.");
            var html = '';
            var i = 0;
            if(datos.length>0){
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
                    Prestamo = formatoMoneda(Prestamo);
                    Abono = formatoMoneda(Abono);
                    Interes = formatoMoneda(Interes);
                    Moratorios = formatoMoneda(Moratorios);
                    Descuento = formatoMoneda(Descuento);
                    Pago = formatoMoneda(Pago);
                    CostoContrato = formatoMoneda(CostoContrato);


                    html += '<tr>' +
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
                        '<img src="../../style/Img/cancelarNor.png"   alt="Cancelar" onclick="buscarEstatusCancelar(' + Contrato + ',' + MovimientoTipo + ')">' +
                        '</td>';

                }
                $('#idTBodyCancelaciones').html(html);
            } else {
                alertify.error("No hay registros para mostrar.")
            }
        }
    });
    $("#divCancelados").load('tablaCancelacionEmpeno.php');
}

function buscarTodosContratos() {
    if (tipoContratoGlobal == 2) {
        $('#idAutoCheck').prop('checked', true);
    } else if (tipoContratoGlobal == 1) {
        $('#idAutoCheck').prop('checked', false);
    }
    var dataEnviar = {
        "tipoContratoGlobal": tipoContratoGlobal
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Cancelar/busquedaTodos.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            alert("Refrescando tabla.");
            var html = '';
            var i = 0;
            if(datos.length>0){
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
                CostoContrato = formatoMoneda(CostoContrato);


                html += '<tr>' +
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
                    '<img src="../../style/Img/cancelarNor.png"   alt="Cancelar" onclick="buscarEstatusCancelar(' + Contrato + ',' + MovimientoTipo + ' )">' +
                    '</td>';

            }
            $('#idTBodyCancelaciones').html(html);
        } else {
            alertify.error("No hay registros para mostrar.")
        }
        }
    });
    $("#divCancelados").load('tablaCancelacionEmpeno.php');
}

function fnBuscarCompras(tipo) {
    //tipo 1 Compras// tipo 2 Ventas
    if (tipoContratoGlobal == 2) {
        $('#idAutoCheck').prop('checked', true);
    } else if (tipoContratoGlobal == 1) {
        $('#idAutoCheck').prop('checked', false);
    }
    var dataEnviar = {
        "tipoContratoGlobal": tipoContratoGlobal,
        "tipo": tipo
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Cancelar/busquedaBazar.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            alert("Refrescando tabla.");
            //$("#divCancelados").load('tablaCancelacionCompras.php');
            var html = '';
            var i = 0;
            if(datos.length>0){
                for (i; i < datos.length; i++) {
                    var id_ArticuloBazar = datos[i].id_ArticuloBazar;
                    var FECHA = datos[i].FECHA;
                    var id_Contrato = datos[i].id_Contrato;
                    var id_serie = datos[i].id_serie;
                    var precio_venta = datos[i].precio_venta;
                    var precioCompra = datos[i].precioCompra;
                    var utilidad = datos[i].utilidad;
                    var Detalle = datos[i].Detalle;
                    var CatDesc = datos[i].CatDesc;

                    precio_venta = formatoMoneda(precio_venta);
                    precioCompra = formatoMoneda(precioCompra);
                    utilidad = formatoMoneda(utilidad);


                    html += '<tr>' +
                        '<td >' + FECHA + '</td>' +
                        '<td>' + id_Contrato + '</td>' +
                        '<td>' + id_serie + '</td>' +
                        '<td>' + Detalle + '</td>' +
                        '<td>' + precioCompra + '</td>' +
                        '<td>' + precio_venta + '</td>' +
                        '<td>' + utilidad + '</td>' +
                        '<td>' + CatDesc + '</td>' +
                        '<td align="center">' +
                        '<img src="../../style/Img/cancelarNor.png"   alt="Cancelar" onclick="buscarEstatusCancelarBazar(' + id_ArticuloBazar + ',' + tipo + ' )">' +
                        '</td>';

                }
                $('#idTBodyCancelacionesCompras').html(html);
            } else {
                alertify.error("No hay registros para mostrar.")
            }
        }
    });
    $("#divCancelados").load('tablaCancelacionCompras.php');
}

function fnBuscarVentas(tipo) {
    //tipo 1 Compras// tipo 2 Ventas
    if (tipoContratoGlobal == 2) {
        $('#idAutoCheck').prop('checked', true);
    } else if (tipoContratoGlobal == 1) {
        $('#idAutoCheck').prop('checked', false);
    }
    var dataEnviar = {
        "tipoContratoGlobal": tipoContratoGlobal,
        "tipo": tipo
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Cancelar/busquedaBazar.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            alert("Refrescando tabla.");
            var html = '';
            var i = 0;
            if(datos.length>0){
                for (i; i < datos.length; i++) {
                    var id_Bazar = datos[i].id_Bazar;
                    var subTotal = datos[i].subTotal;
                    var iva = datos[i].iva;
                    var descuento_Venta = datos[i].descuento_Venta;
                    var total = datos[i].total;
                    var fecha_Creacion = datos[i].fecha_Creacion;
                    var Movimiento = datos[i].Movimiento;
                    var tipo_movimiento = datos[i].tipo_movimiento;

                    subTotal = formatoMoneda(subTotal);
                    iva = formatoMoneda(iva);
                    descuento_Venta = formatoMoneda(descuento_Venta);
                    total = formatoMoneda(total);

                    html += '<tr>' +
                        '<td >' + id_Bazar + '</td>' +
                        '<td>' + iva + '</td>' +
                        '<td>' + subTotal + '</td>' +
                        '<td>' + descuento_Venta + '</td>' +
                        '<td>' + total + '</td>' +
                        '<td>' + fecha_Creacion + '</td>' +
                        '<td>' + Movimiento + '</td>' +
                        '<td align="center">' +
                        '<img src="../../style/Img/cancelarNor.png"   alt="Cancelar" onclick="buscarEstatusCancelarBazar( '+ id_Bazar +',' + tipo_movimiento +' )">' +
                        '</td>';

                }
                $('#idTBodyCancelacionesVentas').html(html);
            } else {
                alertify.error("No hay registros para mostrar.")
            }
        }
    });
    $("#divCancelados").load('tablaCancelacionVentas.php');
}

function buscarEstatusCancelar(Contrato, MovimientoTipo) {
    var dataEnviar = {
        "Contrato": Contrato
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Cancelar/busquedaEstatus.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var validate = false;
            MovimientoTipo = Number(MovimientoTipo);
            var registro = datos.length;
            registro = Number(registro);
            registro = registro - 1;
            var IdMovimiento = datos[registro].IdMovimiento;
            var tipo_movimiento = datos[registro].tipo_movimiento;
            var MovimientoDesc = datos[registro].MovimientoDesc;


            tipo_movimiento = Number(tipo_movimiento);
            if (tipo_movimiento <= MovimientoTipo) {
                validate = true;
            } else {
                validate = false;
            }
            //}
            if (validate) {
                ContratoCancelar = Contrato;
                tipoCancelar = tipo_movimiento;
                idMovimientoCancelar = IdMovimiento;
                cancelarConfirmar();
            } else {
                alert("No se puede cancelar, ya que el contrato se encuentra en estatus: " + MovimientoDesc);
            }
        }
    });
}

function buscarEstatusCancelarBazar(id_Bazar,Movimiento) {

    ventaBazCancelarglb = id_Bazar;
    ventaMovimientoCancelarglb = Movimiento;
    if(ventaMovimientoCancelarglb==6){
        cancelarConfirmar();
    }

    var dataEnviar = {
        "id_Bazar": ventaBazCancelarglb,
        "tipo": ventaMovimientoCancelarglb,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Cancelar/busquedaEstatusBazar.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var validate = false;
            var registro = datos.length;
            registro = Number(registro);
            registro = registro - 1;
            var tipo_movimiento = datos[registro].tipo_movimiento;
            var MovimientoDesc = datos[registro].MovimientoDesc;


            tipo_movimiento = Number(tipo_movimiento);
            if(ventaMovimientoCancelarglb==22){
                if(tipo_movimiento==23||tipo_movimiento==6){
                    validate = false;
                }else{
                    validate=true;
                }
            }

            if (validate) {
                busquedaVenta();
            } else {
                alert("No se puede cancelar, ya que el contrato se encuentra en estatus: " + MovimientoDesc);
            }
        }
    });
}
//Alerta para confirmar la Eliminacion
function cancelarConfirmar() {
    alertify.confirm('Atención',
        'Confime si desea cancelar.',
        function () {
            $("#modalCancelar").modal();},
        function () {
            alertify.success("No se continuo la cancelación.")
        });
}

function tokenCancelar() {
    var tokenDes = $("#idCodigoAut").val();
    var dataEnviar = {
        "token": tokenDes,
        "Contrato": ContratoCancelar,
        "tipoContrato": tipoContratoGlobal,

    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Token/TokenCancelar.php',
        type: 'post',
        success: function (response) {
            if (response > 0) {
                $("#idToken").val(response);
                // var token = parseInt(response);
                var token = response;

                alertify.success("Código correcto.");

                if(ventaMovimientoCancelarglb==6){
                    busquedaVenta(1);
                }else{
                    busquedaContrato();
                }

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

function busquedaContrato() {
    var fechaAlmoneda = '';
    var id_movimiento = '';
    if(tipoCancelar==3||tipoCancelar==7){
        cancelacionMovimiento(id_movimiento,fechaAlmoneda);
    }else{
        //CancelaMovimiento y Bit Pagos
        var dataEnviar = {
            "ContratoCancelar":ContratoCancelar,
            "IdMovimiento": idMovimientoCancelar

        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Cancelar/recuperarFechaAlm.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var i = 0;
                if (datos.length > 0) {
                    for (i; i < datos.length; i++) {
                        id_movimiento = datos[i].id_movimiento;
                        fechaAlmoneda = datos[i].fechaAlmoneda;
                        cancelacionMovimiento(id_movimiento,fechaAlmoneda);
                        }
                } else {
                    alertify.error("No hay registros para mostrar.")
                }
            }
        });
    }


}
function busquedaVenta(tipo) {
    ventaBazCancelarglb = id_Bazar;
    ventaMovimientoCancelarglb = Movimiento;
        //CancelaMovimiento y Bit Pagos
        var dataEnviar = {
            "id_Bazar":ventaBazCancelarglb,
            "Movimiento": ventaMovimientoCancelarglb,
            "tipo": tipo
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Cancelar/cancelarVentas.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var i = 0;
                if (datos.length > 0) {
                    for (i; i < datos.length; i++) {
                        id_movimiento = datos[i].id_movimiento;
                        fechaAlmoneda = datos[i].fechaAlmoneda;
                        cancelacionMovimiento(id_movimiento,fechaAlmoneda);
                    }
                } else {
                    alertify.error("No hay registros para mostrar.")
                }
            }
        });
}
function cancelacionMovimientoVenta(id_movimientoAnterior,fechaAlmoneda) {
    //CancelaMovimiento y Bit Pagos
    var dataEnviar = {
        "tipo_movimiento":tipoCancelar,
        "movimientoCancelado": movimientoCancelado,
        "IdMovimiento": idMovimientoCancelar,
        "fechaAlmoneda": fechaAlmoneda,
        "id_movimientoAnterior": id_movimientoAnterior
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Cancelar/cancelarMovimiento.php',
        data: dataEnviar,
        success: function (response) {
            if (response == 1) {
                if(tipoCancelar==3||tipoCancelar==7){
                    cancelacionContrato();
                }else{
                    BitacoraUsuarioCancelacion()
                }
            }else{
                alertify.error("Error al cancelar movimiento.")
            }
        }
    });
}

function cancelacionMovimiento(id_movimientoAnterior,fechaAlmoneda) {
    //CancelaMovimiento y Bit Pagos
    var dataEnviar = {
        "tipo_movimiento":tipoCancelar,
        "movimientoCancelado": movimientoCancelado,
        "IdMovimiento": idMovimientoCancelar,
        "fechaAlmoneda": fechaAlmoneda,
        "id_movimientoAnterior": id_movimientoAnterior
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Cancelar/cancelarMovimiento.php',
        data: dataEnviar,
        success: function (response) {
            if (response == 1) {
                if(tipoCancelar==3||tipoCancelar==7){
                    cancelacionContrato();
                }else{
                    BitacoraUsuarioCancelacion()
                }
            }else{
                alertify.error("Error al cancelar movimiento.")
            }
        }
    });
}

function cancelacionContrato() {
    //Cancela  articulos
    var dataEnviar = {
        "Contrato": ContratoCancelar,
        "tipoContratoGlobal":tipoContratoGlobal

    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Cancelar/cancelarContrato.php',
        data: dataEnviar,
        success: function (response) {
            if (response == 1) {
                BitacoraUsuarioCancelacion()
            }else{
                alertify.error("Error al cancelar movimiento.")
            }
        }
    });
}
function BitacoraUsuarioCancelacion() {
    //id_Movimiento = 3 cat_movimientos-->Operacion-->Empeño
    var id_Movimiento = 20;
    var id_contrato = ContratoCancelar;
    var id_almoneda = 0;
    var id_cliente = 0;
    var consulta_fechaInicio = null;
    var consulta_fechaFinal = null;
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
                alert("Se realizo la cancelación del movimiento.")
                reCargarPag();
            } else {
                alertify.error("Error al contactar con el seridor.")
            }
        }
    });
}

function reCargarPag() {
    location.reload();
}

function buscarCierreCaja() {
    var dataEnviar = {
        "tipe": 1,
        "folio" : 0,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Cancelar/busquedaCierre.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            alert("Refrescando tabla.");
            var html = '';
            var i = 0;
            var Num = 1;
            if(datos.length>0){
                for (i; i < datos.length; i++) {
                    var folio_CierreCaja = datos[i].folio_CierreCaja;
                    var id_CierreCaja = datos[i].id_CierreCaja;
                    var id_CierreSucursal = datos[i].id_CierreSucursal;
                    var total_Salida = datos[i].total_Salida;
                    var total_Entrada = datos[i].total_Entrada;
                    var saldo_Caja = datos[i].saldo_Caja;
                    var efectivo_Caja = datos[i].efectivo_Caja;
                    var ajuste = datos[i].ajuste;
                    var usuario = datos[i].usuario;
                    var CerradoPorGerente = datos[i].CerradoPorGerente;

                    total_Salida = formatoMoneda(total_Salida);
                    total_Entrada = formatoMoneda(total_Entrada);
                    saldo_Caja = formatoMoneda(saldo_Caja);
                    efectivo_Caja = formatoMoneda(efectivo_Caja);
                    ajuste = formatoMoneda(ajuste);

                    if(CerradoPorGerente==0){
                        CerradoPorGerente = "NO";
                    }else{
                        CerradoPorGerente = "SI";
                    }
                    Num++;

                    html += '<tr>' +
                        '<td >' + Num + '</td>' +
                        '<td>' + id_CierreCaja + '</td>' +
                        '<td>' + id_CierreSucursal + '</td>' +
                        '<td>' + total_Salida + '</td>' +
                        '<td>' + total_Entrada + '</td>' +
                        '<td>' + saldo_Caja + '</td>' +
                        '<td>' + efectivo_Caja + '</td>' +
                        '<td>' + ajuste + '</td>' +
                        '<td>' + usuario + '</td>' +
                        '<td>' + CerradoPorGerente + '</td>' +
                        '<td align="center">' +
                        '<img src="../../style/Img/cancelarNor.png"   alt="Cancelar" onclick="cierreCancelar(' + folio_CierreCaja + ')">' +
                        '</td>';

                }
                $('#idTBodyCancelacionesCierre').html(html);
            } else {
                alertify.error("No hay registros para mostrar.")
            }
        }
    });
    $("#divCancelados").load('tablaCancelacionCierre.php');
}

function cierreCancelar(folio_CierreCaja) {
    var dataEnviar = {
        "tipe": 2,
        "folio" : folio_CierreCaja,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Cancelar/busquedaCierre.php',
        data: dataEnviar,
        success: function (actualizado) {
            if (actualizado==1) {
                buscarCierreCaja();
                alertify.success("Se ha realizado la cancelación del cierre de caja.")

            } else {
                alertify.error("Error al cancelar el cierre de caja.")
            }
        }
    });
}