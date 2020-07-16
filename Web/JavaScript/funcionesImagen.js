function MostrarTodos() {
    var idContrato = $("#idContratoFotos").text();
    location.href = '../ImagenContrato/vImagenesContrato.php?idContrato=' + idContrato;
}

function AgregarFoto() {
    var idContrato = $("#idContratoFotos").text();
    location.href = '../ImagenContrato/vAgregarImagen.php?idContrato=' + idContrato;
}

function EditarFoto(editarId) {
    location.href = '../ImagenContrato/vEditarImagen.php?edit_id=' + editarId;
}

function ElimnarFoto(delete_id) {
    alertify.confirm('Eliminar',
        'Confirme eliminacion de la imagen seleccionada.',
        function () {
            location.href = '../ImagenContrato/vImagenesContrato.php?delete_id=' + delete_id;
        },
        function () {
            alertify.error('Cancelado')
        });
}

function CancelarEditar() {
    var idContrato = 147;
    location.href = '../ImagenContrato/vImagenesContrato.php?idContrato=' + idContrato;
}

