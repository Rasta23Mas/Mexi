<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["idUsuario"])) {
    header("Location: ../index.php");
    session_destroy();
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
include_once(HTML_PATH . "Empeno/modalColor.php");
include_once(HTML_PATH . "menuGeneral.php");
include_once(DESC_PATH . "modalDescuentoTokenAuto.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../../JavaScript/funcionesIntereses.js"></script>
    <script src="../../JavaScript/funcionesCliente.js"></script>
    <script src="../../JavaScript/funcionesContratoAuto.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionesArticulos.js"></script>
    <script src="../../JavaScript/funcionesCalendario.js"></script>
    <link rel="stylesheet" type="text/css" href="../../librerias/jqueryui/jquery-ui.min.css">
    <script src="../../librerias/jqueryui/jquery-ui.min.js"></script>
    <style type="text/css">
        #suggestionsNombreEmpeno {
            box-shadow: 2px 2px 8px 0 rgba(0, 0, 0, .2);
            height: auto;
            position: absolute;
            top: 103px;
            z-index: 9999;
            width: 300px;
        }

        #suggestionsNombreEmpeno .suggest-element {
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

        .inputMinus {
            text-transform: lowercase;

        }

    </style>
</head>
<body>
<form id="idFormAuto" name="formAuto">
    <div id="contenedor" class="container">
        <div>
            <br>
        </div>
        <div class="row">
            <div class="col col-lg-7 border border-primary ">
                <table border="0" width="90%" style="margin: 0 auto;">
                    <tr>
                        <td colspan="12" align="right">
                            <input type="button" class="btn btn-success "
                                   data-toggle="modal" data-target="#modalRegistroNuevo"
                                   value="Agregar">&nbsp;&nbsp;
                            <input type="button" class="btn btn-warning "
                                   data-toggle="modal" data-target="#modalEditarNuevo" id="btnEditar"
                                   value="Editar" onclick="modalEditarCliente($('#idClienteEmpeno').val())" disabled>
                            &nbsp;&nbsp;
                            <input type="button" class="btn btn-primary " id="btnHistorial"
                                   value="Historial" onclick="historial($('#idClienteEmpeno').val())">
                            &nbsp;&nbsp;
                            <input type="button" class="btn btn-info "
                                   onclick="mostrarTodos($('#idNombres').val())"
                                   value="Ver todos">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <label for="nombreCliente">Nombre:</label>
                        </td>
                        <td colspan="5">
                            <label for="celular">Celular:</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <div>
                                <input id="idNombres" name="Nombres" type="text" style="width: 350px"
                                       class="inputCliente"
                                       onkeypress="nombreAutocompletar()" placeholder="Buscar Cliente..."/>
                            </div>
                            <div id="suggestionsNombreEmpeno"></div>
                        </td>
                        <td colspan="5">
                            <input type="text" name="celularEmpeno" placeholder="" id="idCelularEmpeno"
                                   style="width: 120px"
                                   required disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <label for="direccion">Dirección:</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12" rowspan="2" name="direccionEmpeno">
                                    <textarea rows="2" cols="75" id="idDireccionEmpeno" class="textArea" disabled>
                                    </textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">

                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <label for="cotitular">Nombre Cotitular:</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <input type="text" id="nombreCotitular" name="idNombreCotitular" class="inputCliente"
                                   onkeypress="return soloLetras(event)"
                                   style="width: 350px" placeholder="A. Paterno-A. Materno-Nombre"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <label for="beneficiario">Nombre Beneficiario:</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <input type="text" id="idNombreBen" name="idNombreBen" class="inputCliente"
                                   onkeypress="return soloLetras(event)"
                                   style="width:350px" placeholder="A. Paterno-A. Materno-Nombre"/>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col col-lg-5 border border-primary border-left-0">
                <table border="0" width="100%" class="tableInteres">
                    <tr>
                        <br>
                    </tr>
                    <tr class="headt">
                        <td colspan="12" class="border border-dark">
                            <label for="vence">&nbsp;Vence:</label>
                            <label id="idFecVencimiento"></label>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td colspan="3" class="border border-dark">&nbsp;Tasa Interés</td>
                        <td colspan="3" class="border border-dark">
                            <select id="tipoInteresEmpeno" name="cmbTipoInteres" class="selectpicker"
                                    onchange="SeleccionarInteres($('#tipoInteresEmpeno').val())">
                                <option value="0">Seleccione:</option>
                                <?php
                                $data = array();
                                $sql = new sqlInteresesDAO();
                                $data = $sql->llenarCmbTipoInteresAutos();
                                for ($i = 0; $i < count($data); $i++) {
                                    echo "<option value=" . $data[$i]['id_interes'] . ">" . $data[$i]['tasa_interes'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td colspan="3" class="border border-dark">&nbsp;Días Almoneda</td>
                        <td colspan="3" class="border border-dark">
                            <select id="idDiasAlmoneda" name="diasAlmName" class="selectpicker" disabled
                                    onchange="calcularDias()"
                                    style="width: 80px">
                                <?php
                                $data = array();
                                $sql = new sqlInteresesDAO();
                                $data = $sql->diasAlmoneda();
                                for ($i = 0; $i < count($data); $i++) {
                                    echo "<option value=" . $data[$i]['id_fechaAlm'] . ">" . $data[$i]['dias'] . "</option>";
                                }
                                ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="table-info border border-dark">&nbsp;Tipo Interés</td>
                        <td colspan="4" class="table-info border border-dark">&nbsp;Periodo</td>
                        <td colspan="4" class="table-info border border-dark">&nbsp;Plazo</td>
                    </tr>
                    <tr class="headt">
                        <td colspan="4" class="border border-dark " align="center">
                            <label id="idTipoInteres"></label>
                            <br>
                        </td>
                        <td colspan="4" class="border border-dark" align="center">
                            <label id="idPeriodo"></label>
                        </td>
                        <td colspan="4" class="border border-dark" align="center">
                            <label id="idPlazo"></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="table-info border border-dark " align="center">% Tasa</td>
                        <td colspan="3" class="table-info border border-dark" align="center">% Alm.</td>
                        <td colspan="3" class="table-info border border-dark" align="center">% Seguro</td>
                        <td colspan="3" class="table-info border border-dark" align="center">% I.V.A.</td>
                    </tr>
                    <tr class="headt">
                        <td colspan="3" class="border border-dark" align="center">
                            <label id="idTasaPorcen"></label>
                        </td>
                        <td colspan="3" class="border border-dark" align="center">
                            <label id="idAlmPorcen"></label>
                        </td>
                        <td colspan="3" class="border border-dark" align="center">
                            <label id="idSeguroPorcen"></label>
                        </td>
                        <td colspan="3" class="border border-dark" align="center">
                            <label id="idIvaPorcen"></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="table-info border border-dark" align="right">Total Avalúo</td>
                        <td colspan="6" class="border border-dark" align="left">
                            &nbsp;&nbsp;
                            <input id="idTotalAvaluoAutoMon" name="totalAvaluo" type="double"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="width: 100px; text-align:right;" disabled
                                   class="inputCliente"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="table-info border border-dark" align="right">Total Préstamo</td>
                        <td colspan="6" class="border border-dark" align="left">
                            &nbsp;&nbsp;
                            <input id="idTotalPrestamoAutoMon" name="totalPrestamo" type="double"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="width: 100px; text-align:right;"
                                   class="inputCliente"/>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td colspan="6" class="table-info border border-dark" align="right">Costo Pensión Mensual:</td>
                        <td colspan="6" class="border border-dark" align="left">
                            &nbsp;&nbsp;
                            <input id="idPensionMon" name="poliza" type="text" style="width: 70px; text-align:right;"
                                   onkeypress="return isNumberDecimal(event)"
                                   class="inputCliente"/>
                            <input id="idPension" name="poliza" type="text" style="width: 70px; text-align:right;"
                                   class="invisible"/>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td colspan="6" class="table-info border border-dark" align="right">Costo Póliza Mensual:</td>
                        <td colspan="6" class="border border-dark" align="left">
                            &nbsp;&nbsp;
                            <input id="idPolizaSeguroMon" name="poliza" type="text" style="width: 70px; text-align:right;"
                                   onkeypress="return isNumberDecimal(event)"
                                   class="inputCliente"/>
                            <input id="idPolizaSeguro" name="poliza" type="text" style="width: 70px; text-align:right;"
                                   class="invisible"/>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td colspan="6" class="table-info border border-dark" align="right">Costo GPS Mensual:</td>
                        <td colspan="6" class="border border-dark" align="left">
                            &nbsp;&nbsp;
                            <input id="idGPSMon" name="gps" type="text" style="width: 70px; text-align:right;"
                                   onkeypress="return isNumberDecimal(event)"
                                   class="inputCliente"/>
                            <input id="idGPS" name="gps" type="text" style="width: 70px; text-align:right;"
                                   class="invisible" />
                        </td>
                    </tr>
                    <tr class="headt">
                        <td colspan="6" class="table-info border border-dark" align="right">
                            <br>
                        </td>
                        <td colspan="6" class="border border-dark" align="center">
                            <input type="button" class="btn btn-info" value="Calcular" onclick="calculaAvaluoAuto()">&nbsp;&nbsp;
                            <input type="button" class="btn btn-warning" value="Limpiar" onclick="limpiarAuto()">

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br>
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
            <div class="col col-lg-9 border border-primary ">
                <table border="0" width="100%">
                    <tr>
                        <td colspan="10">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Tipo Vehiculo</label>
                        </td>
                        <td>
                            <label>Marca</label>
                        </td>
                        <td>
                            <label>Modelo</label>
                        </td>
                        <td>
                            <label>Año</label>
                        </td>
                        <td>
                            <label>Color</label>
                            <img src="../../style/Img/mas.png"  data-toggle="modal"
                                 data-target="#modalColor" alt="Agregar Tipo">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select id="idTipoVehiculo" name="cmbVehiculo" class="selectpicker">
                                <option value="0">Seleccione:</option>
                                <?php
                                $data = array();
                                $sql = new sqlArticulosDAO();
                                $data = $sql->llenarCmbTipoAuto();
                                for ($i = 0; $i < count($data); $i++) {
                                    echo "<option value=" . $data[$i]['id_Auto'] . ">" . $data[$i]['descripcion'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" id="idMarca" name="marca" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idModelo" name="modelo" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idAnio" name="anio" size="13" onkeypress="return soloNumeros(event)"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <select id="idColor" name="cmbColor" class="selectpicker" style="width: 120px">
                                <option value="0">SELECCIONE:</option>
                                <?php
                                $data = array();
                                $sql = new sqlArticulosDAO();
                                $data = $sql->llenarCmbColores();
                                for ($i = 0; $i < count($data); $i++) {
                                    echo "<option value=" . $data[$i]['id_Color'] . ">" . $data[$i]['descripcion'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Placas</label>
                        </td>
                        <td>
                            <label>Factura</label>
                        </td>
                        <td>
                            <label>Kms.</label>
                        </td>
                        <td>
                            <label>Agencia</label>
                        </td>
                        <td>
                            <label>Número de motor</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="idPlacas" name="placas" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idFactura" name="factura" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idKms" name="kms" size="13"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idAgencia" name="agencia" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idMotor" name="motor" size="13"
                                   style="text-align:left"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Serie chasis</label>
                        </td>
                        <td>
                            <label>VIN (N. Id. Vehiculo)</label>
                        </td>
                        <td >
                            <label>REPUVE</label>
                        </td>
                        <td>
                            <label>Gasolina %</label>
                        </td>
                        <td>
                            <label>Tarjeta de circulación</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="idChasis" name="chasis" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td >
                            <input type="text" id="idVehiculo" name="vehiculo" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td >
                            <input type="text" id="idRepuve" name="repuve" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idGasolina" name="gasolina" size="13"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idTarjeta" name="tarjeta" size="13"
                                   style="text-align:left"/>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <label>Aseguradora</label>
                        </td>
                        <td >
                            <label>Póliza</label>
                        </td>
                        <td >
                            <label>Fecha Vencimiento</label>
                        </td>
                        <td >
                            <label>Tipo Póliza</label>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <input type="text" id="idAseguradora" name="aseguradora" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td >
                            <input type="text" id="idPoliza" name="poliza" size="13"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="text-align:left"/>
                        </td>
                        <td >
                            <input type="text" id="idFechaVencAuto" name="fechaVencAuto" size="13"
                                   class="calendarioModBoton" disabled
                                   style="text-align:left"/>
                        </td>
                        <td >
                            <input type="text" id="idTipoPoliza" name="tipoPoliza" size="13"
                                   style="text-align:left"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <label>Observaciones</label>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="5" name="observacionesAuto">
                            <p><textarea name="detalle" id="idObservacionesAuto"
                                         class="textArea" rows="1" cols="90"></textarea></p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col col-lg-3 border border-primary border-left-0">
                <table border="0" width="100%">
                    <tbody>
                    <tr>
                        <td colspan="2">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><h5>Documentos entregados:</h5></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="idCheckTarjeta">
                                <label class="form-check-label" for="exampleCheck1">Tarjeta de
                                    Circulación</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="idCheckFactura">
                                <label class="form-check-label" for="exampleCheck1">Factura</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="idCheckINE">
                                <label class="form-check-label" for="exampleCheck1">Copia INE</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="idCheckImportacion"
                                       cion>
                                <label class="form-check-label" for="exampleCheck1">Importación</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                       id="idCheckTenecia">
                                <label class="form-check-label" for="exampleCheck1">Tenencias(Últimas
                                    5)</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                       id="idCheckPoliza">
                                <label class="form-check-label" for="exampleCheck1">Póliza de
                                    seguro</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                       id="idCheckLicencia">
                                <label class="form-check-label" for="exampleCheck1">Copia de
                                    Licencia</label>
                            </div>
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
        <div class="row" class="border border-success">
            <div class="col col-lg-12" align="right" class="border border-success">
                <table>
                    <tr>
                        <td align="right">
                            <input type="button" class="btn btn-primary" value="Contrato" onclick="validarMontoAuto()">&nbsp;
                            <input type="button" class="btn btn-warning" value="Cancelar" onclick="cancelar()">&nbsp;
                            <input type="button" class="btn btn-warning" value="test" onclick="funcionSeleccionarColor()">&nbsp;

                            <input type="button" class="btn btn-danger" value="Salir" onclick="location.href='vInicio.php'">&nbsp;
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div>
                <table class="invisible">
                    <tr>
                        <td>
                        <input type="text" id="idClienteEmpeno" name="clienteEmpeno" size="20"
                               style="text-align:center" />
                        <input id="idSumaInteresPrestamo" name="totalInteres" disabled type="text"
                               style="width: 150px; text-align: right"/>
                        <input type="text" id="idFechaAlm" name="fechaAlm" size="12"
                               style="text-align:center" />
                        <input type="text" id="diasInteres" name="diasInteres" size="3"
                               style="text-align:center" />
                        <input id="idTipoFormulario" name="tipoFormulario" disabled type="text" value="3"
                               style="width: 150px; text-align: right" />
                        <input id="idAforo" name="aforo" disabled type="text" value="1"
                               style="width: 150px; text-align: right" />
                        <input id="idMontoToken" name="MontoToken" disabled type="text" value="0"
                               style="width: 150px; text-align: right" />
                        <input id="idToken" name="token" disabled type="text" value="0"
                               style="width: 150px; text-align: right" />
                        <input id="tokenDescripcion" name="tokenDescripcion" disabled type="text" value="0"
                               style="width: 150px; text-align: right" />
                        </td>
                        <td colspan="4" align="center">
                            <input id="idTotalAvaluoAuto" name="totalAvaluo"  />
                            <input id="idTotalPrestamoAuto" name="totalPrestamo" />
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>

</body>
</html>
