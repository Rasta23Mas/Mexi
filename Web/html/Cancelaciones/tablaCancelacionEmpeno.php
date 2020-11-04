<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");
?>

<table class="table table-hover table-condensed table-bordered" width="100%">
    <thead style="background: dodgerblue; color:white;">
    <tr align="center">
        <th>Contrato</th>
        <th>Creación</th>
        <th>Movimiento</th>
        <th>Folio</th>
        <th>Prestamo</th>
        <th>Abono</th>
        <th>Pago</th>
        <th>Interes</th>
        <th>Moratorios</th>
        <th>Costo Contrato</th>
        <th>Descuento</th>
        <th>Plazo</th>
        <th>Cancelar</th>
    </tr>
    </thead>
    <tbody id="idTBodyCancelaciones" class="letraExtraChica" align="center">
    </tbody>
</table>