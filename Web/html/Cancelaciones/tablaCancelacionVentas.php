<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");
?>
<style>
    .letraChica {
        font-size: .8em;
    }
</style>
<table class="table table-hover table-condensed table-bordered " width="100%">
    <thead style="background: dodgerblue; color:white;">
    <tr align="center">
        <th>Fecha Venta</th>
        <th>Contrato</th>
        <th>Serie</th>
        <th width="500px">Detalle</th>
        <th>Venta</th>
        <th>Descuento</th>
        <th>Tipo Adquisición</th>
        <th>Cancelar</th>
    </tr>
    </thead>
    <tbody id="idTBodyCancelacionesVentas" class="letraExtraChica" align="center">
    </tbody>
</table>