<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlCierreDAO.php");


$dotacionesA_Caja = $_POST['dotacionesA_Caja'];
$CantAportacionesBoveda = $_POST['CantAportacionesBoveda'];
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
$CantAbonoApartados = $_POST['CantAbonoApartados'];
$abonoApartados = $_POST['abonoApartados'];
$gps = $_POST['gps'];
$poliza = $_POST['poliza'];
$pension = $_POST['pension'];
$CantAjustes = $_POST['CantAjustes'];
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
$total_Entrada = $_POST['total_Entrada'];
$total_Salida = $_POST['total_Salida'];
$saldo_final = $_POST['saldo_final'];
$DepoEntradas = $_POST['DepoEntradas'];
$DepoSalidas = $_POST['DepoSalidas'];
$DepoSaldoFinal = $_POST['DepoSaldoFinal'];
$DepoVencida = $_POST['DepoVencida'];
$DepoVigente = $_POST['DepoVigente'];
$DepoTotal = $_POST['DepoTotal'];
$idCierreSucursal = $_POST['idCierreSucursal'];



$sqlTblCierre = new sqlCierreDAO();
$sqlTblCierre->guardarCierreSucursal($dotacionesA_Caja,$CantAportacionesBoveda,$aportaciones_Boveda,$CantCapitalRecuperado,$capitalRecuperado,$CantAbono,$abonoCapital,$intereses,
    $iva,$CantVentasMostrador,$mostrador,$iva_venta,$CantAbonoApartados,$abonoApartados,$gps,$poliza,$pension,$CantAjustes,$ajustes,$CantRetirosCaja,
    $retirosCaja,$retiros_boveda,$CantPrestamosNuevos,$prestamosNuevos,$CantDescuentos,$descuentosAplicados,$CantDescuentosVentas,$descuentos_ventas,
    $total_Entrada,$total_Salida,$saldo_final,$DepoEntradas,$DepoSalidas,$DepoSaldoFinal,$DepoVencida,$DepoVigente,$DepoTotal,$idCierreSucursal);

?>


