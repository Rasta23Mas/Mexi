<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");
?>

<table class="table table-hover table-condensed table-bordered" width="100%">
    <thead  style="background: dodgerblue; color:white;">
    <tr align="center">
        <th>Código</th>
        <th>Articulo</th>
        <th>Vitrina</th>
        <th>Vitrina Final</th>
        <th>Fotos</th>
    </tr>
    </thead>
    <tbody id="idTBodyVentaDetalle">
    </tbody>
</table>