function cargarRptRefrendo() {
        var dataEnviar = {
            "tipoReporte": 1,
        };
        $.ajax({
            type: "POST",
            url: '../../../com.Mexicash/Controlador/Contrato/tblDetalleFechas.php',
            data: dataEnviar,
            dataType: "json",
            success: function (datos) {
                var html = '';
                var htmlAuto = '';
                var htmlfinal = '';
                var i = 0;
                var Num = 1;
                alert("Refrescando tabla.");
                for (i; i < datos.length; i++) {
                    var Contrato = datos[i].Contrato;
                    var FechaCreacion = datos[i].FechaCreacion;
                    var Movimiento = datos[i].Movimiento;
                    var idMovimiento = datos[i].idMovimiento;
                    var Prestamo = datos[i].Prestamo;
                    var PrestamoActual = datos[i].PrestamoActual;
                    var Abono = datos[i].Abono;
                    var Interes = datos[i].Interes;
                    var Moratorios = datos[i].Moratorios;
                    var Descuento = datos[i].Descuento;
                    var Pago = datos[i].Pago;
                    var Plazo = datos[i].Plazo;
                    var CostoContrato = datos[i].CostoContrato;
                    var MovimientoTipo = datos[i].MovimientoTipo;

                    ContratoReimprimir = Contrato;
                    MovimientoReimprimir = idMovimiento;

                    Prestamo = formatoMoneda(Prestamo);
                    Abono = formatoMoneda(Abono);
                    Interes = formatoMoneda(Interes);
                    Moratorios = formatoMoneda(Moratorios);
                    Descuento = formatoMoneda(Descuento);
                    Pago = formatoMoneda(Pago);
                    CostoContrato = formatoMoneda(CostoContrato);


                    html = '<tr>' +
                        '<td >' + Contrato + '</td>' +
                        '<td>' + FechaCreacion + '</td>' +
                        '<td>' + Movimiento + '</td>' +
                        '<td>' + idMovimiento + '</td>' +
                        '<td>' + PrestamoActual + '</td>' +
                        '<td>' + Abono + '</td>' +
                        '<td>' + Pago + '</td>' +
                        '<td>' + Interes + '</td>' +
                        '<td>' + Moratorios + '</td>' +
                        '<td>' + CostoContrato + '</td>' +
                        '<td>' + Descuento + '</td>' +
                        '<td>' + Plazo + '</td>' +
                        '<td align="center">' +
                        '<img src="../../style/Img/seleccionarNor.png"  data-dismiss="modal" alt="Seleccionar"  onclick="buscarDatosPorFecha(' + Contrato + ')">' +
                        '</td>' +
                        '<td align="center">' +
                        '<img src="../../style/Img/impresoraNor.png"  data-dismiss="modal" alt="impromor" onclick="reimprimir(' + MovimientoTipo + ','+idMovimiento+','+ Contrato +')">' +
                        '</td>';
                    if (tipoContratoGlobal == 2) {
                        htmlAuto = '<td align="center"> ' +
                            '<img src="../../style/Img/docNor.png"  alt="Documentos" onclick="cargarPDFDocumentos(' + Contrato + ')">' +
                            '</td>';
                    }

                    htmlfinal += html + htmlAuto + '</tr>';
                    Num++;
                }

                if (tipoContratoGlobal == 2) {
                    $('#idTBodyContratoAuto').html(htmlfinal);
                } else {
                    $('#idTBodyContrato').html(htmlfinal);
                }
                var contrato = 0;
                var clienteEmpeno = 0;
                var BitfechaIni = nuevaFechaInicio;
                var BitfechaFin = nuevaFechaFinal;
                BitacoraUsuarioConsulta(contrato, clienteEmpeno, BitfechaIni, BitfechaFin);
            }
        });
        if (tipoContratoGlobal == 2) {
            $("#divContrato").load('tablaContratoAuto.php');
        } else {
            $("#divContrato").load('tablaContrato.php');
        }
}