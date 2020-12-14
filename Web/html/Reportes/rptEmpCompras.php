<style>
    .letraChica {
        font-size: .8em;
    }
</style>
<table class="table table-hover table-condensed table-bordered letraChica" width="100%">
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
    </tr>
    </thead>
    <tbody id="idTBodyCompras" class="letraChica" align="center">
    </tbody>
</table>
<table class="table table-hover table-condensed table-bordered letraChica" width="100%">
    <tr align="center" class="titleTable">
        <td align="right"><b>Total Compras:<b>&nbsp;&nbsp; <label id="totalCompras"></label></td>
        <td align="right"><b>Total Precio Venta:<b>&nbsp;&nbsp; <label id="totalPrecio"></label></td>
        <td align="right"><b>Total Utilidad:<b>&nbsp;&nbsp; <label id="totalUtilidad"></label></td>
    </tr>
</table>
<div class="col-md-12 text-center">
    <ul class="pagination" id="paginador"></ul>
</div>