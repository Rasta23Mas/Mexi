<style>
    .letraChica {
        font-size: .8em;
    }
</style>
<table class="table table-hover table-condensed table-bordered letraChica" width="100%">
    <thead style="background: dodgerblue; color:white;">
    <tr align="center">
        <th>Venta</th>
        <th>Fecha Venta</th>
        <th>Subtotal</th>
        <th>Descuento</th>
        <th>Total</th>
        <th>Prestamo</th>
        <th>Utilidad</th>
        <th>Usuario</th>
    </tr>
    </thead>
    <tbody id="idTBodyVentas" class="letraChica" align="center">
    </tbody>
</table>
<table class="table table-hover table-condensed table-bordered letraChica" width="100%">
    <tr align="center" class="titleTable">
        <td align="right"><b>Total Ventas:<b>&nbsp;&nbsp; <label id="totalVentas"></label></td>
    </tr>
</table>
<div class="col-md-12 text-center">
    <ul class="pagination" id="paginador"></ul>
</div>