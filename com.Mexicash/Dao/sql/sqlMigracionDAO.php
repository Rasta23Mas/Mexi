<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlMigracionDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    //Busqueda de Contrato
    function sqlBuscarIdContrato()
    {
        $idBazar = 0;
        //Modifique los estatus de usuario
        try {

                $sucursal = $_SESSION["sucursal"];
                $IdCompraMax= 0;
                $buscar = "SELECT MAX(id_Contrato) FROM articulo_bazar_tbl WHERE sucursal=$sucursal AND (id_serieTipo=2 || compra_mig=1)";
                $statement = $this->conexion->query($buscar);
                $encontro = $statement->num_rows;
                if ($encontro > 0) {
                    $fila = $statement->fetch_object();
                    $IdCompraMax = $fila->UltimaCompra;
                }
                $IdCompraMax++;


        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $IdCompraMax;
    }




}