<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");


$dotacionesA_Caja = $_POST['dotacionesA_Caja'];
//$cantAportacionesBoveda = $_POST['cantAportacionesBoveda'];
//$aportaciones_Boveda = $_POST['aportaciones_Boveda'];
$cantDotaciones = $_POST['cantDotaciones'];
$dotacionesA_Caja = $_POST['dotacionesA_Caja'];
$cantCapitalRecuperado = $_POST['cantCapitalRecuperado'];
$capitalRecuperado = $_POST['capitalRecuperado'];
$cantAbono = $_POST['cantAbono'];
$abonoCapital = $_POST['abonoCapital'];
$cantInteres = $_POST['cantInteres'];
$intereses = $_POST['intereses'];
$cantIva = $_POST['cantIva'];
$iva = $_POST['iva'];
$cantMostrador = $_POST['cantMostrador'];
$mostrador = $_POST['mostrador'];
$cantIvaVenta = $_POST['cantIvaVenta'];
$iva_venta = $_POST['iva_venta'];
$cantApartados = $_POST['cantApartados'];
$apartadosVenta = $_POST['apartadosVenta'];
$cantAbonoVenta = $_POST['cantAbonoVenta'];
$abonoVentas = $_POST['abonoVentas'];
$cantGps = $_POST['cantGps'];
$gps = $_POST['gps'];
$cantPoliza = $_POST['cantPoliza'];
$poliza = $_POST['poliza'];
$cantPension = $_POST['cantPension'];
$pension = $_POST['pension'];
$cantRetiros = $_POST['cantRetiros'];
$retirosCaja = $_POST['retirosCaja'];
$cantPrestamos = $_POST['cantPrestamos'];
$prestamosNuevos = $_POST['prestamosNuevos'];
$cantDescuentos = $_POST['cantDescuentos'];
$descuentosAplicados = $_POST['descuentosAplicados'];
$cantDescuentosVentas = $_POST['cantDescuentosVentas'];
$descuento_Ventas = $_POST['descuento_Ventas'];
$cantCostoContrato = $_POST['cantCostoContrato'];
$costoContrato = $_POST['costoContrato'];
$total_Salida = $_POST['total_Salida'];
$total_Entrada = $_POST['total_Entrada'];
$saldo_Caja = $_POST['saldo_Caja'];
$efectivo_Caja = $_POST['efectivo_Caja'];

$cantAjustes = $_POST['cantAjustes'];
$ajuste = $_POST['ajustes'];
$CantIncremento = $_POST['cantIncremento'];
$incrementoPatrimonio = $_POST['incrementoPatrimonio'];

$cantRefrendos = $_POST['cantRefrendos'];
$informeRefrendo = $_POST['informeRefrendo'];
$idCierreCaja = $_POST['idCierreCaja'];
$cerradoPorGerenteGlb = $_POST['cerradoPorGerenteGlb'];



$sqlTblCierre = new sqlCierreDAO();
$sqlTblCierre->guardarCierreCaja($cantDotaciones,
$dotacionesA_Caja,
$cantCapitalRecuperado,
$capitalRecuperado,
$cantAbono,
$abonoCapital,
$cantInteres,
$intereses,
$cantIva,
$iva,
$cantMostrador,
$mostrador,
$cantIvaVenta,
$iva_venta,
$cantApartados,
$apartadosVenta,
$cantAbonoVenta,
$abonoVentas,
$cantGps,
$gps,
$cantPoliza,
$poliza,
$cantPension,
$pension,
$cantRetiros,
$retirosCaja,
$cantPrestamos,
$prestamosNuevos,
$cantDescuentos,
$descuentosAplicados,
$cantDescuentosVentas,
$descuento_Ventas,
$cantCostoContrato,
$costoContrato,
$total_Salida,
$total_Entrada,
$saldo_Caja,
$efectivo_Caja,
$cantAjustes,
$ajuste,
$CantIncremento,
$incrementoPatrimonio,
$cantRefrendos,
$informeRefrendo,
$idCierreCaja,
$cerradoPorGerenteGlb
);

?>


