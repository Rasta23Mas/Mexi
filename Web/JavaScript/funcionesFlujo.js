var checkCentral = 0;
var errorToken = 0;
var tokenmovimientoGlo = 0;

function generarFolio() {
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Flujo/generarFolio.php',
        success: function (respuesta) {
            if(respuesta>0){
                document.getElementById('idFolio').innerHTML = respuesta;
                buscarTotales();
            }else {
                alertify.error("Error al conectar con el servidor");
            }
        }
    });
}

function buscarTotales() {
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Flujo/busquedaFlujo.php',
        dataType: "json",
        success: function (datos) {
            var i = 0;
            if(datos.length>0){
                var saldoCentral = 0;
                var saldoBancos = 0;
                var saldoBoveda = 0;
                for (i; i < datos.length; i++) {
                    //var id_flujototal = datos[i].id_flujototal;
                    var id_flujoAgente = datos[i].id_flujoAgente;
                    var importe = datos[i].importe;
                    var sucursal = datos[i].sucursal;
                    var sucursalSesion = datos[i].sucursalSesion;

                    if(id_flujoAgente==1){
                        saldoCentral = importe;
                    }else if(id_flujoAgente==2){
                        saldoBancos = importe;
                    }else if(id_flujoAgente==3 && sucursal==sucursalSesion){
                        saldoBoveda = importe;
                    }
                }

                $("#idSaldoCentralVal").val(saldoCentral);
                $("#idSaldoBancosVal").val(saldoBancos);
                $("#idSaldoBovedaVal").val(saldoBoveda);
                saldoBancos = formatoMoneda(saldoBancos);
                saldoBoveda = formatoMoneda(saldoBoveda);
                document.getElementById('idSaldoBancos').innerHTML = saldoBancos;
                document.getElementById('idSaldoBoveda').innerHTML =saldoBoveda;
            } else {
                alertify.error("No hay saldos iniciales.")
            }
        }
    });
}

function validaCajaUsuario() {
    var idUsuarioCaja = $("#idUsuarioCaja").val();

    var dataEnviar = {
        "idUsuarioCaja": idUsuarioCaja,
    };
    $.ajax({
        data: dataEnviar,
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Flujo/validaCaja.php',
        success: function (retorna) {
            if (retorna == 2) {
                    alert("El usuario ya ha realizado el cierre de caja.");
                location.reload();
            } else {
                saldoCajaUsuario();
            }
        }
    });
}

function saldoCajaUsuario() {
    var idUsuarioCaja = $("#idUsuarioCaja").val();

    var dataEnviar = {
        "idUsuarioCaja": idUsuarioCaja,
    };
    $.ajax({
        data: dataEnviar,
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Flujo/busquedaCajaDot.php',
        dataType: "json",
        success: function (datos) {
            var i = 0;
            if(datos.length>0){
                var importe= 0;
                for (i; i < datos.length; i++) {
                     importe = datos[i].importe;
                }
                $("#idSaldoCajaVal").val(importe);
            } else {
                alertify.error("El usuario no tiene asignada una caja.");
                $("#idSaldoCajaVal").val(0);
            }
        }
    });
}

function clickCentral() {
    checkCentral = $('input:radio[name=central]:checked').val();
    if(checkCentral==5||checkCentral==6){
        $("#idUsuarioCaja").prop('disabled', false);
    }else{
        $("#idUsuarioCaja").prop('disabled', true);
    }
    $("#idUsuarioCaja").val(0);
    $("#idSaldoCajaVal").val('');
}

function aceptarCentral() {
    if(checkCentral!==0){
        var tipoUsuario = $("#idTipoUsuario").val();
        tipoUsuario = Number(tipoUsuario);
        if(tipoUsuario==4){
            alert("El usuario no tiene privilegios, para realizar las operaciones.")
            location.href='../Empeno/vInicio.php';
        }else{
            var importe = $("#importeMovimientoCentral").val();
            importe = Number(importe);

            if(importe==0){
                alert("Por favor, ingresa un importe.");
            }else{
                var saldoCentral = $("#idSaldoCentralVal").val();
                var saldoBanco = $("#idSaldoBancosVal").val();
                var saldoBoveda = $("#idSaldoBovedaVal").val();
                var idUsuarioCaja = $("#idUsuarioCaja").val();
                var saldoCaja = $("#idSaldoCajaVal").val();
                saldoCentral = Number(saldoCentral);
                saldoBanco = Number(saldoBanco);
                saldoBoveda = Number(saldoBoveda);
                idUsuarioCaja = Number(idUsuarioCaja);
                var pideToken = 0;

                var validate = true;
                var cat_token_movimiento = 0;
                if(checkCentral==1){
                    cat_token_movimiento = 3;
                    pideToken =1;
                    if(importe>saldoCentral){
                        alert("El importe no puede ser mayor al Saldo de Central.");
                        validate = false;
                    }
                }else if(checkCentral==2){
                    cat_token_movimiento = 4;
                    pideToken =1;
                    if(importe>saldoBanco){
                        alert("El importe no puede ser mayor al Saldo de Bancos.");
                        validate = false;
                    }
                }else if(checkCentral==3){
                    cat_token_movimiento = 5;
                    pideToken =1;
                    if(importe>saldoBanco){
                        alert("El importe no puede ser mayor al Saldo de Bancos.");
                        validate = false;
                    }
                }else if(checkCentral==4){
                    cat_token_movimiento = 6;
                    pideToken =1;
                    if(importe>saldoBoveda){
                        alert("El importe no puede ser mayor al Saldo de Bóveda.");
                        validate = false;
                    }
                }else if(checkCentral==5){
                    if(importe>saldoBoveda){
                        alert("El importe no puede ser mayor al Saldo de Bóveda.");
                        validate = false;
                    }
                    if(idUsuarioCaja==0){
                        alert("Seleccione un vendedor.");
                        validate = false;
                    }
                }else if(checkCentral==6){
                  /*  if (importe > saldoCaja) {
                        alert("El importe no puede ser mayor al Saldo de la Caja.");
                        validate = false;
                    }*/
                    if(idUsuarioCaja==0){
                        alert("Seleccione un vendedor.");
                        validate = false;
                    }
                }
                if(validate){

                    if(tipoUsuario==3){
                        if(pideToken ==1){
                            tokenmovimientoGlo = cat_token_movimiento;
                            $("#modalFlujo").modal();
                        }else{
                            guardarFlujoTotales(importe)

                        }

                    } else{
                        guardarFlujoTotales(importe)
                    }
                }
            }
        }
    }else{
        alert("Selecciona un movimiento de flujo.");
    }
}

function tokenFlujo() {
    var tokenDes = $("#idCodigoAut").val();
    var idFolio = $("#idFolio").text();
    var importe = $("#importeMovimientoCentral").val();
    var dataEnviar = {
            "tokenDes": tokenDes,
            "idFolio": idFolio,
            "importe": importe,
            "cat_token_movimiento": tokenmovimientoGlo,

        };
        $.ajax({
            data: dataEnviar,
            url: '../../../com.Mexicash/Controlador/Token/TokenFlujo.php',
            type: 'post',
            success: function (response) {
                if (response > 0) {
                    var token = response;
                    if (token > 30) {
                        alert("Los Token se estan terminando, favor de avisar al administrador");
                    }
                    alertify.success("Código correcto.");
                    guardarFlujoTotales(importe);
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

function guardarFlujoTotales(importe) {
    importe = Number(importe);
    var saldoCentral = $("#idSaldoCentralVal").val();
    var saldoBanco = $("#idSaldoBancosVal").val();
    var saldoBoveda = $("#idSaldoBovedaVal").val();
    var saldoCaja = $("#idSaldoCajaVal").val();
    var idUsuarioCaja = $("#idUsuarioCaja").val();
    saldoCentral = Number(saldoCentral);
    saldoBanco = Number(saldoBanco);
    saldoBoveda = Number(saldoBoveda);
    saldoCaja = Number(saldoCaja);

    var saldoCentralFinal = 0;
    var saldoBancoFinal = 0;
    var saldoBovedaFinal = 0;
    var saldoCajaFinal = 0;



    if(checkCentral==1){
        //CENTRAL A BANCOS
        saldoCentralFinal = saldoCentral - importe;
        saldoBancoFinal = saldoBanco + importe;
        saldoCentralFinal = Math.round(saldoCentralFinal * 100) / 100;
        saldoBancoFinal = Math.round(saldoBancoFinal * 100) / 100;
        saldoBovedaFinal = saldoBoveda;
    }else if(checkCentral==2){
        //BANCOS A CENTRAL
        saldoBancoFinal = saldoBanco - importe;
        saldoCentralFinal = saldoCentral + importe;
        saldoCentralFinal = Math.round(saldoCentralFinal * 100) / 100;
        saldoBancoFinal = Math.round(saldoBancoFinal * 100) / 100;
        saldoBovedaFinal = saldoBoveda;
    }else if(checkCentral==3){
        //BANCOS A BOVEDA
        saldoCentralFinal = saldoCentral;
        saldoBancoFinal = saldoBanco - importe;
        saldoBovedaFinal = saldoBoveda + importe;
        saldoBancoFinal = Math.round(saldoBancoFinal * 100) / 100;
        saldoBovedaFinal = Math.round(saldoBovedaFinal * 100) / 100;

    }else if(checkCentral==4){
        //BOVEDA A BANCO
        saldoCentralFinal = saldoCentral;
        saldoBancoFinal = saldoBanco + importe;
        saldoBovedaFinal = saldoBoveda - importe;
        saldoBancoFinal = Math.round(saldoBancoFinal * 100) / 100;
        saldoBovedaFinal = Math.round(saldoBovedaFinal * 100) / 100;
    }else if(checkCentral==5){
        //BOVEDA A CAJA
        saldoCentralFinal = saldoCentral;
        saldoBancoFinal = saldoBanco;
        saldoBovedaFinal = saldoBoveda - importe;
        saldoCajaFinal = saldoCaja + importe;
        saldoBovedaFinal = Math.round(saldoBovedaFinal * 100) / 100;
        saldoCajaFinal = Math.round(saldoCajaFinal * 100) / 100;
        fnCierreCajaIndispensable(1,idUsuarioCaja,1);

    }else if(checkCentral==6){
        //CAJA A BOVEDA
        saldoCentralFinal = saldoCentral;
        saldoBancoFinal = saldoBanco ;
        saldoBovedaFinal = saldoBoveda + importe;
        saldoCajaFinal = saldoCaja - importe;
        saldoBovedaFinal = Math.round(saldoBovedaFinal * 100) / 100;
        saldoCajaFinal = Math.round(saldoCajaFinal * 100) / 100;
    }

    var dataEnviar = {
        "saldoCentralFinal": saldoCentralFinal,
        "saldoBancoFinal": saldoBancoFinal,
        "saldoBovedaFinal": saldoBovedaFinal,
        "saldoCajaFinal": saldoCajaFinal,
        "idUsuarioCaja": idUsuarioCaja,

    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Flujo/guardarFlujoTotales.php',
        type: 'post',
        success: function (response) {
            if (response > 0) {
                alertify.success("Totales guardados correctamente.");
                guardarFlujo(importe);
            } else {
                    alertify.error("Error al guardar los totales.");
            }
        },
    })

}

function guardarFlujo(importe) {

    importe = Number(importe);
    var idFolio = $("#idFolio").text();
    var concepto = $("#idConcepto").val();
    var usuarioCaja = $("#idUsuarioCaja").val();
    var importeLetra = NumeroALetras(importe);

    var dataEnviar = {
        "id_catFlujo": checkCentral,
        "importe": importe,
        "idFolio": idFolio,
        "concepto": concepto,
        "usuarioCaja": usuarioCaja,
        "importeLetra": importeLetra,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Flujo/guardarFlujo.php',
        type: 'post',
        success: function (response) {
            if (response > 0) {
                alert("Movimiento guardado.");
                setTimeout(function(){  cargarPDFDepositaria(idFolio); }, 2000);
                setTimeout(function(){ location.reload() }, 3000);
            } else {
                alertify.error("Error al guardar el movimiento.");
            }
        },
    })
}

/*function cargarPDFDepositaria(idFolio) {
    //ANterior para visualizar
    window.open('../PDF/callPdfFlujo.php?folio=' + idFolio);
}*/

function cargarPDFDepositaria(idFolio) {
    window.open('../PDF/callPdfFlujo.php?pdf=1&folio=' + idFolio);
}

function buscarFolio() {
    var idFolioBuscar = $("#idFolioBuscar").val();

    var dataEnviar = {
        "idFolioBuscar": idFolioBuscar,

    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Flujo/busquedaFolio.php',
        type: 'post',
        dataType: "json",
        success: function (datos) {
            if(datos.length>0){
                cargarPDFDepositaria(idFolioBuscar);
            } else {
               alert("No se encontró ningún folio.")
            }
        },
    })

}
