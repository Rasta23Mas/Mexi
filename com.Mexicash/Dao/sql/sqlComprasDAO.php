<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlVentasDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    //Busqueda de Contrato
    function sqlBuscarIdBazarCompras()
    {
        $idBazar = 0;
        //Modifique los estatus de usuario
        try {
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $buscar = "SELECT id_Bazar FROM contrato_mov_baz_tbl WHERE tipo_movimiento=0 AND id_CierreCaja= $idCierreCaja";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $idBazar = $fila->id_Bazar;
            } else {
                $fechaCreacion = date('Y-m-d H:i:s');
                $sucursal = $_SESSION["sucursal"];
                $insertaCarrito = "INSERT INTO  contrato_mov_baz_tbl
                       (tipo_movimiento, id_CierreCaja,sucursal,fecha_creacion)
                        VALUES (0,$idCierreCaja,$sucursal,'$fechaCreacion')";
                if ($ps = $this->conexion->prepare($insertaCarrito)) {
                    if ($ps->execute()) {
                        $buscar = "SELECT id_Bazar FROM contrato_mov_baz_tbl WHERE tipo_movimiento=0 AND id_CierreCaja= $idCierreCaja";
                        $statement = $this->conexion->query($buscar);
                        if ($statement->num_rows > 0) {
                            $fila = $statement->fetch_object();
                            $idBazar = $fila->id_Bazar;
                        }
                    } else {
                        $idBazar = 0;
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $idBazar;
    }

}