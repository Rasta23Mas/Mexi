var totalArqueoGlobal;
var totalArqueoBilletes;
var totalArqueoMonedas;
var calculado = 0;
//Cantidades
var idMilCantGlobal = 0;
var idQuinientosCantGlobal = 0;
var idDoscientosCantGlobal = 0;
var idCienCantGlobal = 0;
var idCincuentaCantGlobal = 0;
var idVeinteCantGlobal = 0;
var idVeinteMonCantGlobal = 0;
var idDiezCantGlobal = 0;
var idCincoCantGlobal = 0;
var idDosCantGlobal = 0;
var idUnoCantGlobal = 0;
var idCincuentaCCantGlobal = 0;
var idCentavosCantGlobal = 0;
//Moneda
var idMilGlobal = 0;
var idQuinientosGlobal = 0;
var idDoscientosGlobal = 0;
var idCienGlobal = 0;
var idCincuentaGlobal = 0;
var idVeinteGlobal = 0;
var idVeinteMonGlobal = 0;
var idDiezGlobal = 0;
var idCincoGlobal = 0;
var idDosGlobal = 0;
var idUnoGlobal = 0;
var idCincuentaCGlobal = 0;
var idCentavosGlobal = 0;

var guardadoPorGerenteGlb = 0;
var ajustesGbl = 0;
var incrementoPatGbl = 0;
var idArqueoGbl = 0;
var diferenciaGbl = 0;


//GUARDAR BIT_CIERRE CAJA
var bitCant_Dotacion_glb = 0;
var bitCant_Retiro_glb = 0;
var bitDotacion_glb = 0;
var bitRetiro_glb = 0;

var totalEntradaNew_glb = 0;
var totalSalidasNew_glb = 0;

function arqueo() {
    calculado = 1;
    var idMilCant = $("#idMilCant").val();
    var idQuinientosCant = $("#idQuinientosCant").val();
    var idDoscientosCant = $("#idDoscientosCant").val();
    var idCienCant = $("#idCienCant").val();
    var idCincuentaCant = $("#idCincuentaCant").val();
    var idVeinteCant = $("#idVeinteCant").val();
    var idVeinteMonCant = $("#idVeinteMonCant").val();
    var idDiezCant = $("#idDiezCant").val();
    var idCincoCant = $("#idCincoCant").val();
    var idDosCant = $("#idDosCant").val();
    var idUnoCant = $("#idUnoCant").val();
    var idCincuentaCCant = $("#idCincuentaCCant").val();
    var idCentavosCant = $("#idCentavosCant").val();


    if (idMilCant == "") {
        idMilCant = 0;
    }
    if (idQuinientosCant == "") {
        idQuinientosCant = 0;
    }
    if (idDoscientosCant == "") {
        idDoscientosCant = 0;
    }
    if (idCienCant == "") {
        idCienCant = 0;
    }
    if (idCincuentaCant == "") {
        idCincuentaCant = 0;
    }
    if (idVeinteCant == "") {
        idVeinteCant = 0;
    }
    if (idVeinteMonCant == "") {
        idVeinteMonCant = 0;
    }
    if (idDiezCant == "") {
        idDiezCant = 0;
    }
    if (idCincoCant == "") {
        idCincoCant = 0;
    }
    if (idDosCant == "") {
        idDosCant = 0;
    }
    if (idUnoCant == "") {
        idUnoCant = 0;
    }
    if (idCincuentaCCant == "") {
        idCincuentaCCant = 0;
    }
    if (idCentavosCant == "") {
        idCentavosCant = 0;
    }

    idMilCant = parseInt(idMilCant);
    idQuinientosCant = parseInt(idQuinientosCant);
    idDoscientosCant = parseInt(idDoscientosCant);
    idCienCant = parseInt(idCienCant);
    idCincuentaCant = parseInt(idCincuentaCant);
    idVeinteCant = parseInt(idVeinteCant);
    idVeinteMonCant = parseInt(idVeinteMonCant);
    idDiezCant = parseInt(idDiezCant);
    idCincoCant = parseInt(idCincoCant);
    idDosCant = parseInt(idDosCant);
    idUnoCant = parseInt(idUnoCant);
    idCincuentaCCant = parseFloat(idCincuentaCCant);
    idCentavosCant = parseFloat(idCentavosCant);

    idMilCantGlobal = idMilCant;
    idQuinientosCantGlobal = idQuinientosCant;
    idDoscientosCantGlobal = idDoscientosCant;
    idCienCantGlobal = idCienCant;
    idCincuentaCantGlobal = idCincuentaCant;
    idVeinteCantGlobal = idVeinteCant;
    idVeinteMonCantGlobal = idVeinteMonCant;
    idDiezCantGlobal = idDiezCant;
    idCincoCantGlobal = idCincoCant;
    idDosCantGlobal = idDosCant;
    idUnoCantGlobal = idUnoCant;
    idCincuentaCCantGlobal = idCincuentaCCant;
    idCentavosCantGlobal = idCentavosCant;


    idMilCant = 1000 * idMilCant;
    idQuinientosCant = 500 * idQuinientosCant;
    idDoscientosCant = 200 * idDoscientosCant;
    idCienCant = 100 * idCienCant;
    idCincuentaCant = 50 * idCincuentaCant;
    idVeinteCant = 20 * idVeinteCant;
    idVeinteMonCant = 20 * idVeinteMonCant;
    idDiezCant = 10 * idDiezCant;
    idCincoCant = 5 * idCincoCant;
    idDosCant = 2 * idDosCant;
    idUnoCant = idUnoCant;
    idCincuentaCCant = .50 * idCincuentaCCant;
    idCentavosCant = .01 * idCentavosCant;

    idMilGlobal = idMilCant;
    idQuinientosGlobal = idQuinientosCant;
    idDoscientosGlobal = idDoscientosCant;
    idCienGlobal = idCienCant;
    idCincuentaGlobal = idCincuentaCant;
    idVeinteGlobal = idVeinteCant;
    idVeinteMonGlobal = idVeinteMonCant;
    idDiezGlobal = idDiezCant;
    idCincoGlobal = idCincoCant;
    idDosGlobal = idDosCant;
    idUnoGlobal = idUnoCant;
    idCincuentaCGlobal = idCincuentaCCant;
    idCentavosGlobal = idCentavosCant;


    var totalBillletes = idMilCant + idQuinientosCant + idDoscientosCant + idCienCant + idCincuentaCant + idVeinteCant;
    var totalMonedas = idVeinteMonCant + idDiezCant + idCincoCant + idDosCant + idUnoCant + idCincuentaCCant + idCentavosCant;
    var totalCaja = totalBillletes + totalMonedas;

    totalArqueoBilletes = totalBillletes;
    totalArqueoMonedas = totalMonedas;
    totalArqueoGlobal = totalCaja;

    idMilCant = formatoMoneda(idMilCant);
    idQuinientosCant = formatoMoneda(idQuinientosCant);
    idDoscientosCant = formatoMoneda(idDoscientosCant);
    idCienCant = formatoMoneda(idCienCant);
    idCincuentaCant = formatoMoneda(idCincuentaCant);
    idVeinteCant = formatoMoneda(idVeinteCant);
    idVeinteMonCant = formatoMoneda(idVeinteMonCant);
    idDiezCant = formatoMoneda(idDiezCant);
    idCincoCant = formatoMoneda(idCincoCant);
    idDosCant = formatoMoneda(idDosCant);
    idUnoCant = formatoMoneda(idUnoCant);
    idCincuentaCCant = formatoMoneda(idCincuentaCCant);
    idCentavosCant = formatoMoneda(idCentavosCant);

    totalBillletes = formatoMoneda(totalBillletes);
    totalMonedas = formatoMoneda(totalMonedas);
    totalCaja = formatoMoneda(totalCaja);


    document.getElementById('lblMil').innerHTML = idMilCant;
    document.getElementById('lblQuinientos').innerHTML = idQuinientosCant;
    document.getElementById('lblDoscientos').innerHTML = idDoscientosCant;
    document.getElementById('lblCien').innerHTML = idCienCant;
    document.getElementById('lblCincuenta').innerHTML = idCincuentaCant;
    document.getElementById('lblVeinte').innerHTML = idVeinteCant;
    document.getElementById('lblVeinteMon').innerHTML = idVeinteMonCant;
    document.getElementById('lblDiez').innerHTML = idDiezCant;
    document.getElementById('lblCinco').innerHTML = idCincoCant;
    document.getElementById('lblDos').innerHTML = idDosCant;
    document.getElementById('lblUno').innerHTML = idUnoCant;
    document.getElementById('lblCincuentaC').innerHTML = idCincuentaCCant;
    document.getElementById('lblCentavos').innerHTML = idCentavosCant;
    document.getElementById('lblTotalBilletes').innerHTML = totalBillletes;
    document.getElementById('lblTotalMonedas').innerHTML = totalMonedas;
    document.getElementById('lblTotalArqueo').innerHTML = totalCaja;
    validarAjustes();
}

function confirmarGuardarCaja() {
    var usuarioCaja = $("#idUsuarioCaja").val();
    var TotCajaNew = $("#idTotCajaNew").val();
    diferenciaGbl = totalArqueoGlobal - TotCajaNew;
    diferenciaGbl = Math.round(diferenciaGbl * 100) / 100;
    var diferencia = "";
    if (calculado == 0) {
        alert("Debe calcular el arqueo.");
    } else {
        if (usuarioCaja == null || usuarioCaja == "") {
            alert("Debe seleccionar el usuario para el arqueo.");
        } else {
            var tipoDiferencia = "";
            if (diferenciaGbl < 0) {
                diferencia =  diferenciaGbl * -1;
                diferencia = Math.round(diferencia * 100) / 100;
                tipoDiferencia = "Se debe realizar un ajuste por la cantidad de: $" +diferencia +'<br>';
                ajustesGbl = diferencia;
            } else if  (diferenciaGbl >0) {
                diferencia =  diferenciaGbl;
                diferencia = Math.round(diferencia * 100) / 100;
                tipoDiferencia = "Se debe realizar un incremento de patrimonio por la cantidad de: $" +diferencia +'<br>';
                incrementoPatGbl = diferencia;
            }

            var totalArqueo = formatoMoneda(totalArqueoGlobal)
            alertify.confirm('Cierre de caja',
                'El total de cierre de caja es : ' + totalArqueo + '<br>' +
                tipoDiferencia  +
                '\n¿Desea continuar?',
                function () {
                        guardarCaja();
                },
                function () {
                    alertify.error('Cierre cancelado.')
                });
        }

    }
}

function validarAjustes() {
    //1 llena movimientos de dotacion y retiro
    var idCierreCaja = $("#idCierreCaja").text();
    var dataEnviar = {
        "idCierreCaja": idCierreCaja,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/ArqueoAjustes.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var empenos = 0;
            var refrendos = 0;
            var desempeno = 0;
            totalEntradaNew_glb = 0;
            totalSalidasNew_glb = 0;

            for (i; i < datos.length; i++) {
                var tipoMov = datos[i].tipo_movimiento;
                var pag_total = datos[i].pag_total;
                var prestamo_Informativo = datos[i].prestamo_Informativo;

                if(tipoMov==3||tipoMov==7){
                    prestamo_Informativo = Math.round(prestamo_Informativo * 100) / 100;
                    empenos += prestamo_Informativo;

                }else if(tipoMov==4||tipoMov==8){
                    pag_total = Math.round(pag_total * 100) / 100;
                    refrendos += pag_total;
                }else if(tipoMov==5||tipoMov==9||tipoMov==21){
                    pag_total = Math.round(pag_total * 100) / 100;
                    desempeno += pag_total;
                }

            }
            empenos = Math.round(empenos * 100) / 100;
            refrendos = Math.round(refrendos * 100) / 100;
            desempeno = Math.round(desempeno * 100) / 100;
            totalEntradaNew_glb += desempeno + refrendos;
            totalSalidasNew_glb += empenos;
            $("#idEmpenosNew").val(empenos);
            $("#idRefrendoNew").val(refrendos);
            $("#idDesempenoNew").val(desempeno);
            validarAjustesVenta();
        }
    })

}

function validarAjustesVenta() {
    //1 llena movimientos de dotacion y retiro
    var idCierreCaja = $("#idCierreCaja").text();
    var dataEnviar = {
        "idCierreCaja": idCierreCaja,
        "tipo": 1,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/ConArqueoAjustes.php',
        type: 'post',
       dataType: "json",

        success: function (datos) {
            var i = 0;
            var venta = 0;
            var venta_abono = 0;
            var venta_apartado = 0;

            for (i; i < datos.length; i++) {
                var tipo_movimiento = datos[i].tipo_movimiento;
                //VENTA
                var e_venta_mostrador = datos[i].subTotal;
                var e_venta_apartados = datos[i].apartado;
                var e_venta_abono = datos[i].abono;

                e_venta_mostrador = parseFloat(e_venta_mostrador);
                e_venta_apartados = parseFloat(e_venta_apartados);
                e_venta_abono = parseFloat(e_venta_abono);

                if(tipo_movimiento==6||tipo_movimiento==10){
                    e_venta_mostrador = Math.round(e_venta_mostrador * 100) / 100;
                    venta += e_venta_mostrador;
                }else if(tipo_movimiento==22){
                    e_venta_abono = Math.round(e_venta_abono * 100) / 100;
                    venta_abono += e_venta_apartados;
                }else if(tipo_movimiento==23){
                    e_venta_apartados = Math.round(e_venta_apartados * 100) / 100;
                    venta_apartado += e_venta_abono;
                }
            }

            var totalVenta = venta + venta_abono + venta_apartado;
            totalVenta = Math.round(totalVenta * 100) / 100;
            totalEntradaNew_glb += totalVenta;
            $("#idVentasNew").val(totalVenta);
            validarAjustesCompra();
        }
    })

}
function validarAjustesCompra() {
    //1 llena movimientos de dotacion y retiro
    var idCierreCaja = $("#idCierreCaja").text();
    var dataEnviar = {
        "idCierreCaja": idCierreCaja,
        "tipo": 2,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/ConArqueoAjustes.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var compra = 0;
            for (i; i < datos.length; i++) {
                var total = datos[i].total;
                total = Math.round(total * 100) / 100;
                compra += total;
            }
            compra = Math.round(compra * 100) / 100;
            totalSalidasNew_glb += compra;


            $("#idComprasNew").val(compra);
            buscarArqueoAnterior();
        }
    })
}

function buscarArqueoAnterior() {
    //1 llena movimientos de dotacion y retiro
    var idCierreCaja = $("#idCierreCaja").text();
    var dataEnviar = {
        "idCierreCaja": idCierreCaja,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/ConArqueoAnterior.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var Salidas_Ajustes = 0;
            var Entradas_Incremento = 0;
            for (i; i < datos.length; i++) {
                var incremento_pat = datos[i].incremento_pat;
                var ajustes = datos[i].ajustes;
                incremento_pat = Math.round(incremento_pat * 100) / 100;
                ajustes = Math.round(ajustes * 100) / 100;
                Entradas_Incremento += incremento_pat;
                Salidas_Ajustes += ajustes;
            }
            Entradas_Incremento = Math.round(Entradas_Incremento * 100) / 100;
            Salidas_Ajustes = Math.round(Salidas_Ajustes * 100) / 100;

            totalEntradaNew_glb += Entradas_Incremento;
            totalSalidasNew_glb += Salidas_Ajustes;

            totalEntradaNew_glb += bitDotacion_glb;
            totalSalidasNew_glb += bitRetiro_glb;
            var TotalCajaNew = totalEntradaNew_glb - totalSalidasNew_glb;
            TotalCajaNew = Math.round(TotalCajaNew * 100) / 100;
            $("#idIncrementoNew").val(Entradas_Incremento);
            $("#idAjustesNew").val(Salidas_Ajustes);
            $("#idTotEntradasNew").val(totalEntradaNew_glb);
            $("#idTotSalidasNew").val(totalSalidasNew_glb);
            $("#idTotCajaNew").val(TotalCajaNew);
        }
    })
}

function guardarCaja() {
    idMilGlobal = Math.round(idMilGlobal * 100) / 100;
    idQuinientosGlobal = Math.round(idQuinientosGlobal * 100) / 100;
    idDoscientosGlobal = Math.round(idDoscientosGlobal * 100) / 100;
    idCienGlobal = Math.round(idCienGlobal * 100) / 100;
    idCincuentaGlobal = Math.round(idCincuentaGlobal * 100) / 100;
    idVeinteGlobal = Math.round(idVeinteGlobal * 100) / 100;
    idVeinteMonGlobal = Math.round(idVeinteMonGlobal * 100) / 100;
    idDiezGlobal = Math.round(idDiezGlobal * 100) / 100;
    idCincoGlobal = Math.round(idCincoGlobal * 100) / 100;
    idDosGlobal = Math.round(idDosGlobal * 100) / 100;
    idUnoGlobal = Math.round(idUnoGlobal * 100) / 100;
    idCincuentaCGlobal = Math.round(idCincuentaCGlobal * 100) / 100;
    idCentavosGlobal = Math.round(idCentavosGlobal * 100) / 100;
    var idCierreCajaSelect = $("#idCierreCaja").text();
    var idUsuarioCaja = $("#idUsuarioCaja").val();


    var dataEnviar = {
        "idMilCantGlobal": idMilCantGlobal,
        "idQuinientosCantGlobal": idQuinientosCantGlobal,
        "idDoscientosCantGlobal": idDoscientosCantGlobal,
        "idCienCantGlobal": idCienCantGlobal,
        "idCincuentaCantGlobal": idCincuentaCantGlobal,
        "idVeinteCantGlobal": idVeinteCantGlobal,
        "idVeinteMonCantGlobal": idVeinteMonCantGlobal,
        "idDiezCantGlobal": idDiezCantGlobal,
        "idCincoCantGlobal": idCincoCantGlobal,
        "idDosCantGlobal": idDosCantGlobal,
        "idUnoCantGlobal": idUnoCantGlobal,
        "idCincuentaCCantGlobal": idCincuentaCCantGlobal,
        "idCentavosCantGlobal": idCentavosCantGlobal,
        "idMilGlobal": idMilGlobal,
        "idQuinientosGlobal": idQuinientosGlobal,
        "idDoscientosGlobal": idDoscientosGlobal,
        "idCienGlobal": idCienGlobal,
        "idCincuentaGlobal": idCincuentaGlobal,
        "idVeinteGlobal": idVeinteGlobal,
        "idVeinteMonGlobal": idVeinteMonGlobal,
        "idDiezGlobal": idDiezGlobal,
        "idCincoGlobal": idCincoGlobal,
        "idDosGlobal": idDosGlobal,
        "idUnoGlobal": idUnoGlobal,
        "idCincuentaCGlobal": idCincuentaCGlobal,
        "idCentavosGlobal": idCentavosGlobal,
        "totalArqueoMonedas": totalArqueoMonedas,
        "totalArqueoBilletes": totalArqueoBilletes,
        "totalArqueoGlobal": totalArqueoGlobal,
        "guardadoPorGerenteGlb": guardadoPorGerenteGlb,
        "idCierreCaja": idCierreCajaSelect,
        "idUsuarioCaja": idUsuarioCaja,
        "ajustesGbl": ajustesGbl,
        "incrementoPatGbl": incrementoPatGbl,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Cierre/GuardarArqueo.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                idArqueoGbl = response;
                alertify.success("Se guardaron correctamente los datos de arqueo.");
                if(diferenciaGbl==0){
                    BitacoraUsuarioArqueo();
                }else{
                    guardarAjustes();
                }
            } else {
                alertify.error("Error al guardar datos de arqueo .")
            }
        }

    });
}

function guardarAjustes() {
    var importe = 0;
    var tipo = 0;
    if(ajustesGbl!==0){
        //TIPO 7 AJUSTE, TIPO 8 INCREMENTO
        tipo = 7;
        importe = ajustesGbl;
    }else if(incrementoPatGbl!==0){
        tipo = 8;
        importe = incrementoPatGbl;
    }
    var dataEnviar = {
        "tipo": tipo,
        "importe": importe,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Flujo/guardarAjustesArqueo.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                guardarFlujoArqueo(response,tipo,importe)
            } else {
                alertify.error("Error en al conectar con el servidor")
            }
        }
    });
}

function guardarFlujoArqueo(importe,tipo,importeAjuste) {
    var usuarioCaja = $("#idUsuarioCaja").val();
    var importeLetra = NumeroALetras(importeAjuste);

    var dataEnviar = {
        "id_catFlujo": tipo,
        "importe": importeAjuste,
        "usuarioCaja": usuarioCaja,
        "importeLetra": importeLetra,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Flujo/guardarFlujoArqueo.php',
        type: 'post',
        success: function (response) {
            if (response > 0) {
                generarFolioArqueo();
            } else {
                alertify.error("Error al guardar el arqueo.");
            }
        },
    })
}

function generarFolioArqueo() {
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Flujo/generarFolio.php',
        success: function (respuesta) {
            if(respuesta>0){
                alert("Movimiento guardado.");
                BitacoraUsuarioArqueo();
            }else {
                alertify.error("Error al guardar el arqueo.");
            }
        }
    });
}

function BitacoraUsuarioArqueo() {
    //id_Movimiento = 17
    //FEErr08

    var id_Movimiento = 17;
    var id_contrato = 0;
    var id_almoneda = 0;
    var id_cliente = 0;
    var consulta_fechaInicio = null;
    var consulta_fechaFinal = null;


    var dataEnviar = {
        "id_Movimiento": id_Movimiento,
        "id_contrato": id_contrato,
        "id_almoneda": id_almoneda,
        "id_cliente": id_cliente,
        "consulta_fechaInicio": consulta_fechaInicio,
        "consulta_fechaFinal": consulta_fechaFinal,
        "idArqueo": idArqueoGbl,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Bitacora/bitacoraUsuario.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                cargarPDFArqueo(idArqueoGbl)
                setTimeout('location.reload();', 700)
                if(ajustesGbl!==0){
                    cargarPDFAjustes(1);
                }else if(incrementoPatGbl!==0){
                    cargarPDFAjustes(2);
                }
            } else {
                alertify.error("Error en al conectar con el servidor. (FEErr08)")
            }
        }
    });
}

function cambioDeArqueo() {
    var idUserSesion = $("#idUserSesion").val();
    var idUsuarioCaja = $("#idUsuarioCaja").val();
    var id_cierreCaja = $("#idCierreCaja").text();
    var NombreUsuario = $('select[name="usuarioCaja"] option:selected').text();
    var idCierreCaja = "";
    saldoCajaUser();

    if (idUserSesion !== idUsuarioCaja) {

        //1 llena movimientos de dotacion y retiro
        var tipo = 5;
        var dataEnviar = {
            "tipo": tipo,
            "idUsuarioSelect": idUsuarioCaja,
            "idCierreCaja": idCierreCaja,

        };
        $.ajax({
            data: dataEnviar,
            url: '../../../com.Mexicash/Controlador/Cierre/llenarCierreCaja.php',
            type: 'post',
            dataType: "json",
            success: function (response) {
                if (response.status == 'ok') {
                    id_cierreCaja = response.result.id_cierreCaja;
                    document.getElementById('idCierreCaja').innerHTML = id_cierreCaja;
                    guardadoPorGerenteGlb = idUserSesion;
                } else {
                    alert("El usuario: " + NombreUsuario + " no cuenta con un cierre de caja activo.");
                }

                alert("Atención, Se ha cambiado el usuario para el cierre de caja." +
                    " Usuario : " + NombreUsuario + " Cierre Caja: " + id_cierreCaja);

            },
        })
    } else {
        document.getElementById('idCierreCaja').innerHTML = id_cierreCaja;

    }
}

function buscarArqueo() {
    var fechaInicial = fechaSQL($("#idFechaInicial").val());
    var fechaFinal = fechaSQL($("#idFechaFinal").val());

    var validate = 1;
    if (fechaInicial == "" && fechaFinal == "") {
        alert("Por favor, ingrese fechas para realizar la busqueda");
        validate = 0;
    } else if (fechaInicial == "") {
        alert("Por favor, ingrese fecha inicial para realizar la busqueda");
        validate = 0;
    } else if (fechaFinal == "") {
        alert("Por favor, ingrese fecha final para realizar la busqueda");
        validate = 0;
    }

    if (validate == 1) {
        var dataEnviar = {
            "tipe": 1,
            "fechaInicial": fechaInicial,
            "fechaFinal": fechaFinal
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Cierre/busqueda.php',
            data: dataEnviar,
            dataType: "json",

            success: function (datos) {
                var html = '';
                var i = 0;
                for (i; i < datos.length; i++) {
                    var id_Arqueo = datos[i].id_Arqueo;
                    var id_cierreCaja = datos[i].id_cierreCaja;
                    var id_CierreSucursal = datos[i].id_CierreSucursal;
                    var usuario = datos[i].usuario;
                    var guardadoPorGerente = datos[i].guardadoPorGerente;
                    var estatus = datos[i].estatus;
                    var fecha_Creacion = datos[i].fecha_Creacion;

                    if (guardadoPorGerente !== 0) {
                        guardadoPorGerente = "SI"
                    } else {
                        guardadoPorGerente = "";
                    }


                    html += '<tr align="center">' +
                        '<td>' + id_Arqueo + '</td>' +
                        '<td>' + id_cierreCaja + '</td>' +
                        '<td>' + id_CierreSucursal + '</td>' +
                        '<td>' + usuario + '</td>' +
                        '<td>' + guardadoPorGerente + '</td>' +
                        '<td>' + estatus + '</td>' +
                        '<td>' + fecha_Creacion + '</td>' +
                        '<td><img src="../../style/Img/impresoraNor.png"  ' +
                        'alt="Imprimir" onclick="cargarPDFArqueo(' + id_Arqueo + ')"></td>' +
                        '</tr>';
                }
                $('#idArqueoModal').html(html);
            }
        });
    }
}

function saldoCajaUser() {
    var idUsuarioCaja = $("#idUsuarioCaja").val();
    bitDotacion_glb = 0;
    bitRetiro_glb = 0;
    bitCant_Dotacion_glb = 0;
    bitCant_Retiro_glb = 0;
    var dataEnviar = {
        "idUsuarioCaja": idUsuarioCaja,
    };
    $.ajax({
        data: dataEnviar,
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Flujo/busquedaCaja.php',
        dataType: "json",
        success: function (datos) {
            var i = 0;
            if (datos.length > 0) {
                var dotacion = 0;
                var retiro = 0;
                for (i; i < datos.length; i++) {
                    var id_cat_flujo = datos[i].id_cat_flujo;
                    var importe = datos[i].importe;
                    id_cat_flujo = Number(id_cat_flujo);
                    importe = Number(importe);
                    if(id_cat_flujo==5){
                        //Dotacion
                        bitCant_Dotacion_glb++;
                        dotacion += importe;
                    }else if (id_cat_flujo==6){
                        //Retiro
                        bitCant_Retiro_glb++;
                        retiro += importe;
                    }
                }
                bitDotacion_glb = dotacion;
                bitRetiro_glb = retiro;
                $("#idDotacionesNew").val(bitDotacion_glb);
                $("#idRetirosNew").val(bitRetiro_glb);
            } else {
                alertify.error("El usuario no tiene una dotación a caja.");
            }
        }
    });
}

//PDF
function cargarPDFArqueo() {
    window.open('../PDF/callPdfArqueo.php?idArqueo=' + idArqueoGbl);
}
function cargarPDFAjustes(tipoAjuste) {
    window.open('../PDF/callPdfAjustes.php?tipoAjuste='+tipoAjuste + '&idArqueo=' + idArqueoGbl);
}
