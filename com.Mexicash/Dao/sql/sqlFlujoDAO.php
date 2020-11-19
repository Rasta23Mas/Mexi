<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Usuario.php");
include_once(BASE_PATH . "Conexion.php");
include_once(DAO_PATH . "UsuarioDAO.php");
date_default_timezone_set('America/Mexico_City');


class sqlFlujoDAO
{

    protected $error;
    protected $conexion;
    protected $db;

    function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }


    function busquedaFlujo()
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT id_flujototal, id_flujoAgente, importe, sucursal FROM flujototales_tbl
                       WHERE id_flujoAgente = 1 OR id_flujoAgente = 2 OR id_flujoAgente =3";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_flujototal" => $row["id_flujototal"],
                        "id_flujoAgente" => $row["id_flujoAgente"],
                        "importe" => $row["importe"],
                        "sucursal" => $row["sucursal"],
                        "sucursalSesion" => $sucursal,
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

    function validaCaja($idUsuarioCaja)
    {
        try {
            $fechaHoy = date('Y-m-d');

            $buscar = "SELECT Caj.estatus FROM bit_cierrecaja AS Caj
                        INNER JOIN bit_cierresucursal AS Suc ON Caj.id_CierreSucursal = Suc.id_CierreSucursal
                    WHERE Caj.usuario = $idUsuarioCaja and DATE(Caj.fecha_Creacion)  = '$fechaHoy' AND SUc.estatus=1";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $estatus = $fila->estatus;
            } else {
                $estatus = 0;
            }
            $retorna = $estatus;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $retorna;
    }

    function busquedaCajaDot($idUsuarioCaja)
    {
        $datos = array();
        try {
            $buscar = "SELECT importe FROM flujototales_tbl 
                        WHERE usuario=$idUsuarioCaja";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "importe" => $row["importe"]
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

    function busquedaCaja($idUsuarioCaja)
    {
        $datos = array();
        try {
            $idCierreSucursal = $_SESSION["idCierreSucursal"];
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT id_cat_flujo, importe FROM flujo_tbl 
                        WHERE usuarioCaja=$idUsuarioCaja AND id_cierreSucursal= $idCierreSucursal
                         AND sucursal = $sucursal AND (id_cat_flujo=5 || id_cat_flujo=6)";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_cat_flujo" => $row["id_cat_flujo"],
                        "importe" => $row["importe"]
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

    function generarFolio()
    {
        $datos = array();
        try {
            $estatus = 0;
            $fechaCreacion = date('Y-m-d H:i:s');
            $usuario = $_SESSION["idUsuario"];
            $sucursal = $_SESSION["sucursal"];
            $idCierreSucursal = $_SESSION["idCierreSucursal"];
            $id_flujo = "";
            $buscarFlujo = "SELECT  id_flujo  FROM flujo_tbl
                       WHERE sucursal= $sucursal and estatus = 0 ";
            $statement = $this->conexion->query($buscarFlujo);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $id_flujo = $fila->id_flujo;
            } else {
                $sucursal = $_SESSION["sucursal"];
                $IdFlujoMax= 0;
                $buscarCompra = "select max(id_flujo) as UltimoFlujo from flujo_tbl where sucursal = $sucursal";
                $statement = $this->conexion->query($buscarCompra);
                $encontro = $statement->num_rows;
                if ($encontro > 0) {
                    $fila = $statement->fetch_object();
                    $IdFlujoMax = $fila->UltimoFlujo;
                }
                $IdFlujoMax++;


                $insertarFlujo = "INSERT INTO flujo_tbl " .
                    "(id_flujo, usuario, sucursal, id_cierreSucursal, estatus, fechaCreacion)  VALUES " .
                    "($IdFlujoMax, $usuario, $sucursal, $idCierreSucursal, $estatus,'$fechaCreacion')";
                if ($ps = $this->conexion->prepare($insertarFlujo)) {
                    if ($ps->execute()) {
                        $insertoFila = mysqli_stmt_affected_rows($ps);
                        if ($insertoFila > 0) {
                            $buscarFlujoGenerado = "SELECT  id_flujo  FROM flujo_tbl WHERE sucursal= $sucursal and estatus = 0 ";
                            $statement = $this->conexion->query($buscarFlujoGenerado);
                            $encontro = $statement->num_rows;
                            if ($encontro > 0) {
                                $fila = $statement->fetch_object();
                                $id_flujo = $fila->id_flujo;
                            } else {
                                $id_flujo = 0;
                            }
                        } else {
                            $id_flujo = 0;
                        }
                    } else {
                        $id_flujo = 0;
                    }
                } else {
                    $id_flujo = 0;
                }

            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $id_flujo;
    }

    public function updateTotalesCentral($saldoCentralFinal, $saldoBancoFinal, $saldoBovedaFinal)
    {
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $sucursal = $_SESSION["sucursal"];
            $updateCentral = "UPDATE flujototales_tbl SET importe=$saldoCentralFinal,fechaModificacion='$fechaModificacion'
                WHERE sucursal=$sucursal and id_flujoAgente=1";
            if ($ps = $this->conexion->prepare($updateCentral)) {
                if ($ps->execute()) {
                    $updateBanco = "UPDATE flujototales_tbl SET importe=$saldoBancoFinal,fechaModificacion='$fechaModificacion'
                WHERE sucursal=$sucursal and id_flujoAgente=2";
                    if ($ps = $this->conexion->prepare($updateBanco)) {
                        if ($ps->execute()) {
                            $updateBoveda = "UPDATE flujototales_tbl SET importe=$saldoBovedaFinal,fechaModificacion='$fechaModificacion'
                WHERE sucursal=$sucursal and id_flujoAgente=3";
                            if ($ps = $this->conexion->prepare($updateBoveda)) {
                                if ($ps->execute()) {
                                    $verdad = 1;
                                } else {
                                    $verdad = -1;
                                }
                            } else {
                                $verdad = -1;
                            }
                        } else {
                            $verdad = -1;
                        }
                    } else {
                        $verdad = -1;
                    }
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

    public function updateTotalesUsuario($saldoBovedaFinal, $saldoCajaFinal, $idUsuarioCaja)
    {
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $sucursal = $_SESSION["sucursal"];
            $updateBoveda = "UPDATE flujototales_tbl SET importe=$saldoBovedaFinal,fechaModificacion='$fechaModificacion'
                WHERE sucursal=$sucursal and id_flujoAgente=3";
            if ($ps = $this->conexion->prepare($updateBoveda)) {
                if ($ps->execute()) {
                    $updateCaja = "UPDATE flujototales_tbl SET importe=$saldoCajaFinal,fechaModificacion='$fechaModificacion'
                WHERE sucursal=$sucursal and id_flujoAgente=4 and usuario=$idUsuarioCaja";
                    if ($ps = $this->conexion->prepare($updateCaja)) {
                        if ($ps->execute()) {
                            $verdad = 1;
                        } else {
                            $verdad = -1;
                        }
                    } else {
                        $verdad = -1;
                    }
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

    public function updateFlujo($id_catFlujo, $importe, $idFolio, $concepto, $usuarioCaja, $importeLetra,$Central,$Banco,$Boveda,$Caja)
    {
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {
            $fechaCreacion = date('Y-m-d H:i:s');
            $usuario = $_SESSION["idUsuario"];
            $concepto = mb_strtoupper($concepto, 'UTF-8');
            $idCierreSucursal = $_SESSION["idCierreSucursal"];

            $updateFlujo = "UPDATE flujo_tbl SET importe=$importe,importeLetra='$importeLetra',id_cat_flujo=$id_catFlujo,
                fechaCreacion='$fechaCreacion',estatus=1,concepto = '$concepto',usuario=$usuario,usuarioCaja=$usuarioCaja,
                id_cierreSucursal=$idCierreSucursal,Central=$Central,Banco=$Banco,Boveda=$Boveda,Caja=$Caja  
                WHERE id_flujo=$idFolio";
            if ($ps = $this->conexion->prepare($updateFlujo)) {
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

    function busquedaFolio($idFolioBuscar)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT id_cat_flujo FROM flujo_tbl
                       WHERE id_flujo= $idFolioBuscar and sucursal=$sucursal ";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_cat_flujo" => $row["id_cat_flujo"],
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


    //Arqueo Fljujo
    public function guardarAjustesArqueo($tipo, $importe)
    {
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {
            $fechaCreacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION["idCierreCaja"];

            $insertarFlujo = "INSERT INTO flujo_arqueo " .
                "( importe, tipo, id_cierreCaja, fecha_Creacion)  VALUES " .
                "(" . $importe . "," . $tipo . "," . $idCierreCaja . ",'" . $fechaCreacion . "')";
            if ($ps = $this->conexion->prepare($insertarFlujo)) {
                if ($ps->execute()) {
                    $insertoFila = mysqli_stmt_affected_rows($ps);
                    if ($insertoFila > 0) {
                        $buscarFlujoGenerado = "SELECT max(id_flujoArqueo) as idflujoArqueo FROM flujo_arqueo";
                        $statement = $this->conexion->query($buscarFlujoGenerado);
                        $encontro = $statement->num_rows;
                        if ($encontro > 0) {
                            $fila = $statement->fetch_object();
                            $id_flujo = $fila->idflujoArqueo;
                        } else {
                            $id_flujo = 0;
                        }
                    } else {
                        $id_flujo = 0;
                    }
                } else {
                    $id_flujo = 0;
                }
            } else {
                $id_flujo = 0;
            }

        } catch (Exception $exc) {
            $verdad = -1;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $id_flujo;
    }

    public function guardarFlujoArqueo($id_catFlujo, $importe, $usuarioCaja, $importeLetra)
    {
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {

            $sucursal = $_SESSION["sucursal"];
            $buscarFlujoGenerado = "SELECT id_flujo FROM flujo_tbl WHERE id_cat_flujo= 0 and sucursal=$sucursal ";
            $statement = $this->conexion->query($buscarFlujoGenerado);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $id_flujo = $fila->id_flujo;
                $fechaCreacion = date('Y-m-d H:i:s');
                $usuario = $_SESSION["idUsuario"];
                $concepto = "ARQUEO";
                $updateFlujo = "UPDATE flujo_tbl SET importe=$importe,importeLetra='$importeLetra',id_cat_flujo=$id_catFlujo,
                fechaCreacion='$fechaCreacion',estatus=1,concepto = '$concepto',usuario=$usuario,usuarioCaja=$usuarioCaja 
                WHERE id_flujo=$id_flujo";
                if ($ps = $this->conexion->prepare($updateFlujo)) {
                    if ($ps->execute()) {
                        $sucursal = $_SESSION["sucursal"];
                        $buscarSaldoBoveda = "SELECT importe as ImporteBoveda FROM flujototales_tbl  
                                                WHERE sucursal=$sucursal and id_flujoAgente=3";
                        $statement = $this->conexion->query($buscarSaldoBoveda);
                        $encontro = $statement->num_rows;
                        if ($encontro > 0) {
                            $fila = $statement->fetch_object();
                            $importeBoveda = $fila->ImporteBoveda;
                            $nuevoImporte = $importeBoveda + $importe;
                            $updateBoveda = "UPDATE flujototales_tbl SET importe=$nuevoImporte,
                                            fechaModificacion='$fechaCreacion'
                                            WHERE sucursal=$sucursal and id_flujoAgente=3";
                            if ($ps = $this->conexion->prepare($updateBoveda)) {
                                if ($ps->execute()) {
                                    if ($id_catFlujo == 7) {
                                        $buscarSaldoBoveda = "SELECT importe as ImporteCaja FROM flujototales_tbl  
                                                WHERE usuario=$usuarioCaja";
                                        $statement = $this->conexion->query($buscarSaldoBoveda);
                                        $encontro = $statement->num_rows;
                                        if ($encontro > 0) {
                                            $fila = $statement->fetch_object();
                                            $ImporteCaja = $fila->ImporteCaja;
                                            $nuevoImporteCaja = $ImporteCaja - $importe;
                                            $updateCaja = "UPDATE flujototales_tbl SET importe=$nuevoImporteCaja,
                                            fechaModificacion='$fechaCreacion'
                                            WHERE usuario=$usuarioCaja";
                                            if ($ps = $this->conexion->prepare($updateCaja)) {
                                                if ($ps->execute()) {
                                                    $verdad = 33;
                                                } else {
                                                    $verdad = -1;
                                                }
                                            }
                                        } else {
                                            $verdad = -12;
                                        }
                                    } else {
                                        $verdad = 3;
                                    }
                                } else {
                                    $verdad = -1;
                                }
                            }
                        } else {
                            $verdad = -1;
                        }
                    } else {
                        $verdad = -1;
                    }


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

    public function updateBovedaAjustes($saldoCentralFinal, $saldoBancoFinal, $saldoBovedaFinal)
    {
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $sucursal = $_SESSION["sucursal"];
            $updateCentral = "UPDATE flujototales_tbl SET importe=$saldoCentralFinal,fechaModificacion='$fechaModificacion'
                WHERE sucursal=$sucursal and id_flujoAgente=1";
            if ($ps = $this->conexion->prepare($updateCentral)) {
                if ($ps->execute()) {
                    $updateBanco = "UPDATE flujototales_tbl SET importe=$saldoBancoFinal,fechaModificacion='$fechaModificacion'
                WHERE sucursal=$sucursal and id_flujoAgente=2";
                    if ($ps = $this->conexion->prepare($updateBanco)) {
                        if ($ps->execute()) {
                            $updateBoveda = "UPDATE flujototales_tbl SET importe=$saldoBovedaFinal,fechaModificacion='$fechaModificacion'
                WHERE sucursal=$sucursal and id_flujoAgente=3";
                            if ($ps = $this->conexion->prepare($updateBoveda)) {
                                if ($ps->execute()) {
                                    $verdad = 1;
                                } else {
                                    $verdad = -1;
                                }
                            } else {
                                $verdad = -1;
                            }
                        } else {
                            $verdad = -1;
                        }
                    } else {
                        $verdad = -1;
                    }
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
}
