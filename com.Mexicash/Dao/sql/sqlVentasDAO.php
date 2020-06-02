<?php
if(!isset($_SESSION)) {
    session_start();
}
include_once ($_SERVER['DOCUMENT_ROOT'].'/dirs.php');
include_once (BASE_PATH."Conexion.php");
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

    function busquedaCodigo($idCodigo){
        $datos = array();
        try {
            $buscar = "SELECT Baz.id_serie , Baz.tipo_movimiento,Art.tipo,Art.kilataje,
                        Art.marca,Art.modelo,Art.ubicacion,Art.detalle,Baz.fecha_Modificacion 
                        FROM bazar_articulos as Baz
                        INNER JOIN articulo_tbl as Art on baz.id_serie = CONCAT (Art.id_SerieSucursal, 
                        Art.id_SerieContrato,Art.id_SerieArticulo) 
                        WHERE Baz.id_serie= '$idCodigo'";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_serie" => $row["id_serie"],
                        "tipo_movimiento" => $row["tipo_movimiento"],
                        "tipo" => $row["tipo"],
                        "kilataje" => $row["kilataje"],
                        "marca" => $row["marca"],
                        "modelo" => $row["modelo"],
                        "ubicacion" => $row["ubicacion"],
                        "detalle" => $row["detalle"],
                        "fecha_Modificacion" => $row["fecha_Modificacion"],
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
    function busquedaCodigoSeleccionado($idCodigo){
        $datos = array();
        try {
            $buscar = "SELECT Baz.id_Bazar,Art.id_Articulo,Baz.precio_venta,
                        Baz.tipo_movimiento,Art.tipo,Art.kilataje,Art.calidad,
                        Art.cantidad,Art.peso,Art.peso_Piedra,Art.piedras,Art.marca,Art.modelo,
                        Art.num_Serie,Art.avaluo,Art.vitrina,Art.precioCat,Art.ubicacion,Art.detalle,
                        Art.fecha_creacion,Baz.fecha_Modificacion FROM bazar_articulos as Baz
                        INNER JOIN articulo_tbl as Art on baz.id_serie = CONCAT (Art.id_SerieSucursal, 
                        Art.id_SerieContrato,Art.id_SerieArticulo) 
                        WHERE Baz.id_serie= '$idCodigo'";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Bazar" => $row["id_Bazar"],
                        "id_Articulo" => $row["id_Articulo"],
                        "precio_venta" => $row["precio_venta"],
                        "tipo_movimiento" => $row["tipo_movimiento"],
                        "tipo" => $row["tipo"],
                        "kilataje" => $row["kilataje"],
                        "calidad" => $row["calidad"],
                        "cantidad" => $row["cantidad"],
                        "peso" => $row["peso"],
                        "peso_Piedra" => $row["peso_Piedra"],
                        "piedras" => $row["piedras"],
                        "marca" => $row["marca"],
                        "modelo" => $row["modelo"],
                        "num_Serie" => $row["num_Serie"],
                        "avaluo" => $row["avaluo"],
                        "vitrina" => $row["vitrina"],
                        "precioCat" => $row["precioCat"],
                        "ubicacion" => $row["ubicacion"],
                        "detalle" => $row["detalle"],
                        "fecha_creacion" => $row["fecha_creacion"],
                        "fecha_Modificacion" => $row["fecha_Modificacion"],


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
    //Validacion de token
    public function validarToken($token){
        $token = mb_strtoupper($token, 'UTF-8');

        try {
            $id = -1;
            $buscar = "SELECT id_token,descripcion FROM cat_token 
                        WHERE descripcion = '$token' and estatus= 1";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $id = $fila->id_token;
            } else {
                $id = -1;
            }

        } catch (Exception $exc) {
            $id = -1;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $id;
        //return $id;
    }

    //Generar Venta
    public function guardarVenta($estatus,$estatusAnterior,$bazar,$cliente,$vendedor,$precioVenta,$descuento){
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $sucursal = $_SESSION["sucursal"];
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $idCierreSucursal = $_SESSION["idCierreSucursal"];
            $fechaCreacion = date('Y-m-d H:i:s');

            $updateContrato = "UPDATE bazar_articulos SET
                                    estatus = $estatus,
                                    id_Cliente = $cliente,
                                    vendedor = $vendedor,
                                    precio_venta = $precioVenta,
                                    descuento_venta = $descuento,
                                    estatusAnterior = $estatusAnterior,
                                    id_CierreCaja = $idCierreCaja,
                                    id_CierreSucursal = $idCierreSucursal,
                                    fecha_Modificacion = '$fechaCreacion',
                                    WHERE
                                    id_Bazar = $bazar";
            if ($ps = $this->conexion->prepare($updateContrato)) {
                if ($ps->execute()) {
                    if ($tipeFormulario == 1) {
                        $updateArticulos = "UPDATE articulo_tbl SET  fecha_modificacion = '$fechaModificacion',usuario= $usuario, id_Estatus = $idEstatusArt 
                                WHERE id_Contrato=$contrato";
                    }
                    if ($tipeFormulario == 2) {
                        $updateArticulos = "UPDATE auto_tbl SET  fecha_modificacion = '$fechaModificacion',usuario= $usuario, id_Estatus = $idEstatusArt 
                                WHERE id_Contrato=$contrato";
                    }

                    if ($ps = $this->conexion->prepare($updateArticulos)) {
                        if ($ps->execute()) {
                            if(empty($token)){
                                $verdad = 1;
                            }else{
                                $token_decripcion = mb_strtoupper($token_decripcion, 'UTF-8');
                                $insertaBitacora = "INSERT INTO bit_token ( id_Contrato, tipo_Contrato, tipo_formulario,
                                                token, descripcion, descuento, interes, moratorio,gps,
                                                pension,poliza,id_tokenMovimiento, estatus, usuario, sucursal, fecha_Creacion)
                                        VALUES ($contrato, $tipoContrato,$tipeFormulario,
                                                '$token','$token_decripcion', $descuento, $token_interes,$token_moratorio,$token_gps,
                                                $token_pension,$token_poliza,$token_movimiento,1, $usuario, $sucursal,'$fechaModificacion')";
                                if ($ps = $this->conexion->prepare($insertaBitacora)) {
                                    if ($ps->execute()) {
                                        $updateToken = "UPDATE cat_token SET
                                         estatus = 2
                                        WHERE id_token =$token";
                                        if ($ps = $this->conexion->prepare($updateToken)) {
                                            if ($ps->execute()) {
                                                $verdad = mysqli_stmt_affected_rows($ps);
                                            } else {
                                                $verdad = -11;
                                            }
                                        } else {
                                            $verdad = -12;
                                        }
                                    } else {
                                        $verdad = -13;
                                    }
                                } else {
                                    $verdad = -155;
                                }
                            }
                        } else {
                            $verdad = -16;
                        }
                    } else {
                        $verdad = -17;
                    }
                } else {
                    $verdad = -18;
                }
            } else {
                $verdad = -19;
            }
        } catch (Exception $exc) {
            $verdad = -20;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        //return $verdad;
        echo $verdad;
    }


}