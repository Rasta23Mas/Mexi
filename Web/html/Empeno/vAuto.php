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
include_once (HTML_PATH."menuGeneral.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../../JavaScript/funcionesIntereses.js"></script>
    <script src="../../JavaScript/funcionesCliente.js"></script>
    <script src="../../JavaScript/funcionesContrato.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionesArticulos.js"></script>
    <script src="../../JavaScript/funcionesCalendario.js"></script>
    <link rel="stylesheet" type="text/css" href="../../librerias/jqueryui/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
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
            <br>
            <br>
        </div>
        <div class="row">
            <div class="col col-lg-6 border border-primary ">
                <table border="0" width="90%" style="margin: 0 auto;">
                    <tbody>
                    <tr>
                        <td colspan="3">
                            <input type="button" class="btn btn-success "
                                   data-toggle="modal" data-target="#modalRegistroNuevo"
                                   value="Agregar">
                        </td>
                        <td colspan="3">
                            <input type="button" class="btn btn-warning "
                                   data-toggle="modal" data-target="#modalEditarNuevo" id="btnEditar"
                                   value="Editar" onclick="modalEditarCliente($('#idClienteEmpeno').val())" disabled>
                        </td>
                        <td colspan="3">
                            <input type="button" class="btn btn-warning "
                                   data-toggle="modal" data-target="#modalHistorial" id="btnEditar"
                                   value="Historial" onclick="historial($('#idClienteEmpeno').val())">
                        </td>
                        <td colspan="3">
                            <input type="button" class="btn btn-success "
                                   data-toggle="modal" data-target="#modalBusquedaCliente"
                                   onclick="mostrarTodos($('#idNombres').val())"
                                   value="Ver todos">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <label for="nombreCliente">Nombre:</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <div>
                                <input id="idNombres" name="Nombres" type="text" style="width: 350px"
                                       class="inputCliente"
                                       onkeypress="nombreAutocompletar()" placeholder="Buscar Cliente..."/>
                            </div>
                            <div id="suggestionsNombreEmpeno"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <label for="celular">Celular:</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
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
                                    <textarea rows="3" cols="36" id="idDireccionEmpeno" class="textArea" disabled>
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
                            <input type="text" id="idNombreBen" name="idNombreBen" class="inputCliente" onkeypress="return soloLetras(event)"
                                   style="width:350px" placeholder="A. Paterno-A. Materno-Nombre"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <input type="text" id="idClienteEmpeno" name="clienteEmpeno" size="20"
                                   style="text-align:center" class="invisible"/>
                            <input id="idSumaInteresPrestamo" name="totalInteres" disabled type="text"
                                   style="width: 150px; text-align: right" class="invisible"/>
                            <input type="text" id="idFechaAlm" name="fechaAlm" size="12"
                                   style="text-align:center" class="invisible"/>
                            <input type="text" id="diasInteres" name="diasInteres" size="3"
                                   style="text-align:center" class="invisible"/>
                            <input id="idTipoFormulario" name="tipoFormulario" disabled type="text" value="3"
                                   style="width: 150px; text-align: right" class="invisible"/>
                            <input id="idAforo" name="aforo" disabled type="text" value="1"
                                   style="width: 150px; text-align: right" class="invisible"/>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col col-lg-6 border border-primary border-left-0">
                <table border="0" width="80%" class="tableInteres">
                    <tbody align="left">
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
                        <td colspan="6" class="border border-dark">&nbsp;Tasa Interés</td>
                        <td colspan="6" class="border border-dark">
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
                    </tr>
                    <tr class="headt">
                        <td colspan="6" class="border border-dark">&nbsp;Días Almoneda</td>
                        <td colspan="6" class="border border-dark" >
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
                        <td colspan="4" class="table-info border border-dark">Tipo Interés</td>
                        <td colspan="4" class="table-info border border-dark">Periodo</td>
                        <td colspan="4" class="table-info border border-dark">Plazo</td>
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
                        <td colspan="4" class="table-info border border-dark" align="center">Total Avalúo</td>
                        <td colspan="4" class="table-info border border-dark" align="center">Total Préstamo</td>
                        <td colspan="4" class="table-info border border-dark" align="center"></td>
                    </tr>
                    <tr class="headt">
                        <td colspan="4" class="border border-dark" align="center">
                            <input id="idTotalAvaluoAutoMon" name="totalAvaluo" type="double"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="width: 100px; text-align:right;"
                                   class="inputCliente"/>
                        </td>
                        <td colspan="4" class="border border-dark" align="center">
                            <input id="idTotalPrestamoAutoMon" name="totalPrestamo" type="double"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="width: 100px; text-align:right;"
                                   class="inputCliente"/>
                        </td>
                        <td colspan="4" class="border border-dark" align="center">
                            <input type="button" class="btn btn-info" value="Calcular" onclick="calculaAvaluoAuto()">&nbsp;&nbsp;
                            <input type="button" class="btn btn-warning" value="Limpiar" onclick="limpiarAuto()">

                        </td>
                    </tr>
                    <tr class="invisible">
                        <td colspan="4" align="center">
                            <input id="idTotalAvaluoAuto" name="totalAvaluo" type="double"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="width: 100px; text-align:right;"
                                   class="inputCliente"/>
                        </td>
                        <td colspan="8"  align="center">
                            <input id="idTotalPrestamoAuto" name="totalPrestamo" type="double"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="width: 100px; text-align:right;"
                                   class="inputCliente"/>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td colspan="6" class="table-info border border-dark" align="center">Costo Pensión Mensual:</td>
                        <td colspan="6" class="border border-dark" align="center">
                            <input id="idPension" name="poliza" type="text" style="width: 150px; text-align:right;"
                                   onkeypress="return isNumberDecimal(event)"
                                   class="inputCliente"/>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td colspan="6" class="table-info border border-dark" align="center">Costo Poliza Mensual:</td>
                        <td colspan="6" class="border border-dark" align="center">
                            <input id="idPolizaSeguro" name="poliza" type="text" style="width: 150px; text-align:right;"
                                   onkeypress="return isNumberDecimal(event)"
                                   class="inputCliente"/>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td colspan="6" class="table-info border border-dark" align="center">Costo GPS Mensual:</td>
                        <td colspan="6" class="border border-dark" align="center">
                            <input id="idGPS" name="gps" type="text" style="width: 150px; text-align:right;"
                                   onkeypress="return isNumberDecimal(event)"
                                   class="inputCliente"/>
                        </td>
                    </tr>

                    </tbody>
                </table>
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
                    <tbody>
                    <tr>
                        <td colspan="10">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Tipo Vehiculo</label>
                        </td>
                        <td colspan="2">
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
                        </td>
                        <td>
                            <label>Placas</label>
                        </td>
                        <td>
                            <label>Factura</label>
                        </td>
                        <td>
                            <label>Kms.</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
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
                        <td colspan="2">
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
                                <option value="0">Seleccione:</option>
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
                        <td>
                            <input type="text" id="idPlacas" name="placas" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idFactura" name="factura" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idKms" name="kms" size="13" onkeypress="return isNumberDecimal(event)"
                                   style="text-align:left"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Agencia</label>
                        </td>
                        <td colspan="2">
                            <label>Número de motor</label>
                        </td>
                        <td>
                            <label>Serie chasis</label>
                        </td>
                        <td colspan="2" align="center">
                            <label>VIN (N. Id. Vehiculo)</label>
                        </td>
                        <td colspan="3" rowspan="5" align="center">
                            <div class="border border-primary">
                                <table>
                                    <tr>
                                        <td colspan="2"><h4>Documentos entregados</h4></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="idCheckTarjeta">
                                                <label class="form-check-label" for="exampleCheck1">Tarjeta de
                                                    Circulación</label>
                                            </div>
                                        </td>
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
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" id="idAgencia" name="agencia" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td colspan="2">
                            <input type="text" id="idMotor" name="motor" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idChasis" name="chasis" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td colspan="2" align="center">
                            <input type="text" id="idVehiculo" name="vehiculo" size="13"
                                   style="text-align:left"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>REPUVE</label>
                        </td>
                        <td colspan="2">
                            <label>Gasolina %</label>
                        </td>
                        <td>
                            <label>Aseguradora</label>
                        </td>
                        <td colspan="2" align="center">
                            <label>Tarjeta de circulación</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" id="idRepuve" name="repuve" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td colspan="2">
                            <input type="text" id="idGasolina" name="gasolina" size="13" onkeypress="return isNumberDecimal(event)"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idAseguradora" name="aseguradora" size="13"
                                   style="text-align:left"/>
                        </td>
                        <td colspan="2" align="center">
                            <input type="text" id="idTarjeta" name="tarjeta" size="13"
                                   style="text-align:left"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Poliza</label>
                        </td>
                        <td colspan="2">
                            <label>Fecha Vencimiento</label>
                        </td>
                        <td colspan="3">
                            <label>Tipo Poliza</label>
                        </td>
                    </tr>
                    <tr>

                        <td colspan="2">
                            <input type="text" id="idPoliza" name="poliza" size="13" onkeypress="return isNumberDecimal(event)"
                                   style="text-align:left"/>
                        </td>
                        <td colspan="2">
                            <input type="text" id="idFechaVencAuto" name="fechaVencAuto" size="13"
                                  class="calendarioModBoton" disabled
                                   style="text-align:left" placeholder="AAAA-MM-DD"/>
                        </td>
                        <td colspan="6">
                            <input type="text" id="idTipoPoliza" name="tipoPoliza" size="13"
                                   style="text-align:left"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <label>Observaciones</label>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="10" name="observacionesAuto">
                            <p><textarea name="detalle" id="idObservacionesAuto"
                                         class="textArea" rows="2" cols="60"></textarea></p>
                        </td>
                    </tr>

                    </tbody>
                </table>

            </div>
        </div>
        <div class="row" class="border border-success" >
            <div class="col col-lg-12" align="right" class="border border-success">
                <input type="button" class="btn btn-primary" value="Contrato" onclick="generarContratoAuto()">&nbsp;
                <input type="button" class="btn btn-warning" value="Cancelar" onclick="cancelar()">&nbsp;
                <input type="button" class="btn btn-danger" value="Salir" onclick="location.href='vInicio.php'">&nbsp;
            </div>
        </div>
    </div>
</form>

</body>
</html>
