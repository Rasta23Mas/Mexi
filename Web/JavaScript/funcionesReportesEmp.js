function cargarRptRefrendo() {
    var NumMetal = 0;
    var NumElect = 0;
    var dataEnviar = {
        "tipoReporte": 1,
    };
    $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Reportes/tblReportes.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var htmlMetal = '';
                var htmlElectronicos = '';
                var i = 0;

                alert("Refrescando tabla.");
                for (i; i < datos.length; i++) {
                    var FECHA = datos[i].FECHA;
                    var FECHAMOV = datos[i].FECHAMOV;
                    var FECHAVEN = datos[i].FECHAVEN;
                    var CONTRATO = datos[i].CONTRATO;
                    var FOLIO = datos[i].FOLIO;
                    var PRESTAMO = datos[i].PRESTAMO;
                    var INTERESES = datos[i].INTERESES;
                    var ALMACENAJE = datos[i].ALMACENAJE;
                    var SEGURO = datos[i].SEGURO;
                    var ABONO = datos[i].ABONO;
                    var DESCU = datos[i].DESCU;
                    var IVA = datos[i].IVA;
                    var COSTO = datos[i].COSTO;
                    var FORMU = datos[i].FORMU;

                    FORMU = parseInt(FORMU)
                    FECHA = fechaFormato(FECHA)
                    FECHAMOV = fechaFormato(FECHAMOV)
                    FECHAVEN = fechaFormato(FECHAVEN)

                    INTERESES = parseFloat(INTERESES);
                    ALMACENAJE = parseFloat(ALMACENAJE);
                    SEGURO = parseFloat(SEGURO);
                    ABONO = parseFloat(ABONO);
                    COSTO = parseFloat(COSTO);
                    DESCU = parseFloat(DESCU);
                    IVA = parseFloat(IVA);

                    var SubTotal = INTERESES + ALMACENAJE + SEGURO + ABONO + COSTO;
                    SubTotal = SubTotal - DESCU;
                    var Total = SubTotal + IVA;
                    PRESTAMO = formatoMoneda(PRESTAMO);
                    INTERESES = formatoMoneda(INTERESES);
                    ALMACENAJE = formatoMoneda(ALMACENAJE);
                    SEGURO = formatoMoneda(SEGURO);
                    ABONO = formatoMoneda(ABONO);
                    DESCU = formatoMoneda(DESCU);
                    IVA = formatoMoneda(IVA);
                    COSTO = formatoMoneda(COSTO);
                    SubTotal = formatoMoneda(SubTotal);
                    Total = formatoMoneda(Total);
                    htmlMetal = '<tr>' +
                        '<td >' + FECHA + '</td>' +
                        '<td>' + FECHAMOV + '</td>' +
                        '<td>' + FECHAVEN + '</td>' +
                        '<td>' + CONTRATO + '</td>' +
                        '<td>' + FOLIO + '</td>' +
                        '<td>' + PRESTAMO + '</td>' +
                        '<td>' + INTERESES + '</td>' +
                        '<td>' + ALMACENAJE + '</td>' +
                        '<td>' + SEGURO + '</td>' +
                        '<td> -- </td>' +
                        '<td> -- </td>' +
                        '<td>' + ABONO + '</td>' +
                        '<td>' + DESCU + '</td>' +
                        '<td>' + COSTO + '</td>' +
                        '<td>' + SubTotal + '</td>' +
                        '<td>' + IVA + '</td>' +
                        '<td>' + Total + '</td>';
                }
                $('#idTBodyRefrendo').html(htmlMetal);
            }
        }
    );
    $("#divMetales").load('rptEmpRefrendo.php');
}