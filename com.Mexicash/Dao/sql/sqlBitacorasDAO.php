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

    function sqlBitacoraVentas($id_Movimiento, $id_bazar, $id_cliente,$idToken)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $usuario = $_SESSION["idUsuario"];
            $sucursal = $_SESSION["sucursal"];
            $id_CierreCaja = $_SESSION["idCierreCaja"];
            $insert = "INSERT INTO bit_user_ventas(id_Bazar, tipo_movimiento, cliente, vendedor, id_token,sucursal, id_CierreCaja, Usuario) 
                                VALUES ($id_bazar,$id_Movimiento,$id_cliente,$usuario,$idToken,$sucursal,$id_CierreCaja,$usuario)";
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

    function sqlBitacoraConsultas($id_Movimiento,$idContrato,$venta,$cliente,$consulta_fechaInicio,$consulta_fechaFinal)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $usuario = $_SESSION["idUsuario"];
            $sucursal = $_SESSION["sucursal"];
            $id_CierreCaja = $_SESSION["idCierreCaja"];
            $insert = "INSERT INTO bit_user_consultas(tipo_movimiento,id_Contrato,id_Bazar, cliente, fecha_Inicial, fecha_Final,sucursal, id_CierreCaja, Usuario) 
                                VALUES ($id_Movimiento,$idContrato,$venta,$cliente,'$consulta_fechaInicio','$consulta_fechaFinal',$sucursal,$id_CierreCaja,$usuario)";
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

    function sqlBitacoraCompras($id_Movimiento,$idContratoCompra,$id_vendedor,$idToken)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $usuario = $_SESSION["idUsuario"];
            $sucursal = $_SESSION["sucursal"];
            $id_CierreCaja = $_SESSION["idCierreCaja"];
            $insert = "INSERT INTO bit_user_compras (id_ContratoCompra, tipo_movimiento, vendedor, id_token,sucursal, id_CierreCaja, Usuario) 
                                VALUES ($idContratoCompra,$id_Movimiento,$id_vendedor,$idToken,$sucursal,$id_CierreCaja,$usuario)";
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

    function sqlBitPrecioMod($precioAnteriorGlb,$precioModGlb,$idArticuloGlb,$idTokenGLb)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $usuario = $_SESSION["idUsuario"];
            $sucursal = $_SESSION["sucursal"];
            $id_CierreCaja = $_SESSION["idCierreCaja"];
            $insert = "INSERT INTO bit_user_preciomod(id_token, sucursal, id_CierreCaja, usuario, precioAnterior, 
                            precioActual,id_ArticuloBazar) 
                                VALUES ('$idTokenGLb',$sucursal,$id_CierreCaja,$usuario,$precioAnteriorGlb,
                                $precioModGlb,$idArticuloGlb)";

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