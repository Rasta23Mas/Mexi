

function cargarTablaCatMetales(tipoMetal) {
    var dataEnviar = {
        "tipoMetal": tipoMetal
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Catalogos/tblCatMetales.php',
        data: dataEnviar,
        dataType: "json",
        success: function (datos) {
            var html = '';
            var i = 0;
            for (i; i < datos.length; i++) {
                var id_Kilataje = datos[i].id_Kilataje;
                var TipoMetal = datos[i].TipoMetal;
                var DesMetal = datos[i].DesMetal;
                var precio = datos[i].precio;
                if (TipoMetal == null) {
                    TipoMetal = '';
                }
                if (DesMetal == null) {
                    DesMetal = '';
                }
                if (precio == null) {
                    precio = '0.00';
                }
                html += '<tr>' +
                    '<td align="center">' + TipoMetal + '</td>' +
                    '<td align="center">' + DesMetal + '</td>' +
                    '<td align="center">$' + precio + '</td>' +
                    '<td><input type="button" class="btn btn-success"  data-toggle="modal" data-target="#modalActualizarMetal"' +
                    'value="Editar"  onclick="modalEditarMetal(' + id_Kilataje + ')"></td>' +
                    '<td><input type="button" class="btn btn-danger" value="Eliminar" ' +
                    'onclick="confirmarEliminarCatMetal(' + id_Kilataje + ')"></td>' +
                    '</tr>';
            }

            $('#idCatMetales').html(html);
        }
    });
}

//Alerta para confirmar la Eliminacion
function confirmarEliminarCatMetal($idMetal) {
    alertify.confirm('Eliminar',
        'Confirme eliminacion de articulo seleccionado.',
        function () {
            eliminarMetal($idMetal)
        },
        function () {
            alertify.error('Cancelado')
        });
}

//Elimina metal
function eliminarMetal($idMetal) {
    var $tipoMetal = $("#idTipoMetalCat").val();
    var dataEnviar = {
        "tipo": 1,
        "idMetal": $idMetal
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Catalogos/ActualizarMetal.php',
        type: 'post',
        success: function (response) {
            if (response == 1) {
                cargarTablaCatMetales($tipoMetal)
                alertify.success("Eliminado con éxito.");
            } else {
                alertify.error("Error al eliminar metal.");
            }
        },
    })

}

function modalEditarMetal(idMetal) {
    var dataEnviar = {
        "tipo": 4,
        "idMetal": idMetal
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Catalogos/ActualizarMetal.php',
        type: 'post',
        dataType: "json",
        success: function (datos) {
            var i = 0;
            for (i; i < datos.length; i++) {
                var id_Kilataje = datos[i].id_Kilataje;
                var TipoMetal = datos[i].TipoMetal;
                var DesMetal = datos[i].DesMetal;
                var precio = datos[i].precio;
                if (TipoMetal == null) {
                    TipoMetal = '';
                }
                if (DesMetal == null) {
                    DesMetal = '';
                }
                if (precio == null) {
                    precio = '0.00';
                }
                $("#idKilatajeEditModal").val(id_Kilataje);
                $('#idTipoCatMetEditModal').val(TipoMetal);
                $('#idUnidadEditModal').val(DesMetal);
                $('#idPrecioEditModal').val(precio);
            }
        }
    })

}

function guardarMetal() {
    var idTipo = $('#idTipoMetalCatModal').val();
    var unidad = $('#idUnidadModal').val();
    var precio = $('#idPrecioModal').val();
    var dataEnviar = {
        "tipo": 3,
        "idTipo": idTipo,
        "unidad": unidad,
        "precio": precio
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Catalogos/ActualizarMetal.php',
        type: 'post',
        success: function (response) {
            if (response == 1) {
                cargarTablaCatMetales(idTipo)
                alertify.success("Guardado con éxito.");
            } else {
                alertify.error("Error al guardar metal.");
            }
        },
    })

}

function validarTipoUser() {
    var idUser = $('#idTipoUserCat').val();

    if(idUser==2){
        actualizarMetal();
    }else{

    }
}

function actualizarMetal() {
    var idMetal = $('#idKilatajeEditModal').val();
    var precio = $('#idPrecioEditModal').val();
    var $tipoMetal = $("#idTipoMetalCat").val();
    var dataEnviar = {
        "tipo": 2,
        "idMetal": idMetal,
        "precio": precio
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Catalogos/ActualizarMetal.php',
        type: 'post',
        success: function (response) {
            if (response == 1) {
                cargarTablaCatMetales($tipoMetal)
                alertify.success("Guardado con éxito.");
            } else {
                alertify.error("Error al guardar precio metal.");
            }
        },
    })

}

//Electronico Agregar
function llenarComboTipoE() {
    var dataEnviar = {
        "tipo": 1
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
            $('#idTipoSelect').html(html);
        }
    });
}

function llenarComboMarcaE() {
    $('#idMarcaSelect').prop('disabled', false);
    $('#idModeloSelect').prop('disabled', false);
    $('#idModeloSelect').val(0);
    $('#idMarcaSelect').val(0);
    var tipoSelect = $('#idTipoSelect').val();
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
            $('#idMarcaSelect').html(html);
            cargarTblProducto(tipoSelect, marcaSelect, modeloSelect);
        }
    });
}

function llenarComboModeloE() {
    $('#idModeloSelect').prop('disabled', false);
    $('#idModeloSelect').val(0);
    var tipoSelect = $('#idTipoSelect').val();
    var marcaSelect = $('#idMarcaSelect').val();
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
            $('#idModeloSelect').html(html);
            cargarTblProducto(tipoSelect, marcaSelect, modeloSelect);
        }
    });
}

function validarTipoE(tipoUsuario) {
    if(tipoUsuario==1||tipoUsuario==2){
        agregarTipoE();
    }else{
        $("#modalTokenElec").modal();
    }
}

function agregarTipoE() {
    var tipoText = $('#idTipoAgregar').val();
    if (tipoText == '') {
        alert("Ingrese el tipo.");
    } else {
        var dataEnviar = {
            "tipo": 4,
            "descripcion": tipoText
        };
        $.ajax({
            data: dataEnviar,
            url: '../../../com.Mexicash/Controlador/Electronicos/Electronico.php',
            type: 'post',
            success: function (response) {
                if (response == 1) {
                    $('#idTipoAgregar').val('');
                    llenarComboTipoE();
                    alertify.success("Se guardo el Tipo correctamente");

                } else {
                    alertify.error("Error al guardar tipo de producto.");
                }
            },
        })
    }
}

function agregarMarcaE() {
    var tipoTextMarca = $('#idTipoModMarca').val();
    if (tipoTextMarca == 0) {
        alert("Por favor. Seleccione el tipo.")
    } else {
        var marcaText = $('#idMarcaAgregar').val();
        if (marcaText == '') {
            alert("Ingrese la marca.");

        } else {
            var dataEnviar = {
                "tipo": 5,
                "tipoCombo": tipoTextMarca,
                "descripcion": marcaText,

            };
            $.ajax({
                data: dataEnviar,
                url: '../../../com.Mexicash/Controlador/Electronicos/Electronico.php',
                type: 'post',
                success: function (response) {
                    if (response == 1) {
                        $('#idTipoAgregar').val('');
                        llenarComboMarcaE();
                        alertify.success("Se guardo la Marca correctamente");

                    } else {
                        alertify.error("Error al guardar la marca de producto.");
                    }
                },
            })
        }
    }
}

function agregarModeloE() {
    var tipoTextMarca = $('#idTipoModModelo').val();
    if (tipoTextMarca == 0) {
        alert("Por favor. Seleccione el tipo.")
    } else {
        var marcaTipo = $('#idMarcaModModelo').val();
        if (marcaTipo == '') {
            alert("Por favor. Seleccione la marca.")
        } else {
            var modeloDes = $('#idModeloAgregar').val();
            if (modeloDes == '') {
                alert("Ingrese el modelo.");

            } else {
                var dataEnviar = {
                    "tipo": 6,
                    "tipoCombo": tipoTextMarca,
                    "marcaCombo": marcaTipo,
                    "descripcion": modeloDes

                };
                $.ajax({
                    data: dataEnviar,
                    url: '../../../com.Mexicash/Controlador/Electronicos/Electronico.php',
                    type: 'post',
                    success: function (response) {
                        if (response == 1) {
                            $('#idTipoAgregar').val('');
                            llenarComboModeloE();
                            alertify.success("Se guardo el Modelo correctamente");

                        } else {
                            alertify.error("Error al guardar el modelo de producto.");
                        }
                    },
                })
            }
        }
    }
}

function agregarProducto() {
    var validateForm = true;
    var cmbTipo = $('#idTipoModP').val();
    var cmbMarca = $('#idMarcaModP').val();
    var cmbModelo = $('#idModeloModP').val();
    if (cmbTipo == 0) {
        alert("Por favor. Seleccione el tipo.");
        validateForm = false;
    } else if (cmbMarca == 0) {
        alert("Por favor. Seleccione la marca.");
        validateForm = false;
    } else if (cmbModelo == 0) {
        alert("Por favor. Seleccione el modelo.");
        validateForm = false;
    }

    if (validateForm) {

        var precio = $('#idPrecioP').val();
        var vitrina = $('#idVitrinaP').val();
        var caracteristicas = $('#idCaracteristicaP').val().trim();

        if (precio == "") {
            alert("Por favor. Ingrese el precio.")
            validateForm = false;
        } else if (vitrina == "") {
            alert("Por favor. Ingrese vitrina.")
            validateForm = false;
        }
        if (validateForm) {
            var dataEnviar = {
                "tipo": 7,
                "cmbTipo": cmbTipo,
                "cmbMarca": cmbMarca,
                "cmbModelo": cmbModelo,
                "precio": precio,
                "vitrina": vitrina,
                "caracteristicas": caracteristicas

            };
            $.ajax({
                data: dataEnviar,
                url: '../../../com.Mexicash/Controlador/Electronicos/Electronico.php',
                type: 'post',
                success: function (response) {
                    if (response == 1) {
                        cargarTblProducto(cmbTipo,cmbMarca,cmbModelo)
                        alertify.success("Se guardo el producto correctamente");

                    } else {
                        alertify.error("Error al guardar el producto.");
                    }
                },
            })
        }
    }
}

function cargarTipoModal() {

    $('#idTipoModMarca').val($('#idTipoSelect').val());
    $('#idMarcaAgregar').val('');
    $('#idTipoModMarcaDes').val($('select[name="tipoElect"] option:selected').text());
}

function cargarMarcaModal() {

    $('#idTipoModModelo').val($('#idTipoSelect').val());
    $('#idMarcaModModelo').val($('#idMarcaSelect').val());
    $('#idModeloAgregar').val('');
    $('#idTipoModDes').val($('select[name="tipoElect"] option:selected').text());
    $('#idMarcaModDes').val($('select[name="marcaElect"] option:selected').text());
}

function cargarProductoModal() {
    $('#idPrecioP').val('');
    $('#idVitrinaP').val('');
    $('#idCaracteristicaP').val('');

    $('#idTipoModP').val($('#idTipoSelect').val());
    $('#idMarcaModP').val($('#idMarcaSelect').val());
    $('#idModeloModP').val($('#idModeloSelect').val());
    $('#idTipoDescP').val($('select[name="tipoElect"] option:selected').text());
    $('#idMarcaDescP').val($('select[name="marcaElect"] option:selected').text());
    $('#idModeloDescP').val($('select[name="modeloElect"] option:selected').text());
}

function editarProducto($idProducto) {
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

                $('#idElectronico').val(idElectronico);
                $('#idTipoModE').val(tipoId);
                $('#idMarcaModE').val(marcaId);
                $('#idModeloModE').val(modeloId);
                $('#idTipoDescE').val(tipoEditar);
                $('#idMarcaDescE').val(marca);
                $('#idModeloDescE').val(modelo);
                $('#idPrecioE').val(precio);
                $('#idVitrinaE').val(vitrina);
                $('#idCaracteristicaE').val(caracteristicas);

            }
        }
    });

}

function cargarTblProducto(tipoSelect, marcaSelect, modeloSelect) {

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
            var html = '';
            var i = 0;
            for (i; i < datos.length; i++) {
                var Catalogo = $("#idCatalogoEnviar").val();
                var idElectronico = datos[i].idElectronico;
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
                html += '<tr>' +
                    '<td>' + tipo + '</td>' +
                    '<td>' + marca + '</td>' +
                    '<td>' + modelo + '</td>' +
                    '<td>$' + precio + '</td>' +
                    '<td>$' + vitrina + '</td>' +
                    '<td>' + caracteristicas + '</td>' +
                    '<td><img src="../../style/Img/editarNor.jpg"  data-toggle="modal" ' +
                    'data-target="#modalEditarProducto" alt="Editar"  onclick="editarProducto(' + idElectronico + ')"></td>' +
                    '<td><img src="../../style/Img/eliminarNor.jpg" alt="Eliminar"  onclick="confirmarEliminarProd(' + idElectronico + ')"></td>' +
                    '<td><img src="../../style/Img/seleccionarNor.png"  data-dismiss="modal" alt="Seleccionar"  onclick="fnCatalogoEnviar(' + idElectronico + ',' + Catalogo +')"></td>' +
                    '</tr>';
            }

            $('#cargarTblProducto').html(html);
        }
    });
}

function actualizarProducto() {
    var idElectro = $('#idElectronico').val();
    var precio = $('#idPrecioE').val();
    var vitrina = $('#idVitrinaE').val();

    var $idTipoModE = $('#idTipoSelect').val();
    var $idMarcaModE = $('#idMarcaSelect').val();
    var $idModeloModE = $('#idModeloSelect').val();
    var caracteristicas = $('#idCaracteristicaE').val().trim();

    var dataEnviar = {
        "tipo": 8,
        "idElectro": idElectro,
        "precio": precio,
        "vitrina": vitrina,
        "caracteristicas": caracteristicas

    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Electronicos/Electronico.php',
        type: 'post',
        success: function (response) {
            if (response == 1) {
                cargarTblProducto($idTipoModE,$idMarcaModE,$idModeloModE)
                alertify.success("Se actualizo el producto correctamente");

            } else {
                alertify.error("Error al actualizar el producto.");
            }
        },
    })


}

function confirmarEliminarProd($idProducto) {
    alertify.confirm('Eliminar',
        'Confirme eliminacion de articulo seleccionado.',
        function () {
            eliminarProductoProd($idProducto)
        },
        function () {
            alertify.error('Cancelado')
        });
}

//Elimina articulos
function eliminarProductoProd($idProducto) {
    var $idTipoModE = $('#idTipoSelect').val();
    var $idMarcaModE = $('#idMarcaSelect').val();
    var $idModeloModE = $('#idModeloSelect').val();

    var dataEnviar = {
        "tipo": 2,
        "idProducto": $idProducto
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Electronicos/ActualizarTblElectronico.php',
        data: dataEnviar,
        dataType: "json",
        success: function (response) {
            if (response == 1) {
                cargarTblProducto($idTipoModE,$idMarcaModE,$idModeloModE)
                alertify.success("Eliminado con éxito.");
            } else {
                alertify.error("Error al eliminar articulo.");
            }
        },
    })

}


//CATALOGO CLIENTES

function cargarCatClientes(sucursal) {
    var dataEnviar = {
        "sucursal": sucursal,
    };
    $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Catalogos/tblClientes.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var html = '';
                var i = 0;
                alert("Refrescando tabla.");
                for (i; i < datos.length; i++) {
                    var id_Cliente = datos[i].id_Cliente;
                    var fecha_Nacimiento = datos[i].fecha_Nacimiento;
                    var NombreCompleto = datos[i].NombreCompleto;
                    var direccionCompleta = datos[i].direccionCompleta;
                    var Sexo = datos[i].Sexo;
                    var Promo = datos[i].Promo;
                    var mensaje = datos[i].mensaje;

                    html += '<tr>' +
                        '<td >' + id_Cliente + '</td>' +
                        '<td>' + NombreCompleto + '</td>' +
                        '<td>' + fecha_Nacimiento + '</td>' +
                        '<td>' + Sexo + '</td>' +
                        '<td>' + direccionCompleta + '</td>' +
                        '<td>' + Promo + '</td>' +
                        '<td>' + mensaje + '</td>' +
                        '</tr>';
                }
                $('#idTBodyClientes').html(html);
            }
        }
    );
    $("#divCat").load('tblClientes.php');
}


function exportarExcelCliente() {
   var sucursal = $("#idSucursal").val();
   window.open('../Excel/rpt_Exc_Clientes.php?sucursal=' + sucursal);
}

function exportarPDFCliente() {
    var sucursal = $("#idSucursal").val();
    window.open('../PDF/callPdf_Cat_Clientes.php?sucursal=' + sucursal );
}

