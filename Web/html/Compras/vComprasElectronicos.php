<?php
if (!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION["idUsuario"])){
    header("Location: ../../../index.php");
    session_destroy();
}

$sucursal = $_SESSION['sucursal'];
$tipoUsuario = $_SESSION['tipoUsuario'];

if ($tipoUsuario == 2) {
    include_once(HTML_PATH . "menuAdmin.php");
} elseif ($tipoUsuario == 3) {
    include_once(HTML_PATH . "menuGeneral.php");
} elseif ($tipoUsuario == 4) {
    include_once(HTML_PATH . "menuVendedor.php");
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlClienteDAO.php");
include_once(SQL_PATH . "sqlInteresesDAO.php");
include_once(SQL_PATH . "sqlArticulosDAO.php");
include_once(SQL_PATH . "sqlContratoDAO.php");
include_once(HTML_PATH . "Clientes/modalRegistroCliente.php");
include_once(HTML_PATH . "Clientes/modalHistorial.php");
include_once(HTML_PATH . "Clientes/modalBusquedaCliente.php");
include_once(HTML_PATH . "Clientes/modalEditarCliente.php");
include_once(HTML_PATH . "Empeno/modalArticulos.php");
include_once(HTML_PATH . "Empeno/modalAgregarArticulos.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Generales-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Empeño</title>
    <!--Funciones-->
    <script src="../../JavaScript/funcionesArticulos.js"></script>
    <script src="../../JavaScript/funcionesIntereses.js"></script>
    <script src="../../JavaScript/funcionesCliente.js"></script>
    <script src="../../JavaScript/funcionesContrato.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionesMovimiento.js"></script>
    <script src="../../JavaScript/funcionNumerosLetras.js"></script>
    <!--    Script inicial-->
    <script type="application/javascript">
        $(document).ready(function () {
            // $('.menuContainer').load('menu.php');
            articulosObsoletos();
            $("#divElectronicos").hide();
            $("#divMetales").show();
            $("#idFormEmpeno").trigger("reset");
            $("#divTablaMetales").load('tablaMetales.php');
            $("#divTablaArticulos").load('tablaArticulos.php');
            $("#divTablaArticulos").hide();
            $("#btnEditar").prop('disabled', true);
            llenarComboInteres(1);
            $("#idNombres").blur(function () {
                $('#suggestionsNombreEmpeno').fadeOut(500);
            });
            selectPrenda();
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
            <div class="col col-lg-4 border border-primary border-left-0">
                <table width="100%" >
                    <tr>
                        <td align="center">
                            <input type="button" class="btn btn-primary" value="Metales"
                                   onclick="Metales();">
                        </td>
                        <td align="center">
                            <input type="button" class="btn btn-primary" value="Electrónicos/Varios"
                                   onclick="Electronicos();">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="divMetales">
                                <table  width="100%">
                                    <tbody class="text-body border" align="left">
                                    <tr>
                                        <td colspan="3">Tipo:</td>
                                        <td colspan="9">
                                            <select id="idTipoMetal" name="cmbTipoMetal" class="selectpicker"
                                                    onchange="selectMetalCmb($('#idTipoMetal').val())"
                                                    style="width: 150px">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Kilataje:</td>
                                        <td colspan="9">
                                            <select id="idKilataje" name="cmbKilataje" class="selectpicker"
                                                    style="width: 150px" onchange="llenaPrecioKilataje()">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" >Calidad:</td>
                                        <td colspan="9">
                                            <select id="idCalidad" name="cmbCalidad" class="selectpicker"
                                                    style="width: 150px">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Cantidad:</td>
                                        <td colspan="3">
                                            <input type="text" id="idCantidad" name="cantidad" size="5"
                                                   onkeypress="return soloNumeros(event)"  placeholder="0"
                                                   style="text-align:center"/>
                                        </td>
                                        <td colspan="3">Peso:</td>
                                        <td colspan="3">
                                            <input type="text" id="idPeso" name="peso" size="4"
                                                   onkeypress="return isNumberDecimal(event)" placeholder="0"
                                                   style="text-align:center"/>
                                            <label>grs</label></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Piedras:</td>
                                        <td colspan="3">
                                            <input type="text" id="idPiedras" name="piedras" size="5"
                                                   onkeypress="return soloNumeros(event)" value="0"
                                                   style="text-align:center"/>
                                            <label>pza</label>
                                        </td>
                                        <td colspan="3">Peso:</td>
                                        <td colspan="3">
                                            <input type="text" id="idPesoPiedra" name="pesoPiedra" size="4" value="0"
                                                   onkeypress="return isNumberDecimal(event)"
                                                   style="text-align:center"/>
                                            <label>grs</label></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Préstamo:</td>
                                        <td colspan="3">
                                            <input type="text" id="idPrestamo" name="prestamo" size="8"
                                                   onkeypress="return calculaPrestamoPeso(event)";
                                                   style="text-align:center"/>
                                        </td>
                                        <td colspan="3">Avalúo:</td>
                                        <td colspan="3">
                                            <input type="text" id="idAvaluo" name="avaluo" size="8"
                                                    disabled
                                                   style="text-align:center" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Vitrina:</td>
                                        <td colspan="3">
                                            <input type="text" id="idVitrina" name="vitrina" size="8"
                                                   onkeypress="return soloNumeros(event)"
                                                   style="text-align:center"/>
                                        </td>
                                        <td colspan="6" >
                                            <input type="button" class="btn btn-info" value="Calcular" onclick="calculaPrestamoBtn()">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" align="left">Descripción de la prenda:
                                        </td>
                                    <tr>
                                        <td colspan="12" name="detallePrenda">
                                            <p>
                                              <textarea name="detalle" id="idDetallePrenda"
                                                        class="textArea" rows="1" cols="40"></textarea></p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="12">Observaciones de la tienda:
                                            <input type="text" id="idKilatajePrecio" name="kilatajePrecio" size="6"
                                                   value="0"
                                                   class="invisible"/></td>

                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                            <p><textarea name="mensaje" id="idObs"
                                                         class="textArea" rows="1" cols="40"></textarea></p>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div id="divElectronicos">
                                <table width="100%">
                                    <tbody class="text-body border" align="left">
                                    <tr>
                                        <td colspan="3">Tipo:</td>
                                        <td colspan="9">
                                            <select id="idTipoElectronico" name="cmbTipoElectronico"
                                                    class="selectpicker"
                                                    onchange="combMarcaVEmpe($('#idTipoElectronico').val())"
                                                    style="width: 150px">
                                                <option value="0">Seleccione:</option>
                                                <?php
                                                $data = array();
                                                $sql = new sqlArticulosDAO();
                                                $data = $sql->llenarCmbCatArticulos();
                                                for ($i = 0; $i < count($data); $i++) {
                                                    echo "<option value=" . $data[$i]['id_tipo'] . ">" . $data[$i]['descripcion'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <img src="../../style/Img/lupa.png" data-toggle="modal"
                                                 data-target="#modalArticulos" alt="Buscar"
                                                 onclick="llenarComboTipoE();">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Marca:</td>
                                        <td colspan="9">
                                            <select id="idMarca" name="marcaSelect" class="selectpicker"
                                                    style="width:150px" disabled
                                                    onchange="cmbModeloVEmpe($('#idMarca').val());">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Modelo:</td>
                                        <td colspan="9">
                                            <select id="idModelo" name="modeloSelect" class="selectpicker"
                                                    style="width:150px" disabled
                                                    onchange="llenarDatosElectronico($('#idTipoElectronico').val(),$('#idMarca').val(),$('#idModelo').val())">
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="3">Préstamo:</td>
                                        <td colspan="3">
                                            <input type="text" id="idPrestamoElectronico" name="prestamoE" size="5"
                                                   onkeypress="return soloNumeros(event)"
                                                   style="text-align:center"/ >
                                        </td>
                                        <td colspan="3">Avalúo:</td>
                                        <td colspan="3">
                                            <input type="text" id="idAvaluoElectronico" name="avaluoE" size="5"
                                                   onkeypress="return soloNumeros(event)" disabled
                                                   style="text-align:center" />
                                        </td>
                                    </tr>
                                        <tr>
                                        <td colspan="3">Vitrina:</td>
                                        <td colspan="3">
                                            <input type="text" id="idVitrinaElectronico" name="vitrinaE" size="5"
                                                   onkeypress="return soloNumeros(event)"
                                                   style="text-align:center"/>
                                        </td>
                                            <td colspan="3">Catalogo:</td>
                                            <td colspan="3">
                                                <input type="text" id="idPrecioCat" disabled name="vitrinaE" size="5"
                                                       onkeypress="return soloNumeros(event)"
                                                       style="text-align:center"/>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                            <input type="button" class="btn btn-info" value="Calcular" onclick="calculaAvaluoElec()">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">No.Serie:</td>
                                        <td colspan="9">
                                            <input type="text" id="idSerie" name="serie" size="18"
                                                   style="text-align:left" value=""/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" align="left">Descripción de la prenda:
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" name="detallePrendaE">
                                            <textarea rows="2" cols="40" id="idDetallePrendaElectronico"
                                                      class="textArea"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">Observaciones de la tienda:</td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                            <textarea rows="2" cols="40" id="idObsElectronico" class="textArea"
                                                      name="observacionesE"></textarea>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            <input type="button" class="btn btn-warning" value="Limpiar" onclick="Limpiar()">
                        </td>
                        <td>
                            <input type="button" class="btn btn-success" value="Agregar a la lista" onclick="Agregar()">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col col-lg-12">
                <br>
            </div>
        </div>
        <div class="row">
            <div id="divTablaMetales" class="col col-lg-12 border border-primary" >
            </div>
            <div id="divTablaArticulos" class="col col-lg-12 border border-primary">
            </div>
        </div>
        <div class="row">
            <div class="col col-lg-12">
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col col-lg-12">
                <table border="0" width="100%">
                    <tr>
                        <td align="right">
                            <input type="button" class="btn btn-primary" value="Contrato" onclick="validarMonto()">&nbsp;
                            <input type="button" class="btn btn-warning" value="Cancelar" onclick="cancelar()">&nbsp;
                            <input type="button" class="btn btn-danger" value="Salir" onclick="location.href='vInicio.php'">&nbsp;
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col col-lg-12">
                <table>
                    <tr>
                        <td colspan="12">
                            <input type="text" id="idClienteEmpeno" name="clienteEmpeno" size="5"
                                   style="text-align:center" class="invisible"/>
                            <input type="text" id="idFechaAlm" name="fechaAlm" size="12"
                                   style="text-align:center" class="invisible"/>
                            <input type="text" id="diasInteres" name="diasInteres" size="3"
                                   style="text-align:center" class="invisible"/>
                            <input id="idTotalInteres" name="totalInteres" disabled type="text"
                                   style="width: 150px; text-align: right" class="invisible"/>
                            <input id="idTipoFormulario" name="tipoFormulario" disabled type="text" value="1"
                                   style="width: 150px; text-align: right" class="invisible"/>
                            <input id="idAforo" name="aforo" disabled type="text" value="1"
                                   style="width: 150px; text-align: right" class=""/>
                            <input id="idMontoToken" name="MontoToken" disabled type="text" value="0"
                                   style="width: 150px; text-align: right" class="invisible"/>
                            <input id="idToken" name="token" disabled type="text" value="0"
                                   style="width: 150px; text-align: right" class="invisible"/>
                            <input id="tokenDescripcion" name="tokenDescripcion" disabled type="text" value="0"
                                   style="width: 150px; text-align: right" class="invisible"/>
                        </td>

                    </tr>
                </table>
            </div>
        </div>
    </div>
    </div>
</form>

</body>
</html>
