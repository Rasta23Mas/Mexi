
function fnCierreCajaIndispensable(estatus,user,tipo) {
    var dataEnviar = {
        "estatus": estatus,
        "user": user,
        "tipo": tipo,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Cierre/ConCierreCajaIndispensable.php',
        type: 'post',
        dataType: "json",
        success: function (response) {
            if (response > 0) {
                alertify.success("Se actualizo cierre de caja.")
            }
        },
    })
}
