<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

class sqlBazarDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    function empenosBazar()
    {
        $datos = array();
        try {
            $fechaHoy = date('Y-m-d');
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT id_movimiento,prestamo_Informativo FROM contrato_mov_tbl
                        WHERE  DATE_FORMAT(fechaAlmoneda,'%Y-%m-%d') = '$fechaHoy' 
                        and sucursal= $sucursal
                        AND tipo_movimiento = 3 
                        AND id_contrato NOT IN 
                        (select id_contrato from contrato_mov_tbl where estatus != 3)";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_movimiento" => $row["id_movimiento"],
                        "prestamo_Informativo" => $row["prestamo_Informativo"]
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

    function refrendosBazar()
    {
        $datos = array();
        try {
            $fechaHoy = date('Y-m-d');
            $buscar = "SELECT id_movimiento,prestamo_Informativo FROM contrato_mov_tbl
                        WHERE  DATE_FORMAT(fechaAlmoneda,'%Y-%m-%d') = '$fechaHoy' 
                        AND tipo_movimiento = 4 
                        AND id_contrato NOT IN 
                        (select id_contrato from contrato_mov_tbl where estatus != 4)";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_movimiento" => $row["id_movimiento"],
                        "prestamo_Informativo" => $row["prestamo_Informativo"]
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