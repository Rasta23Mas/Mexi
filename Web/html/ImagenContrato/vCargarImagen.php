<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');
$idContrato = 0;
if (isset($_GET['idContrato'])) {
    $idContrato = $_GET['idContrato'];
}
$tipoUsuario = $_SESSION['tipoUsuario'];
if ($tipoUsuario == 2) {
    include_once(HTML_PATH . "menuAdmin.php");
} elseif ($tipoUsuario == 3) {
    include_once(HTML_PATH . "menuGeneral.php");
} elseif ($tipoUsuario == 4) {
    include_once(HTML_PATH . "menuVendedor.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Generales-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subir Fotos</title>
    <script src="../../JavaScript/funcionesImagen.js"></script>

    <script type="application/javascript">
        $(document).ready(function () {
            var idContratoFotos = <?php echo $idContrato ?>;
            $("#idContratoFotos").val(idContratoFotos);
            llenarTablaImagen(idContratoFotos);
            $("#divContratoFotos").load('tablaImagen.php');
        })
    </script>
    <style type="text/css">

        .inputCliente {
            text-transform: uppercase;
        }
    </style>
</head>

<body>
<div class="row">
    <div class="col-md-1">
        <br>
    </div>
    <div class="col-md-3">
        <table width="100%" border="1">
            <tr>
                <td colspan="2">
                    &nbsp;
                </td>
            </tr>
            <tr class="border-primary border">
                <td style=" background: dodgerblue; color:white; ">
                    <label>&nbsp;
                        Contrato</label>
                </td>
                <td align="center" style="width: 180px">
                    <input type="text" name="ContratoFotos" id="idContratoFotos" style="width: 70px"
                           disabled/>
                </td>
            </tr>
            <tr class="border-primary border">
                <td style=" background: dodgerblue; color:white; ">
                    <label>&nbsp;
                        Descripción</label>
                </td>
                <td align="center" style="width: 180px">
                    <input type="text" name="descripcionFoto" id="DescripcionFoto" style="width: 70px"
                           class="inputCliente"
                    />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="fileImage" accept="image/*" value="Subir">
                        <label class="custom-file-label" for="inputGroupFile04">Subir Archivo</label>
                        <br>
                        <img id="imgSalida" src=""/>
                        <div id="imagenEditar">
                        </div>
                        <br> <br>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-7 offset-md-1">
        <h3>Archivos del contratosss</h3>
        <hr>
        <div id="data">
        </div>
        <div id="divContratoFotos" class="col col-lg-12">
        </div>
    </div>
    <div class="col-md-1">
        <br>
    </div>

</div>
<div class="row">
    <div class="col-md-1">
        <br>
    </div>
    <div class="col-md-3">

    </div>
</div>
<div class="col-md-2 offset-md-1 invisible">
    <div class="form-group">
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
</body>

</html>
