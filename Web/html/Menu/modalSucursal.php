<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/css" src="../../JavaScript/funcionesGenerales.js"></script>
</head>
<body>
<div class="modal fade " id="modalSucursal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seleccione la sucursal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" align="center">
                    <table width="100%" >
                        <tr>
                            <td align="left">
                                <label>Sucursal:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                           <select id="idSucursalSelect" name="cmbVehiculo" class="selectpicker">
                               <option value="0">Seleccione:</option>
                               <option value="1">CANTIL</option>
                               <option value="2">JAMAICA</option>
                           </select>
                            </td>
                        </tr>
                    </table>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-success " data-dismiss="modal"
                       onclick="fnLoginAdministradores($('#idSucursalSelect').val());"  value="Continuar">

            </div>
        </div>
    </div>
</div>
</body>
</html>
