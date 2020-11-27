<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Menu.php');
$sucursal = $_SESSION['sucursal'];

include_once (HTML_PATH. "Cancelaciones/modalCancelar.php");

$fechaGuardada = $_SESSION["ultimoAcceso"];
$ahora = date("Y-n-j H:i:s");
$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
$tiempo_limite = 20;
echo $tiempo_transcurrido;
echo '/';
echo $tiempo_limite;
echo '/';
if($tiempo_transcurrido >= $tiempo_limite) {
    session_destroy();
    echo 'Entra';
    header("Location: ../../../index.php");
    //header("Location: $url");
}else {
    echo $ahora;
    $_SESSION["ultimoAcceso"] = $ahora;

}

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
        $("#divCancelados").load('tablaCancelacionEmpeno.php');
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
                        <td align="center" colspan="4">
                            <label>Artículos</label>
                        </td>
                        <td align="center" colspan="4">
                            <label>Bazar</label>
                        </td>
                        <td align="center" colspan="2">
                            <label>Cierre</label>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="width: 50%" colspan="2">
                            <input type="radio" name="auto" id="idAutoCheck" onclick="clickAuto()">
                            Auto</label>
                        </td>
                        <td colspan="2" align="center">
                            <input type="button" class="btn btn-warning" value="Limpiar"
                                   style="width: 130px" onclick="limpiarCancelado()">&nbsp;
                        </td>
                        <td colspan="4">
                            <br>
                        </td>
                        <td colspan="2">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center"><br>
                            <input type="button" class="btn btn-success" value="Empeños"
                                   style="width: 130px" onclick="cancelarEmpeno()">&nbsp;
                        </td>
                        <td align="center"><br>
                            <input type="button" class="btn btn-success" value="Refrendo"
                                   style="width: 130px" onclick="cancelarRefrendo()">&nbsp;
                        </td>
                        <td align="center"><br>
                            <input type="button" class="btn btn-success" value="Desempeño"
                                   style="width: 130px"  onclick="cancelarDesempeno()">&nbsp;
                        </td>
                        <td align="center"><br>
                            <input type="button" class="btn btn-success" value="Todos"
                                   style="width: 130px"  onclick="cancelarTodos()">&nbsp;
                        </td>
                        <td align="center"><br>
                            <input type="button" class="btn btn-success" value="Compras"
                                   style="width: 130px"  onclick="cancelarCompra()">&nbsp;
                        </td>
                        <td align="center"><br>
                            <input type="button" class="btn btn-success" value="Ventas"
                                   style="width: 130px"  onclick="cancelarVenta()">&nbsp;
                        </td>
                        <td align="center"><br>
                            <input type="button" class="btn btn-success" value="Apartado"
                                   style="width: 130px"  onclick="cancelarApartado()">&nbsp;
                        </td>
                        <td align="center"><br>
                            <input type="button" class="btn btn-success" value="Abono"
                                   style="width: 130px"  onclick="cancelarAbono()">&nbsp;
                        </td>
                        <td align="center"><br>
                            <input type="button" class="btn btn-success" value="Cierre Caja"
                                   style="width: 130px"  onclick="cancelarCierreCaja()">&nbsp;
                        </td>
                        <td align="center" ><br>
                            <input type="button" class="btn btn-success" value="Cierre Sucursal"
                                   style="width: 130px"  onclick="cancelarCierreSucursal()">&nbsp;
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
