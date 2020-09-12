function fechaActual() {
    var diaActual = new Date();
    var dia = diaActual.getDate();
    var mes = diaActual.getMonth() + 1;
    var anio = diaActual.getFullYear();
    if (dia < 10) {
        dia = '0' + dia;
    }
    if (mes < 10) {
        mes = '0' + mes;
    }
    diaActual = anio + '-' + mes + '-' + dia;

    return diaActual;
}

function sumarDias(diasASumar) {
    var fecha = new Date(),
        dia = fecha.getDate(),
        mes = fecha.getMonth() + 1,
        anio = fecha.getFullYear(),
        addTime = diasASumar * 86400; //Tiempo en segundos
    fecha.setSeconds(addTime); //Añado el tiempo
    var mesNuevo = fecha.getMonth() + 1;
    var diaNuevo = fecha.getDate();

    if (mesNuevo < 10) {
        mesNuevo = "0" + mesNuevo;
    }
    if (diaNuevo < 10) {
        diaNuevo = "0" + diaNuevo;
    }

    var fechaDias = fecha.getFullYear() + "-" + mesNuevo + "-" + diaNuevo;
    return fechaDias;
}

function calcularDiasAlmoneda(diasContrato, diasAlm) {
    diasAlm = parseInt(diasAlm);
    diasContrato = parseInt(diasContrato);
    diasAlm = diasAlm + diasContrato;
    var sumarAlm = sumarDias(diasAlm);
    return sumarAlm;
}

function soloNumeros(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) return true;
    else if (tecla == 0 || tecla == 9) return true;
    // patron =/[0-9\s]/;// -> solo letras
    patron = /[0-9\s]/;// -> solo numeros
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function isNumberDecimal(e) {
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) {
        return true;
    }
    var patron;
    patron = /[0-9.]/
    var te;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function formatStringToDate(text) {
    var myDate = text.split('-');
    return new Date(myDate[0], myDate[1] - 1, myDate[2]);

}

function fechaFormato() {
    var fecha = new Date();
    var mesNuevo = fecha.getMonth() + 1;
    var diaNuevo = fecha.getDate();

    if (mesNuevo < 10) {
        mesNuevo = "0" + mesNuevo;
    }
    if (diaNuevo < 10) {
        diaNuevo = "0" + diaNuevo;
    }

    var fechaHoyFormat = fecha.getFullYear() + "-" + mesNuevo + "-" + diaNuevo;
    return fechaHoyFormat;
}

function isDateValidate(e) {
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) {
        return true;
    }
    var patron;
    patron = /[0-9-]/
    var te;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function soloLetras(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = "8-37-39-46";

    tecla_especial = false
    for(var i in especiales){
        if(key == especiales[i]){
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla)==-1 && !tecla_especial){
        return false;
    }
}

function formatoMoneda($cantidad) {
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    })

    var cantidadRetorno = formatter.format($cantidad);

    return cantidadRetorno;
}

function cerrarSesion() {
    //id_Movimiento = 2 cat_movimientos-->Sesion-->Cerrar Sesion
    var id_Movimiento  = 2;
    var id_contrato  = 0;
    var id_almoneda  = 0;
    var id_cliente  = 0;
    var consulta_fechaInicio  = null;
    var consulta_fechaFinal  = null;
    var idArqueo  = 0;

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
                location.href = '../CerrarSesion.php'
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
        }
    });
}

function fechaSQL(fechaAConvertir) {
        var diaIni = fechaAConvertir.substring(0,2);
        var mesIni = fechaAConvertir.substring(3,5);
        var anioIni = fechaAConvertir.substring(6,10);
        var nuevaFecha = anioIni + "-" +  mesIni + "-" + diaIni;
        return nuevaFecha;
}

function fechaVista(fechaAConvertir) {
    var diaIni = fechaAConvertir.substring(0,4);
    var mesIni = fechaAConvertir.substring(5,7);
    var anioIni = fechaAConvertir.substring(8,10);
    var nuevaFecha = anioIni + "-" +  mesIni + "-" + diaIni;
    return nuevaFecha;
}

function DosDecimales(monto) {
    monto = Math.round(monto * 100) / 100;
    return monto;

}
//Saber el tipo de dato
//alert(typeof (totalVencInteres))
//Obtener el valor texto de un select
//  $('select[name="lineas"] option:selected').text());
//seter lbl
//  document.getElementById('idFecVencimiento').innerHTML =
//border top 0
//style="border-top-style: hidden"
//MAyusculas
//color.toUpperCase();
//Check false o true
//document.getElementById("myCheck").checked = false;
//reload
//var  recargar = setTimeout(function(){ location.reload() }, 3000);
//onclick String
//onclick="verFotosContrato(\'' + id_serie + '\')