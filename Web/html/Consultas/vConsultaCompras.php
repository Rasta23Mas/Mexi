<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Menu.php');
include_once(SQL_PATH . "sqlClienteDAO.php");//ok

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Generales-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consulta</title>
    <!--Funciones-->
    <script src="../../JavaScript/funcionesConsultaCompras.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionesCalendario.js"></script>
    <script src="../../JavaScript/funcionesVendedor.js"></script>
    <link rel="stylesheet" type="text/css" href="../../librerias/jqueryui/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="../../librerias/jqueryui/jquery-ui.min.js"></script>

    <!--    Script inicial-->
    <script type="application/javascript">
        $(document).ready(function () {
            $("#idNombres").blur(function () {
                $('#suggestionsNombreEmpeno').fadeOut(500);
            });
      })
    </script>
    <style type="text/css">
        #suggestionsNombreEmpeno {
            box-shadow: 2px 2px 8px 0 rgba(0, 0, 0, .2);
            height: auto;
            position: absolute;
            top: 220px;
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
            text-align: left;
            text-transform: uppercase;
        }

        .headt td {
            height: 35px;
        }

        .inputCliente {
            text-transform: uppercase;
        }
        .letraExtraChica {
            font-size: .8em;
        }

    </style>
</head>
<body>

<form id="idFormConsulta" name="formConsulta">
    <div align="center">
            <table width="85%" border="0">
                <tr>
                    <td colspan="6">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="6" style=" color:darkblue; ">
                        <h3>Consulta Compras</h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        &nbsp;
                    </td>
                </tr>
                <tr style="background: dodgerblue; color:white; ">
                    <td style="border-style: solid; border-color: #80dfff;">
                        <label class="form-check-label">&nbsp;
                            <input type="radio" name="consultaPor" id="idVentaRadio" onclick="fnRadioVenta()">
                            Por Compra</label>
                    </td>
                    <td style="border-style: solid; border-color: #80dfff;" colspan="2">&nbsp;
                        <label class="form-check-label">
                            <input type="radio" name="consultaPor" id="idNombreRadio" onclick="fnRadioNombre()">
                            Por Nombre&nbsp;</label>
                    </td>
                    <td style="border-style: solid; border-color: #80dfff;" colspan="3">&nbsp;
                        <label class="form-check-label">
                            <input type="radio" name="consultaPor" id="idFechaRadio" onclick="fnRadioFecha()">
                            Por Fecha&nbsp;</label>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="width: 180px" class="border-primary border">
                        <label>Num. Compra:</label>
                        <input type="text" name="idVentaName" id="idVentaConsulta" style="width: 70px"
                               onkeypress="return fnEnterBusquedaCompra(event)" disabled/>
                    </td>
                    <td align="center" style="width: 120px" class="border-primary border border-right-0">
                        <label>Nombre:</label>
                    </td>
                    <td >
                        <div>
                            <input id="idNombreConsulta" name="Nombres" type="text" style="width: 300px"
                                   class="inputCliente" onkeypress="fnClienteAutoCompleteVen()"
                                   placeholder="Buscar Vendedor..." disabled/>
                        </div>
                        <div id="suggestionsNombreEmpeno"></div>
                    </td>
                    <td align="left" class="border-primary border" colspan="3">&nbsp;&nbsp;
                        <label>Rango de fechas:</label>
                        <input type="text" name="fechaInicial" id="idFechaInicial" style="width: 100px"
                               class="calendarioModBoton"
                               disabled/>
                        <label> a </label>
                        <input type="text" name="fechaFinal" id="idFechaFinal" style="width: 100px"
                               class="calendarioModBoton"
                               disabled/>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        &nbsp;
                    </td>
                </tr>
                <tr style="background: dodgerblue; color:white; ">
                    <td colspan="2" style="border-style: solid; border-color: #80dfff;">
                        <label>&nbsp;&nbsp;Datos del vendedor:</label>
                    </td>
                    <td colspan="4" style="border-style: solid; border-color: #80dfff;">
                        <label>&nbsp;&nbsp;Detalle de la compra:</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" name="direccionEmpeno"
                        class="border-primary border border-top-0 border-right-0 border-bottom-0">
                        &nbsp;&nbsp;<textarea rows="3" cols="35" id="idDireccionConsulta" class="textArea" disabled>
                    </textarea>
                    </td>
                    <td colspan="4"   class="border-primary border-right">
                        <div id="divDetallesVenta" class="col col-lg-12">
                            <table class="table table-hover table-condensed table-bordered" width="100%">
                                <thead  style="background: dodgerblue; color:white;">
                                <tr align="center">
                                    <th>Código</th>
                                    <th>Articulo</th>
                                    <th>Vitrina</th>
                                    <th>Vitrina Final</th>
                                    <th>Fotos</th>
                                </tr>
                                </thead>
                                <tbody id="idTBodyVentaDet">
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="border-primary border border-top-0 border-bottom-0">&nbsp;
                        <input type="button" class="btn btn-primary" id="btnBuscarConsulta" value="Buscar"
                               onclick="fnBusquedaVenta()" disabled>&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" class="btn btn-warning" id="btnLimpiarConsulta" value="Limpiar"
                               onclick="fnLimpiarConsultaV()">&nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="border-primary border border-top-0 ">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        &nbsp;
                    </td>
                </tr>
                <tr class="border-primary border">
                    <td colspan="6">
                        <br>
                        <div id="divVenta" class="col col-lg-12">
                            <table class="table table-hover table-condensed table-bordered" width="100%">
                                <thead style="background: dodgerblue; color:white;">
                                <tr align="center">
                                    <th>Num Venta</th>
                                    <th>Movimiento</th>
                                    <th>Creación</th>
                                    <th>Subtotal</th>
                                    <th>IVA</th>
                                    <th>Total</th>
                                    <th>Ver</th>
                                    <th>Imprimir</th>
                                </tr>
                                </thead>
                                <tbody id="idTBodyVenta" class="letraExtraChica" align="center">
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="visibility: hidden">
                        <input type="text" name="idCliente" id="idClienteConsulta" style="width: 70px"
                               disabled/>
                        <input type="text" name="idCliente" id="idVentaBusqueda" style="width: 70px"
                               disabled/>
                    </td>
                </tr>
            </table>
    </div>
</form>
</body>
</html>