<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlMovimientosDAO.php");


$id_contrato = $_POST['id_contrato'];
$fechaVencimiento = $_POST['fechaVencimiento'];
$fechaAlmoneda = $_POST['fechaAlmoneda'];
$prestamo_actual = $_POST['prestamo_actual'];
$s_prestamo_nuevo = $_POST['s_prestamo_nuevo'];
$s_descuento_aplicado = $_POST['s_descuento_aplicado'];
$descuentoTotal = $_POST['descuentoTotal'];
$abonoTotal = $_POST['abonoTotal'];
$e_capital_recuperado = $_POST['e_capital_recuperado'];
$e_pagoDesempeno = $_POST['e_pagoDesempeno'];
$e_abono = $_POST['e_abono'];
$e_intereses = $_POST['e_intereses'];
$e_interes = $_POST['e_interes'];
$e_almacenaje = $_POST['e_almacenaje'];
$e_seguro = $_POST['e_seguro'];
$e_moratorios = $_POST['e_moratorios'];
$e_iva = $_POST['e_iva'];
$e_gps = $_POST['e_gps'];
$e_poliza = $_POST['e_poliza'];
$e_pension = $_POST['e_pension'];
$costo_Contrato = $_POST['e_costoContrato'];
$tipo_Contrato = $_POST['tipo_Contrato'];
$tipo_movimiento = $_POST['tipo_movimiento'];
$prestamo_Informativo = $_POST['prestamo_Informativo'];
$pag_subtotal = $_POST['pag_subtotal'];
$pag_total = $_POST['pag_total'];
$pag_efectivo = $_POST['pag_efectivo'];
$pag_cambio = $_POST['pag_cambio'];

$idRefrendoMigracion = $_POST['idRefrendoMigracion'];





$sqlMovimientos = new sqlMovimientosDAO();
$sqlMovimientos->insertContratoMov($id_contrato,$fechaVencimiento,$fechaAlmoneda,$prestamo_actual,$s_prestamo_nuevo,
$s_descuento_aplicado,$descuentoTotal, $abonoTotal, $e_capital_recuperado, $e_pagoDesempeno, $e_abono, $e_intereses, $e_interes, $e_almacenaje,
$e_seguro, $e_moratorios, $e_iva, $e_gps, $e_poliza, $e_pension, $costo_Contrato, $tipo_Contrato, $tipo_movimiento, $prestamo_Informativo,
$pag_subtotal, $pag_total, $pag_efectivo, $pag_cambio,$idRefrendoMigracion);

?>

