function MostrarTodos() {
    var articulo = $("#idArticuloFotos").val();
    location.href = '../ImagenContrato/vImagenesContrato.php?articulo='+articulo;
}

function AgregarFoto() {
    var articulo = $("#idArticuloFotos").val();
    location.href = '../ImagenContrato/vAgregarImagen.php?articulo='+articulo;
}

function EditarFoto(editarId) {
    var articulo = $("#idArticuloFotos").val();
    location.href = '../ImagenContrato/vEditarImagen.php?edit_id=' + editarId +'&articulo='+articulo;
}

function ElimnarFoto(delete_id) {
    alertify.confirm('Eliminar',
        'Confirme eliminacion de la imagen seleccionada.',
        function () {
            var articulo = $("#idArticuloFotos").val();
            location.href = '../ImagenContrato/vImagenesContrato.php?delete_id=' + delete_id+'&articulo='+articulo;
        },
        function () {
            alertify.error('Cancelado')
        });
}

function CancelarEditar() {
    var articulo = $("#idArticuloFotos").val();
    location.href = '../ImagenContrato/vImagenesContrato.php?articulo='+articulo;
}
