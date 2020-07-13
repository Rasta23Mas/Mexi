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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Generales-->
    <meta charset="utf-8">
    <script src="../../JavaScript/funcionesImagen.js"></script>


</head>

<body>
<div class="col-md-2 offset-md-1">
    <br><br>

    <div class="form-group">
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <button class="btn btn-outline-secondary" type="button">Contrato</button>
            </div>
            <input type="text" class="form-control" id="idContrato">
        </div>
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


</body>

</html>
