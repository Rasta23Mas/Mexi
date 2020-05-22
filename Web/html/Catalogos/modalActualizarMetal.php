<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Actualizar Metal</title>
    <script src="../../JavaScript/funcionesCatalogos.js"></script>
</head>
<body>
<div class="modal fade" id="modalActualizarMetal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Guardar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <table class="table table-hover table-condensed table-bordered" width="100%">
                        <tr>
                            <td colspan="6">Tipo:</td>
                            <td colspan="6">
                                <input type="text" id="idTipoCatMetEditModal" name="metal" size="6"
                                       style="text-align:center" disabled/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">Unidad:</td>
                            <td colspan="6">
                                <input type="text" id="idUnidadEditModal" name="unidad" size="6"
                                       style="text-align:center" disabled/>
                            </td>
                        </tr>
                        <td colspan="6">Precio:</td>
                        <td colspan="6">
                            <input type="text" id="idPrecioEditModal" name="precio" size="6"
                                   style="text-align:center"/>
                        </td>
                        </tr>
                        <tr>
                            <input type="text" id="idKilatajeEditModal" name="metal" size="6"
                                   style="text-align:center" class="invisible"/>
                        </tr>
                    </table>

                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" data-dismiss="modal"
                       value="Guardar" onclick="actualizarMetal()">
            </div>
        </div>
    </div>
</div>
</body>
</html>
