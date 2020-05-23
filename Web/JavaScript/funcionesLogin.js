$tipoUserGlb = 0;

function enterValidaUser(e) {
    if (e.keyCode === 13 && !e.shiftKey) {
        validarUser();
    }
}

function validarUser() {
    var user = $("#usuario").val();
    var pass = $("#password").val();
    var validate = true;
    if (user == '' || user == null) {
        alertify.error("Por favor ingrese un usuario.");
        validate = false;
    }
    if (pass == '' || pass == null) {
        alertify.error("Por favor ingrese una contraseña.");
        validate = false;
    }
    if (validate) {
        var dataEnviar = {
            "User": user,
            "Pass": pass,
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Usuario/Loggin.php',
            data: dataEnviar,
            success: function (tipoUser) {
                $tipoUserGlb = tipoUser;
                if ($tipoUserGlb > 0) {
                    if ($tipoUserGlb == 1 || $tipoUserGlb == 2) {
                        //Administradores -> 1 Login -> Valida si la sucursal esta cerrada
                        HaySucursalesRegistradas();
                    } else {
                        var validateMobile = isMobile();
                        if (validateMobile) {
                            alert("El sistema Mexicash se encuentra inavilitado para dispositivos moviles.");
                        } else {
                            validarHorario();
                        }
                    }
                } else {
                    $('#resultado').html("Verifique usuario y contraseña.");
                }
            }
        });
    }
}

function HaySucursalesRegistradas() {
    //VAlida si esta inactiva
    var dataEnviar = {
        "tipo": 4,
        "idCierreSuc": 0,
    };
    $.ajax({
        type: "POST",
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Usuario/busquedaCajaSucursal.php',
        success: function (HaySucursales) {
            if (HaySucursales == 0) {
                insertaCajaSucursal(1);
            } else {
                validarSucursalHoyAdmin();
            }
        }
    });
}

function insertaCajaSucursal(idCierreSuc) {
    var dataEnviar = {
        "tipo": 3,
        "idCierreSuc": idCierreSuc,
    };
    $.ajax({
        type: "POST",
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Usuario/busquedaCajaSucursal.php',
        success: function (response) {
            if (response == 0) {
                saldosSucursal();
            } else {
                alertify.error("Error en al conectar con el servidor. (FLErr01)")
            }
        }
    });
}

function validarSucursalHoyAdmin() {
    //VAlida si esta inactiva
    var dataEnviar = {
        "tipo": 5,
        "idCierreSuc": 0,
    };
    $.ajax({
        type: "POST",
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Usuario/busquedaCajaSucursal.php',
        success: function (response) {
            if (response == 0) {

                insertaCajaSelectMaxSucursal();
            }else  if (response == 1) {
                buscaridCaja();
            } else if (response == 2) {
                if ($tipoUserGlb == 1 || $tipoUserGlb == 2) {
                    confirmarEntrarSucursalInactiva();
                }else  if ($tipoUserGlb == 3) {
                    confirmarCancelarCierre();
                } else {
                    alert("Se ha realizado el cierre de sucursal.")
                }
            }
        }
    });
}

function insertaCajaSelectMaxSucursal() {
    var dataEnviar = {
        "tipo": 6,
        "idCierreSuc": 0,
    };
    $.ajax({
        type: "POST",
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Usuario/busquedaCajaSucursal.php',
        success: function (response) {
            if (response == 1) {
                saldosSucursal();

            } else {
                alertify.error("Error en al conectar con el servidor. (FLErr01)")
            }
        }
    });
}

function validarHorario() {
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Usuario/Horario.php',
        success: function (response) {
            var horario = Number(response);
            if (horario > 0) {
                HaySucursalesRegistradas();
            } else {
                if ($tipoUserGlb == 3) {
                    confirmarModificarHorario();
                } else {
                    alert("El sistema Mexicash se encuentra inavilitado por horario.");
                }
            }
        }
    });
}

function confirmarModificarHorario() {
    alertify.confirm('Cambio de horario',
        'Por horario, el sistema esta inavilitado. ' + '<br>' + '\n¿Desea modificar el horario usando un token?',
        function () {
            location.href = '../Configuracion/vHorario.php'
        },
        function () {
            alertify.error('Cerrado por horario.')
        });
}

function confirmarCancelarCierre() {
    alertify.confirm('Cierre de Sucursal',
        'El cierre de la sucursal ya fue realizado. ' + '<br>' + '\n¿Desea cancelar el cierre de la sucursal usando un token?',
        function () {
            location.href = '../Configuracion/vCancelarSucursal.php'
        },
        function () {
            alertify.error('Cerrado por cierre de sucursal.')
        });
}

function confirmarEntrarSucursalInactiva() {
    alertify.confirm('Cierre de Sucursal',
        'El cierre de la sucursal ya fue realizado. ' + '<br>' + '\n¿Desea continuar, no podra realziar operaciones de dotación?',
        function () {
            //Adminisradores -> 9 Inicia sesion
            location.href = '../Empeno/vInicio.php';
        },
        function () {
            alertify.error('Cancelado ingreso de sesión.')
        });
}

function BitacoraUsuario() {
    //FLErr03
    //id_Movimiento = 1 cat_movimientos-->Sesion-->Iniciar Sesion
    var id_Movimiento = 1;
    var id_contrato = 0;
    var id_almoneda = 0;
    var id_cliente = 0;
    var consulta_fechaInicio = null;
    var consulta_fechaFinal = null;
    var idArqueo = 0;


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
                location.href = '../Empeno/vInicio.php'
            } else {
                alertify.error("Error en al conectar con el servidor.  (FLErr03)")
            }
        }
    });
}

function isMobile() {
    try {
        document.createEvent("TouchEvent");
        return true;
    } catch (e) {
        return false;
    }
}

function buscaridCaja() {
    //FLErr02
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Usuario/busquedaCaja.php',
        success: function (response) {
            if (response > 0) {
                //Adminisradores -> 5 Inicia la sesion
                if($tipoUserGlb==1||$tipoUserGlb ==2){
                    location.href = '../Empeno/vInicio.php'
                }else{
                    BitacoraUsuario();
                }
            } else if (response == -1) {
                //Adminisradores -> 5 Inicia la sesion
                if($tipoUserGlb==3){
                    location.href = '../Empeno/vInicio.php'
                }else{
                    alert("El usuario no tiene acceso, ya que se ha realizado el cierre de caja.")
                }
            } else {
                alertify.error("Error en al conectar con el servidor.  (FLErr02)")
            }
        }
    });
}

function saldosSucursal() {
    //FLErr09
    var dataEnviar = {
        "tipo": 7,
        "idCierreSuc": 0,
    };
    $.ajax({
        type: "POST",
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Usuario/busquedaCajaSucursal.php',
        success: function (response) {
            if (response == 1) {
                buscaridCaja()
            } else {
                alertify.error("Error en al conectar con el servidor. (FLErr091)")
            }
        }
    });
}