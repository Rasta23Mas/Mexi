<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["idUsuario"])) {
    header("Location: ../index.php");
    session_destroy();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
$tipoUsuario = $_SESSION['tipoUsuario'];
if ($tipoUsuario == 2) {
    include_once(HTML_PATH . "menuAdmin.php");
} elseif ($tipoUsuario == 3) {
    include_once(HTML_PATH . "menuGeneral.php");
} elseif ($tipoUsuario == 4) {
    include_once(HTML_PATH . "menuVendedor.php");
}
include_once(SQL_PATH . "sqlCierreDAO.php");
include_once(HTML_PATH . "Cierre/modalBusquedaCaja.php");

$tipoUsuario = $_SESSION['tipoUsuario'];
$idUserSesion = $_SESSION["idUsuario"];
$idCierreCaja =  $_SESSION["idCierreCaja"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../../JavaScript/funcionesCierres.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionNumerosLetras.js"></script>
    <script src="../../JavaScript/funcionesCalendario.js"></script>
    <link rel="stylesheet" type="text/css" href="../../librerias/jqueryui/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="../../librerias/jqueryui/jquery-ui.min.js"></script>
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
            $("#guardarCaja").prop('disabled', true);
            $("#idTipoSesion").val(usuariotipo);

        })
    </script>

    <style type="text/css">
        .titleTable {
            background: dodgerblue;
            color: white;
        }

        .titleTableEntrada {
            background: #33cc33;
            color: white;
        }

        .titleTableSalida {
            background: #ff0000;
            color: white;
        }

        .primeraColTotales {
            width: 75px;
            text-align: right;
        }

        .espacioEnmedio {
            width: 50px;
        }

        .terceraCol {
            text-align: right;
        }

        .primeraCol {
            width: 75px;
            text-align: center;
        }

        .segundaCol {
            width: 200px;
        }

        .terceraCol {
            width: 100px;
        }

    </style>

</head>
<body>
<form id="idFormEmpeno" name="formEmpeno">
    <div class="container-fluid" style="position: absolute; top: 8.2vh; height: 91.8vh">
        <div>
            <br>
            <h3 align="center">Cierre de caja</h3>
            <br>
        </div>
        <div class="row">
            <div class="col-1">
            </div>
            <div class="col-10 " align="center">
                <table width="80%" class="border border-primary" align="center" >
                    <tr align="center">
                        <td class="titleTable">
                            <label>Cajero</label>
                        </td>
                        <td class="titleTable">
                            <label>Operación Caja</label>
                        </td>
                        <td class="titleTable">
                            <label>Cargar Caja</label>
                        </td>
                    </tr>
                    <tr align="center">
                        <td align="center">
                       <select id="idUsuarioCaja" name="usuarioCaja" class="selectpicker" disabled
                                    style="width: 100px" onchange="cambioDeCaja();">
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
                        <td align="center">
                            <input type="button" class="btn btn-primary w-50" value="Cargar" id="cargarUsuario" onclick="validarEsatusCaja()"/>
                        </td>
                    </tr>
                    <tr align="center">
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
                            <input type="button" class="btn btn-success w-50"
                                   data-toggle="modal" data-target="#modalCierreCaja"
                                   onclick="buscarCierreCaja()"
                                   value="Buscar"/>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-1">
            </div>
            <div class="col-10 " align="center">
                <br>
                <table border="0" width="850px">
                    <tr>
                        <td colspan="3" class="titleTable border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;DOTACIONES DE EFECTIVO</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="titleTable border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;RETIROS DE EFECTIVO</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantDotacionesCaja"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;DOTACIONES A CAJA</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="dotacionCajaVal"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                            <label id="CantRetiroCaja"></label>
                        </td>
                        <td class="segundaCol border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;RETIROS A CAJA</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="retiroCaja"></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7"><br></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="titleTableEntrada" align="center">
                            <label>&nbsp;&nbsp;&nbsp;ENTRADAS</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="titleTableSalida" align="center">
                            <label>&nbsp;&nbsp;&nbsp;SALIDAS</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7"><br></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="titleTable border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;TRADICIONALES</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="titleTable border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;TRADICIONALES</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantCapitalRecuperado"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;CAPITAL RECUPERADO:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="capitalRecuperado"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                            <label id="CantPrestamosNuevos"></label>
                        </td>
                        <td class="segundaCol border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;PRÉSTAMOS NUEVOS:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="prestamosNuevos"></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantAbonoCapital"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;ABONO A CAPITAL:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="abonoCapital"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                            <label id="CantDescuentos"></label>
                        </td>
                        <td class="segundaCol border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;DESC. APLICADOS:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="descuentos"></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantIntereses"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;INTERESES:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="intereses"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                            <label id="CantDescuentosVentas"></label>
                        </td>
                        <td class="segundaCol border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;DESC. VENTAS:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="descuentosVentas"></label>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantCostoContrato"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;COSTO CONTRATO:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="costoContrato"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                            <label id="CantPatrimonio"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;INCREMENTO PAT.:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="patrimonio"></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantIVA"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;I.V.A. :</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="iva"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="">
                            <br>
                        </td>
                    </tr>
                    <tr>

                        <td class="primeraCol border border-primary">
                            <label id="CantGps"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;RENTA GPS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="gps"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="titleTable border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;TOTALES</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantPoliza"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;PÓLIZA:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="poliza"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales border border-primary" colspan="2">
                            <label><b>&nbsp;&nbsp;&nbsp;TOTAL ENTRADAS:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="totalEntradas"></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantPension"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;PENSIÓN:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="pension"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales border border-primary" colspan="2">
                            <label><b>&nbsp;&nbsp;&nbsp;TOTAL IVA:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="totalIVA"></label>
                        </td>
                    </tr>
                    <tr>

                        <td class="primeraCol border border-primary">
                            <label id="CantAjuste"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;AJUSTES:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="ajustesArq"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales border border-primary" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;TOTAL SALIDAS:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="totalSalidas"></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" >

                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales border border-primary" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;SALDO CAJA:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="saldoCaja"></label>
                        </td>

                    <!--    <td class="primeraColTotales border border-primary" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;AJUSTE:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="ajuste"></label>
                        </td>-->

                    </tr>
                    <tr>
                        <td colspan="3" class="titleTable border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;VENTAS</label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales border border-primary" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;EFECTIVO CAJA:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="efectivoCaja"></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantMostrador"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;CAPITAL RECUPERADO:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="mostrador"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>

                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantIvaVenta"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;I.V.A.:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="ivaVenta"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantApartados"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;APARTADOS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="apartados"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantAbono"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;ABONOS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="abono"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantRefrendos"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;* INFORM. REFRENDO:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="refrendos"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3"  align="right">
                            <input type="button" class="btn btn-warning w-25" value="Limpiar" id="idLimpiarCaja" onclick="limpiarCierreCaja()"/>
&nbsp;&nbsp;&nbsp;
                            <input type="button" class="btn btn-primary w-25" value="Guardar" id="guardarCaja" onclick="confirmarGuardarCierre()"/>
                        </td>
                    </tr>
                    <tr style="visibility: hidden">
                        <td class="primeraCol">
                            <input type="text" name="userSesion" id="idUserSesion" style="width: 100px"
                                   disabled/>
                        </td>
                        <td class="segundaCol">
                            <input type="text" name="cierreCaja" id="idCierreCajaSesion" style="width: 100px"
                                   disabled/>
                        </td>
                        <td class="terceraCol">
                            <input type="text" name="tipoSesion" id="idTipoSesion" style="width: 100px"
                                   disabled/>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3"  align="right">

                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-1">
            </div>
        </div>
        <div>
            <br>
            <br>
        </div>
    </div>
</form>

</body>
</html>
