function Contrato_Mov(mov_contrato,mov_fechaVencimiento,mov_fechaAlmoneda,mov_prestamo_actual,mov_prestamo_nuevo,mov_descuentoApl,mov_descuentoTotal,
                      mov_abonoTotal,mov_capitalRecuperado,mov_pagoDesempeno,mov_abono,mov_intereses,mov_interes,mov_almacenaje,mov_seguro,
                      mov_moratorios,mov_iva,mov_gps,mov_poliza,mov_pension,mov_costoContrato,mov_tipoContrato,mov_tipoMovimiento,mov_Informativo,
                      mov_subtotal,mov_total,mov_efectivo,mov_cambio) {

    var dataEnviar = {
        "id_contrato": mov_contrato,
        "fechaVencimiento": mov_fechaVencimiento,
        "fechaAlmoneda": mov_fechaAlmoneda,
        "prestamo_actual": mov_prestamo_actual,
        "s_prestamo_nuevo": mov_prestamo_nuevo,
        "s_descuento_aplicado": mov_descuentoApl,
        "descuentoTotal": mov_descuentoTotal,
        "abonoTotal": mov_abonoTotal,
        "e_capital_recuperado": mov_capitalRecuperado,
        "e_pagoDesempeno": mov_pagoDesempeno,
        "e_abono": mov_abono,
        "e_intereses": mov_intereses,
        "e_interes": mov_interes,
        "e_almacenaje": mov_almacenaje,
        "e_seguro": mov_seguro,
        "e_moratorios": mov_moratorios,
        "e_iva": mov_iva,
        "e_gps": mov_gps,
        "e_poliza": mov_poliza,
        "e_pension": mov_pension,
        "e_costoContrato": mov_costoContrato,
        "tipo_Contrato": mov_tipoContrato,
        "tipo_movimiento": mov_tipoMovimiento,
        "prestamo_Informativo": mov_Informativo,
        "pag_subtotal": mov_subtotal,
        "pag_total": mov_total,
        "pag_efectivo": mov_efectivo,
        "pag_cambio": mov_cambio,

    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Movimientos/movimientosContrato.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                alertify.success("Contrato guardado.");
            } else if (response==-7){
                alertify.error("Error al actualizar las fechas del contrato.");
            } else {
                alertify.error("Error en al conectar con el servidor. (FEErr06)");
            }
        }
    });
}