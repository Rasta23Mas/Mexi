//Funcion agregar cliente
function agregarVendedor() {
    //  si es metal envia tipoAtticulo como 1 si es Electronico corresponde el 2
    var idNombre = $("#idNombre").val();
    var idApPat = $("#idApPat").val();
    var idSexo = $("#idSexo").val();
    var idFechaNac = $("#idFechaNac").val();
    var idCelular = $("#idCelular").val();
    var idIdentificacion = $("#idIdentificacion").val();
    var idNumIdentificacion = $("#idNumIdentificacion").val();
    var idEstado = $("#idEstado").val();
    var idMunicipio = $("#idMunicipio").val();
    var idLocalidad = $("#idLocalidad").val();
    var idCalle = $("#idCalle").val();
    var idNumExt = $("#idNumExt").val();
    var validacion = true;
    if (idNombre == "" || idNombre == null) {
        alert("Por favor ingrese un nombre.");
        validacion = false;
    } else if (idApPat == "" || idApPat == null) {
        alert("Por favor ingrese apellido paterno.");
        validacion = false;
    } else if (idSexo == 0 || idSexo == null) {
        alert("Por favor seleccione el campo sexo.");
        validacion = false;
    } else if (idFechaNac == "" || idFechaNac == null) {
        alert("Por favor ingrese fecha de nacimiento.");
        validacion = false;
    } else if (idCelular == "" || idCelular == null) {
        alert("Por favor ingrese numero celular.");
        validacion = false;
    } else if (idIdentificacion == 0 || idIdentificacion == null) {
        alert("Por favor ingrese tipo de identificacion.");
        validacion = false;
    } else if (idNumIdentificacion == "" || idNumIdentificacion == null) {
        alert("Por favor ingrese número de identificación.");
        validacion = false;
    } else if (idEstado == 0 || idEstado == null) {
        alert("Por favor seleccione un estado.");
        validacion = false;
    } else if (idMunicipio == 0 || idMunicipio == null) {
        alert("Por favor seleccione un municipio.");
        validacion = false;
    } else if (idLocalidad == 0 || idLocalidad == null) {
        alert("Por favor seleccione una Localidad.");
        validacion = false;
    } else if (idCalle == "" || idCalle == null) {
        alert("Por favor ingrese la calle.");
        validacion = false;
    } else if (idNumExt == "" || idNumExt == null) {
        alert("Por favor ingrese número exterior.");
        validacion = false;
    }


    if (validacion == true) {
        var dataEnviar = {
            "idNombre": idNombre,
            "idApPat": idApPat,
            "idApMat": $("#idApMat").val(),
            "idSexo": idSexo,
            "idFechaNac": idFechaNac,
            "idRfc": $("#idRfc").val(),
            "idCurp": $("#idCurp").val(),
            "idCelular": idCelular,
            "idTelefono": $("#idTelefono").val(),
            "idCorreo": $("#idCorreo").val(),
            "idOcupacion": $("#idOcupacion").val(),
            "idIdentificacion": idIdentificacion,
            "idNumIdentificacion": idNumIdentificacion,
            "idEstado": idEstado,
            "idMunicipio": idMunicipio,
            "idLocalidad": idLocalidad,
            "idCalle": idCalle,
            "idCP": $("#idCP").val(),
            "idNumExt": idNumExt,
            "idNumInt": $("#idNumInt").val(),
            "idPromocion": $("#idPromocion").val(),
            "idMensajeInterno": $("#idMensajeInterno").val().trim()
        };
        $.ajax({
            data: dataEnviar,
            url: '../../../com.Mexicash/Controlador/Vendedor/RegistroVendedor.php',
            type: 'post',
            success: function (response) {
                if (response == 1) {
                    $("#idFormRegistroVen")[0].reset();
                    $("#modalRegistroVenNuevo").modal('hide');//ocultamos el modal
                    $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove();//eliminamos el backdrop del modal
                    buscarVendedorAgregado();
                    alertify.success("Vendedor agregado.");
                } else {
                    alertify.error("Error al agregar vendedor.");
                }
            },
        })
    }

}

//Funcion para traer datos de cliente agregado
function buscarVendedorAgregado() {
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Vendedor/BuscarVendedorAgregado.php',
        dataType: "json",
        success: function (response) {
            if (response.status == 'ok') {
                $("#idVendedor").val(response.result.id_Vendedor);
                $("#idNombresVendedor").val(response.result.NombreCompleto);
                $("#idCelularVendedor").val(response.result.celular);
                $("#idDireccionVendedor").val(response.result.direccionCompleta);
                $("#btnEditar").prop('disabled', false);
            }
        }
    });
}

//Funcion autocompletar nombre de cliente
function nombreVenAutocompletar() {
    $('#idNombresVendedor').on('keyup', function () {
        var key = $('#idNombresVendedor').val();
        var dataEnviar = {
            "idNombres": key
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Vendedor/AutocompleteVendedor.php',
            data: dataEnviar,
            success: function (data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestionsNombreEmpeno').fadeIn(1000).html(data);
                //Al hacer click en alguna de las sugerencias
                $('.suggest-element').on('click', function () {
                    //Obtenemos la id unica de la sugerencia pulsada
                    var id = $(this).attr('id');
                    var celular = $('#' + id).attr('celular');
                    var direccionComp = $('#' + id).attr('direccionCompleta');
                    //var estado = $('#' + id).attr('estadoDesc');
                    //Editamos el valor del input con data de la sugerencia pulsada
                    $('#idVendedor').val(id);
                    $('#idNombresVendedor').val($('#' + id).attr('data'));
                    $("#idCelularVendedor").val(celular);
                    $("#idDireccionVendedor").val(direccionComp);
                    $("#btnEditar").prop('disabled', false);
                    //Hacemos desaparecer el resto de sugerencias
                    $('#suggestionsNombreEmpeno').fadeOut(1000);
                    return false;
                });

            }
        });
    });
}

//Funcion modal Editar cliente
function modalEditarVendedor(idVendedor) {
    $("#idFormEditar")[0].reset();
    $("#idVendedorEditar").val(idVendedor);
    if (idVendedor == '' || idVendedor == null) {
        alert("Por favor selecciona un vendedor.")
    } else {
        if ($("#idNombresVendedor").val() == '' || $("#idNombresVendedor").val == null) {
            alert("Por favor selecciona un vendedor.")
        } else {
            var dataEnviar = {
                "idVendedorEditar": idVendedor
            };
            $.ajax({
                type: "POST",
                url: '../../../com.Mexicash/Controlador/Vendedor/BuscarVendedorDatos.php',
                data: dataEnviar,
                dataType: "json",
                success: function (datos) {
                    var i = 0;
                    for (i; i < datos.length; i++) {
                        var nombre = datos[i].nombre;
                        var apellido_Pat = datos[i].apellido_Pat;
                        var apellido_Mat = datos[i].apellido_Mat;
                        var sexo = datos[i].sexo;
                        var fecha_Nacimiento = datos[i].fecha_Nacimiento;
                        var curp = datos[i].curp;
                        var ocupacion = datos[i].ocupacion;
                        var tipo_Identificacion = datos[i].tipo_Identificacion;
                        var num_Identificacion = datos[i].num_Identificacion;
                        var celular = datos[i].celular;
                        var rfc = datos[i].rfc;
                        var telefono = datos[i].telefono;
                        var correo = datos[i].correo;
                        var estado = datos[i].estado;
                        var municipio = datos[i].municipio;
                        var localidad = datos[i].localidad;
                        var codigo_Postal = datos[i].codigo_Postal;
                        var calle = datos[i].calle;
                        var num_exterior = datos[i].num_exterior;
                        var num_interior = datos[i].num_interior;
                        var mensaje = datos[i].mensaje;
                        var promocion = datos[i].promocion;

                        if (nombre == null) {
                            nombre = '';
                        }
                        if (apellido_Pat == null) {
                            apellido_Pat = '';
                        }
                        if (apellido_Mat == null) {
                            apellido_Mat = '';
                        }
                        if (sexo == null) {
                            sexo = '';
                        }
                        if (fecha_Nacimiento == null) {
                            fecha_Nacimiento = '';
                        }
                        if (curp == null) {
                            curp = '';
                        }
                        if (ocupacion == null) {
                            ocupacion = '';
                        }
                        if (tipo_Identificacion == null) {
                            tipo_Identificacion = '';
                        }
                        if (num_Identificacion == null) {
                            num_Identificacion = '';
                        }
                        if (celular == null) {
                            celular = '';
                        }
                        if (rfc == null) {
                            rfc = '';
                        }
                        if (telefono == null) {
                            telefono = '';
                        }
                        if (correo == null) {
                            correo = '';
                        }
                        if (estado == null) {
                            estado = '';
                        }

                        if (codigo_Postal == null) {
                            codigo_Postal = '';
                        }
                        if (municipio == null) {
                            municipio = '';
                        }

                        if (localidad == null) {
                            localidad = '';
                        }
                        if (calle == null) {
                            calle = '';
                        }
                        if (num_exterior == null) {
                            num_exterior = '';
                        }
                        if (num_interior == null) {
                            num_interior = '';
                        }
                        if (mensaje == null) {
                            mensaje = '';
                        }
                        if (promocion == null) {
                            promocion = '';
                        }

                        $("#idNombreEdit").val(nombre);
                        $("#idApMatEdit").val(apellido_Mat);
                        $("#idApPatEdit").val(apellido_Pat);
                        $("#idSexoEdit").val(sexo);
                        $("#idIdentificacionEdit").val(tipo_Identificacion);
                        $("#idNumIdentificacionEdit").val(num_Identificacion);
                        $("#idFechaNacEdit").val(fecha_Nacimiento);
                        $("#idCorreoEdit").val(correo);
                        $("#idRfcEdit").val(rfc);
                        $("#idCurpEdit").val(curp);
                        $("#idCelularEdit").val(celular);
                        $("#idTelefonoEdit").val(telefono);
                        $("#idEstadoNameEdit").val(estado);
                        $("#idMunicipioEdit").val(municipio);
                        $("#idLocalidadEdit").val(localidad);
                        $("#idCalleEdit").val(calle);
                        $("#idCPEdit").val(codigo_Postal);
                        $("#idNumIntEdit").val(num_interior);
                        $("#idNumExtEdit").val(num_exterior);
                        $("#idOcupacionEdit").val(ocupacion);
                        $("#idMensajeInternoEdit").val(mensaje);
                        $("#idPromocionEdit").val(promocion);
                    }
                }
            });
        }
    }
}

//Alerta para confirmar la actualizacion
function confirmarVendedorActualizacion() {
    var idVendedorEditar = $("#idVendedorEditar").val();
    if (idVendedorEditar == "" || idVendedorEditar == null) {
        alert("Por favor seleccione un usuario en la pantalla anterior.");
        $("#modalEditarVendedorNuevo").modal('hide');//ocultamos el modal
        $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
        $('.modal-backdrop').remove();//eliminamos el backdrop del modal
        $("#btnEditar").prop('disabled', true);

    } else {
        alertify.confirm('Actualizar',
            'Confirme actualizacion del vendedor.',
            function () {
                actualizarVendedor();
            },
            function () {
                alertify.error('Cancelado.');
            });
    }

}

//Actualizar el cliente
function actualizarVendedor() {
    //  si es metal envia tipoAtticulo como 1 si es Electronico corresponde el 2
    var idNombre = $("#idNombreEdit").val();
    var idApPat = $("#idApPatEdit").val();
    var idSexo = $("#idSexoEdit").val();
    var idFechaNac = $("#idFechaNacEdit").val();
    var idCelular = $("#idCelularEdit").val();
    var idIdentificacion = $("#idIdentificacionEdit").val();
    var idNumIdentificacion = $("#idNumIdentificacionEdit").val();
    var idEstado = $("#idEstadoNameEdit").val();
    var idMunicipio = $("#idMunicipioEdit").val();
    var idLocalidad = $("#idLocalidadEdit").val();
    var idCalle = $("#idCalleEdit").val();
    var idNumExt = $("#idNumExtEdit").val();
    var validacion = true;
    if (idNombre == "" || idNombre == null) {
        alert("Por favor ingrese un nombre.");
        validacion = false;
    } else if (idApPat == "" || idApPat == null) {
        alert("Por favor ingrese apellido paterno.");
        validacion = false;
    } else if (idSexo == "" || idSexo == null) {
        alert("Por favor seleccione el campo sexo.");
        validacion = false;
    } else if (idFechaNac == "" || idFechaNac == null) {
        alert("Por favor ingrese fecha de nacimiento.");
        validacion = false;
    } else if (idCelular == "" || idCelular == null) {
        alert("Por favor ingrese numero celular.");
        validacion = false;
    } else if (idIdentificacion == "" || idIdentificacion == null) {
        alert("Por favor ingrese tipo de identificacion.");
        validacion = false;
    } else if (idNumIdentificacion == "" || idNumIdentificacion == null) {
        alert("Por favor ingrese número de identificación.");
        validacion = false;
    } else if (idEstado == "" || idEstado == null) {
        alert("Por favor seleccione un estado.");
        validacion = false;
    } else if (idMunicipio == "" || idMunicipio == null) {
        alert("Por favor seleccione un municipio.");
        validacion = false;
    } else if (idLocalidad == "" || idLocalidad == null) {
        alert("Por favor seleccione una Localidad.");
        validacion = false;
    } else if (idCalle == "" || idCalle == null) {
        alert("Por favor ingrese la calle.");
        validacion = false;
    } else if (idNumExt == "" || idNumExt == null) {
        alert("Por favor ingrese número exterior.");
        validacion = false;
    }


    if (validacion == true) {
        var dataEnviar = {
            "idVendedorEditar": $("#idVendedorEditar").val(),
            "idNombre": idNombre,
            "idApPat": idApPat,
            "idApMat": $("#idApMatEdit").val(),
            "idSexo": idSexo,
            "idFechaNac": idFechaNac,
            "idRfc": $("#idRfcEdit").val(),
            "idCurp": $("#idCurpEdit").val(),
            "idCelular": idCelular,
            "idTelefono": $("#idTelefonoEdit").val(),
            "idCorreo": $("#idCorreoEdit").val(),
            "idOcupacion": $("#idOcupacionEdit").val(),
            "idIdentificacion": idIdentificacion,
            "idNumIdentificacion": idNumIdentificacion,
            "idEstado": idEstado,
            "idMunicipio": idMunicipio,
            "idLocalidad": idLocalidad,
            "idCalle": idCalle,
            "idCP": $("#idCPEdit").val(),
            "idNumExt": idNumExt,
            "idNumInt": $("#idNumIntEdit").val(),
            "idPromocion": $("#idPromocionEdit").val(),
            "idMensajeInterno": $("#idMensajeInternoEdit").val().trim()
        };
        $.ajax({
            data: dataEnviar,
            url: '../../../com.Mexicash/Controlador/Vendedor/ActualizarVendedor.php',
            type: 'post',
            success: function (response) {
                if (response == 1) {

                    $("#modalEditarVendedor").modal('hide');//ocultamos el modal
                    $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove();//eliminamos el backdrop del modal
                    buscarVendedorEditado($("#idVendedorEditar").val());
                    $("#idFormEditar")[0].reset();
                    alertify.success("Vendedor actualizado.");
                } else {
                    alertify.error("Error al actualizar vendedor.");
                }
            },
        })
    }

}

//Funcion traer datos de cliente Editado y seleccionado
function buscarVendedorEditado(vendedorEditado) {
    var dataEnviar = {
        "vendedorEditado": vendedorEditado
    };
    $.ajax({
        data: dataEnviar,
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Vendedor/BuscarVendedorEditado.php',
        dataType: "json",
        success: function (response) {
            if (response.status == 'ok') {
                $("#idClienteEmpeno").val(vendedorEditado);
                $("#idNombresVendedor").val(response.result.NombreCompleto);
                $("#idCelularVendedor").val(response.result.celular);
                $("#idDireccionVendedor").val(response.result.direccionCompleta);
                $("#btnEditar").prop('disabled', false);
            }
        }
    });
}

//Funcion mostrar todos los clientes con un mismo nombre
function mostrarTodos(idNombresVendedor) {
    $('#suggestionsNombreEmpeno').fadeOut(1000);
    var Mostrar = 2;
    if (idNombresVendedor == '' || idNombresVendedor == null) {
        Mostrar = 1;
    }
    var dataEnviar = {
        "Mostrar": Mostrar,
        "idNombresVendedor": idNombresVendedor
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Vendedor/VerTodos.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var html = '';
            var i = 0;
            $("#modalBusquedaVendedor").modal();
            if (datos.length == 0) {
                $("#idNombresVendedor").val('');
                $("#idVendedor").val('');
                $("#idCelularVendedor").val('');
                $("#idDireccionVendedor").val('');
                html += '<tr>' +
                    '<td colspan="4" align="center">Sin datos a mostrar.</td>' +
                    '</tr>';
            } else {
                for (i; i < datos.length; i++) {
                    var id_Vendedor = datos[i].id_Vendedor;
                    var NombreCompleto = datos[i].NombreCompleto;
                    var celular = datos[i].celular;
                    var direccionCompleta = datos[i].direccionCompleta;
                    if (NombreCompleto == null) {
                        NombreCompleto = '';
                    }
                    if (celular == null) {
                        celular = '';
                    }
                    if (direccionCompleta == null) {
                        direccionCompleta = '';
                    }

                    html += '<tr>' +
                        '<td>' + NombreCompleto + '</td>' +
                        '<td>' + celular + '</td>' +
                        '<td>' + direccionCompleta + '</td>' +
                        '<td><input type="button" class="btn btn-info" data-dismiss="modal" value="Seleccionar" ' +
                        'onclick="buscarVendedorEditado(' + id_Vendedor + ')"></td>' +
                        '</tr>';
                }
            }
            $('#idTBodyVerTodos').html(html);
        }
    });
}