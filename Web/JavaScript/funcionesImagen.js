function MostrarTodos() {
    var idContrato = $("#idContratoFotos").text();
    location.href = '../ImagenContrato/vImagenesContrato.php?idContrato='+idContrato;
}

function AgregarFoto() {
    var idContrato = $("#idContratoFotos").text();
    location.href = '../ImagenContrato/vAgregarImagen.php?idContrato='+idContrato;
}

function EditarFoto(editarId) {
    location.href = '../ImagenContrato/vEditarImagen.php?edit_id='+editarId;
}

function ElimnarFoto(delete_id) {
    location.href = '../ImagenContrato/vAgregarImagen.php?delete_id='+delete_id;
}

function CancelarEditar() {
    var idContrato = 147;
    location.href = '../ImagenContrato/vImagenesContrato.php?idContrato='+idContrato;
}

