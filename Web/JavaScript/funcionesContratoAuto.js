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
                // var token = parseInt(response);
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
    var chkTarjeta = 0;
    var chkFActura = 0;
    var chkIne = 0;
    var chkImportacion = 0;
    var chkTenencia = 0;
    var chkPoliza = 0;
    var chkLicencia = 0;
    chkTarjeta = 1;
    chkFActura = 1;
    chkIne = 1;
    chkTenencia = 1;
    chkPoliza = 1;
    chkLicencia = 1;
    if ($('#idCheckImportacion').is(":checked")) {
        chkImportacion = 1;
    }
    var diasAlmonedaValue = $('select[name="diasAlmName"] option:selected').text();
    var prestamoAuto = $("#idTotalPrestamoAuto").val();
    var interesAuto = calcularInteresAuto(prestamoAuto);
    var tipoFormulario = $("#idTipoFormulario").val();
    var aforo = $("#idAforo").val();
    var idTipoInteres = $("#idTipoInteres").text();
    var idPeriodo = $("#idPeriodo").text();
    var plazo = $("#idPlazo").text();
    var totalPrestamo = $("#idTotalPrestamoAuto").val();
    var totalAvaluo = $("#idTotalAvaluoAuto").val();
    var fechaVencimiento = $("#idFecVencimiento").text();
    var fechaAlmoneda = $("#idFechaAlm").val();

    totalPrestamo = Math.round(totalPrestamo * 100) / 100;
    totalAvaluo = Math.round(totalAvaluo * 100) / 100;

    var dataEnviar = {
        "idClienteAuto": clienteEmpeno,
        "fechaVencimiento": fechaVencimiento,
        "totalPrestamo": totalPrestamo,
        "totalAvaluo": totalAvaluo,
        "total_Interes": interesAuto,
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
        "fecha_Alm":fechaAlmoneda
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Contrato/cAuto.php',
        type: 'post',
        success: function (contrato) {
            if (contrato > 0) {
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
                var mov_tipoContrato = 1;//Articulos y Electronicos
                var mov_tipoMovimiento = 3;//Empeño
                var mov_Informativo = totalPrestamo;
                var mov_subtotal = 0;
                var mov_total = 0;
                var mov_efectivo = 0;
                var mov_cambio = 0;

                Contrato_Mov(mov_contrato,mov_fechaVencimiento,mov_fechaAlmoneda,mov_prestamo_actual,mov_prestamo_nuevo,mov_descuentoApl,mov_descuentoTotal,
                    mov_abonoTotal,mov_capitalRecuperado,mov_pagoDesempeno,mov_abono,mov_intereses,mov_interes,mov_almacenaje,mov_seguro,
                    mov_moratorios,mov_iva,mov_gps,mov_poliza,mov_pension,mov_costoContrato,mov_tipoContrato,mov_tipoMovimiento,mov_Informativo,
                    mov_subtotal,mov_total,mov_efectivo,mov_cambio);
                BitacoraUsuarioEmpeno(contrato, clienteEmpeno, 2,tipoFormulario);

                //MovimientosContrato(contrato, idTipoInteres, idPeriodo, plazo, totalPrestamo, clienteEmpeno, fechaVencimiento, fechaAlmoneda, 2, totalAvaluo);
                alertify.success("Contrato generado exitosamente.");
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


/*function MovimientosContrato(contrato, idTipoInteres, idPeriodo, plazoEnviado, totalPrestamo, clienteEmpeno,
                             fechaVencimiento, fechaAlmoneda, tipoContrato, totalAvaluo) {
    //FEErr06
    //tipo_movimiento = 3 cat_movimientos-->Operacion-->Empeño
    var movimiento = 0;
    if (tipoContrato == 1) {
        movimiento = 3;
    } else if (tipoContrato == 2) {
        movimiento = 7;
    }
    var id_contrato = contrato;
    var plazo = plazoEnviado;
    var periodo = idPeriodo;
    var tipoInteres = idTipoInteres;
    var s_prestamo_nuevo = totalPrestamo;
    var s_descuento_aplicado = 0;
    var e_capital_recuperado = 0;
    var e_pagoDesempeno = 0;
    var e_abono = 0;
    var e_intereses = 0;
    var e_moratorios = 0;
    var e_iva = 0;
    var e_venta_mostrador = 0;
    var e_venta_iva = 0;
    var e_venta_apartados = 0;
    var e_gps = 0;
    var e_poliza = 0;
    var e_pension = 0;
    var tipo_Contrato = tipoContrato;
    var tipo_movimiento = movimiento;
    var costo_Contrato = 0;

    var dataEnviar = {
        "id_contrato": id_contrato,
        "fechaVencimiento": fechaVencimiento,
        "fechaAlmoneda": fechaAlmoneda,
        "plazo": plazo,
        "periodo": periodo,
        "tipoInteres": tipoInteres,
        "prestamo_actual": s_prestamo_nuevo,
        "totalAvaluo": totalAvaluo,
        "s_prestamo_nuevo": s_prestamo_nuevo,
        "s_descuento_aplicado": s_descuento_aplicado,
        "e_capital_recuperado": e_capital_recuperado,
        "e_pagoDesempeno": e_pagoDesempeno,
        "e_abono": e_abono,
        "e_intereses": e_intereses,
        "e_moratorios": e_moratorios,
        "e_iva": e_iva,
        "e_venta_mostrador": e_venta_mostrador,
        "e_venta_iva": e_venta_iva,
        "e_venta_apartados": e_venta_apartados,
        "e_gps": e_gps,
        "e_poliza": e_poliza,
        "e_pension": e_pension,
        "tipo_Contrato": tipo_Contrato,
        "tipo_movimiento": tipo_movimiento,
        "abonoFinal": 0,
        "descuentoFinal": 0,
        "costo_Contrato": costo_Contrato,
        "prestamo_Informativo": s_prestamo_nuevo,

    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Movimientos/movimientosContrato.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {

            } else {
                alertify.error("Error en al conectar con el servidor. (FEErr06)")
            }
        }
    });
}*/

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
                BitacoraTokenEmpeno(contrato,tipoFormulario,tipoContrato)
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
                var  recargar = setTimeout(function(){  location.reload() }, 3000);
                var  pdfDoc = setTimeout(function(){  verPDFDocumentosCon(contrato); }, 2000);
                var  pdf = setTimeout(function(){ verPDF(contrato); }, 2000);
            } else {
                alertify.error("Error en al guardar el token")
            }
        }
    });
}