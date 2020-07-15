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


class sqlFotografiaDAO
{

    protected $error;
    protected $conexion;
    protected $db;

    function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    public function llenarTablaImagenes($idContratoBusqueda)
    {
        $datos = array();
        $sucursal = $_SESSION["sucursal"];

        try {
            $buscar = "SELECT * FROM imagenes
                        WHERE id_contrato =$idContratoBusqueda";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id" => $row["id"],
                        "descripcion" => $row["descripcion"],
                        "img" => $row["img"],
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
        //echo json_encode($datos);
    }

}
