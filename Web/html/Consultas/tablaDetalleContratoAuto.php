<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");
?>

<table class="table table-hover table-condensed table-bordered" width="100%">
    <thead  style="background: dodgerblue; color:white;">
    <tr>
        <th>Num</th>
        <th>Auto</th>
        <th>Detalle</th>
        <th>Observacioness</th>
    </tr>
    </thead>
    <tbody id="idTBodyContratoDetalleAuto">
    </tbody>
</table>