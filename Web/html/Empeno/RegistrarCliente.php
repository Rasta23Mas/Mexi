<?php
/*if(!isset($_SESSION)) {
    session_start();
}
if(!isset($_SESSION["idUsuario"])){
    header("Location: ../index.php");
    session_destroy();
}*/
$_SESSION['idUsuario'] = 1;
$_SESSION['usuario'] = "admin";
$_SESSION['sucursal'] = 1;
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");
include_once(HTML_PATH . "Empeno/menuLibrerias.php")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Generales-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Funciones-->
    <script src="../../JavaScript/funcionesCatalogos.js"></script>
    <script src="../../JavaScript/funcionesCliente.js"></script>
    <!--Calendario-->
    <script src="../../JavaScript/funcionesCalendario.js"></script>
    <link rel="stylesheet"  type="text/css" href="../../librerias/jqueryui/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="../../librerias/jqueryui/jquery-ui.min.js"></script>
    <style type="text/css">
        .textArea {
            resize: none;
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
<form id="idFormRegistro" autocomplete="off">
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
                            <input type="text" class="inputCliente" name="nombre" id="idNombre"
                                   placeholder="Nombres"
                                   style="width: 200px"
                                   required/>
                        </td>
                        <td>
                            <input type="text" class="inputCliente" name="apPat" id="idApPat"
                                   placeholder="Apellido Paterno" style="width: 200px"
                                   required/>
                        </td>
                        <td>
                            <input type="text" class="inputCliente" name="apMat" id="idApMat"
                                   placeholder="Apellido Materno" style="width: 200px"/>
                        </td>
                        <td>
                            <select name="sexo" id="idSexo" style="width: 200px" required>
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
                                    id="idIdentificacion"
                                    style="width: 200px" required>
                                <option value="0">Selecciona Uno</option>
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
                            <input type="text" name="numIdentificacion" class="inputCliente"
                                   id="idNumIdentificacion"
                                   style="width: 200px"
                                   required/>
                        </td>
                        <td>
                            <input type="text" name="fechaNac" id="idFechaNac" style="width: 100px" class="calendarioMod"
                                   required placeholder="AAAA/MM/DD" />
                        </td>
                        <td>
                            <input type="text" name="correo" id="idCorreo" style="width: 200px"
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
                            <input type="text" class="inputCliente" name="rfc" id="idRfc"
                                   placeholder=""
                                   style="width: 200px"/>
                        </td>
                        <td>
                            <input type="text" class="inputCliente" name="curp" id="idCurp"
                                   style="width: 200px"
                                   placeholder=""/>
                        </td>
                        <td>
                            <input type="text" name="celular" id="idCelular"
                                   onkeypress="return soloNumeros(event)"
                                   style="width: 200px" maxlength="11"
                                   required/>
                        </td>
                        <td>
                            <input type="text" name="telefono" id="idTelefono"
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
                            <select id="idEstado" name="estadoName" class="selectpicker"  style="width:155px">
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
                            <select id="idMunicipio" name="municipioName" class="selectpicker"  style="width:200px" disabled>
                            </select>
                        </td>
                        <td>
                            <select id="idLocalidad" name="localidadName" class="selectpicker"  style="width:200px" disabled>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="inputCliente" name="calle" placeholder=""
                                   id="idCalle"
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
                                   id="idCP" style="width: 100px" required/>
                        </td>
                        <td>
                            <input type="text" name="numExt" placeholder=""
                                   onkeypress="return soloNumeros(event)"
                                   id="idNumExt" style="width: 50px" required/>
                        </td>
                        <td>
                            <input type="text" name="numInt" placeholder="" id="idNumInt"
                                   style="width: 150px"/>
                        </td>
                        <td>
                            <input type="text" name="numInt" placeholder="" id="idOcupacion"
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
                                      id="idMensajeInterno"
                                      rows="3" cols="80"></textarea>
                        </td>
                        <td style="vertical-align:top;">
                            <select type="text" name="promocion" placeholder="Selecciona:"
                                    class="selectpicker"
                                    id="idPromocion" style="width: 150px">
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
        <div align="right">
            <input type="button" class="btn btn-primary" onclick="agregarCliente()"
                   value="Guardar">
        </div>
    </div>
</form>

</body>
</html>
