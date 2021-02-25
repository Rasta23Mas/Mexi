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
        $datos = array();
        //Modifique los estatus de usuario
        try {
            $sucursal = $_SESSION["sucursal"];
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $buscar = "SELECT id,id_Compra FROM contrato_mov_com_tbl WHERE tipo_movimiento=0 AND sucursal=$sucursal";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                while ($row = $statement->fetch_assoc()) {
                    $data = [
                        "id" => $row["id"],
                        "id_Compra" => $row["id_Compra"]
                    ];
                    array_push($datos, $data);
                }
            } else {
                $fechaCreacion = date('Y-m-d H:i:s');

                $usuario = $_SESSION["idUsuario"];

                $sucursal = $_SESSION["sucursal"];
                $IdCompraMax= 0;
                $buscarCompra = "select max(id_Compra) as UltimaCompra from contrato_mov_com_tbl where sucursal = $sucursal";
                $statement = $this->conexion->query($buscarCompra);
                $encontro = $statement->num_rows;
                if ($encontro > 0) {
                    $fila = $statement->fetch_object();
                    $IdCompraMax = $fila->UltimaCompra;
                }
                $IdCompraMax++;

                $insertaCarrito = "INSERT INTO  contrato_mov_com_tbl
                       (id_Compra,tipo_movimiento, id_CierreCaja,sucursal,fecha_creacion,usuario)
                        VALUES ($IdCompraMax,0,$idCierreCaja,$sucursal,'$fechaCreacion',$usuario)";
                if ($ps = $this->conexion->prepare($insertaCarrito)) {
                    if ($ps->execute()) {
                        $buscar = "SELECT id,id_Compra FROM contrato_mov_com_tbl WHERE tipo_movimiento=0 AND sucursal=$sucursal";
                        $statement = $this->conexion->query($buscar);
                        if ($statement->num_rows > 0) {
                            while ($row = $statement->fetch_assoc()) {
                                $data = [
                                    "id" => $row["id"],
                                    "id_Compra" => $row["id_Compra"]
                                ];
                                array_push($datos, $data);
                            }
                        }
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo json_encode($datos);
    }

    function sqlGuardarCompra($tipoMovimiento,$idVendedor,$subTotal,$iva,$total,$efectivo,$cambio,$idContratoCompra,$idCompraGlb)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];

            $updateContratoBaz = "UPDATE contrato_mov_com_tbl SET tipo_movimiento = $tipoMovimiento,idVendedorArt=$idVendedor, subTotal=$subTotal,
                                iva=$iva,total=$total,efectivo=$efectivo,cambio=$cambio
                                WHERE id=$idCompraGlb AND  sucursal=$sucursal  ";
            if ($ps = $this->conexion->prepare($updateContratoBaz)) {
                if ($ps->execute()) {
                    $updateBitVentas = "UPDATE articulo_bazar_tbl SET id_Contrato = $idContratoCompra
                            WHERE sucursal=$sucursal AND id_Contrato =0 AND id_cierreCaja=$idCierreCaja";
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