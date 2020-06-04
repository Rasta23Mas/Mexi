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
    public function busquedaApartados($codigo)
    {
        //Modifique los estatus de usuario
        $datos = array();
        try {
            $buscar = "SELECT Baz.id_Contrato,Baz.sucursal,Baz.id_serie , Baz.tipo_movimiento,Art.tipo,Art.kilataje,
                        Art.marca,Art.modelo,Art.ubicacion,Art.detalle,Art.avaluo,Art.vitrina,Baz.fecha_Modificacion,
                        Art.id_Articulo,Baz.precio_venta,Art.precioCat 
                        FROM bazar_articulos as Baz
                        INNER JOIN articulo_tbl as Art on baz.id_serie = CONCAT (Art.id_SerieSucursal, 
                        Art.id_SerieContrato,Art.id_SerieArticulo) 
                        WHERE Baz.id_serie like '$codigo'  and Baz.id_serie not in 
                        (select id_serie FROM bazar_articulos 
                        where  tipo_movimiento = 6 || tipo_movimiento = 20 || tipo_movimiento = 22 
                        || tipo_movimiento = 23)";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Contrato" => $row["id_Contrato"],
                        "sucursal" => $row["sucursal"],
                        "id_serie" => $row["id_serie"],
                        "tipo_movimiento" => $row["tipo_movimiento"],
                        "tipoArt" => $row["tipo"],
                        "kilataje" => $row["kilataje"],
                        "marca" => $row["marca"],
                        "modelo" => $row["modelo"],
                        "ubicacion" => $row["ubicacion"],
                        "detalle" => $row["detalle"],
                        "avaluo" => $row["avaluo"],
                        "vitrina" => $row["vitrina"],
                        "fecha_Modificacion" => $row["fecha_Modificacion"],
                        "id_Articulo" => $row["id_Articulo"],
                        "precio_venta" => $row["precio_venta"],
                        "precioCat" => $row["precioCat"],
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

    function busquedaCodigo($idCodigo)
    {
        $datos = array();
        try {
            $buscar = "SELECT Baz.id_serie , Baz.tipo_movimiento,Art.tipo,Art.kilataje,
                        Art.marca,Art.modelo,Art.ubicacion,Art.detalle,Art.avaluo,Art.vitrina,Baz.fecha_Modificacion 
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
                        "tipoArt" => $row["tipo"],
                        "kilataje" => $row["kilataje"],
                        "marca" => $row["marca"],
                        "modelo" => $row["modelo"],
                        "ubicacion" => $row["ubicacion"],
                        "detalle" => $row["detalle"],
                        "avaluo" => $row["avaluo"],
                        "vitrina" => $row["vitrina"],
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

    function busquedaCodigoSeleccionado($idCodigo)
    {
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
    public function validarToken($token)
    {
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
    public function guardarApartado($id_ContratoGlb, $id_serieGlb, $id_ClienteGlb, $precio_ActualGlb, $apartadoGlb,$fechaVencimiento,
                                 $ivaGlb, $tipo_movimientoGlb, $vendedorGlb, $sucursalGlb,$efectivo,$cambio)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];

            $insertaApartado = "INSERT INTO bazar_articulos 
                       (id_Contrato, id_serie,id_Cliente,precio_Actual,apartado,fechaVencimiento,iva,tipo_movimiento,vendedor,efectivo,cambio,fecha_Modificacion,sucursal,id_CierreCaja)
                        VALUES ($id_ContratoGlb, '$id_serieGlb',$id_ClienteGlb,$precio_ActualGlb,$apartadoGlb,'$fechaVencimiento',$ivaGlb,$tipo_movimientoGlb,$vendedorGlb,$efectivo,$cambio
                        '$fechaModificacion',$sucursalGlb,$idCierreCaja)";
            if ($ps = $this->conexion->prepare($insertaApartado)) {
                if ($ps->execute()) {
                    $buscarBazar= "select max(id_Bazar) as UltimoBazarID from bazar_articulos where id_CierreCaja = $idCierreCaja";
                    $statement = $this->conexion->query($buscarBazar);
                    $encontro = $statement->num_rows;
                    if ($encontro > 0) {
                        $fila = $statement->fetch_object();
                        $UltimoBazarID = $fila->UltimoBazarID;
                        $respuesta = $UltimoBazarID;
                    }
                } else {
                    $respuesta = -1;
                }
            } else {
                $respuesta = 3;
            }
        } catch (Exception $exc) {
            $respuesta = -20;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        //return $verdad;
        echo $respuesta;
    }

    public function busquedaApartados2($idCodigo)
    {
        //Modifique los estatus de usuario
        $datos = array();
        try {
            $buscar = "SELECT max(id_movimiento) as IdMovimiento FROM contratomovimientos_tbl 
                        WHERE id_contrato = '$idContratoDes' and tipo_Contrato= $tipoContrato and tipo_movimiento!=20";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "IdMovimiento" => $row["IdMovimiento"]
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