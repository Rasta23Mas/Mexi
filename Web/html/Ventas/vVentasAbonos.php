<?php
if (!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION["idUsuario"])){
    header("Location: ../../../index.php");
    session_destroy();
}

$idCierreCaja = $_SESSION['idCierreCaja'];
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlUsuarioDAO.php");
include_once(HTML_PATH . "Clientes/modalRegistroCliente.php");
include_once(HTML_PATH . "Clientes/modalBusquedaCliente.php");
include_once(HTML_PATH . "Clientes/modalEditarCliente.php");
include_once (HTML_PATH. "Ventas/menuVentas.php")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Generales-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ventas</title>
    <!--Funciones-->
    <script src="../../JavaScript/funcionesCliente.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionesVentasAbono.js"></script>

    <!--    Script inicial-->
    <script type="application/javascript">
        $(document).ready(function () {
            $("#idFormEmpeno").trigger("reset");
            $("#btnEditar").prop('disabled', true);
            $("#btnAbono").prop('disabled', true);
            $("#idFechaHoy").val(fechaActual());
            $("#idNombreVenta").blur(function () {
                $('#suggestionsNombreVenta').fadeOut(500);
            });
            $("#divTablaAbono").load('tablaAbono.php');
            $("#divTablaApartado").load('tablaApartados.php');
            $("#idImporteAbono").prop('disabled', true);
            $("#idEfectivo").prop('disabled', true);
        })
    </script>
    <style type="text/css">
        #suggestionsNombreVenta {
            box-shadow: 2px 2px 8px 0 rgba(0, 0, 0, .2);
            height: auto;
            position: absolute;
            top: 65px;
            z-index: 9999;
            width: 300px;
        }

        #suggestionsNombreVenta .suggest-element {
            background-color: #EEEEEE;
            border-top: 1px solid #d6d4d4;
            cursor: pointer;
            padding: 8px;
            width: 100%;
            float: left;
        }

        .textArea {
            resize: none;
        }

        .headt td {
            height: 35px;
        }

        .inputCliente {
            text-transform: uppercase;
        }


        .propInvisible {
            visibility: hidden;
        }


    </style>
</head>
<body>
<form id="idFormAbonos" name="formVentas">
    <div id="contenedor" class="container">
        <div>
            <br>
            <br>
        </div>
        <div class="row">
            <div class="col col-lg-4 border border-primary"  >
                <table border="0" width="100%" >
                    <tbody>
                    <tr>
                        <td colspan="4">
                            <label>Nombre:</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div>
                                <input id="idNombreVenta" name="Nombres" type="text" style="width: 300px"
                                       class="inputCliente"
                                       onkeypress="nombreAutocompletarAbono()" placeholder="Buscar Cliente..."/>
                            </div>
                            <div id="suggestionsNombreVenta"></div>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <label>Fecha:</label>
                        </td>
                        <td >
                            <label>Folio:</label>
                        </td>
                    </tr>
                    <tr >
                        <td align="left">
                            <input type="text" name="fechaH" id="idFechaHoy"
                                   style="width: 100px;text-align: right "disabled/>
                        </td>
                        <td>
                            <input id="idFolioBazar" name="folio" type="text" style="width: 130px" value="" disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 25%"><br></td>
                        <td style="width: 25%"><br></td>
                        <td style="width: 25%"><br></td>
                        <td style="width: 25%"><br></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col col-lg-1"  >
            </div>
            <div class="col col-lg-7 border border-primary"  >
                <div id="divTablaAbono" class="col col-lg-11 " >
                </div>
            </div>
        </div>
        <div class="row">
            <div  class="col col-lg-12 " >
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col col-lg-4 border border-primary"  >
                <table border="0" width="100%" >
                    <tbody>
                    <tr>
                        <td style="width: 40%"><br></td>
                        <td colspan="2"><br></td>
                    </tr>
                    <tr>
                        <td>
                            <label>Total Apartado:</label>
                        </td>
                        <td colspan="2">
                            <input id="idTotalApartado" name="totalApartado" type="text" style="width: 130px; text-align: right" disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Abonado:</label>
                        </td>
                        <td colspan="2">
                            <input id="idTotalAbonado" name="totalAbonado" type="text" style="width: 130px; text-align: right" disabled
                                   />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><br></td>
                    </tr>
                    <tr>
                        <td>
                            <label>Ultimo Saldo:</label>
                        </td>
                        <td colspan="2">
                            <input id="idUltimoSaldo" name="ultimoSaldo" type="text" style="width: 130px; text-align: right" disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Fecha Abono:</label>
                        </td>
                        <td colspan="2">
                            <input id="fechaAbono" name="fechaA" type="text" style="width: 130px; text-align: right" disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><br></td>
                    </tr>
                    <tr>
                        <td>
                            <label>Importe Abono:</label>
                        </td>
                        <td colspan="2">
                            <input id="idImporteAbono" name="importeAbono" type="text"
                                   onkeypress="return nuevoAbono(event)"
                                   style="width: 130px; text-align: right" value=""/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Nuevo Saldo:</label>
                        </td>
                        <td colspan="2">
                            <input id="idNuevoSaldo" name="nuevoSaldo" type="text" style="width: 130px; text-align: right" value="" disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><br></td>
                    </tr>
                    <tr>
                        <td>
                            <label><b>Total a Pagar:<b></label>
                        </td>
                        <td colspan="2">
                            <input id="idTotalPagar" name="totalPagar" type="text" style="width: 130px; text-align: right" disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><br><hr color="blue" size=3> </td>
                    </tr>
                    <tr >
                        <td >
                            <label for="subtotal">Efectivo:</label>
                        </td>
                        <td style="vertical-align:top;">
                            <input type="text" name="efectivo"  id="idEfectivo"
                                   style="width: 130px; text-align: right"
                                   placeholder="$0.00"
                                   onkeypress="return efectivoAbono(event)"/>
                        </td>
                    </tr>
                    <tr >
                        <td >
                            <label for="subtotal">Cambio:</label>
                        </td>
                        <td style="vertical-align:top;">
                            <input type="text" name="cambio"  id="idCambio" placeholder="$0.00"
                                   style="width: 130px; text-align: right" disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><br></td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="col col-lg-1"  >
            </div>
            <div class="col col-lg-7 border border-primary"  >
                <div id="divTablaApartado" class="col col-lg-12 ">
                </div>
            </div>
        </div>
        <div class="row">
            <div  class="col col-lg-12 " >
                <br>
            </div>
        </div>
        <div class="row propInvisible"  >
            <div class="col col-lg-12"  >
                <input type="text" name="apartadoValue"  id="idTotalApartadoValue"
                       style="width: 120px "disabled/>
                <input type="text" name="iva"  id="idTotalAbonadoValue"
                       style="width: 120px "disabled/>
                <input type="text" name="total"  id="idUltimoSaldoValue"
                       style="width: 120px "disabled/>
                <input type="text" name="abono"  id="idImporteAbonoValue" value="0"
                       style="width: 120px "disabled/>
                <input type="text" name="total"  id="idNuevoSaldoValue"
                       style="width: 120px "disabled/>
                <input type="text" name="efectivo"  id="idEfectivoValue" value="0"
                       style="width: 120px "disabled/>
                <input type="text" name="cambio"  id="idCambioValue"
                       style="width: 120px "disabled/>
                <input type="text" name="cambio"  id="idPrestamo"
                       style="width: 120px "disabled/>
            </div>
        </div>
        <div class="row">
            <div class="col col-lg-9"  >
                <br>
            </div>
            <div class="col col-lg-3"  >
                <input type="button" class="btn btn-warning" value="Limpiar" onclick="cancelarVentaAbono()">&nbsp;&nbsp;
                <input type="button" class="btn btn-success" value="Abono" id="btnAbono" onclick="guardarAbono()">&nbsp;&nbsp;
                <input type="button" class="btn btn-danger" value="Salir" onclick="location.href='vInicio.php'">
            </div>
        </div>
    </div>
    </div>
    </div>
</form>

</body>
</html>
