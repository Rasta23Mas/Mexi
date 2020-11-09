<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");
?>
<style>
    .letraChica {
        font-size: .8em;
    }
</style>
<table class="table table-hover table-condensed table-bordered" width="100%">
    <thead style="background: dodgerblue; color:white;">
    <tr align="center">
        <th>Bazar</th>
        <th>Contrato</th>
        <th>Serie</th>
        <th width="800px">Detalle</th>
        <th>Compra</th>
        <th>Venta</th>
        <th>Utilidad</th>
        <th>Tipo Adquisición</th>
        <th>Cancelar</th>
    </tr>
    </thead>
    <tbody id="idTBodyCancelacionesCompras" class="letraExtraChica" align="center">
    </tbody>
</table>