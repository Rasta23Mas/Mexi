<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");
include_once(HTML_PATH . "Menu/menuHorario.php");
include_once(DESC_PATH . "modalTokenHorario.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>HORsARIO</title>
<script src="../../JavaScript/funcionesConfiguracion.js"></script>
<script src="../../JavaScript/funcionesGenerales.js"></script>


<script type="application/javascript">
    $(document).ready(function () {
        cargarHorario();
        $("#tipoUser").val(3);
    })
</script>
<style type="text/css">
    .titleTable {
        background: dodgerblue;
        color: white;
    }
</style>
<body>
<form id="idFormEmpeno" name="formEmpeno">
    <div class="container-fluid">
        <div>
            <br>
        </div>
        <div>
            <br>
        </div>
        <div>
            <br>
        </div>
        <div class="row">
            <div class="col-12">
                <table width="80%" border="0" align="center">
                    <tr>
                        <br>
                    </tr>
                    <tr>
                        <td align="center" style="width: 700px;">
                            <table class="table-bordered border-primary" width="70%">
                                <tr style="background: dodgerblue; color:white;">
                                    <td align="center" colspan="2">
                                        <label>HORARIO</label>
                                    </td>
                                    <td align="center" colspan="2">
                                        <label>ENTRADA</label>
                                    </td>
                                    <td align="center" colspan="2">
                                        <label>SALIDA</label>
                                    </td>
                                    <td align="center" colspan="2">
                                        <label>ACTIVO</label>
                                    </td>
                                    <td align="center" colspan="2">
                                        <label>EDITAR</label>
                                    </td>
                                    <td align="center" colspan="2">
                                        <label>GUARDAR</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label>LUNES</label></td>
                                    <td colspan="2" align="center" >
                                        <input type="time" name="hora" step="3600"
                                               id="lunesEntrada" disabled/>

                                    </td>
                                    <td colspan="2" align="center">
                                        <input type="time" name="hora"  step="3600"
                                               id="lunesSalida" disabled/>
                                    </td>
                                    <td colspan="2" align="center">
                                        <input type="checkbox" id="checkLunes" value="LUNES" checked disabled>
                                    </td>
                                    <td colspan="2" align="center" >
                                        <img src="../../style/Img/editarNor.jpg" alt="Editar" onclick="editarHorario(1)">
                                    </td>
                                    <td colspan="2" align="center" >
                                        <input type="button" class="btn btn-success" id="btnGuardarLun" value="Guardar" onclick="validarHorario(1)" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label>MARTES</label></td>
                                    <td colspan="2" align="center" >
                                        <input type="time" name="hora"  step="3600"
                                               id="martesEntrada" disabled/>
                                    </td>
                                    <td colspan="2" align="center">
                                        <input type="time" name="hora" step="3600"
                                               id="martesSalida" disabled/>
                                    </td>
                                    <td colspan="2" align="center">
                                        <input type="checkbox" id="checkMartes" value="MARTES" checked disabled>
                                    </td>
                                    <td colspan="2" align="center" >
                                        <img src="../../style/Img/editarNor.jpg" alt="Editar" onclick="editarHorario(2)">
                                    </td>
                                    <td colspan="2" align="center" >
                                        <input type="button" class="btn btn-success" id="btnGuardarMar" value="Guardar" onclick="validarHorario(2)" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label>MIERCOLES</label></td>
                                    <td colspan="2" align="center" >
                                        <input type="time" name="hora"  step="3600"
                                               id="miercolesEntrada" disabled/>
                                    </td>
                                    <td colspan="2" align="center">
                                        <input type="time" name="hora" step="3600"
                                               id="miercolesSalida" disabled/>
                                    </td>
                                    <td colspan="2" align="center">
                                        <input type="checkbox" id="checkMiercoles" value="MIERCOLES" checked disabled>
                                    </td>
                                    <td colspan="2" align="center">
                                        <img src="../../style/Img/editarNor.jpg" alt="Editar" onclick="editarHorario(3)">
                                    </td>
                                    <td colspan="2" align="center">
                                        <input type="button" class="btn btn-success" id="btnGuardarMie" value="Guardar" onclick="validarHorario(3)" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label>JUEVES</label></td>
                                    <td colspan="2" align="center" >
                                        <input type="time" name="hora"  step="3600"
                                               id="juevesEntrada" disabled/>
                                    </td>
                                    <td colspan="2" align="center" >
                                        <input type="time" name="hora"  step="3600"
                                               id="juevesSalida" disabled/>
                                    </td>
                                    <td colspan="2" align="center">
                                        <input type="checkbox" id="checkJueves" value="JUEVES" checked disabled>
                                    </td>
                                    <td colspan="2" align="center" >
                                        <img src="../../style/Img/editarNor.jpg" alt="Editar" onclick="editarHorario(4)">
                                    </td>
                                    <td colspan="2" align="center" >
                                        <input type="button" class="btn btn-success" id="btnGuardarJue" value="Guardar" onclick="validarHorario(4)" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label>VIERNES</label></td>
                                    <td colspan="2" align="center" >
                                        <input type="time" name="hora" step="3600"
                                               id="viernesEntrada" disabled/></td>
                                    <td colspan="2" align="center" >
                                        <input type="time" name="hora"  step="3600"
                                               id="viernesSalida" disabled/>
                                    </td>
                                    <td colspan="2" align="center">
                                        <input type="checkbox" id="checkViernes" value="VIERNES" checked disabled>
                                    </td>
                                    <td colspan="2" align="center" >
                                        <img src="../../style/Img/editarNor.jpg" alt="Editar" onclick="editarHorario(5)">
                                    </td>
                                    <td colspan="2" align="center">
                                        <input type="button" class="btn btn-success" id="btnGuardarVie" value="Guardar" onclick="validarHorario(5)" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label>SABADO</label></td>
                                    <td colspan="2" align="center" >
                                        <input type="time" name="hora"  step="3600"
                                               id="sabadoEntrada" disabled/></td>
                                    <td colspan="2" align="center">
                                        <input type="time" name="hora"  step="3600"
                                               id="sabadoSalida" disabled/>
                                    </td>
                                    <td colspan="2" align="center">
                                        <input type="checkbox" id="checkSabado" value="SABADO" checked disabled>
                                    </td>
                                    <td colspan="2" align="center" >
                                        <img src="../../style/Img/editarNor.jpg" alt="Editar" onclick="editarHorario(6)">
                                    </td>
                                    <td colspan="2" align="center" >
                                        <input type="button" class="btn btn-success" id="btnGuardarSab" value="Guardar" onclick="validarHorario(6)" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label>DOMINGO</label></td>
                                    <td colspan="2" align="center" >
                                        <input type="time" name="hora" step="3600"
                                               id="domingoEntrada" disabled/></td>
                                    <td colspan="2" align="center" >
                                        <input type="time" name="hora" step="3600"
                                               id="domingoSalida" disabled/>
                                    </td>
                                    <td colspan="2" align="center">
                                        <input type="checkbox" id="checkDomingo" value="DOMINGO" checked disabled>
                                    </td>
                                    <td colspan="2" align="center" >
                                        <img src="../../style/Img/editarNor.jpg" alt="Editar" onclick="editarHorario(7)">
                                    </td>
                                    <td colspan="2" align="center" >
                                        <input type="button" class="btn btn-success" id="btnGuardarDom" value="Guardar" onclick="validarHorario(7)" disabled>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="invisible">
                            <input type="text" name="tokenDes" id="tokenHorarioDes" style="width: 100px"
                                   disabled/>
                            <input type="text" name="token" id="idTokenHorario" style="width: 100px"
                                   disabled/>
                            <input type="text" name="tipoUser" id="tipoUser" style="width: 100px"
                                   disabled/>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</form>

</body>
</html>
