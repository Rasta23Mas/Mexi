<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");
?>

<table class="table table-hover table-condensed table-bordered" width="100%">
    <thead>
    <tr>
        <th>Folio</th>
        <th>Artículo</th>
        <th>Seleccionar</th>
    </tr>
    </thead>
    <tbody id="idTBodyApartado">
    </tbody>
</table>