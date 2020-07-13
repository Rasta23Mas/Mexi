var idImgGlobal="";//obtengo el id la imagen
$(document).ready(function(){
    dataDeTablas();
    $('#buttonEdit').hide();
});
function dataDeTablas(){
    var opciones="listar";
    $.ajax({
        url:"../../../com.Mexicash/Controlador/Imagen/ImagenOpciones.php",
        method:"POST",
        data:{opciones:opciones},

        success:function(data) {
            $('#data').html(data);
        }
    });

}
//previsualizo la imagen insertar
$(function() {
    $('#fileImage').change(function(e) {
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
$('#buttonRegist').click(function(){
    var fileImage = $('#fileImage').val();
    var titulo=$('#titleImage').val();
    var contrato=$('#titleImage').val();
    if(titulo!=""){
        if (fileImage != '') {

            var form_data = new FormData();
            var opciones = "ingresoImg";
            form_data.append('opciones', opciones);
            form_data.append('titulo', titulo);
            form_data.append("fileImage", document.getElementById('fileImage').files[0]);
            console.log(form_data);
            $.ajax({
                url:"../../../com.Mexicash/Controlador/Imagen/ImagenOpciones.php",
                method: "POST",
                data: form_data,
                contentType: false,
                processData: false,
                success:function(data) {
                    $('#data').html(data);
                    $('#titleImage').val("");
                    $('#imgSalida').hide();
                }
            });
        }else{
            alert("No ingreso Archivo de imagen");
        }
    }else{
        alert("Error No ingreso titulo");
    }
});

//pre editcion img
function preEditImg(idImg){
    $('#buttonEdit').show();
    $('#buttonRegist').hide();
    $('#imagenEditar').show();
    idImgGlobal=idImg;
    //alert("edito "+idImg);
    $('#opcionValor').val('Edicion');
    var opciones="getOneImg";
    $.ajax({
        url:"../../../com.Mexicash/Controlador/Imagen/ImagenOpciones.php",
        method:"POST",
        data:{idImg:idImg,opciones:opciones},
        success:function(data) {
            $('#imagenEditar').html(data);
            getTitle(idImg);	//llamo a la funcion
        }
    });
}
function getTitle(idImg){	//obtengo el titulo y lo coloca en el input
    var opciones="getTitle";
    $.ajax({
        url:"../../../com.Mexicash/Controlador/Imagen/ImagenOpciones.php",
        method:"POST",
        data:{idImg:idImg,opciones:opciones},
        success:function(data) {
            $('#titleImage').val(data);
        }
    });
}

//borro Img
function deleteImg(idImg){
    //	alert("borro "+idImg);
    var opciones="deleteData";
    $.ajax({
        url:"../../../com.Mexicash/Controlador/Imagen/ImagenOpciones.php",
        method:"POST",
        data:{idImg:idImg,opciones:opciones},
        success:function(data) {
            $('#data').html(data);
        }
    });
}

//edito Imagen
$('#buttonEdit').click(function(){
    var fileImage = $('#fileImage').val();
    var titulo=$('#titleImage').val();
    if(titulo!=""){
        if (fileImage != '') {// si actualizo la imagen
            var form_data = new FormData();
            var opciones = "editoImg";
            form_data.append('opciones', opciones);
            form_data.append('titulo', titulo);
            form_data.append('idImgGlobal', idImgGlobal);
            form_data.append("fileImage", document.getElementById('fileImage').files[0]);
            console.log(form_data);
            $.ajax({
                url:"../../../com.Mexicash/Controlador/Imagen/ImagenOpciones.php",
                method: "POST",
                data: form_data,
                contentType: false,
                processData: false,
                success:function(data) {
                    $('#data').html(data);
                }
            });
        }else{//edito Solo el Titulo.
            var titulo = $('#titleImage').val();
            var opciones = "editoSinImg";
            $.ajax({
                url:"../../../com.Mexicash/Controlador/Imagen/ImagenOpciones.php",
                method:"POST",
                data:{idImgGlobal:idImgGlobal,titulo:titulo,opciones:opciones},
                success:function(data) {
                    $('#data').html(data);
                }
            });
        }
        $('#opcionValor').val('Ingresar');
        $('#titleImage').val("");
        $('#imagenEditar').hide();
        $('#imgSalida').hide();
        $('#buttonEdit').hide();
        $('#buttonRegist').show();
    }else{
        alert("No ingreso titulo");
    }
});

$('#buttonCancel').click(function(){//limpio los campos
    $('#opcionValor').val('Ingresar');
    $('#titleImage').val("");
    $('#imagenEditar').hide();
    $('#imgSalida').hide();
    $('#buttonEdit').hide();
    $('#buttonRegist').show();
});
