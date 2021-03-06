<?php
if(!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Articulo.php");
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');



class sqlArticulosDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    public function guardarArticulo($tipoPost,$idArticulo,$imei, $idPiezaNew,Articulo $articulo)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $status = 1;
            $fechaCreacion = date('Y-m-d H:i:s');
            $fechaModificacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];

            $idVitrina = $articulo->getVitrina();
            $interes = $articulo->getInteres();
            $sucursal = $_SESSION["sucursal"];
            $sucursalSerie = "0" . $_SESSION["sucursal"];



            if ($tipoPost == "1") {
                $idTipoM = $articulo->getTipoM();
                $idKilataje = $articulo->getKilataje();
                $idCalidad = $articulo->getCalidad();
                $idCantidad = $articulo->getCantidad();
                $idPeso = $articulo->getPeso();
                $idPesoPiedra = $articulo->getPesoPiedra();
                $idPiedras = $articulo->getPiedras();
                $idPrestamo = $articulo->getPrestamo();
                $idAvaluo = $articulo->getAvaluo();
                $idObs = $articulo->getObs();
                $idDetallePrenda = $articulo->getDetallePrenda();
                $descCorto = $articulo->getDescCorto();
                $idObs = mb_strtoupper($idObs, 'UTF-8');
                $idDetallePrenda = mb_strtoupper($idDetallePrenda, 'UTF-8');
                $idObs = strtoupper($idObs);
                $idDetallePrenda = strtoupper($idDetallePrenda);
                $descCorto = mb_strtoupper($descCorto, 'UTF-8');

                $insert = "INSERT INTO articulo_tbl " .
                    "(id_SerieSucursal,id_SerieArticulo,tipoArticulo,tipo, kilataje, calidad, cantidad, peso, peso_Piedra, piedras,piezas, prestamo, avaluo,vitrina, interes, observaciones," .
                    " detalle, id_Estatus, fecha_creacion, fecha_modificacion,id_cierreCaja,descripcionCorta,sucursal,IMEI)  VALUES " .
                    "('$sucursalSerie','$idArticulo',$tipoPost,'" . $idTipoM . "', '" . $idKilataje . "', '" . $idCalidad . "', '" . $idCantidad . "', '" . $idPeso
                    . "', '" . $idPesoPiedra . "', '"  . $idPiezaNew . "', '" . $idPiedras . "', '" . $idPrestamo . "', '" . $idAvaluo . "', '" . $idVitrina . "', '" . $interes . "','" . $idObs . "','"
                    . $idDetallePrenda . "','" . $status . "','" . $fechaCreacion . "','" . $fechaModificacion . "'," . $idCierreCaja . ",'$descCorto',$sucursal ,$imei)";

            } else if ($tipoPost == "2") {
                $idTipoE = $articulo->getTipoE();
                $idMarca = $articulo->getMarca();
                $idModelo = $articulo->getModelo();
                $idSerie = $articulo->getSerie();
                $idPrestamoE = $articulo->getPrestamoE();
                $idAvaluoE = $articulo->getAvaluoE();
                $idObsE = $articulo->getObsE();
                $precioCat = $articulo->getPrecioCat();
                $idDetallePrendaE = $articulo->getDetallePrendaE();
                $descCortoElectro = $articulo->getDescCortoElectro();

                $idObsE = mb_strtoupper($idObsE, 'UTF-8');
                $idDetallePrendaE = mb_strtoupper($idDetallePrendaE, 'UTF-8');
                $descCortoElectro = mb_strtoupper($descCortoElectro, 'UTF-8');

                $insert = "INSERT INTO articulo_tbl " .
                    "(id_SerieSucursal,id_SerieArticulo,tipoArticulo,tipo, marca, modelo, num_Serie, prestamo, avaluo,vitrina, precioCat, interes,  observaciones," .
                    " detalle, id_Estatus, fecha_creacion, fecha_modificacion,id_cierreCaja,descripcionCorta,sucursal,IMEI)  VALUES " .
                    "('$sucursalSerie','$idArticulo',$tipoPost,'" . $idTipoE . "','" . $idMarca . "', '" . $idModelo
                    . "', '" . $idSerie . "','" . $idPrestamoE . "', '" . $idAvaluoE . "', '" . $idVitrina . "', '" . $precioCat . "','" . $interes . "','" . $idObsE . "','"
                    . $idDetallePrendaE . "','" . $status . "','" . $fechaCreacion . "','" . $fechaModificacion . "'," . $idCierreCaja . ",'$descCortoElectro',$sucursal,$imei)";
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
        //return $verdad;
        echo $verdad;
    }

    public function buscarArticulo()
    {
        $datos = array();
        try {
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT Ar.id_Articulo, ET.descripcion as tipo, EM.descripcion as marca, EMOD.descripcion as modelo, Ar.prestamo,
                        Ar.avaluo, Ar.detalle 
                        FROM articulo_tbl Ar
                        LEFT JOIN cat_electronico_tipo ET on Ar.tipo = ET.id_tipo AND ET.sucursal= $sucursal
                        LEFT JOIN cat_electronico_marca EM on Ar.marca = EM.id_marca AND EM.sucursal= $sucursal
                        LEFT JOIN cat_electronico_modelo EMOD on Ar.modelo = EMOD.id_modelo AND EMOD.sucursal= $sucursal
                        WHERE id_Contrato=0 and id_cierreCaja=$idCierreCaja AND Ar.sucursal = $sucursal";
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

    public function hayArticulos()
    {
        try {
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $hayArticulos = 0;
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT Ar.id_Articulo
                        FROM articulo_tbl Ar
                        WHERE id_Contrato=0 and id_cierreCaja=$idCierreCaja and sucursal=$sucursal";

            $statement = $this->conexion->query($buscar);

            if ($statement->num_rows > 0) {
                $hayArticulos=1;
            }

        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo $hayArticulos;
    }
    public function buscarMetales()
    {
        $datos = array();
        try {
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT id_Articulo, TA.descripcion as tipoMetal, TK.descripcion as kilataje,TC.descripcion as calidad, 
                        prestamo,avaluo, detalle FROM articulo_tbl AR
                        INNER JOIN cat_tipoarticulo as TA on AR.tipo = TA.id_tipo
                        INNER JOIN cat_kilataje as TK on AR.kilataje = TK.id_Kilataje
                        INNER JOIN cat_calidad as TC on AR.calidad = TC.id_calidad
                        WHERE id_Contrato=0 and id_cierreCaja= $idCierreCaja and sucursal=$sucursal";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Articulo" => $row["id_Articulo"],
                        "tipoMetalArt" => $row["tipoMetal"],
                        "kilataje" => $row["kilataje"],
                        "calidad" => $row["calidad"],
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
            $buscar = "SELECT Porcentaje FROM cat_avaluoaforo 
                        WHERE id_campoRef=$idTipoFormulario and sucursal =$sucursal";
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
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT Monto FROM cat_montotoken where sucursal=$sucursal";
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
    public function eliminarArticulo($idArticulo)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $eliminarArticulo = "DELETE FROM articulo_tbl WHERE id_Articulo='$idArticulo'";

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

    function llenarCmbCatArticulos(){
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