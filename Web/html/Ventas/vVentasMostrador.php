<?php
if (!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION["idUsuario"])){
    header("Location: ../../../index.php");
    session_destroy();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlUsuarioDAO.php");
include_once(HTML_PATH . "Clientes/modalRegistroCliente.php");
include_once(HTML_PATH . "Clientes/modalBusquedaCliente.php");
include_once(HTML_PATH . "Clientes/modalEditarCliente.php");
include_once(HTML_PATH . "Ventas/modalDescuentoVenta.php");
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
<!--    <script src="../../JavaScript/funcionesArticulos.js"></script>
    <script src="../../JavaScript/funcionesIntereses.js"></script>-->
    <script src="../../JavaScript/funcionesCliente.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionesVentas.js"></script>

    <!--    Script inicial-->
    <script type="application/javascript">
        $(document).ready(function () {
            $("#idFormEmpeno").trigger("reset");
            $("#btnEditar").prop('disabled', true);
            $("#btnVenta").prop('disabled', true);
            document.getElementById('idFechaHoy').innerHTML =fechaActual();
            $("#divTablaMetales").load('tablaMetales.php');
            $("#divTablaArticulos").load('tablaArticulos.php');
            $("#divTablaArticulos").hide();
            $("#idNombreVenta").blur(function () {
                $('#suggestionsNombreVenta').fadeOut(500);
            });
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
             visibility: visible;
         }


    </style>
</head>
<body>
<form id="idFormVentas" name="formVentas">
    <div id="contenedor" class="container">
        <div>
            <br>
            <br>
        </div>
        <div class="row">
            <div class="col col-lg-11 border border-primary"  >
                <table border="0" width="90%" >
                    <tbody>
                    <tr class="headt">
                        <td colspan="4">
                            <label>Fecha:</label>
                            <label id="idFechaHoy"></label>
                        </td>
                        <td colspan="6">
                            <input type="button" class="btn btn-success "
                                   data-toggle="modal" data-target="#modalRegistroNuevo"
                                   value="Agregar">
                            <input type="button" class="btn btn-warning "
                                   data-toggle="modal" data-target="#modalEditarNuevo" id="btnEditar"
                                   value="Editar" onclick="modalEditarCliente($('#idClienteEmpeno').val())" disabled>
                            <input type="button" class="btn btn-primary "
                                   data-toggle="modal" data-target="#modalBusquedaCliente"
                                   onclick="mostrarTodos($('#idNombres').val())"
                                   value="Ver todos">

                        </td>
                        <td colspan="2">
                            <input type="text" id="idClienteEmpeno" name="clienteEmpeno" size="20"  class="invisible"/>
                        </td>
                    </tr>
                    <tr >
                        <td colspan="2">
                            <label for="nombreCliente">Nombre:</label>
                        </td>
                        <td colspan="2">
                            <label for="celular">Celular:</label>
                        </td>
                        <td colspan="8">
                            <label for="direccion">Dirección:</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:top;">
                            <div>
                                <input id="idNombreVenta" name="Nombres" type="text" style="width: 300px"
                                       class="inputCliente"
                                       onkeypress="nombreAutocompletarVenta()" placeholder="Buscar Cliente..."/>
                            </div>
                            <div id="suggestionsNombreVenta"></div>
                        </td>
                        <td colspan="2" style="vertical-align:top;">
                            <input type="text" name="celularEmpeno" placeholder="" id="idCelularVenta"
                                   style="width: 120px "
                                   required disabled/>
                        </td>
                        <td colspan="8" name="direccionEmpeno">
                                    <textarea  cols="70" id="idDireccionVenta" class="textArea" disabled>
                                    </textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <br>
                        </td>
                    </tr>

                    <tr >
                        <td colspan="4">
                            <input id="idCodigoMostrador" name="codigo" type="text" style="width: 130px" value="010001140"/>
                            &nbsp;&nbsp;
                            <input type="button" class="btn btn-primary" value="Buscar" id="btnBuscarCodigo" onclick="busquedaCodigoMostrador()">&nbsp;
                        </td>
                        <td colspan="8">
                            <label for="direccion">Vendedor:</label>
                            <select id="idVendedor" name="cmbVendedor" class="selectpicker" style="width: 200px">
                                <option value="0">Seleccione:</option>
                                <?php
                                $data = array();
                                $sqlUsu = new sqlUsuarioDAO();
                                $data = $sqlUsu->vendedores();
                                for ($i = 0; $i < count($data); $i++) {
                                    echo "<option value=" . $data[$i]['id_User'] . ">" . $data[$i]['NombreUser'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
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
            <div  class="col col-lg-12 " >
                <br>
            </div>
        </div>
        <div class="row">
            <div id="divTablaMetales" class="col col-lg-11 " >
            </div>
            <div id="divTablaArticulos" class="col col-lg-11 ">
            </div>
        </div>
        <div class="row">
            <div class="col col-lg-1 ">
                <br>
            </div>
            <div class="col col-lg-1 ">
                <br>
            </div>
            <div class="col col-lg-1 ">
                <br>
            </div>
            <div class="col col-lg-1 ">
                <br>
            </div>
            <div class="col col-lg-1 ">
                <br>
            </div>
            <div class="col col-lg-1 ">
                <br>
            </div>
            <div class="col col-lg-1 ">
                <br>
            </div>
            <div class="col col-lg-1 ">
                <br>
            </div>
            <div class="col col-lg-4" >
                <table border="0" width="90%" >
                    <tbody>
                    <tr >
                        <td >
                            <label for="subtotal">SubTotal:</label>
                        </td>
                        <td >
                            <input type="text" name="subtotal"  id="idSubTotal"
                                   style="width: 120px; text-align: right "disabled/>
                        </td>
                    </tr>
                    <tr >
                        <td >
                            <label for="subtotal">IVA:</label>
                        </td>
                        <td style="vertical-align:top;">
                            <input type="text" name="iva"  id="idIva"
                                   style="width: 120px; text-align: right "disabled/>
                        </td>
                    </tr>
                    <tr >
                        <td >
                            <label for="subtotal">Descuento:</label>
                        </td>
                        <td style="vertical-align:top;">
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
                        <td  style="vertical-align:top;">
                            <input type="text" name="totalPagar"  id="idTotalPagar"
                                   style="width: 120px;text-align: right "disabled/>
                        </td>
                    </tr>
                    <tr >
                        <td >
                            <label for="subtotal">Efectivo:</label>
                        </td>
                        <td style="vertical-align:top;">
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
                        <td style="vertical-align:top;">
                            <input type="text" name="cambio"  id="idCambio" placeholder="$0.00"
                                   style="width: 120px; text-align: right "  disabled/>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col col-lg-12" >
                <br>
                <input type="text" name="subtotal"  id="idSubTotalValue" class="propInvisible"
                       style="width: 120px "disabled/>
                <input type="text" name="iva"  id="idIvaValue" class="propInvisible"
                       style="width: 120px "disabled/>
                <input type="text" name="total"  id="idTotalBase" class="propInvisible"
                       style="width: 120px "disabled/>
                <input type="text" name="total"  id="idTotalValue" class="propInvisible"
                       style="width: 120px "disabled/>
                <input type="text" name="descuento"  id="idDescuentoValue" class="propInvisible" value="0"
                       style="width: 120px "disabled/>
                <input type="text" name="estatus"  id="idEstatus" class="propInvisible"
                       style="width: 120px "disabled/>
                <input type="text" name="efectivo"  id="idEfectivoValue" class="propInvisible"
                       style="width: 120px "disabled/>
                <input type="text" name="cambio"  id="idCambioValue" class="propInvisible"
                       style="width: 120px "disabled/>
                <input type="text" name="tokenDesc"  id="tokenDescripcion" class="propInvisible"
                       style="width: 120px "disabled/>
                <input type="text" name="idtoken"  id="idToken" class="propInvisible"
                       style="width: 120px "disabled/>
                <input type="text" name="cliente"  id="idClienteVenta" class="propInvisible" value="0"
                       style="width: 120px "disabled/>
                <input type="text" name="vendedor"  id="vendedor" class="propInvisible"
                       style="width: 120px "disabled/>
            </div>
        </div>
        <div class="row">

            <div class="col col-lg-7">
                <br>
            </div>
            <div class="col col-lg-5 lef" >
                <input type="button" class="btn btn-warning" value="Limpiar" onclick="cancelarVenta()">&nbsp;
                <input type="button" class="btn btn-success" value="Venta" id="btnVenta" onclick="validaVenta()">&nbsp;
                <input type="button" class="btn btn-primary" value="Reimprimir" onclick="reimprimir()">&nbsp;
                <input type="button" class="btn btn-danger" value="Salir" onclick="location.href='vInicio.php'">&nbsp;
            </div>
        </div>
    </div>
    </div>
    </div>
</form>

</body>
</html>
