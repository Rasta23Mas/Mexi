<?php
if(!isset($_SESSION)) {
    session_start();
}
include_once(MODELO_PATH . "Interes.php");
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlInteresesDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    public function buscarTasaInteres($inTasaInteres)
    {
        try {
            $id = -1;

            $buscar = "select * where  = " . $inTasaInteres;

            $statement = $this->conexion->prepare($buscar);

            if ($statement->execute()) {
                $id = $statement->fetch();
                echo "Todo correcto";
                $statement->close();
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        return $id;
    }

    function llenarCmbTipoInteres($idTablaInteres){
        $datos = array();
        $sucursal = $_SESSION["sucursal"];
        try {
            $buscar = "SELECT id_interes, tasa_interes FROM cat_interes WHERE tablaInteres=". $idTablaInteres . " and sucursal=" .$sucursal;

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_interes" => $row["id_interes"],
                        "tasa_interes" => $row["tasa_interes"]
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

    function llenarCmbTipoInteresAutos(){
        $datos = array();
        $sucursal = $_SESSION["sucursal"];

        try {
            $buscar = "SELECT id_interes, tasa_interes FROM cat_interes WHERE tablaInteres=3  and sucursal=" .$sucursal;
            $rs = $this->conexion->query($buscar);

            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_interes" => $row["id_interes"],
                        "tasa_interes" => $row["tasa_interes"]
                    ];

                    array_push($datos, $data);
                }
            }

        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        return $datos;
    }

    function llenarFormIntereses($idInteres)
    {
        $datos = array();
        try {
            $buscar = "SELECT id_interes, tasa_interes, tipo_interes as tipoInteres, periodo, plazo, tasa, alm, seguro, iva, 
                        tipo_Agrupamiento,dias FROM cat_interes WHERE id_interes = " . $idInteres;
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                $consulta = $rs->fetch_assoc();
                $data['status'] = 'ok';
                $data['result'] = $consulta;
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        //return  json_encode($data);
        echo json_encode($data);
    }

    function llenarCmbTipoPromo(){
        $datos = array();

        try {
            $buscar = "SELECT id_TipoPromocion, descripcion FROM cat_promocion";
            $rs = $this->conexion->query($buscar);

            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_TipoPromocion" => $row["id_TipoPromocion"],
                        "descripcion" => $row["descripcion"]
                    ];
                    array_push($datos, $data);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        return $datos;
    }

    function diasAlmoneda()
    {
        $datos = array();

        try {
            $buscar = "SELECT  id_fechaAlm, dias FROM cat_almoneda Where activo=1 order by dias";
            $rs = $this->conexion->query($buscar);

            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_fechaAlm" => $row["id_fechaAlm"],
                        "dias" => $row["dias"]
                    ];
                    array_push($datos, $data);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        return $datos;
    }

}