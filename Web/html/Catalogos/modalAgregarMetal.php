<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");
include_once(SQL_PATH . "sqlArticulosDAO.php");


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
<div class="modal fade" id="modalAgregarMetal" tabindex="-1" role="dialog"
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
                                <select id="idTipoMetalCatModal" name="cmbTipoMetal" class="selectpicker" style="width: 150px">
                                    <option value="0">Seleccione:</option>
                                    <?php
                                    $data = array();
                                    $sql = new sqlArticulosDAO();
                                    $data = $sql->llenarCmbTipoPrenda();
                                    for ($i = 0; $i < count($data); $i++) {
                                        echo "<option value=" . $data[$i]['id_tipo'] . ">" . $data[$i]['descripcion'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">Unidad:</td>
                            <td colspan="6">
                                <input type="text" id="idUnidadModal" name="unidad" size="6"
                                       style="text-align:center" />
                            </td>
                        </tr>
                        <td colspan="6">Precio:</td>
                        <td colspan="6">
                            <input type="text" id="idPrecioModal" name="precio" size="6"   onkeypress="return isNumberDecimal(event)"
                                   style="text-align:center"/>
                        </td>
                        </tr>
                    </table>

                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" data-dismiss="modal"
                       value="Guardar" onclick="guardarMetal()">
            </div>
        </div>
    </div>
</div>
</body>
</html>
