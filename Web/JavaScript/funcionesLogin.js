var tipoUserGlb = 0;

function enterValidaUser(e) {
    if (e.keyCode == 13 && !e.shiftKey) {
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
                tipoUserGlb = tipoUser;
                if (tipoUserGlb > 0) {
                    if (tipoUserGlb == 1 || tipoUserGlb == 2) {
                        $("#modalSucursal").modal();
                    } else {
                        var validateMobile = isMobile();
                        if (validateMobile) {
                            alert("El sistema Mexicash se encuentra inhabilitado para dispositivos moviles.");
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

//Login Administradores
function LoginAdministradores(sucursal) {
    //ErrFn01
    var dataEnviar = {
        "sucursal": sucursal,
    };
    $.ajax({
        type: "POST",
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Usuario/LogginAdministradores.php',
        success: function (HaySucursales) {
            if (HaySucursales == 1) {
                location.href = '../Empeno/vInicio.php';
            } else if (HaySucursales == 0) {
                saldosInformativoAdmin();
            } else {
                alertify.error("Error en al conectar con el servidor. (ErrFn01)")
            }
        }
    });
}

function saldosInformativoAdmin() {

    $.ajax({
        url: '../../../com.Mexicash/Controlador/Usuario/saldoInicialInfo.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var saldoInicialInfo = 0;
            for (i; i < datos.length; i++) {
                var prestamo_Informativo = datos[i].prestamo_Informativo;

                prestamo_Informativo = Math.round(prestamo_Informativo * 100) / 100;
                saldoInicialInfo += prestamo_Informativo;
            }
            saldoInicialInfo = Math.round(saldoInicialInfo * 100) / 100;
            saldosSucursalAdmin(saldoInicialInfo)
        }
    })
}

function saldosSucursalAdmin(saldoInicialInfo) {
    //ErrFn02
    var dataEnviar = {
        "saldoInicialInfo": saldoInicialInfo,
    };
    $.ajax({
        type: "POST",
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Usuario/updateCajaSucursal.php',
        success: function (response) {
            if (response == 1) {
                location.href = '../Empeno/vInicio.php'
            } else {
                alertify.error("Error en al conectar con el servidor. (ErrFn02)")
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

function validarHorario() {
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Usuario/Horario.php',
        success: function (response) {
            var horario = Number(response);
            if (horario > 0) {
                if (tipoUserGlb == 3) {
                    LoginGerente();
                } else {
                    LoginVendedor();
                }
            } else {
                if (tipoUserGlb == 3) {
                    confirmarModificarHorario();
                } else {
                    alert("El sistema Mexicash se encuentra inhabilitado por horario.");
                }
            }
        }
    });
}

function confirmarModificarHorario() {
    alertify.confirm('Cambio de horario',
        'Por horario, el sistema esta inhabilitado. ' + '<br>' + '\n¿Desea modificar el horario usando un token?',
        function () {
            location.href = '../Menu/vModHorario.php'
        },
        function () {
            alertify.error('Cerrado por horario.')
        });
}

function LoginGerente() {
    //ErrFn03
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Usuario/LogginGerente.php',
        success: function (HaySucursales) {
            if (HaySucursales == 1) {
                buscaridCajaGerente();
            } else if (HaySucursales == 0) {
                saldosInformativoGerente();
            } else {
                alertify.error("Error en al conectar con el servidor. (ErrFn03)")
            }
        }
    });
}

function saldosInformativoGerente() {
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Usuario/saldoInicialInfo.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var saldoInicialInfo = 0;
            for (i; i < datos.length; i++) {
                var prestamo_Informativo = datos[i].prestamo_Informativo;

                prestamo_Informativo = Math.round(prestamo_Informativo * 100) / 100;
                saldoInicialInfo += prestamo_Informativo;
            }
            saldoInicialInfo = Math.round(saldoInicialInfo * 100) / 100;
            saldosSucursalGerente(saldoInicialInfo)
        }
    })
}

function saldosSucursalGerente(saldoInicialInfo) {
    //ErrFn04
    var dataEnviar = {
        "saldoInicialInfo": saldoInicialInfo,
    };
    $.ajax({
        type: "POST",
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Usuario/updateCajaSucursal.php',
        success: function (response) {
            if (response == 1) {
                buscaridCajaGerente();
            } else {
                alertify.error("Error en al conectar con el servidor. (ErrFn04)")
            }
        }
    });
}


function buscaridCajaGerente() {
    //ErrFn05
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Usuario/LogginGerenteCaja.php',
        success: function (response) {
            if (response == 1) {
                BitacoraUsuario();
            } else {
                alertify.error("Error en al conectar con el servidor.  (ErrFn05)")
            }
        }
    });
}

function BitacoraUsuario() {
    //ErrFn06
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
                alertify.error("Error en al conectar con el servidor.  (ErrFn06)")
            }
        }
    });
}

function LoginVendedor() {
    //ErrFn07
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Usuario/LogginVendedor.php',
        success: function (HaySucursales) {
            if (HaySucursales == 1) {
                buscaridCajaVendedor();
            } else if (HaySucursales == 2) {
                alertify.error('Sistema cerrado por cierre de sucursal.')
            }  else if (HaySucursales == 0) {
                saldosInformativoVendedor();
            } else {
                alertify.error("Error en al conectar con el servidor. (ErrFn07)")
            }
        }
    });
}

function saldosInformativoVendedor() {
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Usuario/saldoInicialInfo.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var saldoInicialInfo = 0;
            for (i; i < datos.length; i++) {
                var prestamo_Informativo = datos[i].prestamo_Informativo;

                prestamo_Informativo = Math.round(prestamo_Informativo * 100) / 100;
                saldoInicialInfo += prestamo_Informativo;
            }
            saldoInicialInfo = Math.round(saldoInicialInfo * 100) / 100;
            saldosSucursalVendedor(saldoInicialInfo)
        }
    })
}

function saldosSucursalVendedor(saldoInicialInfo) {
    //ErrFn09
    var dataEnviar = {
        "saldoInicialInfo": saldoInicialInfo,
    };
    $.ajax({
        type: "POST",
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Usuario/updateCajaSucursal.php',
        success: function (response) {
            if (response == 1) {
                buscaridCajaVendedor();
            } else {
                alertify.error("Error en al conectar con el servidor. (ErrFn09)")
            }
        }
    });
}


function buscaridCajaVendedor() {
    //ErrFn10
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Usuario/LogginVendedorCaja.php',
        success: function (response) {
            if (response == 1) {
                BitacoraUsuario();
            } else if (response == 1) {
                alertify.error('Sistema cerrado. El usuario ha realizado el cierre de su caja.')
            } else {
                alertify.error("Error en al conectar con el servidor.  (ErrFn10)")
            }
        }
    });
}
/*
function BitacoraUsuario() {
    //ErrFn06
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
                alertify.error("Error en al conectar con el servidor.  (ErrFn06)")
            }
        }
    });
}*/


//-----
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
                saldosInformativo();
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
                if (tipoUserGlb == 1 || tipoUserGlb == 2) {
                    confirmarEntrarSucursalInactiva();
                }else  if (tipoUserGlb == 3) {
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
                saldosInformativo();

            } else {
                alertify.error("Error en al conectar con el servidor. (FLErr01)")
            }
        }
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





function buscaridCaja() {
    //FLErr11
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Usuario/busquedaCaja.php',
        success: function (response) {
            if (response > 0) {
                if(tipoUserGlb==1||tipoUserGlb ==2){
                    location.href = '../Empeno/vInicio.php'
                }else{
                    BitacoraUsuario();
                }
            } else if (response == -1) {
                //Adminisradores -> 5 Inicia la sesion
                if(tipoUserGlb==3){
                    location.href = '../Empeno/vInicio.php'
                }else{
                    alert("El usuario no tiene acceso, ya que se ha realizado el cierre de caja.")
                }
            } else {
                alertify.error("Error en al conectar con el servidor.  (FLErr11)")
            }
        }
    });
}

function saldosInformativo() {
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Usuario/saldoInicialInfo.php',
        type: 'post',
        dataType: "json",

        success: function (datos) {
            var i = 0;
            var saldoInicialInfo = 0;
            for (i; i < datos.length; i++) {
                var prestamo_Informativo = datos[i].prestamo_Informativo;

                prestamo_Informativo = Math.round(prestamo_Informativo * 100) / 100;
                saldoInicialInfo += prestamo_Informativo;
            }
            saldoInicialInfo = Math.round(saldoInicialInfo * 100) / 100;
            saldosSucursal(saldoInicialInfo)
        }
    })
}

function saldosSucursal(saldoInicialInfo) {
    //FLErr13
    var dataEnviar = {
        "saldoInicialInfo": saldoInicialInfo,
    };
    $.ajax({
        type: "POST",
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Usuario/updateCajaSucursal.php',
        success: function (response) {
            if (response == 1) {
                buscaridCaja()
            } else {
                alertify.error("Error en al conectar con el servidor. (FLErr13)")
            }
        }
    });
}

