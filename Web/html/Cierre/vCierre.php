<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["idUsuario"])) {
    header("Location: ../index.php");
    session_destroy();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(HTML_PATH . "Cierre/menuCierre.php");
include_once(SQL_PATH . "sqlCierreDAO.php");
include_once(HTML_PATH . "Cierre/modalBusquedaCaja.php");

$UsuarioNombre = $_SESSION["usuario"];
$idCierreSucursal = $_SESSION['idCierreSucursal'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../../JavaScript/funcionesCierreSucursal.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionesCalendario.js"></script>
    <link rel="stylesheet" type="text/css" href="../../librerias/jqueryui/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="../../librerias/jqueryui/jquery-ui.min.js"></script>
    <script type="application/javascript">
        $(document).ready(function () {
            document.getElementById('usuarioNombre').innerHTML = '<?php echo $UsuarioNombre?>';
            var cierreSucursal = <?php echo $idCierreSucursal?>;

            document.getElementById('idCierreSucursal').innerHTML = cierreSucursal;

            $("#guardarCaja").prop('disabled', true);

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
        .primeraColLeft {
            width: 75px;
            text-align: left;
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
            <h3 align="center">Cierre de Sucursal</h3>
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
                            <label>Operación Sucursal</label>
                        </td>
                        <td class="titleTable">
                            <label>Cargar Caja</label>
                        </td>
                    </tr>
                    <tr align="center">
                        <td align="center" class="prueba">
                            <label id="usuarioNombre"></label>
                        </td>
                        <td align="center" class="prueba">
                            <label id="idCierreSucursal"></label>
                        </td>
                        <td align="center">
                            <input type="button" class="btn btn-primary w-50" value="Cargar" id="cargarUsuario" onclick="validarEsatusSucursal()"/>
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
                                   onclick="validarEsatusSucursal()"
                                   value="Buscar"/>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div>
            <br>
        </div>
        <div class="row">
            <div class="col-1">
            </div>
            <div class="col-10 " align="center">
                <br>
                <table border="0" width="850px">
                    <tr>
                        <td class="primeraColLeft border border-primary" colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;SALDO INICIAL:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="saldoInicial"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td colspan="3" class="titleTable border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;RETIROS DE EFECTIVO</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraColLeft border border-primary" colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;DOTACIONES A CAJA:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="dotaciones"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                            <label id="CantRetirosCaja"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;RETIROS A CAJA:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="retirosCaja"></label>
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
                        <td class="primeraCol border border-primary">
                            <label id="CantAportaciones"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;APORTACIONES BÓVEDA:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="aportaciones"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                            <label id="CantRetiros"></label>
                        </td>
                        <td class="segundaCol border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;RETIROS A BÓVEDA:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="retiros"></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantRecuperado"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;CAPITAL RECUPERADO:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="recuperado"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                            <label id="CantPrestamos"></label>
                        </td>
                        <td class="segundaCol border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;PRESTAMOS NUEVOS:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="prestamos"></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantAbono"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;ABONO A CAPITAL:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="abono"></label>
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
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantInteres"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;INTERESES:</label>
                        </td>

                        <td class="terceraCol  border border-primary">
                            <label id="interes"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraCol border border-primary">
                            <label id="CantDescVentas"></label>
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
                            <label id="CantIva"></label>
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
                        <td colspan="3" class="titleTable border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;TOTALES</label>
                        </td>


                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantVentas"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;VENTAS MOSTRADOR:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="ventas"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales border border-primary" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;TOTAL ENTRADAS:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="totalEntrados"></label>
                        </td>


                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantIvaVentas"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;IVA VENTAS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="ivaVentas"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales border border-primary" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;TOTAL IVA:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="totalIVA"></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                        <!--<label id="CantIvaUtilidad"></label>-->
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;UTILIDAD VENTA:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="utilidad"></label>
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
                        <td class="primeraCol border border-primary">
                            <label id="CantApartados"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;APARTADOS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="apartadoVenta"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales border border-primary" colspan="2">
                            <b><label>&nbsp;&nbsp;&nbsp;SALDO FINAL:</label>
                        </td>
                        <td class="terceraCol border border-primary">
                            <label id="saldoFinal"></label>
                        </td>

                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantAbonoVenta"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;ABONO:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="abonoVenta"></label>
                        </td>

                        <td class="espacioEnmedio " colspan="4">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantGPS"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;GPS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="gps"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>

                        <td colspan="3" class="titleTable border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;INFORMATIVOS</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantPoliza"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;POLIZA:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="poliza"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales  border border-primary" colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;SALDO INICIAL:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="saldoInicialDepo"></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantPension"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;PENSION:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="pension"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales  border border-primary"  colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;ENTRADAS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="entradas"></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol border border-primary">
                            <label id="CantAjustes"></label>
                        </td>
                        <td class="segundaCol  border border-primary">
                            <label>&nbsp;&nbsp;&nbsp;AJUSTES:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="ajustes"></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales  border border-primary"  colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;SALIDAS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="salidas"></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol" colspan="3">
                            <label></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales  border border-primary"  colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;SALDO FINAL:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="saldoFinalDepo"></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol" colspan="3">
                            <label></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                   <!--     <td class="primeraColTotales  border border-primary"  colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;DEPOSITARIA VIGENTE:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="depositariaVigente"></label>
                        </td>-->
                        <td class="primeraColTotales  border border-primary"  colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;APARTADOS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="apartadosInfo"></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol" colspan="3">
                            <label></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales  border border-primary"  colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;ABONOS:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="abonosInfo"></label>
                        </td>
                    </tr>
                    <tr>
                        <td class="primeraCol" colspan="3">
                            <label></label>
                        </td>
                        <td class="espacioEnmedio ">
                            <br>
                        </td>
                        <td class="primeraColTotales  border border-primary"  colspan="2">
                            <label>&nbsp;&nbsp;&nbsp;TOTAL INVENTARIO:</label>
                        </td>
                        <td class="terceraCol  border border-primary">
                            <label id="totalInventarioInfo"></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <br>
                        </td>
                    </tr>
                        <tr>
                        <td colspan="7"  align="right">
                            <input type="button" class="btn btn-warning w-25" value="Limpiar" id="idLimpiarCaja" onclick="limpiarCierreCaja()"/>
                            &nbsp;&nbsp;&nbsp;
                            <input type="button" class="btn btn-primary w-25" value="Guardar" id="guardarCaja" onclick="confirmarCierreSucursal()"/>
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
