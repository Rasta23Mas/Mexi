<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Usuario.php");
include_once(BASE_PATH . "Conexion.php");
include_once(SERVICIOS_PATH . "Errores.php");
include_once(DAO_PATH . "UsuarioDAO.php");
date_default_timezone_set('America/Mexico_City');


class sqlReportesDAO
{

    protected $error;
    protected $conexion;
    protected $db;

    function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    public function reporteContratos()
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(ConM.fecha_Creacion,'%Y-%m-%d') AS FECHAMOV,
                        DATE_FORMAT(ConM.fechaVencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        ConM.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO, 
                        Bit.intereses AS INTERESES,  Bit.almacenaje AS ALMACENAJE, 
                        Bit.seguro AS SEGURO,  Bit.abonoCapital as ABONO,Bit.descuentoAplicado as DESCU,
                        Bit.iva as IVA, Bit.costoContrato AS COSTO, Con.id_Formulario as FORMU
                        FROM contratomovimientos_tbl AS ConM
                        INNER JOIN contrato_tbl AS Con ON ConM.id_contrato = Con.id_Contrato
                        INNER JOIN bit_pagos AS Bit ON ConM.id_movimiento = Bit.ultimoMovimiento
                        WHERE DATE_FORMAT(ConM.fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 5 OR ConM.tipo_movimiento = 9 
                        OR ConM.tipo_movimiento = 21)  
                        ORDER BY FORMU";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "FECHA" => $row["FECHA"],
                        "FECHAMOV" => $row["FECHAMOV"],
                        "FECHAVEN" => $row["FECHAVEN"],
                        "CONTRATO" => $row["CONTRATO"],
                        "PRESTAMO" => $row["PRESTAMO"],
                        "INTERESES" => $row["INTERESES"],
                        "ALMACENAJE" => $row["ALMACENAJE"],
                        "SEGURO" => $row["SEGURO"],
                        "ABONO" => $row["ABONO"],
                        "DESCU" => $row["DESCU"],
                        "IVA" => $row["IVA"],
                        "COSTO" => $row["COSTO"],
                        "FORMU" => $row["FORMU"],
                    ];
                    array_push($datos, $data);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($datos);
    }
    public function reporteDesempe($fechaIni,$fechaFin)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(ConM.fecha_Creacion,'%Y-%m-%d') AS FECHAMOV,
                        DATE_FORMAT(ConM.fechaVencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        ConM.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO, 
                        Bit.intereses AS INTERESES,  Bit.almacenaje AS ALMACENAJE, 
                        Bit.seguro AS SEGURO,  Bit.abonoCapital as ABONO,Bit.descuentoAplicado as DESCU,
                        Bit.iva as IVA, Bit.costoContrato AS COSTO, Con.id_Formulario as FORMU
                        FROM contratomovimientos_tbl AS ConM
                        INNER JOIN contrato_tbl AS Con ON ConM.id_contrato = Con.id_Contrato
                        INNER JOIN bit_pagos AS Bit ON ConM.id_movimiento = Bit.ultimoMovimiento
                        WHERE DATE_FORMAT(ConM.fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 5 OR ConM.tipo_movimiento = 9 
                        OR ConM.tipo_movimiento = 21)  
                        ORDER BY FORMU";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "FECHA" => $row["FECHA"],
                        "FECHAMOV" => $row["FECHAMOV"],
                        "FECHAVEN" => $row["FECHAVEN"],
                        "CONTRATO" => $row["CONTRATO"],
                        "PRESTAMO" => $row["PRESTAMO"],
                        "INTERESES" => $row["INTERESES"],
                        "ALMACENAJE" => $row["ALMACENAJE"],
                        "SEGURO" => $row["SEGURO"],
                        "ABONO" => $row["ABONO"],
                        "DESCU" => $row["DESCU"],
                        "IVA" => $row["IVA"],
                        "COSTO" => $row["COSTO"],
                        "FORMU" => $row["FORMU"],
                    ];
                    array_push($datos, $data);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($datos);
    }
    public function reporteRefrendo($fechaIni,$fechaFin)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(ConM.fecha_Creacion,'%Y-%m-%d') AS FECHAMOV,
                        DATE_FORMAT(ConM.fechaVencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        ConM.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO, 
                        Bit.intereses AS INTERESES,  Bit.almacenaje AS ALMACENAJE, 
                        Bit.seguro AS SEGURO,  Bit.abonoCapital as ABONO,Bit.descuentoAplicado as DESCU,
                        Bit.iva as IVA, Bit.costoContrato AS COSTO, Con.id_Formulario as FORMU
                        FROM contratomovimientos_tbl AS ConM
                        INNER JOIN contrato_tbl AS Con ON ConM.id_contrato = Con.id_Contrato
                        INNER JOIN bit_pagos AS Bit ON ConM.id_movimiento = Bit.ultimoMovimiento
                        WHERE DATE_FORMAT(ConM.fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 4 OR ConM.tipo_movimiento = 8 )  
                        ORDER BY FORMU";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "FECHA" => $row["FECHA"],
                        "FECHAMOV" => $row["FECHAMOV"],
                        "FECHAVEN" => $row["FECHAVEN"],
                        "CONTRATO" => $row["CONTRATO"],
                        "PRESTAMO" => $row["PRESTAMO"],
                        "INTERESES" => $row["INTERESES"],
                        "ALMACENAJE" => $row["ALMACENAJE"],
                        "SEGURO" => $row["SEGURO"],
                        "ABONO" => $row["ABONO"],
                        "DESCU" => $row["DESCU"],
                        "IVA" => $row["IVA"],
                        "COSTO" => $row["COSTO"],
                        "FORMU" => $row["FORMU"],
                    ];
                    array_push($datos, $data);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($datos);
    }


}