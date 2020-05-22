<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");
?>

<table class="table table-hover table-condensed table-bordered" width="80%">
    <thead>
    <tr>
        <th>Código</th>
        <th>Artículo</th>
        <th>Kilates</th>
        <th>Precio</th>
        <th>Precio Vitrina</th>
        <th>Observaciones</th>
        <th>Modificar</th>
    </tr>
    </thead>
    <tbody id="idTBodyMetales">
    </tbody>
</table>