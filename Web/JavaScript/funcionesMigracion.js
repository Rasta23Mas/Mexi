var radioSelect = 0;

function fnCheckCompra (){
    if (document.getElementById('idCheckCompra').checked)
    {
        $("#idContratoMig").prop('disabled', true);
        fnBuscarIdContrato();
    } else {
        $("#idContratoMig").prop('disabled', false);
    }
}

function fnBuscarIdContrato() {
    var dataEnviar = {
        "tipo": 1
    };
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Migracion/ConMigracion.php',
        type: 'post',
        data: dataEnviar,
        success: function (respuesta) {
            if (respuesta == 0) {
                location.reload()
            } else {
               $("#idContratoMig").val(respuesta)
            }
        },
    })
}

function radioMetal() {
    fnSelectPrendaCompras();
    radioSelect = 1;
}
function radioElect() {
    fnLlenarComboTipoElec();
    radioSelect = 2;
}

function fnBuscarIVACatalogo() {
    $.ajax({
        url: '../../../com.Mexicash/Controlador/Configuracion/ConIvaCatalogo.php',
        type: 'post',
        success: function (respuesta) {
            if (respuesta == 0) {
                location.reload()
            } else {
                IvaCatalogoGlb = respuesta
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
                $("#idFormCompras")[0].reset();
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
        var efectivo = $("#idEfectivoCompra").val();
        efectivo = Math.floor(efectivo * 100) / 100;

        if (efectivo < totalGlb) {
            alert("El efectivo no puede ser menor que el total a pagar.")
        } else {
            $("#idEfectivoCompra").val("");
            $("#idCambioCompra").val("");
            cambioGlb = efectivo - totalGlb;
            cambioGlb = Math.floor(cambioGlb * 100) / 100;
            efectivoGlb = efectivo;
            var cambioFormat = formatoMoneda(cambioGlb);
            efectivo = formatoMoneda(efectivoGlb);
            $("#idCambioCompra").val(cambioFormat);
            $("#idEfectivoCompra").val(efectivo);
            $("#idEfectivoCompra").prop('disabled', true);
            $("#btnCompra").prop('disabled', false);
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

    if (idVendedor !== 0) {
        if (vitrina !== "") {
            var formElectronico = $("#idTipoElectronico").val();
            var formMetal = $("#idTipoMetal").val();
            if (formMetal !== 0 || formElectronico !== 0) {
                var idSucursalSerie = "0" + sucursalGlb;
                if (formMetal > 0) {
                    var detalle = $("#idDetallePrenda").val();
                    tipoMovimientoGlb = 28;
                    if (detalle == "") {
                        alertify.error("Favor de agregar la descripción de la prenda.");
                    } else {
                        //  si es metal envia tipoAtticulo como 1 si es Electronico corresponde el 2

                        idArticuloGlb++;
                        var idArticulo = String(idArticuloGlb);
                        idArticulo = idArticulo.padStart(2, "0");
                        var idContratoSerie = String(idContratoCompraGlb);
                        idContratoSerie = idContratoSerie.padStart(6, "0");
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
                            "idPrecioCompra": $("#idPrecioCompra").val(),
                            "idObs": $("#idObs").val(),
                            "idDetallePrenda": $("#idDetallePrenda").val(),
                            "idContrato": 0,
                            "SerieBazar": SerieBazar,
                            "id_serieTipo": id_serieTipo,
                            "tipo_movimiento": tipoMovimientoGlb,
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
                    tipoMovimientoGlb = 29;
                    if (detalle == "") {
                        alertify.error("Favor de agregar la descripción de la prenda.");
                    } else {
                        idArticuloGlb++;

                        var idArticulo = String(idArticuloGlb);
                        idArticulo = idArticulo.padStart(2, "0");
                        var idContrato = String(idContratoCompraGlb);
                        var idContratoSerie = idContrato.padStart(6, "0");
                        var descTipoElectro = $('select[name="cmbTipoElectronico"] option:selected').text();
                        var descMarca = $('select[name="marcaSelect"] option:selected').text();
                        var descModelo = $('select[name="modeloSelect"] option:selected').text();
                        var descDetalle = $("#idDetallePrendaElectronico").val();
                        var descripcionCorta = descTipoElectro + " " + descMarca + " " + descModelo + " " + descDetalle;
                        var id_serieTipo = 2;

                        var SerieBazar = idSucursalSerie + "0" + id_serieTipo + idContratoSerie + idArticulo;
                        var serie = $("#idSerie").val();
                        //  si es metal envia tipoAtticulo como 1 si es Electronico corresponde el 2
                        var dataEnviar = {
                            "idTipoEnviar": 2,
                            "idTipoElectronico": formElectronico,
                            "idMarca": $("#idMarca").val(),
                            "idEstado": $("#idEstado").val(),
                            "idModelo": $("#idModelo").val(),
                            "idSerie": serie,
                            "idVitrina": $("#idVitrinaElectronico").val(),
                            "idPrecioCat": $("#idPrecioCat").val(),
                            "idObsElectronico": $("#idObsElectronico").val(),
                            "idDetallePrendaElectronico": $("#idDetallePrendaElectronico").val(),
                            "idPrecioCompra": $("#idPrecioCompra").val(),
                            "idContrato": 0,
                            "SerieBazar": SerieBazar,
                            "id_serieTipo": id_serieTipo,
                            "tipo_movimiento": tipoMovimientoGlb,
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
    $("#idPrecioCompra").val("");
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
    var subtotal = 0;
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Vendedor/ConTblArticulosCompras.php',
        dataType: "json",
        success: function (datos) {
            alert("Refrescando tabla.");
            var html = '';
            var i = 0;
            if (datos.length == 0) {
                subtotal = 0;
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
                    var precioCompra = datos[i].precioCompra;
                    precioCompra = parseFloat(precioCompra);

                    vitrina = parseFloat(vitrina);
                    subtotal += precioCompra;
                    vitrina = formatoMoneda(vitrina);
                    precioCompra = formatoMoneda(precioCompra);
                    html += '<tr>' +
                        '<td>' + id_serie + '</td>' +
                        '<td>' + descripcionCorta + '</td>' +
                        '<td>' + observaciones + '</td>' +
                        '<td>' + precioCompra + '</td>' +
                        '<td>' + vitrina + '</td>' +
                        '<td><input type="button" class="btn btn-danger" value="Eliminar" ' +
                        'onclick="fnConfirmarEliminarArticulo(' + id_ArticuloBazar + ')"></td>' +
                        '</tr>';
                }

            }
            fnCalcularTotales(subtotal);
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
        "idArticuloBazar": idArticuloBazar
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Vendedor/ConEliminarArticuloCompras.php',
        type: 'post',
        success: function (response) {
            if (response == 1) {
                fnCargarArticulos();
                alertify.success("Eliminado con éxito.");
            } else {
                alertify.error("Error al eliminar articulo.");
            }
        },
    })

}

function fnCalcularTotales(subtotal) {

    subTotalGlb = Math.round(subtotal * 100) / 100;
    ivaGlb = Math.floor(subTotalGlb * IvaCatalogoGlb) / 100;
    totalGlb = subTotalGlb

    var subtotalFormat = formatoMoneda(subTotalGlb);
    var ivaValueFormat = formatoMoneda(ivaGlb);
    var totalValueFormat = formatoMoneda(totalGlb);
    $("#idSubTotalCompra").val(subtotalFormat);
    $("#idIvaCompra").val(ivaValueFormat);
    $("#idTotalPagarCompra").val(totalValueFormat);


}

function fnLlenarComboTipoElec() {
    var dataEnviar = {
        "tipo": 1,
        "tipoCombo": 0
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
                var id_tipo = datos[i].id_tipo;
                var descripcion = datos[i].descripcion;
                html += '<option value=' + id_tipo + '>' + descripcion + '</option>';
            }
            $('#idTipoElectronico').html(html);
        }
    });
}

function fnCombMarcaVEmpe() {
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

function fnCmbModeloVEmpe() {
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

function fnLlenarDatosElectronico(tipoSelect, marcaSelect, modeloSelect) {
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

function fnValidaciones() {
    var idVendedor = $("#idVendedor").val();

    var validate = true;
    if (idVendedor == 0) {
        alert("Por Favor. Selecciona un vendedor.");
        validate = false;
    } else if (idArticuloGlb == 0) {
        alert("Por Favor. Agrega un artículo.");
        validate = false;
    } else if (cambioGlb == -1) {
        alert("Por Favor. Calcula el cambio.");
        validate = false;
    }
    if (validate) {
        $("#modalCompras").modal();
    }
}

function fnTokenCompras() {
    var tokenDes = $("#idCodigoAut").val();
    var dataEnviar = {
        "token": tokenDes
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Token/ConTokenValidar.php',
        type: 'post',
        success: function (response) {
            if (response > 0) {
                idTokenGlb = response;
                idTokenDescGlb = tokenDes;
                var token = response;
                if (token > 20) {
                    alert("Los Token se estan terminando, favor de avisar al administrador");
                }
                alertify.success("Código correcto.");
                fnGenerarCompra();

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
function fnGenerarCompra() {
    //FEErr01
    var dataEnviar = {
        "tipoMovimiento": tipoMovimientoGlb,
        "idVendedor": $("#idVendedor").val(),
        "subTotal": subTotalGlb,
        "iva": ivaGlb,
        "total": totalGlb,
        "efectivo":efectivoGlb,
        "cambio": cambioGlb,
        "idContratoCompra": idContratoCompraGlb,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Compras/ConGuardarCompra.php',
        type: 'post',
        success: function (contrato) {
            if (contrato > 0) {
                fnUpdateToken();
                fnCierreCajaIndispensable(1,0,0);

            } else {
                alertify.error("Error al generar contrato.");
            }
        },
    })
}

function fnUpdateToken() {
    var dataEnviar = {
        "idTokenSubtotalGlb": subTotalGlb,
        "idTokenIvaGlb": ivaGlb,
        "idTokenTotalGlb": totalGlb,
        "idToken": idTokenGlb,
        "tokenDesc": idTokenDescGlb,
        "idTokenMov": tipoMovimientoGlb,
        "idContratoCompra": idContratoCompraGlb,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Token/TokenCompras.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                fnBitacoraCompra(idTokenGlb);
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
        }
    });
}

function fnBitacoraCompra(token) {
    var dataEnviar = {
        "id_Movimiento": tipoMovimientoGlb,
        "idContratoCompra": idContratoCompraGlb,
        "id_vendedor":  $("#idVendedor").val(),
        "idToken": token,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Bitacora/ConBitacoraCompras.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                verPDFCompra();
            } else {
                alertify.error("Error en al conectar con el servidor.")
            }
        }
    });
}

//Generar PDF
function verPDFCompra() {
    window.open('../PDF/callPdfCompra.php?idContratoCompra=' + idContratoCompraGlb);
    alert("Compra realizada.");
    fnRecargarCompras();
}
function fnRecargarCompras() {
    location.reload();
}



