<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

include_once(SQL_PATH . "sqlUsuarioDAO.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/Menu.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Generales-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ventas</title>
    <!--Funciones-->
    <script src="../../JavaScript/funcionesCliente.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionesVentasModPrecio.js"></script>
    <script type="application/javascript">
        $(document).ready(function () {
           // $("#divTablaMetalesModP").load('tablaMetalesModPrecio.php');
        })
    </script>
    <style type="text/css">
        .letraExtraChica {
            font-size: .8em;
        }

        .headt td {
            height: 35px;
        }

        .tablaArticulos {
            font-size: .9em;
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
            <div class="col col-md-12 border border-primary"  >
                <table border="0" width="100%" >
                    <tbody>
                    <tr >
                        <td colspan="2">
                            <label for="nombreCliente">Codigo:</label>
                        </td>
                        <td colspan="10">
                                <br>
                        </td>
                    </tr>
                    <tr >
                        <td colspan="4">
                            <input id="idCodigoMostrador" name="codigo" type="text" style="width: 130px" value=""
                                   onkeypress="return busquedaCodigoMostradorModP(event)"/>
                            &nbsp;&nbsp;
                            <input type="button" class="btn btn-primary" value="Buscar" id="btnBuscarCodigo" onclick="fnLlenaReportMostradorModP()">&nbsp;
                        </td>
                        <td colspan="8">

                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <br>
                        </td>
                    </tr>
                    <tr >
                        <td colspan="2">
                            <label>Artículo:</label>
                        </td>
                        <td colspan="2">
                            <label>Precio Actual:</label>
                        </td>
                        <td colspan="2">
                            <label>Modificación:</label>
                        </td>
                        <td colspan="3">
                            <label>Código de Autorización:</label>
                        </td>
                        <td colspan="3">

                        </td>
                    </tr>
                    <tr >
                        <td colspan="2">
                            <input type="text" name="articulo"  id="idArticuloNew"
                                   style="width: 120px; text-align: right " disabled/>
                        </td>
                        <td colspan="2">
                            <input type="text" name="precioActual"  id="idPrecioActualNew"
                                   style="width: 120px; text-align: right " disabled/>
                        </td>
                        <td colspan="2">
                            <input type="text" name="precioMod"  id="idPrecioModNew"
                                   style="width: 120px; text-align: right " disabled
                                   placeholder="$0.00"
                                   onkeypress="return isNumberDecimal(event)" />
                        </td>
                        <td colspan="3">
                            <input type="text" id="idCodigoAutModNew" name="codigoAut" size="20" disabled
                                   value="" style="text-align: center" class="inputMinus"/>
                        </td>
                        <td colspan="3">
                            <input type="button" class="btn btn-success " data-dismiss="modal" disabled
                                   onclick="editarPrecioNew();"  id="EditarPre" value="Editar">
                        </td>
                        <td colspan="2">

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12">
                <br>
            </div>
        </div>
        <div class="row">
            <div class="row">
                <div id="divTablaMetalesModP" class="col col-md-12 " class="tablaArticulos">
                    <table class="table table-hover table-condensed table-bordered letraExtraChica" width="100%">
                        <thead style="background: dodgerblue; color:white;">
                        <tr>
                            <th colspan="10"  style="text-align: center">Consulta de Artículos</th>
                        </tr>
                        <tr>
                            <th>Código</th>
                            <th>Contrato</th>
                            <th>Artículo</th>
                            <th>Tipo</th>
                            <th>Precio Empeño</th>
                            <th>Precio Avaluo</th>
                            <th>Precio Vitrina</th>
                            <th>Descripción</th>
                            <th>Editar</th>
                        </tr>
                        </thead>
                        <tbody id="idTBodyMetalesModPre" >
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center">
                    <ul class="pagination" id="paginador"></ul>
                </div>
            </div>
        </div>
    </div>
</form>

</body>
</html>
