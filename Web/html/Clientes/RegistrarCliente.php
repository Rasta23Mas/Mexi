<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Registro Clientes</title>
    <link rel="stylesheet" href="../../style/less/main.css"/>
    <link rel="stylesheet" href="../../style/css/bootstrap/bootstrap.css"/>
    <link href="../../style/css/magicsuggest/magicsuggest-min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../librerias/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../librerias/alertifyjs/css/alertify.css"/>
    <link rel="stylesheet" type="text/css" href="../../librerias/alertifyjs/css/themes/default.css"/>
    <script src="../../librerias/jquery/jquery-3.4.1.min.js"></script>
    <script src="../../librerias/bootstrap/js/bootstrap.js"></script>
    <script src="../../librerias/alertifyjs/alertify.js"></script>
    <script src="../../JavaScript/funcionesCatalogos.js"></script>
    <script src="../../JavaScript/funcionesCliente.js"></script>
    <script src="../../librerias/jquery/jquery.numeric.js" type="text/javascript"></script>
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <script src="js/bootstrap-datetimepicker.min.js"></script>

    <style type="text/css">
        .suggestions {
            box-shadow: 2px 2px 8px 0 rgba(0, 0, 0, .2);
            height: auto;
            position: absolute;
            top: 45px;
            z-index: 9999;
            width: 206px;
        }

        .suggestions .suggest-element {
            background-color: #EEEEEE;
            border-top: 1px solid #d6d4d4;
            cursor: pointer;
            padding: 8px;
            width: 100%;
            float: left;
        }
    </style>

    <script>
        $(document).ready(function () {
            //  $('.menuContainer').load('menu.php');
            $('.inputNumeric').numeric();
            $("#idFecNac").datepicker({
                changeMonth:true,
                changeYear: true
            });
        });
    </script>


</head>
<body>
<div class="menuContainer"></div>


<form id="idFormRegistro" autocomplete="off">
    <div id="conteiner" class="container">
        <div class="row">
            <br>
            <br>
        </div>
        <div class="row">
            <input id="idEstado" name="Estado" type="text" style="width: 5px" class="invisible"/>
            <input id="idMunicipio" name="municipio" type="text" style="width: 5px" class="invisible"/>
            <input id="idLocalidad" name="localidad" type="text" style="width: 5px" class="invisible"/>
            <br>
            <h2>Registrar Cliente</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <table>
                    <tr>
                        <td>Nombre(s):</td>
                        <td>Apellido Paterno:</td>
                        <td>Apellido Materno:</td>
                        <td>Fecha Nacimiento:</td>
                        <td>Sexo:</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="nombre" id="idNombre" placeholder="Nombres" style="width: 200px"
                                   required />
                        </td>
                        <td>
                            <input type="text" name="apPat" id="idApPat" placeholder="Apellido Paterno" style="width: 200px"
                                   required />
                        </td>
                        <td>
                            <input type="text" name="apMat" id="idApMat" placeholder="Apellido Materno" style="width: 200px" />
                        </td>
                        <td>
                            <input type="text" name="fechaNac" id="idFechaNac" style="width: 200px"
                                   required />
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
                            RFC:
                        </td>
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
                            <input type="text" name="rfc" id="idRfc" placeholder="" style="width: 200px" />
                        </td>
                        <td>
                            <input type="text"  name="curp" id="idCurp" style="width: 200px"  placeholder="" />
                        </td>
                        <td>
                            <input type="text" name="celular" id="idCelular" class="inputNumeric" style="width: 200px"
                                    required/>
                        </td>
                        <td>
                            <input type="text" name="telefono" id="idTelefono" class="inputNumeric" style="width: 200px"
                                   placeholder="N&uacute;mero con lada" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Correo Electr&oacute;nico:
                        </td>
                        <td>
                            Ocupacion:
                        </td>
                        <td>
                            Tipo de Identificaci&oacute;n:
                        </td>
                        <td>
                            No. Identificaci&oacute;n:
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="correo" id="idCorreo" style="width: 200px" placeholder=""/>
                        </td>
                        <td>
                            <select type="text" name="ocupacion" placeholder="Selecciona uno" id="idOcupacion"
                                    style="width: 200px" required>
                                <option value="22">Selecciona Uno</option>
                                <?php
                                $dataOcupaciones = array();
                                $sq = new sqlCatalogoDAO();
                                $dataOcupaciones = $sq->catOcupacionesLlenar();
                                for ($i = 0; $i < count($dataOcupaciones); $i++) {
                                    echo "<option value=" . $dataOcupaciones[$i]['id_Ocupacion'] . ">" . $dataOcupaciones[$i]['descripcion'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select type="text" name="identificacion" placeholder="Selecciona uno"
                                    id="idIdentificacion"
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
                            <input type="text" name="numIdentificacion" placeholder="" id="idNumIdentificacion"
                                   style="width: 200px"
                                   required/>
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
                            <input id="idEstadoName" name="estadoName" type="text" style="width: 200px"
                                   onkeypress="estadoAutocompletar()" placeholder="Buscar Estado..." required/>
                            <span class="input-group-btn"></span>
                            <div id="sugerenciaEstado" class="suggestions"></div>
                        </td>
                        <td>
                            <input id="idMunicipioName" name="municipioName" type="text" style="width: 200px"
                                   onkeypress="municipioAutocompletar()" placeholder="Buscar Municipio..." required/>
                            <span class="input-group-btn"></span>
                            <div id="sugerenciaMunicipio" class="suggestions"></div>
                        </td>
                        <td>
                            <input id="idLocalidadName" name="localidadName" type="text" style="width: 200px"
                                   onkeypress="localidadAutocompletar()" placeholder="Buscar Localidad..." required/>
                            <span class="input-group-btn"></span>
                            <div id="sugerenciaLocalidad" class="suggestions"></div>
                        </td>
                        <td>
                            <input type="text" name="calle" placeholder="" id="idCalle" style="width: 200px"
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
                            ¿Como se entero?
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="cp" placeholder=""  class="inputNumeric" id="idCP" style="width: 100px"  required/>
                        </td>
                        <td>
                            <input type="text" name="numExt" placeholder="" class="inputNumeric" id="idNumExt" style="width: 50px" required/>
                        </td>
                        <td>
                            <input type="text" name="numInt" placeholder="" id="idNumInt" style="width: 150px" />
                        </td>
                        <td>
                            <select type="text" name="promocion" placeholder="Selecciona:"
                                    id="idPromocion" style="width: 150px" >
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
                    <tr>
                        <td colspan="4">
                            Mensaje de uso interno:
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <textarea type="text" name="mensajeInterno" placeholder="" id="idMensajeInterno"
                                      rows="4" cols="80"
                                      ></textarea>
                        </td>
                        <td>
                            <input type="button" class="btn btn-outline-primary btn-lg" onclick="agregarCliente()"
                                   value="Guardar">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>


</body>
</html>
