var idImgGlobal = "";//obtengo el id la imagen
$(document).ready(function () {
    dataDeTablas();
    $('#buttonEdit').hide();
});

function dataDeTablas() {
    var opciones = "listar";
    $.ajax({
        url: "../../../com.Mexicash/Controlador/Imagen/ImagenOpciones.php",
        method: "POST",
        data: {opciones: opciones},

        success: function (data) {
            $('#data').html(data);
        }
    });

}

//previsualizo la imagen insertar
$(function () {
    $('#fileImage').change(function (e) {
        addImage(e);
    });

    function addImage(e) {
        $('#imagenEditar').hide();
        $('#imgSalida').show();
        var file = e.target.files[0],
            imageType = /image.*/;
        if (!file.type.match(imageType))
            return;
        var reader = new FileReader();
        reader.onload = fileOnload;
        reader.readAsDataURL(file);
    }

    function fileOnload(e) {
        var result = e.target.result;
        $('#imgSalida').attr("src", result);
    }
});
//ingreso imagen blob
$('#buttonRegist').click(function () {
    var fileImage = $('#fileImage').val();
    var descripcion = $('#DescripcionFoto').val();
    var contrato = $('#idContratoFotos').val();
    if (descripcion != "") {
        if (fileImage != '') {

            var form_data = new FormData();
            var opciones = "ingresoImg";
            form_data.append('opciones', opciones);
            form_data.append('titulo', descripcion);
            form_data.append("fileImage", document.getElementById('fileImage').files[0]);
            console.log(form_data);
            $.ajax({
                url: "../../../com.Mexicash/Controlador/Imagen/ImagenOpciones.php",
                method: "POST",
                data: form_data,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#data').html(data);
                    $('#DescripcionFoto').val("");
                    $('#imgSalida').hide();
                }
            });
        } else {
            alert("No ingreso Archivo de imagen");
        }
    } else {
        alert("Error No ingreso la descripcion");
    }
});

//pre editcion img
function preEditImg(idImg) {
    $('#buttonEdit').show();
    $('#buttonRegist').hide();
    $('#imagenEditar').show();
    idImgGlobal = idImg;
    //alert("edito "+idImg);
    $('#opcionValor').val('Edicion');
    var opciones = "getOneImg";
    $.ajax({
        url: "../../../com.Mexicash/Controlador/Imagen/ImagenOpciones.php",
        method: "POST",
        data: {idImg: idImg, opciones: opciones},
        success: function (data) {
            $('#imagenEditar').html(data);
            getTitle(idImg);	//llamo a la funcion
        }
    });
}

function getTitle(idImg) {	//obtengo la descripcion y lo coloca en el input
    var opciones = "getTitle";
    $.ajax({
        url: "../../../com.Mexicash/Controlador/Imagen/ImagenOpciones.php",
        method: "POST",
        data: {idImg: idImg, opciones: opciones},
        success: function (data) {
            $('#DescripcionFoto').val(data);
        }
    });
}

//borro Img
function deleteImg(idImg) {
    //	alert("borro "+idImg);
    var opciones = "deleteData";
    $.ajax({
        url: "../../../com.Mexicash/Controlador/Imagen/ImagenOpciones.php",
        method: "POST",
        data: {idImg: idImg, opciones: opciones},
        success: function (data) {
            $('#data').html(data);
        }
    });
}

//edito Imagen
$('#buttonEdit').click(function () {
    var fileImage = $('#fileImage').val();
    var descripcion = $('#DescripcionFoto').val();
    if (descripcion != "") {
        if (fileImage != '') {// si actualizo la imagen
            var form_data = new FormData();
            var opciones = "editoImg";
            form_data.append('opciones', opciones);
            form_data.append('titulo', descripcion);
            form_data.append('idImgGlobal', idImgGlobal);
            form_data.append("fileImage", document.getElementById('fileImage').files[0]);
            console.log(form_data);
            $.ajax({
                url: "../../../com.Mexicash/Controlador/Imagen/ImagenOpciones.php",
                method: "POST",
                data: form_data,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#data').html(data);
                }
            });
        } else {//edito Solo la descripcion
            var descripcion = $('#DescripcionFoto').val();
            var opciones = "editoSinImg";
            $.ajax({
                url: "../../../com.Mexicash/Controlador/Imagen/ImagenOpciones.php",
                method: "POST",
                data: {idImgGlobal: idImgGlobal, titulo: descripcion, opciones: opciones},
                success: function (data) {
                    $('#data').html(data);
                }
            });
        }
        $('#opcionValor').val('Ingresar');
        $('#DescripcionFoto').val("");
        $('#imagenEditar').hide();
        $('#imgSalida').hide();
        $('#buttonEdit').hide();
        $('#buttonRegist').show();
    } else {
        alert("No ingreso la descripcion");
    }
});

$('#buttonCancel').click(function () {//limpio los campos
    $('#opcionValor').val('Ingresar');
    $('#DescripcionFoto').val("");
    $('#imagenEditar').hide();
    $('#imgSalida').hide();
    $('#buttonEdit').hide();
    $('#buttonRegist').show();
});

function llenarTablaImagen(idContratoBusqueda) {
    var dataEnviar = {
        "idContratoBusqueda": idContratoBusqueda
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Imagen/llenarTablaImg.php',
        data: dataEnviar,
        dataType: "json",

        success: function (datos) {
            alert("Refrescando tabla detalle de contrato.");
            var html = '';
            var i = 0;
            var Num = 1;
            if (datos.length > 0) {
                for (i; i < datos.length; i++) {
                    var id = datos[i].id;
                    var descripcion = datos[i].descripcion;
                    var img = datos[i].img;

                    html += '<tr align="center">' +
                        '<td>' + Num + '</td>' +
                        '<td>' + descripcion + '</td>' +
                        '<td><img src="data:image/jpeg;base64," . base64_encode(img) . " class="img-responsive img-rounded "></td>' +
                        '<td>' + id + '</td>' +
                        '<td>' + id + '</td>' +
                        '</tr>';

                    Num++;
                }
                $('#idTBodyImagenes').html(html);
            } else {
                alertify.error("El contrato no existe.");
            }
        }
    });
    $("#divContratoFotos").load('tablaImagen.php');
}