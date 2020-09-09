<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Auto.php");
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlBitacorasDAO
{
    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    function sqlBitacoraVentas($id_Movimiento, $id_bazar, $id_cliente, $id_vendedor,$idToken)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $usuario = $_SESSION["idUsuario"];
            $sucursal = $_SESSION["sucursal"];
            $namePC = $_SESSION["namePC"];
            $id_CierreCaja = $_SESSION["idCierreCaja"];
            $insert = "INSERT INTO bit_user_ventas(id_Bazar, tipo_movimiento, cliente, vendedor, id_token,sucursal, id_CierreCaja, Usuario,namePC) 
                                VALUES ($id_bazar,$id_Movimiento,$id_cliente,$id_vendedor,$idToken,$sucursal,$id_CierreCaja,$usuario,'$namePC')";
            if ($ps = $this->conexion->prepare($insert)) {
                if ($ps->execute()) {
                    $verdad = mysqli_stmt_affected_rows($ps);
                } else {
                    $verdad = -1;
                }
            } else {
                $verdad = -1;
            }
        } catch (Exception $exc) {
            $verdad = -1;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
    }

}