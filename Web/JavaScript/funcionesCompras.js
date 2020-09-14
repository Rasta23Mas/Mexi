//Variables Globales
var Interes = 0.00;
var idArticuloGlb = 0;

function fnBuscaridBazarCompras() {
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Compras/ConBuscarIdCompras.php',
        type: 'post',
        success: function (respuesta) {
            if (respuesta == 0) {
                location.reload()
            }else{
                $("#idCompra").val(respuesta);
            }
        },
    })
}

function fnSelectPrendaCompras() {
    var dataEnviar = {
        "clase": 5,
        "idTipoMetal": 0
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/comboMetales.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var html = "";
            html += " <option value=0>Seleccione:</option>"
            var i = 0;
            for (i; i < datos.length; i++) {
                var id_tipo = datos[i].id_tipo;
                var descripcion = datos[i].descripcion;
                html += '<option value=' + id_tipo + '>' + descripcion + '</option>';
            }
            $('#idTipoMetal').html(html);

        }
    });
}

//Agrega articulos obsololetos
function fnArticulosObsoletosCom() {
    //FEErr04
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Vendedor/ArticulosComObsoletos.php',
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

function fnSelectMetalCmb(tipoMetal) {
    fnSelectKilataje(tipoMetal);
    fnSelectCalidad(tipoMetal);
}

function fnSelectKilataje(tipoMetal) {
    var dataEnviar = {
        "clase": 2,
        "idTipoMetal": tipoMetal
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/comboMetales.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var html = "";
            html += " <option value=0>Seleccione:</option>"
            var i = 0;
            for (i; i < datos.length; i++) {
                var idKilataje = datos[i].id_Kilataje;
                var descripcion = datos[i].descripcion;
                html += '<option value=' + idKilataje + '>' + descripcion + '</option>';
            }
            $('#idKilataje').html(html);

        }
    });
}

function fnSelectCalidad(tipoMetal) {
    var dataEnviar = {
        "clase": 3,
        "idTipoMetal": tipoMetal
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/comboMetales.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var html = "";
            html += " <option value=0>Seleccione:</option>"
            var i = 0;
            for (i; i < datos.length; i++) {
                var idCalidad = datos[i].id_calidad;
                var descripcion = datos[i].descripcion;
                html += '<option value=' + idCalidad + '>' + descripcion + '</option>';
            }
            $('#idCalidad').html(html);
        }
    });
}

function fnLlenaPrecioKilataje() {
    var idKil = $("#idKilataje").val();
    var dataEnviar = {
        "clase": 4,
        "idTipoMetal": idKil
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/comboMetales.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var i = 0;
            for (i; i < datos.length; i++) {
                var precio = datos[i].precio;
                $('#idKilatajePrecio').val(precio);
            }
        }
    });
}

function fnCalculaPrestamoPeso(e) {
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) {
        return true;
    }
    var patron;
    patron = /[0-9.]/
    var te;
    te = String.fromCharCode(tecla);
    if (e.keyCode == 13 && !e.shiftKey) {
        var tipoInteresEmpeno = parseFloat($("#tipoInteresEmpeno").val());
        if (tipoInteresEmpeno == 0) {
            alert("Selecciona un tipo de de interes.")
        } else {
            var validate = false;

            if ($("#idTipoMetal").val() == 0) {
                alert("Selecciona un tipo de metal")
            } else if ($("#idKilataje").val() == 0) {
                alert("Selecciona un tipo de kilataje")
            } else if ($("#idCalidad").val() == 0) {
                alert("Selecciona un tipo de calidad")
            } else if ($("#idCantidad").val() == "" || $("#idCantidad").val() == 0) {
                alert("Ingresa el campo de Cantidad")
            } else if ($("#idPeso").val() == "" || $("#idPeso").val() == 0) {
                alert("Ingresa el campo de Peso")
            } else if ($("#idPiedras").val() == "") {
                alert("Ingresa el campo de Piedras")
            } else if ($("#idPesoPiedra").val() == "") {
                alert("Ingresa el campo de Peso Piedras")
            } else if ($("#idPrestamo").val() == "" || $("#idPrestamo").val() == 0) {
                alert("Ingresa el prestamo")
            } else {
                validate = true;
            }
            if (validate) {
                calculaAvaluo();
            }
        }
    } else {
        return patron.test(te);
    }

}

function fnCalculaPrestamoBtn() {
    var validate = false;
    if ($("#idTipoMetal").val() == 0) {
        alert("Selecciona un tipo de metal")
    } else if ($("#idKilataje").val() == 0) {
        alert("Selecciona un tipo de kilataje")
    } else if ($("#idCalidad").val() == 0) {
        alert("Selecciona un tipo de calidad")
    } else if ($("#idCantidad").val() == "" || $("#idCantidad").val() == 0) {
        alert("Ingresa el campo de Cantidad")
    } else if ($("#idPeso").val() == "" || $("#idPeso").val() == 0) {
        alert("Ingresa el campo de Peso")
    } else if ($("#idPiedras").val() == "") {
        alert("Ingresa el campo de Piedras")
    } else if ($("#idPesoPiedra").val() == "") {
        alert("Ingresa el campo de Peso Piedras")
    } else {
        validate = true;
    }
    if (validate) {
        var cantidad = parseInt($("#idCantidad").val());
        var peso = parseFloat($("#idPeso").val());
        var pesoPiedra = parseFloat($("#idPesoPiedra").val());
        var piedras = parseInt($("#idPiedras").val());
        var kilPrecio = parseInt($("#idKilatajePrecio").val());
        alert(kilPrecio)
        var pesoTotalMetal = cantidad * peso;
        var pesoTotalPiedra = piedras * pesoPiedra;
        var pesoTotal = pesoTotalMetal - pesoTotalPiedra;
        var vitrina = pesoTotal * kilPrecio;
        $("#idVitrina").val(vitrina);
    } else {
        $("#idVitrina").val(0);
    }
}

function fnEfectivoCompra(e) {
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) {
        return true;
    }
    var patron;
    patron = /[0-9.]/
    var te;
    te = String.fromCharCode(tecla);
    if (e.keyCode == 13 && !e.shiftKey) {

        var totalValue = $("#idTotalValue").val();
        var efectivo = $("#idEfectivo").val();

        totalValue = Math.floor(totalValue * 100) / 100;
        efectivo = Math.floor(efectivo * 100) / 100;

        if (efectivo < totalValue) {
            alert("El efectivo no puede ser menor que el total a pagar.")
        } else {
            $("#idEfectivo").val("");
            $("#idCambio").val("");
            $("#idEfectivoValue").val("");
            $("#idCambioValue").val("");
            var cambio = efectivo - totalValue;
            cambio = Math.floor(cambio * 100) / 100;

            $("#idEfectivoValue").val(efectivo);
            $("#idCambioValue").val(cambio);
            cambio = formatoMoneda(cambio);
            efectivo = formatoMoneda(efectivo);
            $("#idCambio").val(cambio);
            $("#idEfectivo").val(efectivo);
            $("#idEfectivo").prop('disabled', true);
            $("#btnVenta").prop('disabled', false);
        }
    }
    return patron.test(te);
}
//Limpia la tabla de Articulos
function fnLimpiarCompra() {
    <!--   Limpiar Metales-->
    $("#idTipoMetal").val(0);
    $("#idKilataje").val(0);
    $("#idCalidad").val(0);
    $("#idCantidad").val("");
    $("#idPeso").val("");
    $("#idPesoPiedra").val("");
    $("#idPiedras").val("");
    $("#idPrestamo").val("");
    $("#idAvaluo").val("");
    $("#idObs").val("");
    $("#idDetallePrenda").val("");
    <!--   Limpiar Electronicos-->
    $("#idTipoElectronico").val(0);
    $("#idMarca").val("");
    $("#idVitrina").val("");
    $("#idVitrinaElectronico").val(0);
    $("#idModelo").val("");
    $("#idSerie").val("");
    $("#idPrecioCat").val("");
    $("#idPrestamoElectronico").val("");
    $("#idAvaluoElectronico").val("");
    $("#idObsElectronico").val("");
    $("#idDetallePrendaElectronico").val("");
    $("#idCantidad").val("");
    $("#idPeso").val("");
    $("#idPiedras").val(0);
    $("#idPesoPiedra").val(0);
    idArticuloGlb = 0;
}
//Agrega articulos a la tabla
function fnAgregarArtCompra() {
    var idVendedor = $("#idVendedor").val();
    var vitrina = $("#idVitrina").val();
    var tipoMovimiento = 0;
    if (idVendedor !== 0) {
        if (vitrina !== "") {
            var formElectronico = $("#idTipoElectronico").val();
            var formMetal = $("#idTipoMetal").val();
            if (formMetal !== 0 || formElectronico !== 0) {
                if (formMetal > 0) {
                    var detalle = $("#idDetallePrenda").val();
                    tipoMovimiento = 28;
                    if (detalle == "") {
                        alertify.error("Favor de agregar la descripción de la prenda.");
                    } else {
                        //  si es metal envia tipoAtticulo como 1 si es Electronico corresponde el 2
                        var idSucursalSerie = $("#idSuc").val();
                        idArticuloGlb++;
                        var idArticulo = String(idArticuloGlb);
                        idArticulo = idArticulo.padStart(2, "0");
                        var idContrato = String($("#idCompra").val());
                        var idContratoSerie = idContrato.padStart(6, "0");
                        var descTipoMetal = $('select[name="cmbTipoMetal"] option:selected').text();
                        var descKilataje = $('select[name="cmbKilataje"] option:selected').text();
                        var descCalidad = $('select[name="cmbCalidad"] option:selected').text();
                        var descDetalle = $("#idDetallePrenda").val();
                        var descripcionCorta = descTipoMetal + " " + descKilataje + " " + descCalidad + " " + descDetalle;
                        var id_serieTipo = 2;
                        var SerieBazar = idSucursalSerie + "0" + id_serieTipo + idContratoSerie + idArticulo;

                        var dataEnviar = {
                            "idTipoEnviar": 1,
                            "idTipoMetal": formMetal,
                            "idKilataje": $("#idKilataje").val(),
                            "idCalidad": $("#idCalidad").val(),
                            "idCantidad": $("#idCantidad").val(),
                            "idPeso": $("#idPeso").val(),
                            "idPesoPiedra": $("#idPesoPiedra").val(),
                            "idPiedras": $("#idPiedras").val(),
                            "idVitrina": $("#idVitrina").val(),
                            "idObs": $("#idObs").val(),
                            "idDetallePrenda": $("#idDetallePrenda").val(),
                            "idContrato": 0,
                            "SerieBazar": SerieBazar,
                            "id_serieTipo": id_serieTipo,
                            "tipo_movimiento": tipoMovimiento,
                            "descripcionCorta": descripcionCorta,
                        };
                        $.ajax({
                            data: dataEnviar,
                            url: '../../../com.Mexicash/Controlador/Compras/ConArticuloCompra.php',
                            type: 'post',
                            success: function (response) {
                                if (response == 1) {
                                    fnCargarArticulos();
                                    fnLimpiarSinResetearIdArticulo();
                                    alertify.success("Articulo agregado exitosamente.");
                                } else {
                                    alertify.error("Error al agregar articulo.");
                                }
                            },
                        })
                    }

                } else if (formElectronico > 0) {
                    var detalle = $("#detallePrendaE").val();
                    tipoMovimiento = 29;
                    if (detalle == "") {
                        alertify.error("Favor de agregar la descripción de la prenda.");
                    } else {
                        idArticuloGlb++;

                        var idArticulo = String(idArticuloGlb);
                        idArticulo = idArticulo.padStart(2, "0");
                        var idContrato = String($("#idCompra").val());
                        var idContratoSerie = idContrato.padStart(6, "0");
                        var descTipoElectro = $('select[name="cmbTipoElectronico"] option:selected').text();
                        var descMarca = $('select[name="marcaSelect"] option:selected').text();
                        var descModelo = $('select[name="modeloSelect"] option:selected').text();
                        var descDetalle = $("#idDetallePrendaElectronico").val();
                        var descripcionCorta = descTipoElectro + " " + descMarca + " " + descModelo + " " + descDetalle;
                        var id_serieTipo = 2;
                        var idSucursalSerie = $("#idSuc").val();
                        var SerieBazar = idSucursalSerie + "0" + id_serieTipo + idContratoSerie + idArticulo;

                        //  si es metal envia tipoAtticulo como 1 si es Electronico corresponde el 2
                        var dataEnviar = {
                            "idTipoEnviar": 2,
                            "idTipoElectronico": formElectronico,
                            "idMarca": $("#idMarca").val(),
                            "idEstado": $("#idEstado").val(),
                            "idModelo": $("#idModelo").val(),
                            "idSerie": $("#idSerie").val(),
                            "idVitrina": $("#idVitrina").val(),
                            "idPrecioCat": $("#idPrecioCat").val(),
                            "idObsElectronico": $("#idObsElectronico").val(),
                            "idDetallePrendaElectronico": $("#idDetallePrendaElectronico").val(),
                            "idContrato": 0,
                            "SerieBazar": SerieBazar,
                            "id_serieTipo": id_serieTipo,
                            "tipo_movimiento": tipoMovimiento,
                            "descripcionCorta": descripcionCorta,

                        };
                        $.ajax({
                            data: dataEnviar,
                            url: '../../../com.Mexicash/Controlador/Compras/ConArticuloCompra.php',
                            type: 'post',
                            success: function (response) {
                                if (response == 1) {
                                    fnCargarArticulos();
                                    fnLimpiarSinResetearIdArticulo();
                                    alertify.success("Articulo agregado exitosamente.");
                                } else {
                                    alertify.error("Error al agregar articulo.4");
                                }
                            },
                        })
                    }
                } else {
                    alertify.error("Por Favor. Selecciona un tipo de articulo.");
                }

            }
        } else {
            alertify.error("Por Favor. Ingresa precio vitrina.");
        }
    } else {
        alertify.error("Por Favor. Selecciona un vendedor.");
    }

}

function fnLimpiarSinResetearIdArticulo() {
    <!--   Limpiar Metales-->
    $("#idTipoMetal").val(0);
    $("#idKilataje").val(0);
    $("#idCalidad").val(0);
    $("#idCantidad").val("");
    $("#idPeso").val("");
    $("#idPesoPiedra").val("");
    $("#idPiedras").val("");
    $("#idPrestamo").val("");
    $("#idAvaluo").val("");
    $("#idObs").val("");
    $("#idDetallePrenda").val("");
    <!--   Limpiar Electronicos-->
    $("#idTipoElectronico").val(0);
    $("#idMarca").val("");
    $("#idVitrina").val("");
    $("#idVitrinaElectronico").val(0);
    $("#idModelo").val("");
    $("#idSerie").val("");
    $("#idPrecioCat").val("");
    $("#idPrestamoElectronico").val("");
    $("#idAvaluoElectronico").val("");
    $("#idObsElectronico").val("");
    $("#idDetallePrendaElectronico").val("");
    $("#idCantidad").val("");
    $("#idPeso").val("");
    $("#idPiedras").val(0);
    $("#idPesoPiedra").val(0);
}

//Cargar tabla Articulos
function fnCargarArticulos() {
    var subTotal = 0;
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Vendedor/ConTblArticulosCompras.php',
        dataType: "json",
        success: function (datos) {
            alert("Refrescando tabla.");
            var html = '';
            var i = 0;
            if (datos.length == 0) {
                html += '<tr>' +
                    '<td colspan="7" align="center"> Sin datos a mostrar</td>' +
                    '</tr>';
            } else {
                for (i; i < datos.length; i++) {

                    var id_ArticuloBazar = datos[i].id_ArticuloBazar;
                    var id_serie = datos[i].id_serie;
                    var descripcionCorta = datos[i].descripcionCorta;
                    var observaciones = datos[i].observaciones;
                    var vitrina = datos[i].vitrina;

                    vitrina = parseFloat(vitrina);
                    subTotal +=vitrina;
                    vitrina = formatoMoneda(vitrina);

                    html += '<tr>' +
                        '<td>' + id_serie + '</td>' +
                        '<td>' + descripcionCorta + '</td>' +
                        '<td>' + observaciones + '</td>' +
                        '<td>' + vitrina + '</td>' +
                        '<td><input type="button" class="btn btn-danger" value="Eliminar" ' +
                        'onclick="fnConfirmarEliminarArticulo(' + id_ArticuloBazar + ')"></td>' +
                        '</tr>';
                }

            }
            fnCalcularTotales(subTotal);
            $('#idTBodyArticulos').html(html);
        }
    });


}

function fnConfirmarEliminarArticulo(idArticuloBazar) {
    alertify.confirm('Eliminar',
        'Confirme eliminacion de articulo seleccionado.',
        function () {
            fnEliminarArticulo(idArticuloBazar)
        },
        function () {
            alertify.error('Cancelado')
        });
}


function fnEliminarArticulo(idArticuloBazar) {
    idArticuloGlb--;
    var dataEnviar = {
        "idArticulo": idArticuloBazar
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Vendedor/ConEliminarArticuloCompras.php',
        type: 'post',
        success: function (response) {
            if (response == 1) {
                fnCargarTablaMetales();
                alertify.success("Eliminado con éxito.");
            } else {
                alertify.error("Error al eliminar articulo.");
            }
        },
    })

}

function fnCalcularTotales(subTotal) {
    var subtotalValue = $("#idSubtotalValue").val();
    var ivaValue = $("#iIvaValue").val();
    var totalValue = $("#idTotalValue").val();

    subtotalValue += subTotal;
    $("#idSubtotalValue").val(subtotalValue);
    subtotalValue = formatoMoneda(subtotalValue)
    $("#idSubtotal").val(subtotalValue);


}





















function calculaAvaluo() {
    var tipoInteresEmpeno = parseFloat($("#tipoInteresEmpeno").val());
    if (tipoInteresEmpeno == 0) {
        alert("Selecciona un tipo de de interes.")
    } else {
        var prestamo = parseFloat($("#idPrestamo").val());
        var avaluoImporte = Math.floor(prestamo * 100) / 90;
        avaluoImporte = Math.round(avaluoImporte * 100) / 100;

        $("#idAvaluo").val(avaluoImporte);
    }
}

function calculaAvaluoElec() {
    var tipoInteresEmpeno = $("#tipoInteresEmpeno").val();
    if (tipoInteresEmpeno == 0) {
        alert("Selecciona un tipo de de interes.")
    } else {
        var prestamoElec = $("#idPrestamoElectronico").val();
        if (prestamoElec == '' || prestamoElec == null) {
            if ($("#idTipoElectronico").val() == 0) {
                alert("Selecciona un tipo de electronico")
            } else {
                if ($("#idMarca").val() == 0) {
                    alert("Selecciona una marca")
                } else {
                    if ($("#idModelo").val() == 0) {
                        alert("Selecciona un modelo")
                    } else {
                        if ($("#idPrestamoElectronico").val() == 0) {
                            alert("Ingresa la cantidad de prestamo.")
                        } else {
                            var prestamoElec = parseFloat(prestamoElec);
                            var aforo = $("#idAforo").val();
                            aforo = parseInt(aforo);
                            var avaluoImporteElectronico = Math.floor(prestamoElec * 100) / aforo;
                            avaluoImporteElectronico = Math.round(avaluoImporteElectronico * 100) / 100;
                            $("#idAvaluoElectronico").val(avaluoImporteElectronico);
                        }
                    }
                }
            }
        } else {
            var aforo = $("#idAforo").val();
            aforo = parseInt(aforo);
            var avaluoImporteElectronico = Math.floor(prestamoElec * 100) / aforo;
            avaluoImporteElectronico = Math.round(avaluoImporteElectronico * 100) / 100;
            $("#idAvaluoElectronico").val(avaluoImporteElectronico);
        }
    }
}




function combMarcaVEmpe() {
    $('#idMarca').prop('disabled', false);
    $('#idMarca').val(0);

    var tipoSelect = $('#idTipoElectronico').val();
    var dataEnviar = {
        "tipo": 2,
        "tipoCombo": tipoSelect
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Electronicos/Electronico.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var html = "";
            html += " <option value=0>Seleccione:</option>"
            var i = 0;
            for (i; i < datos.length; i++) {
                var id_marca = datos[i].id_marca;
                var descripcion = datos[i].descripcion;
                html += '<option value=' + id_marca + '>' + descripcion + '</option>';
            }
            $('#idMarca').html(html);
        }
    });
}

function cmbModeloVEmpe() {
    $('#idModelo').prop('disabled', false);
    $('#idModelo').val(0);
    var tipoSelect = $('#idTipoElectronico').val();
    var marcaSelect = $('#idMarca').val();
    var dataEnviar = {
        "tipo": 3,
        "tipoCombo": tipoSelect,
        "marcaCombo": marcaSelect
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Electronicos/Electronico.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var html = "";
            html += " <option value=0>Seleccione:</option>"
            var i = 0;
            for (i; i < datos.length; i++) {
                var id_modelo = datos[i].id_modelo;
                var descripcion = datos[i].descripcion;
                html += '<option value=' + id_modelo + '>' + descripcion + '</option>';
            }
            $('#idModelo').html(html);
        }
    });
}

function llenarDatosElectronico(tipoSelect, marcaSelect, modeloSelect) {
    var dataEnviar = {
        "tipoCombo": tipoSelect,
        "marcaCombo": marcaSelect,
        "modeloCombo": modeloSelect

    };
    $.ajax({
        data: dataEnviar,
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Electronicos/tblElectronico.php',
        dataType: "json",
        success: function (datos) {
            var i = 0;
            for (i; i < datos.length; i++) {
                var tipo = datos[i].tipoE;
                var marca = datos[i].marca;
                var modelo = datos[i].modelo;
                var precio = datos[i].precio;
                var vitrina = datos[i].vitrina;
                var caracteristicas = datos[i].caracteristicas;
                if (tipo == null) {
                    tipo = '';
                }
                if (marca == null) {
                    marca = '';
                }
                if (modelo == null) {
                    modelo = '';
                }
                if (precio == null) {
                    precio = '';
                }
                if (vitrina == null) {
                    vitrina = '';
                }
                if (caracteristicas == null) {
                    caracteristicas = '';
                }

                var pretamoElec = parseFloat(precio);
                var avaluoImporte = Math.floor(pretamoElec * 75) / 100;
                avaluoImporte = pretamoElec + avaluoImporte;
                avaluoImporte = avaluoImporte.toFixed(2)
                avaluoImporte = parseFloat(avaluoImporte)

                $("#idPrestamoElectronico").val(precio);
                $("#idAvaluoElectronico").val(avaluoImporte);
                $("#idVitrinaElectronico").val(vitrina);
                $("#idPrecioCat").val(vitrina);
                $("#idDetallePrendaElectronico").val(caracteristicas);

            }
        }
    });
}

function llenarDatosFromModalCompras($idProducto) {
    var dataEnviar = {
        "tipo": 1,
        "idProducto": $idProducto
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Electronicos/ActualizarTblElectronico.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var i = 0;
            for (i; i < datos.length; i++) {
                var tipoId = datos[i].tipoId;
                var tipoEditar = datos[i].tipoEditar;
                var marcaId = datos[i].marcaId;
                var marca = datos[i].marca;
                var modeloId = datos[i].modeloId;
                var modelo = datos[i].modelo;
                var precio = datos[i].precio;
                var vitrina = datos[i].vitrina;
                var caracteristicas = datos[i].caracteristicas;
                if (tipoId == null) {
                    tipoId = '';
                }
                if (marcaId == null) {
                    marcaId = '';
                }
                if (modeloId == null) {
                    modeloId = '';
                }
                if (tipoEditar == null) {
                    tipoEditar = '';
                }
                if (marca == null) {
                    marca = '';
                }
                if (modelo == null) {
                    modelo = '';
                }
                if (precio == null) {
                    precio = '';
                }
                if (vitrina == null) {
                    vitrina = '';
                }
                if (caracteristicas == null) {
                    caracteristicas = '';
                }
                combMarcaVEmpeFromModal(tipoId);
                cmbModeloVEmpeFromModal(tipoId, marcaId);
                alert("Cargando datos.")
                var pretamoElec = parseFloat(precio);
                var avaluoImporte = Math.floor(pretamoElec * 75) / 100;
                avaluoImporte = pretamoElec + avaluoImporte;
                avaluoImporte = avaluoImporte.toFixed(2)
                avaluoImporte = parseFloat(avaluoImporte)
                $("#idTipoElectronico").val(tipoId);
                $("#idMarca").val(marcaId);
                $("#idModelo").val(modeloId);
                $("#idPrestamoElectronico").val(precio);
                $("#idAvaluoElectronico").val(avaluoImporte);
                $("#idVitrinaElectronico").val(vitrina);
                $("#idPrecioCat").val(vitrina);
                $("#idDetallePrendaElectronico").val(caracteristicas);


            }
        }
    });

}

function combMarcaVEmpeFromModal(tipoId) {
    $('#idMarca').prop('disabled', false);
    $('#idMarca').val(0);

    var tipoSelect = tipoId;
    var dataEnviar = {
        "tipo": 2,
        "tipoCombo": tipoSelect
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Electronicos/Electronico.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var html = "";
            html += " <option value=0>Seleccione:</option>"
            var i = 0;
            for (i; i < datos.length; i++) {
                var id_marca = datos[i].id_marca;
                var descripcion = datos[i].descripcion;
                html += '<option value=' + id_marca + '>' + descripcion + '</option>';
            }
            $('#idMarca').html(html);
        }
    });
}

function cmbModeloVEmpeFromModal(tipoId, marcaId) {
    $('#idModelo').prop('disabled', false);
    $('#idModelo').val(0);
    var tipoSelect = tipoId;
    var marcaSelect = marcaId;
    var dataEnviar = {
        "tipo": 3,
        "tipoCombo": tipoSelect,
        "marcaCombo": marcaSelect
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Electronicos/Electronico.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var html = "";
            html += " <option value=0>Seleccione:</option>"
            var i = 0;
            for (i; i < datos.length; i++) {
                var id_modelo = datos[i].id_modelo;
                var descripcion = datos[i].descripcion;
                html += '<option value=' + id_modelo + '>' + descripcion + '</option>';
            }
            $('#idModelo').html(html);
        }
    });
}




