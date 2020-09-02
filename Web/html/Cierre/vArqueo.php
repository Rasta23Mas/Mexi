<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

$sucursal = $_SESSION['sucursal'];
include_once(SQL_PATH . "sqlCierreDAO.php");
$tipoUsuario = $_SESSION['tipoUsuario'];
if ($tipoUsuario == 2) {
    include_once(HTML_PATH . "menuAdmin.php");
} elseif ($tipoUsuario == 3) {
    include_once(HTML_PATH . "menuGeneral.php");
} elseif ($tipoUsuario == 4) {
    include_once(HTML_PATH . "menuVendedor.php");
}
$tipoUsuario = $_SESSION['tipoUsuario'];
$idUserSesion = $_SESSION["idUsuario"];
$idCierreCaja =  $_SESSION["idCierreCaja"];
include_once(HTML_PATH . "Cierre/modalBusquedaArqueo.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cierre Caja</title>
<script src="../../JavaScript/funcionesArqueo.js"></script>
<script src="../../JavaScript/funcionesFlujo.js"></script>
<script src="../../JavaScript/funcionesGenerales.js"></script>
<script src="../../JavaScript/funcionNumerosLetras.js"></script>


<script type="application/javascript">
    $(document).ready(function () {
        var usuariotipo = <?php echo $tipoUsuario ?>;
        $("#idUserSesion").val(<?php echo $idUserSesion ?>);
        var cierreCaja = <?php echo $idCierreCaja?>;
        document.getElementById('idCierreCaja').innerHTML = cierreCaja;
        $("#idCierreCajaSesion").val(cierreCaja);
        if(usuariotipo==3){
            $("#idUsuarioCaja").prop('disabled', false);
        }
        saldoCajaUser();
    })
</script>
<style type="text/css">
    .titleTable {
        background: dodgerblue;
        color: white;
    }



</style>
<body>
<form id="idFormEmpeno" name="formEmpeno">
    <div class="container-fluid">
        <div>
            <br>
        </div>
        <div class="row">
            <div class="col-12 " align="center">
                <table width="70%" class="border border-primary" align="center" >
                    <tr align="center">
                        <td class="titleTable">
                            <label>Cajero</label>
                        </td>
                        <td class="titleTable">
                            <label>Operación Caja</label>
                        </td>
                        <td class="titleTable">
                            <label>Operación Sucursal</label>
                        </td>
                    </tr>
                    <tr align="center">
                        <td align="center">
                         <select id="idUsuarioCaja" name="usuarioCaja" class="selectpicker" disabled
                                       style="width: 100px" onchange="cambioDeArqueo();">
                                <?php
                                $data = array();
                                $sql = new sqlCierreDAO();
                                $data = $sql->cargarUsuariosCaja();
                                for ($i = 0; $i < count($data); $i++) {
                                    echo "<option value=" . $data[$i]['idUsuario'] . ">" . $data[$i]['Usuario'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td align="center" class="prueba">
                            <label id="idCierreCaja"></label>
                        </td>
                        <td align="center" class="prueba">
                            <label ><?php echo $_SESSION["idCierreSucursal"]; ?></label>
                        </td>
                    </tr>
                   <!-- <tr align="center">
                        <td class="titleTable">
                            <label>Fecha Inicial</label>
                        </td>
                        <td class="titleTable">
                            <label>Fecha Final</label>
                        </td>
                        <td class="titleTable">
                            <label>Buscar cierre </label>
                        </td>
                    </tr>
                    <tr align="center">
                        <td align="center">
                            <input type="text" name="fechaInicial" id="idFechaInicial" style="width: 100px"
                                   class="calendarioModBoton"
                                   disabled/>
                        </td>
                        <td>
                            <input type="text" name="fechaFinal" id="idFechaFinal" style="width: 100px"
                                   class="calendarioModBoton"
                                   disabled/>
                        </td>
                        <td align="center">
                            <input type="button" class="btn btn-success w-25"
                                   data-toggle="modal" data-target="#modalArqueo"
                                   onclick="buscarArqueo()"
                                   value="Buscar"/>
                        </td>
                    </tr>-->
                </table>
            </div>
        </div>
            <div class="col-12">
                <table width="80%" border="0" align="center">
                    <tr>
                        <br>
                    </tr>
                    <tr>
                        <td align="center"  style="width: 700px;">
                            <table class="table-bordered border-primary" width="80%">
                                <tr style="background: dodgerblue; color:white;">
                                    <td align="center" colspan="5">
                                        <label>BILLETES</label>
                                    </td>
                                </tr>
                                <tr >
                                    <td colspan="2" align="center" style="width: 40%"><label> $1000.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idMilCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="right"><label id="lblMil"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> 500.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idQuinientosCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="right"><label id="lblQuinientos"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> 200.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idDoscientosCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="right"><label id="lblDoscientos"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> 100.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCienCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="right"><label id="lblCien"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> 50.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCincuentaCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="right"><label id="lblCincuenta"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%" ><label> 20.00</label></td>
                                    <td  align="center" style="width: 70px" >
                                        <input type="text" name="billete" placeholder="0" id="idVeinteCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="right" ><label id="lblVeinte"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="center" style="width: 40%" >
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">
                                        TOTAL BILLETES:&nbsp;
                                    </td>
                                    <td colspan="2" align="right">
                                        <label id="lblTotalBilletes"></label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td align="center" style="width: 700px;">
                            <table class="table-bordered border-primary" width="80%">
                                <tr style="background: dodgerblue; color:white;">
                                    <td align="center" colspan="5">
                                        <label>MONEDAS</label>
                                    </td>
                                </tr>
                                <tr >
                                    <td colspan="2" align="center" style="width: 40%"><label> $20.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idVeinteMonCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="right"><label id="lblVeinteMon"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label>10.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idDiezCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="right"><label id="lblDiez"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> 5.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCincoCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="right"><label id="lblCinco"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> 2.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idDosCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="right"><label id="lblDos"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> 1.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idUnoCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="right"><label id="lblUno"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> .50</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCincuentaCCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="right"><label id="lblCincuentaC"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label>Centavos</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCentavosCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="right"><label id="lblCentavos"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">
                                        TOTAL MONEDAS:&nbsp;
                                    </td>
                                    <td colspan="2" align="right">
                                        <label id="lblTotalMonedas"></label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL ARQUEO:</label>&nbsp;&nbsp;<label id="lblTotalArqueo"></label></h5>
                        </td>

                        <td align="right">
                            <input type="button" class="btn btn-primary" id="btnCalculaArqueo" value="Calcular Arqueo" onclick="arqueo()">&nbsp;
                            <input type="button" class="btn btn-success" id="btnGuardarArqueo" value="Guardar Arqueo" onclick="confirmarGuardarCaja()">&nbsp;
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="invisible">
                            <input type="text" name="userSesion" id="idUserSesion" style="width: 100px"
                                   disabled/>
                            <input type="text" name="cierreCaja" id="idCierreCajaSesion" style="width: 100px"
                                   disabled/>
                            <label>saldo caja</label>
                            <input type="text" name="saldoCaja" id="idSaldoCajaVal" style="width: 100px"
                                   disabled/>
                            <label>Entradas caja</label>
                            <input type="text" name="saldoCajaIva" id="idSaldoCajaEntradas" style="width: 100px"
                                   disabled/>
                            <label>iva caja</label>
                            <input type="text" name="saldoCajaIva" id="idSaldoCajaIva" style="width: 100px"
                                   disabled/>
                            <label>interes caja</label>
                            <input type="text" name="SaldoCajaInteres" id="idSaldoCajaInteres" style="width: 100px"
                                   disabled/>
                            <label>interes mor</label>
                            <input type="text" name="SaldoCajaMor" id="idSaldoCajaMor" style="width: 100px"
                                   disabled/>
                            <label>interes auto</label>
                            <input type="text" name="saldoCajaAuto" id="idSaldoCajaAuto" style="width: 100px"
                                   disabled/>
                            <label>vanta</label>
                            <input type="text" name="saldoVenta" id="idSaldoVenta" style="width: 100px"
                                   disabled/>
                            <label>saldo caja</label>
                            <input type="text" name="saldoCajaSistema" id="idSaldoCajaSistema" style="width: 100px"
                                   disabled/>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>

</body>
</html>
