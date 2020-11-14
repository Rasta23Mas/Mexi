var errorToken = 0;
var tokenBitacora = 0;

//consultar contratos
function hayArticulos() {
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Articulos/hayArticulos.php',
        success: function (HayArticulos) {
            if(HayArticulos==1){
                validarMonto();
            }else{
                alert("Por Favor. Ingresa los articulos.");
            }
        }
    });
}

function validarMonto() {
    var totalPrestamo = $("#idTotalPrestamo").val();
    var montoToken = $("#idMontoToken").val();
    var clienteEmpeno = $("#idClienteEmpeno").val();
    var tipoInteres = $("#tipoInteresEmpeno").val();
    var diasAlmoneda = $("#idDiasAlmoneda").val();
    var validate = true;
    if (clienteEmpeno == '' || clienteEmpeno == null) {
        alert("Por Favor. Selecciona un cliente.");
        validate = false;
    } else if (tipoInteres == '' || tipoInteres == null) {
        alert("Por Favor. Selecciona tipo de interes.");
        validate = false;
    } else if (diasAlmoneda == 0) {
        alert("Por Favor. Selecciona los días de almoneda.");
        validate = false;
    }
    if (validate) {
        totalPrestamo = Number(totalPrestamo);
        montoToken = Number(montoToken);
        if(totalPrestamo>=montoToken){
            tokenBitacora =1;
            $("#modalDescuento").modal();
        }else{
            generarContrato();
        }
    }
}

function tokenNuevo() {
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
                generarContrato();

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

//Genera contrato
function generarContrato() {
    //FEErr01
    var totalPrestamo = $("#idTotalPrestamo").val();
    var totalAvaluo = $("#idTotalAvaluo").val();
    var diasAlmonedaValue = $('select[name="diasAlmName"] option:selected').text();
    var fechaVencimiento = $("#idFecVencimiento").text();
    var fechaAlmoneda = $("#idFechaAlm").val();
    var Suma_InteresPrestamo = $("#idTotalInteres").val();

    totalPrestamo = Math.round(totalPrestamo * 100) / 100;
    totalAvaluo = Math.round(totalAvaluo * 100) / 100;
    Suma_InteresPrestamo = Math.round(Suma_InteresPrestamo * 100) / 100;
    var Total_Intereses = Suma_InteresPrestamo - totalPrestamo;
    Total_Intereses = Math.round(Total_Intereses * 100) / 100;
    var tipoFormulario = $("#idTipoFormulario").val();
    var cliente = $("#idClienteEmpeno").val();
    var totalAvaluoLetra = NumeroALetras(totalAvaluo);
    var seguro = $("#idSeguroPorcen").text();
    alert(seguro);
    var dataEnviar = {
        "idCliente": $("#idClienteEmpeno").val(),
        "totalPrestamo": totalPrestamo,
        "totalAvaluo": totalAvaluo,
        "diasAlmonedaValue": diasAlmonedaValue,
        "cotitular": $("#nombreCotitular").val(),
        "beneficiario": $("#idNombreBen").val(),
        "plazo":  $("#idPlazo").text(),
        "periodo":  $("#idPeriodo").text(),
        "tipoInteres":  $("#idTipoInteres").text(),
        "tasa": $("#idTasaPorcen").text(),
        "alm": $("#idAlmPorcen").text(),
        "seguro": $("#idSeguroPorcen").text(),
        "iva": $("#idIvaPorcen").text(),
        "dias": $("#diasInteres").val(),
        "idTipoFormulario":  $("#idTipoFormulario").val(),
        "aforo":  $("#idAforo").val(),
        "fecha_vencimiento":  fechaVencimiento,
        "fecha_almoneda":  fechaAlmoneda,
        "Suma_InteresPrestamo":  Suma_InteresPrestamo,
        "Total_Intereses":  Total_Intereses,
        "totalAvaluoLetra":  totalAvaluoLetra
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Contrato/cContrato.php',
        type: 'post',
        success: function (contrato) {
            alert(contrato)
            if (contrato > 0) {
                actualizarArticulo(contrato,tipoFormulario,cliente);
                var idRefrendoMigracion = $("#idRefrendoMigracion").val();
                idRefrendoMigracion = Math.round(idRefrendoMigracion * 100) / 100;

                var totalPrestamo = $("#idTotalPrestamo").val();
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
                    mov_subtotal,mov_total,mov_efectivo,mov_cambio,idRefrendoMigracion);

            } else {
                alertify.error("Error al generar contrato. (FEErr01)");
            }
        },
    })
}

//Generar PDF
//Reimprimir


function verPDF(id_ContratoPDF) {
    window.open('../PDF/callPdfContrato.php?contrato=' + id_ContratoPDF);
}



//Agrega articulos a la tabla
function actualizarArticulo(ultimoContrato,tipoFormulario,cliente) {
    //FEErr03

    var serie = ultimoContrato.trim();
    var idSerieContrato = serie.padStart(6, "0");
    var dataEnviar = {
        "contrato": ultimoContrato,
        "idSerieContrato": idSerieContrato

    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Articulos/ArticuloUpdate.php',
        type: 'post',

        success: function (response) {
            if (response == -1 || response == 0) {
                alertify.error("Error al agregar articulos al contrato. (FEErr03)");
            } else {
                alertify.success("Articulos agregados al contrato.");
                BitacoraUsuarioEmpeno(ultimoContrato, cliente, 1);
            }
        },
    })


}

//Agrega articulos obsololetos
function fnArticulosObsoletos() {
    //FEErr04
    $.ajax({
        url: '../../../com.Mexicash/Controlador/ArticulosObsoletos.php',
        type: 'post',
        success: function (response) {
            if (response == -1 || response == 0) {
                alertify.error("Error FEErr04.");
            } else {
                $("#idFormEmpeno")[0].reset();
                alertify.success("Bienvenidos");
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

function BitacoraUsuarioEmpeno(contrato, clienteEmpeno, tipoContrato) {
    //id_Movimiento = 3 cat_movimientos-->Operacion-->Empeño
    //FEErr07
    var movimiento = 0;
    if (tipoContrato == 1) {
        movimiento = 3;
    } else if (tipoContrato == 2) {
        movimiento = 7;
    }
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
                if(tokenBitacora==1){
                    var tipoFormulario = $("#idTipoFormulario").val()
                    BitacoraTokenEmpeno(contrato,tipoFormulario,clienteEmpeno);
                }else{
                    setTimeout(function(){  verPDF(contrato); }, 1000);
                    setTimeout(function(){ location.reload() }, 2000);
                }
            } else {
                alertify.error("Error en al conectar con el servidor. (FEErr07)")
            }
        }
    });
}


function BitacoraTokenEmpeno(contrato,tipoFormulario) {
    //tokenMovimiento= 9 ->Monto Electronicos/Metales
    //tokenMovimiento= 10->Monto Auto
    var tipoContrato = 1;
    var token = $("#idToken").val();
    var tokenDescripcion = $("#tokenDescripcion").val();
    var tokenMovimiento = 9;
    var dataEnviar = {
        "contrato": contrato,
        "tipoContrato": tipoContrato,
        "tipoFormulario": tipoFormulario,
        "token": token,
        "tokenDescripcion": tokenDescripcion,
        "tokenMovimiento": tokenMovimiento,
        "importe": tokenMovimiento,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Bitacora/bitacoraToken.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                alertify.success("Token guardado.");
                setTimeout(function(){  verPDF(contrato); }, 1000);
                setTimeout(function(){ location.reload() }, 2000);


            } else {
                alertify.error("Error en al guardar el token")
            }
        }
    });
}


function fnEditarJoyeria() {
    var prestamo = $("#idPrestamo").val();
    prestamo = Math.round(prestamo * 100) / 100;
    if(prestamo==0){
        alert("Por Favor. Calcule el prestamo.")
    }else{
        $("#modalEditarJoyeria").modal();
        $("#idPrestamoCalculado").val(prestamo);
    }

}


function tokenNuevoJoyeria() {
    var tokenDes = $("#idCodigoJoy").val();
    var motivo = $("#idMotivoJoy").val();
    var prestamoCalculado = $("#idPrestamoCalculado").val();
    var prestamoNuevo = $("#idPrestamoNuevo").val();

    if(motivo==''){
        alert("Por Favor.Llena el campo de motivo.");
    }else if(prestamoNuevo==''){
        alert("Por Favor.Llena el campo de nuevo prestamo.");
    }else{
        if(prestamoNuevo<prestamoCalculado){
            fnTokenJoyeria(0,'Precio Menor',motivo,prestamoCalculado,prestamoNuevo);
        }else{
            if(tokenDes==''||tokenDes==0){
                alert("Por Favor.Llena el campo de token.");
            }else {
                var dataEnviar = {
                    "token": tokenDes
                };
                $.ajax({
                    data: dataEnviar,
                    url: '../../../com.Mexicash/Controlador/Desempeno/Token.php',
                    type: 'post',
                    success: function (response) {
                        if (response > 0) {
                            var prestamo= $("#idPrestamo").val();
                            fnTokenJoyeria(response,tokenDes,motivo,prestamo,prestamoNuevo,1);

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
        }
    }
}

function fnTokenJoyeria(response,tokenDes,motivo,prestamo,prestamoNuevo) {
    var dataEnviar = {
        "response": response,
        "tokenDes": tokenDes,
        "motivo": motivo,
        "prestamo": prestamo,
        "prestamoNuevo": prestamoNuevo,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Token/TokenJoyeria.php',
        type: 'post',
        success: function (response) {
            if (response > 0) {
                $("#idPrestamo").val(prestamoNuevo);
                $("#modalEditarJoyeria").modal('hide');//ocultamos el modal
                $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove();//eliminamos el backdrop del modal
                alert("Prestamo modificado correctamente.");
                calculaPrestamoBtn()
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
