<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");
?>

<table class="table table-hover table-condensed table-bordered" width="100%">
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Abono</th>
        <th>Saldo</th>
    </tr>
    </thead>
    <tbody id="idTBodyAbono">
    </tbody>
</table>