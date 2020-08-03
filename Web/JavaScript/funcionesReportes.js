function selectReporte() {
   var reporte = $('#idTipoReporte').val();
    $("#idFechaInicial").val('');
    $("#idFechaFinal").val('');
    if (reporte == 1) {
        nameForm = "Histórico"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        $("#idFechaInicial").datepicker('option','disabled',false);
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
        $("#idFechaInicial").datepicker('disable');
        $("#idFechaFinal").datepicker('disable');
        //$("#divReporte").load('rptEmpContratos.php');
    } else if (reporte == 4) {
        nameForm = "Desempeños"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        $("#idFechaInicial").datepicker('option','disabled',false);
        $("#idFechaInicial").prop('disabled',true);
        //$("#divReporte").load('rptEmpDesempeno.php');
    } else if (reporte == 5) {
        nameForm = "Refrendo"
        document.getElementById('NombreReporte').innerHTML = nameForm;
        $("#idFechaInicial").datepicker('option','disabled',false);
        $("#idFechaInicial").prop('disabled',true);
    }
}

function llenarReporte() {
    var fechaIni = $("#idFechaInicial").val();
    var fechaFin = $("#idFechaFinal").val();
    var tipoReporte = $('#idTipoReporte').val();

    if(tipoReporte==2){
        cargarRptInv()
    }else if(tipoReporte==3){
        cargarRptVenci()
    }else{
        if(fechaFin!=""&&fechaIni!=""){
            fechaIni = fechaSQL(fechaIni);
            fechaFin = fechaSQL(fechaFin);
            if(tipoReporte==1){
                cargarRptHisto(fechaIni,fechaFin)
            }else if(tipoReporte==4){
                cargarRptDesempe(fechaIni,fechaFin)
            }else if(tipoReporte==5){
                cargarRptRefrendo(fechaIni,fechaFin);
            }
        }else{
            alertify.error("Seleccione fecha de inicio y fecha final.");
        }
    }

}

function exportarExcel() {
    alert("Exportar a Excel");
}

function exportarPDF() {
    var fechaIni = $("#idFechaInicial").val();
    var fechaFin = $("#idFechaFinal").val();
    var tipoReporte = $('#idTipoReporte').val();

    if(tipoReporte==2){
        window.open('../PDF/callPdf_R_Inventario.php');

    }else if(tipoReporte==3){
        window.open('../PDF/callPdf_R_Contratos.php');

    }else{
        if(fechaFin!=""&&fechaIni!=""){
            fechaIni = fechaSQL(fechaIni);
            fechaFin = fechaSQL(fechaFin);
            if(tipoReporte==1){
                window.open('../PDF/callPdf_R_Historico.php?fechaIni='+fechaIni+'&fechaFin='+fechaFin);
            }else if(tipoReporte==4){
                cargarRptDesempe(fechaIni,fechaFin);
                window.open('../PDF/callPdf_R_Desempeno.php?fechaIni='+fechaIni+'&fechaFin='+fechaFin);

            }else if(tipoReporte==5){
                cargarRptRefrendo(fechaIni,fechaFin);
                window.open('../PDF/callPdf_R_Refrendo.php?fechaIni='+fechaIni+'&fechaFin='+fechaFin);

            }
        }else{
            alertify.error("Seleccione fecha de inicio y fecha final.");
        }
    }
}

//Reporte HISTORICO
function cargarRptHisto(fechaIni,fechaFin) {
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

                    if(FORMU==1){
                        tipoMetal++;
                        Observaciones = ObserMetal;
                        Detalle = DetalleArt;
                    }else if (FORMU==2){
                        tipoMetal = 0;
                        tipoElectro++;
                        Observaciones = ObserElec;
                        Detalle = DetalleArt;
                    }else if (FORMU==3){
                        tipoMetal = 0;
                        tipoElectro = 0;
                        tipoAuto++;
                        Observaciones = ObserAuto;
                        Detalle = DetalleAuto;
                    }

                    if(tipoMetal==1){
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> METAL </td>' +
                            '</tr>';
                    }else if (tipoElectro==1){
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> ELECTRÓNICOS </td>' +
                            '</tr>';
                    }else if (tipoAuto == 1){
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

                    if(FORMU==1){
                        tipoMetal++;
                        Observaciones = ObserMetal;
                        Detalle = DetalleArt;
                    }else if (FORMU==2){
                        tipoMetal = 0;
                        tipoElectro++;
                        Observaciones = ObserElec;
                        Detalle = DetalleArt;
                    }else if (FORMU==3){
                        tipoMetal = 0;
                        tipoElectro = 0;
                        tipoAuto++;
                        Observaciones = ObserAuto;
                        Detalle = DetalleAuto;
                    }

                    if(tipoMetal==1){
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> METAL </td>' +
                            '</tr>';
                    }else if (tipoElectro==1){
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> ELECTRÓNICOS </td>' +
                            '</tr>';
                    }else if (tipoAuto == 1){
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

                    if(FORMU==1){
                        tipoMetal++;
                        Observaciones = ObserMetal;
                        Detalle = DetalleArt;
                    }else if (FORMU==2){
                        tipoMetal = 0;
                        tipoElectro++;
                        Observaciones = ObserElec;
                        Detalle = DetalleArt;
                    }else if (FORMU==3){
                        tipoMetal = 0;
                        tipoElectro = 0;
                        tipoAuto++;
                        Observaciones = ObserAuto;
                        Detalle = DetalleAuto;
                    }

                    if(tipoMetal==1){
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> METAL </td>' +
                            '</tr>';
                    }else if (tipoElectro==1){
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> ELECTRÓNICOS </td>' +
                            '</tr>';
                    }else if (tipoAuto == 1){
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
                    alert("hola");
                }

                $('#idTBodyContrato').html(html);
            }
        }
    );
    $("#divRpt").load('rptEmpContratos.php');
}

//Reporte Desempeño
function cargarRptDesempe(fechaIni,fechaFin) {
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
                    var SubTotal = 0;
                    var Total = 0;
                    FORMU = Number(FORMU)
                    PRESTAMO = Number(PRESTAMO);
                    INTERESES = Number(INTERESES);
                    ALMACENAJE = Number(ALMACENAJE);
                    SEGURO = Number(SEGURO);
                    ABONO = Number(ABONO);
                    COSTO = Number(COSTO);
                    DESCU = Number(DESCU);
                    IVA = Number(IVA);
                    SubTotal = PRESTAMO + ABONO + COSTO;
                    SubTotal = SubTotal - DESCU;
                    Total = SubTotal + IVA;
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
                    if(FORMU==1){
                        tipoMetal++;
                    }else if (FORMU==2){
                        tipoMetal = 0;
                        tipoElectro++;
                    }else if (FORMU==3){
                        tipoMetal = 0;
                        tipoElectro = 0;
                        tipoAuto++;
                    }

                    if(tipoMetal==1){
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> Metal </td>' +
                            '</tr>';
                    }else if (tipoElectro==1){
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> Electrónicos </td>' +
                            '</tr>';
                    }else if (tipoAuto == 1){
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
function cargarRptRefrendo(fechaIni,fechaFin) {
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
                    var SubTotal = 0;
                    var Total = 0;
                    FORMU = Number(FORMU)
                    INTERESES = Number(INTERESES);
                    ALMACENAJE = Number(ALMACENAJE);
                    SEGURO = Number(SEGURO);
                    ABONO = Number(ABONO);
                    COSTO = Number(COSTO);
                    DESCU = Number(DESCU);
                    IVA = Number(IVA);
                    SubTotal = INTERESES + ALMACENAJE + SEGURO + ABONO + COSTO;
                    SubTotal = SubTotal - DESCU;
                    Total = SubTotal + IVA;
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
                    if(FORMU==1){
                        tipoMetal++;
                    }else if (FORMU==2){
                        tipoMetal = 0;
                        tipoElectro++;
                    }else if (FORMU==3){
                        tipoMetal = 0;
                        tipoElectro = 0;
                        tipoAuto++;
                    }

                    if(tipoMetal==1){
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> Metal </td>' +
                            '</tr>';
                    }else if (tipoElectro==1){
                        html +=
                            '<tr>' +
                            '<td colspan="14" style="background: dodgerblue; color:white;"> Electrónicos </td>' +
                            '</tr>';
                    }else if (tipoAuto == 1){
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

