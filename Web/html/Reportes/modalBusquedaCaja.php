<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCatalogoDAO.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Busqueda Caja</title>
    <script src="../../JavaScript/funcionesCierres.js"></script>
</head>
<body>
<div class="modal fade" id="modalCierreCaja" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ver todos los cierres de caja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <table class="table table-hover table-condensed table-bordered" width="100%">
                        <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Caja</th>
                            <th>Cierre Sucursal</th>
                            <th>Usuario</th>
                            <th>Cerrado Por Gerente</th>
                            <th>Fecha</th>
                            <th>Imprimir</th>
                        </tr>
                        </thead>
                        <tbody id="idCierreCajaModal">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-danger" data-dismiss="modal"
                       value="Salir">
            </div>
        </div>
    </div>
</div>
</body>
</html>
