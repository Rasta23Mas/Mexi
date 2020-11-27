<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlMovimientosDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');


$id_contrato = $_POST['id_contrato'];
$fechaVencimiento = $_POST['fechaVencimiento'];
$fechaAlmoneda = $_POST['fechaAlmoneda'];
$plazo = $_POST['plazo'];
$periodo = $_POST['periodo'];
$tipoInteres = $_POST['tipoInteres'];
$prestamo_actual = $_POST['prestamo_actual'];
$totalAvaluo = $_POST['totalAvaluo'];
$s_prestamo_nuevo = $_POST['s_prestamo_nuevo'];
$s_descuento_aplicado = $_POST['s_descuento_aplicado'];
$e_capital_recuperado = $_POST['e_capital_recuperado'];
$e_pagoDesempeno = $_POST['e_pagoDesempeno'];
$e_abono = $_POST['e_abono'];
$e_intereses = $_POST['e_intereses'];
$e_moratorios = $_POST['e_moratorios'];
$e_venta_mostrador = $_POST['e_venta_mostrador'];
$e_venta_iva = $_POST['e_venta_iva'];
$e_venta_apartados = $_POST['e_venta_apartados'];
$e_gps = $_POST['e_gps'];
$e_poliza = $_POST['e_poliza'];
$e_pension = $_POST['e_pension'];
$tipo_Contrato = $_POST['tipo_Contrato'];
$tipo_movimiento = $_POST['tipo_movimiento'];
$abonoFinal = $_POST['abonoFinal'];
$descuentoFinal = $_POST['descuentoFinal'];
$costo_Contrato = $_POST['costo_Contrato'];
$prestamo_Informativo = $_POST['prestamo_Informativo'];
$e_iva = $_POST['e_iva'];


$sqlMovimientos = new sqlMovimientosDAO();
$sqlMovimientos->insertarMovimiento(
    $id_contrato,
    $fechaVencimiento,
    $fechaAlmoneda,
    $plazo,
    $periodo,
    $tipoInteres,
    $prestamo_actual,
    $totalAvaluo,
    $s_prestamo_nuevo,
    $s_descuento_aplicado,
    $e_capital_recuperado,
    $e_pagoDesempeno,
    $e_abono,
    $e_intereses,
    $e_moratorios,
    $e_venta_mostrador,
    $e_venta_iva,
    $e_venta_apartados,
    $e_gps,
    $e_poliza,
    $e_pension,
    $tipo_Contrato,
    $tipo_movimiento,
    $abonoFinal,
    $descuentoFinal,
    $costo_Contrato,
    $prestamo_Informativo,
    $e_iva
);

?>

