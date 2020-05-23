<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlMovimientosDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    public function insertarMovimiento($id_contrato, $fechaVencimiento, $fechaAlmoneda, $plazo, $periodo, $tipoInteres,
                                       $prestamo_actual,$totalAvaluo, $s_prestamo_nuevo, $s_descuento_aplicado, $e_capital_recuperado,
                                       $e_pagoDesempeno, $e_abono, $e_intereses, $e_moratorios, $e_venta_mostrador,
                                       $e_venta_iva, $e_venta_apartados, $e_gps, $e_poliza, $e_pension, $tipo_Contrato,
                                       $tipo_movimiento, $abonoFinal, $descuentoFinal, $costo_Contrato,$prestamo_Informativo,$e_iva){
        // TODO: Implement guardaCiente() method.
        try {
            $verdad = -1;
            $usuario = $_SESSION["idUsuario"];
            $sucursal = $_SESSION["sucursal"];
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $idCierreSucursal = $_SESSION["idCierreSucursal"];
            $fechaCreacion = date('Y-m-d H:i:s');

            $insertaMovimiento = "INSERT INTO contratomovimientos_tbl (id_contrato,fechaVencimiento,fechaAlmoneda, plazo, periodo, tipoInteres,
                        prestamo_actual,total_Avaluo, s_prestamo_nuevo, 
                        s_descuento_aplicado,descuentoTotal,abonoTotal, e_capital_recuperado,e_pagoDesempeno,e_abono, e_intereses, e_moratorios,e_iva, e_venta_mostrador,
                        e_venta_iva, e_venta_apartados, e_gps, e_poliza, e_pension, e_costoContrato, tipo_Contrato, tipo_movimiento,
                        usuario, sucursal, id_cierreCaja, id_cierreSucursal, fecha_Creacion,prestamo_Informativo) VALUES 
                        ($id_contrato, '$fechaVencimiento','$fechaAlmoneda','$plazo', '$periodo', '$tipoInteres',$prestamo_actual, $totalAvaluo, $s_prestamo_nuevo, $s_descuento_aplicado,$descuentoFinal,$abonoFinal,
                         $e_capital_recuperado, $e_pagoDesempeno, $e_abono, $e_intereses, $e_moratorios,$e_iva, $e_venta_mostrador,
                        $e_venta_iva, $e_venta_apartados, $e_gps,$e_poliza, $e_pension,$costo_Contrato, $tipo_Contrato, $tipo_movimiento,
                         $usuario, $sucursal, $idCierreCaja, $idCierreSucursal,'$fechaCreacion',$prestamo_Informativo)";
            if ($ps = $this->conexion->prepare($insertaMovimiento)) {
                if ($ps->execute()) {
                    // $verdad = mysqli_stmt_affected_rows($ps);
                    $buscarContrato = "select max(id_movimiento) as ID_Movimiento from contratomovimientos_tbl where usuario = " . $usuario . " and sucursal = $sucursal";
                    $statement = $this->conexion->query($buscarContrato);
                    $encontro = $statement->num_rows;
                    if ($encontro > 0) {
                        $fila = $statement->fetch_object();
                        $UltimoMovimiento = $fila->ID_Movimiento;
                        $verdad = $UltimoMovimiento;
                    }
                } else {
                    $verdad = -2;
                }
            } else {
                $verdad = -3;
            }

        } catch (Exception $exc) {
            $verdad = -4;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
    }
}