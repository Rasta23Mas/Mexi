var errorToken = 0;
//VENTA 6
var tipo_movimientoGlb = 6;
var idBazarGlb = 0;
var id_ClienteGlb = 0;
var id_VendedorGlb = 0;
var idSubtotalGlb = 0;
var idEmpenoGlb = 0;
var idIvaGlb = 0;
var idTokenSubtotalGlb = 0;
var idTokenIvaGlb = 0;
var idTokenTotalGlb = 0;
var idTokenDescuentoGlb = 0;

var precioAnteriorGlb = 0;
var precioModGlb = 0;
var idArticuloGlb = 0;
var idTokenGLb = 0;

var paginadorGlb;
var totalPaginasGlb;
var itemsPorPaginaGlb = 20;
var numerosPorPaginaGlb = 4;
var idCodigoMostradorGlb = 0;
function buscaridBazarVentas() {
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Ventas/ConBuscarIdBazar.php',
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
        fnLlenaReportMostrador();
    }
}

//LLenar Reportes
function fnLlenaReportMostrador() {
    alert("test");
    var idCodigo = $("#idCodigoMostrador").val();
    idCodigoMostradorGlb = idCodigo;
    var dataEnviar = {
        "idCodigo": idCodigoMostradorGlb,
        "tipo": 1,
        "limit": 0,
        "offset": 0,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Ventas/busquedaCodigo.php',
        data: dataEnviar,
        dataType: "json"
    }).done(function (data, textStatus, jqXHR) {
        var total = data.totalCount;
        if(total==0){
            alert("Sin resultados en la busqueda.")
        }else{
            fnCreaPaginador(total);
        }
    }).fail(function (jqXHR, textStatus, textError) {
        alert("Error al realizar la peticion cuantos".textError);

    });
}


function fnCreaPaginador(totalItems) {
    $("#paginador").html("");
    paginadorGlb = $(".pagination");
    totalPaginasGlb = Math.ceil(totalItems/itemsPorPaginaGlb);

    $('<li><a href="#" class="first_link"><</a></li>').appendTo(paginadorGlb);
    $('<li><a href="#" class="prev_link">«</a></li>').appendTo(paginadorGlb);

    var pag = 0;
    while(totalPaginasGlb > pag)
    {
        $('<li><a href="#" class="page_link">'+(pag+1)+'</a></li>').appendTo(paginadorGlb);
        pag++;
    }

    if(numerosPorPaginaGlb > 1)
    {
        $(".page_link").hide();
        $(".page_link").slice(0,numerosPorPaginaGlb).show();
    }

    $('<li><a href="#" class="next_link">»</a></li>').appendTo(paginadorGlb);
    $('<li><a href="#" class="last_link">></a></li>').appendTo(paginadorGlb);

    paginadorGlb.find(".page_link:first").addClass("active");
    paginadorGlb.find(".page_link:first").parents("li").addClass("active");

    paginadorGlb.find(".prev_link").hide();

    paginadorGlb.find("li .page_link").click(function()
    {
        var irpagina =$(this).html().valueOf()-1;
        fnCargaPagina(irpagina);
        return false;
    });

    paginadorGlb.find("li .first_link").click(function()
    {
        var irpagina =0;
        fnCargaPagina(irpagina);
        return false;
    });

    paginadorGlb.find("li .prev_link").click(function()
    {
        var irpagina =parseInt(paginadorGlb.data("pag")) -1;
        fnCargaPagina(irpagina);
        return false;
    });

    paginadorGlb.find("li .next_link").click(function()
    {
        var irpagina =parseInt(paginadorGlb.data("pag")) +1;
        fnCargaPagina(irpagina);
        return false;
    });

    paginadorGlb.find("li .last_link").click(function()
    {
        var irpagina =totalPaginasGlb -1;
        fnCargaPagina(irpagina);
        return false;
    });

    fnCargaPagina(0);

}

function fnCargaPagina(pagina){
    var desde = pagina * itemsPorPaginaGlb;
    var idCodigo = $("#idCodigoMostrador").val();
    var dataEnviar = {
        "idCodigo": idCodigo,
        "tipo": 2,
        "limit": itemsPorPaginaGlb,
        "offset": desde,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Ventas/busquedaCodigo.php',
        data: dataEnviar,
        dataType: "json"
    }).done(function (data, textStatus, jqXHR) {
        var lista = data.lista;
        $("#idTBodyMetales").html("");
        $.each(lista, function(ind, elem){
            var prestamoCon = elem.prestamo;
            var avaluoCon = elem.avaluo;
            var vitrinaVentaCon = elem.vitrinaVenta;

            var id_ArticuloBazar = elem.id_ArticuloBazar;
            var empeno = prestamoCon;
            var precio_Actual =vitrinaVentaCon;
            prestamoCon = formatoMoneda(prestamoCon);
            avaluoCon = formatoMoneda(avaluoCon);
            vitrinaVentaCon = formatoMoneda(vitrinaVentaCon);
            var desc = elem.descripcionCorta;
            var obs = elem.observaciones;
            var descripcion = desc + " " + obs;


            $("<tr>"+
                "<td>"+elem.id_Contrato+"</td>"+
                "<td>"+id_ArticuloBazar+"</td>"+
                "<td>"+elem.id_serie+"</td>"+
                "<td>"+elem.Adquisicion+"</td>"+
                "<td align='right'>"+prestamoCon+"</td>"+
                "<td align='right'>"+avaluoCon+"</td>"+
                "<td align='right'>"+vitrinaVentaCon+"</td>"+
                "<td>"+descripcion+"</td>"+
                '<td align="center">' +
                '<img src="../../style/Img/carritoNor.png"  data-dismiss="modal" alt="Agregar"' +
                'onclick="validarCarrito(' + id_ArticuloBazar + ',' + precio_Actual + ',' + empeno + ')"> ' +
                '</td>' +
                '<td align="center">' +
                '<img src="../../style/Img/editarNor.jpg"  data-dismiss="modal" alt="Agregar"' +
                'onclick="fnModalPrecio(' + id_ArticuloBazar + ',' + precio_Actual + ')"> ' +
                '</td>'+
                "</tr>").appendTo($("#idTBodyMetales"));
        });

    }).fail(function (jqXHR, textStatus, textError) {
        alert("Error al realizar la peticion cuantos".textError);
    });

    if(pagina >= 1)
    {
        paginadorGlb.find(".prev_link").show();

    }
    else
    {
        paginadorGlb.find(".prev_link").hide();
    }


    if(pagina <(totalPaginasGlb- numerosPorPaginaGlb))
    {
        paginadorGlb.find(".next_link").show();
    }else
    {
        paginadorGlb.find(".next_link").hide();
    }

    paginadorGlb.data("pag",pagina);

    if(numerosPorPaginaGlb>1)
    {
        $(".page_link").hide();
        if(pagina < (totalPaginasGlb- numerosPorPaginaGlb))
        {
            $(".page_link").slice(pagina,numerosPorPaginaGlb + pagina).show();
        }
        else{
            if(totalPaginasGlb > numerosPorPaginaGlb)
                $(".page_link").slice(totalPaginasGlb- numerosPorPaginaGlb).show();
            else
                $(".page_link").slice(0).show();

        }
    }

    paginadorGlb.children().removeClass("active");
    paginadorGlb.children().eq(pagina+2).addClass("active");


}

function fnModalPrecio(id_ArticuloBazar, precio_Actual) {
    precioAnteriorGlb = precio_Actual;
    precio_Actual = formatoMoneda(precio_Actual);
    $("#idPrecioActual").val(precio_Actual);
    $("#idPrecioMod").val(0);
    $("#idArticulo").val(id_ArticuloBazar);
    $("#modalPrecioVenta").modal();

}

function editarPrecio() {
    var idPrecioMod = $("#idPrecioMod").val();
    var idArticulo = $("#idArticulo").val();
    var idCodigoAutMod = $("#idCodigoAutMod").val();

     precioModGlb = idPrecioMod;
     idArticuloGlb = idArticulo;
     idTokenGLb = idCodigoAutMod;
    var dataEnviar = {
        "idPrecioMod": idPrecioMod,
        "idArticulo": idArticulo,
        "idCodigoAutMod": idCodigoAutMod,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Ventas/TokenVentaModPrecio.php',
        type: 'post',
        success: function (respuesta) {
            if (respuesta != 0) {
                alert("Se modifico correctamente el precio.");
                fnBitPrecioMod();
            } else {
                alertify.error("El artículo ya esta en el carrito de compras.");
            }
        },
    })

}

//Carrito
function validarCarrito(id_ArticuloBazar, precio_Enviado, empeno) {
    var vendedor = 0;
    var cliente = $("#idClienteSeleccion").val();

    if (cliente == 0) {
        alertify.warning("Favor de seleccionar el cliente.");
    } else if (vendedor == 33) {
        alertify.warning("Favor de seleccionar el vendedor.");
    } else {
        $("#idNombreVenta").prop('disabled', true);
        var dataEnviar = {
            "id_ArticuloBazar": id_ArticuloBazar,
        };
        $.ajax({
            data: dataEnviar,
            url: '../../../com.Mexicash/Controlador/Ventas/CarritoValidar.php',
            type: 'post',
            success: function (respuesta) {
                if (respuesta == 0) {
                    agregarCarrito(id_ArticuloBazar, precio_Enviado, empeno, cliente, vendedor)
                } else {
                    alertify.error("El artículo ya esta en el carrito de compras.");
                }
            },
        })
    }
}

function agregarCarrito(id_ArticuloBazar, precio_Enviado, empeno, cliente, vendedor) {
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
                fnLlenaReportMostrador();
                refrescarCarrito(precio_Enviado, empeno, tipoCarrito);
            } else {
                alertify.error("Error al agregar el artículo.");
            }
        },
    })
}

function eliminarDelCarrito(id_Ventas, precio_Enviado, prestamo) {
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
                fnLlenaReportMostrador();
                refrescarCarrito(precio_Enviado, prestamo, tipoCarrito);
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
                refrescarCarrito(0, 0, 3);
            }
        },
    })
}

function refrescarCarrito(precio_Enviado, empeno, tipoCarrito) {
    calcularIva(precio_Enviado, empeno, tipoCarrito);
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
                    var prestamo = datos[i].prestamo;
                    var precio_ActualFormat = formatoMoneda(precio_Actual);
                    var prestamoFormat = formatoMoneda(prestamo);
                    html += '<tr>' +
                        '<td>' + Codigo + '</td>' +
                        '<td>' + id_Contrato + '</td>' +
                        '<td>' + descripcionCorta + '</td>' +
                        '<td>' + precio_ActualFormat + '</td>' +
                        '<td>' + prestamoFormat + '</td>' +
                        '<td align="center">' +
                        '<img src="../../style/Img/eliminarNor.jpg"  data-dismiss="modal" alt="Eliminar"' +
                        'onclick="eliminarDelCarrito(' + id_ventas + ',' + precio_Actual + ',' + prestamo + ')"> ' +
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

function calcularIva(precio_Enviado, empeno, tipoCarrito) {
    $("#idDescuento").prop('disabled', false);
    if (tipoCarrito == 1) {
        idSubtotalGlb += precio_Enviado;
        idEmpenoGlb += empeno;
    } else if (tipoCarrito == 2) {
        idSubtotalGlb -= precio_Enviado;
        idEmpenoGlb -= empeno;
    } else if (tipoCarrito == 3) {
        idSubtotalGlb = 0;
        idEmpenoGlb = 0;

    }
    var precioFinal = Math.floor(idSubtotalGlb * 100) / 100;
    idEmpenoGlb = Math.floor(idEmpenoGlb * 100) / 100;
    var calculaIva = Math.floor(precioFinal * 16) / 100;
    idIvaGlb = calculaIva;
    var precioFinalFormat = formatoMoneda(idSubtotalGlb);
    var empenoTotalFormat = formatoMoneda(idEmpenoGlb);
    var calculaIvaFormat = formatoMoneda(idIvaGlb);
    var totalPagarFormat = formatoMoneda(idSubtotalGlb);
    $("#idSubTotal").val(precioFinalFormat);
    $("#idPrestamoTot").val(empenoTotalFormat);
    $("#idIva").val(calculaIvaFormat);
    $("#idTotalPagar").val(totalPagarFormat);
    $("#idSubTotalValue").val(idSubtotalGlb);
    $("#idIvaValue").val(idIvaGlb);
    $("#idTotalValue").val(idSubtotalGlb);
    $("#idTotalBase").val(idSubtotalGlb);
    $("#idPrestamoTotValue").val(idEmpenoGlb);


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
            $("#btnVenta").prop('disabled', false);
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
        url: '../../../com.Mexicash/Controlador/Token/ConTokenValidar.php',
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
        var subtotal = $("#idSubTotalValue").val();
        var iva = $("#idIvaValue").val();
        var descuento = $("#idDescuentoValue").val();
        var total = $("#idTotalValue").val();
        var totalprestamo = $("#idPrestamoTotValue").val();
        var utilidad = total - totalprestamo;
        var cambio = $("#idCambioValue").val();
        var cliente = $("#idClienteSeleccion").val();
        var vendedor = 0;
        idTokenGLb = $("#idToken").val();
        var tokenDesc = "";
        if (idTokenGLb != 0) {
            tokenDesc = $("#tokenDescripcion").val();
        }
        var idBazar = $("#idBazar").val();
        utilidad = Math.floor(utilidad * 100) / 100;
        idTokenSubtotalGlb = subtotal;
        idTokenIvaGlb = iva;
        idTokenDescuentoGlb = descuento;
        idTokenTotalGlb = total;

        var dataEnviar = {
            "tipo_movimiento": tipo_movimientoGlb,
            "subTotal": subtotal,
            "iva": iva,
            "descuento": descuento,
            "total": total,
            "totalprestamo": totalprestamo,
            "utilidad": utilidad,
            "efectivo": efectivo,
            "cambio": cambio,
            "cliente": cliente,
            "vendedor": vendedor,
            "idToken": idTokenGLb,
            "tokenDesc": tokenDesc,
            "idBazar": idBazar,
        };

        $.ajax({
            data: dataEnviar,
            url: '../../../com.Mexicash/Controlador/Ventas/GuardarVenta.php',
            type: 'post',
            success: function (response) {
                if (response == 1) {
                    idBazarGlb = idBazar;
                    ArticulosUpdateVenta()
                } else {
                    alertify.error("Error en al conectar con el servidor.FnError01");
                }
            },
        })
    }
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
                alertify.success("Artículos actualizados correctamente.");
                fnCierreCajaIndispensable(1, 0, 0);
                if (idTokenGLb != 0) {
                    fnUpdateToken();
                } else {
                    fnBitacoraVenta();
                }
            } else {
                alertify.error("Error en al conectar con el servidor.FnError02")
            }
        }
    });
}

function fnUpdateToken() {
    var dataEnviar = {
        "idTokenSubtotalGlb": idTokenSubtotalGlb,
        "idTokenIvaGlb": idTokenIvaGlb,
        "idTokenTotalGlb": idTokenTotalGlb,
        "idTokenDescuentoGlb": idTokenDescuentoGlb,
        "idToken": $("#idToken").val(),
        "tokenDesc": $("#tokenDescripcion").val(),
        "idTokenMov": 7,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Token/TokenVentas.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                fnBitacoraVenta();
            } else {
                alertify.error("Error en al conectar con el servidor.FnError03")
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
                verPDFVenta(idBazarGlb);
            } else {
                alertify.error("Error en al conectar con el servidor.FnError04")
            }
        }
    });
}

//Generar PDF
function verPDFVenta(idBazar) {
    window.open('../PDF/callPdfVenta.php?pdf=1&idBazar=' + idBazar);
    alert("Venta realizada.");
    fnRecargarMostrador();
}

function fnRecargarMostrador() {
    location.reload();
}

function configurarRango() {
    alert("configuración")
}

function fnBitPrecioMod() {
    var dataEnviar = {
        "precioAnteriorGlb": precioAnteriorGlb,
        "precioModGlb": precioModGlb,
        "idArticuloGlb": idArticuloGlb,
        "idTokenGLb": idTokenGLb,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Bitacora/ConBitPrecioMod.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                fnLlenaReportMostrador();
            } else {
                alertify.error("Error en al conectar con el servidor.FnError04")
            }
        }
    });
}