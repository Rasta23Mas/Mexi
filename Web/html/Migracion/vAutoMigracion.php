<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Menu.php');
include_once(DESC_PATH . "modalDescuentoTokenAuto.php");
include_once(SQL_PATH . "sqlArticulosDAO.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Empeño Auto</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../../JavaScript/funcionesMigAuto.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionesMovimiento.js"></script>
    <script src="../../JavaScript/funcionesArticulos.js"></script>
    <script src="../../JavaScript/funcionesCalendario.js"></script>
    <script src="../../JavaScript/funcionNumerosLetras.js"></script>

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

        .inputMayus {
            text-transform: uppercase;

        }
        .letraExtraChica {
            font-size: .9em;
        }
    </style>
</head>
<body>
<form id="idFormAuto" name="formAuto">
    <div id="contenedor" class="container letraExtraChica ">
        <div>
            <br>
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
                            <label>Contrato</label>
                        </td>
                        <td>
                            <label>Folio Migración</label>
                        </td>
                        <td>
                            <label>Prestamo</label>
                        </td>
                        <td>
                            <label>Avaluo</label>
                        </td>
                        <td>
                            <label>Vitrina</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="idContratoMig" name="contrato" size="13" class="inputMayus"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idFolioMig" name="folio" size="13" class="inputMayus"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idPrestamoMig" name="prestamo" size="13" class="inputMayus"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idAvaluoMig" name="avaluo" size="13" class="inputMayus"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idVitrinaMig" name="migracion" size="13" class="inputMayus"
                                   style="text-align:left"/>
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
                            <input type="text" id="idMarca" name="marca" size="13" class="inputMayus"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idModelo" name="modelo" size="13" class="inputMayus"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idAnio" name="anio" size="13" onkeypress="return soloNumeros(event)"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idColor" name="color" size="13" class="inputMayus"
                                   style="text-align:left"/>
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
                            <input type="text" id="idPlacas" name="placas" size="13" class="inputMayus"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idFactura" name="factura" size="13" class="inputMayus"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idKms" name="kms" size="13"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idAgencia" name="agencia" size="13" class="inputMayus"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idMotor" name="motor" size="13" class="inputMayus"
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
                            <input type="text" id="idChasis" name="chasis" size="13" class="inputMayus"
                                   style="text-align:left"/>
                        </td>
                        <td >
                            <input type="text" id="idVehiculo" name="vehiculo" size="13" class="inputMayus"
                                   style="text-align:left"/>
                        </td>
                        <td >
                            <input type="text" id="idRepuve" name="repuve" size="13" class="inputMayus"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idGasolina" name="gasolina" size="13"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="text-align:left"/>
                        </td>
                        <td>
                            <input type="text" id="idTarjeta" name="tarjeta" size="13" class="inputMayus"
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
                        <td>
                            <br>
                        </td>
                    </tr>
                    <tr>

                        <td >
                            <input type="text" id="idAseguradora" name="aseguradora" size="13" class="inputMayus"
                                   style="text-align:left"/>
                        </td>
                        <td >
                            <input type="text" id="idPoliza" name="poliza" size="13" class="inputMayus"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="text-align:left"/>
                        </td>
                        <td >
                            <input type="text" id="idFechaVencAuto" name="fechaVencAuto" size="13"
                                   class="calendarioModBoton" disabled
                                   style="text-align:left"/>
                        </td>
                        <td >
                            <input type="text" id="idTipoPoliza" name="tipoPoliza" size="13" class="inputMayus"
                                   style="text-align:left"/>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="5">
                            <label>Observaciones</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" name="observacionesAuto" rowspan="2">
                            <p><textarea name="detalle" id="idObservacionesAuto" class="inputMayus textArea"
                                         rows="1" cols="100"></textarea></p>
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
                            <input type="button" class="btn btn-primary" value="Contrato" onclick="validateFormAuto()">&nbsp;
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
                        <input id="idMontoToken" name="MontoToken" disabled type="text" value="0"
                               style="width: 150px; text-align: right" />
                        <input id="idToken" name="token" disabled type="text" value="0"
                               style="width: 150px; text-align: right" />
                        <input id="tokenDescripcion" name="tokenDescripcion" disabled type="text" value="0"
                               style="width: 150px; text-align: right" />
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>

</body>
</html>
