<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlComprasDAO
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
            $buscar = "SELECT id_Compra FROM contrato_mov_com_tbl WHERE tipo_movimiento=0 AND id_CierreCaja= $idCierreCaja";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $idCompra = $fila->id_Compra;
            } else {
                $fechaCreacion = date('Y-m-d H:i:s');
                $sucursal = $_SESSION["sucursal"];
                $insertaCarrito = "INSERT INTO  contrato_mov_com_tbl
                       (tipo_movimiento, id_CierreCaja,sucursal,fecha_creacion)
                        VALUES (0,$idCierreCaja,$sucursal,'$fechaCreacion')";
                if ($ps = $this->conexion->prepare($insertaCarrito)) {
                    if ($ps->execute()) {
                        $buscar = "SELECT id_Compra FROM contrato_mov_com_tbl WHERE tipo_movimiento=0 AND id_CierreCaja= $idCierreCaja";
                        $statement = $this->conexion->query($buscar);
                        if ($statement->num_rows > 0) {
                            $fila = $statement->fetch_object();
                            $idCompra = $fila->id_Compra;
                        }
                    } else {
                        $idCompra = 0;
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $idCompra;
    }

    function sqlGuardarCompra($tipoMovimiento,$idVendedor,$subTotal,$iva,$total,$efectivo,$cambio,$idContratoCompra)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];

            $updateContratoBaz = "UPDATE contrato_mov_com_tbl SET tipo_movimiento = $tipoMovimiento,idVendedorArt=$idVendedor, subTotal=$subTotal,
                                iva=$iva,total=$total,efectivo=$efectivo,cambio=$cambio
                                WHERE id_Compra=$idContratoCompra";
            if ($ps = $this->conexion->prepare($updateContratoBaz)) {
                if ($ps->execute()) {
                    $updateBitVentas = "UPDATE articulo_bazar_tbl SET id_Contrato = $idContratoCompra
                            WHERE sucursal=$sucursal AND id_Compra = $idContratoCompra AND id_cierreCaja=$idCierreCaja";
                    if ($ps = $this->conexion->prepare($updateBitVentas)) {
                        if ($ps->execute()) {
                            $respuesta = 1;
                        } else {
                            $respuesta = -1;
                        }
                    } else {
                        $respuesta = 1;
                    }
                } else {
                    $respuesta = -1;
                }
            } else {
                $respuesta = -1;
            }
        } catch (Exception $exc) {
            $respuesta = -20;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $respuesta;
    }


}