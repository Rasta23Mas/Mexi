<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");
if (!isset($_SESSION)) {
    session_start();
}
$tipoUsuario = $_SESSION['tipoUsuario'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/css" src="../../JavaScript/funcionesGenerales.js"></script>

</head>
<body>
<div class="modal fade " id="modalArticulos" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Electrónicos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <table width="100%">
                            <tr>
                                <td>
                                    <label>Tipo:</label>&nbsp;
                                    <img src="../../style/Img/mas.png"  data-toggle="modal"
                                         data-target="#modalAgregarTipo" alt="Agregar Tipo">
                                </td>
                                <td>
                                    <label>Marca:</label>&nbsp;
                                    <img src="../../style/Img/mas.png"  data-toggle="modal"
                                         data-target="#modalAgregarMarca" alt="Agregar Marca" onclick="cargarTipoModal()">
                                </td>
                                <td>
                                    <label>Modelo:</label>&nbsp;
                                    <img src="../../style/Img/mas.png"  data-toggle="modal"
                                         data-target="#modalAgregarModelo" alt="Agregar Modelo"  onclick="cargarMarcaModal()">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select id="idTipoSelect" name="tipoElect" class="selectpicker"  style="width:200px" onchange="llenarComboMarcaE();">
                                    </select>
                                </td>
                                <td>
                                    <select id="idMarcaSelect" name="marcaElect" class="selectpicker"  style="width:200px" disabled onchange="llenarComboModeloE();">
                                    </select>
                                </td>
                                <td>
                                    <select id="idModeloSelect" name="modeloElect" class="selectpicker"  style="width:200px" disabled
                                            onchange="cargarTblProducto($('#idTipoSelect').val(),$('#idMarcaSelect').val(),$('#idModeloSelect').val())">
                                    </select>
                                </td>
                                <td>
                                    <input type="button" class="btn btn-success" data-toggle="modal"
                                           data-target="#modalAgregarProducto"
                                           onclick="cargarProductoModal()"  value="Agregar" />
                                    <input type="text" id="idCatalogoEnviar" name="catalogo" size="5" value="2"
                                           style="text-align:center" class="invisible"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="table table-hover table-condensed table-bordered" width="100%">
                            <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Precio</th>
                                <th>Vitrina</th>
                                <th>Caracteristicas</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                                <th>Seleccionar</th>
                            </tr>
                            </thead>
                            <tbody id="cargarTblProducto">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-warning w-23" data-dismiss="modal"
                           value="Salir">
                </div>

            </div>
        </div>
    </div>


</body>
</html>
