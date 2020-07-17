function MostrarTodos() {
    var idContrato = $("#idContratoFotos").val();
    var articulo = $("#idArticuloFotos").val();
    location.href = '../ImagenContrato/vImagenesContrato.php?idContrato=' + idContrato+ '&articulo='+articulo;
}

function AgregarFoto() {
    var idContrato = $("#idContratoFotos").val();
    var articulo = $("#idArticuloFotos").val();
    location.href = '../ImagenContrato/vAgregarImagen.php?idContrato=' + idContrato+ '&articulo='+articulo;
}

function EditarFoto(editarId) {
    var idContrato = $("#idContratoFotos").val();
    var articulo = $("#idArticuloFotos").val();
    location.href = '../ImagenContrato/vEditarImagen.php?edit_id=' + editarId +'&idContrato=' + idContrato+ '&articulo='+articulo;
}

function ElimnarFoto(delete_id) {
    alertify.confirm('Eliminar',
        'Confirme eliminacion de la imagen seleccionada.',
        function () {
            var idContrato = $("#idContratoFotos").val();
            var articulo = $("#idArticuloFotos").val();
            location.href = '../ImagenContrato/vImagenesContrato.php?delete_id=' + delete_id+'&idContrato=' + idContrato+ '&articulo='+articulo;;
        },
        function () {
            alertify.error('Cancelado')
        });
}

function CancelarEditar() {
    var idContrato = 147;
    location.href = '../ImagenContrato/vImagenesContrato.php?idContrato=' + idContrato;
}


function guardarEdicion() {
    alert("entra");
    var idContrato = $("#idContratoFotos").val();
    var articulo = $("#idArticuloFotos").val();
    location.href = '../ImagenContrato/vImagenesContrato.php?idContrato=' + idContrato+ '&articulo='+articulo;
}
