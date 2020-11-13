<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Menu.php');
$tipoFormularioGet = 0;
if (isset($_GET['tipoFormGet'])) {
    $tipoFormularioGet = $_GET['tipoFormGet'];
}
$ContratoGet = 0;
if (isset($_GET['contrato'])) {
    $ContratoGet = $_GET['contrato'];
}


include_once (DESC_PATH."modalDescuentoToken.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mexicash</title>
    <script src="../../JavaScript/funcionesDesempeno.js"></script>
    <script src="../../JavaScript/funcionesMovimiento.js"></script>
    <script type="application/javascript">
        var form = <?php echo $tipoFormularioGet?>;
        var ContratoEnviado = <?php echo $ContratoGet?>;
        var nameForm = "Error";
        var tipoArticuloOAuto = 0;
        form = parseInt(form);
        $(document).ready(function () {
            $("#btnGenerar").prop('disabled', true);
            $("#idFormulario").val(form);

             if (form === 3) {
                nameForm = "Desempeño";
                $("#idGPSTH").hide();
                $("#idPensionTH").hide();
                $("#idPolizaTH").hide();
                $("#idGPSTDform").hide();
                $("#idPensionTDform").hide();
                $("#idPolizaTDform").hide();
                $("#trGPSNota").hide();
                $("#trPensionNota").hide();
                $("#trPolizaNota").hide();
                $("#idAbonoTDform").hide();
                $("#idAbonoTH").hide();

                //Botones
                $("#btnGenerar").val(nameForm)
                $("#idFormulario").val(form);
                tipoArticuloOAuto = 1;
                $("#idTipoDeContrato").val(tipoArticuloOAuto);
                $("#trAbonoNotaNuevo").hide();
            } else if (form === 4) {
                nameForm = "Desempeño Auto";
                tipoArticuloOAuto = 2;
                $("#trAbonoNotaNuevo").hide();
                $("#idAbonoTDform").hide();
                $("#idAbonoTH").hide();
                //Botones
                $("#btnGenerar").val(nameForm)
                $("#idFormulario").val(form);
                $("#idTipoDeContrato").val(tipoArticuloOAuto);
            }

            document.getElementById('nameFormLbl').innerHTML = nameForm;
            if (ContratoEnviado !== 0) {
                $("#idContrato").val(ContratoEnviado);
                busquedaMovimiento();
                $("#btnGenerar").hide();
                $("#btnGenerarSinInteres").show();
                $("#btnGenerarSinInteres").val(nameForm)


            } else {
                $("#trCostoContrato").hide();
                $("#trTotalSinInteres").hide();
                $("#trIvaSinInteres").hide();
                $("#btnGenerarSinInteres").hide();
            }
        });
    </script>
    <style>
        .propInvisible {
            visibility: visible;
        }
        .letraExtraChica {
            font-size: .9em;
        }
    </style>
</head>
<body>
<form id="idFormDesRef" name="formDes">
    <div id="newContenedor" class="letraExtraChica">
        <div class="row" align="center">
            <div class="col col-lg-12">
                <br>
                <h2><label id="nameFormLbl"></label></h2>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col col-lg-1">
            </div>
            <div class="col col-lg-3 border border-primary ">
                <table border="0" width="100%">
                    <tr>
                        <td style="width: 200px" align="left">
                            <label>Contrato:</label>
                            <input type="text" id="idContrato" name="contrato" size="10"
                                   onkeypress="return busquedaRefrendo(event)"
                                   style="text-align:right"/>
                        </td>
                    </tr>
                        <tr>
                        <td align="left">
                            <input type="button" class="btn btn-info " id="btnBuscar" onclick="busquedaMovimiento();"
                                   value="Buscar">
                            <input type="button" class="btn btn-warning" value="Cancelar" onclick="cancelar()">&nbsp;

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Nombre del Cliente:
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label id="lblNombreCliente"><label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Datos del Cliente:
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <textarea rows="4" cols="30" id="idDatosClienteDes" class="textAreaUP" disabled>
                            </textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Datos del Contrato:
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <!--   <textarea rows="13" cols="45" id="idDatosContratoDes" class="textAreaRes" disabled>
                               </textarea>-->
                            <table>
                                <tr>
                                    <td><label>Fecha Empeño :</label></td>
                                    <td><input type="text" id="idTblFechaEmpeno" name="tblFechaEmpe" size="10" disabled
                                               style="text-align:left"/></td>
                                </tr>
                                <tr>
                                    <td><label>Fecha Vencimiento :</label></td>
                                    <td><input type="text" id="idTblFechaVenc" name="tblFechaVenc" size="10" disabled
                                               style="text-align:left"/></td>
                                </tr>
                                <tr>
                                    <td><label>Fecha Comercialización :</label></td>
                                    <td><input type="text" id="idTblFechaComer" name="tblFechaComer" size="10" disabled
                                               style="text-align:left"/></td>
                                </tr>
                                <tr>
                                    <td><label>Días transcurridos :</label></td>
                                    <td><input type="text" id="idTblDiasTransc" name="tblDiasTransc" size="10" disabled
                                               style="text-align:center"/></td>
                                </tr>
                                <tr>
                                    <td><label>Días transcurridos interés :</label></td>
                                    <td><input type="text" id="idTblDiasTransInt" name="tblDiasTranscInteres" size="10"
                                               disabled
                                               style="text-align:center"/></td>
                                </tr>
                                <tr>
                                    <td><label>Plazo :</label></td>
                                    <td><input type="text" id="idTblPlazo" name="tblPlazo" size="10" disabled
                                               style="text-align:center"/></td>
                                </tr>
                                <tr>
                                    <td><label>Tasa :</label></td>
                                    <td><input type="text" id="idTblTasa" name="tblTasa" size="10" disabled
                                               style="text-align:center"/></td>
                                </tr>
                                <tr>
                                    <td><label>Interés diario :</label></td>
                                    <td><input type="text" id="idTblInteresDiario" name="tblInteresDiario" size="10"
                                               disabled
                                               style="text-align:center"/></td>
                                </tr>
                                <tr>
                                    <td><label>Interés :</label></td>
                                    <td><input type="text" id="idTblInteres" name="tblInteres" size="10" disabled
                                               style="text-align:center"/></td>
                                    <td><input type="text" id="idTblInteresDesc" name="tblInteres" size="5" disabled
                                               style="text-align:center" class="propInvisible"/></td>
                                </tr>
                                <tr>
                                    <td><label>Almacenaje :</label></td>
                                    <td><input type="text" id="idTblAlmacenaje" name="contrato" size="10" disabled
                                               style="text-align:center"/></td>
                                    <td><input type="text" id="idTblAlmacenajeDesc" name="contrato" size="5" disabled
                                               style="text-align:center" class="propInvisible"/></td>

                                </tr>
                                <tr>
                                    <td><label>Seguro :</label></td>
                                    <td><input type="text" id="idTblSeguro" name="tblSeguro" size="10" disabled
                                               style="text-align:center"/></td>
                                    <td><input type="text" id="idTblSeguroDesc" name="tblSeguro" size="5" disabled
                                               style="text-align:center" class="propInvisible"/></td>
                                </tr>
                                <tr>
                                    <td><label>Moratorios :</label></td>
                                    <td><input type="text" id="idTblMoratorios" name="tblMoratorios" size="10" disabled
                                               style="text-align:center"/></td>
                                </tr>
                                <tr>
                                    <td class="propInvisible"><label>I.V.A. :</label></td>
                                    <td class="propInvisible"><input type="text" id="idTblIva" name="tblIva" size="10" disabled
                                               style="text-align:center"/></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Descripción de la prenda:
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <textarea rows="4" cols="30" id="idDetalleContratoDes" class="textAreaUP" disabled>
                            </textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col col-md-7 border border-primary border-left-0">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4">
                            <div>
                                <table class="table table-bordered " width="100%">
                                    <thead>
                                    <th>Contrato</th>
                                    <th>Préstamo</th>
                                    <th>Interés</th>
                                    <th id="idGPSTH">GPS</th>
                                    <th id="idPolizaTH">Poliza</th>
                                    <th id="idPensionTH">Pension</th>
                                    <th id="idAbonoTH">Abono</th>
                                    </thead>
                                    <tr align="center">
                                        <td><label id="idConTDDes"></label></td>
                                        <td><label id="idPresTDDes"></label></td>
                                        <td><label id="idInteresTDDes"></label></td>
                                        <td id="idGPSTDform"><label id="idGPSTDDes"></label></td>
                                        <td id="idPensionTDform"><label id="idPensionTDDes"></label></td>
                                        <td id="idPolizaTDform"><label id="idPolizaTDDes"></label></td>
                                        <td id="idAbonoTDform"><label id="idAbonoTDDes"></label></td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 200px;">
                            <h6>Préstamo:</label></h6>
                        </td>
                        <td align="right" style="width: 180px;">
                            <h6><input type="text" id="idPrestamoNotaNuevo" name="prestamoNota"
                                       style="width: 160px; text-align: right" disabled value="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="prestamoNuevoNota" name="Prestamo"
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>
                    <tr id="trInteresNovo">
                        <td align="right">
                            <h6>Interés:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idInteresNotaNuevo" name="prestamoNota"
                                       style="width: 160px; text-align: right" disabled value="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="interesNuevoNota" name="Interes"
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>

                    <tr id="trMoratorioNovo">
                        <td align="right">
                            <h6>Moratorios:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idMoratorioNotaNuevo" name="prestamoNota"
                                       style="width: 160px; text-align: right" disabled value="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="moratoriosNuevoNota" name="Moratorios"
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>
                    <tr id="trGPSNota">
                        <td align="right">
                            <h6>GPS:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idGPSNota" name="gpsNota"
                                       style="width: 160px; text-align: right" disabled value="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="gpsNuevoNota" name="Gps" value="0"
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>
                    <tr id="trPolizaNota">
                        <td align="right">
                            <h6>Poliza:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idPolizaNota" name="polizaNota"
                                       style="width: 160px; text-align: right" disabled value="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="polizaNuevoNota" name="Poliza" value="0"
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>
                    <tr id="trPensionNota">
                        <td align="right">
                            <h6>Pension:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idPensionNota" name="pensionNota"
                                       style="width: 160px; text-align: right" disabled value="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="pensionNuevoNota" name="Pension" value="0"
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>

                    <tr id="trtotalInteresNovo">
                        <td align="right">
                            <h6>Total Interés:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idTotalInteresNotaNuevo" name="prestamoNota"
                                       style="width: 160px; text-align: right" disabled value="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="totalInteresNuevoNota" name="TotalInteres"
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>
                    <tr id="trIva">
                        <td align="right">
                            <h6>IVA:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idIVANotaNuevo" name="prestamoNota"
                                       style="width: 160px; text-align: right" disabled value="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="idIVAValue" class="propInvisible" name="IVA"
                                   style="width: 100px; text-align: right "/>
                        </td>
                    </tr>
                    <tr id="trInteresPagarNovo">
                        <td align="right">
                            <h6>Interés a pagar:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idInteresAPagarNotaNuevo" name="prestamoNota"
                                       style="width: 160px; text-align: right" disabled value="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="interesPagarNuevoNota" name="Interes"
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>
                    <tr id="trInteresPagarNovo">
                        <td align="right">
                            <h6>Gastos Administración:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idGastosAdminNotaNuevo" name="prestamoNota"
                                       style="width: 160px; text-align: right" disabled value="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="gastosAdminNuevoNota" name="Interes"
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>
                    <tr id="trDescuentoInteresNovo">
                        <td align="right">
                            <h6>Descuento a interés:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idDescuentoNotaNuevo" name="prestamoNota"
                                       style="width: 160px; text-align: right" disabled placeholder="$0.00"
                                       onkeypress="return descuentoNuevo(event)"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="descuentoNuevoNota" name="Descuento"
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>
                    <tr id="trTotalAPagarNovo">
                        <td align="right">
                            <h6>Total a pagar:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idTotalAPagarNotaNuevo" name="prestamoNota"
                                       style="width: 160px; text-align: right" disabled value="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="totalPagarNuevoNota" name="TotalPagar"
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>
                    <tr id="trCostoContrato">
                        <td align="right">
                            <h6>Costo por contrato:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idCostoContrato" name="costoContratoNota"
                                       style="width: 160px; text-align: right" disabled value="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="idCostoContratoValue" name="CostoContrato" value=""
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>
                    <tr id="trIvaSinInteres">
                        <td align="right">
                            <h6>IVA:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idIVANotaNuevoSinInteres" name="prestamoNota"
                                       style="width: 160px; text-align: right" disabled value="$0.00"/></h6>
                        </td>
                        <td colspan="2">
                          <br>
                        </td>
                    </tr>
                    <tr id="trTotalSinInteres">
                        <td align="right">
                            <h6>Total a pagar:1</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="totalSinInteres" name="prestamoNota"
                                       style="width: 160px; text-align: right" disabled value="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="totalSinInteresValue" name="totalSinInteres" value=""
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <h6>Efectivo:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idEfectivoNotaNuevo" name="prestamoNota"
                                       onkeypress="return cambioNuevo(event)"
                                       style="width: 160px; text-align: right" disabled placeholder="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="efectivoNuevoNota" name="Efectivo"
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <h6>Cambio:</label></h6>
                        </td>
                        <td align="right">
                            <h6><input type="text" id="idCambioNotaNuevo" name="prestamoNota"
                                       style="width: 160px; text-align: right" disabled placeholder="$0.00"/></h6>
                        </td>
                        <td colspan="2" class="propInvisible">
                            <input type="text" id="cambioNuevoNota" name="Cambio"
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" colspan="4">
                            <input type="button" class="btn btn-warning" value="Limpiar" id="btnLimpiar" disabled
                                   onclick="limpiarRefrendo()">&nbsp;
                            <input type="button" class="btn btn-primary" id="btnGenerar" value="Desempeño"
                                   onclick="validaDescuentoNuevo()">&nbsp;
                            <input type="button" class="btn btn-primary" id="btnGenerarSinInteres" value="Desempeño"
                                   onclick="MovimientosRefrendoSinInteres()">&nbsp;
                            <input type="button" class="btn btn-danger" value="Salir"
                                   onclick="location.href='vInicio.php'">&nbsp;
                        </td>
                    </tr>

                    <tr class="propInvisible">
                        <td>
                            <input type="text" id="idValidaToken" name="validaToken"
                                   style="width: 100px; text-align: right" value="0"/>
                        </td>
                        <td>
                            <input type="text" id="idToken" name="token" style="width: 100px; text-align: right"/>
                        </td>
                        <td>
                            <input type="text" id="descuentoAnteriorNuevoNota" name="DescuentoAnterior" value="0"
                                   style="width: 100px; text-align: right"/>
                        </td>
                        <td>
                            <input type="text" id="saldoPendienteNuevoNota" name="saldoPendiente" value="0.00"
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>
                    <tr class="propInvisible">

                        <td>
                            <input type="text" id="fechaVencimientoNuevoNota" name="fechaVencimiento" value="0"
                                   style="width: 100px; text-align: right"/>
                        </td>
                        <td>
                            <input type="text" id="fechaAlmNuevoNota" name="fechaAlm" value="0"
                                   style="width: 100px; text-align: right"/>
                        </td>
                        <td>
                            <input type="text" id="abonoAnteriorNuevoNota" name="AbonoAnterior" value="0"
                                   style="width: 100px; text-align: right"/>
                        </td>
                        <td>
                            <input type="text" id="tokenDescripcion" name="tokenDes" value=""
                                   style="width: 100px; text-align: right"/>
                        </td>
                    </tr>

                    <tr class="propInvisible">
                        <td>
                            <input type="text" id="idPrestamoSinInteres" name="PrestamoSinInteres" value=""
                                   style="width: 100px; text-align: right"/>
                        </td>
                        <td>
                            <input type="text" id="idFormulario" class="propInvisible" name="formulario"
                                   style="width: 100px;  "/>
                        </td>
                        <td>
                            <input type="text" id="idTipoDeContrato" class="propInvisible" name="tipoContrato"
                                   style="width: 100px;  "/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                </table>

            </div>
            <div class="col col-md-1 ">
            </div>
        </div>
    </div>
</form>

</body>
</html>
