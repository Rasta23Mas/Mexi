var entradasInfoGlb = 0;

function empenosBazar() {
    var tipo = 1;
    var dataEnviar = {
        "tipo": tipo,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Bazar/BusquedaBazar.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var entradasInfo = 0;
            var utilidadVenta = 0;

            for (i; i < datos.length; i++) {
                var id_movimiento = datos[i].id_movimiento;
                var prestamo_Informativo = datos[i].prestamo_Informativo;
                prestamo_Informativo = Math.round(prestamo_Informativo * 100) / 100;
                entradasInfo += prestamo_Informativo;
            }
            entradasInfo = Math.round(entradasInfo * 100) / 100;
            entradasInfoGlb = entradasInfo;

            entradasInfo = formatoMoneda(entradasInfo);
            document.getElementById('salidas').innerHTML = entradasInfo;

        }
    })
}

function refrendosBazar() {
    var tipo = 2;
    var dataEnviar = {
        "tipo": tipo,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Bazar/BusquedaBazar.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var entradasInfo = 0;
            var utilidadVenta = 0;

            for (i; i < datos.length; i++) {
                var id_movimiento = datos[i].id_movimiento;
                var prestamo_Informativo = datos[i].prestamo_Informativo;
                prestamo_Informativo = Math.round(prestamo_Informativo * 100) / 100;
                entradasInfo += prestamo_Informativo;
            }
            entradasInfo = Math.round(entradasInfo * 100) / 100;
            entradasInfoGlb = entradasInfo;

            entradasInfo = formatoMoneda(entradasInfo);
            document.getElementById('salidas').innerHTML = entradasInfo;

        }
    })
}

function apartadosBazar() {

}

function abonosBazar() {

}