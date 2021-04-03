<style>
    .letraChica {
        font-size: .8em;
    }
</style>
<table class="table table-hover table-condensed table-bordered letraChica" width="100%">
    <thead style="background: dodgerblue; color:white;">
    <tr align="center">
        <th>Fecha</th>
        <th>Fecha Mov.</th>
        <th>Contrato</th>
        <th>Préstamo</th>
        <th>Intereses</th>
        <th>Almacenaje</th>
        <th>Seguro</th>
        <th>Desc</th>
        <th>Costo C</th>
        <th>SubTotal</th>
        <th>Iva Int</th>
        <th>Total Cobrado</th>
    </tr>
    </thead>
    <tbody id="idTBodyDesempeno" class="letraChica" align="center">
    </tbody>
</table>
<table class="table table-hover table-condensed table-bordered letraChica" width="100%">
    <tr align="center" class="titleTable">
        <td align="right"><b>Total Prestamo:<b>&nbsp;&nbsp; <label id="totalPrestamo"></label></td>
        <td align="right"><b>Total Intereses:<b>&nbsp;&nbsp; <label id="totaltInteres"></label></td>
        <td align="right"><b>Total Alm:<b>&nbsp;&nbsp; <label id="totalAlmacenaje"></label></td>
        <td align="right"><b>Total Seguro:<b>&nbsp;&nbsp; <label id="totalSeguro"></label></td>
        <td align="right"><b>Total Desc:<b>&nbsp;&nbsp; <label id="totalDescuento"></label></td>
        <td align="right"><b>Total Costo:<b>&nbsp;&nbsp; <label id="totalCosto"></label></td>
        <td align="right"><b>Total Subtotal:<b>&nbsp;&nbsp; <label id="totalSubtotal"></label></td>
        <td align="right"><b>Total Iva:<b>&nbsp;&nbsp; <label id="totalIva"></label></td>
        <td align="right"><b>Total Cobrado:<b>&nbsp;&nbsp; <label id="totalCobrado"></label></td>
    </tr>
</table>
<div class="col-md-12 text-center">
    <ul class="pagination" id="paginador"></ul>
</div>