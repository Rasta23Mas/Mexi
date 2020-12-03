<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Security.php');
$idCierreCaja = $_SESSION['idCierreCaja'];
include_once(SQL_PATH . "sqlUsuarioDAO.php");
include_once(VENT_PATH . "modalRegCliVen.php");
include_once(VENT_PATH . "modalBusClienteVen.php");
include_once(VENT_PATH . "modalEditCliVen.php");
include_once(VENT_PATH . "modalPrecioVenta.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Menu.php');
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
    <script src="../../JavaScript/funcionesVentasApartados.js"></script>

    <!--    Script inicial-->
    <script type="application/javascript">
        $(document).ready(function () {
            $("#idFormApartados").trigger("reset");
            $("#btnEditar").prop('disabled', true);
            $("#btnVenta").prop('disabled', true);
            document.getElementById('idFechaHoy').innerHTML = fechaActual();
            var sumarMes = sumarDias(30);
            document.getElementById('idFechaVen').innerHTML = sumarMes;
            $("#divTablaMetales").load('tablaMetales.php');
            $("#divTblArticulosCompra").load('tablaArticulosCompra.php');
            $("#idNombreVenta").blur(function () {
                $('#suggestionsNombreVenta').fadeOut(500);
            });
            limpiarCarritoApartado();
            buscaridBazarApartado();
        })
    </script>
    <style type="text/css">
        #suggestionsNombreVenta {
            box-shadow: 2px 2px 8px 0 rgba(0, 0, 0, .2);
            height: auto;
            position: absolute;
            top: 110px;
            z-index: 9999;
            width: 350px;
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
<form id="idFormApartados" name="formVentas">
    <div id="contenedor" class="container">
        <div>
            <br>
            <br>
        </div>
        <div class="row">
            <div class="col col-md-12 border border-primary">
                <table border="0" width="100%">
                    <tbody>
                    <tr class="headt">
                        <td colspan="5" align="left">
                            <input type="button" class="btn btn-success "
                                   data-toggle="modal" data-target="#modalRegistroNuevo"
                                   value="Agregar">
                            <input type="button" class="btn btn-warning "
                                   data-toggle="modal" data-target="#modalEditarNuevo" id="btnEditar"
                                   value="Editar" onclick="modalEditarCliente($('#idClienteSeleccion').val())" disabled>
                            <input type="button" class="btn btn-primary "
                                   data-toggle="modal" data-target="#modalBusquedaCliente"
                                   onclick="mostrarTodos($('#idNombres').val())"
                                   value="Ver todos">
                            <!--                            <input type="button" class="btn btn-warning" value="Configurarar Rangos" onclick="configurarRango()">&nbsp;
                            -->                        </td>
                        <td align="right" colspan="3">
                            <label>Fecha:</label>
                            <label id="idFechaHoy"></label>&nbsp;
                            <label> Vencimiento:</label>
                            <label id="idFechaVen"></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <label>Nombre:</label>
                        </td>
                        <td>
                            <label>Celular:</label>
                        </td>
                        <td colspan="3">
                            <label>Dirección:</label>
                        </td>
                        <td>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="vertical-align:top;">
                            <div>
                                <input id="idNombreVenta" name="Nombres" type="text" style="width: 300px"
                                       class="inputCliente"
                                       onkeypress="nombreAutocompletarVenta()" placeholder="Buscar Cliente..."/>
                            </div>
                            <div id="suggestionsNombreVenta"></div>
                        </td>
                        <td align="center" style="vertical-align:top;">
                            <input type="text" name="celularEmpeno" placeholder="" id="idCelularVenta"
                                   style="width: 100px;text-align: right "
                                   disabled/>
                        </td>
                        <td colspan="3" name="direccionEmpeno">
                                    <textarea cols="30" id="idDireccionVenta" class="textArea" disabled>
                                    </textarea>
                        </td>
                        <td>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <input id="idCodigoApartado" name="codigo" type="text" style="width: 130px" value=""
                                   onkeypress="return busquedaCodigoApartado(event)"/>
                            &nbsp;&nbsp;
                            <input type="button" class="btn btn-primary" value="Buscar" id="btnBuscarCodigo" onclick="fnLlenaReportApartado()">&nbsp;

                        </td>
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <br>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12 ">
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-9">
                <div id="divTblArticulosCompra">
                </div>
            </div>
            <div class="col col-md-3">
                <table border="0" width="100%">
                    <tbody>
                    <tr >
                        <td >
                            <label for="subtotal">Total Prestamo:</label>
                        </td>
                        <td align="right">
                            <input type="text" name="subtotal"  id="idPrestamoTot"
                                   style="width: 120px; text-align: right "disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>SubTotal:</label>
                        </td>
                        <td align="right">
                            <input type="text" name="subtotal" id="idSubTotal"
                                   style="width: 120px; text-align: right " disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>IVA:</label>
                        </td>
                        <td align="right">
                            <input type="text" name="iva" id="idIva"
                                   style="width: 120px; text-align: right " disabled/>
                        </td>
                    </tr>
                    <tr >
                        <td >
                            <label >Total a Pagar:</label>
                        </td>
                        <td  style="vertical-align:top;" align="right">
                            <input type="text" name="totalPagar"  id="idTotalPagar"
                                   style="width: 120px;text-align: right "disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Apartado inicial:</label>
                        </td>
                        <td align="right">
                            <input type="text" name="abono" id="idApartadoInicial"
                                   style="width: 120px; text-align: right "
                                   placeholder="$0.00" onkeypress="return apartadoInicial(event)"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Falta por Pagar:</label>
                        </td>
                        <td align="right">
                            <input type="text" name="faltaPagarName" id="idfaltaPagar"
                                   style="width: 120px;text-align: right " disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Efectivo:</label>
                        </td>
                        <td align="right">
                            <input type="text" name="efectivo" id="idEfectivo"
                                   style="width: 120px; text-align: right "
                                   placeholder="$0.00"
                                   onkeypress="return efectivoVenta(event)"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Cambio:</label>
                        </td>
                        <td align="right">
                            <input type="text" name="cambio" id="idCambio" placeholder="$0.00"
                                   style="width: 120px; text-align: right " disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <input type="button" class="btn btn-warning" value="Limpiar" onclick="cancelarApartado()">&nbsp;&nbsp;
                            <input type="button" class="btn btn-success" value="Apartado" id="btnVenta"
                                   onclick="validaApartado()">&nbsp;&nbsp;
                            <input type="button" class="btn btn-danger" value="Salir"
                                   onclick="location.href='vInicio.php'">

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12 ">
                <br>
            </div>
        </div>
        <div class="row">
            <div id="divTablaMetales" class="col col-md-12 ">
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12">
                <br>
                <input type="text" name="subtotal" id="idSubTotalValue"
                       style="width: 120px " class="propInvisible" disabled/>
                <input type="text" name="subtotal"  id="idPrestamoTotValue"
                       style="width: 120px " class="propInvisible" disabled/>
                <input type="text" name="iva" id="idIvaValue"
                       style="width: 120px " class="propInvisible" disabled/>
                <input type="text" name="total" id="idTotalBase"
                       style="width: 120px " class="propInvisible" disabled/>
                <input type="text" name="total" id="idApartadoInicialValue" value="0"
                       style="width: 120px " class="propInvisible" disabled/>
                <input type="text" name="total" id="idTotalValue"
                       style="width: 120px " class="propInvisible" disabled/>
                <input type="text" name="total" id="faltaPagarValue" value="0"
                       style="width: 120px " class="propInvisible" disabled/>
                <input type="text" name="efectivo" id="idEfectivoValue"
                       style="width: 120px " class="propInvisible" disabled/>
                <input type="text" name="cambio" id="idCambioValue"
                       style="width: 120px " class="propInvisible" disabled/>
                <input type="text" name="cliente" id="idClienteSeleccion" value="0"
                       style="width: 120px " class="propInvisible" disabled/>
                <input type="text" name="bazar" id="idBazar" value="0"
                       style="width: 120px " class="propInvisible" disabled/>
            </div>
        </div>
    </div>
</form>

</body>
</html>
