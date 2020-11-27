<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');


$dotacionesA_Caja = $_POST['dotacionesA_Caja'];
$CantAportacionesBoveda = $_POST['cantAportacionesBoveda'];
$aportaciones_Boveda = $_POST['aportaciones_Boveda'];
$CantCapitalRecuperado = $_POST['CantCapitalRecuperado'];
$capitalRecuperado = $_POST['capitalRecuperado'];
$CantAbono = $_POST['CantAbono'];
$abonoCapital = $_POST['abonoCapital'];
$intereses = $_POST['intereses'];
$iva = $_POST['iva'];
$CantVentasMostrador = $_POST['CantVentasMostrador'];
$mostrador = $_POST['mostrador'];
$iva_venta = $_POST['iva_venta'];
$cantCostoContrato = $_POST['cantCostoContrato'];
$costoContrato = $_POST['costoContrato'];
$utilidadVenta = $_POST['utilidadVenta'];
$CantApartados = $_POST['CantApartados'];
$apartados = $_POST['apartados'];
$CantAbonosVenta = $_POST['CantAbonosVenta'];
$abonoVenta = $_POST['abonoVenta'];
$gps = $_POST['gps'];
$poliza = $_POST['poliza'];
$pension = $_POST['pension'];
$CantAjustes = $_POST['cantAjustes'];
$ajustes = $_POST['ajustes'];
$CantRetirosCaja = $_POST['CantRetirosCaja'];
$retirosCaja = $_POST['retirosCaja'];
$retiros_boveda = $_POST['retiros_boveda'];
$CantPrestamosNuevos = $_POST['CantPrestamosNuevos'];
$prestamosNuevos = $_POST['prestamosNuevos'];
$CantDescuentos = $_POST['CantDescuentos'];
$descuentosAplicados = $_POST['descuentosAplicados'];
$CantDescuentosVentas = $_POST['CantDescuentosVentas'];
$descuentos_ventas = $_POST['descuentos_ventas'];
$cantIncremento = $_POST['cantIncremento'];
$incrementoPatrimonio = $_POST['incrementoPatrimonio'];
$total_Entrada = $_POST['total_Entrada'];
$total_Iva = $_POST['total_Iva'];
$total_Salida = $_POST['total_Salida'];
$saldo_final = $_POST['saldo_final'];
$InfoSaldoInicial = $_POST['InfoSaldoInicial'];
$InfoEntradas = $_POST['InfoEntradas'];
$InfoSalidas = $_POST['InfoSalidas'];
$InfoSaldoFinal = $_POST['InfoSaldoFinal'];
$InfoApartados = $_POST['InfoApartados'];
$InfoAbono = $_POST['InfoAbono'];
$InfoTotalInventario = $_POST['InfoTotalInventario'];
$idCierreSucursal = $_POST['idCierreSucursal'];



$sqlTblCierre = new sqlCierreDAO();
$sqlTblCierre->guardarCierreSucursal($dotacionesA_Caja,$CantAportacionesBoveda,$aportaciones_Boveda,$CantCapitalRecuperado,$capitalRecuperado,$CantAbono,$abonoCapital,$intereses,
    $iva,$CantVentasMostrador,$mostrador,$iva_venta, $cantCostoContrato, $costoContrato, $utilidadVenta, $CantApartados, $apartados, $CantAbonosVenta, $abonoVenta,
    $gps,$poliza,$pension,$CantAjustes,$ajustes,$CantRetirosCaja,
    $retirosCaja,$retiros_boveda,$CantPrestamosNuevos,$prestamosNuevos,$CantDescuentos,$descuentosAplicados,$CantDescuentosVentas,$descuentos_ventas,
    $cantIncremento, $incrementoPatrimonio, $total_Entrada,$total_Iva,$total_Salida,$saldo_final,
    $InfoSaldoInicial, $InfoEntradas, $InfoSalidas,$InfoSaldoFinal, $InfoApartados, $InfoAbono, $InfoTotalInventario, $idCierreSucursal);

?>


