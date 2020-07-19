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

    public function reporteRefrendo()
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT Con.fecha_Creacion as FECHA,ConM.fecha_Creacion AS FECHAMOV,
                        ConM.fechaVencimiento AS FECHAVEN, ConM.id_contrato AS CONTRATO,
                        ConM.id_movimiento AS FOLIO, Con.total_Prestamo AS PRESTAMO, 
                        Bit.intereses AS INTERESES,  Bit.almacenaje AS ALMACENAJE, 
                        Bit.seguro AS SEGURO,  Bit.abonoCapital as ABONO,Bit.descuentoAplicado as DESCU,
                        Bit.iva as IVA, Bit.costoContrato AS COSTO, Con.id_Formulario as FORMU
                        FROM contratomovimientos_tbl AS ConM
                        INNER JOIN contrato_tbl AS Con ON ConM.id_contrato = Con.id_Contrato
                        INNER JOIN bit_pagos AS Bit ON ConM.id_movimiento = Bit.ultimoMovimiento
                        WHERE ConM.tipo_Contrato=1  AND ConM.sucursal = $sucursal
                        AND ConM.tipo_movimiento = 4 AND ConM.id_contrato NOT IN 
                            (SELECT id_contrato FROM contratomovimientos_tbl 
                            WHERE tipo_movimiento = 5 || tipo_movimiento = 6 ||
                            tipo_movimiento = 20 || tipo_movimiento = 21 || tipo_movimiento = 22|| 
                            tipo_movimiento = 23 || tipo_movimiento = 24) 
                        ORDER BY FORMU";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "FECHA" => $row["FECHA"],
                        "FECHAMOV" => $row["FECHAMOV"],
                        "FECHAVEN" => $row["FECHAVEN"],
                        "CONTRATO" => $row["CONTRATO"],
                        "FOLIO" => $row["FOLIO"],
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