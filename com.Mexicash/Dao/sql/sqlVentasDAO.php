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
    function sqlBuscarIdBazar()
    {
        $idBazar = 0;
        //Modifique los estatus de usuario
        try {
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT id_Bazar FROM contrato_mov_baz_tbl WHERE tipo_movimiento=0 and sucursal=$sucursal";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $idBazar = $fila->id_Bazar;
            } else {
                $fechaCreacion = date('Y-m-d H:i:s');

                $id_CierreSucursal = $_SESSION["idCierreSucursal"];

                $IdBazarMax= 0;
                $buscarCompra = "select max(id_Bazar) as UltimoIdBazar from contrato_mov_baz_tbl where sucursal = $sucursal";

                $statement = $this->conexion->query($buscarCompra);
                $encontro = $statement->num_rows;
                if ($encontro > 0) {
                    $fila = $statement->fetch_object();
                    $IdBazarMax = $fila->UltimoIdBazar;
                }
                $IdBazarMax++;

                $insertaCarrito = "INSERT INTO  contrato_mov_baz_tbl
                       (id_Bazar,tipo_movimiento, id_CierreCaja,id_CierreSucursal,sucursal,fecha_creacion)
                        VALUES ($IdBazarMax,0,$idCierreCaja,$id_CierreSucursal,$sucursal,'$fechaCreacion')";
                if ($ps = $this->conexion->prepare($insertaCarrito)) {
                    if ($ps->execute()) {
                        $buscar = "SELECT id_Bazar FROM contrato_mov_baz_tbl WHERE tipo_movimiento=0 AND id_CierreCaja= $idCierreCaja  and sucursal=$sucursal";

                        $statement = $this->conexion->query($buscar);
                        if ($statement->num_rows > 0) {
                            $fila = $statement->fetch_object();
                            $idBazar = $fila->id_Bazar;
                        }
                    } else {
                        $idBazar = 0;
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $idBazar;
    }

    function busquedaApartados($codigo)
    {
        //Modifique los estatus de usuario
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT Baz.id_Contrato,Baz.id_Bazar,Baz.id_serie ,ART.descripcionCorta,
                        ART.observaciones, Baz.prestamo_Empeno,ART.avaluo,
                        Baz.precio_venta
                        FROM contrato_mov_baz_tbl as Baz
                        LEFT JOIN articulo_tbl AS ART on Baz.id_Articulo = ART.id_Articulo 
                        WHERE Baz.id_serie like '$codigo%' AND Baz.sucursal=$sucursal
                        and Baz.id_serie not in 
                        (select id_serie FROM contrato_mov_baz_tbl 
                        where sucursal=$sucursal AND tipo_movimiento = 6 || tipo_movimiento = 20 || tipo_movimiento = 22 
                        || tipo_movimiento = 23 )";
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

    function busquedaApartadosCliente($id_ClienteGlb)
    {
        $sucursal = $_SESSION["sucursal"];
        $datos = array();
        try {
            $buscar = "SELECT CON.id_Bazar,CON.apartado, ART.descripcionCorta, ART.observaciones
                        FROM contrato_mov_baz_tbl AS CON
                        LEFT JOIN bit_ventas AS BIT ON CON.id_Bazar = BIT.id_Bazar
                        LEFT JOIN articulo_bazar_tbl AS ART ON BIT.id_ArticuloBazar = ART.id_ArticuloBazar
                        WHERE CON.cliente = $id_ClienteGlb  and CON.tipo_movimiento = 22 and CON.sucursal= $sucursal and  ART.Fisico=1";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Bazar" => $row["id_Bazar"],
                        "apartado" => $row["apartado"],
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

    function busquedaAbonos($id_Bazar)
    {
        //Modifique los estatus de usuario
        $sucursal = $_SESSION["sucursal"];
        $datos = array();
        try {
            $buscar = "SELECT fecha_Creacion,subTotal,iva,total,apartado,abono,tipo_movimiento,faltaPagar
                        FROM contrato_mov_baz_tbl WHERE id_Apartado = $id_Bazar AND sucursal=$sucursal AND tipo_movimiento=22 || tipo_movimiento=23";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "fecha_Creacion" => $row["fecha_Creacion"],
                        "subTotal" => $row["subTotal"],
                        "ivaAbono" => $row["iva"],
                        "total" => $row["total"],
                        "apartadoAbono" => $row["apartado"],
                        "abonoAbono" => $row["abono"],
                        "tipo_movimientoAbono" => $row["tipo_movimiento"],
                        "faltaPagar" => $row["faltaPagar"],
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

    public function sqlBusquedaCodigo($idCodigo,$tipo,$limit,$offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($tipo == 1) {
                $count = "SELECT COUNT(id_ArticuloBazar) as  totalCount 
                            FROM articulo_bazar_tbl as ART
                            LEFT JOIN cat_adquisicion as ADQ on ART.id_serieTipo = ADQ.id_Adquisicion
                            WHERE sucursal=$sucursal  AND HayMovimiento = 0 
                            AND (id_serie like '%$idCodigo%' OR id_Contrato like '$idCodigo%')
                            AND id_ArticuloBazar NOT IN (SELECT id_ArticuloBazar FROM bit_ventas) ";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
            } else {
                $BusquedaQuery = "SELECT  id_Contrato,id_ArticuloBazar,id_serie ,ADQ.descripcion AS Adquisicion, prestamo, 
                        avaluo,vitrinaVenta, descripcionCorta,observaciones
                        FROM articulo_bazar_tbl as ART
                        LEFT JOIN cat_adquisicion as ADQ on ART.id_serieTipo = ADQ.id_Adquisicion
                        WHERE sucursal=$sucursal  AND HayMovimiento = 0 
                        AND (id_serie like '%$idCodigo%' OR id_Contrato like '$idCodigo%')
                        AND id_ArticuloBazar NOT IN (SELECT id_ArticuloBazar FROM bit_ventas)
                        ORDER BY ART.id_contrato
                        LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["id_Contrato"] = $fila["id_Contrato"];
                    $jsondataperson["id_ArticuloBazar"] = $fila["id_ArticuloBazar"];
                    $jsondataperson["id_serie"] = $fila["id_serie"];
                    $jsondataperson["Adquisicion"] = $fila["Adquisicion"];
                    $jsondataperson["prestamo"] = $fila["prestamo"];
                    $jsondataperson["avaluo"] = $fila["avaluo"];
                    $jsondataperson["vitrinaVenta"] = $fila["vitrinaVenta"];
                    $jsondataperson["descripcionCorta"] = $fila["descripcionCorta"];
                    $jsondataperson["observaciones"] = $fila["observaciones"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

   /* function sqlBusquedaCodigo($idCodigo, $tipo, $limit, $offset)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT  id_Contrato,id_ArticuloBazar,id_serie ,ADQ.descripcion AS Adquisicion, prestamo, 
                        avaluo,vitrinaVenta, descripcionCorta,observaciones
                        FROM articulo_bazar_tbl as ART
                        LEFT JOIN cat_adquisicion as ADQ on ART.id_serieTipo = ADQ.id_Adquisicion ";
            if ($tipoBusqueda == 1) {
                $buscar .= " WHERE id_serie like '%$idCodigo%' AND sucursal=$sucursal  AND HayMovimiento = 0
                        LIMIT 20";
            } else if ($tipoBusqueda == 2) {
                $buscar .= " WHERE id_Contrato like '$idCodigo%' AND sucursal= $sucursal  AND HayMovimiento = 0
                        LIMIT 20";
            } else if ($tipoBusqueda == 3) {
                $buscar .= " WHERE id_serie like '%$idCodigo%' AND sucursal= $sucursal  AND HayMovimiento = 0
                         AND id_ArticuloBazar NOT IN (SELECT id_ArticuloBazar FROM bit_ventas) LIMIT 20";
            }
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_ContratoBaz" => $row["id_Contrato"],
                        "id_ArtBazar" => $row["id_ArticuloBazar"],
                        "id_serieBaz" => $row["id_serie"],
                        "Adquisicion" => $row["Adquisicion"],
                        "empeno" => $row["prestamo"],
                        "avaluo" => $row["avaluo"],
                        "precio_Actual" => $row["vitrinaVenta"],
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
    }*/

    function busquedaCodigoSeleccionado($idCodigo)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT Baz.id_Bazar,ART.id_Articulo,Baz.precio_venta,
                        Baz.tipo_movimiento,ART.tipo,ART.kilataje,ART.calidad,
                        ART.cantidad,ART.peso,ART.peso_Piedra,ART.piedras,ART.marca,ART.modelo,
                        ART.num_Serie,ART.avaluo,ART.vitrina,ART.precioCat,ART.observaciones,ART.detalle,
                        ART.fecha_creacion,Baz.fecha_Creacion FROM contrato_mov_baz_tbl as Baz
                        LEFT JOIN articulo_tbl AS ART on Baz.id_Articulo = ART.id_Articulo AND Art.sucursal=$sucursal
                        WHERE Baz.id_serie= '$idCodigo' AND Baz.sucursal=$sucursal";
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
                        "fecha_Modificacion" => $row["fecha_Creacion"],


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
    public function sqlGuardarApartado($tipo_movimiento,$subTotal,$iva,$apartado,$faltaPagar,$total,$efectivo,$cambio,$cliente,$idBazar,$vencimiento)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];
            $Fisico = 1;
            $total = $iva + $subTotal;

            $updateContratoBaz = "UPDATE contrato_mov_baz_tbl SET tipo_movimiento = $tipo_movimiento,subTotal=$subTotal,
                                iva=$iva,total=$total,total=$total,apartado=$apartado,id_Apartado=$idBazar,faltaPagar=$faltaPagar, total=$total,efectivo=$efectivo,cambio=$cambio,
                                cliente=$cliente,fecha_Creacion='$fechaModificacion',
                                sucursal=$sucursal,id_CierreCaja=$idCierreCaja,Fisico=$Fisico, fechaVencimiento='$vencimiento'
                                WHERE id_Bazar=$idBazar AND sucursal = $sucursal";
            if ($ps = $this->conexion->prepare($updateContratoBaz)) {
                if ($ps->execute()) {
                    $updateBitVentas = "UPDATE bit_ventas SET guardar = 1
                            WHERE sucursal=$sucursal AND guardar = 0 AND id_cierreCaja=$idCierreCaja";
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

    public function sqlGuardarAbono($tipo_movimiento,$efectivo,$cambio,$id_Cliente,$idBazar,$faltaPagar,$abono,$abono_Total)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $fechaCreacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];
            $IdBazarMax= 0;
            $buscarCompra = "select max(id_Bazar) as UltimoIdBazar from contrato_mov_baz_tbl where sucursal = $sucursal";
            $statement = $this->conexion->query($buscarCompra);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $IdBazarMax = $fila->UltimoIdBazar;
            }
            $IdBazarMax++;

            $insertaAbono = "INSERT INTO contrato_mov_baz_tbl 
                       (id_Bazar,cliente,tipo_movimiento,efectivo,cambio,abono,abono_Total,faltaPagar,id_Apartado,fecha_Creacion,sucursal,id_CierreCaja)
                        VALUES ($IdBazarMax,$id_Cliente,$tipo_movimiento, $efectivo,$cambio,$abono,$abono_Total,$faltaPagar,$idBazar,'$fechaCreacion',$sucursal,$idCierreCaja)";
            if ($ps = $this->conexion->prepare($insertaAbono)) {
                if ($ps->execute()) {
                    $buscarBazar = "select max(id_Bazar) as UltimoBazarID from contrato_mov_baz_tbl where id_CierreCaja = $idCierreCaja AND sucursal=$sucursal";
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

    public function sqlGuardarVenta($tipo_movimiento, $subTotal, $iva, $descuento, $total,$totalprestamo,$utilidad, $efectivo, $cambio, $cliente, $vendedor, $idToken, $tokenDesc, $idBazar)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];
            $Fisico = 0;

            $updateContratoBaz = "UPDATE contrato_mov_baz_tbl SET tipo_movimiento = $tipo_movimiento,subTotal=$subTotal,
                                iva=$iva,descuento_Venta=$descuento,total=$total,totalPrestamo=$totalprestamo,utilidad=$utilidad,efectivo=$efectivo,cambio=$cambio,
                                cliente=$cliente,vendedor=$vendedor,fecha_Creacion='$fechaModificacion',
                                sucursal=$sucursal,id_CierreCaja=$idCierreCaja,Fisico=$Fisico
                                WHERE id_Bazar=$idBazar and sucursal= $sucursal";
            if ($ps = $this->conexion->prepare($updateContratoBaz)) {
                if ($ps->execute()) {
                    $updateBitVentas = "UPDATE bit_ventas SET guardar = 1
                            WHERE sucursal=$sucursal AND guardar = 0 AND id_cierreCaja=$idCierreCaja and sucursal= $sucursal";
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

    public function sqlArticulosUpdate($idBazar,$tipo_movimiento)
    {
        // TODO: Implement guardaCiente() method.
        try {
            if($tipo_movimiento==6){
                $Fisico = 0;
            }else{
                $Fisico = 1;
            }
            $sucursal = $_SESSION["sucursal"];
            $HayMovimiento= 1;
            $buscar = "SELECT id_ArticuloBazar as Articulo FROM bit_ventas WHERE id_Bazar=$idBazar and sucursal=$sucursal";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $articulo = $row['Articulo'];
                    $updateArtBaz = "UPDATE articulo_bazar_tbl SET tipo_movimiento = $tipo_movimiento,
                                            Fisico=$Fisico, HayMovimiento=$HayMovimiento
                                            WHERE id_ArticuloBazar=$articulo and sucursal=$sucursal";
                    if ($ps = $this->conexion->prepare($updateArtBaz)) {
                        if ($ps->execute()) {
                            $respuesta = 1;
                        } else {
                            $respuesta = -1;
                        }
                    } else {
                        $respuesta = 1;
                    }
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

    public function sqlAgregarCarrito($id_ArticuloBazar, $idCliente, $idBazar)
    {
        // TODO: Implement guardaCiente() method.
        $datos = array();
        try {
            $fechaCreacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];
            $usuario = $_SESSION["idUsuario"];
            $insertaCarrito = "INSERT INTO  bit_ventas
                       (id_Bazar,id_ArticuloBazar, id_cliente,id_vendedor,sucursal,id_cierreCaja,guardar,fecha_creacion)
                        VALUES ($idBazar,$id_ArticuloBazar,$idCliente, $usuario,$sucursal,$idCierreCaja,0,'$fechaCreacion')";
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
            $deleteCarrito = "DELETE FROM bit_ventas WHERE id_ventas = $id_Ventas";
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
                            Baz.descripcionCorta, Baz.vitrinaVenta,Baz.prestamo
                            FROM bit_ventas as Ven
                            LEFT JOIN articulo_bazar_tbl as Baz on Ven.id_ArticuloBazar = Baz.id_ArticuloBazar
                            WHERE Ven.sucursal=$sucursal AND Baz.sucursal=$sucursal AND Ven.guardar = 0 AND Ven.id_cierreCaja=$idCierreCaja";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_ventas" => $row["id_ventas"],
                        "Codigo" => $row["Codigo"],
                        "id_ContratoVentas" => $row["id_Contrato"],
                        "descripcionCorta" => $row["descripcionCorta"],
                        "precio_Actual" => $row["vitrinaVenta"],
                        "prestamo" => $row["prestamo"],
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

            $limpiarCarrito = "DELETE FROM bit_ventas WHERE sucursal=$sucursal AND guardar = 0 AND id_cierreCaja=$idCierreCaja";
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

    public function sqlValidarCarrito($id_ArticuloBazar)
    {
        // TODO: Implement guardaCiente() method.
        $cantidad = 0;
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT  COUNT(id_ArticuloBazar) as CountBazar FROM bit_ventas where sucursal =$sucursal AND id_ArticuloBazar= $id_ArticuloBazar";
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

    public function sqlValidarPrecioMod($idPrecioMod,$idArticulo,$idCodigoAutMod)
    {
        $idCodigoAutMod = mb_strtoupper($idCodigoAutMod, 'UTF-8');

        try {
            $id = -1;
            $verdad = 0;

            $buscar = "SELECT id_token,descripcion FROM cat_token 
                        WHERE descripcion = '$idCodigoAutMod' and estatus= 1";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $id = $fila->id_token;
                $updatePrecio = "UPDATE articulo_bazar_tbl SET
                                         vitrinaVenta = $idPrecioMod
                                        WHERE id_ArticuloBazar =$idArticulo";
                if ($ps = $this->conexion->prepare($updatePrecio)) {
                    if ($ps->execute()) {
                        $updateToken = "UPDATE cat_token SET
                                         estatus = 2
                                        WHERE id_token =$id";
                        $verdad = 1;
                    } else {
                        $verdad = -1;
                    }
                } else {
                    $verdad = -1;
                }
            } else {
                $id = -1;
            }

        } catch (Exception $exc) {
            $id = -1;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
        //return $id;
    }

}