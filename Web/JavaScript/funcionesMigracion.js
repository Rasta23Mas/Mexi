var radioSelect = 0;
var idArticuloGlb = 0;
var sucursalGlb = 0;
var checkCompraGlb = 0;
var sucursalGlb = 0;
function fnCargarSucursal(sucursal) {
    sucursalGlb = sucursal;
}

function fnValidarContrato() {
    var idContratoSerie = $("#idContratoMig").val();
    if(idContratoSerie!=""){
        var dataEnviar = {
            "tipo": 2,
            "idContratoSerie": idContratoSerie,
            "checkCompraGlb": checkCompraGlb,
        };
        $.ajax({
            url: '../../../com.Mexicash/Controlador/Migracion/ConMigracion.php',
            type: 'post',
            data: dataEnviar,
            success: function (respuesta) {
                if (respuesta == 0) {
                    $("#idFolioMig").prop('disabled', false);
                    $("#idMetalesRadio").prop('disabled', false);
                    $("#idElectroRadio").prop('disabled', false);
                    $("#idPrestamoMig").prop('disabled', false);
                    $("#idAvaluoMig").prop('disabled', false);
                    $("#idVitrinaMig").prop('disabled', false);
                    $("#idDetallePrenda").prop('disabled', false);
                    $("#idObs").prop('disabled', false);
                    $("#btnAgregar").prop('disabled', false);
                    $("#btnCompra").prop('disabled', false);
                    $("#idContratoMig").prop('disabled', true);
                    $("#idCheckCompra").prop('disabled', true);
                } else {
                    alert("El contrato ya esta en el bazar.");
                }
            },
        })
    }else{
        alert("Por favor, ingrese número de contrato.");
    }
}

function fnCheckCompra() {
    if (document.getElementById('idCheckCompra').checked) {
        $("#idContratoMig").prop('disabled', true);
        fnBuscarIdContrato();
    } else {
        $("#idContratoMig").prop('disabled', false);
        $("#idContratoMig").val('');
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
                $("#idContratoMig").val(respuesta);
                checkCompraGlb= 1;
            }
        },
    })
}

function radioMetal() {
    fnSelectPrendaCompras();
    $(".classMetales").show();
    $(".classElect").hide();
    radioSelect = 1;
    $("#idTipoMetal").prop('disabled', false);
    $("#idKilataje").prop('disabled', false);
    $("#idCalidad").prop('disabled', false);
    $("#idPiezas").prop('disabled', false);
    $("#idCantidad").prop('disabled', false);
    $("#idPeso").prop('disabled', false);
    $("#idPiedras").prop('disabled', false);
    $("#idPesoPiedra").prop('disabled', false);

    $("#idTipoElectronico").prop('disabled', true);
    $("#idMarca").prop('disabled', true);
    $("#idModelo").prop('disabled', true);
    $("#idSerie").prop('disabled', true);
    $("#idIMEI").prop('disabled', true);
    $("#idTipoElectronico").val(0);
    $("#idMarca").val(0);
    $("#idModelo").val(0);
    $("#idSerie").val("");
    $("#idIMEI").val("");

}

function radioElect() {
    fnLlenarComboTipoElec();
    $(".classMetales").hide();
    $(".classElect").show();
    radioSelect = 2;
    $("#idTipoMetal").prop('disabled', true);
    $("#idKilataje").prop('disabled', true);
    $("#idCalidad").prop('disabled', true);
    $("#idPiezas").prop('disabled', true);
    $("#idCantidad").prop('disabled', true);
    $("#idPeso").prop('disabled', true);
    $("#idPiedras").prop('disabled', true);
    $("#idPesoPiedra").prop('disabled', true);
    $("#idTipoMetal").val(0);
    $("#idKilataje").val(0);
    $("#idCalidad").val(0);
    $("#idPiezas").val("");
    $("#idCantidad").val("");
    $("#idPeso").val("");
    $("#idPiedras").val("");
    $("#idPesoPiedra").val("");

    $("#idTipoElectronico").prop('disabled', false);
    $("#idMarca").prop('disabled', false);
    $("#idModelo").prop('disabled', false);
    $("#idSerie").prop('disabled', false);
    $("#idIMEI").prop('disabled', false);

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

//Limpia la tabla de Articulos
function fnLimpiarMig() {
    idArticuloGlb = 0;
    location.reload();
}

//Agrega articulos a la tabla
function fnAgregarArtMig() {
    var vitrina = $("#idVitrinaMig").val();
    if (vitrina !== "") {
        if (radioSelect !== 0) {
            var detalle = $("#idDetallePrenda").val();
            if (detalle == "") {
                alertify.error("Favor de agregar la descripción de la prenda.");
            } else {
                //  si es metal envia tipoAtticulo como 1 si es Electronico corresponde el 2
                idArticuloGlb++;
                var idArticulo = String(idArticuloGlb);
                idArticulo = idArticulo.padStart(2, "0");
                var idContrato = $("#idContratoMig").val();
                var idFolioMig = $("#idFolioMig").val();
                var idContratoSerie = idContrato.padStart(6, "0");
                var descTipoMetal = 0;
                var descKilataje = 0;
                var descCalidad = 0;
                var descTipoElectro = 0;
                var descMarca = 0;
                var descModelo = 0;
                var descripcionCorta = 0;
                var SerieBazar = '';
                var id_serieTipo = "03";
                var tipo_enviar = 0;
                var idTipoMetal = 0;
                var idKilataje = 0;
                var idCalidad = 0;
                var idPiezas = 0;
                var idCantidad = 0;
                var idPeso = 0;
                var idPiedras = 0;
                var idPesoPiedra = 0;
                var idTipoElectronico = 0;
                var idMarca = 0;
                var idModelo = 0;
                var idSerie = 0;
                var idIMEI = 0;

                var idPrestamoMig = $("#idPrestamoMig").val();
                var idAvaluoMig = $("#idAvaluoMig").val();
                var idVitrinaMig = $("#idVitrinaMig").val();
                idPrestamoMig = Math.round(idPrestamoMig * 100) / 100;
                idAvaluoMig = Math.round(idAvaluoMig * 100) / 100;
                idVitrinaMig = Math.round(idVitrinaMig * 100) / 100;
                var descDetalle = $("#idDetallePrenda").val();
                var idObs = $("#idObs").val();
                var tipo_movimiento = 33;
                var idSucursalSerie = "0" + sucursalGlb;
                var tipoCMB = 0
                if (radioSelect == 1) {
                    tipo_enviar = 1;
                    descTipoMetal = $('select[name="cmbTipoMetal"] option:selected').text();
                    descKilataje = $('select[name="cmbKilataje"] option:selected').text();
                    descCalidad = $('select[name="cmbCalidad"] option:selected').text();
                    descripcionCorta = descTipoMetal + " " + descKilataje + " " + descCalidad + " " + descDetalle;
                    SerieBazar = idSucursalSerie + id_serieTipo + idContratoSerie + idArticulo;
                    idTipoMetal = $("#idTipoMetal").val();
                    tipoCMB=idTipoMetal;
                    idKilataje = $("#idKilataje").val();
                    idCalidad = $("#idCalidad").val();
                    idPiezas = $("#idPiezas").val();
                    idCantidad = $("#idCantidad").val();
                    idPeso = $("#idPeso").val();
                    idPiedras = $("#idPiedras").val();
                    idPesoPiedra = $("#idPesoPiedra").val();
                } else {
                    tipo_enviar = 2;
                    descTipoElectro = $('select[name="cmbTipoElectronico"] option:selected').text();
                    descMarca = $('select[name="marcaSelect"] option:selected').text();
                    descModelo = $('select[name="modeloSelect"] option:selected').text();
                    descripcionCorta = descTipoElectro + " " + descMarca + " " + descModelo + " " + descDetalle;
                    SerieBazar = idSucursalSerie + id_serieTipo + idContratoSerie + idArticulo;
                    idTipoElectronico = $("#idTipoElectronico").val();
                    tipoCMB=idTipoElectronico;
                    idMarca = $("#idMarca").val();
                    idModelo = $("#idModelo").val();
                    idSerie = $("#idSerie").val();
                    idIMEI = $("#idIMEI").val();
                }

                var dataEnviar = {
                    "idTipoEnviar": tipo_enviar,
                    "idContrato": idContrato,
                    "idFolioMig": idFolioMig,
                    "idKilataje": idKilataje,
                    "idCalidad": idCalidad,
                    "idPiezas": idPiezas,
                    "idCantidad": idCantidad,
                    "idPeso": idPeso,
                    "idPiedras": idPiedras,
                    "idPesoPiedra": idPesoPiedra,
                    "idMarca": idMarca,
                    "idModelo": idModelo,
                    "idSerie": idSerie,
                    "idIMEI": idIMEI,
                    "idPrestamoMig": idPrestamoMig,
                    "idAvaluoMig": idAvaluoMig,
                    "idVitrinaMig": idVitrinaMig,
                    "descDetalle": descDetalle,
                    "idObs": idObs,
                    "SerieBazar": SerieBazar,
                    "id_serieTipo": id_serieTipo,
                    "tipo_movimiento": tipo_movimiento,
                    "descripcionCorta": descripcionCorta,
                    "tipoCMB": tipoCMB,
                    "checkCompraGlb": checkCompraGlb,
                };
                $.ajax({
                    data: dataEnviar,
                    url: '../../../com.Mexicash/Controlador/Migracion/ConArticuloMig.php',
                    type: 'post',
                    success: function (response) {
                        if (response == 1) {
                            fnCargarArticulosMig();
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
    } else {
        alertify.error("Por Favor. Ingresa precio vitrina.");
    }
}


function fnLimpiarSinResetearIdArticulo() {
    $("#idTipoMetal").prop('disabled', true);
    $("#idKilataje").prop('disabled', true);
    $("#idCalidad").prop('disabled', true);
    $("#idPiezas").prop('disabled', true);
    $("#idCantidad").prop('disabled', true);
    $("#idPeso").prop('disabled', true);
    $("#idPiedras").prop('disabled', true);
    $("#idPesoPiedra").prop('disabled', true);

    $("#idTipoElectronico").prop('disabled', true);
    $("#idMarca").prop('disabled', true);
    $("#idModelo").prop('disabled', true);
    $("#idSerie").prop('disabled', true);
    $("#idIMEI").prop('disabled', true);
    $(".classMetales").hide();
    $(".classElect").hide();

    //valida primero el contrato
    $("#idFolioMig").prop('disabled', true);
    $("#idMetalesRadio").prop('disabled', true);
    $("#idElectroRadio").prop('disabled', true);
    $("#idPrestamoMig").prop('disabled', true);
    $("#idAvaluoMig").prop('disabled', true);
    $("#idVitrinaMig").prop('disabled', true);
    $("#idDetallePrenda").prop('disabled', true);
    $("#idObs").prop('disabled', true);
    $("#btnAgregar").prop('disabled', true);
    $("#btnCompra").prop('disabled', false);
}

function fnCargarArticulosMig() {
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Migracion/ConTblArticulosMig.php',
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
                    var prestamo = datos[i].prestamo;
                    prestamo = parseFloat(prestamo);
                    vitrina = parseFloat(vitrina);

                    vitrina = formatoMoneda(vitrina);
                    prestamo = formatoMoneda(prestamo);
                    html += '<tr>' +
                        '<td>' + id_serie + '</td>' +
                        '<td>' + descripcionCorta + '</td>' +
                        '<td>' + observaciones + '</td>' +
                        '<td>' + prestamo + '</td>' +
                        '<td>' + vitrina + '</td>' +
                        '<td><input type="button" class="btn btn-danger" value="Eliminar" ' +
                        'onclick="fnConfirmarEliminarMig(' + id_ArticuloBazar + ')"></td>' +
                        '</tr>';
                }

            }
            $('#idTBodyArticulosMig').html(html);
        }
    });


}

function fnConfirmarEliminarMig(idArticuloBazar) {
    alertify.confirm('Eliminar',
        'Confirme eliminacion de articulo seleccionado.',
        function () {
            fnEliminarArticuloMig(idArticuloBazar)
        },
        function () {
            alertify.error('Cancelado')
        });
}

function fnEliminarArticuloMig(idArticuloBazar) {
    idArticuloGlb--;
    var dataEnviar = {
        "idArticuloBazar": idArticuloBazar
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Migracion/ConEliminarArticuloMig.php',
        type: 'post',
        success: function (response) {
            if (response == 1) {
                fnCargarArticulosMig();
                alertify.success("Eliminado con éxito.");
            } else {
                alertify.error("Error al eliminar articulo.");
            }
        },
    })

}


