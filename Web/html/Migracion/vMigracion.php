<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

include_once(HTML_PATH . "Compras/modalRegistroVendedor.php");
include_once(HTML_PATH . "Compras/modalEditarVendedor.php");
include_once(HTML_PATH . "Compras/modalBusquedaVendedor.php");
include_once(HTML_PATH . "Compras/modalCompras.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Menu.php');

$sucursal = $_SESSION['sucursal'];



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Generales-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compras</title>
    <!--Funciones-->
    <script src="../../JavaScript/funcionesMigracion.js"></script>
    <script src="../../JavaScript/funcionesIntereses.js"></script>
    <script src="../../JavaScript/funcionesVendedor.js"></script>
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script src="../../JavaScript/funcionesMovimiento.js"></script>
    <script src="../../JavaScript/funcionNumerosLetras.js"></script>
    <!--    Script inicial-->
    <script type="application/javascript">
        $(document).ready(function () {
            $("#idFormCompras").trigger("reset");
            $("#btnEditar").prop('disabled', true);
            $("#btnCompra").prop('disabled', true);
            fnSelectPrendaCompras();
            fnLlenarComboTipoElec();
           // fnArticulosObsoletosCom();
            //alert(sucursal)
        })
    </script>
    <style type="text/css">
        #suggestionsNombreEmpeno {
            box-shadow: 2px 2px 8px 0 rgba(0, 0, 0, .2);
            height: auto;
            position: absolute;
            top: 105px;
            z-index: 9999;
            width: 300px;
        }

        #suggestionsNombreEmpeno .suggest-element {
            background-color: #EEEEEE;
            border-top: 1px solid #d6d4d4;
            cursor: pointer;
            padding: 7px;
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
            font-size: .9em;
        }

    </style>
</head>
<body>
<form id="idFormCompras" name="formEmpeno">
    <div id="contenedor" class="container letraExtraChica">
        <div>
            <br>
        </div>
        <div>
            <center><h3>Migración</h3></center>
        </div>
        <div>
            <br>
        </div>
        <div class="row">
            <div class="col col-md-12 border-primary border" >
                <table width="100%"  >
                    <tr class="headt">
                        <td >Contrato:</td>
                        <td >
                            <input type="text" id="idContratoMig" name="contratoMigracion" size="8"
                                   onkeypress="return soloNumeros(event)"
                                   style="text-align:center"/>
                        </td>
                        <td colspan="2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                       id="idCheckCompra" onclick="fnCheckCompra();">
                                <label class="form-check-label" for="exampleCheck1">
                                    Es Compra?</label>
                            </div>
                        </td>
                        <td >Folio Migración:</td>
                        <td >
                            <input type="text" id="idFolioMig" name="folioMig" size="14"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="text-align:center"/></td>
                        <td>&nbsp;
                            <label class="form-check-label">
                                <input type="radio" name="migracionDe" id="idMetalesRadio"
                                       onclick="radioMetal()">
                                Metales&nbsp;</label>
                        </td>
                        <td>&nbsp;
                            <label class="form-check-label">
                                <input type="radio" name="migracionDe" id="idElectroRadio"
                                       onclick="radioElect()">
                                Electrónicos&nbsp;</label>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td >Tipo:</td>
                        <td >
                            <select id="idTipoMetal" name="cmbTipoMetal" class="selectpicker"
                                    onchange="fnSelectMetalCmb($('#idTipoMetal').val())"
                                    style="width: 150px">
                            </select>
                        </td>
                        <td>Kilataje:</td>
                        <td >
                            <select id="idKilataje" name="cmbKilataje" class="selectpicker"
                                    style="width: 150px" onchange="fnLlenaPrecioKilataje()">
                            </select>
                        </td>
                        <td >Calidad:</td>
                        <td >
                            <select id="idCalidad" name="cmbCalidad" class="selectpicker"
                                    style="width: 150px">
                            </select>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                    <tr class="headt">
                        <td >Cantidad:</td>
                        <td >
                            <input type="text" id="idCantidad" name="cantidad" size="5"
                                   onkeypress="return soloNumeros(event)" placeholder="0"
                                   style="text-align:center"/>
                        </td>
                        <td>Peso:</td>
                        <td >
                            <input type="text" id="idPeso" name="peso" size="4"
                                   onkeypress="return isNumberDecimal(event)" placeholder="0"
                                   style="text-align:center"/>
                            <label>grs</label></td>
                        <td >Piedras:</td>
                        <td >
                            <input type="text" id="idPiedras" name="piedras" size="5"
                                   onkeypress="return soloNumeros(event)" value="0"
                                   style="text-align:center"/>
                            <label>pza</label>
                        </td>
                        <td >Peso:</td>
                        <td >
                            <input type="text" id="idPesoPiedra" name="pesoPiedra" size="4" value="0"
                                   onkeypress="return isNumberDecimal(event)"
                                   style="text-align:center"/>
                            <label>grs</label></td>
                    </tr>
                    <tr>
                        <td>Tipo:</td>
                        <td>
                            <select id="idTipoElectronico" name="cmbTipoElectronico"
                                    class="selectpicker"
                                    onchange="fnCombMarcaVEmpe($('#idTipoElectronico').val())"
                                    style="width: 150px">
                            </select>
                            <img src="../../style/Img/lupa.png" data-toggle="modal"
                                 data-target="#modalArticulos" alt="Buscar"
                                 onclick="llenarComboTipoE();">
                        </td>
                        <td>Marca:</td>
                        <td>
                            <select id="idMarca" name="marcaSelect" class="selectpicker"
                                    style="width:150px" disabled
                                    onchange="fnCmbModeloVEmpe($('#idMarca').val());">
                            </select>
                        </td>
                        <td>Modelo:</td>
                        <td>
                            <select id="idModelo" name="modeloSelect" class="selectpicker"
                                    style="width:150px" disabled
                                    onchange="fnLlenarDatosElectronico($('#idTipoElectronico').val(),$('#idMarca').val(),$('#idModelo').val())">
                            </select>
                        </td>
                        <td>No.Serie:</td>
                        <td>
                            <input type="text" id="idSerie" name="serie" size="18"
                                   style="text-align:left" value=""/>
                        </td>
                    <tr>
                    <tr id="trIMEI">
                        <td >IMEI:</td>
                        <td >
                            <input type="text" id="idIMEI" name="imei" size="18"
                                   style="text-align:left" value=""/>
                        </td>
                    </tr>
                    <tr class="headt">
                        <td>Prestamo Empeño:</td>
                        <td>
                            <input type="text" id="idPrestamoMig" name="vitrina" size="8"
                                   onkeypress="return soloNumeros(event)"
                                   style="text-align:center"/>
                        </td>
                        <td>Avaluo:</td>
                        <td>
                            <input type="text" id="idAvaluoMig" name="vitrina" size="8"
                                   onkeypress="return soloNumeros(event)"
                                   style="text-align:center"/>
                        </td>
                        <td>Vitrina:</td>
                        <td>
                            <input type="text" id="idVitrinaMig" name="vitrina" size="8"
                                   onkeypress="return soloNumeros(event)"
                                   style="text-align:center"/>
                        </td>
                        <td colspan="2"></td>

                    </tr>
                    <tr class="headt">
                        <td colspan="2" align="left">Descripción de la prenda:
                        </td>
                        <td colspan="2">Observaciones de la tienda:
                            <input type="text" id="idKilatajePrecio" name="kilatajePrecio" size="6"
                                   value="0"
                                   class="invisible" disabled/></td>
                    </tr>
                    <tr class="headt">
                        <td colspan="2" name="detallePrenda">
                            <p>
                            <textarea name="detalle" id="idDetallePrenda"
                               class="textArea" rows="1" cols="40"></textarea></p>
                        </td>
                        <td colspan="2">
                            <p><textarea name="mensaje" id="idObs"
                               class="textArea" rows="1" cols="40"></textarea></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" align="right">
                            <input type="button" class="btn btn-success" value="Agregar" onclick="fnAgregarArtCompra()">&nbsp;
                            <input type="button" class="btn btn-warning" value="Limpiar" onclick="fnLimpiarCompra()">&nbsp;
                            <input type="button" id="btnCompra" class="btn btn-primary" value="Migrar" onclick="fnValidaciones()">&nbsp;

                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12">
                <br>
            </div>
        </div>
        <div class="row">
            <div id="divTablaArticulos" class="col col-md-12">
                <table class="table table-hover table-condensed table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th>Serie</th>
                        <th>Descripción</th>
                        <th>Observaciones</th>
                        <th>Precio Compra</th>
                        <th>Vitrina</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody id="idTBodyArticulos">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>

</body>
</html>
