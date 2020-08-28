var idGuardarGlb = 0;
var idHorarioIniGlb = 0;
var idHorarioFinGlb = 0;
var idEstatusGlb = 0;

function cargarHorario() {
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Configuracion/LlenarHorario.php',
            dataType: "json",
            success: function (datos) {
                var i = 0;
                for (i; i < datos.length; i++) {
                    var dia_Num = datos[i].dia_Num;
                    var Entrada = datos[i].Entrada;
                    var Salida = datos[i].Salida;
                    var Estatus = datos[i].Estatus;

                    if(dia_Num==1){
                        $("#lunesEntrada").val(Entrada);
                        $("#lunesSalida").val(Salida);
                        if(Estatus==0){
                            document.getElementById("checkLunes").checked = false;
                        }
                    } else if(dia_Num==2){
                        $("#martesEntrada").val(Entrada);
                        $("#martesSalida").val(Salida);
                        if(Estatus==0){
                            document.getElementById("checkMartes").checked = false;
                        }
                    }else if(dia_Num==3){
                        $("#miercolesEntrada").val(Entrada);
                        $("#miercolesSalida").val(Salida);
                        if(Estatus==0){
                            document.getElementById("checkMiercoles").checked = false;
                        }
                    } else if(dia_Num==4){
                        $("#juevesEntrada").val(Entrada);
                        $("#juevesSalida").val(Salida);
                        if(Estatus==0){
                            document.getElementById("checkJueves").checked = false;
                        }
                    } else if(dia_Num==5){
                        $("#viernesEntrada").val(Entrada);
                        $("#viernesSalida").val(Salida);
                        if(Estatus==0){
                            document.getElementById("checkViernes").checked = false;
                        }
                    } else if(dia_Num==6){
                        $("#sabadoEntrada").val(Entrada);
                        $("#sabadoSalida").val(Salida);
                        if(Estatus==0){
                            document.getElementById("checkSabado").checked = false;
                        }
                    } else if(dia_Num==7){
                        $("#domingoEntrada").val(Entrada);
                        $("#domingoSalida").val(Salida);
                        if(Estatus==0){
                            document.getElementById("checkDomingo").checked = false;
                        }
                    }
                }
            }
        });
    }

function editarHorario(idHorario) {
    if (idHorario == 1) {
        $("#lunesEntrada").prop('disabled', false);
        $("#lunesSalida").prop('disabled', false);
        $("#btnGuardarLun").prop('disabled', false);
        $("#martesEntrada").prop('disabled', true);
        $("#martesSalida").prop('disabled', true);
        $("#btnGuardarMar").prop('disabled', true);
        $("#miercolesEntrada").prop('disabled', true);
        $("#miercolesSalida").prop('disabled', true);
        $("#btnGuardarMie").prop('disabled', true);
        $("#juevesEntrada").prop('disabled', true);
        $("#juevesSalida").prop('disabled', true);
        $("#btnGuardarJue").prop('disabled', true);
        $("#viernesEntrada").prop('disabled', true);
        $("#viernesSalida").prop('disabled', true);
        $("#btnGuardarVie").prop('disabled', true);
        $("#sabadoEntrada").prop('disabled', true);
        $("#sabadoSalida").prop('disabled', true);
        $("#btnGuardarSab").prop('disabled', true);
        $("#domingoEntrada").prop('disabled', true);
        $("#domingoSalida").prop('disabled', true);
        $("#btnGuardarDom").prop('disabled', true);

        $("#checkLunes").prop('disabled', false);
        $("#checkMartes").prop('disabled', true);
        $("#checkMiercoles").prop('disabled', true);
        $("#checkJueves").prop('disabled', true);
        $("#checkViernes").prop('disabled', true);
        $("#checkSabado").prop('disabled', true);
        $("#checkDomingo").prop('disabled', true);


    } else if (idHorario == 2) {
        $("#lunesEntrada").prop('disabled', true);
        $("#lunesSalida").prop('disabled', true);
        $("#btnGuardarLun").prop('disabled', true);
        $("#martesEntrada").prop('disabled', false);
        $("#martesSalida").prop('disabled', false);
        $("#btnGuardarMar").prop('disabled', false);
        $("#miercolesEntrada").prop('disabled', true);
        $("#miercolesSalida").prop('disabled', true);
        $("#btnGuardarMie").prop('disabled', true);
        $("#juevesEntrada").prop('disabled', true);
        $("#juevesSalida").prop('disabled', true);
        $("#btnGuardarJue").prop('disabled', true);
        $("#viernesEntrada").prop('disabled', true);
        $("#viernesSalida").prop('disabled', true);
        $("#btnGuardarVie").prop('disabled', true);
        $("#sabadoEntrada").prop('disabled', true);
        $("#sabadoSalida").prop('disabled', true);
        $("#btnGuardarSab").prop('disabled', true);
        $("#domingoEntrada").prop('disabled', true);
        $("#domingoSalida").prop('disabled', true);
        $("#btnGuardarDom").prop('disabled', true);

        $("#checkLunes").prop('disabled', true);
        $("#checkMartes").prop('disabled', false);
        $("#checkMiercoles").prop('disabled', true);
        $("#checkJueves").prop('disabled', true);
        $("#checkViernes").prop('disabled', true);
        $("#checkSabado").prop('disabled', true);
        $("#checkDomingo").prop('disabled', true);
    } else if (idHorario == 3) {
        $("#lunesEntrada").prop('disabled', true);
        $("#lunesSalida").prop('disabled', true);
        $("#btnGuardarLun").prop('disabled', true);
        $("#martesEntrada").prop('disabled', true);
        $("#martesSalida").prop('disabled', true);
        $("#btnGuardarMar").prop('disabled', true);
        $("#miercolesEntrada").prop('disabled', false);
        $("#miercolesSalida").prop('disabled', false);
        $("#btnGuardarMie").prop('disabled', false);
        $("#juevesEntrada").prop('disabled', true);
        $("#juevesSalida").prop('disabled', true);
        $("#btnGuardarJue").prop('disabled', true);
        $("#viernesEntrada").prop('disabled', true);
        $("#viernesSalida").prop('disabled', true);
        $("#btnGuardarVie").prop('disabled', true);
        $("#sabadoEntrada").prop('disabled', true);
        $("#sabadoSalida").prop('disabled', true);
        $("#btnGuardarSab").prop('disabled', true);
        $("#domingoEntrada").prop('disabled', true);
        $("#domingoSalida").prop('disabled', true);
        $("#btnGuardarDom").prop('disabled', true);

        $("#checkLunes").prop('disabled', true);
        $("#checkMartes").prop('disabled', true);
        $("#checkMiercoles").prop('disabled', false);
        $("#checkJueves").prop('disabled', true);
        $("#checkViernes").prop('disabled', true);
        $("#checkSabado").prop('disabled', true);
        $("#checkDomingo").prop('disabled', true);
    } else if (idHorario == 4) {
        $("#lunesEntrada").prop('disabled', true);
        $("#lunesSalida").prop('disabled', true);
        $("#btnGuardarLun").prop('disabled', true);
        $("#martesEntrada").prop('disabled', true);
        $("#martesSalida").prop('disabled', true);
        $("#btnGuardarMar").prop('disabled', true);
        $("#miercolesEntrada").prop('disabled', true);
        $("#miercolesSalida").prop('disabled', true);
        $("#btnGuardarMie").prop('disabled', true);
        $("#juevesEntrada").prop('disabled', false);
        $("#juevesSalida").prop('disabled', false);
        $("#btnGuardarJue").prop('disabled', false);
        $("#viernesEntrada").prop('disabled', true);
        $("#viernesSalida").prop('disabled', true);
        $("#btnGuardarVie").prop('disabled', true);
        $("#sabadoEntrada").prop('disabled', true);
        $("#sabadoSalida").prop('disabled', true);
        $("#btnGuardarSab").prop('disabled', true);
        $("#domingoEntrada").prop('disabled', true);
        $("#domingoSalida").prop('disabled', true);
        $("#btnGuardarDom").prop('disabled', true);

        $("#checkLunes").prop('disabled', true);
        $("#checkMartes").prop('disabled', true);
        $("#checkMiercoles").prop('disabled', true);
        $("#checkJueves").prop('disabled', false);
        $("#checkViernes").prop('disabled', true);
        $("#checkSabado").prop('disabled', true);
        $("#checkDomingo").prop('disabled', true);
    } else if (idHorario == 5) {
        $("#lunesEntrada").prop('disabled', true);
        $("#lunesSalida").prop('disabled', true);
        $("#btnGuardarLun").prop('disabled', true);
        $("#martesEntrada").prop('disabled', true);
        $("#martesSalida").prop('disabled', true);
        $("#btnGuardarMar").prop('disabled', true);
        $("#miercolesEntrada").prop('disabled', true);
        $("#miercolesSalida").prop('disabled', true);
        $("#btnGuardarMie").prop('disabled', true);
        $("#juevesEntrada").prop('disabled', true);
        $("#juevesSalida").prop('disabled', true);
        $("#btnGuardarJue").prop('disabled', true);
        $("#viernesEntrada").prop('disabled', false);
        $("#viernesSalida").prop('disabled', false);
        $("#btnGuardarVie").prop('disabled', false);
        $("#sabadoEntrada").prop('disabled', true);
        $("#sabadoSalida").prop('disabled', true);
        $("#btnGuardarSab").prop('disabled', true);
        $("#domingoEntrada").prop('disabled', true);
        $("#domingoSalida").prop('disabled', true);
        $("#btnGuardarDom").prop('disabled', true);

        $("#checkLunes").prop('disabled', true);
        $("#checkMartes").prop('disabled', true);
        $("#checkMiercoles").prop('disabled', true);
        $("#checkJueves").prop('disabled', true);
        $("#checkViernes").prop('disabled', false);
        $("#checkSabado").prop('disabled', true);
        $("#checkDomingo").prop('disabled', true);
    } else if (idHorario == 6) {
        $("#lunesEntrada").prop('disabled', true);
        $("#lunesSalida").prop('disabled', true);
        $("#btnGuardarLun").prop('disabled', true);
        $("#martesEntrada").prop('disabled', true);
        $("#martesSalida").prop('disabled', true);
        $("#btnGuardarMar").prop('disabled', true);
        $("#miercolesEntrada").prop('disabled', true);
        $("#miercolesSalida").prop('disabled', true);
        $("#btnGuardarMie").prop('disabled', true);
        $("#juevesEntrada").prop('disabled', true);
        $("#juevesSalida").prop('disabled', true);
        $("#btnGuardarJue").prop('disabled', true);
        $("#viernesEntrada").prop('disabled', true);
        $("#viernesSalida").prop('disabled', true);
        $("#btnGuardarVie").prop('disabled', true);
        $("#sabadoEntrada").prop('disabled', false);
        $("#sabadoSalida").prop('disabled', false);
        $("#btnGuardarSab").prop('disabled', false);
        $("#domingoEntrada").prop('disabled', true);
        $("#domingoSalida").prop('disabled', true);
        $("#btnGuardarDom").prop('disabled', true);

        $("#checkLunes").prop('disabled', true);
        $("#checkMartes").prop('disabled', true);
        $("#checkMiercoles").prop('disabled', true);
        $("#checkJueves").prop('disabled', true);
        $("#checkViernes").prop('disabled', true);
        $("#checkSabado").prop('disabled', false);
        $("#checkDomingo").prop('disabled', true);
    } else if (idHorario == 7) {
        $("#lunesEntrada").prop('disabled', true);
        $("#lunesSalida").prop('disabled', true);
        $("#btnGuardarLun").prop('disabled', true);
        $("#martesEntrada").prop('disabled', true);
        $("#martesSalida").prop('disabled', true);
        $("#btnGuardarMar").prop('disabled', true);
        $("#miercolesEntrada").prop('disabled', true);
        $("#miercolesSalida").prop('disabled', true);
        $("#btnGuardarMie").prop('disabled', true);
        $("#juevesEntrada").prop('disabled', true);
        $("#juevesSalida").prop('disabled', true);
        $("#btnGuardarJue").prop('disabled', true);
        $("#viernesEntrada").prop('disabled', true);
        $("#viernesSalida").prop('disabled', true);
        $("#btnGuardarVie").prop('disabled', true);
        $("#sabadoEntrada").prop('disabled', true);
        $("#sabadoSalida").prop('disabled', true);
        $("#btnGuardarSab").prop('disabled', true);
        $("#domingoEntrada").prop('disabled', false);
        $("#domingoSalida").prop('disabled', false);
        $("#btnGuardarDom").prop('disabled', false);

        $("#checkLunes").prop('disabled', true);
        $("#checkMartes").prop('disabled', true);
        $("#checkMiercoles").prop('disabled', true);
        $("#checkJueves").prop('disabled', true);
        $("#checkViernes").prop('disabled', true);
        $("#checkSabado").prop('disabled', true);
        $("#checkDomingo").prop('disabled', false);
    }
}

function validarHorario(idGuardar) {
    var idHorarioIni = "";
    var idHorarioFin = "";
    var idEstatus = 0;
    if (idGuardar == 1) {
         idHorarioIni = $("#lunesEntrada").val();
         idHorarioFin = $("#lunesSalida").val();
        $("#lunesEntrada").prop('disabled', true);
        $("#lunesSalida").prop('disabled', true);
        $("#btnGuardarLun").prop('disabled', true);
        if ($('#checkLunes').is(":checked")) {
            idEstatus = 1;
        }
    } else if (idGuardar == 2) {
        idHorarioIni = $("#martesEntrada").val();
        idHorarioFin = $("#martesSalida").val();
        $("#martesEntrada").prop('disabled', true);
        $("#martesSalida").prop('disabled', true);
        $("#btnGuardarMar").prop('disabled', true);
        if ($('#checkMartes').is(":checked")) {
            idEstatus = 1;
        }
    } else if (idGuardar == 3) {
        idHorarioIni = $("#miercolesEntrada").val();
        idHorarioFin = $("#miercolesSalida").val();
        $("#miercolesEntrada").prop('disabled', true);
        $("#miercolesSalida").prop('disabled', true);
        $("#btnGuardarMie").prop('disabled', true);
        if ($('#checkMiercoles').is(":checked")) {
            idEstatus = 1;
        }

    } else if (idGuardar == 4) {
        idHorarioIni = $("#juevesEntrada").val();
        idHorarioFin = $("#juevesSalida").val();
        $("#juevesEntrada").prop('disabled', true);
        $("#juevesSalida").prop('disabled', true);
        $("#btnGuardarJue").prop('disabled', true);
        if ($('#checkJueves').is(":checked")) {
            idEstatus = 1;
        }
    } else if (idGuardar == 5) {
        idHorarioIni = $("#viernesEntrada").val();
        idHorarioFin = $("#viernesSalida").val();
        $("#viernesEntrada").prop('disabled', true);
        $("#viernesSalida").prop('disabled', true);
        $("#btnGuardarVie").prop('disabled', true);
        if ($('#checkViernes').is(":checked")) {
            idEstatus = 1;
        }
    } else if (idGuardar == 6) {
        idHorarioIni = $("#sabadoEntrada").val();
        idHorarioFin = $("#sabadoSalida").val();
        $("#sabadoEntrada").prop('disabled', true);
        $("#sabadoSalida").prop('disabled', true);
        $("#btnGuardarSab").prop('disabled', true);
        if ($('#checkSabado').is(":checked")) {
            idEstatus = 1;
        }
    } else if (idGuardar == 7) {
        idHorarioIni = $("#viernesEntrada").val();
        idHorarioFin = $("#viernesSalida").val();
        $("#domingoEntrada").prop('disabled', true);
        $("#domingoSalida").prop('disabled', true);
        $("#btnGuardarDom").prop('disabled', true);
        if ($('#checkDomingo').is(":checked")) {
            idEstatus = 1;
        }
    }
    if(idHorarioIni<idHorarioFin){
        validarToken(idGuardar,idHorarioIni,idHorarioFin,idEstatus)
    }else{
        alertify.error("Valide el horario inicial y final.");

    }
}

function validarToken(idGuardar,idHorarioIni,idHorarioFin,idEstatus){
     idGuardarGlb = idGuardar;
     idHorarioIniGlb = idHorarioIni;
     idHorarioFinGlb = idHorarioFin;
     idEstatusGlb = idEstatus;
    var tipoUser = $("#tipoUser").val();
     if(tipoUser==2){
         guardarHorario();
     }else{
         $("#modalTokenHorario").modal();
     }
}

function tokenHorario() {
    var tokenDes = $("#idCodigoAutHor").val();
    var dataEnviar = {
        "token": tokenDes
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Desempeno/Token.php',
        type: 'post',
        success: function (response) {
            if (response > 0) {
                $("#idTokenHorario").val(response);
                // var token = parseInt(response);
                var token = response;
                if (token > 20) {
                    alert("Los Token se estan terminando, favor de avisar al administrador");
                }
                alertify.success("Código correcto.");
                $("#tokenHorarioDes").val(tokenDes);
                guardarHorario();

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

function guardarHorario(){
    var dataEnviar = {
        "idGuardarGlb": idGuardarGlb,
        "idHorarioIniGlb": idHorarioIniGlb,
        "idHorarioFinGlb": idHorarioFinGlb,
        "idEstatusGlb": idEstatusGlb,
    };
    $.ajax({
        data: dataEnviar,
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Configuracion/GuardarHorario.php',
        success: function (retorna) {
            if (retorna == 1) {
                var tipoUser = $("#tipoUser").val();

                if(tipoUser==2){
                    alert("Horario modificado con éxito.");
                    var  recargar = setTimeout(function(){ location.reload() }, 3000);

                }else{
                    actualizarToken();
                }
            } else {
                alertify.error("Error al guardar modificación de horario. Por favor actualice y vuelva a intentar");
            }
        }
    });
}

function actualizarToken(){
    var tokenDes = $("#tokenHorarioDes").val();
    var idToken = $("#idTokenHorario").val();
    var dataEnviar = {
        "idGuardarGlb": idGuardarGlb,
        "idHorarioIniGlb": idHorarioIniGlb,
        "idHorarioFinGlb": idHorarioFinGlb,
        "idEstatusGlb": idEstatusGlb,
        "idToken": idToken,
        "tokenDes": tokenDes,
    };
    $.ajax({
        data: dataEnviar,
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Configuracion/BitacoraToken.php',
        success: function (retorna) {
            if (retorna == 1) {
                alert("Horario modificado con éxito.");
                var  recargar = setTimeout(function(){ location.reload() }, 3000);

            } else {
                alertify.error("Error al guardar modificación de horario. Por favor actualice y vuelva a intentar");
            }
        }
    });
}

