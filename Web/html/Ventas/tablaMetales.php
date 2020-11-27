<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlArticulosDAO.php");
?>
<style>
    .letraExtraChica {
        font-size: .8em;
    }
</style>
<table class="table table-hover table-condensed table-bordered letraExtraChica" width="80%">
    <thead style="background: dodgerblue; color:white;">
    <tr>
        <th colspan="10"  style="text-align: center">Consulta de Artículos</th>
    </tr>
    <tr>
        <th>Código</th>
        <th>Contrato</th>
        <th>Artículo</th>
        <th>Tipo</th>
        <th>Precio Empeño</th>
        <th>Precio Avaluo</th>
        <th>Precio Vitrina</th>
        <th>Descripción</th>
        <th>Agregar</th>
        <th>Editar</th>
    </tr>
    </thead>
    <tbody id="idTBodyMetales" >
    </tbody>
</table>
<div class="col-md-12 text-center">
    <ul class="pagination" id="paginador"></ul>
</div>