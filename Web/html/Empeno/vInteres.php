<?php
session_start();
if(!isset($_SESSION["idUsuario"])){
    header("Location: ../index.php");
    session_destroy();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlInteresesDAO.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="../../style/less/main.css"/>
    <link rel="stylesheet" href="../../style/css/bootstrap/bootstrap.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="../../style/css/magicsuggest/magicsuggest-min.css" rel="stylesheet">
    <script language="JavaScript" type="text/JavaScript">
        function Seleccionar(tipoInteresValue) {
            if (tipoInteresValue != "null" || tipoInteresValue != 0) {
                var dataEnviar = {
                    "tipoInteresValue" : tipoInteresValue
                };
                $.ajax({
                    data: dataEnviar,
                    url: '../../../com.Mexicash/Controlador/Intereses.php',
                    type:'post',
                    dataType: "json",
                    beforeSend:function () {
                        $("#pperiodo").html("Procesando");
                    },
                    success:function (response) {
                        if(response.status == 'ok') {
//para asignar a input
                            $("#idTipoInteres").val(response.result.tipoInteres);
                            $("#idPeriodo").val(response.result.periodo);
                            $("#idPlazo").val(response.result.plazo);
                            $('#idTasaPorcen').val(response.result.tasa);
                            $('#idAlmPorcen').val(response.result.alm);
                            $('#idSeguroPorcen').val(response.result.seguro);
                            $('#idIvaPorcen').val(response.result.iva + " %");
                        }
                    },
                })
            }
        }
    </script>
</head>
<body>
<form name="formInteres" id="idFormInteres">
    <div class="col-4">
        <table class="table table-bordered border border-dark ">
            <thead class="thead-light">
            <tr>
                <th colspan="6" class="border border-dark">Contrato:</th>
                <th colspan="6" class="border border-dark">Vence:</th>
            </tr>
            </thead>
            <tbody class="text-body border" align="center">
            <tr>
                <td colspan="6" class="table-info border-dark">Tasa Interés</td>
                <td colspan="6" class="border border-dark">
                    <select id="tipoInteres" name="cmbTipoInteres" onChange="javascript:Seleccionar($('#tipoInteres').val());">
                        <option value="0">Seleccione:</option>
                        <?php

                        $data = array();

                        $sql = new sqlInteresesDAO();
                        $data = $sql->llenarCmbTipoInteres();
                        for ($i = 0; $i < count($data); $i++) {
                            echo "<option value=" . $data[$i]['id_interes'] . ">" . $data[$i]['tasa_interes'] . "</option>";
                        }
                        ?>
                    </select>


                </td>

            </tr>
            <tr>
                <td colspan="4" class="table-info border border-dark">Tipo Interés</td>
                <td colspan="4" class="table-info border border-dark">Periodo</td>
                <td colspan="4" class="table-info border border-dark">Plazo</td>
            </tr>
            <tr>
                <td colspan="4" class="border border-dark ">
                    <input type="text" id="idTipoInteres" name="tipoInteres" size="20" style="text-align:center" disabled/>
                </td>
                <td colspan="4" class="border border-dark">
                    <input type="text" id="idPeriodo" name="periodo" size="20" style="text-align:center" disabled/>
                </td>
                <td colspan="4" class="border border-dark">
                    <input type="text" id="idPlazo" name="plazo" size="6"  style="text-align:center" disabled/>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="table-info border border-dark ">% Tasa</td>
                <td colspan="3" class="table-info border border-dark">% Alm.</td>
                <td colspan="3" class="table-info border border-dark">% Seguro</td>
                <td colspan="3" class="table-info border border-dark">% I.V.A.</td>
            </tr>
            <tr>
                <td colspan="3" class="border border-dark">
                    <input type="text" id="idTasaPorcen" name="tasaPorcen" size="6"  style="text-align:center" disabled/>

                </td>
                <td colspan="3" class="border border-dark">
                    <input type="text" id="idAlmPorcen" name="almPorcen" size="6"  style="text-align:center" disabled/>

                </td>
                <td colspan="3" class="border border-dark">
                    <input type="text" id="idSeguroPorcen" name="seguroPorcen" size="6"  style="text-align:center" disabled/>

                </td>
                <td colspan="3" class="border border-dark">
                    <input type="text" id="idIvaPorcen" name="ivaPorcen" size="6"  style="text-align:center" disabled/>

                </td>
            </tr>
            <tr>
                <td colspan="6" class="table-info border border-dark">Total Avalúo</td>
                <td colspan="6" class="table-info border border-dark">Total Préstamo</td>
            </tr>
            <tr>
                <td colspan="6" class="border border-dark">
                    <input type="text" id="idTotalAvaluo" name="totalAvaluo" size="9" value="0.00" style="text-align:center" disabled/>
                </td>
                <td colspan="6" class="border border-dark">
                    <input type="text" id="idTotalPrestamo" name="totalPrestamo" size="9" value="0.00" style="text-align:center" disabled/>
                </td>
            </tr>

            </tbody>
        </table>
    </div>
</form>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="../../style/css/magicsuggest/magicsuggest-min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>
</html>
