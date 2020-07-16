function MostrarTodos() {
    var idContrato = $("#idContratoFotos").text();
    location.href = '../ImagenContrato/vImagenesContrato.php?idContrato='+idContrato;
}

function AgregarFoto() {
    var idContrato = $("#idContratoFotos").text();
    location.href = '../ImagenContrato/vAgregarImagen.php?idContrato='+idContrato;
}

