<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");
?>

<table class="table table-hover table-condensed table-bordered" width="100%">
    <thead>
    <tr>
        <th>Tipo</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Préstamo</th>
        <th>Avalúo</th>
        <th>Observaciones</th>
        <th>Eliminar</th>
    </tr>
    </thead>
    <tbody id="idTBodyArticulos">
    </tbody>
</table>