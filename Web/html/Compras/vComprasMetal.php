<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

include_once(HTML_PATH . "Compras/modalRegistroVendedor.php");
include_once(HTML_PATH . "Compras/modalEditarVendedor.php");
include_once(HTML_PATH . "Compras/modalBusquedaVendedor.php");
include_once(DESC_PATH . "modalDescuentoToken.php");

$sucursal = $_SESSION['sucursal'];
$tipoUsuario = $_SESSION['tipoUsuario'];
if ($tipoUsuario == 2) {
    include_once(HTML_PATH . "menuAdmin.php");
} elseif ($tipoUsuario == 3) {
    include_once(HTML_PATH . "menuGeneral.php");
} elseif ($tipoUsuario == 4) {
    include_once(HTML_PATH . "menuVendedor.php");
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Generales-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Empeño</title>
    <!--Funciones-->
    <script src="../../JavaScript/funcionesCompras.js"></script>
    <script src="../../JavaScript/funcionesIntereses.js"></script>
    <script src="../../JavaScript/funcionesVendedor.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionesMovimiento.js"></script>
    <script src="../../JavaScript/funcionNumerosLetras.js"></script>
    <!--    Script inicial-->
    <script type="application/javascript">
        $(document).ready(function () {
            $("#idFormEmpeno").trigger("reset");
            $("#divTablaMetales").load('tablaMetalesCompras.php');
            $("#btnEditar").prop('disabled', true);
            llenarComboInteres(1);
            $("#idNombres").blur(function () {
                $('#suggestionsNombreEmpeno').fadeOut(500);
            });
            selectPrenda();
            llenarAforoCompras(1);
            articulosObsoletosCom();
            buscaridBazarCompras();
        })
    </script>
    <style type="text/css">
        #suggestionsNombreEmpeno {
            box-shadow: 2px 2px 8px 0 rgba(0, 0, 0, .2);
            height: auto;
            position: absolute;
            top: 105px;
            z-index: 9999;
            width: 300px;
        }

        #suggestionsNombreEmpeno .suggest-element {
            background-color: #EEEEEE;
            border-top: 1px solid #d6d4d4;
            cursor: pointer;
            padding: 7px;
            width: 100%;
            float: left;
        }

        .textArea {
            resize: none;
            text-align: left;
            text-transform: uppercase;

        }

        .headt td {
            height: 35px;
        }

        .inputCliente {
            text-transform: uppercase;
        }


    </style>
</head>
<body>
<form id="idFormEmpeno" name="formEmpeno">
    <div id="contenedor" class="container">
        <div>
            <br>
        </div>
        <div class="row">
            <div class="col col-md-4">
                <table border="0" width="100%" class="tableInteres">
                    <tbody>
                    <tr class="headt">
                        <td>
                            <input type="button" class="btn btn-success "
                                   data-toggle="modal" data-target="#modalRegistroVenNuevo"
                                   value="Agregar">
                            <input type="button" class="btn btn-warning "
                                   data-toggle="modal" data-target="#modalEditarVendedor" id="btnEditar"
                                   value="Editar" onclick="modalEditarVendedor($('#idVendedor').val())" disabled>
                            <input type="button" class="btn btn-info "
                                   data-toggle="modal" data-target="#modalBusquedaCliente"
                                   onclick="mostrarTodos($('#idNombresVendedor').val())"
                                   value="Ver todos">
                        </td>
                    </tr>
                    <tr class="headt">
                        <td>
                            <label for="nombreCliente">Nombre:</label>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <div>
                                <input id="idNombresVendedor" name="Nombres" type="text" style="width: 300px"
                                       class="inputCliente" onkeypress="nombreVenAutocompletar()"
                                       placeholder="Buscar Cliente..."/>
                            </div>
                            <div id="suggestionsNombreEmpeno"></div>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td >
                            <label for="celular">Celular:</label>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td >
                            <input type="text" name="celularVendedor" placeholder="" id="idCelularVendedor"
                                   style="width: 120px"
                                   required disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <label for="direccion">Dirección:</label>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td  rowspan="2" name="direccionEmpeno">
                                    <textarea rows="2" cols="40" id="idDireccionVendedor" class="textArea" disabled>
                                    </textarea>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col col-md-5">
                <table width="90%" class="border-primary border">
                    <tr style="background: dodgerblue; color:white;">
                        <td colspan="4" align="center">Compra Metales</td>
                    </tr>
                    <tr class="headt">
                        <td >Tipo:</td>
                        <td >
                            <select id="idTipoMetal" name="cmbTipoMetal" class="selectpicker"
                                    onchange="selectMetalCmb($('#idTipoMetal').val())"
                                    style="width: 150px">
                            </select>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td>Kilataje:</td>
                        <td >
                            <select id="idKilataje" name="cmbKilataje" class="selectpicker"
                                    style="width: 150px" onchange="llenaPrecioKilataje()">
                            </select>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td >Calidad:</td>
                        <td >
                            <select id="idCalidad" name="cmbCalidad" class="selectpicker"
                                    style="width: 150px">
                            </select>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td >Cantidad:
                            <input type="text" id="idCantidad" name="cantidad" size="5"
                                   onkeypress="return soloNumeros(event)" placeholder="0"
                                   style="text-align:center"/>
                        </td>
                        <td>Peso:
                            <input type="text" id="idPeso" name="peso" size="4"
                                   onkeypress="return isNumberDecimal(event)" placeholder="0"
                                   style="text-align:center"/>
                            <label>grs</label></td>
                    </tr>
                    <tr>
                        <td >Piedras:
                            <input type="text" id="idPiedras" name="piedras" size="5"
                                   onkeypress="return soloNumeros(event)" value="0"
                                   style="text-align:center"/>
                            <label>pza</label>
                        </td>
                        <td >Peso:
                            <input type="text" id="idPesoPiedra" name="pesoPiedra" size="4" value="0"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="text-align:center"/>
                            <label>grs</label></td>
                    </tr>
                    <tr class="headt">
                        <td>Préstamo:</td>
                        <td>
                            <input type="text" id="idPrestamo" name="prestamo" size="8"
                                   onkeypress="return calculaPrestamoPeso(event)" ;
                                   style="text-align:center"/>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td>Avalúo:</td>
                        <td>
                            <input type="text" id="idAvaluo" name="avaluo" size="8"
                                   disabled
                                   style="text-align:center"/>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td>Vitrina:</td>
                        <td>
                            <input type="text" id="idVitrina" name="vitrina" size="8"
                                   onkeypress="return soloNumeros(event)"
                                   style="text-align:center"/>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td>
                            <input type="button" class="btn btn-info" value="Calcular" onclick="calculaPrestamoBtn()">
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class="headt">
                        <td colspan="2" align="left">Descripción de la prenda:
                        </td>
                    </tr>
                    <tr class="headt">
                        <td colspan="2">Observaciones de la tienda:
                            <input type="text" id="idKilatajePrecio" name="kilatajePrecio" size="6"
                                   value="0"
                                   class="invisible" disabled/></td>
                    </tr>
                    <tr class="headt">
                        <td colspan="2" name="detallePrenda">
                            <p>
                            <textarea name="detalle" id="idDetallePrenda"
                               class="textArea" rows="1" cols="40"></textarea></p>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td colspan="2">
                            <p><textarea name="mensaje" id="idObs"
                               class="textArea" rows="1" cols="40"></textarea></p>
                        </td>
                    </tr>
                    <tr >
                        <td align="right" colspan="4">
                            <input type="button" class="btn btn-warning" value="Limpiar" onclick="Limpiar()">
                            <input type="button" class="btn btn-success" value="Agregar a la lista" onclick="AgregarArtCompra()">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col col-md-3" >
                <table border="0" width="100%" >
                    <tbody>
                    <tr >
                        <td >
                            <label for="subtotal">SubTotal:</label>
                        </td>
                        <td align="right">
                            <input type="text" name="subtotal"  id="idSubTotal"
                                   style="width: 120px; text-align: right "disabled/>
                        </td>
                    </tr>
                    <tr >
                        <td >
                            <label for="subtotal">IVA:</label>
                        </td>
                        <td style="vertical-align:top;" align="right">
                            <input type="text" name="iva"  id="idIva"
                                   style="width: 120px; text-align: right "disabled/>
                        </td>
                    </tr>
                    <tr >
                        <td >
                            <label for="subtotal">Descuento:</label>
                        </td>
                        <td style="vertical-align:top;" align="right">
                            <input type="text" name="descuento"  id="idDescuento"
                                   style="width: 120px; text-align: right "
                                   placeholder="$0.00"
                                   onkeypress="return descuentoVenta(event)"/>

                        </td>
                    </tr>
                    <tr >
                        <td >
                            <label for="subtotal">Total a Pagar:</label>
                        </td>
                        <td  style="vertical-align:top;" align="right">
                            <input type="text" name="totalPagar"  id="idTotalPagar"
                                   style="width: 120px;text-align: right "disabled/>
                        </td>
                    </tr>
                    <tr >
                        <td >
                            <label for="subtotal">Efectivo:</label>
                        </td>
                        <td style="vertical-align:top;" align="right">
                            <input type="text" name="efectivo"  id="idEfectivo"
                                   style="width: 120px; text-align: right "
                                   placeholder="$0.00"
                                   onkeypress="return efectivoVenta(event)"/>
                        </td>
                    </tr>
                    <tr >
                        <td >
                            <label for="subtotal">Cambio:</label>
                        </td>
                        <td style="vertical-align:top;" align="right">
                            <input type="text" name="cambio"  id="idCambio" placeholder="$0.00"
                                   style="width: 120px; text-align: right "  disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <input type="button" class="btn btn-warning" value="Limpiar" onclick="cancelarVenta()">&nbsp;
                            <input type="button" class="btn btn-success" value="Venta" id="btnVenta" onclick="validaVenta()">&nbsp;
                            <input type="button" class="btn btn-danger" value="Salir" onclick="location.href='vInicio.php'">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12">
                <br>
            </div>
        </div>
        <div class="row">
            <div id="divTablaMetales" class="col col-md-12 border border-primary">
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12">
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12">
                <table border="0" width="100%">
                    <tr>
                        <td align="right">
                            <input type="button" class="btn btn-primary" value="Comprar" onclick="validarMonto()">&nbsp;
                            <input type="button" class="btn btn-danger" value="Salir"
                                   onclick="location.href='vInicio.php'">&nbsp;
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12">
                <table>
                    <tr>
                        <td colspan="12">
                            <input type="text" id="idVendedor" name="clienteEmpeno" size="5"
                                   style="text-align:center" class="invisible"/>
                            <input id="idToken" name="token" disabled type="text" value="0"
                                   style="width: 150px; text-align: right" class="invisible"/>
                            <input id="tokenDescripcion" name="tokenDescripcion" disabled type="text" value="0"
                                   style="width: 150px; text-align: right" class="invisible"/>
                            <input id="idAforo" name="aforo" disabled type="text" value="0"
                                   style="width: 150px; text-align: right" class="invisible"/>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>

</body>
</html>
