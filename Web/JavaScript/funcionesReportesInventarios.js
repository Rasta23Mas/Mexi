


function selectReporte() {
    var reporte = $('#idTipoReporte').val();
    $("#idFechaInicial").val('');
    $("#idFechaFinal").val('');
    if (reporte == 1) {
        nameForm = "Histórico"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        $("#idFechaInicial").datepicker('option', 'disabled', false);
         $("#idFechaInicial").prop('disabled',true);
        //$("#divReporte").load('rptEmpHistorico.php');
    } else if (reporte == 2) {
        nameForm = "Inventarios"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        $("#idFechaInicial").datepicker('disable');
        // $("#divReporte").load('rptEmpInventario.php');
    } else if (reporte == 3) {
        nameForm = "Contratos Vencidos"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        $("#idFechaInicial").datepicker('option', 'disabled', false);
        $("#idFechaFinal").datepicker('option', 'disabled', false);
        $("#idFechaInicial").prop('disabled',true);
        $("#idFechaFinal").prop('disabled',true);

        //$("#divReporte").load('rptEmpContratos.php');
    } else if (reporte == 4) {
        nameForm = "Desempeños"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        $("#idFechaInicial").datepicker('option', 'disabled', false);
        $("#idFechaFinal").datepicker('option', 'disabled', false);
        $("#idFechaInicial").prop('disabled',true);
        $("#idFechaFinal").prop('disabled',true);

        //$("#divReporte").load('rptEmpDesempeno.php');
    } else if (reporte == 5) {
        nameForm = "Refrendo"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        $("#idFechaInicial").datepicker('option', 'disabled', false);
        $("#idFechaFinal").datepicker('option', 'disabled', false);
        $("#idFechaInicial").prop('disabled',true);
        $("#idFechaFinal").prop('disabled',true);

    }else if (reporte == 6) {
        nameForm = "Bazar"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        $("#idFechaInicial").datepicker('disable');
        $("#idFechaFinal").datepicker('disable');
        $("#idFechaInicial").prop('disabled',true);
        $("#idFechaFinal").prop('disabled',true);

    }
}

function llenarReporte() {
    var fechaIni = $("#idFechaInicial").val();
    var fechaFin = $("#idFechaFinal").val();
    var tipoReporte = $('#idTipoReporte').val();

    if (tipoReporte == 2) {
        cargarRptInv()
    } else if (tipoReporte == 3) {
        cargarRptVenci()
    } else if (tipoReporte == 6) {
        cargarRptBazar()
    }else {
        if (fechaFin !== "" && fechaIni !== "") {
            fechaIni = fechaSQL(fechaIni);
            fechaFin = fechaSQL(fechaFin);
            if (tipoReporte == 1) {
                cargarRptHisto(fechaIni, fechaFin)
            } else if (tipoReporte == 4) {
                cargarRptDesempe(fechaIni, fechaFin)
            } else if (tipoReporte == 5) {
                cargarRptRefrendo(fechaIni, fechaFin);
            }
        } else {
            alertify.error("Seleccione fecha de inicio y fecha final.");
        }
    }

}

function exportarExcel() {
    var fechaIni = $("#idFechaInicial").val();
    var fechaFin = $("#idFechaFinal").val();
    var tipoReporte = $('#idTipoReporte').val();
    var sucursal = $('#idSucursal').val();
    if (tipoReporte == 2) {
        window.open('../Excel/rpt_Exc_Inventario.php?sucursal=' + sucursal);

    } else if (tipoReporte == 3) {
        window.open('../Excel/rpt_Exc_Contrato.php?sucursal=' + sucursal);

    } else if (tipoReporte == 6) {
        window.open('../Excel/rpt_Exc_Bazar.php?sucursal=' + sucursal);

    }else {
        if (fechaFin !== "" && fechaIni !== "") {
            fechaIni = fechaSQL(fechaIni);
            fechaFin = fechaSQL(fechaFin);
            if (tipoReporte == 1) {
                window.open('../Excel/rpt_Exc_Historico.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal);
            } else if (tipoReporte == 4) {
                window.open('../Excel/rpt_Exc_Desempeno.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal);
            } else if (tipoReporte == 5) {
                window.open('../Excel/rpt_Exc_Refrendo.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal);
            }
        } else {
            alertify.error("Seleccione fecha de inicio y fecha final.");
        }
    }
}

function exportarPDF() {
    var fechaIni = $("#idFechaInicial").val();
    var fechaFin = $("#idFechaFinal").val();
    var tipoReporte = $('#idTipoReporte').val();

    if (tipoReporte == 2) {
        window.open('../PDF/callPdf_R_Inventario.php');

    } else if (tipoReporte == 3) {
        window.open('../PDF/callPdf_R_Contratos.php');

    } else if (tipoReporte == 6) {
        window.open('../PDF/callPdf_R_Bazar.php');

    }else {
        if (fechaFin !== "" && fechaIni !== "") {
            fechaIni = fechaSQL(fechaIni);
            fechaFin = fechaSQL(fechaFin);
            if (tipoReporte == 1) {
                window.open('../PDF/callPdf_R_Historico.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin);
            } else if (tipoReporte == 4) {
                window.open('../PDF/callPdf_R_Desempeno.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin);

            } else if (tipoReporte == 5) {
                window.open('../PDF/callPdf_R_Refrendo.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin);
            }
        } else {
            alertify.error("Seleccione fecha de inicio y fecha final.");
        }
    }
}

//Reporte HISTORICO
function cargarRptHisto(fechaIni, fechaFin) {
    var tipoReporte = $('#idTipoReporte').val();
    var tipoMetal = 0;
    var tipoElectro = 0;
    var tipoAuto = 0;
    var dataEnviar = {
        "tipoReporte": tipoReporte,
        "fechaIni": fechaIni,
        "fechaFin": fechaFin,
    };
    $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Reportes/tblReportes.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var html = '';
                var i = 0;
                alert("Refrescando tabla.");
                for (i; i < datos.length; i++) {
                    var FECHA = datos[i].FECHA;
                    var FECHAVEN = datos[i].FECHAVEN;
                    var FECHAALM = datos[i].FECHAALM;
                    var CONTRATO = datos[i].CONTRATO;
                    var NombreCompleto = datos[i].NombreCompleto;
                    var PRESTAMO = datos[i].PRESTAMO;
                    var Plazo = datos[i].Plazo;
                    var Periodo = datos[i].Periodo;
                    var TipoInteres = datos[i].TipoInteres;
                    var DescripcionCorta = datos[i].DescripcionCorta;
                    var Obs = datos[i].Obs;
                    var ObserAuto = datos[i].ObserAuto;
                    var DetalleAuto = datos[i].DetalleAuto;
                    var FORMU = datos[i].Form;
                    var Observaciones = "";
                    var Detalle = "";

                    FORMU = Number(FORMU)
                    PRESTAMO = Number(PRESTAMO);
                    PRESTAMO = formatoMoneda(PRESTAMO);

                    if (FORMU == 1) {
                        tipoMetal++;
                        Observaciones = DescripcionCorta;
                        Detalle = Obs;
                    } else if (FORMU == 2) {
                        tipoMetal = 0;
                        tipoElectro++;
                        Observaciones = DescripcionCorta;
                        Detalle = Obs;
                    } else if (FORMU == 3) {
                        tipoMetal = 0;
                        tipoElectro = 0;
                        tipoAuto++;
                        Observaciones = ObserAuto;
                        Detalle = DetalleAuto;
                    }

                    if (tipoMetal == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> METAL </td>' +
                            '</tr>';
                    } else if (tipoElectro == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> ELECTRÓNICOS </td>' +
                            '</tr>';
                    } else if (tipoAuto == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> AUTO </td>' +
                            '</tr>';
                    }

                    html += '<tr>' +
                        '<td >' + FECHA + '</td>' +
                        '<td>' + FECHAVEN + '</td>' +
                        '<td>' + FECHAALM + '</td>' +
                        '<td>' + CONTRATO + '</td>' +
                        '<td>' + NombreCompleto + '</td>' +
                        '<td>' + PRESTAMO + '</td>' +
                        '<td>' + Plazo + '</td>' +
                        '<td>' + Periodo + '</td>' +
                        '<td>' + TipoInteres + '</td>' +
                        '<td>' + Observaciones + '</td>' +
                        '<td>' + Detalle + '</td>' +
                        '</tr>';
                }
                $('#idTBodyHistorico').html(html);
            }
        }
    );
    $("#divRpt").load('rptEmpHistorico.php');
}

//Reporte INVENTARIO
function cargarRptInv() {
    var tipoReporte = $('#idTipoReporte').val();
    var tipoMetal = 0;
    var tipoElectro = 0;
    var tipoAuto = 0;
    var dataEnviar = {
        "tipoReporte": tipoReporte,
        "fechaIni": '',
        "fechaFin": '',
    };
    $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Reportes/tblReportes.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var html = '';
                var i = 0;
                alert("Refrescando tabla.");
                for (i; i < datos.length; i++) {
                    var FECHA = datos[i].FECHA;
                    var FECHAVEN = datos[i].FECHAVEN;
                    var FECHAALM = datos[i].FECHAALM;
                    var CONTRATO = datos[i].CONTRATO;
                    var NombreCompleto = datos[i].NombreCompleto;
                    var PRESTAMO = datos[i].PRESTAMO;
                    var Plazo = datos[i].Plazo;
                    var Periodo = datos[i].Periodo;
                    var TipoInteres = datos[i].TipoInteres;
                    var ObserElec = datos[i].ObserElec;
                    var ObserMetal = datos[i].ObserMetal;
                    var ObserAuto = datos[i].ObserAuto;
                    var DetalleAuto = datos[i].DetalleAuto;
                    var DetalleArt = datos[i].Detalle;
                    var FORMU = datos[i].Form;
                    var Observaciones = "";
                    var Detalle = "";

                    FORMU = Number(FORMU)
                    PRESTAMO = Number(PRESTAMO);
                    PRESTAMO = formatoMoneda(PRESTAMO);

                    if (FORMU == 1) {
                        tipoMetal++;
                        Observaciones = ObserMetal;
                        Detalle = DetalleArt;
                    } else if (FORMU == 2) {
                        tipoMetal = 0;
                        tipoElectro++;
                        Observaciones = ObserElec;
                        Detalle = DetalleArt;
                    } else if (FORMU == 3) {
                        tipoMetal = 0;
                        tipoElectro = 0;
                        tipoAuto++;
                        Observaciones = ObserAuto;
                        Detalle = DetalleAuto;
                    }

                    if (tipoMetal == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> METAL </td>' +
                            '</tr>';
                    } else if (tipoElectro == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> ELECTRÓNICOS </td>' +
                            '</tr>';
                    } else if (tipoAuto == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> AUTO </td>' +
                            '</tr>';
                    }

                    html += '<tr>' +
                        '<td >' + FECHA + '</td>' +
                        '<td>' + FECHAVEN + '</td>' +
                        '<td>' + FECHAALM + '</td>' +
                        '<td>' + CONTRATO + '</td>' +
                        '<td>' + NombreCompleto + '</td>' +
                        '<td>' + PRESTAMO + '</td>' +
                        '<td>' + Plazo + '</td>' +
                        '<td>' + Periodo + '</td>' +
                        '<td>' + TipoInteres + '</td>' +
                        '<td>' + Observaciones + '</td>' +
                        '<td>' + Detalle + '</td>' +
                        '</tr>';
                }
                $('#idTBodyInventario').html(html);
            }
        }
    );
    $("#divRpt").load('rptEmpInventario.php');
}

//Reporte Contrato Venc
function cargarRptVenci() {
    var tipoReporte = $('#idTipoReporte').val();
    var tipoMetal = 0;
    var tipoElectro = 0;
    var tipoAuto = 0;
    var dataEnviar = {
        "tipoReporte": tipoReporte,
        "fechaIni": '',
        "fechaFin": '',
    };
    $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Reportes/tblReportes.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var html = '';
                var i = 0;
                alert("Refrescando tabla.");
                for (i; i < datos.length; i++) {
                    var FECHA = datos[i].FECHA;
                    var FECHAVEN = datos[i].FECHAVEN;
                    var FECHAALM = datos[i].FECHAALM;
                    var CONTRATO = datos[i].CONTRATO;
                    var NombreCompleto = datos[i].NombreCompleto;
                    var PRESTAMO = datos[i].PRESTAMO;
                    var Plazo = datos[i].Plazo;
                    var Periodo = datos[i].Periodo;
                    var TipoInteres = datos[i].TipoInteres;
                    var ObserElec = datos[i].ObserElec;
                    var ObserMetal = datos[i].ObserMetal;
                    var ObserAuto = datos[i].ObserAuto;
                    var DetalleAuto = datos[i].DetalleAuto;
                    var DetalleArt = datos[i].Detalle;
                    var FORMU = datos[i].Form;
                    var Observaciones = "";
                    var Detalle = "";

                    FORMU = Number(FORMU)
                    PRESTAMO = Number(PRESTAMO);
                    PRESTAMO = formatoMoneda(PRESTAMO);

                    if (FORMU == 1) {
                        tipoMetal++;
                        Observaciones = ObserMetal;
                        Detalle = DetalleArt;
                    } else if (FORMU == 2) {
                        tipoMetal = 0;
                        tipoElectro++;
                        Observaciones = ObserElec;
                        Detalle = DetalleArt;
                    } else if (FORMU == 3) {
                        tipoMetal = 0;
                        tipoElectro = 0;
                        tipoAuto++;
                        Observaciones = ObserAuto;
                        Detalle = DetalleAuto;
                    }

                    if (tipoMetal == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> METAL </td>' +
                            '</tr>';
                    } else if (tipoElectro == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> ELECTRÓNICOS </td>' +
                            '</tr>';
                    } else if (tipoAuto == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> AUTO </td>' +
                            '</tr>';
                    }

                    html += '<tr>' +
                        '<td >' + FECHA + '</td>' +
                        '<td>' + FECHAVEN + '</td>' +
                        '<td>' + FECHAALM + '</td>' +
                        '<td>' + CONTRATO + '</td>' +
                        '<td>' + NombreCompleto + '</td>' +
                        '<td>' + PRESTAMO + '</td>' +
                        '<td>' + Plazo + '</td>' +
                        '<td>' + Periodo + '</td>' +
                        '<td>' + TipoInteres + '</td>' +
                        '<td>' + Observaciones + '</td>' +
                        '<td>' + Detalle + '</td>' +
                        '</tr>';
                }

                $('#idTBodyContrato').html(html);
            }
        }
    );
    $("#divRpt").load('rptEmpContratos.php');
}

//Reporte Desempeño
function cargarRptDesempe(fechaIni, fechaFin) {
    var tipoReporte = $('#idTipoReporte').val();
    var tipoMetal = 0;
    var tipoElectro = 0;
    var tipoAuto = 0;
    var dataEnviar = {
        "tipoReporte": tipoReporte,
        "fechaIni": fechaIni,
        "fechaFin": fechaFin,
    };
    $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Reportes/tblReportes.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var html = '';
                var i = 0;
                alert("Refrescando tabla.");
                for (i; i < datos.length; i++) {
                    var FECHA = datos[i].FECHA;
                    var FECHAMOV = datos[i].FECHAMOV;
                    var FECHAVEN = datos[i].FECHAVEN;
                    var CONTRATO = datos[i].CONTRATO;
                    var PRESTAMO = datos[i].PRESTAMO;
                    var INTERESES = datos[i].INTERESES;
                    var ALMACENAJE = datos[i].ALMACENAJE;
                    var SEGURO = datos[i].SEGURO;
                    var ABONO = datos[i].ABONO;
                    var DESCU = datos[i].DESCU;
                    var IVA = datos[i].IVA;
                    var COSTO = datos[i].COSTO;
                    var FORMU = datos[i].FORMU;
                    var SubTotal = datos[i].pag_subtotal;
                    var Total = datos[i].pag_total;
                    FORMU = Number(FORMU)
                    PRESTAMO = Number(PRESTAMO);
                    INTERESES = Number(INTERESES);
                    ALMACENAJE = Number(ALMACENAJE);
                    SEGURO = Number(SEGURO);
                    ABONO = Number(ABONO);
                    COSTO = Number(COSTO);
                    DESCU = Number(DESCU);
                    IVA = Number(IVA);
                    PRESTAMO = formatoMoneda(PRESTAMO);
                    INTERESES = formatoMoneda(INTERESES);
                    ALMACENAJE = formatoMoneda(ALMACENAJE);
                    SEGURO = formatoMoneda(SEGURO);
                    ABONO = formatoMoneda(ABONO);
                    DESCU = formatoMoneda(DESCU);
                    IVA = formatoMoneda(IVA);
                    COSTO = formatoMoneda(COSTO);
                    SubTotal = formatoMoneda(SubTotal);
                    Total = formatoMoneda(Total);
                    if (FORMU == 1) {
                        tipoMetal++;
                    } else if (FORMU == 2) {
                        tipoMetal = 0;
                        tipoElectro++;
                    } else if (FORMU == 3) {
                        tipoMetal = 0;
                        tipoElectro = 0;
                        tipoAuto++;
                    }

                    if (tipoMetal == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> Metal </td>' +
                            '</tr>';
                    } else if (tipoElectro == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> Electrónicos </td>' +
                            '</tr>';
                    } else if (tipoAuto == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> Auto </td>' +
                            '</tr>';
                    }

                    html += '<tr>' +
                        '<td >' + FECHA + '</td>' +
                        '<td>' + FECHAMOV + '</td>' +
                        '<td>' + FECHAVEN + '</td>' +
                        '<td>' + CONTRATO + '</td>' +
                        '<td>' + PRESTAMO + '</td>' +
                        '<td>' + INTERESES + '</td>' +
                        '<td>' + ALMACENAJE + '</td>' +
                        '<td>' + SEGURO + '</td>' +
                        '<td>' + ABONO + '</td>' +
                        '<td>' + DESCU + '</td>' +
                        '<td>' + COSTO + '</td>' +
                        '<td>' + SubTotal + '</td>' +
                        '<td>' + IVA + '</td>' +
                        '<td>' + Total + '</td>' +
                        '</tr>';
                }
                $('#idTBodyDesempeno').html(html);
            }
        }
    );
    $("#divRpt").load('rptEmpDesempeno.php');
}

//Reporte Refrendo
function cargarRptRefrendo(fechaIni, fechaFin) {
    var tipoReporte = $('#idTipoReporte').val();
    var tipoMetal = 0;
    var tipoElectro = 0;
    var tipoAuto = 0;
    var dataEnviar = {
        "tipoReporte": tipoReporte,
        "fechaIni": fechaIni,
        "fechaFin": fechaFin,
    };
    $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Reportes/tblReportes.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var html = '';
                var i = 0;
                alert("Refrescando tabla.");
                for (i; i < datos.length; i++) {
                    var FECHA = datos[i].FECHA;
                    var FECHAMOV = datos[i].FECHAMOV;
                    var FECHAVEN = datos[i].FECHAVEN;
                    var CONTRATO = datos[i].CONTRATO;
                    var PRESTAMO = datos[i].PRESTAMO;
                    var INTERESES = datos[i].INTERESES;
                    var ALMACENAJE = datos[i].ALMACENAJE;
                    var SEGURO = datos[i].SEGURO;
                    var ABONO = datos[i].ABONO;
                    var DESCU = datos[i].DESCU;
                    var IVA = datos[i].IVA;
                    var COSTO = datos[i].COSTO;
                    var FORMU = datos[i].FORMU;
                    var SubTotal = datos[i].pag_subtotal;
                    var Total = datos[i].pag_total;
                    FORMU = Number(FORMU)
                    INTERESES = Number(INTERESES);
                    ALMACENAJE = Number(ALMACENAJE);
                    SEGURO = Number(SEGURO);
                    ABONO = Number(ABONO);
                    COSTO = Number(COSTO);
                    DESCU = Number(DESCU);
                    IVA = Number(IVA);
                    PRESTAMO = formatoMoneda(PRESTAMO);
                    INTERESES = formatoMoneda(INTERESES);
                    ALMACENAJE = formatoMoneda(ALMACENAJE);
                    SEGURO = formatoMoneda(SEGURO);
                    ABONO = formatoMoneda(ABONO);
                    DESCU = formatoMoneda(DESCU);
                    IVA = formatoMoneda(IVA);
                    COSTO = formatoMoneda(COSTO);
                    SubTotal = formatoMoneda(SubTotal);
                    Total = formatoMoneda(Total);
                    if (FORMU == 1) {
                        tipoMetal++;
                    } else if (FORMU == 2) {
                        tipoMetal = 0;
                        tipoElectro++;
                    } else if (FORMU == 3) {
                        tipoMetal = 0;
                        tipoElectro = 0;
                        tipoAuto++;
                    }

                    if (tipoMetal == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> Metal </td>' +
                            '</tr>';
                    } else if (tipoElectro == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> Electrónicos </td>' +
                            '</tr>';
                    } else if (tipoAuto == 1) {
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> Auto </td>' +
                            '</tr>';
                    }

                    html += '<tr>' +
                        '<td >' + FECHA + '</td>' +
                        '<td>' + FECHAMOV + '</td>' +
                        '<td>' + FECHAVEN + '</td>' +
                        '<td>' + CONTRATO + '</td>' +
                        '<td>' + PRESTAMO + '</td>' +
                        '<td>' + INTERESES + '</td>' +
                        '<td>' + ALMACENAJE + '</td>' +
                        '<td>' + SEGURO + '</td>' +
                        '<td>' + ABONO + '</td>' +
                        '<td>' + DESCU + '</td>' +
                        '<td>' + COSTO + '</td>' +
                        '<td>' + SubTotal + '</td>' +
                        '<td>' + IVA + '</td>' +
                        '<td>' + Total + '</td>' +
                        '</tr>';
                }
                $('#idTBodyRefrendo').html(html);
            }
        }
    );
    $("#divRpt").load('rptEmpRefrendo.php');
}

//Reporte Contrato Venc
function cargarRptBazar() {
    var tipoReporte = $('#idTipoReporte').val();
    var dataEnviar = {
        "tipoReporte": tipoReporte,
        "fechaIni": '',
        "fechaFin": '',
    };
    $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Reportes/tblReportes.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var html = '';
                var i = 0;
                alert("Refrescando tabla.");
                for (i; i < datos.length; i++) {
                    var TotalFilas = datos[i].TotalFilas;
                    var id_Contrato = datos[i].id_ContratoRepBaz;
                    var id_serie = datos[i].id_serieRepBaz;
                    var Movimiento = datos[i].Movimiento;
                    var fecha_Bazar = datos[i].fecha_Bazar;
                    var precio_venta = datos[i].precio_venta;
                    var Detalle =  datos[i].Detalle;
                    var CatDesc = datos[i].CatDesc;
                    var id_ContratoMig = datos[i].id_ContratoMig;

                    precio_venta = formatoMoneda(precio_venta);

                    html += '<tr>' +
                        '<td >' + fecha_Bazar + '</td>' +
                        '<td>' + id_Contrato + '</td>' +
                        '<td>' + id_serie + '</td>' +
                        '<td>' + Movimiento + '</td>' +
                        '<td>' + Detalle + '</td>' +
                        '<td>' + precio_venta + '</td>' +
                        '<td>' + CatDesc + '</td>' +
                        '<td>' + id_ContratoMig + '</td>' +
                        '</tr>';
                }

                $('#idTBodyBazar').html(html);
            }
        }
    );
    $("#divRpt").load('rptEmpBazar.php');
}

// MONITOREO
function selectReporteMon() {
    var nombre = $('select[name="nombreReporte"] option:selected').text();
    var titulo = "Autorizaciones : " + nombre;
   document.getElementById('NombreReporte').innerHTML = titulo;
}

function llenarReporteMonitoreo() {
    var fechaIni = $("#idFechaInicial").val();
    var fechaFin = $("#idFechaFinal").val();

    if (fechaFin !== "" && fechaIni !== "") {
        fechaIni = fechaSQL(fechaIni);
        fechaFin = fechaSQL(fechaFin);
        cargarRptMon(fechaIni, fechaFin)
    } else {
        alertify.error("Seleccione fecha de inicio y fecha final.");
    }
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

                    if(tipo_formulario==1){
                        tipoContrato = "METALES";
                    }else if(tipo_formulario==2){
                        tipoContrato = "ELECTRÓNICOS";
                    }else if(tipo_formulario==3){
                        tipoContrato = "AUTO";
                    }


                    if(tipo_formulario==null){
                        tipo_formulario="";
                    }
                    if(descuento==null){
                        descuento="";
                    }
                    if(interes==null){
                        interes="";
                    }
                    if(importe_flujo==null){
                        importe_flujo="";
                    }
                    if(id_flujo==null){
                        id_flujo="";
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
        if(tipoExportar==1){
            window.open('../Excel/rpt_Exc_Monitoreo.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal+'&tipo=' + tipo + '&nombre=' + nombre);
        }else if(tipoExportar==2){
            window.open('../PDF/callPdf_R_Monitoreo.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal+'&tipo=' + tipo + '&nombre=' + nombre);
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
        if(tipoReporte==1){
            cargarRptFinIng(fechaIni, fechaFin,tipoReporte)
        }else if(tipoReporte==2){
            cargarRptFinIng(fechaIni, fechaFin,tipoReporte)
        }
    } else {
        alertify.error("Seleccione fecha de inicio y fecha final.");
    }
}
//Reporte MONITOREO
function cargarRptFinIng(fechaIni, fechaFin,tipoReporte) {

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

                    if(Desem==null){Desem=0;}
                    if(AbonoRef==null){ AbonoRef=0;}
                    if(Inte==null){Inte=0;}
                    if(costoContrato==null){costoContrato=0;}
                    if(Iva==null){ Iva=0;}
                    if(Ventas==null){ Ventas=0;}
                    if(IvaVenta==null){ IvaVenta=0;}
                    if(Utilidad==null){ Utilidad=0;}
                    if(Apartados==null){ Apartados=0;}
                    if(AbonoVen==null){ AbonoVen=0;}
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
    $("#divRptFinancieros").load('rptFinancierosIng.php');
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
        if(tipoExportar==1){
            if(tipo==1){
                window.open('../Excel/rpt_Exc_Ingresos.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal+'&nombre=' + nombre);
            }else if(tipo==2){
                window.open('../Excel/rpt_Exc_Ingresos.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal+'&nombre=' + nombre);
            }
        }else if(tipoExportar==2){
            if(tipo==1){
                window.open('../PDF/callPdf_R_Ingresos.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal+'&nombre=' + nombre);
            }else if(tipo==2){
                window.open('../PDF/callPdf_R_Ingresos.php?fechaIni=' + fechaIni + '&fechaFin=' + fechaFin + '&sucursal=' + sucursal+'&nombre=' + nombre);
            }
        }

    } else {
        alertify.error("Seleccione fecha de inicio y fecha final.");
    }

}