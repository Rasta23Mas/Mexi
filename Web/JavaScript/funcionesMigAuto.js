

function validateAutoMig() {

    var validateForm = false;
    if($("#idTipoVehiculo").val()==0){
        $("#idTipoVehiculo").focus();
        alertify.error("Por favor, selecciona el tipo de vehiculo.");
    } else if($("#idMarca").val()==""){
        $("#idMarca").focus();
        alertify.error("Por favor, ingresa la marca.");
    }else if($("#idModelo").val()==""){
        $("#idModelo").focus();
        alertify.error("Por favor, ingresa el modelo.");
    }else if($("#idAnio").val()==""){
        $("#idAnio").focus();
        alertify.error("Por favor, ingresa el año.");
    }else if($("#idColor").val()==""){
        $("#idColor").focus();
        alertify.error("Por favor, selecciona el color.");
    }else if($("#idPlacas").val()==""){
        $("#idPlacas").focus();
        alertify.error("Por favor, ingresa las placas.");
    }else if($("#idFactura").val()==""){
        $("#idFactura").focus();
        alertify.error("Por favor, ingresa la factura.");
    }else if($("#idKms").val()==""){
        $("#idKms").focus();
        alertify.error("Por favor, ingresa el kilometraje.");
    }else if($("#idAgencia").val()==""){
        $("#idAgencia").focus();
        alertify.error("Por favor, ingresa la agencia.");
    }else if($("#idMotor").val()==""){
        $("#idMotor").focus();
        alertify.error("Por favor, ingresa el id del motor.");
    }else if($("#idChasis").val()==""){
        $("#idChasis").focus();
        alertify.error("Por favor, ingresa el número del chasis.");
    }else if($("#idVehiculo").val()==""){
        $("#idVehiculo").focus();
        alertify.error("Por favor, ingresa el VIN.");
    }else if($("#idRepuve").val()==""){
        $("#idRepuve").focus();
        alertify.error("Por favor, ingresa el REPUVE.");
    }else if($("#idGasolina").val()==""){
        $("#idGasolina").focus();
        alertify.error("Por favor, ingresa la gasolina.");
    }else if($("#idTarjeta").val()==""){
        $("#idTarjeta").focus();
        alertify.error("Por favor, ingresa la tarjeta.");
    }else if($("#idAseguradora").val()==""){
        $("#idAseguradora").focus();
        alertify.error("Por favor, ingresa la aseguradora.");
    }else if($("#idPoliza").val()==""){
        $("#idPoliza").focus();
        alertify.error("Por favor, ingresa la poliza.");
    }else if($("#idFechaVencAuto").val()==""){
        $("#idFechaVencAuto").focus();
        alertify.error("Por favor, ingresa la fecha de vencimiento.");
    }else if($("#idTipoPoliza").val()==""){
        $("#idTipoPoliza").focus();
        alertify.error("Por favor, ingresa el tipo de poliza.");
    }else if($("#idObservacionesAuto").val()==""){
        $("#idObservacionesAuto").focus();
        alertify.error("Por favor, ingresa las observaciones.");
    }else{
        validateForm= true;
    }

    if(validateForm){
        $("#modalDescuentoAuto").modal();
    }
}

function tokenNuevoAutoMig() {
    var tokenDes = $("#idCodigoAut").val();
    var dataEnviar = {
        "token": tokenDes
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Desempeno/Token.php',
        type: 'post',
        success: function (response) {
            if (response > 0) {
                $("#idToken").val(response);
                // var token = parseInt(response);
                var token = response;
                if (token > 20) {
                    alert("Los Token se estan terminando, favor de avisar al administrador");
                }
                alertify.success("Código correcto.");
                $("#tokenDescripcion").val(tokenDes);
                fnContratoAutoMig();
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

function fnContratoAutoMig() {
    //FEErr02
    var chkTarjeta = 1;
    var chkFActura = 1;
    var chkIne = 1;
    var chkImportacion = 0;
    var chkTenencia = 1;
    var chkPoliza = 1;
    var chkLicencia = 1;
    if ($('#idCheckImportacion').is(":checked")) {
        chkImportacion = 1;
    }
    var idContratoMig = $("#idContratoMig").val();
    var idFolioMig = $("#idFolioMig").val();
    var idPrestamoMig = $("#idPrestamoMig").val();
    var idAvaluoMig = $("#idAvaluoMig").val();
    var idVitrinaMig = $("#idVitrinaMig").val();
    var idTipoVehiculo = $("#idTipoVehiculo").val();
    var idMarca = $("#idMarca").val();
    var idModelo = $("#idModelo").val();
    var idAnio = $("#idAnio").val();
    var idColor = $("#idColor").val();
    var idPlacas = $("#idPlacas").val();
    var idFactura = $("#idFactura").val();
    var idKms = $("#idKms").val();
    var idAgencia = $("#idAgencia").val();
    var idMotor = $("#idMotor").val();
    var idChasis = $("#idChasis").val();
    var idVehiculo = $("#idVehiculo").val();
    var idRepuve = $("#idRepuve").val();
    var idGasolina = $("#idGasolina").val();
    var idTarjeta = $("#idTarjeta").val();
    var idAseguradora = $("#idAseguradora").val();
    var idPoliza = $("#idPoliza").val();
    var idFechaVencAuto = $("#idFechaVencAuto").val();
    var idTipoPoliza = $("#idTipoPoliza").val();
    var observacionesAuto = $("#idObservacionesAuto").val().trim();
    var idContratoMigSerie = String(idContratoMig);
    idContratoMigSerie = idContratoMigSerie.padStart(6, "0");
    var descripcionCorta = idMarca + " " + idModelo + " " + idColor + " " + idFactura + " " + observacionesAuto;
    idPrestamoMig = Math.round(idPrestamoMig * 100) / 100;
    idAvaluoMig = Math.round(idAvaluoMig * 100) / 100;
    idVitrinaMig = Math.round(idVitrinaMig * 100) / 100;

    var dataEnviar = {
        "idContratoMig": idContratoMig,
        "idFolioMig": idFolioMig,
        "idPrestamoMig": idPrestamoMig,
        "idAvaluoMig": idAvaluoMig,
        "idVitrinaMig": idVitrinaMig,
        "idTipoVehiculo": idTipoVehiculo,
        "idMarca": idMarca,
        "idModelo": idModelo,
        "idAnio": idAnio,
        "idColor": idColor,
        "idPlacas": idPlacas,
        "idFactura": idFactura,
        "idKms": idKms,
        "idAgencia": idAgencia,
        "idMotor": idMotor,
        "idChasis": idChasis,
        "idVehiculo": idVehiculo,
        "idRepuve": idRepuve,
        "idGasolina": idGasolina,
        "idTarjeta": idTarjeta,
        "idAseguradora": idAseguradora,
        "idPoliza": idPoliza,
        "idFechaVencAuto": idFechaVencAuto,
        "idTipoPoliza": idTipoPoliza,
        "observacionesAuto": observacionesAuto,
        "idCheckTarjeta": chkTarjeta,
        "idCheckFactura": chkFActura,
        "idCheckINE": chkIne,
        "idCheckImportacion": chkImportacion,
        "idCheckTenecia": chkTenencia,
        "idCheckPoliza": chkPoliza,
        "idCheckLicencia": chkLicencia,
        "idContratoMigSerie": idContratoMigSerie,
        "descripcionCorta": descripcionCorta,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Migracion/ConGuardarAutoMig.php',
        type: 'post',
        success: function (contrato) {
            alert(contrato)
            if (contrato > 0) {
                BitacoraTokenEmpeno();
            } else {
                alertify.error("Error al generar contrato. (FEErr02)");
            }

        },
    })
}



function BitacoraTokenEmpeno(contrato,tipoFormulario,tipoCon) {
    //tokenMovimiento= 9 ->Monto Electronicos/Metales
    //tokenMovimiento= 10->Monto Auto
    var tipoContrato = tipoCon;
    var token = $("#idToken").val();
    var tokenDescripcion = $("#tokenDescripcion").val();
    var tokenMovimiento = 10;
    var dataEnviar = {
        "contrato": contrato,
        "tipoContrato": tipoContrato,
        "tipoFormulario": tipoFormulario,
        "token": token,
        "tokenDescripcion": tokenDescripcion,
        "tokenMovimiento": tokenMovimiento,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Bitacora/bitacoraToken.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                alertify.success("Token guardado.");
                setTimeout(function(){ location.reload() }, 2000);
            } else {
                alertify.error("Error en al guardar el token")
            }
        }
    });
}
