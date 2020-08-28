//Variables Globales
var Interes = 0.00;
var idArticuloGlb = 0;
var PorcentajeVitrina = .20;


//Limpia la tabla de Articulos
function Limpiar() {
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

function LimpiarSinResetearIdArticulo() {
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

//Agrega articulos a la tabla
function AgregarArtCompra() {
    var idVendedor = $("#idVendedor").val();
    var vitrina = $("#idVitrina").val();
    if (idVendedor != 0) {
        if (vitrina != "") {
            var formElectronico = $("#idTipoElectronico").val();
            var formMetal = $("#idTipoMetal").val();
            if (formMetal != 0 || formElectronico != 0) {
                if (formMetal > 0) {
                    var detalle = $("#idDetallePrenda").val();
                    if (detalle == "") {
                        alertify.error("Favor de agregar la descripción de la prenda.");
                    } else {
                        //  si es metal envia tipoAtticulo como 1 si es Electronico corresponde el 2
                        var metalAvaluo = $("#idAvaluo").val();
                        var metalPrestamo = $("#idPrestamo").val();
                        var idArticulo = 0;
                        idArticuloGlb++;
                        var idArticulo = String(idArticuloGlb);
                        var idArticulo = idArticulo.padStart(2, "0");

                        var dataEnviar = {
                            "idTipoEnviar": 1,
                            "idTipoMetal": formMetal,
                            "idKilataje": $("#idKilataje").val(),
                            "idCalidad": $("#idCalidad").val(),
                            "idCantidad": $("#idCantidad").val(),
                            "idPeso": $("#idPeso").val(),
                            "idPesoPiedra": $("#idPesoPiedra").val(),
                            "idPiedras": $("#idPiedras").val(),
                            "idPrestamo": metalPrestamo,
                            "idAvaluo": metalAvaluo,
                            "idVitrina": $("#idVitrina").val(),
                            "idObs": $("#idObs").val(),
                            "idDetallePrenda": $("#idDetallePrenda").val(),
                            "idArticulo": idArticulo,


                        };
                        $.ajax({
                            data: dataEnviar,
                            url: '../../../com.Mexicash/Controlador/Vendedor/ArticuloCompra.php',
                            type: 'post',
                            success: function (response) {
                                if (response == 1) {
                                    cargarTablaMetales();
                                    $("#divTablaMetales").load('tablaMetalesCompras.php');
                                    LimpiarSinResetearIdArticulo();
                                    alertify.success("Articulo agregado exitosamente.");
                                } else {
                                    alertify.error("Error al agregar articulo.");
                                }
                            },
                        })
                    }

                } else if (formElectronico > 0) {
                    var detalle = $("#detallePrendaE").val();
                    if (detalle == "") {
                        alertify.error("Favor de agregar la descripción de la prenda.");
                    } else {
                        var artiAvaluo = $("#idAvaluoElectronico").val();
                        var artiPrestamo = $("#idPrestamoElectronico").val();
                        var idArticulo = 0;
                        idArticuloGlb++;

                        var idArticulo = String(idArticuloGlb);
                        var idArticulo = idArticulo.padStart(2, "0");

                        //  si es metal envia tipoAtticulo como 1 si es Electronico corresponde el 2
                        var dataEnviar = {
                            "idTipoEnviar": 2,
                            "idTipoElectronico": formElectronico,
                            "idMarca": $("#idMarca").val(),
                            "idEstado": $("#idEstado").val(),
                            "idModelo": $("#idModelo").val(),
                            "idSerie": $("#idSerie").val(),
                            "idPrestamoElectronico": artiPrestamo,
                            "idAvaluoElectronico": artiAvaluo,
                            "idVitrina": $("#idVitrina").val(),
                            "idPrecioCat": $("#idPrecioCat").val(),
                            "idObsElectronico": $("#idObsElectronico").val(),
                            "idDetallePrendaElectronico": $("#idDetallePrendaElectronico").val(),
                            "idArticulo": idArticulo,

                        };
                        $.ajax({
                            data: dataEnviar,
                            url: '../../../com.Mexicash/Controlador/Vendedor/ArticuloCompra.php',
                            type: 'post',
                            success: function (response) {
                                if (response == 1) {
                                    cargarTablaArticulo();
                                    $("#divTablaArticulos").load('tablaArticulos.php');
                                    LimpiarSinResetearIdArticulo();
                                    alertify.success("Articulo agregado exitosamente.");
                                } else {
                                    alertify.error("Error al agregar articulo.1");
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


//Cargar tabla Articulos
function cargarTablaMetales() {
    var metalPrestamo = 0;
    var metalAvaluo = 0;
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Vendedor/tblMetalesCompras.php',
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

                    var tipoMetal = datos[i].tipoMetal;
                    var kilataje = datos[i].kilataje;
                    var calidad = datos[i].calidad;
                    var prestamo = datos[i].prestamo;
                    var avaluo = datos[i].avaluo;

                    var detalle = datos[i].detalle;

                    prestamo = parseFloat(prestamo);
                    avaluo = parseFloat(avaluo);
                    metalPrestamo += prestamo;
                    metalAvaluo += avaluo;
                    prestamo = formatoMoneda(prestamo);
                    avaluo = formatoMoneda(avaluo);
                    if (tipoMetal === null) {
                        tipoMetal = '';
                    }
                    if (kilataje === null) {
                        kilataje = '';
                    }
                    if (calidad === null) {
                        calidad = '';
                    }
                    if (prestamo === null) {
                        prestamo = '';
                    }
                    if (avaluo === null) {
                        avaluo = '';
                    }
                    if (detalle === null) {
                        detalle = '';
                    }
                    html += '<tr>' +
                        '<td>' + tipoMetal + '</td>' +
                        '<td>' + kilataje + '</td>' +
                        '<td>' + calidad + '</td>' +
                        '<td>' + prestamo + '</td>' +
                        '<td>' + avaluo + '</td>' +
                        '<td>' + detalle + '</td>' +
                        '<td><input type="button" class="btn btn-danger" value="Eliminar" ' +
                        'onclick="confirmarEliminarMetales(' + datos[i].id_Articulo + ')"></td>' +
                        '</tr>';
                }

            }
            sumarTotalesMetal(metalPrestamo, metalAvaluo);
            $('#idTBodyMetales').html(html);
        }
    });

    $("#divTablaMetales").load('tablaMetalesCompras.php');

}

function cargarTablaArticulo() {
    var artiPrestamo = 0;
    var artiAvaluo = 0;
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Articulos/tblArticulos.php',
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
                    var tipo = datos[i].tipo;
                    var marca = datos[i].marca;
                    var modelo = datos[i].modelo;
                    var prestamo = datos[i].prestamo;
                    var avaluo = datos[i].avaluo;
                    var detalle = datos[i].detalle;

                    prestamo = parseFloat(prestamo);
                    avaluo = parseFloat(avaluo);
                    artiPrestamo += prestamo;
                    artiAvaluo += avaluo;
                    prestamo = formatoMoneda(prestamo);
                    avaluo = formatoMoneda(avaluo);

                    if (marca === null) {
                        marca = '';
                    }
                    if (modelo === null) {
                        modelo = '';
                    }
                    if (prestamo === null) {
                        prestamo = '';
                    }
                    if (avaluo === null) {
                        avaluo = '';
                    }
                    if (detalle === null) {
                        detalle = '';
                    }
                    html += '<tr>' +
                        '<td>' + tipo + '</td>' +
                        '<td>' + marca + '</td>' +
                        '<td>' + modelo + '</td>' +
                        '<td>' + prestamo + '</td>' +
                        '<td>' + avaluo + '</td>' +
                        '<td>' + detalle + '</td>' +
                        '<td><input type="button" class="btn btn-danger" value="Eliminar" ' +
                        'onclick="confirmarEliminar(' + datos[i].id_Articulo + ')"></td>' +
                        '</tr>';
                }
            }

            sumarTotalesArticulo(artiPrestamo, artiAvaluo);

            $('#idTBodyArticulos').html(html);
        }
    });
    $("#divTablaArticulos").load('tablaArticulos.php');

}

//Alerta para confirmar la Eliminacion
function confirmarEliminar(idArticulo) {
    alertify.confirm('Eliminar',
        'Confirme eliminacion de articulo seleccionado.',
        function () {
            eliminarArticulo($idArticulo)
        },
        function () {
            alertify.error('Cancelado')
        });
}

function confirmarEliminarMetales(idArticulo) {
    alertify.confirm('Eliminar',
        'Confirme eliminacion de articulo seleccionado.',
        function () {
            eliminarMetales(idArticulo)
        },
        function () {
            alertify.error('Cancelado')
        });
}

//Elimina articulos
function eliminarArticulo(idArticulo) {
    idArticuloGlb--;
    var dataEnviar = {
        "$idArticulo": idArticulo
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Vendedor/EliminarArticuloCompras.php',
        type: 'post',
        success: function (response) {
            if (response == 1) {
                cargarTablaArticulo();
                $("#divTablaArticulos").load('tablaArticulos.php');
                alertify.success("Eliminado con éxito.");
            } else {
                alertify.error("Error al eliminar articulo.");
            }
        },
    })

}

function eliminarMetales(idArticulo) {
    idArticuloGlb--;
    var dataEnviar = {
        "idArticulo": idArticulo
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Vendedor/EliminarArticuloCompras.php',
        type: 'post',
        success: function (response) {
            if (response == 1) {
                cargarTablaMetales();
                $("#divTablaMetales").load('tablaMetalesCompras.php');
                alertify.success("Eliminado con éxito.");
            } else {
                alertify.error("Error al eliminar articulo.");
            }
        },
    })

}

function selectMetalCmb($tipoMetal) {
    selectKilataje($tipoMetal);
    selectCalidad($tipoMetal);
}

function selectPrenda() {
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

function selectKilataje($tipoMetal) {
    var dataEnviar = {
        "clase": 2,
        "idTipoMetal": $tipoMetal
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

function llenaPrecioKilataje() {
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

function selectCalidad($tipoMetal) {
    var dataEnviar = {
        "clase": 3,
        "idTipoMetal": $tipoMetal
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
function calculaPrestamoBtn() {
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
            var prestamo = pesoTotal * kilPrecio;

            var aforo = $("#idAforo").val();
            aforo = parseInt(aforo);
            var avaluoImporte = Math.floor(prestamo * 100) / aforo;
            $("#idPrestamo").val(prestamo);
            avaluoImporte = Math.round(avaluoImporte * 100) / 100;
            $("#idAvaluo").val(avaluoImporte);
        } else {
            $("#idPrestamo").val('');
        }
}

function calculaPrestamoPeso(e) {
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) {
        return true;
    }
    var patron;
    patron = /[0-9.]/
    var te;
    te = String.fromCharCode(tecla);
    if (e.keyCode === 13 && !e.shiftKey) {
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

function combMarcaVEmpe() {
    $('#idMarca').prop('disabled', false);
    $('#idMarca').val(0);

    var tipoSelect = $('#idTipoElectronico').val();
    var marcaSelect = 0;
    var modeloSelect = 0;
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
    var modeloSelect = 0;
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
                var idElectronico = datos[i].idElectronico;
                var tipo = datos[i].tipoE;
                var marca = datos[i].marca;
                var modelo = datos[i].modelo;
                var precio = datos[i].precio;
                var vitrina = datos[i].vitrina;
                var caracteristicas = datos[i].caracteristicas;
                if (tipo === null) {
                    tipo = '';
                }
                if (marca === null) {
                    marca = '';
                }
                if (modelo === null) {
                    modelo = '';
                }
                if (precio === null) {
                    precio = '';
                }
                if (vitrina === null) {
                    vitrina = '';
                }
                if (caracteristicas === null) {
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

function llenarDatosFromModal($idProducto) {
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
            for (i = 0; i < datos.length; i++) {
                var idElectronico = datos[i].idElectronico;
                var tipoId = datos[i].tipoId;
                var tipoEditar = datos[i].tipoEditar;
                var marcaId = datos[i].marcaId;
                var marca = datos[i].marca;
                var modeloId = datos[i].modeloId;
                var modelo = datos[i].modelo;
                var precio = datos[i].precio;
                var vitrina = datos[i].vitrina;
                var caracteristicas = datos[i].caracteristicas;
                if (tipoId === null) {
                    tipoId = '';
                }
                if (marcaId === null) {
                    marcaId = '';
                }
                if (modeloId === null) {
                    modeloId = '';
                }
                if (tipoEditar === null) {
                    tipoEditar = '';
                }
                if (marca === null) {
                    marca = '';
                }
                if (modelo === null) {
                    modelo = '';
                }
                if (precio === null) {
                    precio = '';
                }
                if (vitrina === null) {
                    vitrina = '';
                }
                if (caracteristicas === null) {
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



function llenarAforoCompras(tipoFormulario) {
    var dataEnviar = {
        "idTipoFormulario": tipoFormulario
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Articulos/Aforo.php',
        type: 'post',
        dataType: "json",
        success: function (response) {
            if (response.status == 'ok') {
                var porcentajeAforo = response.result.Porcentaje;
                alert(porcentajeAforo);
                $("#idAforo").val(porcentajeAforo);
            }
        },
    })


}

//Agrega articulos obsololetos
function articulosObsoletosCom() {
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