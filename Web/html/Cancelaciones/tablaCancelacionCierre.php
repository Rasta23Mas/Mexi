<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");
?>

<table class="table table-hover table-condensed table-bordered" width="100%">
    <thead style="background: dodgerblue; color:white;">
    <tr align="center">
        <th>Num</th>
        <th>Caja</th>
        <th>Sucursal</th>
        <th>Salida</th>
        <th>Entrada</th>
        <th>Saldo Caja</th>
        <th>Efectivo Caja</th>
        <th>Ajustes</th>
        <th>Usuario</th>
        <th>Cerrado por Gerente</th>
        <th>Cancelar</th>
    </tr>
    </thead>
    <tbody id="idTBodyCancelacionesCierre" class="letraExtraChica" align="center">
    </tbody>
</table>