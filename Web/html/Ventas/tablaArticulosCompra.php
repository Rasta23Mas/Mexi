<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");
?>

<table class="table table-hover table-condensed table-bordered" width="80%">
    <thead style="background: green; color:white;">
    <tr align="center">
        <th colspan="7">Agregados al Carrito</th>
    </tr>
    <tr>
        <th>Código</th>
        <th>Contrato</th>
        <th>Artículo</th>
        <th>Precio Vitrina</th>
        <th>Prestamo</th>
        <th>Eliminar</th>
    </tr>
    </thead>
    <tbody id="idTBodyArticulosCarrito">
    </tbody>
</table>