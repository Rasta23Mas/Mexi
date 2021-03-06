<?php
if(!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Articulo.php");
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');




class sqlArticulosComprasDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    public function sqlGuardarArticuloCompras($tipoPost, ArticuloCompras $articulo,$idPrecioCompra)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $idCierreCaja = $_SESSION['idCierreCaja'];
            $idVitrina = $articulo->getVitrina();
            $sucursal = $_SESSION["sucursal"];
            $SerieBazar = $articulo->getSerieBazar();
            $idSerieTipo = $articulo->getIdSerieTipo();
            $tipoMovimiento = $articulo->getTipoMovimiento();
            $descCorta = $articulo->getDescripcionCorta();
            $descCorta = strtoupper($descCorta);

            if ($tipoPost == "1") {
                $idTipoM = $articulo->getTipoM();
                $idKilataje = $articulo->getKilataje();
                $idCalidad = $articulo->getCalidad();
                $idCantidad = $articulo->getCantidad();
                $idPeso = $articulo->getPeso();
                $idPesoPiedra = $articulo->getPesoPiedra();
                $idPiedras = $articulo->getPiedras();
                $idObs = $articulo->getObs();
                $idDetallePrenda = $articulo->getDetallePrenda();

                $idObs = mb_strtoupper($idObs, 'UTF-8');
                $idDetallePrenda = mb_strtoupper($idDetallePrenda, 'UTF-8');
                $idObs = strtoupper($idObs);
                $idDetallePrenda = strtoupper($idDetallePrenda);
                $insert = "INSERT INTO articulo_bazar_tbl " .
                    "(id_serie,id_serieTipo,tipo_movimiento,tipoArticulo,tipo, " .
                    " kilataje, calidad, cantidad, peso, peso_Piedra, piedras,precioCompra,vitrina, " .
                    " vitrinaVenta,observaciones, detalle,descripcionCorta,sucursal,id_cierreCaja)  VALUES " .
                    " ('$SerieBazar',$idSerieTipo,$tipoMovimiento,$tipoPost,$idTipoM,$idKilataje,$idCalidad,$idCantidad,$idPeso,
                      $idPesoPiedra, $idPiedras, $idPrecioCompra,$idVitrina,$idVitrina ,' $idObs',' $idDetallePrenda ',' $descCorta ',$sucursal,$idCierreCaja)";
            } else if ($tipoPost == "2") {
                $idTipoE = $articulo->getTipoE();
                $idMarca = $articulo->getMarca();
                $idModelo = $articulo->getModelo();
                $idSerie = $articulo->getSerie();
                $idObsE = $articulo->getObsE();
                $precioCat = $articulo->getPrecioCat();
                $idDetallePrendaE = $articulo->getDetallePrendaE();
                $idObsE = mb_strtoupper($idObsE, 'UTF-8');
                $idDetallePrendaE = mb_strtoupper($idDetallePrendaE, 'UTF-8');


                $insert = "INSERT INTO articulo_bazar_tbl " .
                    "(id_serie,id_serieTipo,tipo_movimiento,tipoArticulo,tipo, " .
                    " marca, modelo, num_Serie,precioCompra,vitrina,vitrinaVenta, precioCat,   observaciones," .
                    " detalle, descripcionCorta, sucursal,id_cierreCaja)  VALUES " .
                    "('$SerieBazar',$idSerieTipo,$tipoMovimiento,$tipoPost,$idTipoE,$idMarca,$idModelo,
                       '$idSerie',$idPrecioCompra,$idVitrina,$idVitrina,$precioCat,'$idObsE',' $idDetallePrendaE ',' $descCorta ',$sucursal,$idCierreCaja)";


            }
            if ($ps = $this->conexion->prepare($insert)) {
                if ($ps->execute()) {
                    $verdad =  mysqli_stmt_affected_rows($ps);
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
    public function sqlArticulosComObsoletos(){
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        $idCierreCaja = $_SESSION['idCierreCaja'];
        $sucursal = $_SESSION["sucursal"];

        try {
            $eliminarArticulo = "DELETE FROM articulo_bazar_tbl WHERE id_Contrato = 0 and 
                                    id_cierreCaja=$idCierreCaja AND sucursal=$sucursal";
            if ($this->conexion->query($eliminarArticulo) === TRUE) {
                $verdad = 1;
            } else {
                $verdad = 2;
            }
        } catch (Exception $exc) {
            $verdad = 4;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
    }
    public function sqlBuscarArticulosCompras()

    {
        $datos = array();
        try {
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT id_ArticuloBazar,id_serie, descripcionCorta,observaciones,vitrina, precioCompra
                        FROM articulo_bazar_tbl 
                        WHERE id_Contrato=0  and id_cierreCaja=$idCierreCaja AND sucursal=$sucursal";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_ArticuloBazar" => $row["id_ArticuloBazar"],
                        "id_serie" => $row["id_serie"],
                        "descripcionCorta" => $row["descripcionCorta"],
                        "observaciones" => $row["observaciones"],
                        "vitrina" => $row["vitrina"],
                        "precioCompra" => $row["precioCompra"],
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
        //echo json_encode($datos);
    }
    public function sqlEliminarArticulo($id_ArticuloBazar)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $sucursal = $_SESSION["sucursal"];

            $eliminarArticulo = "DELETE FROM articulo_bazar_tbl WHERE id_ArticuloBazar=$id_ArticuloBazar
            AND sucursal=$sucursal";
            if ($ps = $this->conexion->prepare($eliminarArticulo)) {
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
        //return $verdad;
        echo $verdad;
    }
    public function buscarArticuloCompras()
    {
        $datos = array();
        try {
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT Ar.id_Articulo, ET.descripcion as tipo, EM.descripcion as marca, EMOD.descripcion as modelo, Ar.prestamo,
                        Ar.avaluo, Ar.detalle 
                        FROM articulo_tbl Ar
                        INNER JOIN cat_electronico_tipo ET on Ar.tipo = ET.id_tipo AND ET.sucursal= $sucursal
                        INNER JOIN cat_electronico_marca EM on Ar.marca = EM.id_marca AND EM.sucursal= $sucursal
                        INNER JOIN cat_electronico_modelo EMOD on Ar.modelo = EMOD.id_modelo AND EMOD.sucursal= $sucursal
                        WHERE id_Contrato=0 and id_cierreCaja= $idCierreCaja AND Ar.sucursal = $sucursal";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Articulo" => $row["id_Articulo"],
                        "tipo" => $row["tipo"],
                        "marca" => $row["marca"],
                        "modelo" => $row["modelo"],
                        "prestamo" => $row["prestamo"],
                        "avaluo" => $row["avaluo"],
                        "detalle" => $row["detalle"]
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
        //echo json_encode($datos);
    }


    public function buscarAforo($idTipoFormulario)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT Porcentaje FROM cat_avaluoaforo WHERE id_campoRef=$idTipoFormulario and sucursal =$sucursal";
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
        echo json_encode($data);
    }
    public function buscarMontoToken()
    {
        try {
            $buscar = "SELECT Monto FROM cat_montotoken where id = 1";
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
        echo json_encode($data);
    }



    function llenarCmbTipoPrenda(){
        $datos = array();

        try {
            $buscar = "SELECT id_tipo, descripcion FROM cat_tipoarticulo where grupo=1";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_tipo" => $row["id_tipo"],
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

        echo json_encode($datos);
    }
    function llenarCmbPrenda($idTipoCombo){
        $datos = array();

        try {
            $buscar = "SELECT id_prenda , descripcion FROM cat_prenda WHERE id_tipoArticulo=$idTipoCombo";

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_prenda" => $row["id_prenda"],
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

        echo json_encode($datos);
    }

    function llenarCmbKilataje($idTipoCombo){
        $datos = array();
        try {
            $buscar = "SELECT id_Kilataje , descripcion FROM cat_kilataje WHERE id_tipoArticulo=$idTipoCombo";

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Kilataje" => $row["id_Kilataje"],
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

        echo json_encode($datos);
    }

    function llenarKilatajePrecio($idKilataje){
        $datos = array();
        $sucursal = $_SESSION["sucursal"];
        try {
            $buscar = "SELECT precio FROM cat_kilataje_precio WHERE id_kilataje=$idKilataje and sucursal=$sucursal";

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "precio" => $row["precio"]
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

    function llenarCmbCalidad($idTipoCombo){
        $datos = array();

        try {
            $buscar = "SELECT id_calidad , descripcion FROM cat_calidad ";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_calidad" => $row["id_calidad"],
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

        echo json_encode($datos);
    }



    function llenarCmbTipoAuto()
    {
        $datos = array();

        try {
            $buscar = "SELECT id_Cat_Articulo, descripcion FROM cat_articulos where tipo='Tipo Auto'";
            $rs = $this->conexion->query($buscar);

            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Auto" => $row["id_Cat_Articulo"],
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

    function llenarCmbCatArticulos()
    {
        $datos = array();

        $sucursal = $_SESSION["sucursal"];
        try {
            $buscar = "SELECT id_tipo, descripcion FROM cat_electronico_tipo where sucursal=$sucursal";
            $rs = $this->conexion->query($buscar);

            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_tipo" => $row["id_tipo"],
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



}