var paginadorGlb;
var totalPaginasGlb;
var itemsPorPaginaGlb = 20;
var numerosPorPaginaGlb = 4;

function fnBuscaReportes(tipo) {
    var dataEnviar = {
        "tipoReporte": tipo
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Reportes/ConCmbReportesInv.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var html = "";
            html += " <option value=0>Seleccione:</option>"
            var i = 0;
            for (i; i < datos.length; i++) {
                var id_cat_rpt = datos[i].id_cat_rpt;
                var descripcion = datos[i].descripcion;
                html += '<option value=' + id_cat_rpt + '>' + descripcion + '</option>';
            }
            $('#idTipoReporte').html(html);
        }
    });
}

function fnSelectReporte() {
    var reporte = $('#idTipoReporte').val();
    var nameForm = "Reporte ";
    var fechas = true;
    var fechasDis = true;
    if (reporte == 1) {
        nameForm += "Histórico";
        document.getElementById('NombreReporte').innerHTML = nameForm;
        $("#divRpt").load('rptEmpHistorico.php');
        fechas = false;
        fechasDis = true;
    } else if (reporte == 2) {
        nameForm += "Contratos Vencidos";
        $("#divRpt").load('rptEmpContratos.php');
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = true;
    } else if (reporte == 3) {
        nameForm += "Desempeños";
        $("#divRpt").load('rptEmpDesempeno.php');
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
    } else if (reporte == 4) {
        nameForm += "Refrendo";
        document.getElementById('NombreReporte').innerHTML = nameForm;
        $("#divRpt").load('rptEmpRefrendo.php');
        fechas = false;
        fechasDis = true;
    } else if (reporte == 5) {
        nameForm += "Bazar"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        $("#divRpt").load('rptEmpBazar.php');
        fechas = true;
    } else if (reporte == 6) {
        nameForm += "Compra"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        $("#divRpt").load('rptEmpCompras.php');
        fechas = false;
        fechasDis = true;
    } else if (reporte == 7) {
        nameForm += "Inventarios"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = true;
        $("#divRpt").load('rptEmpInventario.php');
    } else if (reporte == 8) {
        nameForm += "Transferencia"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        fnRecargarReportes();
    } else if (reporte == 9) {
        nameForm += "Venta"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptEmpVentas.php');
    } else if (reporte == 10) {
        nameForm = "Ingresos"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptFinIngresos.php');
    } else if (reporte == 11) {
        nameForm += "Corporativo"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptFinCorporativo.php');
    } else if (reporte == 12) {
        nameForm += "Descuento de Intéres"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptTknDescuento.php');
    } else if (reporte == 13) {
        nameForm += "Cancelaciones"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptTknDescuento.php');
    } else if (reporte == 14) {
        nameForm += "Central a Banco"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptTknDescuento.php');
    } else if (reporte == 15) {
        nameForm += "Banco a Central"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptTknDescuento.php');
    } else if (reporte == 16) {
        nameForm += "Banco a Bóveda"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptTknDescuento.php');
    } else if (reporte == 17) {
        nameForm += "Bóveda a Banco"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptTknDescuento.php');
    } else if (reporte == 18) {
        nameForm += "Descuento en Ventas"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptMonitoreo.php');
    } else if (reporte == 19) {
        nameForm += "Cambio de precio vitrina"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptTknDescuento.php');
    } else if (reporte == 20) {
        nameForm += "Monto mayor artículos"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptTknDescuento.php');
    } else if (reporte == 21) {
        nameForm += "Monto mayor autos"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptTknDescuento.php');
    } else if (reporte == 22) {
        nameForm += "Horario"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptTknDescuento.php');
    } else if (reporte == 23) {
        nameForm += "Cierre Caja"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptCieCaja.php');
    } else if (reporte == 24) {
        nameForm += "Cierre Sucursal"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptCieSucursal.php');
    } else if (reporte == 25) {
        nameForm += "Cierre Caja por día"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptCieCaja.php');
        fnRecargarReportes();
    } else if (reporte == 26) {
        nameForm += "Cierre Sucursal por día"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptCieSucursal.php');
        fnRecargarReportes();
    } else if (reporte == 27) {
        nameForm += "Empeños"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = false;
        fechasDis = true;
        $("#divRpt").load('rptEmpEmpeno.php');
    } else if (reporte == 28) {
        nameForm += "Bazar Auto"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        fechas = true;
        $("#divRpt").load('rptEmpBazar.php');
    }

    $("#idFechaInicial").datepicker('option', 'disabled', fechas);
    $("#idFechaFinal").datepicker('option', 'disabled', fechas);
    $("#idFechaInicial").prop('disabled', fechasDis);
    $("#idFechaFinal").prop('disabled', fechasDis);
}

function fnLlenarReporte() {
    var fechaIni = $("#idFechaInicial").val();
    var fechaFin = $("#idFechaFinal").val();
    var tipoReporte = $('#idTipoReporte').val();

    var busqueda = 1;
    if (tipoReporte == 2 || tipoReporte == 5 || tipoReporte == 7 || tipoReporte == 28) {
        fnLlenaReport(busqueda, tipoReporte, fechaIni, fechaFin);
    } else {
        if (fechaFin !== "" && fechaIni !== "") {
            fechaIni = fechaSQL(fechaIni);
            fechaFin = fechaSQL(fechaFin);
            fnLlenaReport(busqueda, tipoReporte, fechaIni, fechaFin);

        } else {
            alertify.error("Seleccione fecha de inicio y fecha final.");
        }
    }

}

//LLenar Reportes
function fnLlenaReport(busqueda, tipoReporte, fechaIni, fechaFin) {
    var dataEnviar = {
        "tipoReporte": tipoReporte,
        "fechaIni": fechaIni,
        "fechaFin": fechaFin,
        "busqueda": busqueda,
        "limit": 0,
        "offset": 0,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Reportes/ConReportes.php',
        data: dataEnviar,
        dataType: "json"
    }).done(function (data, textStatus, jqXHR) {
        var total = data.totalCount;
        if (total == 0) {
            alert("Sin resultados en la busqueda.")
        } else {
            if (tipoReporte == 1) {
                var TOT_PRESTAMO = data.TOT_PRESTAMO;
                TOT_PRESTAMO = formatoMoneda(TOT_PRESTAMO);
                document.getElementById('totalPrestamo').innerHTML = TOT_PRESTAMO;
            } else if (tipoReporte == 2) {
                var TOT_PRESTAMO = data.TOT_PRESTAMO;
                TOT_PRESTAMO = formatoMoneda(TOT_PRESTAMO);
                document.getElementById('totalPrestamo').innerHTML = TOT_PRESTAMO;
            } else if (tipoReporte == 3) {
                var TOT_PRESTAMO = data.TOT_PRESTAMO;
                var TOT_INTERES = data.TOT_INTERES;
                var TOT_ALM = data.TOT_ALM;
                var TOT_SEG = data.TOT_SEG;
                var TOT_ABONO = data.TOT_ABONO;
                var TOT_DESC = data.TOT_DESC;
                var TOT_IVA = data.TOT_IVA;
                var TOT_COSTO = data.TOT_COSTO;
                var TOT_SUB = data.TOT_SUB;
                var TOT_TOTAL = data.TOT_TOTAL;
                TOT_PRESTAMO = formatoMoneda(TOT_PRESTAMO);
                TOT_INTERES = formatoMoneda(TOT_INTERES);
                TOT_ALM = formatoMoneda(TOT_ALM);
                TOT_SEG = formatoMoneda(TOT_SEG);
                TOT_ABONO = formatoMoneda(TOT_ABONO);
                TOT_DESC = formatoMoneda(TOT_DESC);
                TOT_IVA = formatoMoneda(TOT_IVA);
                TOT_COSTO = formatoMoneda(TOT_COSTO);
                TOT_SUB = formatoMoneda(TOT_SUB);
                TOT_TOTAL = formatoMoneda(TOT_TOTAL);
                document.getElementById('totalPrestamo').innerHTML = TOT_PRESTAMO;
                document.getElementById('totaltInteres').innerHTML = TOT_INTERES;
                document.getElementById('totalAlmacenaje').innerHTML = TOT_ALM;
                document.getElementById('totalSeguro').innerHTML = TOT_SEG;
                document.getElementById('totalAbono').innerHTML = TOT_ABONO;
                document.getElementById('totalDescuento').innerHTML = TOT_DESC;
                document.getElementById('totalCosto').innerHTML = TOT_COSTO;
                document.getElementById('totalSubtotal').innerHTML = TOT_SUB;
                document.getElementById('totalIva').innerHTML = TOT_IVA;
                document.getElementById('totalCobrado').innerHTML = TOT_TOTAL;
            } else if (tipoReporte == 4) {
                var TOT_PRESTAMO = data.TOT_PRESTAMO;
                var TOT_INTERES = data.TOT_INTERES;
                var TOT_ALM = data.TOT_ALM;
                var TOT_SEG = data.TOT_SEG;
                var TOT_ABONO = data.TOT_ABONO;
                var TOT_DESC = data.TOT_DESC;
                var TOT_IVA = data.TOT_IVA;
                var TOT_COSTO = data.TOT_COSTO;
                var TOT_SUB = data.TOT_SUB;
                var TOT_TOTAL = data.TOT_TOTAL;
                TOT_PRESTAMO = formatoMoneda(TOT_PRESTAMO);
                TOT_INTERES = formatoMoneda(TOT_INTERES);
                TOT_ALM = formatoMoneda(TOT_ALM);
                TOT_SEG = formatoMoneda(TOT_SEG);
                TOT_ABONO = formatoMoneda(TOT_ABONO);
                TOT_DESC = formatoMoneda(TOT_DESC);
                TOT_IVA = formatoMoneda(TOT_IVA);
                TOT_COSTO = formatoMoneda(TOT_COSTO);
                TOT_SUB = formatoMoneda(TOT_SUB);
                TOT_TOTAL = formatoMoneda(TOT_TOTAL);
                document.getElementById('totalPrestamo').innerHTML = TOT_PRESTAMO;
                document.getElementById('totaltInteres').innerHTML = TOT_INTERES;
                document.getElementById('totalAlmacenaje').innerHTML = TOT_ALM;
                document.getElementById('totalSeguro').innerHTML = TOT_SEG;
                document.getElementById('totalAbono').innerHTML = TOT_ABONO;
                document.getElementById('totalDescuento').innerHTML = TOT_DESC;
                document.getElementById('totalCosto').innerHTML = TOT_COSTO;
                document.getElementById('totalSubtotal').innerHTML = TOT_SUB;
                document.getElementById('totalIva').innerHTML = TOT_IVA;
                document.getElementById('totalCobrado').innerHTML = TOT_TOTAL;
            } else if (tipoReporte == 27) {
                var TOT_PRESTAMO = data.TOT_PRESTAMO;
                TOT_PRESTAMO = formatoMoneda(TOT_PRESTAMO);
                document.getElementById('totalPrestamo').innerHTML = TOT_PRESTAMO;
            } else if (tipoReporte == 5) {
                var TOT_VENTAS = data.TOT_VENTAS;
                TOT_VENTAS = formatoMoneda(TOT_VENTAS);
                document.getElementById('totalVentas').innerHTML = TOT_VENTAS;
            } else if (tipoReporte == 6) {
                var TOT_VENTAS = data.TOT_VENTAS;
                var TOT_COMPRA = data.TOT_COMPRA;
                TOT_VENTAS = parseFloat(TOT_VENTAS);
                TOT_COMPRA = parseFloat(TOT_COMPRA);
                var UTILIDAD = TOT_VENTAS - TOT_COMPRA;
                TOT_VENTAS = formatoMoneda(TOT_VENTAS);
                TOT_COMPRA = formatoMoneda(TOT_COMPRA);
                TOT_VENTAS = formatoMoneda(TOT_VENTAS);
                document.getElementById('totalCompras').innerHTML = TOT_COMPRA;
                document.getElementById('totalPrecio').innerHTML = TOT_VENTAS;
                document.getElementById('totalUtilidad').innerHTML = UTILIDAD;
            } else if (tipoReporte == 7) {
                var TOT_VENTAS = data.TOT_VENTAS;
                TOT_VENTAS = formatoMoneda(TOT_VENTAS);
                document.getElementById('totalVentas').innerHTML = TOT_VENTAS;
            } else if (tipoReporte == 9) {
                var TOT_SUB = data.TOT_SUB;
                var TOT_DESC = data.TOT_DESC;
                var TOT_VENTAS = data.TOT_VENTAS;
                var TOT_PREST = data.TOT_PREST;
                var TOT_UTIL = data.TOT_UTIL;

                TOT_SUB = formatoMoneda(TOT_SUB);
                TOT_DESC = formatoMoneda(TOT_DESC);
                TOT_VENTAS = formatoMoneda(TOT_VENTAS);
                TOT_PREST = formatoMoneda(TOT_PREST);
                TOT_UTIL = formatoMoneda(TOT_UTIL);

                document.getElementById('totalSubtotal').innerHTML = TOT_SUB;
                document.getElementById('totalDescuento').innerHTML = TOT_DESC;
                document.getElementById('totalVentas').innerHTML = TOT_VENTAS;
                document.getElementById('totalPrestamo').innerHTML = TOT_PREST;
                document.getElementById('totalUtilidad').innerHTML = TOT_UTIL;
            } else if (tipoReporte == 28) {
                var TOT_VENTAS = data.TOT_VENTAS;
                TOT_VENTAS = formatoMoneda(TOT_VENTAS);
                document.getElementById('totalVentas').innerHTML = TOT_VENTAS;
            } else if (tipoReporte == 10) {
                var TOT_DES = data.TOT_DES;
                var TOT_COSTO = data.TOT_COST;
                var TOT_ABONO = data.TOT_ABONO;
                var TOT_INTER = data.TOT_INTER;
                var TOT_IVA = data.TOT_IVA;
                var TOT_VENTAS = data.TOT_MOS;
                var TOT_IVAV = data.TOT_IVAVEN;
                var TOT_APAR = data.TOT_APAR;
                var TOT_ABON = data.TOT_ABON;
                var TOT_UTIL = data.TOT_UTIL;

                TOT_DES = formatoMoneda(TOT_DES);
                TOT_COSTO = formatoMoneda(TOT_COSTO);
                TOT_ABONO = formatoMoneda(TOT_ABONO);
                TOT_INTER = formatoMoneda(TOT_INTER);
                TOT_IVA = formatoMoneda(TOT_IVA);
                TOT_VENTAS = formatoMoneda(TOT_VENTAS);
                TOT_IVAV = formatoMoneda(TOT_IVAV);
                TOT_APAR = formatoMoneda(TOT_APAR);
                TOT_ABON = formatoMoneda(TOT_ABON);
                TOT_UTIL = formatoMoneda(TOT_UTIL);

                document.getElementById('totalDes').innerHTML = TOT_DES;
                document.getElementById('totalCosto').innerHTML = TOT_COSTO;
                document.getElementById('totalAbono').innerHTML = TOT_ABONO;
                document.getElementById('totalInteres').innerHTML = TOT_INTER;
                document.getElementById('totalIva').innerHTML = TOT_IVA;
                document.getElementById('totalVentas').innerHTML = TOT_VENTAS;
                document.getElementById('totalIvaVentas').innerHTML = TOT_IVAV;
                document.getElementById('totalApart').innerHTML = TOT_APAR;
                document.getElementById('totalAbono').innerHTML = TOT_ABON;
                document.getElementById('totalUtil').innerHTML = TOT_UTIL;
            } else if (tipoReporte == 11) {
                var TOT_DES = data.TOT_DES;
                var TOT_COSTO = data.TOT_COST;
                var TOT_ABONO = data.TOT_ABONO;
                var TOT_INTER = data.TOT_INTER;
                var TOT_IVA = data.TOT_IVA;
                var TOT_VENTAS = data.TOT_MOS;
                var TOT_IVAV = data.TOT_IVAVEN;
                var TOT_APAR = data.TOT_APAR;
                var TOT_ABON = data.TOT_ABON;
                var TOT_UTIL = data.TOT_UTIL;

                TOT_DES = formatoMoneda(TOT_DES);
                TOT_COSTO = formatoMoneda(TOT_COSTO);
                TOT_ABONO = formatoMoneda(TOT_ABONO);
                TOT_INTER = formatoMoneda(TOT_INTER);
                TOT_IVA = formatoMoneda(TOT_IVA);
                TOT_VENTAS = formatoMoneda(TOT_VENTAS);
                TOT_IVAV = formatoMoneda(TOT_IVAV);
                TOT_APAR = formatoMoneda(TOT_APAR);
                TOT_ABON = formatoMoneda(TOT_ABON);
                TOT_UTIL = formatoMoneda(TOT_UTIL);

                document.getElementById('totalDes').innerHTML = TOT_DES;
                document.getElementById('totalCosto').innerHTML = TOT_COSTO;
                document.getElementById('totalAbono').innerHTML = TOT_ABONO;
                document.getElementById('totalInteres').innerHTML = TOT_INTER;
                document.getElementById('totalIva').innerHTML = TOT_IVA;
                document.getElementById('totalVentas').innerHTML = TOT_VENTAS;
                document.getElementById('totalIvaVentas').innerHTML = TOT_IVAV;
                document.getElementById('totalApart').innerHTML = TOT_APAR;
                document.getElementById('totalAbono').innerHTML = TOT_ABON;
                document.getElementById('totalUtil').innerHTML = TOT_UTIL;
            }

            fnCreaPaginador(total);
        }
    }).fail(function (jqXHR, textStatus, textError) {
        alert("Error al realizar la peticion cuantos".textError);

    });
}

//PAginador
function fnCreaPaginador(totalItems) {
    $("#paginador").html("");
    paginadorGlb = $(".pagination");
    totalPaginasGlb = Math.ceil(totalItems / itemsPorPaginaGlb);

    $('<li><a href="#" class="first_link"><</a></li>').appendTo(paginadorGlb);
    $('<li><a href="#" class="prev_link">«</a></li>').appendTo(paginadorGlb);

    var pag = 0;
    while (totalPaginasGlb > pag) {
        $('<li><a href="#" class="page_link">' + (pag + 1) + '</a></li>').appendTo(paginadorGlb);
        pag++;
    }

    if (numerosPorPaginaGlb > 1) {
        $(".page_link").hide();
        $(".page_link").slice(0, numerosPorPaginaGlb).show();
    }

    $('<li><a href="#" class="next_link">»</a></li>').appendTo(paginadorGlb);
    $('<li><a href="#" class="last_link">></a></li>').appendTo(paginadorGlb);

    paginadorGlb.find(".page_link:first").addClass("active");
    paginadorGlb.find(".page_link:first").parents("li").addClass("active");

    paginadorGlb.find(".prev_link").hide();

    paginadorGlb.find("li .page_link").click(function () {
        var irpagina = $(this).html().valueOf() - 1;
        fnCargaPagina(irpagina);
        return false;
    });

    paginadorGlb.find("li .first_link").click(function () {
        var irpagina = 0;
        fnCargaPagina(irpagina);
        return false;
    });

    paginadorGlb.find("li .prev_link").click(function () {
        var irpagina = parseInt(paginadorGlb.data("pag")) - 1;
        fnCargaPagina(irpagina);
        return false;
    });

    paginadorGlb.find("li .next_link").click(function () {
        var irpagina = parseInt(paginadorGlb.data("pag")) + 1;
        fnCargaPagina(irpagina);
        return false;
    });

    paginadorGlb.find("li .last_link").click(function () {
        var irpagina = totalPaginasGlb - 1;
        fnCargaPagina(irpagina);
        return false;
    });

    fnCargaPagina(0);

}

function fnCargaPagina(pagina) {
    var desde = pagina * itemsPorPaginaGlb;
    var fechaIni = $("#idFechaInicial").val();
    var fechaFin = $("#idFechaFinal").val();
    fechaIni = fechaSQL(fechaIni);
    fechaFin = fechaSQL(fechaFin);
    var tipoReporte = $('#idTipoReporte').val();
    var busqueda = 2;
    var dataEnviar = {
        "tipoReporte": tipoReporte,
        "fechaIni": fechaIni,
        "fechaFin": fechaFin,
        "busqueda": busqueda,
        "limit": itemsPorPaginaGlb,
        "offset": desde,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Reportes/ConReportes.php',
        data: dataEnviar,
        dataType: "json"
    }).done(function (data, textStatus, jqXHR) {
        var lista = data.lista;
        if (tipoReporte == 1) {
            fnTBodyHistorico(lista);
        } else if (tipoReporte == 2) {
            fnTBodyContratos(lista);
        } else if (tipoReporte == 3) {
            fnTBodyDesempeno(lista);
        } else if (tipoReporte == 4) {
            fnTBodyRefrendo(lista);
        } else if (tipoReporte == 5) {
            fnTBodyBazar(lista);
        } else if (tipoReporte == 6) {
            fnTBodyCompra(lista);
        } else if (tipoReporte == 7) {
            fnTBodyInventario(lista);
        } else if (tipoReporte == 8) {
            //Transferencias
            //fnTBodyInventario(lista);
        } else if (tipoReporte == 9) {
            fnTBodyVentas(lista);
        } else if (tipoReporte == 10) {
            fnTBodyIngresos(lista);
        } else if (tipoReporte == 11) {
            fnTBodyCorporativo(lista);
        } else if (tipoReporte == 12) {
            fnTBodyTknDescuento(lista);
        }  else if (tipoReporte == 13) {
            fnTBodyTknDescuento(lista);
        } else if (tipoReporte == 14) {
            fnTBodyTknDescuento(lista);
        } else if (tipoReporte == 15) {
            fnTBodyTknDescuento(lista);
        } else if (tipoReporte == 16) {
            fnTBodyTknDescuento(lista);
        } else if (tipoReporte == 17) {
            fnTBodyTknDescuento(lista);
        } else if (tipoReporte == 18) {
            fnTBodyTknDescuento(lista);
        } else if (tipoReporte == 19) {
            fnTBodyTknDescuento(lista);
        } else if (tipoReporte == 20) {
            fnTBodyTknDescuento(lista);
        } else if (tipoReporte == 21) {
            fnTBodyTknDescuento(lista);
        } else if (tipoReporte == 22) {
            fnTBodyTknDescuento(lista);
        }else if (tipoReporte == 23) {
            fnTBodyCaja(lista);
        } else if (tipoReporte == 24) {
            fnTBodySucursal(lista);
        } else if (tipoReporte == 27) {
            fnTBodyEmpeno(lista);
        } else if (tipoReporte == 28) {
            fnTBodyBazarAuto(lista);
        }
    }).fail(function (jqXHR, textStatus, textError) {
        alert("Error al realizar la peticion cuantos".textError);

    });

    if (pagina >= 1) {
        paginadorGlb.find(".prev_link").show();

    } else {
        paginadorGlb.find(".prev_link").hide();
    }


    if (pagina < (totalPaginasGlb - numerosPorPaginaGlb)) {
        paginadorGlb.find(".next_link").show();
    } else {
        paginadorGlb.find(".next_link").hide();
    }

    paginadorGlb.data("pag", pagina);

    if (numerosPorPaginaGlb > 1) {
        $(".page_link").hide();
        if (pagina < (totalPaginasGlb - numerosPorPaginaGlb)) {
            $(".page_link").slice(pagina, numerosPorPaginaGlb + pagina).show();
        } else {
            if (totalPaginasGlb > numerosPorPaginaGlb)
                $(".page_link").slice(totalPaginasGlb - numerosPorPaginaGlb).show();
            else
                $(".page_link").slice(0).show();

        }
    }

    paginadorGlb.children().removeClass("active");
    paginadorGlb.children().eq(pagina + 2).addClass("active");


}

function fnTBodyHistorico(lista) {

    $("#idTBodyHistorico").html("");
    $.each(lista, function (ind, elem) {
        var prestamoCon = elem.PRESTAMO;
        prestamoCon = parseFloat(prestamoCon);
        prestamoCon = formatoMoneda(prestamoCon);
        var formulario = elem.Form;
        var obs = " ";
        var desc = " ";
        if (formulario == 1) {
            obs = elem.ObserArt;
            desc = elem.DESCRIPCION;
        } else if (formulario == 2) {
            obs = elem.ObserArt;
            desc = elem.DESCRIPCION;
        } else {
            obs = elem.ObserAuto;
            desc = elem.detalleAuto;
        }
        $("<tr>" +
            "<td>" + elem.FECHA + "</td>" +
            "<td>" + elem.FECHAVEN + "</td>" +
            "<td>" + elem.FECHAALM + "</td>" +
            "<td align='left'>" + elem.NombreCompleto + "</td>" +
            "<td>" + elem.CONTRATO + "</td>" +
            "<td align='right'>" + prestamoCon + "</td>" +
            "<td align='left'>" + desc + "</td>" +
            "<td>" + obs + "</td>" +
            "</tr>").appendTo($("#idTBodyHistorico"));
    });

}

function fnTBodyContratos(lista) {
    $("#idTBodyContrato").html("");
    $.each(lista, function (ind, elem) {
        var prestamoCon = elem.PRESTAMO;
        prestamoCon = formatoMoneda(prestamoCon);
        var formulario = elem.Form;
        var obs = "";
        if (formulario == 1) {
            obs = elem.ObserArt;
        } else {
            obs = elem.ObserAuto;
        }
        if (obs == null) {
            obs = "";
        }
        $("<tr>" +
            "<td>" + elem.FECHA + "</td>" +
            "<td>" + elem.FECHAVEN + "</td>" +
            "<td>" + elem.FECHAALM + "</td>" +
            "<td>" + elem.NombreCompleto + "</td>" +
            "<td>" + elem.celular + "</td>" +
            "<td>" + elem.CONTRATO + "</td>" +
            "<td align='right'>" + prestamoCon + "</td>" +
            "<td>" + elem.DESCRIPCION + "</td>" +
            "<td>" + obs + "</td>" +
            "</tr>").appendTo($("#idTBodyContrato"));
    });
}

function fnTBodyDesempeno(lista) {
    $("#idTBodyDesempeno").html("");
    $.each(lista, function (ind, elem) {
        var prestamoCon = elem.PRESTAMO;
        var interesesCon = elem.INTERESES;
        var almacenajeCon = elem.ALMACENAJE;
        var seguroCon = elem.SEGURO;
        var abonoCon = elem.ABONO;
        var descuCon = elem.DESCU;
        var ivaCon = elem.IVA;
        var costoCon = elem.COSTO;
        var subtotalCon = elem.pag_subtotal;
        var totalCon = elem.pag_total;
        prestamoCon = formatoMoneda(prestamoCon);
        interesesCon = formatoMoneda(interesesCon);
        almacenajeCon = formatoMoneda(almacenajeCon);
        seguroCon = formatoMoneda(seguroCon);
        abonoCon = formatoMoneda(abonoCon);
        descuCon = formatoMoneda(descuCon);
        ivaCon = formatoMoneda(ivaCon);
        costoCon = formatoMoneda(costoCon);
        subtotalCon = formatoMoneda(subtotalCon);
        totalCon = formatoMoneda(totalCon);
        $("<tr>" +
            "<td>" + elem.FECHA + "</td>" +
            "<td>" + elem.FECHAMOV + "</td>" +
            "<td>" + elem.FECHAVEN + "</td>" +
            "<td>" + elem.CONTRATO + "</td>" +
            "<td align='right'>" + prestamoCon + "</td>" +
            "<td align='right'>" + interesesCon + "</td>" +
            "<td align='right'>" + almacenajeCon + "</td>" +
            "<td align='right'>" + seguroCon + "</td>" +
            "<td align='right'>" + abonoCon + "</td>" +
            "<td align='right'>" + descuCon + "</td>" +
            "<td align='right'>" + ivaCon + "</td>" +
            "<td align='right'>" + costoCon + "</td>" +
            "<td align='right'>" + subtotalCon + "</td>" +
            "<td align='right'>" + totalCon + "</td>" +
            "</tr>").appendTo($("#idTBodyDesempeno"));
    });
}

function fnTBodyRefrendo(lista) {
    $("#idTBodyRefrendo").html("");
    $.each(lista, function (ind, elem) {
        var prestamoCon = elem.PRESTAMO;
        var interesesCon = elem.INTERESES;
        var almacenajeCon = elem.ALMACENAJE;
        var seguroCon = elem.SEGURO;
        var abonoCon = elem.ABONO;
        var descuCon = elem.DESCU;
        var ivaCon = elem.IVA;
        var costoCon = elem.COSTO;
        var subtotalCon = elem.pag_subtotal;
        var totalCon = elem.pag_total;
        prestamoCon = formatoMoneda(prestamoCon);
        interesesCon = formatoMoneda(interesesCon);
        almacenajeCon = formatoMoneda(almacenajeCon);
        seguroCon = formatoMoneda(seguroCon);
        abonoCon = formatoMoneda(abonoCon);
        descuCon = formatoMoneda(descuCon);
        ivaCon = formatoMoneda(ivaCon);
        costoCon = formatoMoneda(costoCon);
        subtotalCon = formatoMoneda(subtotalCon);
        totalCon = formatoMoneda(totalCon);
        $("<tr>" +
            "<td>" + elem.FECHA + "</td>" +
            "<td>" + elem.FECHAMOV + "</td>" +
            "<td>" + elem.FECHAVEN + "</td>" +
            "<td>" + elem.CONTRATO + "</td>" +
            "<td align='right'>" + prestamoCon + "</td>" +
            "<td align='right'>" + interesesCon + "</td>" +
            "<td align='right'>" + almacenajeCon + "</td>" +
            "<td align='right'>" + seguroCon + "</td>" +
            "<td align='right'>" + abonoCon + "</td>" +
            "<td align='right'>" + descuCon + "</td>" +
            "<td align='right'>" + ivaCon + "</td>" +
            "<td align='right'>" + costoCon + "</td>" +
            "<td align='right'>" + subtotalCon + "</td>" +
            "<td align='right'>" + totalCon + "</td>" +
            "</tr>").appendTo($("#idTBodyRefrendo"));
    });
}

function fnTBodyBazar(lista) {
    $("#idTBodyBazar").html("");

    $.each(lista, function (ind, elem) {
        var venta = elem.precio_venta;
        venta = formatoMoneda(venta)
        $("<tr>" +
            "<td>" + elem.FECHA + "</td>" +
            "<td>" + elem.id_Contrato + "</td>" +
            "<td>" + elem.id_serie + "</td>" +
            "<td align='left'>" + elem.Detalle + "</td>" +
            "<td align='right'>" + venta + "</td>" +
            "<td>" + elem.CatDesc + "</td>" +
            "</tr>").appendTo($("#idTBodyBazar"));
    });
}

function fnTBodyCompra(lista) {
    $("#idTBodyCompras").html("");

    $.each(lista, function (ind, elem) {
        var venta = elem.precio_venta;
        var compra = elem.precioCompra;
        venta = parseFloat(venta);
        compra = parseFloat(compra);
        var utilidad = venta - compra;
        venta = formatoMoneda(venta);
        compra = formatoMoneda(compra);
        utilidad = formatoMoneda(utilidad);
        $("<tr>" +
            "<td>" + elem.FECHA + "</td>" +
            "<td>" + elem.id_Contrato + "</td>" +
            "<td>" + elem.id_serie + "</td>" +
            "<td align='left'>" + elem.Detalle + "</td>" +
            "<td align='right'>" + compra + "</td>" +
            "<td align='right'>" + venta + "</td>" +
            "<td align='right'>" + utilidad + "</td>" +
            "<td>" + elem.CatDesc + "</td>" +
            "</tr>").appendTo($("#idTBodyCompras"));
    });
}

function fnTBodyInventario(lista) {
    $("#idTBodyInventario").html("");

    $.each(lista, function (ind, elem) {
        var venta = elem.precio_venta;
        venta = formatoMoneda(venta)
        $("<tr>" +
            "<td>" + elem.FECHA + "</td>" +
            "<td>" + elem.id_Contrato + "</td>" +
            "<td>" + elem.id_serie + "</td>" +
            "<td align='left'>" + elem.Detalle + "</td>" +
            "<td align='right'>" + venta + "</td>" +
            "<td>" + elem.CatDesc + "</td>" +
            "</tr>").appendTo($("#idTBodyInventario"));
    });
}

function fnTBodyVentas(lista) {
    $("#idTBodyVentas").html("");

    $.each(lista, function (ind, elem) {
        var subTotal = elem.subTotal;
        var descuento_Venta = elem.descuento_Venta;
        var total = elem.total;
        var totalPrestamo = elem.totalPrestamo;
        var utilidad = elem.utilidad;

        subTotal = parseFloat(subTotal);
        descuento_Venta = parseFloat(descuento_Venta);
        total = parseFloat(total);
        totalPrestamo = parseFloat(totalPrestamo);
        utilidad = parseFloat(utilidad);

        subTotal = formatoMoneda(subTotal);
        descuento_Venta = formatoMoneda(descuento_Venta);
        total = formatoMoneda(total);
        totalPrestamo = formatoMoneda(totalPrestamo);
        utilidad = formatoMoneda(utilidad);

        $("<tr>" +
            "<td>" + elem.id_Bazar + "</td>" +
            "<td>" + elem.FECHA + "</td>" +
            "<td align='right'>" + subTotal + "</td>" +
            "<td align='right'>" + descuento_Venta + "</td>" +
            "<td align='right'>" + total + "</td>" +
            "<td align='right'>" + totalPrestamo + "</td>" +
            "<td align='right'>" + utilidad + "</td>" +
            "<td>" + elem.usuario + "</td>" +
            "</tr>").appendTo($("#idTBodyVentas"));
    });
}

function fnTBodyIngresos(lista) {
    $("#idTBodyIngresos").html("");

    $.each(lista, function (ind, elem) {
        var desempeno = elem.Desem;
        var costo = elem.costoContrato;
        var abono = elem.AbonoRef;
        var interes = elem.Inte;
        var iva = elem.Iva;
        var ventas = elem.Ventas;
        var ivaVenta = elem.IvaVenta;
        var apartado = elem.Apartados;
        var abonoVenta = elem.AbonoVen;
        var utilidad = elem.Utilidad;
        desempeno = formatoMoneda(desempeno);
        costo = formatoMoneda(costo);
        abono = formatoMoneda(abono);
        interes = formatoMoneda(interes);
        iva = formatoMoneda(iva);
        ventas = formatoMoneda(ventas);
        ivaVenta = formatoMoneda(ivaVenta);
        apartado = formatoMoneda(apartado);
        abonoVenta = formatoMoneda(abonoVenta);
        utilidad = formatoMoneda(utilidad);

        $("<tr>" +
            "<td>" + elem.id_CierreSucursal + "</td>" +
            "<td align='right'>" + desempeno + "</td>" +
            "<td align='right'>" + costo + "</td>" +
            "<td align='right'>" + abono + "</td>" +
            "<td align='right'>" + interes + "</td>" +
            "<td align='right'>" + iva + "</td>" +
            "<td align='right'>" + ventas + "</td>" +
            "<td align='right'>" + ivaVenta + "</td>" +
            "<td align='right'>" + apartado + "</td>" +
            "<td align='right'>" + abonoVenta + "</td>" +
            "<td align='right'>" + utilidad + "</td>" +
            "<td>" + elem.Fecha + "</td>" +
            "</tr>").appendTo($("#idTBodyIngresos"));
    });
}

function fnTBodyCorporativo(lista) {
    $("#idTBodyCorporativo").html("");
    var desempenoMes = 0;
    var costoMes = 0;
    var abonoMes = 0;
    var interesMes = 0;
    var ivaMes = 0;
    var ventasMes = 0;
    var ivaVentaMes = 0;
    var apartadoMes = 0;
    var abonoVentaMes = 0;
    var utilidadMes = 0;
    var finLista = 0;
    var MesNombre = "";
    $.each(lista, function (ind, elem) {
        finLista = lista.length - 1;

        var Imprime = elem.Imprime;

        if (Imprime == 1) {
            var Tdesempeno = formatoMoneda(desempenoMes);
            var Tcosto = formatoMoneda(costoMes);
            var Tabono = formatoMoneda(abonoMes);
            var Tinteres = formatoMoneda(interesMes);
            var Tiva = formatoMoneda(ivaMes);
            var Tventas = formatoMoneda(ventasMes);
            var TivaVenta = formatoMoneda(ivaVentaMes);
            var Tapartado = formatoMoneda(apartadoMes);
            var TabonoVenta = formatoMoneda(abonoVentaMes);
            var Tutilidad = formatoMoneda(utilidadMes);
            desempenoMes = 0;
            costoMes = 0;
            abonoMes = 0;
            interesMes = 0;
            ivaMes = 0;
            ventasMes = 0;
            ivaVentaMes = 0;
            apartadoMes = 0;
            abonoVentaMes = 0;
            utilidadMes = 0;

            $("<tr style='background: dodgerblue; color:white; '>" +
                "<td></td>" +
                "<td>" + Tdesempeno + "</td>" +
                "<td align='right'>" + Tcosto + "</td>" +
                "<td align='right'>" + Tabono + "</td>" +
                "<td align='right'>" + Tinteres + "</td>" +
                "<td align='right'>" + Tiva + "</td>" +
                "<td align='right'>" + Tventas + "</td>" +
                "<td align='right'>" + TivaVenta + "</td>" +
                "<td align='right'>" + Tapartado + "</td>" +
                "<td align='right'>" + TabonoVenta + "</td>" +
                "<td align='right'>" + Tutilidad + "</td>" +
                "<td>" + MesNombre + "</td>" +
                "</tr>").appendTo($("#idTBodyCorporativo"));
            MesNombre = "";
        }
        var desempeno = elem.Desem;
        var costo = elem.costoContrato;
        var abono = elem.AbonoRef;
        var interes = elem.Inte;
        var iva = elem.Iva;
        var ventas = elem.Ventas;
        var ivaVenta = elem.IvaVenta;
        var apartado = elem.Apartados;
        var abonoVenta = elem.AbonoVen;
        var utilidad = elem.Utilidad;
        var Mes = elem.Mes;
        MesNombre = fnMesNombre(Mes);
        desempeno = parseFloat(desempeno);
        costo = parseFloat(costo);
        abono = parseFloat(abono);
        interes = parseFloat(interes);
        iva = parseFloat(iva);
        ventas = parseFloat(ventas);
        ivaVenta = parseFloat(ivaVenta);
        apartado = parseFloat(apartado);
        abonoVenta = parseFloat(abonoVenta);
        utilidad = parseFloat(utilidad);

        desempenoMes += desempeno;
        costoMes += costo;
        abonoMes += abono;
        interesMes += interes;
        ivaMes += iva;
        ventasMes += ventas;
        ivaVentaMes += ivaVenta;
        apartadoMes += apartado;
        abonoVentaMes += abonoVenta;
        utilidadMes += utilidad;

        desempeno = formatoMoneda(desempeno);
        costo = formatoMoneda(costo);
        abono = formatoMoneda(abono);
        interes = formatoMoneda(interes);
        iva = formatoMoneda(iva);
        ventas = formatoMoneda(ventas);
        ivaVenta = formatoMoneda(ivaVenta);
        apartado = formatoMoneda(apartado);
        abonoVenta = formatoMoneda(abonoVenta);
        utilidad = formatoMoneda(utilidad);
        $("<tr>" +
            "<td>" + elem.id_CierreSucursal + "</td>" +
            "<td align='right'>" + desempeno + "</td>" +
            "<td align='right'>" + costo + "</td>" +
            "<td align='right'>" + abono + "</td>" +
            "<td align='right'>" + interes + "</td>" +
            "<td align='right'>" + iva + "</td>" +
            "<td align='right'>" + ventas + "</td>" +
            "<td align='right'>" + ivaVenta + "</td>" +
            "<td align='right'>" + apartado + "</td>" +
            "<td align='right'>" + abonoVenta + "</td>" +
            "<td align='right'>" + utilidad + "</td>" +
            "<td>" + elem.Fecha + "</td>" +
            "</tr>").appendTo($("#idTBodyCorporativo"));

        if (finLista == ind) {
            var Tdesempeno = formatoMoneda(desempenoMes);
            var Tcosto = formatoMoneda(costoMes);
            var Tabono = formatoMoneda(abonoMes);
            var Tinteres = formatoMoneda(interesMes);
            var Tiva = formatoMoneda(ivaMes);
            var Tventas = formatoMoneda(ventasMes);
            var TivaVenta = formatoMoneda(ivaVentaMes);
            var Tapartado = formatoMoneda(apartadoMes);
            var TabonoVenta = formatoMoneda(abonoVentaMes);
            var Tutilidad = formatoMoneda(utilidadMes);
            desempenoMes = 0;
            costoMes = 0;
            abonoMes = 0;
            interesMes = 0;
            ivaMes = 0;
            ventasMes = 0;
            ivaVentaMes = 0;
            apartadoMes = 0;
            abonoVentaMes = 0;
            utilidadMes = 0;
            var Mes = elem.Mes;
            $("<tr style='background: dodgerblue; color:white; '>" +
                "<td></td>" +
                "<td>" + Tdesempeno + "</td>" +
                "<td align='right'>" + Tcosto + "</td>" +
                "<td align='right'>" + Tabono + "</td>" +
                "<td align='right'>" + Tinteres + "</td>" +
                "<td align='right'>" + Tiva + "</td>" +
                "<td align='right'>" + Tventas + "</td>" +
                "<td align='right'>" + TivaVenta + "</td>" +
                "<td align='right'>" + Tapartado + "</td>" +
                "<td align='right'>" + TabonoVenta + "</td>" +
                "<td align='right'>" + Tutilidad + "</td>" +
                "<td>" + MesNombre + "</td>" +
                "</tr>").appendTo($("#idTBodyCorporativo"));
        }

    });
}

function fnTBodyTknDescuento(lista) {
    $("#idTBodyTknDescuento").html("");

    $.each(lista, function (ind, elem) {
        var descuento = elem.descuento;
        descuento = formatoMoneda(descuento);

        $("<tr>" +
            "<td>" + elem.Fecha + "</td>" +
            "<td>" + elem.id_Contrato + "</td>" +
            "<td align='right'>" + elem.token + "</td>" +
            "<td align='right'>" + elem.descripcion + "</td>" +
            "<td align='right'>" + descuento + "</td>" +
            "<td align='right'>" + elem.usuario + "</td>" +
            "<td align='right'>" + elem.sucursal + "</td>" +
            "<td>" + elem.estatus + "</td>" +
            "</tr>").appendTo($("#idTBodyTknDescuento"));
    });


}

function fnTBodyCaja(lista) {
    $("#idTBodyCaja").html("");

    $.each(lista, function (ind, elem) {
        var dotacion = elem.dotacionesA_Caja;
        var capitalRecuperado = elem.capitalRecuperado;
        var abonoCapital = elem.abonoCapital;
        var intereses = elem.intereses;
        var iva = elem.iva;
        var mostrador = elem.mostrador;
        var ivaVen = elem.iva_venta;
        var apartadoVen = elem.apartadosVentas;
        var abonoVen = elem.abonoVentas;
        var retiro = elem.retirosCaja;
        var prestamo = elem.prestamosNuevos;
        var costo = elem.costoContrato;

        dotacion = formatoMoneda(dotacion);
        capitalRecuperado = formatoMoneda(capitalRecuperado);
        abonoCapital = formatoMoneda(abonoCapital);
        intereses = formatoMoneda(intereses);
        iva = formatoMoneda(iva);
        mostrador = formatoMoneda(mostrador);
        ivaVen = formatoMoneda(ivaVen);
        apartadoVen = formatoMoneda(apartadoVen);
        abonoVen = formatoMoneda(abonoVen);
        retiro = formatoMoneda(retiro);
        prestamo = formatoMoneda(prestamo);
        costo = formatoMoneda(costo);
        $("<tr>" +
            "<td>" + elem.id_CierreCaja + "</td>" +
            "<td>" + elem.id_CierreSucursal + "</td>" +
            "<td align='right'>" + dotacion + "</td>" +
            "<td align='right'>" + capitalRecuperado + "</td>" +
            "<td align='right'>" + abonoCapital + "</td>" +
            "<td align='right'>" + intereses + "</td>" +
            "<td align='right'>" + iva + "</td>" +
            "<td align='right'>" + mostrador + "</td>" +
            "<td align='right'>" + ivaVen + "</td>" +
            "<td align='right'>" + apartadoVen + "</td>" +
            "<td align='right'>" + abonoVen + "</td>" +
            "<td align='right'>" + retiro + "</td>" +
            "<td align='right'>" + prestamo + "</td>" +
            "<td align='right'>" + costo + "</td>" +
            "</tr>").appendTo($("#idTBodyCaja"));
    });
}

function fnTBodySucursal(lista) {
    $("#idTBodySucursal").html("");

    $.each(lista, function (ind, elem) {
        var dotacion = elem.dotacionesA_Caja;
        var capitalRecuperado = elem.capitalRecuperado;
        var abonoCapital = elem.abonoCapital;
        var intereses = elem.intereses;
        var iva = elem.iva;
        var mostrador = elem.mostrador;
        var ivaVen = elem.iva_venta;
        var apartados = elem.apartados;
        var abonoVen = elem.abonoVentas;
        var retiro = elem.retirosCaja;
        var prestamo = elem.prestamosNuevos;
        var costo = elem.costoContrato;

        dotacion = formatoMoneda(dotacion);
        capitalRecuperado = formatoMoneda(capitalRecuperado);
        abonoCapital = formatoMoneda(abonoCapital);
        intereses = formatoMoneda(intereses);
        iva = formatoMoneda(iva);
        mostrador = formatoMoneda(mostrador);
        ivaVen = formatoMoneda(ivaVen);
        apartados = formatoMoneda(apartados);
        abonoVen = formatoMoneda(abonoVen);
        retiro = formatoMoneda(retiro);
        prestamo = formatoMoneda(prestamo);
        costo = formatoMoneda(costo);
        $("<tr>" +
            "<td>" + elem.id_CierreSucursal + "</td>" +
            "<td align='right'>" + dotacion + "</td>" +
            "<td align='right'>" + capitalRecuperado + "</td>" +
            "<td align='right'>" + abonoCapital + "</td>" +
            "<td align='right'>" + intereses + "</td>" +
            "<td align='right'>" + iva + "</td>" +
            "<td align='right'>" + mostrador + "</td>" +
            "<td align='right'>" + ivaVen + "</td>" +
            "<td align='right'>" + apartados + "</td>" +
            "<td align='right'>" + abonoVen + "</td>" +
            "<td align='right'>" + retiro + "</td>" +
            "<td align='right'>" + prestamo + "</td>" +
            "<td align='right'>" + costo + "</td>" +
            "</tr>").appendTo($("#idTBodySucursal"));
    });
}

function fnTBodyEmpeno(lista) {
    $("#idTBodyEmpeno").html("");
    $.each(lista, function (ind, elem) {
        var prestamoCon = elem.PRESTAMO;
        prestamoCon = formatoMoneda(prestamoCon);
        var formulario = elem.Form;
        var obs = " ";
        if (formulario == 1) {
            obs = elem.ObserArt;
        } else if (formulario == 2) {
            obs = elem.ObserArt;
        } else {
            obs = elem.ObserAuto;
        }
        $("<tr>" +
            "<td>" + elem.FECHA + "</td>" +
            "<td>" + elem.FECHAVEN + "</td>" +
            "<td>" + elem.FECHAALM + "</td>" +
            "<td align='left'>" + elem.NombreCompleto + "</td>" +
            "<td>" + elem.CONTRATO + "</td>" +
            "<td align='right'>" + prestamoCon + "</td>" +
            "<td align='left'>" + elem.DESCRIPCION + "</td>" +
            "<td>" + obs + "</td>" +
            "</tr>").appendTo($("#idTBodyEmpeno"));
    });
}

function exportar(expor) {
    var fechaIni = $("#idFechaInicial").val();
    var fechaFin = $("#idFechaFinal").val();
    var tipoReporte = $('#idTipoReporte').val();
    var sucursal = $('#idSucursal').val();
    if (tipoReporte == 7) {
        if (expor == 1) {
            window.open('../Excel/rpt_Exc_Inventario.php?sucursal=' + sucursal);
        } else {
            window.open('../PDF/callPdf_R_Inventario.php');
        }
    } else if (tipoReporte == 2) {
        if (expor == 1) {
            window.open('../Excel/rpt_Exc_Contrato.php?sucursal=' + sucursal);
        } else {
            window.open('../PDF/callPdf_R_Contratos.php');
        }
    } else if (tipoReporte == 5) {
        if (expor == 1) {
            window.open('../Excel/rpt_Exc_Bazar.php?sucursal=' + sucursal);
        } else {
            window.open('../PDF/callPdf_R_Bazar.php');
        }
    }else if (tipoReporte == 28) {
        if (expor == 1) {
            window.open('../Excel/rpt_Exc_BazarAuto.php?sucursal=' + sucursal);
        } else {
            window.open('../PDF/callPdf_R_BazarAuto.php');
        }
    } else {
        if (fechaFin !== "" && fechaIni !== "") {
            fechaIni = fechaSQL(fechaIni);
            fechaFin = fechaSQL(fechaFin);
            if (tipoReporte == 1) {
                if (expor == 1) {
                    window.open('../Excel/rpt_Exc_Historico.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal);
                } else {
                    window.open('../PDF/callPdf_R_Historico.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin);
                }
            } else if (tipoReporte == 3) {
                if (expor == 1) {
                    window.open('../Excel/rpt_Exc_Desempeno.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal);
                } else {
                    window.open('../PDF/callPdf_R_Desempeno.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin);
                }
            } else if (tipoReporte == 4) {
                if (expor == 1) {
                    window.open('../Excel/rpt_Exc_Refrendo.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal);
                } else {
                    window.open('../PDF/callPdf_R_Refrendo.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin);
                }
            } else if (tipoReporte == 6) {
                if (expor == 1) {
                    window.open('../Excel/rpt_Exc_Compra.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal);
                } else {
                    alert("entra");
                    window.open('../PDF/callPdf_R_Compra.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin);
                }
            } else if (tipoReporte == 9) {
                if (expor == 1) {
                    window.open('../Excel/rpt_Exc_Venta.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal);
                } else {
                    window.open('../PDF/callPdf_R_Venta.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin);

                }
            } else if (tipoReporte == 10) {
                if (expor == 1) {
                    window.open('../Excel/rpt_Exc_Ingresos.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal);
                } else {

                }
            } else if (tipoReporte == 11) {
                if (expor == 1) {
                    window.open('../Excel/rpt_Exc_Corporativo.phpfechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal);
                } else {

                }
            } else if (tipoReporte == 23) {
                if (expor == 1) {
                    window.open('../Excel/rpt_Exc_Caja.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal);
                } else {

                }
            } else if (tipoReporte == 24) {
                if (expor == 1) {
                    window.open('../Excel/rpt_Exc_Sucursal.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal);
                } else {

                }
            } else if (tipoReporte == 27) {
                if (expor == 1) {
                    window.open('../Excel/rpt_Exc_Empenos.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal);
                } else {
                    window.open('../PDF/callPdf_R_Empeno.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin);
                }
            }
        } else {
            alertify.error("Seleccione fecha de inicio y fecha final.");
        }
    }
}

// MONITOREO
function selectReporteMon() {
    var nombre = $('select[name="nombreReporte"] option:selected').text();
    var titulo = "Autorizaciones : " + nombre;
    document.getElementById('NombreReporte').innerHTML = titulo;
}


//Reporte MONITOREO
function cargarRptMon(fechaIni, fechaFin) {
    var tipoReporte = $('#idTipoReporteMon').val();
    var dataEnviar = {
        "tipoReporte": tipoReporte,
        "fechaIni": fechaIni,
        "fechaFin": fechaFin,
    };
    $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Reportes/tblReportesMon.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                // alert(datos)
                var html = '';
                var i = 0;
                alert("Refrescando tabla.");
                for (i; i < datos.length; i++) {
                    var id_BitacoraToken = datos[i].id_BitacoraToken;
                    var id_Contrato = datos[i].id_Contrato;
                    var tipo_formulario = datos[i].tipo_formulario;
                    var token = datos[i].token;
                    var descripcion = datos[i].descripcion;
                    var descuento = datos[i].descuento;
                    var interes = datos[i].interes;
                    var Descr = datos[i].Descripcion;
                    var user = datos[i].usuario;
                    var importe_flujo = datos[i].importe_flujo;
                    var id_flujo = datos[i].id_flujo;
                    var Fecha = datos[i].Fecha;
                    var tipoContrato = "";

                    if (tipo_formulario == 1) {
                        tipoContrato = "METALES";
                    } else if (tipo_formulario == 2) {
                        tipoContrato = "ELECTRÓNICOS";
                    } else if (tipo_formulario == 3) {
                        tipoContrato = "AUTO";
                    }


                    if (tipo_formulario == null) {
                        tipo_formulario = "";
                    }
                    if (descuento == null) {
                        descuento = "";
                    }
                    if (interes == null) {
                        interes = "";
                    }
                    if (importe_flujo == null) {
                        importe_flujo = "";
                    }
                    if (id_flujo == null) {
                        id_flujo = "";
                    }

                    html += '<tr>' +
                        '<td >' + id_BitacoraToken + '</td>' +
                        '<td>' + id_Contrato + '</td>' +
                        '<td>' + tipoContrato + '</td>' +
                        '<td>' + token + '</td>' +
                        '<td>' + descripcion + '</td>' +
                        '<td>' + descuento + '</td>' +
                        '<td>' + interes + '</td>' +
                        '<td>' + importe_flujo + '</td>' +
                        '<td>' + id_flujo + '</td>' +
                        '<td>' + Descr + '</td>' +
                        '<td>' + user + '</td>' +
                        '<td>' + Fecha + '</td>' +
                        '</tr>';
                }
                $('#idTBodyMonitoreo').html(html);
            }
        }
    );
    $("#divRptMonitoreo").load('rptMonitoreo.php');
}

function exportarMonitoreo(tipoExportar) {
    //tipoExportar = 1 Excel //2 PDF
    var fechaIni = $("#idFechaInicial").val();
    var fechaFin = $("#idFechaFinal").val();
    var tipo = $('#idTipoReporteMon').val();
    var sucursal = $('#idSucursal').val();
    var nombre = $("#NombreReporte").text();
    if (fechaFin !== "" && fechaIni !== "") {
        fechaIni = fechaSQL(fechaIni);
        fechaFin = fechaSQL(fechaFin);
        if (tipoExportar == 1) {
            window.open('../Excel/rpt_Exc_Monitoreo.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal + '&tipo=' + tipo + '&nombre=' + nombre);
        } else if (tipoExportar == 2) {
            window.open('../PDF/callPdf_R_Monitoreo.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal + '&tipo=' + tipo + '&nombre=' + nombre);
        }

    } else {
        alertify.error("Seleccione fecha de inicio y fecha final.");
    }

}

// FINANCIERO
function selectReporteFin() {
    var nombre = $('select[name="nombreReporte"] option:selected').text();
    var titulo = "Financieros : " + nombre;
    document.getElementById('NombreReporte').innerHTML = titulo;
}

function llenarReporteFinanciero() {
    var fechaIni = $("#idFechaInicial").val();
    var fechaFin = $("#idFechaFinal").val();
    var tipoReporte = $('#idTipoReporteFin').val();

    if (fechaFin !== "" && fechaIni !== "") {
        fechaIni = fechaSQL(fechaIni);
        fechaFin = fechaSQL(fechaFin);
        if (tipoReporte == 1) {
            cargarRptFinIng(fechaIni, fechaFin, tipoReporte)
        } else if (tipoReporte == 2) {
            cargarRptFinIng(fechaIni, fechaFin, tipoReporte)
        }
    } else {
        alertify.error("Seleccione fecha de inicio y fecha final.");
    }
}

//Reporte MONITOREO
function cargarRptFinIng(fechaIni, fechaFin, tipoReporte) {

    var dataEnviar = {
        "tipoReporte": tipoReporte,
        "fechaIni": fechaIni,
        "fechaFin": fechaFin,
    };
    $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Reportes/tblReportesFin.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var html = '';
                var i = 0;
                alert("Refrescando tabla.");
                for (i; i < datos.length; i++) {
                    var id_CierreSucursal = datos[i].id_CierreSucursal;
                    var Desem = datos[i].Desem;
                    var AbonoRef = datos[i].AbonoRef;
                    var Inte = datos[i].Inte;
                    var costoContrato = datos[i].costoContratoFin;
                    var Iva = datos[i].Iva;
                    var Ventas = datos[i].Ventas;
                    var IvaVenta = datos[i].IvaVenta;
                    var Utilidad = datos[i].Utilidad;
                    var Apartados = datos[i].Apartados;
                    var AbonoVen = datos[i].AbonoVen;
                    var Fecha = datos[i].Fecha;

                    if (Desem == null) {
                        Desem = 0;
                    }
                    if (AbonoRef == null) {
                        AbonoRef = 0;
                    }
                    if (Inte == null) {
                        Inte = 0;
                    }
                    if (costoContrato == null) {
                        costoContrato = 0;
                    }
                    if (Iva == null) {
                        Iva = 0;
                    }
                    if (Ventas == null) {
                        Ventas = 0;
                    }
                    if (IvaVenta == null) {
                        IvaVenta = 0;
                    }
                    if (Utilidad == null) {
                        Utilidad = 0;
                    }
                    if (Apartados == null) {
                        Apartados = 0;
                    }
                    if (AbonoVen == null) {
                        AbonoVen = 0;
                    }
                    Desem = formatoMoneda(Desem);
                    AbonoRef = formatoMoneda(AbonoRef);
                    Inte = formatoMoneda(Inte);
                    costoContrato = formatoMoneda(costoContrato);
                    Iva = formatoMoneda(Iva);
                    Ventas = formatoMoneda(Ventas);
                    IvaVenta = formatoMoneda(IvaVenta);
                    Utilidad = formatoMoneda(Utilidad);
                    Apartados = formatoMoneda(Apartados);
                    AbonoVen = formatoMoneda(AbonoVen);

                    html += '<tr>' +
                        '<td >' + id_CierreSucursal + '</td>' +
                        '<td>' + Desem + '</td>' +
                        '<td>' + costoContrato + '</td>' +
                        '<td>' + AbonoRef + '</td>' +
                        '<td>' + Inte + '</td>' +
                        '<td>' + Iva + '</td>' +
                        '<td>' + Ventas + '</td>' +
                        '<td>' + IvaVenta + '</td>' +
                        '<td>' + Apartados + '</td>' +
                        '<td>' + AbonoVen + '</td>' +
                        '<td>' + Utilidad + '</td>' +
                        '<td>' + Fecha + '</td>' +
                        '</tr>';
                }
                $('#idTBodyIngresos').html(html);
            }
        }
    );
    $("#divRptFinancieros").load('rptFinIngresos.php');
}

function fnTBodyBazarAuto(lista) {
    $("#idTBodyBazar").html("");

    $.each(lista, function (ind, elem) {
        var venta = elem.precio_venta;
        venta = formatoMoneda(venta)
        $("<tr>" +
            "<td>" + elem.FECHA + "</td>" +
            "<td>" + elem.id_Contrato + "</td>" +
            "<td>" + elem.id_serie + "</td>" +
            "<td align='left'>" + elem.Detalle + "</td>" +
            "<td align='right'>" + venta + "</td>" +
            "<td><label>Migración</label></td>" +
            "</tr>").appendTo($("#idTBodyBazar"));
    });
}

function exportarFinanciero(tipoExportar) {
    //tipoExportar = 1 Excel //2 PDF
    var fechaIni = $("#idFechaInicial").val();
    var fechaFin = $("#idFechaFinal").val();
    var tipo = $('#idTipoReporteFin').val();
    var sucursal = $('#idSucursal').val();
    var nombre = $("#NombreReporte").text();
    if (fechaFin !== "" && fechaIni !== "") {
        fechaIni = fechaSQL(fechaIni);
        fechaFin = fechaSQL(fechaFin);
        if (tipoExportar == 1) {
            if (tipo == 1) {
                window.open('../Excel/rpt_Exc_Ingresos.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal + '&nombre=' + nombre);
            } else if (tipo == 2) {
                window.open('../Excel/rpt_Exc_Corporativo.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal + '&nombre=' + nombre);
            }
        } else if (tipoExportar == 2) {
            if (tipo == 1) {
                window.open('../PDF/callPdf_R_Ingresos.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal + '&nombre=' + nombre);
            } else if (tipo == 2) {
                window.open('../PDF/callPdf_R_Corporativo.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal + '&nombre=' + nombre);
            }
        }

    } else {
        alertify.error("Seleccione fecha de inicio y fecha final.");
    }

}


function fnRecargarReportes() {
    alert("Reporte en construcción");
    location.reload();
}

