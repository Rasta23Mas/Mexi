var errorToken = 0;
function validarMontoAuto() {
    var clienteEmpeno = $("#idClienteEmpeno").val();
    var tipoInteres = $("#tipoInteresEmpeno").val();
    var diasAlmoneda = $("#idDiasAlmoneda").val();
    var validate = true;

    if (clienteEmpeno == '' || clienteEmpeno == null) {
        alert("Por Favor. Selecciona un cliente.");
        validate = false;
    } else if (tipoInteres == 0) {
        alert("Por Favor. Selecciona tipo de interes.");
        validate = false;
    } else if (diasAlmoneda == '' || diasAlmoneda == null) {
        alert("Por Favor. Selecciona los días de almoneda.");
        validate = false;
    }
    if (validate) {
        if ($('#idCheckTarjeta').is(":checked")) {
            if ($('#idCheckFactura').is(":checked")) {
                if ($('#idCheckINE').is(":checked")) {
                    if ($('#idCheckTenecia').is(":checked")) {
                        if ($('#idCheckPoliza').is(":checked")) {
                            if ($('#idCheckLicencia').is(":checked")) {
                                validateFormAuto();
                            } else {
                                alert("Por Favor. Solicita copia de la Licencia.");
                            }
                        } else {
                            alert("Por Favor. Solicita Póliza de seguro.");
                        }
                    } else {
                        alert("Por Favor. Solicita las ultimas 5 Tenencias.");
                    }
                } else {
                    alert("Por Favor. Solicita el INE.");
                }
            } else {
                alert("Por Favor. Solicita la Factura.");
            }
        } else {
            alert("Por Favor. Solicita la Tarjeta de circulación.");
        }
    }
}

function validateFormAuto() {

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
    }else if($("#idColor").val()==0){
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

function tokenNuevoAuto() {
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
                var token = response;
                if (token > 20) {
                    alert("Los Token se estan terminando, favor de avisar al administrador");
                }
                alertify.success("Código correcto.");
                $("#tokenDescripcion").val(tokenDes);
                generarContratoAuto();
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

function generarContratoAuto() {
    //FEErr02
    var clienteEmpeno = $("#idClienteEmpeno").val();
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
    var diasAlmonedaValue = $('select[name="diasAlmName"] option:selected').text();
    var tipoFormulario = $("#idTipoFormulario").val();
    var aforo = $("#idAforo").val();
    var totalPrestamo = $("#idTotalPrestamoAuto").val();
    var totalAvaluo = $("#idTotalAvaluoAuto").val();
    var fechaVencimiento = $("#idFecVencimiento").text();
    var fechaAlmoneda = $("#idFechaAlm").val();
    var prestamoAuto = $("#idTotalPrestamoAuto").val();
    var interesAuto = calcularInteresAuto(prestamoAuto);

    totalPrestamo = Math.round(totalPrestamo * 100) / 100;
    totalAvaluo = Math.round(totalAvaluo * 100) / 100;
    var totalAvaluoLetra = NumeroALetras(totalAvaluo);
    var dataEnviar = {
        "idClienteAuto": clienteEmpeno,
        "fechaVencimiento": fechaVencimiento,
        "totalPrestamo": totalPrestamo,
        "totalAvaluo": totalAvaluo,
        "total_Inter": interesAuto,
        "sumaInteresPrestamo": $("#idSumaInteresPrestamo").val(),
        "polizaSeguro": $("#idPolizaSeguro").val(),
        "gps": $("#idGPS").val(),
        "pension": $("#idPension").val(),
        "beneficiario": $("#idNombreBen").val(),
        "cotitular": $("#nombreCotitular").val(),
        "plazo":  $("#idPlazo").text(),
        "periodo":  $("#idPeriodo").text(),
        "idTipoInteres":  $("#idTipoInteres").text(),
        "tasa": $("#idTasaPorcen").text(),
        "alm": $("#idAlmPorcen").text(),
        "seguro": $("#idSeguroPorcen").text(),
        "iva": $("#idIvaPorcen").text(),
        "dias": $("#diasInteres").val(),
        "idTipoFormulario": tipoFormulario,
        "aforo": aforo,
        "idTipoVehiculo": $("#idTipoVehiculo").val(),
        "idMarca": $("#idMarca").val(),
        "idModelo": $("#idModelo").val(),
        "idAnio": $("#idAnio").val(),
        "idColor": $("#idColor").val(),
        "idPlacas": $("#idPlacas").val(),
        "idFactura": $("#idFactura").val(),
        "idKms": $("#idKms").val(),
        "idAgencia": $("#idAgencia").val(),
        "idMotor": $("#idMotor").val(),
        "idSerie": $("#idChasis").val(),
        "idVehiculo": $("#idVehiculo").val(),
        "idRepuve": $("#idRepuve").val(),
        "idGasolina": $("#idGasolina").val(),
        "idAseguradora": $("#idAseguradora").val(),
        "idTarjeta": $("#idTarjeta").val(),
        "idPoliza": $("#idPoliza").val(),
        "idFechaVencAuto": $("#idFechaVencAuto").val(),
        "idTipoPoliza": $("#idTipoPoliza").val(),
        "idObservacionesAuto": $("#idObservacionesAuto").val().trim(),
        "idCheckTarjeta": chkTarjeta,
        "idCheckFactura": chkFActura,
        "idCheckINE": chkIne,
        "idCheckImportacion": chkImportacion,
        "idCheckTenecia": chkTenencia,
        "idCheckPoliza": chkPoliza,
        "idCheckLicencia": chkLicencia,
        "diasAlmoneda": diasAlmonedaValue,
        "fecha_Alm":fechaAlmoneda,
        "totalAvaluoLetra":  totalAvaluoLetra
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Contrato/cAuto.php',
        type: 'post',
        success: function (contrato) {
            if (contrato > 0) {
                var idRefrendoMigracion = $("#idRefrendoMigracion").val();
                idRefrendoMigracion = Math.round(idRefrendoMigracion * 100) / 100;

                var mov_contrato = contrato;
                var mov_fechaVencimiento = fechaVencimiento;
                var mov_fechaAlmoneda = fechaAlmoneda;
                var mov_prestamo_actual = totalPrestamo;
                var mov_prestamo_nuevo = totalPrestamo;
                var mov_descuentoApl = 0;
                var mov_descuentoTotal = 0;
                var mov_abonoTotal = 0;
                var mov_capitalRecuperado = 0;
                var mov_pagoDesempeno = 0;
                var mov_abono = 0;
                var mov_intereses = 0;
                var mov_interes = 0;
                var mov_almacenaje = 0;
                var mov_seguro = 0;
                var mov_moratorios = 0;
                var mov_iva = 0;
                var mov_gps = 0;
                var mov_poliza = 0;
                var mov_pension = 0;
                var mov_costoContrato = 0;
                var mov_tipoContrato = 2;//Articulos y Electronicos
                var mov_tipoMovimiento = 7;//Empeño
                var mov_Informativo = totalPrestamo;
                var mov_subtotal = 0;
                var mov_total = 0;
                var mov_efectivo = 0;
                var mov_cambio = 0;

                Contrato_Mov(mov_contrato,mov_fechaVencimiento,mov_fechaAlmoneda,mov_prestamo_actual,mov_prestamo_nuevo,mov_descuentoApl,mov_descuentoTotal,
                    mov_abonoTotal,mov_capitalRecuperado,mov_pagoDesempeno,mov_abono,mov_intereses,mov_interes,mov_almacenaje,mov_seguro,
                    mov_moratorios,mov_iva,mov_gps,mov_poliza,mov_pension,mov_costoContrato,mov_tipoContrato,mov_tipoMovimiento,mov_Informativo,
                    mov_subtotal,mov_total,mov_efectivo,mov_cambio,idRefrendoMigracion);
                BitacoraUsuarioEmpeno(contrato, clienteEmpeno, 2,tipoFormulario);

            } else {
                alertify.error("Error al generar contrato. (FEErr02)");
            }

        },
    })
}

//Limpia la tabla cuando cambia el tipo de articulo
function limpiarTabla() {
    //FEErr05
    $.ajax({
        url: '../../../com.Mexicash/Controlador/ArticulosObsoletos.php',
        type: 'post',
        success: function (response) {
            if (response == -1 || response == 0) {
                alertify.error("Error FEErr05");
            } else {
                alertify.warning("Se limpio tabla por modificar el tipo de articulo.");
            }
        },
    })
}

//Canelar
function cancelar() {
    $("#idFormEmpeno")[0].reset();
    $("#idFormAuto")[0].reset();
    alertify.success("Contrato cancelado");
}

function BitacoraUsuarioEmpeno(contrato, clienteEmpeno, tipoContrato,tipoFormulario) {
    var movimiento = 7;
    var id_Movimiento = movimiento;
    var id_contrato = contrato;
    var id_almoneda = 0;
    var id_cliente = clienteEmpeno;
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
                BitacoraTokenEmpeno(contrato,tipoFormulario,tipoContrato);
            } else {
                alertify.error("Error en al conectar con el servidor. (FEErr07)")
            }
        }
    });
}

function verPDF(id_ContratoPDF) {
    window.open('../PDF/callPdfContrato.php?pdf=1&contrato=' + id_ContratoPDF);
}

function verPDFDocumentosCon(id_ContratoPDF) {
    window.open('../PDF/callPdfAutoDocumentos.php?pdf=1&contrato=' + id_ContratoPDF);
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
                setTimeout(function(){  verPDFDocumentosCon(contrato); }, 2000);
                setTimeout(function(){  verPDF(contrato); }, 1000);
                setTimeout(function(){ location.reload() }, 2000);
            } else {
                alertify.error("Error en al guardar el token")
            }
        }
    });
}
