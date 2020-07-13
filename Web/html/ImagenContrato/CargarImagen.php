<?php
if (!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION["idUsuario"])){
    header("Location: ../../../index.php");
    session_destroy();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once (HTML_PATH."menuGeneral.php");

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>
<div class="col-md-4 offset-md-1">
    <br><br>

    <div class="form-group">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button class="btn btn-outline-secondary" type="button">Titulo</button>
            </div>
            <input type="text" class="form-control" id="titleImage">
        </div>

        <div class="custom-file">
            <input type="file" class="custom-file-input" id="fileImage" accept="image/*">
            <label class="custom-file-label" for="inputGroupFile04">Archivo</label>
            <br>
            <img id="imgSalida" src=""/>
            <div id="imagenEditar">
            </div>
            <br> <br>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button class="btn btn-outline-secondary" type="button">Opcion</button>
            </div>
            <div class="custom-file">
                <input type="text" class="form-control" id="opcionValor" value="Ingresar" readonly>
            </div>
        </div>
        <button class="btn btn-primary" type="button" id="buttonRegist">Ingresar</button>
        <button class="btn btn-success" type="button" id="buttonEdit">Editar</button>
        <button class="btn btn-warning" type="button" id="buttonCancel">Cancelar</button>
        <br><br>
    </div>
</div>

<div  class="col-md-3 offset-md-1">
    <h3>Imagenes</h3>
    <hr>
    <div id="data">
        <!--Aca se cargan los datos-->
    </div>
</div>

<script>
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
                alert("solotitulo"  + data)
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

</script>

</body>

</html>
