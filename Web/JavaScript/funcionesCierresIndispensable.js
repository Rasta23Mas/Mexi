
function fnCierreCajaIndispensable(estatus) {
    var dataEnviar = {
        "estatus": estatus,
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
