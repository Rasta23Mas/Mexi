function SeleccionarInteres(tipoInteresValue,tipoFormulario) {
    if (tipoInteresValue !== "null" || tipoInteresValue !== 0) {
        var dataEnviar = {
            "tipoInteresValue": tipoInteresValue
        };
        $.ajax({
            data: dataEnviar,
            url: '../../../com.Mexicash/Controlador/Intereses/ConIntereses.php',
            type: 'post',
            dataType: "json",
            success: function (response) {
                if (response.status == 'ok') {
                    document.getElementById('idTipoInteres').innerHTML = response.result.tipoInteres;
                    document.getElementById('idPeriodo').innerHTML = response.result.periodo;
                    var diasPeriodo = response.result.dias;
                    diasPeriodo = parseInt(diasPeriodo);
                    var sumarMes = sumarDias(diasPeriodo);
                    $("#diasInteres").val(diasPeriodo);
                    document.getElementById('idFecVencimiento').innerHTML = sumarMes;
                    document.getElementById('idPlazo').innerHTML = response.result.plazo;
                    document.getElementById('idTasaPorcen').innerHTML = response.result.tasa;
                    document.getElementById('idAlmPorcen').innerHTML = response.result.alm;
                    document.getElementById('idSeguroPorcen').innerHTML = response.result.seguro;
                    document.getElementById('idIvaPorcen').innerHTML = response.result.iva ;
                    limpiarTablaInteres();
                    llenarAforoAvaluo(tipoFormulario);
                   llenarMontoToken();
                    $("#divTablaMetales").load('tablaMetales.php');
                    $("#divTablaArticulos").load('tablaArticulos.php');
                    calcularDias()
                    $("#idDiasAlmoneda").prop('disabled', false);
                }
            },
        })
    }
}

function llenarAforoAvaluo(tipoFormulario) {
    var dataEnviar = {
        "idTipoFormulario": tipoFormulario
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Articulos/Aforo.php',
        type: 'post',
        dataType: "json",
        success: function (response) {
            if (response.status == 'ok') {
                var porcentajeAforo = response.result.Porcentaje;
                $("#idAforo").val(porcentajeAforo);
            }
        },
    })


}


function llenarMontoToken() {
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Articulos/MontoToken.php',
        type: 'post',
        dataType: "json",
        success: function (response) {
            if (response.status == 'ok') {
                var Monto = response.result.Monto;
                $("#idMontoToken").val(Monto);
            }
        },
    })
}
function limpiarTablaInteres() {
    $.ajax({
        url: '../../../com.Mexicash/Controlador/ArticulosObsoletos.php',
        type: 'post',
        success: function (response) {
            if (response == -1 || response == 0) {
                alertify.error("Error 0001.");
            } else {
                alertify.warning("Se limpio tabla por modificar el tipo de interes.");
            }
        },
    })
}

function fnLlenarCmbInteres(tipoCombo) {
    var dataEnviar = {
        "idTipoCombo": tipoCombo
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/comboInteres.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var html = "";
            html += " <option value=0>Seleccione:</option>"
            var i = 0;
            for (i; i < datos.length; i++) {
                var id_interes = datos[i].id_interes;
                var tasa_interes = datos[i].tasa_interes;
                html += '<option value=' + id_interes + '>' + tasa_interes + '</option>';
            }
            $('#tipoInteresEmpeno').html(html);
        }
    });
}

function LimpiarInteres() {
    document.getElementById('idTipoInteres').innerHTML = '';
    document.getElementById('idPeriodo').innerHTML =  '';
    document.getElementById('idFecVencimiento').innerHTML = '';
    document.getElementById('idPlazo').innerHTML= '';
    document.getElementById('idTasaPorcen').innerHTML = '';
    document.getElementById('idAlmPorcen').innerHTML= '';
    document.getElementById('idSeguroPorcen').innerHTML = '';
    document.getElementById('idIvaPorcen').innerHTML= '';
    $("#idTotalAvaluo").val('0.00');
    $("#idTotalPrestamo").val('0.00');
}

function calcularDias() {

    var diasAlm =  $('select[name="diasAlmName"] option:selected').text();
    var diasPeriodo =$("#diasInteres").val();
    diasAlm = parseInt(diasAlm);
    diasPeriodo = parseInt(diasPeriodo);
    diasAlm = diasAlm + diasPeriodo;
    var sumarAlm = sumarDias(diasAlm);
    $("#idFechaAlm").val(sumarAlm);
    $("#idDiasAlmoneda").prop('disabled', true);
}