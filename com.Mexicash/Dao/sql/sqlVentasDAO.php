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
            $buscar = "SELECT Baz.id_Contrato,Baz.id_Bazar,Baz.id_serie ,Art.tipoArticulo,Art.kilataje,
                        Art.marca,Art.modelo,Art.ubicacion,Art.detalle,Baz.prestamo_Empeno,Art.avaluo,
                        Baz.precio_venta
                        FROM bazar_articulos as Baz
                        INNER JOIN articulo_tbl as Art on baz.id_serie = CONCAT (Art.id_SerieSucursal, 
                        Art.id_SerieContrato,Art.id_SerieArticulo) 
                        WHERE Baz.id_serie like '$codigo%'  and Baz.id_serie not in 
                        (select id_serie FROM bazar_articulos 
                        where  tipo_movimiento = 6 || tipo_movimiento = 20 || tipo_movimiento = 22 
                        || tipo_movimiento = 23)";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Bazar" => $row["id_Bazar"],
                        "id_Contrato" => $row["id_Contrato"],
                        "id_serie" => $row["id_serie"],
                        "tipoArt" => $row["tipoArticulo"],
                        "kilataje" => $row["kilataje"],
                        "marca" => $row["marca"],
                        "modelo" => $row["modelo"],
                        "ubicacion" => $row["ubicacion"],
                        "detalle" => $row["detalle"],
                        "empeno" => $row["prestamo_Empeno"],
                        "avaluo" => $row["avaluo"],
                        "precio_venta" => $row["precio_venta"],
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

    public function busquedaApartadosCliente($id_ClienteGlb)
    {
        //Modifique los estatus de usuario
        $sucursal = $_SESSION["sucursal"];
        $datos = array();
        try {
            $buscar = "SELECT Baz.id_Bazar,Baz.id_Contrato,Art.tipoArticulo,
                        CONCAT (ET.descripcion,'/ ', EM.descripcion,'/ ',EMOD.descripcion,'/ ',Art.detalle,'/ ', Art.ubicacion) as ElectronicoArt,
                        CONCAT (Art.detalle,'/ ', TA.descripcion,'/ ', TK.descripcion,'/ ',TC.descripcion,'/ ',  Art.ubicacion) as ElectronicoMetal                        FROM bazar_articulos as Baz
                        INNER JOIN articulo_tbl as Art on baz.id_serie = CONCAT (Art.id_SerieSucursal, 
                        Art.id_SerieContrato,Art.id_SerieArticulo) 
                        LEFT JOIN cat_electronico_tipo as ET on Art.tipo = ET.id_tipo
                        LEFT JOIN cat_electronico_marca as EM on Art.marca = EM.id_marca
                        LEFT JOIN cat_electronico_modelo as EMOD on Art.modelo = EMOD.id_modelo
                        LEFT JOIN cat_tipoarticulo as TA on Art.tipo = TA.id_tipo
                        LEFT JOIN cat_kilataje as TK on Art.kilataje = TK.id_Kilataje
                        LEFT JOIN cat_calidad as TC on Art.calidad = TC.id_calidad
                        WHERE Baz.id_Cliente = '$id_ClienteGlb'  and Baz.tipo_movimiento = '22' and Baz.sucursal= $sucursal and  Baz.id_serie not in 
                        (select id_serie FROM bazar_articulos 
                        where  Baz.sucursal= $sucursal  AND tipo_movimiento = 6 || tipo_movimiento = 20 )";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Bazar" => $row["id_Bazar"],
                        "id_Contrato" => $row["id_Contrato"],
                        "tipoArticulo" => $row["tipoArticulo"],
                        "ElectronicoArt" => $row["ElectronicoArt"],
                        "ElectronicoMetal" => $row["ElectronicoMetal"],
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

    public function busquedaAbonos($id_Contrato)
    {
        //Modifique los estatus de usuario
        $sucursal = $_SESSION["sucursal"];
        $datos = array();
        try {
            $buscar = "SELECT id_Bazar,fecha_Modificacion,abono,precio_venta,precio_Actual,apartado,tipo_movimiento,id_serie, sucursal
                        FROM bazar_articulos WHERE id_Contrato = $id_Contrato AND tipo_movimiento=22 || tipo_movimiento=23";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Bazar" => $row["id_Bazar"],
                        "fecha_Modificacion" => $row["fecha_Modificacion"],
                        "abono" => $row["abono"],
                        "precio_venta" => $row["precio_venta"],
                        "precio_Actual" => $row["precio_Actual"],
                        "apartado" => $row["apartado"],
                        "tipo_movimiento" => $row["tipo_movimiento"],
                        "id_serie" => $row["id_serie"],
                        "sucursal" => $row["sucursal"],
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
            $buscar = "SELECT  Baz.id_Contrato,Baz.id_Bazar,Baz.id_serie ,Art.tipoArticulo,Art.kilataje,
                        Art.marca,Art.modelo,Art.ubicacion,Art.detalle,Baz.prestamo_Empeno,Art.avaluo,
                        Baz.precio_venta FROM bazar_articulos as Baz INNER JOIN articulo_tbl as Art on baz.id_serie = 
                        CONCAT (Art.id_SerieSucursal, Art.id_SerieContrato,Art.id_SerieArticulo) 
                        WHERE Baz.id_serie like '$idCodigo%' and Baz.id_serie not in 
                        (select id_serie FROM bazar_articulos where tipo_movimiento = 6 || tipo_movimiento = 20 || tipo_movimiento = 22 || tipo_movimiento = 23 )";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Contrato" => $row["id_Contrato"],
                        "id_Bazar" => $row["id_Bazar"],
                        "id_serie" => $row["id_serie"],
                        "tipoArt" => $row["tipoArticulo"],
                        "kilataje" => $row["kilataje"],
                        "marca" => $row["marca"],
                        "modelo" => $row["modelo"],
                        "ubicacion" => $row["ubicacion"],
                        "detalle" => $row["detalle"],
                        "empeno" => $row["prestamo_Empeno"],
                        "avaluo" => $row["avaluo"],
                        "precio_venta" => $row["precio_venta"],
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
                                 $ivaGlb, $tipo_movimientoGlb, $vendedorGlb,$efectivo,$cambio,$precioVenta){
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];
            $idCierreSuc = $_SESSION["idCierreSucursal"];

            $insertaApartado = "INSERT INTO bazar_articulos 
                       (id_Contrato, id_serie,id_Cliente,precio_venta,precio_Actual,apartado,fechaVencimiento,iva,tipo_movimiento,vendedor,efectivo,cambio,fecha_Modificacion,sucursal,id_CierreCaja,id_CierreSucursal)
                        VALUES ($id_ContratoGlb, '$id_serieGlb',$id_ClienteGlb,$precioVenta,$precio_ActualGlb,$apartadoGlb,'$fechaVencimiento',$ivaGlb,$tipo_movimientoGlb,$vendedorGlb,$efectivo,$cambio,
                        '$fechaModificacion',$sucursal,$idCierreCaja,$idCierreSuc)";
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

    public function guardarAbono($id_Cliente,$id_Contrato,$id_serie,$tipo_movimiento,$idPrestamo,$precio_Actual,$abono,$abono_Total,$efectivo,$cambio,$sucursal)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $idCierreSuc = $_SESSION["idCierreSucursal"];

            $insertaAbono = "INSERT INTO bazar_articulos 
                       (id_Cliente,id_Contrato, id_serie,tipo_movimiento,precio_venta,precio_Actual,abono,abono_Total,efectivo,cambio,fecha_Modificacion,sucursal,id_CierreCaja,id_CierreSucursal)
                        VALUES ($id_Cliente,$id_Contrato, '$id_serie',$tipo_movimiento,$idPrestamo,$precio_Actual,$abono,$abono_Total,'$efectivo',$cambio,'$fechaModificacion',$sucursal,$idCierreCaja,$idCierreSuc)";
            if ($ps = $this->conexion->prepare($insertaAbono)) {
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

    public function guardarVenta($id_ContratoGlb,$id_serieGlb,$id_ClienteGlb,
                                 $ivaGlb,$tipo_movimientoGlb,$vendedorGlb,$efectivo,$cambio,$precioVenta,
                                 $descuento,$idToken,$tokenDesc)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $idCierreSuc = $_SESSION["idCierreSucursal"];
            $sucursal = $_SESSION["sucursal"];
            $usuario = $_SESSION["idUsuario"];

            $insertaAbono = "INSERT INTO bazar_articulos 
                       (id_Contrato, id_serie,tipo_movimiento,id_Cliente,precio_venta,precio_Actual,descuento_Venta,abono,iva,vendedor,efectivo,cambio,fecha_Modificacion,sucursal,id_CierreCaja,id_CierreSucursal)
                        VALUES ($id_ContratoGlb,'$id_serieGlb', $tipo_movimientoGlb,$id_ClienteGlb,$precioVenta,0,$descuento,0,$ivaGlb,$vendedorGlb,'$efectivo',$cambio,'$fechaModificacion',$sucursal,$idCierreCaja,$idCierreSuc)";
            if ($ps = $this->conexion->prepare($insertaAbono)) {
                if ($ps->execute()) {
                    if (empty($idToken)) {
                        $buscarBazar= "select max(id_Bazar) as UltimoBazarID from bazar_articulos where id_CierreCaja = $idCierreCaja";
                        $statement = $this->conexion->query($buscarBazar);
                        $encontro = $statement->num_rows;
                        if ($encontro > 0) {
                            $fila = $statement->fetch_object();
                            $UltimoBazarID = $fila->UltimoBazarID;
                            $respuesta = $UltimoBazarID;
                        }
                    } else {
                        $token_decripcion = mb_strtoupper($tokenDesc, 'UTF-8');
                        $insertaBitacora = "INSERT INTO bit_token ( id_Contrato, token, descripcion, descuento, id_tokenMovimiento, estatus, usuario, sucursal, fecha_Creacion)
                                        VALUES ($id_ContratoGlb,$idToken,'$token_decripcion', $descuento, 7, 1, $usuario, $sucursal,'$fechaModificacion')";
                        if ($ps = $this->conexion->prepare($insertaBitacora)) {
                            if ($ps->execute()) {
                                $updateToken = "UPDATE cat_token SET
                                         estatus = 2
                                        WHERE id_token =$idToken";
                                if ($ps = $this->conexion->prepare($updateToken)) {
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
                                        $respuesta = -11;
                                    }
                                } else {
                                    $respuesta = -12;
                                }
                            } else {
                                $respuesta = -13;
                            }
                        } else {
                            $respuesta = -155;
                        }
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

}