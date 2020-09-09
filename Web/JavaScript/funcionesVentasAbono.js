var errorToken = 0;

var id_ClienteGlb = 0;
//ABONO 23
var tipo_movimientoGlb = 0;
var sucursalGlb = 0;
var idBazarGlb = 0;
var ivaGlb = 0;
var apartadoGlb = 0;


function nombreAutocompletarAbono() {
    $('#idNombreVenta').on('keyup', function () {
        var key = $('#idNombreVenta').val();
        var dataEnviar = {
            "idNombres": key
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Cliente/AutocompleteClienteAbono.php',
            data: dataEnviar,
            success: function (data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestionsNombreVenta').fadeIn(1000).html(data);
                //Al hacer click en alguna de las sugerencias
                $('.suggest-element').on('click', function () {
                    //Obtenemos la id unica de la sugerencia pulsada
                    var id = $(this).attr('id');
                    id_ClienteGlb = id;
                    $('#idNombreVenta').val($('#' + id).attr('data'));
                    //Hacemos desaparecer el resto de sugerencias
                    $('#suggestionsNombreVenta').fadeOut(1000);
                    $("#idNombreVenta").prop('disabled', true);
                    busquedaClienteBazar()
                    return false;
                });
            }
        });
    });
}

function busquedaClienteBazar() {
    var dataEnviar = {
        "id_ClienteGlb": id_ClienteGlb,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Ventas/busquedaClienteAbono.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            if (datos.length > 0) {
                var html = '';
                var i = 0;
                for (i; i < datos.length; i++) {
                    var id_Bazar = datos[i].id_Bazar;
                    var apartado = datos[i].apartado;
                    var descripcionCorta = datos[i].descripcionCorta;
                    var observaciones = datos[i].observaciones;
                    var articulo = descripcionCorta + " " + observaciones;

                    html += '<tr>' +
                        '<td>' + id_Bazar + '</td>' +
                        '<td>' + articulo + '</td>' +
                        '<td align="center">' +
                        '<img src="../../style/Img/seleccionarNor.png"  ' +
                        'alt="Seleccionar"  ' +
                        'onclick="busquedaAbonos(' + id_Bazar +')">' +
                        '</td>' +
                        '</tr>';
                }
                $('#idTBodyApartado').html(html);
                $("#btnAbono").prop('disabled', false);
            } else {
                alertify.error("No se encontro articulo apartado.");
            }
        }
    });
}

function busquedaAbonos(id_Bazar) {
    var dataEnviar = {
        "id_Bazar": id_Bazar,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Ventas/busquedaAbonos.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var abonoTotal = 0;
            var tablaAbono = 0;
            var fechaAbono = "";
            var prestamoVenta = "";
            if (datos.length > 0) {
                var html = '';
                var i = 0;
                for (i; i < datos.length; i++) {

                    var fecha_Creacion = datos[i].fecha_Creacion;
                    var subTotal = datos[i].subTotal;
                    ivaGlb = datos[i].ivaAbono;
                    var total = datos[i].total;

                    var tipo_movimiento = datos[i].tipo_movimientoAbono;
                    var faltaPagar = datos[i].faltaPagar;
                    apartadoGlb = Math.floor(apartadoGlb * 100) / 100;
                    subTotal = Math.floor(subTotal * 100) / 100;
                    faltaPagar = Math.floor(faltaPagar * 100) / 100;

                    if (tipo_movimiento == 22 ) {
                        apartadoGlb = datos[i].apartadoAbono;
                        var apartadoTabla = formatoMoneda(apartadoGlb);
                        var saldoTabla = formatoMoneda(faltaPagar);
                        html += '<tr>' +
                            '<td>' + fecha_Creacion + '</td>' +
                            '<td align="right">' + apartadoTabla + '</td>' +
                            '<td align="right">' + saldoTabla + '</td>' +
                            '</tr>';

                    } else if (tipo_movimiento == 23) {
                        var abono = datos[i].abonoAbono;
                        abono = Math.floor(abono * 100) / 100;

                        abonoTotal += abono;
                        fechaAbono = fecha_Creacion;
                        tablaAbono++;
                        var abonoTabla = formatoMoneda(abono);
                        var saldoTabla = formatoMoneda(faltaPagar);
                        html += '<tr>' +
                            '<td>' + fecha_Creacion + '</td>' +
                            '<td align="right">' + abonoTabla + '</td>' +
                            '<td align="right">' + saldoTabla + '</td>' +
                            '</tr>';
                    }

                }

                if (tablaAbono == 0) {
                    html += '<tr>' +
                        '<td colspan="3" align="center"> <label>Sin abonos para mostrar.</label></td>' +
                        '</tr>';
                }

                abonoTotal = Math.floor(abonoTotal * 100) / 100;

                $("#idFolioBazar").val(id_Bazar);
                $("#idTotalApartadoValue").val(apartadoGlb);
                $("#idTotalAbonadoValue").val(abonoTotal);
                $("#idUltimoSaldoValue").val(faltaPagar);
                $("#idPrestamoVenta").val(prestamoVenta);
                var apartadoFormat = formatoMoneda(apartadoGlb);
                var abonoFormat = formatoMoneda(abonoTotal);
                var ultimoSaldoFormat = formatoMoneda(faltaPagar);
                $("#idTotalApartado").val(apartadoFormat);
                $("#idTotalAbonado").val(abonoFormat);
                $("#idUltimoSaldo").val(ultimoSaldoFormat);
                fechaAbono = fechaFormato(fechaAbono)
                $("#fechaAbono").val(fechaAbono);
                $("#idImporteAbono").prop('disabled', false);

                $('#idTBodyAbono').html(html);
            } else {
                alertify.warning("No se encontro ningún abono para el artículo");
            }

        }
    });
}

function nuevoAbono(e) {
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

        var ultimoSaldo = $("#idUltimoSaldoValue").val();
        var abono = $("#idImporteAbono").val();

        ultimoSaldo = Math.floor(ultimoSaldo * 100) / 100;
        abono = Math.floor(abono * 100) / 100;

        if(abono==0||abono==""){
            alertify.warning("Por favor capturar el abono.");

        }else{
            if (ultimoSaldo > abono) {
                var nuevoSaldo = ultimoSaldo - abono;
                nuevoSaldo = Math.floor(nuevoSaldo * 100) / 100;
                $("#idEfectivo").val("");
                $("#idCambio").val("");

                $("#idImporteAbonoValue").val(abono);
                $("#idNuevoSaldoValue").val(nuevoSaldo);

                var abonoFormat = formatoMoneda(abono);
                var nuevoSaldoFormat = formatoMoneda(nuevoSaldo);

                $("#idImporteAbono").val(abonoFormat);
                $("#idNuevoSaldo").val(nuevoSaldoFormat);
                $("#idTotalPagar").val(abonoFormat);
                $("#idImporteAbono").prop('disabled', true);
                $("#idEfectivo").prop('disabled', false);
                tipo_movimientoGlb = 23;

            } else if(ultimoSaldo == abono){
                var nuevoSaldo = 0;
                nuevoSaldo = Math.floor(nuevoSaldo * 100) / 100;
                $("#idEfectivo").val("");
                $("#idCambio").val("");

                $("#idImporteAbonoValue").val(abono);
                $("#idNuevoSaldoValue").val(nuevoSaldo);

                var abonoFormat = formatoMoneda(abono);
                var nuevoSaldoFormat = formatoMoneda(nuevoSaldo);

                $("#idImporteAbono").val(abonoFormat);
                $("#idNuevoSaldo").val(nuevoSaldoFormat);
                $("#idTotalPagar").val(abonoFormat);
                $("#idImporteAbono").prop('disabled', true);
                $("#idEfectivo").prop('disabled', false);
                tipo_movimientoGlb = 6;
            } else {
                alert("El abono tiene que ser menor al total.");
            }
        }


    }
    return patron.test(te);
}

function efectivoAbono(e) {
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

        var abono = $("#idImporteAbonoValue").val();
        var efectivo = $("#idEfectivo").val();

        abono = Math.floor(abono * 100) / 100;
        efectivo = Math.floor(efectivo * 100) / 100;

        if (efectivo < abono) {
            alert("El efectivo no puede ser menor que el abono a pagar.")
        } else {
            $("#idEfectivo").val("");
            $("#idCambio").val("");
            $("#idEfectivoValue").val("");
            $("#idCambioValue").val("");
            var cambio = efectivo - abono;
            cambio = Math.floor(cambio * 100) / 100;

            $("#idEfectivoValue").val(efectivo);
            $("#idCambioValue").val(cambio);
            cambio = formatoMoneda(cambio);
            efectivo = formatoMoneda(efectivo);
            $("#idCambio").val(cambio);
            $("#idEfectivo").val(efectivo);
            $("#idEfectivo").prop('disabled', true);
        }
    }
    return patron.test(te);
}

function cancelarVentaAbono() {
    location.reload();
}

function guardarAbono() {
    var abono = $("#idImporteAbonoValue").val();
    if (abono == 0) {
        alert("Debe calcular el abono.");
    } else {
        var efectivo = $("#idEfectivoValue").val();
        if (efectivo == 0) {
            alert("Debe calcular el cambio del cliente.");
        } else {
            var nuevoSaldo = $("#idNuevoSaldoValue").val();
            var abonoAnterior = $("#idTotalAbonadoValue").val();
            var efectivo = $("#idEfectivoValue").val();
            var cambio = $("#idCambioValue").val();
            var id_Bazar = $("#idFolioBazar").val();
            abonoAnterior = Math.floor(abonoAnterior * 100) / 100;
            abono = Math.floor(abono * 100) / 100;
            var abonoTotal = abonoAnterior + abono;
            abonoTotal = Math.floor(abonoTotal * 100) / 100;
            var dataEnviar = {
                "tipo_movimiento": tipo_movimientoGlb,
                "efectivo": efectivo,
                "cambio": cambio,
                "id_Cliente": id_ClienteGlb,
                "idBazar": id_Bazar,
                "faltaPagar": nuevoSaldo,
                "abono": abono,
                "abono_Total": abonoTotal,
            };

            $.ajax({
                data: dataEnviar,
                url: '../../../com.Mexicash/Controlador/Ventas/GuardarAbono.php',
                type: 'post',
                success: function (response) {
                    alert(response)
                    if (response > 0) {
                        idBazarGlb = response;
                        ArticulosUpdateVenta(id_Bazar);
                    } else {
                        alertify.error("Error al guardar el abono");
                    }
                },
            })
        }
    }

}


function ArticulosUpdateVenta(id_Bazar) {
    var dataEnviar = {
        "idBazar": id_Bazar,
        "tipo_movimiento": tipo_movimientoGlb,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Ventas/UpdateArticulos.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                alertify.success("Artículos actualizados correctamente.")
                fnBitacoraAbonos();
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
        }
    });
}

function fnBitacoraAbonos() {
    alert("llega")
    var dataEnviar = {
        "id_Movimiento": tipo_movimientoGlb,
        "id_bazar": idBazarGlb,
        "id_cliente": id_ClienteGlb,
        "id_vendedor": 0,
        "idToken": 0,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Bitacora/ConBitacoraVentas.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                verPDFAbono(idBazarGlb);
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
        }
    });
}

//Generar PDF
function verPDFAbono(idBazar) {
    if(tipo_movimientoGlb==23){
        window.open('../PDF/callPdfAbono.php?pdf=1&idBazar=' + idBazar);
    }else if(tipo_movimientoGlb==6){
        window.open('../PDF/callPdfVentaAbono.php?pdf=1&idBazar=' + idBazar);
    }
    alert("Abono realizado");
    $("#idFormAbonos")[0].reset();
    $("#divTablaAbono").load('tablaAbono.php');
    $("#divTablaApartado").load('tablaApartados.php');
    $("#idNombreVenta").prop('disabled', false);
}

function configurarRango() {
    alert("configuración")
}
