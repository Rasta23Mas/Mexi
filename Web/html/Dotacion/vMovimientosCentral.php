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
$sesionInactiva = $_SESSION['sesionInactiva'];



include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once (HTML_PATH."menuGeneral.php");
include_once(HTML_PATH . "Dotacion/modalFlujo.php");
include_once(HTML_PATH . "Dotacion/modalBusqueda.php");

include_once(SQL_PATH . "sqlUsuarioDAO.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Movimientos</title>
    <script src="../../JavaScript/funcionesFlujo.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionNumerosLetras.js"></script>

    <script type="application/javascript">
        $(document).ready(function () {
            var sesionInactiva =<?php echo $sesionInactiva ?>;
            if(sesionInactiva==0){
                $("#sesionInactiva").hide();

            }else{
                $("#sesionInactiva").show();
                $("#btnReimprimirCentral").prop('disabled', true);
                $("#btnAceptarCentral").prop('disabled', true);
                $("#importeMovimientoCentral").prop('disabled', true);
            }
            var tipoUsuario = <?php echo $tipoUsuario?>;
            var muestraTR = false;
            tipoUsuario = Number(tipoUsuario);
            if (tipoUsuario == 1) {
                muestraTR = true;

            } else if (tipoUsuario == 2) {
                muestraTR = true;
            } else if (tipoUsuario == 3) {
                muestraTR = false;
            } else {
                $("#idCentral_BancoCheck").prop('disabled', true);
                $("#idBanco_CentralCheck").prop('disabled', true);
                $("#idBanco_BovedaCheck").prop('disabled', true);
                $("#idBoveda_BancoCheck").prop('disabled', true);
                $("#idBoveda_CajaCheck").prop('disabled', true);
                $("#idCaja_BovedaCheck").prop('disabled', true);
                muestraTR = false;
                $("#btnReimprimirCentral").prop('disabled', true);
                $("#btnAceptarCentral").prop('disabled', true);
                $("#importeMovimientoCentral").prop('disabled', true);
            }

            if (muestraTR) {
                $("#lblSaldoBancos").show();
                $("#idSaldoBancos").show();
            } else {
                $("#lblSaldoBancos").hide();
                $("#idSaldoBancos").hide();
            }

            $("#idTipoUsuario").val(tipoUsuario);
            generarFolio();
            $("#idFolioBuscar").val("");
            var fecha = fechaActual();
            document.getElementById('idFecha').innerHTML = fecha;

        })
    </script>
</head>
<style>
    .inputCliente {
    text-transform: uppercase;
    }
</style>

<body>
<form id="idFormCentral" name="formCentral">
    <div class="container-fluid">
        <div>
            <br>
        </div>
        <div class="row">
            <div class="col-12">
                <h4 align="center">Dotaciones</h4>
                <h2 align="center" id="sesionInactiva" style="color:#FF0000";>¡IMPORTANTE NO PODRA HACER OPERACIONES DE DOTACIÓN!</h2>
                <br>
                <table width="450" align="center" class="border border-primary" border="0">
                    <tr style="background: dodgerblue; color:white;">
                        <td align="left" colspan="4">
                            <label>&nbsp;&nbsp;&nbsp;Movimientos</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label class="form-check-label">
                                &nbsp;&nbsp;&nbsp;<input type="radio" name="central" id="idCentral_BancoCheck" value="1"
                                                         onclick="clickCentral()">
                                CENTRAL A BANCO</label>
                        </td>
                        <td class="border border-right-0 border-bottom-0 border-top-0 border-primary">
                            &nbsp;
                        </td>
                        <td>
                            <label>FOLIO:</label>
                            <label id="idFolio"></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label class="form-check-label">
                                &nbsp;&nbsp;&nbsp;<input type="radio" name="central" id="idBanco_CentralCheck" value="2"
                                                         onclick="clickCentral()">
                                BANCO A CENTRAL</>
                        </td>
                        <td class="border border-right-0 border-bottom-0 border-top-0 border-primary">
                            &nbsp;
                        </td>
                        <td>
                            <label>Fecha:</label>&nbsp;<label id="idFecha"></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label class="form-check-label">
                                &nbsp;&nbsp;&nbsp;<input type="radio" name="central" id="idBanco_BovedaCheck" value="3"
                                                         onclick="clickCentral()">
                                BANCO A BÓVEDA</>
                        </td>
                        <td class="border border-right-0 border-bottom-0 border-top-0 border-primary">
                            &nbsp;
                        </td>
                        <td>
                            <label>SALDO BÓVEDA</label>
                        </td>

                    </tr>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label class="form-check-label">
                                &nbsp;&nbsp;&nbsp;<input type="radio" name="central" id="idBoveda_BancoCheck" value="4"
                                                         onclick="clickCentral()">
                                BÓVEDA A BANCO</>
                        </td>
                        <td class="border border-right-0 border-bottom-0 border-top-0 border-primary">
                            &nbsp;
                        </td>
                        <td align="right">
                            <label id="idSaldoBoveda"></label>&nbsp;&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label class="form-check-label">
                                &nbsp;&nbsp;&nbsp;<input type="radio" name="central" id="idBoveda_CajaCheck" value="5"
                                                         onclick="clickCentral()">
                                BÓVEDA A CAJA</>
                        </td>
                        <td class="border border-right-0 border-bottom-0 border-top-0 border-primary">
                            &nbsp;
                        </td>
                        <td>
                            <label id="lblSaldoBancos">SALDO BANCOS</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label class="form-check-label">
                                &nbsp;&nbsp;&nbsp;<input type="radio" name="central" id="idCaja_BovedaCheck" value="6"
                                                         onclick="clickCentral()">
                                CAJA A BÓVEDA</>
                        </td>
                        <td class="border border-right-0 border-top-0 border-primary">
                            &nbsp;
                        </td>
                        <td align="right" id="trSaldoBancosVal"
                            class="border border-left-0 border-top-0 border-right-0 border-primary">
                            <label id="idSaldoBancos"></label>&nbsp;&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="height: 50px">
                            &nbsp;&nbsp;&nbsp;<label>Caja:</label></td>
                        <td align="left" style="height: 50px">
                            <select id="idUsuarioCaja" name="usuarioCaja" class="selectpicker" disabled
                                    style="width: 100px" onchange="validaCajaUsuario();">
                                <option value="0">Seleccione</option>
                                <?php
                                $data = array();
                                $sql = new sqlUsuarioDAO();
                                $data = $sql->usuariosCaja();
                                for ($i = 0; $i < count($data); $i++) {
                                    echo "<option value=" . $data[$i]['id_User'] . ">" . $data[$i]['NombreUser'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td colspan="2">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td >
                            &nbsp;&nbsp;&nbsp;<label>IMPORTE:</label>
                        </td>
                        <td >
                            <input id="importeMovimientoCentral" name="movimientoBoveda" type="text"
                                   style="width: 100px; text-align: right" placeholder="$0.00" onkeypress="return isNumberDecimal(event)"/>
                        </td>
                        <td colspan="2">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td >
                            &nbsp;&nbsp;&nbsp;<label>CONCEPTO:</label>
                        </td>
                        <td colspan="3">
                            <input id="idConcepto" name="concepto" type="text"  class="inputCliente"
                                   style="width: 300px; text-align: left"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" colspan="4">
                            <input type="button" id="btnAceptarCentral" class="btn btn-primary" value="Aceptar"
                                   style="width: 125px" onclick="aceptarCentral()">&nbsp;
                            <input type="button" class="btn btn-warning "
                                   data-toggle="modal" data-target="#modalBusqueda" id="btnReimprimirCentral"
                                   value="Re-Imprimir" >
                          <!--  <input type="button" class="btn btn-danger" value="Salir"
                                   style="width: 125px" onclick="salirCentral()">&nbsp;-->
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="">
                            <input id="idTipoUsuario" name="tipoUsuario" type="text"
                                   style="width: 100px; text-align: right" value=""/>
                            <input id="idSaldoCentralVal" name="saldoCentral" type="text"
                                   style="width: 100px; text-align: right" value=""/>
                            <input id="idSaldoBancosVal" name="saldoBanco" type="text"
                                   style="width: 100px; text-align: right" value=""/>
                            <input id="idSaldoBovedaVal" name="saldoBoveda" type="text"
                                   style="width: 100px; text-align: right" value=""/>
                            <input id="idSaldoCajaVal" name="saldoCaja" type="text"
                                   style="width: 100px; text-align: right" value=""/>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>

</body>
</html>
