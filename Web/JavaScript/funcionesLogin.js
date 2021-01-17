var tipoUserGlb = 0;

function fnEnterValidaUser(e) {
    if (e.keyCode == 13 && !e.shiftKey) {
        fnValidarPass();
    }
}

function fnValidarPass() {
    var user = $("#usuario").val();
    var validate = true;
    if (user == '' || user == null) {
        alertify.error("Por favor ingrese un usuario.");
        validate = false;
    }
    if (validate) {
        var dataEnviar = {
            "User": user,
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Usuario/PassChange.php',
            data: dataEnviar,
            success: function (Pass) {
                var validar = parseInt(Pass);
                if (validar == 1) {
                    alert("El usuario necesita cambiar su contraseña.");
                    location.href = 'MenuLogginPass.php?userGet=' + user;
                } else {
                    fnValidarUser();
                }
            }
        });
    }
}

function fnMostrarContrasena() {
    var tipo = document.getElementById("idPassword");
    var pass = $("#idPassword").val();
    var user = $("#idUsuarioReset").val();
    if(pass!=""){
        if (tipo.type == "password") {
            tipo.type = "text";
            var imgClose = document.getElementById("ojoClose");
            imgClose.style.visibility = 'hidden';
            var imgOpen = document.getElementById("ojoOpen");
            imgOpen.style.visibility = 'visible';
        } else {
            tipo.type = "password";
            var imgClose = document.getElementById("ojoClose");
            imgClose.style.visibility = 'visible';
            var imgOpen = document.getElementById("ojoOpen");
            imgOpen.style.visibility = 'hidden';
        }
    }else{
        alert("Por favor capture la contraseña.");
    }

}

function fnValidarContrasenas() {
    var pass = $("#idPassword").val();
    var passSecond = $("#idPasswordSecond").val();
    var user = $("#idUsuarioReset").val();
    if (pass != passSecond) {
        alertify.error("Las contraseñas no son iguales.");
    } else {

        var dataEnviar = {
            "pass": pass,
            "user": user,
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Usuario/PassGuardar.php',
            data: dataEnviar,
            success: function (guardado) {
                var validar = parseInt(guardado);
                if (validar == 1) {
                    alert("Se cambio la contraseña correctamente.");
                    location.href = 'MenuLoggin.php';
                } else {
                    alert("Error al guardar contraseña.");
                }
            }
        });
    }


}

function fnValidarUser() {
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
            url: '../../../com.Mexicash/Controlador/Usuario/NuevoLoggin.php',
            data: dataEnviar,
            success: function (tipoUser) {
                tipoUserGlb = tipoUser;
                if (tipoUserGlb > 0) {
                    if ( tipoUserGlb == 1) {
                        alert("superUser");
                    }else if ( tipoUserGlb == 2) {
                        $("#modalSucursal").modal();
                    } else {
                        var validateMobile = fnIsMobile();
                        if (validateMobile) {
                            alert("El sistema Mexicash se encuentra inhabilitado para dispositivos moviles.");
                        } else {
                            fnValidarHorario();
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
function fnLoginAdministradores(sucursal) {
    //ErrFn01
    var dataEnviar = {
        "sucursal": sucursal,
    };
    $.ajax({
        type: "POST",
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Usuario/NuevoLogginValidaSiYaInicio.php',
        success: function (Validar) {
            alert(Validar)
            //$Validar = 1; Todo ok dejalo iniciar sesion
            //$Validar = 2; La sucursal ya cerro sesión
            //$Validar = 3; Ocurrio un error al insertar la sesión de caja
            //$Validar = 4; Ocurrio un error al insertar la sesión de SUCURSAL
            if (Validar == 1) {
                location.href = '../Empeno/vInicioAdmin.php';
            } else if (Validar == 2) {
                alert("La sucursal ya cerro operaciónes el día de hoy");
            }  else if (Validar == 3) {
                alert("La sesión de caja no se guardo correctamente, favor de intenar de nuevo.");
            } else if (Validar == 4) {
                alert("La sesión de sucursal no se guardo correctamente, favor de intenar de nuevo.");
            }else {
                alertify.error("Error en al conectar con el servidor. (ErrFn01)")
            }
        }
    });
}

//Verifica si es desde un celular
function fnIsMobile() {
    try {
        document.createEvent("TouchEvent");
        return true;
    } catch (e) {
        return false;
    }
}

//Valida el horario de la sucursal
function fnValidarHorario() {
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Usuario/Horario.php',
        success: function (response) {
            var horario = Number(response);
            if (horario > 0) {
                fnLoginGerenteYVendedor();
            } else {
                if (tipoUserGlb == 3) {
                    fnConfirmarModificarHorario();
                } else {
                    alert("El sistema Mexicash se encuentra inhabilitado por horario.");
                }
            }
        }
    });
}

//Login Gerente y Administradores
function fnLoginGerenteYVendedor() {
    //ErrFn02
    var dataEnviar = {
        "sucursal": 0,
    };
    $.ajax({
        type: "POST",
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Usuario/NuevoLogginValidaSiYaInicio.php',
        success: function (Validar) {

            //$Validar = 1; Todo ok dejalo iniciar sesion
            //$Validar = 2; La sucursal ya cerro sesión
            //$Validar = 3; Ocurrio un error al insertar la sesión de caja
            //$Validar = 4; Ocurrio un error al insertar la sesión de SUCURSAL
            if (Validar == 1) {
                if (tipoUserGlb == 3) {
                    location.href = '../Empeno/vInicioGerente.php'
                } else {
                    location.href = '../Empeno/vInicio.php'
                }
                fnBitacoraUsuario();
            } else if (Validar == 2) {
                alert("La sucursal ya cerro operaciónes el día de hoy");
            }  else if (Validar == 3) {
                alert("La sesión de caja no se guardo correctamente, favor de intenar de nuevo.");
            } else if (Validar == 4) {
                alert("La sesión de sucursal no se guardo correctamente, favor de intenar de nuevo.");
            }else {
                alertify.error("Error en al conectar con el servidor. (ErrFn02)")
            }
        }
    });
}

//Guarda una bitacora de los inicios de sesión
function fnBitacoraUsuario() {
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
                alertify.success("Inicio de sesión correcto.")
            } else {
                alertify.error("Error en al conectar con el servidor.  (ErrFn06)")
            }
        }
    });
}

// Funcion para modificar el horario
function fnConfirmarModificarHorario() {
    alertify.confirm('Cambio de horario',
        'Por horario, el sistema esta inhabilitado. ' + '<br>' + '\n¿Desea modificar el horario usando un token?',
        function () {
            location.href = '../Menu/vModHorario.php'
        },
        function () {
            alertify.error('Cerrado por horario.')
        });
}

//Funcion por si se ocupa cancelar los cierres de sucursal
/*function confirmarCancelarCierre() {
    alertify.confirm('Cierre de Sucursal',
        'El cierre de la sucursal ya fue realizado. ' + '<br>' + '\n¿Desea cancelar el cierre de la sucursal usando un token?',
        function () {
            location.href = '../Configuracion/vCancelarSucursal.php'
        },
        function () {
            alertify.error('Cerrado por cierre de sucursal.')
        });
}*/
