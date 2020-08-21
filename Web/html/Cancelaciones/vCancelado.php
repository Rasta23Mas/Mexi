<?php
if (!isset($_SESSION)) {
    session_start();
}
if(!isset($_SESSION["idUsuario"])){
    header("Location: ../index.php");
    session_destroy();
}

$sucursal = $_SESSION['sucursal'];
$tipoUsuario = $_SESSION['tipoUsuario'];


include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');

if($tipoUsuario==2){
    include_once (HTML_PATH."menuAdmin.php");
}elseif ($tipoUsuario==3){
    include_once (HTML_PATH."menuGeneral.php");
}elseif ($tipoUsuario==4){
    include_once (HTML_PATH."menuVendedor.php");
}
include_once (HTML_PATH. "Cancelaciones/modalCancelar.php");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cierre Caja</title>
<script src="../../JavaScript/funcionesCancelar.js"></script>
<script src="../../JavaScript/funcionesGenerales.js"></script>

<script type="application/javascript">
    $(document).ready(function () {
        $("#divCancelados").load('tablaCancelacionEmpeño.php');
    })
</script>
<body>
<form id="idFormEmpeno" name="formEmpeno">
    <div class="container-fluid">
        <div>
            <br>
        </div>
        <div class="row">
            <div class="col-12">
                <h4 align="center">Cancelaciones</h4>
                <br>
                <table width="20%" align="center" class="table-bordered border-primary ">
                    <tr style="background: dodgerblue; color:white;">
                        <td align="center" colspan="2">
                            <label>Empeños</label>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="width: 50%">
                            <input type="radio" name="auto" id="idAutoCheck" onclick="clickAuto()">
                            Auto</label>
                        </td>
                        <td>
                            <input type="button" class="btn btn-warning" value="Limpiar"
                                   style="width: 130px" onclick="limpiarCancelado()">&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                            <input type="button" class="btn btn-success" value="Empeños"
                                   style="width: 130px" onclick="cancelarEmpeño()">&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                            <input type="button" class="btn btn-success" value="Refrendo"
                                   style="width: 130px" onclick="cancelarRefrendo()">&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                            <input type="button" class="btn btn-success" value="Desempeño"
                                   style="width: 130px"  onclick="cancelarDesempeño()">&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                            <input type="button" class="btn btn-success" value="Todos"
                                   style="width: 130px"  onclick="cancelarTodos()">&nbsp;
                        </td>
                    </tr>
                    <tr style="background: dodgerblue; color:white;">
                        <td align="center" colspan="2">
                            <label>Cierre</label>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                            <input type="button" class="btn btn-success" value="Cierre Caja"
                                   style="width: 130px"  onclick="cancelarCierreCaja()">&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                            <input type="button" class="btn btn-success" value="Cierre Sucursal"
                             style="width: 130px"  onclick="cancelarCierreSucursal()">&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <br>
        <div class="row">
            <div id="divCancelados" class="col col-lg-12">
            </div>

        </div>

    </div>
</form>

</body>
</html>
