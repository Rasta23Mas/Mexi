<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro Clientes</title>
    <script src="../../JavaScript/funcionesCatalogos.js"></script>

</head>
<body>
<div class="modal fade " id="modalEditarNuevo" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <form id="idFormEditar" autocomplete="off">
                        <div id="conteiner" class="container">

                            <div class="row">
                                <div class="col-12" align="center">
                                    <table width="100%">
                                        <tr>
                                            <td>Nombre(s):</td>
                                            <td>Apellido Paterno:</td>
                                            <td>Apellido Materno:</td>
                                            <td>Sexo:</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" class="inputCliente" name="nombre" id="idNombreEdit"
                                                       placeholder="Nombres" onkeypress="return soloLetras(event)"
                                                       style="width: 200px"
                                                       required/>
                                            </td>
                                            <td>
                                                <input type="text" class="inputCliente" name="apPat" id="idApPatEdit"
                                                       placeholder="Apellido Paterno" style="width: 200px" onkeypress="return soloLetras(event)"
                                                       required/>
                                            </td>
                                            <td>
                                                <input type="text" class="inputCliente" name="apMat" id="idApMatEdit" onkeypress="return soloLetras(event)"
                                                       placeholder="Apellido Materno" style="width: 200px"/>
                                            </td>
                                            <td>
                                                <select name="sexo" id="idSexoEdit" style="width: 200px" required>
                                                    <option value="0">Selecciona:</option>
                                                    <?php
                                                    $dataSexo = array();
                                                    $sqlCatalogo = new sqlCatalogoDAO();
                                                    $dataSexo = $sqlCatalogo->llenarCmbSexo();
                                                    for ($i = 0; $i < count($dataSexo); $i++) {
                                                        echo "<option value=" . $dataSexo[$i]['id_Cat_Cliente'] . ">" . $dataSexo[$i]['descripcion'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Tipo de Identificaci&oacute;n:
                                            </td>
                                            <td>
                                                No. Identificaci&oacute;n:
                                            </td>
                                            <td>Fecha Nacimiento:</td>
                                            <td>
                                                Correo Electr&oacute;nico:
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select type="text" name="identificacion" placeholder="Selecciona uno"
                                                        id="idIdentificacionEdit"
                                                        style="width: 200px" required>
                                                    <option value="44">Selecciona Uno</option>
                                                    <?php
                                                    $dataIdent = array();
                                                    $sq = new sqlCatalogoDAO();
                                                    $dataIdent = $sq->traeIdentificaciones();
                                                    for ($i = 0; $i < count($dataIdent); $i++) {
                                                        echo "<option value=" . $dataIdent[$i]['id_Cat_Cliente'] . ">" . $dataIdent[$i]['descripcion'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="numIdentificacion" placeholder=""
                                                       id="idNumIdentificacionEdit"
                                                       style="width: 200px"
                                                       required/>
                                            </td>
                                            <td>
                                                <input type="text" name="fechaNac" id="idFechaNacEdit"
                                                     style="width: 150px"  onkeypress="return isDateValidate(event)"
                                                       required placeholder="AAAA-MM-DD" />
                                            </td>
                                            <td>
                                                <input type="text" name="correo" id="idCorreoEdit" class="inputMinus" style="width: 200px"
                                                       placeholder=""/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>RFC:</td>
                                            <td>
                                                CURP:
                                            </td>
                                            <td>
                                                Celular:
                                            </td>
                                            <td>
                                                Tel&eacute;fono:
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" class="inputCliente" name="rfc" id="idRfcEdit"
                                                       placeholder=""
                                                       style="width: 200px"/>
                                            </td>
                                            <td>
                                                <input type="text" class="inputCliente" name="curp" id="idCurpEdit"
                                                       style="width: 200px"
                                                       placeholder=""/>
                                            </td>
                                            <td>
                                                <input type="text" name="celular" id="idCelularEdit"
                                                       onkeypress="return soloNumeros(event)"
                                                       style="width: 200px" maxlength="11"
                                                       required/>
                                            </td>
                                            <td>
                                                <input type="text" name="telefono" id="idTelefonoEdit"
                                                       onkeypress="return soloNumeros(event)"
                                                       style="width: 200px" maxlength="8"
                                                       placeholder="N&uacute;mero con lada"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Estado de Residencia:
                                            </td>
                                            <td>
                                                Municipio:
                                            </td>
                                            <td>
                                                Localidad:
                                            </td>
                                            <td>
                                                Calle:
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select id="idEstadoNameEdit" name="estadoName" class="selectpicker"  style="width:155px">
                                                    <option value="0">Seleccione:</option>
                                                    <?php
                                                    $dataEstado = array();
                                                    $sqlEstado = new sqlCatalogoDAO();
                                                    $dataEstado = $sqlEstado->completaEstado();
                                                    for ($i = 0; $i < count($dataEstado); $i++) {
                                                        echo "<option value=" . $dataEstado[$i]['id_Estado'] . ">" . $dataEstado[$i]['descripcion'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="inputCliente" name="municipioName" placeholder=""
                                                       id="idMunicipioEdit" onkeypress="return soloLetras(event)"
                                                       style="width: 200px" required/>
                                            </td>
                                            <td>
                                                <input type="text" class="inputCliente" name="municipioName" placeholder=""
                                                       id="idLocalidadEdit" onkeypress="return soloLetras(event)"
                                                       style="width: 200px" required/>
                                            </td>
                                            <td>
                                                <input type="text" class="inputCliente" name="calle" placeholder=""
                                                       id="idCalleEdit"
                                                       style="width: 200px"
                                                       required/>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                Codigo Postal:
                                            </td>
                                            <td>
                                                No. Exterior:
                                            </td>
                                            <td>
                                                No. Interior:
                                            </td>
                                            <td>
                                                Ocupacion:
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="cp" placeholder=""
                                                       onkeypress="return soloNumeros(event)"
                                                       id="idCPEdit" style="width: 100px" required/>
                                            </td>
                                            <td>
                                                <input type="text" name="numExt" placeholder=""
                                                       onkeypress="return soloNumeros(event)"
                                                       id="idNumExtEdit" style="width: 50px" required/>
                                            </td>
                                            <td>
                                                <input type="text" name="numInt" placeholder="" id="idNumIntEdit"
                                                       style="width: 150px"/>
                                            </td>
                                            <td>
                                                <input type="text" name="numInt" placeholder="" id="idOcupacionEdit"
                                                       style="width: 200px"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                Mensaje de uso interno:
                                            </td>
                                            <td>
                                                ¿Como se entero?
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                            <textarea type="text" class="inputCliente textArea" name="mensajeInterno" placeholder=""
                                                     id="idMensajeInternoEdit" rows="3" cols="80"></textarea>
                                            </td>
                                            <td style="vertical-align:top;">
                                                <select name="promocion" placeholder="Selecciona:"
                                                        class="selectpicker"
                                                        id="idPromocionEdit" style="width: 150px">
                                                    <option value="0">Selecciona:</option>
                                                    <?php

                                                    $dataPromo = array();

                                                    $sql = new sqlCatalogoDAO();

                                                    $dataPromo = $sql->traePromociones();

                                                    for ($i = 0; $i < count($dataPromo); $i++) {
                                                        echo "<option value=" . $dataPromo[$i]['id_Cat_Cliente'] . ">" . $dataPromo[$i]['descripcion'] . "</option>";
                                                    }

                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <input id="idClienteEditar" name="clienteEditar" type="text" style="width: 5px"
                                       class="invisible"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-warning" onclick="confirmarActualizacion()"
                       value="Actualizar">
            </div>
        </div>
    </div>
</div>
</body>
</html>
