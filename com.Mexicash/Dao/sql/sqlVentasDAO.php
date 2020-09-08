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
            $buscar = "SELECT Baz.id_Contrato,Baz.id_Bazar,Baz.id_serie ,ART.descripcionCorta,
                        ART.observaciones, Baz.prestamo_Empeno,ART.avaluo,
                        Baz.precio_venta
                        FROM contrato_baz_mov_tbl as Baz
                        LEFT JOIN articulo_tbl AS ART on Baz.id_Articulo = ART.id_Articulo 
                        WHERE Baz.id_serie like '$codigo%'  and Baz.id_serie not in 
                        (select id_serie FROM contrato_baz_mov_tbl 
                        where  tipo_movimiento = 6 || tipo_movimiento = 20 || tipo_movimiento = 22 
                        || tipo_movimiento = 23)";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Bazar" => $row["id_Bazar"],
                        "id_ContratoApartado" => $row["id_Contrato"],
                        "id_serieApartado" => $row["id_serie"],
                        "descripcionCorta" => $row["descripcionCorta"],
                        "observaciones" => $row["observaciones"],
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
            $buscar = "SELECT Baz.id_Bazar,Baz.id_Contrato,
                         ART.descripcionCorta,ART.observaciones
                        FROM contrato_baz_mov_tbl as Baz
                        LEFT JOIN articulo_tbl AS ART on Baz.id_Articulo = ART.id_Articulo 
                        WHERE Baz.id_Cliente = '$id_ClienteGlb'  and Baz.tipo_movimiento = '22' and Baz.sucursal= $sucursal and  Baz.id_serie not in 
                        (select id_serie FROM contrato_baz_mov_tbl 
                        where  Baz.sucursal= $sucursal  AND tipo_movimiento = 6 || tipo_movimiento = 20 )";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Bazar" => $row["id_Bazar"],
                        "id_ContratoVentas" => $row["id_Contrato"],
                        "descripcionCorta" => $row["descripcionCorta"],
                        "observaciones" => $row["observaciones"],
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
            $buscar = "SELECT id_Bazar,fecha_Modificacion,iva,apartado,abono,precio_venta,precio_Actual,apartado,tipo_movimiento,id_serie, sucursal
                        FROM contrato_baz_mov_tbl WHERE id_Contrato = $id_Contrato AND tipo_movimiento=22 || tipo_movimiento=23";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Bazar" => $row["id_Bazar"],
                        "fecha_Modificacion" => $row["fecha_Modificacion"],
                        "iva" => $row["iva"],
                        "apartado" => $row["apartado"],
                        "abono" => $row["abono"],
                        "precio_venta" => $row["precio_venta"],
                        "precio_Actual" => $row["precio_Actual"], "tipo_movimiento" => $row["tipo_movimiento"],
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
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT  Baz.id_Contrato,Baz.id_Bazar,Baz.id_serie ,Baz.id_serieTipo, Baz.prestamo_Empeno, 
                        Baz.precio_Actual, ART.descripcionCorta,ART.observaciones, ART.avaluo
                        FROM articulo_bazar_tbl as Baz 
                        LEFT JOIN articulo_tbl AS ART on Baz.id_Articulo = ART.id_Articulo 
                        WHERE Baz.id_serie like '%$idCodigo%' AND Baz.sucursal= '$sucursal' AND Baz.Fisico=1
                        LIMIT 20";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_ContratoBaz" => $row["id_Contrato"],
                        "id_Bazar" => $row["id_Bazar"],
                        "id_serieBaz" => $row["id_serie"],
                        "id_serieTipo" => $row["id_serieTipo"],
                        "empeno" => $row["prestamo_Empeno"],
                        "precio_Actual" => $row["precio_Actual"],
                        "descripcionCorta" => $row["descripcionCorta"],
                        "observaciones" => $row["observaciones"],
                        "avaluo" => $row["avaluo"],
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

    function busquedaContrato($idContrato)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT  Baz.id_Contrato,Baz.id_Bazar,Baz.id_serie ,Baz.id_serieTipo, Baz.prestamo_Empeno, 
                        Baz.precio_venta, ART.descripcionCorta,ART.observaciones, ART.avaluo
                        FROM articulo_bazar_tbl as Baz 
                        LEFT JOIN articulo_tbl AS ART on Baz.id_Articulo = ART.id_Articulo 
                        WHERE Baz.id_Contrato like '$idContrato%' AND Baz.sucursal= '$sucursal' AND Baz.Fisico=1
                        LIMIT 20";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_ContratoBaz" => $row["id_Contrato"],
                        "id_Bazar" => $row["id_Bazar"],
                        "id_serieBaz" => $row["id_serie"],
                        "id_serieTipo" => $row["id_serieTipo"],
                        "empeno" => $row["prestamo_Empeno"],
                        "precio_venta" => $row["precio_venta"],
                        "descripcionCorta" => $row["descripcionCorta"],
                        "observaciones" => $row["observaciones"],
                        "avaluo" => $row["avaluo"],
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

    function sqlBusquedaSinCodigo($idCodigo,$id_bazar)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT  Baz.id_Contrato,Baz.id_Bazar,Baz.id_serie ,Baz.id_serieTipo, Baz.prestamo_Empeno, 
                        Baz.precio_Actual, ART.descripcionCorta,ART.observaciones, ART.avaluo
                        FROM articulo_bazar_tbl as Baz 
                        LEFT JOIN articulo_tbl AS ART on Baz.id_Articulo = ART.id_Articulo 
                        WHERE Baz.id_serie like '%$idCodigo%' AND Baz.sucursal= '$sucursal' AND Baz.Fisico=1
                        AND Baz.id_Bazar!=$id_bazar
                        LIMIT 20";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_ContratoBaz" => $row["id_Contrato"],
                        "id_Bazar" => $row["id_Bazar"],
                        "id_serieBaz" => $row["id_serie"],
                        "id_serieTipo" => $row["id_serieTipo"],
                        "empeno" => $row["prestamo_Empeno"],
                        "precio_Actual" => $row["precio_Actual"],
                        "descripcionCorta" => $row["descripcionCorta"],
                        "observaciones" => $row["observaciones"],
                        "avaluo" => $row["avaluo"],
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
            $buscar = "SELECT Baz.id_Bazar,ART.id_Articulo,Baz.precio_venta,
                        Baz.tipo_movimiento,ART.tipo,ART.kilataje,ART.calidad,
                        ART.cantidad,ART.peso,ART.peso_Piedra,ART.piedras,ART.marca,ART.modelo,
                        ART.num_Serie,ART.avaluo,ART.vitrina,ART.precioCat,ART.observaciones,ART.detalle,
                        ART.fecha_creacion,Baz.fecha_Modificacion FROM contrato_baz_mov_tbl as Baz
                        LEFT JOIN articulo_tbl AS ART on Baz.id_Articulo = ART.id_Articulo 
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
                        "observaciones" => $row["observaciones"],
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
    public function guardarApartado($id_ContratoGlb, $id_serieGlb, $id_ClienteGlb, $precio_ActualGlb, $apartadoGlb, $fechaVencimiento,
                                    $ivaGlb, $tipo_movimientoGlb, $vendedorGlb, $efectivo, $cambio, $precioVenta)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];
            $idCierreSuc = $_SESSION["idCierreSucursal"];

            $insertaApartado = "INSERT INTO contrato_baz_mov_tbl 
                       (id_Contrato, id_serie,id_Cliente,precio_venta,precio_Actual,apartado,fechaVencimiento,iva,tipo_movimiento,vendedor,efectivo,cambio,fecha_Modificacion,sucursal,id_CierreCaja,id_CierreSucursal)
                        VALUES ($id_ContratoGlb, '$id_serieGlb',$id_ClienteGlb,$precioVenta,$precio_ActualGlb,$apartadoGlb,'$fechaVencimiento',$ivaGlb,$tipo_movimientoGlb,$vendedorGlb,$efectivo,$cambio,
                        '$fechaModificacion',$sucursal,$idCierreCaja,$idCierreSuc)";
            if ($ps = $this->conexion->prepare($insertaApartado)) {
                if ($ps->execute()) {
                    $buscarBazar = "select max(id_Bazar) as UltimoBazarID from contrato_baz_mov_tbl where id_CierreCaja = $idCierreCaja";
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

    public function guardarAbono($id_Cliente, $id_Contrato, $id_serie, $tipo_movimiento, $idPrestamo, $precio_Actual, $iva, $apartado, $abono, $abono_Total, $efectivo, $cambio, $sucursal)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $idCierreSuc = $_SESSION["idCierreSucursal"];

            $insertaAbono = "INSERT INTO contrato_baz_mov_tbl 
                       (id_Cliente,id_Contrato, id_serie,tipo_movimiento,precio_venta,precio_Actual,iva,apartado,abono,abono_Total,efectivo,cambio,fecha_Modificacion,sucursal,id_CierreCaja,id_CierreSucursal)
                        VALUES ($id_Cliente,$id_Contrato, '$id_serie',$tipo_movimiento,$idPrestamo,$precio_Actual,$iva,$apartado,$abono,$abono_Total,'$efectivo',$cambio,'$fechaModificacion',$sucursal,$idCierreCaja,$idCierreSuc)";
            if ($ps = $this->conexion->prepare($insertaAbono)) {
                if ($ps->execute()) {
                    $buscarBazar = "select max(id_Bazar) as UltimoBazarID from contrato_baz_mov_tbl where id_CierreCaja = $idCierreCaja";
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

    public function guardarVenta($id_ContratoGlb, $id_serieGlb, $id_ClienteGlb,
                                 $ivaGlb, $tipo_movimientoGlb, $vendedorGlb, $efectivo, $cambio, $precioVenta,
                                 $descuento, $idToken, $tokenDesc)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $idCierreSuc = $_SESSION["idCierreSucursal"];
            $sucursal = $_SESSION["sucursal"];
            $usuario = $_SESSION["idUsuario"];

            $insertaAbono = "INSERT INTO contrato_baz_mov_tbl 
                       (id_Contrato, id_serie,tipo_movimiento,id_Cliente,precio_venta,precio_Actual,descuento_Venta,abono,iva,vendedor,efectivo,cambio,fecha_Modificacion,sucursal,id_CierreCaja,id_CierreSucursal)
                        VALUES ($id_ContratoGlb,'$id_serieGlb', $tipo_movimientoGlb,$id_ClienteGlb,$precioVenta,0,$descuento,0,$ivaGlb,$vendedorGlb,'$efectivo',$cambio,'$fechaModificacion',$sucursal,$idCierreCaja,$idCierreSuc)";
            if ($ps = $this->conexion->prepare($insertaAbono)) {
                if ($ps->execute()) {
                    if (empty($idToken)) {
                        $buscarBazar = "select max(id_Bazar) as UltimoBazarID from contrato_baz_mov_tbl where id_CierreCaja = $idCierreCaja";
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
                                        $buscarBazar = "select max(id_Bazar) as UltimoBazarID from contrato_baz_mov_tbl where id_CierreCaja = $idCierreCaja";
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


    public function sqlAgregarCarrito($id_Bazar, $idCliente, $idVendedor)
    {
        // TODO: Implement guardaCiente() method.
        $datos = array();
        try {
            $fechaCreacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];

            $insertaCarrito= "INSERT INTO  bit_ventas
                       (id_bazar, id_cliente,id_vendedor,sucursal,id_cierreCaja,guardar,fecha_creacion)
                        VALUES ($id_Bazar,$idCliente, $idVendedor,$sucursal,$idCierreCaja,0,'$fechaCreacion')";
            if ($ps = $this->conexion->prepare($insertaCarrito)) {
                if ($ps->execute()) {
                    $respuesta = 1;
                } else {
                    $respuesta = 0;
                }
            }
        } catch
        (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo $respuesta;
    }

    public function sqlEliminarCarrito($id_Ventas)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $deleteCarrito= "DELETE FROM bit_ventas WHERE id_ventas = $id_Ventas";
            if ($ps = $this->conexion->prepare($deleteCarrito)) {
                if ($ps->execute()) {
                    $respuesta = 1;
                } else {
                    $respuesta = 0;
                }
            }
        } catch
        (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo $respuesta;
    }

    public function sqlRefrescarCarrito()
    {
        // TODO: Implement guardaCiente() method.
        $datos = array();
        try {
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT Ven.id_ventas as id_ventas,Baz.id_serie as Codigo,Baz.id_Contrato,
                                Art.descripcionCorta, Baz.precio_Actual
                                FROM bit_ventas as Ven
                                LEFT JOIN articulo_bazar_tbl as Baz on Ven.id_bazar = Baz.id_Bazar
                                LEFT JOIN articulo_tbl as Art on Baz.id_Articulo = Art.id_Articulo
                                WHERE Ven.sucursal=$sucursal AND Ven.guardar = 0 AND Ven.id_cierreCaja=$idCierreCaja";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_ventas" => $row["id_ventas"],
                        "Codigo" => $row["Codigo"],
                        "id_ContratoVentas" => $row["id_Contrato"],
                        "descripcionCorta" => $row["descripcionCorta"],
                        "precio_Actual" => $row["precio_Actual"],
                    ];
                    array_push($datos, $data);
                }
            }
        } catch
        (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($datos);
    }

    public function sqlLimpiarCarrito()
    {
        // TODO: Implement guardaCiente() method.
        try {
            $sucursal = $_SESSION["sucursal"];
            $idCierreCaja = $_SESSION['idCierreCaja'];

            $limpiarCarrito= "DELETE FROM bit_ventas WHERE sucursal=$sucursal AND guardar = 0 AND id_cierreCaja=$idCierreCaja";
            if ($ps = $this->conexion->prepare($limpiarCarrito)) {
                if ($ps->execute()) {
                    $respuesta = mysqli_stmt_affected_rows($ps);
                } else {
                    $respuesta = -1;
                }
            } else {
                $respuesta = -1;
            }
        } catch
        (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo $respuesta;
    }

    public function sqlValidarCarrito($id_Bazar)
    {
        // TODO: Implement guardaCiente() method.
        $cantidad = 0;
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar= "SELECT  COUNT(id_bazar) as CountBazar FROM bit_ventas where sucursal =$sucursal AND id_bazar= $id_Bazar";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $cantidad = $fila->CountBazar;
            } else {
                $cantidad = -1;
            }
        } catch
        (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo $cantidad;
    }


}