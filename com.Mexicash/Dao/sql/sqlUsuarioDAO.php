<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Usuario.php");
include_once(BASE_PATH . "Conexion.php");
include_once(DAO_PATH . "UsuarioDAO.php");
date_default_timezone_set('America/Mexico_City');


class sqlUsuarioDAO
{

    protected $error;
    protected $conexion;
    protected $db;

    function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    function sqlCambioPass($usuario)
    {
        try {
            $Pass = 0;

            $buscar = "select Pass_reset  from usuarios_tbl where usuario ='$usuario'";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $Pass = $fila->Pass_reset;
            }

        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo $Pass;
    }

    function loginAutentificion($usuario, $pass)
    {
        try {
            $tipoUsuario = 0;
            $buscar = "select id_User,usuario,password,id_Sucursal,tipoUsuario  from usuarios_tbl where usuario = '$usuario'";
            $statement = $this->conexion->query($buscar);

            if ($statement->num_rows > 0) {
                    $fila = $statement->fetch_object();
                    $pass_hash = $fila->password;
                if(password_verify($pass, $pass_hash)) {
                    $id = $fila->id_User;
                    $idName = $fila->usuario;
                    $id_Sucursal = $fila->id_Sucursal;
                    $tipoUsuario =  $fila->tipoUsuario;
                    $_SESSION['idUsuario'] = $id;
                    $_SESSION['usuario'] = $idName;
                    $_SESSION['sucursal'] = $id_Sucursal;
                    $_SESSION['tipoUsuario'] = $tipoUsuario;
                    $_SESSION['sesionInactiva'] = 0;
                    $_SESSION['cajaInactiva'] = 0;
                    $_SESSION['idCierreSucursal'] = 0;
                    $_SESSION['idCierreCaja'] = 0;
                    $_SESSION["autentificado"]= "SI";
                    $_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s");
                }


            }

        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo $tipoUsuario;
    }

    function sucursalAdmin($sucursalEnviada)
    {
        try {
            $_SESSION["sucursal"] = $sucursalEnviada;
            $dotacion = 1;
            $buscar = "select id_CierreSucursal from bit_cierresucursal where flag_Activa=1 AND sucursal=$sucursalEnviada";
            $statement = $this->conexion->query($buscar);
            $encontro = $statement->num_rows;

            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $idCierreSucursal = $fila->id_CierreSucursal;
                if($idCierreSucursal==0){
                    $maxIdCierreSuc = "SELECT MAX( id_CierreSucursal ) as idSucursal FROM bit_cierresucursal WHERE  sucursal=$sucursalEnviada";
                    $statement = $this->conexion->query($maxIdCierreSuc);
                    if ($statement->num_rows > 0) {
                        $fila = $statement->fetch_object();
                        $idSucursalMax = $fila->idSucursal;
                        $idSucursalMax++;
                    } else {
                        $idSucursalMax = 1;
                    }

                    $updateSaldoInicial = "UPDATE bit_cierresucursal SET id_CierreSucursal=$idSucursalMax
                        WHERE id_CierreSucursal=0 AND sucursal=$sucursalEnviada AND estatus=1";

                    if ($ps = $this->conexion->prepare($updateSaldoInicial)) {
                        if ($ps->execute()) {
                            $insertoFila = mysqli_stmt_affected_rows($ps);
                            if ($insertoFila > 0) {
                                $buscarIdCierre = "select id_CierreSucursal  from bit_cierresucursal where sucursal = " . $sucursalEnviada . " and flag_Activa =1";
                                $resultado = $this->conexion->query($buscarIdCierre);
                                if ($resultado->num_rows > 0) {
                                    $fila = $resultado->fetch_object();
                                    $_SESSION['idCierreSucursal'] = $fila->id_CierreSucursal;
                                    $dotacion = 1;
                                    $retorna = 0;
                                }
                            } else {
                                $retorna = -1;
                            }
                        } else {
                            $retorna = -1;
                        }
                    } else {
                        $retorna = -1;
                    }
                }else{
                    $_SESSION['idCierreSucursal'] = $idCierreSucursal;
                    $retorna = 1;
                }
            } else {
                $fechaHoy = date('Y-m-d');
                $buscarHoy = "select id_CierreSucursal from bit_cierresucursal where flag_Activa=0 AND sucursal=$sucursalEnviada AND DATE(fecha_Creacion)='$fechaHoy'";
                $statement = $this->conexion->query($buscarHoy);
                $encontro = $statement->num_rows;
                if ($encontro > 0) {
                    $fila = $statement->fetch_object();
                    $idCierreSucursal = $fila->id_CierreSucursal;
                    $_SESSION['idCierreSucursal'] = $idCierreSucursal;
                    $dotacion = 0;
                    $retorna = 1;
                } else {
                    $estatus = 1;
                    $fechaCreacion = date('Y-m-d H:i:s');
                    $usuario = $_SESSION["idUsuario"];
                    $maxIdCierreSuc = "SELECT MAX( id_CierreSucursal ) as idSucursal FROM bit_cierresucursal WHERE  sucursal=$sucursalEnviada";
                    $statement = $this->conexion->query($maxIdCierreSuc);
                    if ($statement->num_rows > 0) {
                        $fila = $statement->fetch_object();
                        $idSucursalMax = $fila->idSucursal;
                        $idSucursalMax++;
                    } else {
                        $idSucursalMax = 1;
                    }
                    $insertarCierreSucursal = "INSERT INTO bit_cierresucursal " .
                        "(id_CierreSucursal,	usuario, sucursal, fecha_Creacion, estatus,flag_Activa)  VALUES " .
                        "($idSucursalMax,$usuario,$sucursalEnviada,'$fechaCreacion',$estatus,1 )";
                    if ($ps = $this->conexion->prepare($insertarCierreSucursal)) {
                        if ($ps->execute()) {
                            $insertoFila = mysqli_stmt_affected_rows($ps);
                            if ($insertoFila > 0) {
                                $buscarIdCierre = "select id_CierreSucursal  from bit_cierresucursal where sucursal = " . $sucursalEnviada . " and flag_Activa =1";
                                $resultado = $this->conexion->query($buscarIdCierre);
                                if ($resultado->num_rows > 0) {
                                    $fila = $resultado->fetch_object();
                                    $_SESSION['idCierreSucursal'] = $fila->id_CierreSucursal;
                                    $dotacion = 1;
                                    $retorna = 0;
                                }
                            } else {
                                $retorna = -1;
                            }
                        } else {
                            $retorna = -1;
                        }
                    } else {
                        $retorna = -1;
                    }
                }
            }
        } catch
        (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        $_SESSION['dotaciones'] = $dotacion;
        $_SESSION['idCierreCaja'] = 0;
        echo $retorna;
    }

    function sucursalGerente()
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $sesionInactiva = 0;
            $buscar = "select id_CierreSucursal from bit_cierresucursal where flag_Activa=1 AND sucursal=$sucursal";
            $statement = $this->conexion->query($buscar);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $idCierreSucursal = $fila->id_CierreSucursal;
                if($idCierreSucursal==0){
                    $maxIdCierreSuc = "SELECT MAX( id_CierreSucursal ) as idSucursal FROM bit_cierresucursal WHERE  sucursal=$sucursal";
                    $statement = $this->conexion->query($maxIdCierreSuc);
                    if ($statement->num_rows > 0) {
                        $fila = $statement->fetch_object();
                        $idSucursalMax = $fila->idSucursal;
                        $idSucursalMax++;
                    } else {
                        $idSucursalMax = 1;
                    }

                    $updateSaldoInicial = "UPDATE bit_cierresucursal SET id_CierreSucursal=$idSucursalMax
                        WHERE id_CierreSucursal=0 AND sucursal=$sucursal AND estatus=1";

                    if ($ps = $this->conexion->prepare($updateSaldoInicial)) {
                        if ($ps->execute()) {
                            $insertoFila = mysqli_stmt_affected_rows($ps);
                            if ($insertoFila > 0) {
                                $buscarIdCierre = "select id_CierreSucursal  from bit_cierresucursal where sucursal = " . $sucursal . " and flag_Activa =1";
                                $resultado = $this->conexion->query($buscarIdCierre);
                                if ($resultado->num_rows > 0) {
                                    $fila = $resultado->fetch_object();
                                    $_SESSION['idCierreSucursal'] = $fila->id_CierreSucursal;
                                    $retorna = 0;
                                }
                            } else {
                                $retorna = -1;
                            }
                        } else {
                            $retorna = -1;
                        }
                    } else {
                        $retorna = -1;
                    }
                }else{
                    $_SESSION['idCierreSucursal'] = $idCierreSucursal;
                    $retorna = 1;
                }

            } else {
                $fechaHoy = date('Y-m-d');
                $buscarHoy = "select id_CierreSucursal from bit_cierresucursal where flag_Activa=0 AND sucursal=$sucursal AND DATE(fecha_Creacion)='$fechaHoy'";
                $statement = $this->conexion->query($buscarHoy);
                $encontro = $statement->num_rows;
                if ($encontro > 0) {
                    $fila = $statement->fetch_object();
                    $idCierreSucursal = $fila->id_CierreSucursal;
                    $_SESSION['idCierreSucursal'] = $idCierreSucursal;
                    $sesionInactiva = 1;
                    $retorna = 1;
                } else {
                    $estatus = 1;
                    $fechaCreacion = date('Y-m-d H:i:s');
                    $usuario = $_SESSION["idUsuario"];
                    $maxIdCierreSuc = "SELECT MAX( id_CierreSucursal ) as idSucursal FROM bit_cierresucursal WHERE sucursal=$sucursal";
                    $statement = $this->conexion->query($maxIdCierreSuc);
                    if ($statement->num_rows > 0) {
                        $fila = $statement->fetch_object();
                        $idSucursalMax = $fila->idSucursal;
                        $idSucursalMax++;
                    } else {
                        $idSucursalMax = 1;
                    }

                    $insertarCierreSucursal = "INSERT INTO bit_cierresucursal " .
                        "(id_CierreSucursal,	usuario, sucursal, fecha_Creacion, estatus,flag_Activa)  VALUES " .
                        "($idSucursalMax,$usuario,$sucursal,'$fechaCreacion',$estatus,1 )";
                    if ($ps = $this->conexion->prepare($insertarCierreSucursal)) {
                        if ($ps->execute()) {
                            $insertoFila = mysqli_stmt_affected_rows($ps);
                            if ($insertoFila > 0) {
                                $buscarIdCierre = "select id_CierreSucursal  from bit_cierresucursal where sucursal = " . $sucursal . " and flag_Activa =1";
                                $resultado = $this->conexion->query($buscarIdCierre);
                                if ($resultado->num_rows > 0) {
                                    $fila = $resultado->fetch_object();
                                    $_SESSION['idCierreSucursal'] = $fila->id_CierreSucursal;
                                    $retorna = 0;
                                    $sesionInactiva = 0;
                                }
                            } else {
                                $retorna = -1;
                            }
                        } else {
                            $retorna = -1;
                        }
                    } else {
                        $retorna = -1;
                    }
                }
            }
        } catch
        (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        $_SESSION['sesionInactiva'] = $sesionInactiva;
        echo $retorna;
    }

    function cajaGerente()
    {
        try {

            $usuario = $_SESSION["idUsuario"];
            $id_CierreSucursal = $_SESSION["idCierreSucursal"];
            $sucursal = $_SESSION["sucursal"];
            $cajaInactiva  = 0;

            $buscarCajaGerente = "select id_CierreCaja from bit_cierrecaja AS Caj
                            INNER JOIN bit_cierresucursal AS Suc ON Caj.id_CierreSucursal = Suc.id_CierreSucursal
                            where Caj.usuario = $usuario and Caj.flag_Activa = 1  
                            and Suc.flag_Activa = 1 AND Suc.sucursal=$sucursal";
            $statement = $this->conexion->query($buscarCajaGerente);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $id_CierreCaja = $fila->id_CierreCaja;

                if($id_CierreCaja==0){
                    $maxIdCierreSuc = "SELECT MAX( id_CierreCaja ) as idCierreCaja FROM bit_cierrecaja WHERE sucursal = $sucursal";
                    $statement = $this->conexion->query($maxIdCierreSuc);
                    if ($statement->num_rows > 0) {
                        $fila = $statement->fetch_object();
                        $idCierreCajaMax = $fila->idCierreCaja;
                        $idCierreCajaMax++;
                    } else {
                        $idCierreCajaMax = 1;
                    }

                    $updateSaldoInicial = "UPDATE bit_cierrecaja SET id_CierreCaja=$idCierreCajaMax
                        WHERE id_CierreCaja=0 AND sucursal=$sucursal AND estatus=1";

                    if ($ps = $this->conexion->prepare($updateSaldoInicial)) {
                        if ($ps->execute()) {
                            $insertoFila = mysqli_stmt_affected_rows($ps);
                            if ($insertoFila > 0) {
                                $buscarIdCierre = "select id_Ci-erreCaja  from bit_cierrecaja where usuario = $usuario AND sucursal = $sucursal and flag_Activa =1";

                                $resultado = $this->conexion->query($buscarIdCierre);
                                if ($resultado->num_rows > 0) {
                                    $fila = $resultado->fetch_object();
                                    $_SESSION['idCierreCaja'] = $fila->id_CierreCaja;
                                    $retorna = 1;
                                    $cajaInactiva = 0;
                                }
                            } else {
                                $retorna = -1;
                            }
                        } else {
                            $retorna = -1;
                        }
                    } else {
                        $retorna = -1;
                    }
                }else{
                    $_SESSION['idCierreCaja'] = $id_CierreCaja;
                    $retorna = 1;
                }

            } else {
                $fechaHoy = date('Y-m-d');
                $buscarHoy = "select id_CierreCaja from bit_cierrecaja where flag_Activa=0 AND sucursal=$sucursal AND DATE(fecha_Creacion	)='$fechaHoy'";
                $statement = $this->conexion->query($buscarHoy);
                $encontro = $statement->num_rows;
                if ($encontro > 0) {
                    $fila = $statement->fetch_object();
                    $id_CierreCaja = $fila->id_CierreCaja;
                    $_SESSION['idCierreCaja'] = $id_CierreCaja;
                    $cajaInactiva = 1;
                    $retorna = 1;
                } else {
                    $estatus = 1;
                    $fechaCreacion = date('Y-m-d H:i:s');
                    $usuario = $_SESSION["idUsuario"];
                    $maxIdCierreSuc = "SELECT MAX( id_CierreCaja ) as idCierreCaja FROM bit_cierrecaja WHERE sucursal = $sucursal";
                    $statement = $this->conexion->query($maxIdCierreSuc);
                    if ($statement->num_rows > 0) {
                        $fila = $statement->fetch_object();
                        $idCierreCajaMax = $fila->idCierreCaja;
                        $idCierreCajaMax++;
                    } else {
                        $idCierreCajaMax = 1;
                    }

                    $insertarCierreCaja = "INSERT INTO bit_cierrecaja " .
                        "(id_CierreCaja,usuario,sucursal, id_CierreSucursal, fecha_Creacion, estatus,flag_Activa)  VALUES " .
                        "($idCierreCajaMax, $usuario, $sucursal,$id_CierreSucursal,' $fechaCreacion',$estatus,1)";

                    if ($ps = $this->conexion->prepare($insertarCierreCaja)) {
                        if ($ps->execute()) {
                            $insertoFila = mysqli_stmt_affected_rows($ps);
                            if ($insertoFila > 0) {
                                $buscarIdCierre = "select id_CierreCaja  from bit_cierrecaja where usuario = $usuario AND sucursal = $sucursal and flag_Activa =1";
                                $resultado = $this->conexion->query($buscarIdCierre);
                                if ($resultado->num_rows > 0) {
                                    $fila = $resultado->fetch_object();
                                    $_SESSION['idCierreCaja'] = $fila->id_CierreCaja;
                                    $retorna = 1;
                                    $cajaInactiva = 0;
                                }
                            } else {
                                $retorna = -1;
                            }
                        } else {
                            $retorna = -1;
                        }
                    } else {
                        $retorna = -1;
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        $_SESSION['cajaInactiva'] = $cajaInactiva;
        echo $retorna;
    }

    function sucursalVendedor()
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "select id_CierreSucursal from bit_cierresucursal where flag_Activa=1 AND sucursal=$sucursal";
            $statement = $this->conexion->query($buscar);
            $encontro = $statement->num_rows;

            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $idCierreSucursal = $fila->id_CierreSucursal;
                if($idCierreSucursal==0){
                    $maxIdCierreSuc = "SELECT MAX( id_CierreSucursal ) as idSucursal FROM bit_cierresucursal WHERE  sucursal=$sucursal";
                    $statement = $this->conexion->query($maxIdCierreSuc);
                    if ($statement->num_rows > 0) {
                        $fila = $statement->fetch_object();
                        $idSucursalMax = $fila->idSucursal;
                        $idSucursalMax++;
                    } else {
                        $idSucursalMax = 1;
                    }

                    $updateSaldoInicial = "UPDATE bit_cierresucursal SET id_CierreSucursal=$idSucursalMax
                        WHERE id_CierreSucursal=0 AND sucursal=$sucursal AND estatus=1";

                    if ($ps = $this->conexion->prepare($updateSaldoInicial)) {
                        if ($ps->execute()) {
                            $insertoFila = mysqli_stmt_affected_rows($ps);
                            if ($insertoFila > 0) {
                                $buscarIdCierre = "select id_CierreSucursal  from bit_cierresucursal  WHERE  sucursal=$sucursal and flag_Activa =1";
                                $resultado = $this->conexion->query($buscarIdCierre);
                                if ($resultado->num_rows > 0) {
                                    $fila = $resultado->fetch_object();
                                    $_SESSION['idCierreSucursal'] = $fila->id_CierreSucursal;
                                    $retorna = 0;
                                }
                            } else {
                                $retorna = -1;
                            }
                        } else {
                            $retorna = -1;
                        }
                    } else {
                        $retorna = -1;
                    }
                }else{
                    $_SESSION['idCierreSucursal'] = $idCierreSucursal;
                    $retorna = 1;
                }

            } else {
                $fechaHoy = date('Y-m-d');
                $buscarHoy = "select id_CierreSucursal from bit_cierresucursal where flag_Activa=0 AND sucursal=$sucursal AND DATE(fecha_Creacion)='$fechaHoy'";

                $statement = $this->conexion->query($buscarHoy);
                $encontro = $statement->num_rows;
                if ($encontro > 0) {
                    $fila = $statement->fetch_object();
                    $idCierreSucursal = $fila->id_CierreSucursal;
                    $_SESSION['idCierreSucursal'] = $idCierreSucursal;
                    $retorna = 2;
                } else {
                    $estatus = 1;
                    $fechaCreacion = date('Y-m-d H:i:s');
                    $usuario = $_SESSION["idUsuario"];
                    $maxIdCierreSuc = "SELECT MAX( id_CierreSucursal ) as idSucursal FROM bit_cierresucursal  WHERE  sucursal=$sucursal";
                    $statement = $this->conexion->query($maxIdCierreSuc);
                    if ($statement->num_rows > 0) {
                        $fila = $statement->fetch_object();
                        $idSucursalMax = $fila->idSucursal;
                        $idSucursalMax++;
                    } else {
                        $idSucursalMax = 1;
                    }

                    $insertarCierreSucursal = "INSERT INTO bit_cierresucursal " .
                        "(id_CierreSucursal,	usuario, sucursal, fecha_Creacion, estatus,flag_Activa)  VALUES " .
                        "($idSucursalMax,$usuario,$sucursal,'$fechaCreacion',$estatus,1 )";
                    if ($ps = $this->conexion->prepare($insertarCierreSucursal)) {
                        if ($ps->execute()) {
                            $insertoFila = mysqli_stmt_affected_rows($ps);
                            if ($insertoFila > 0) {
                                $buscarIdCierre = "select id_CierreSucursal  from bit_cierresucursal where sucursal = " . $sucursal . " and flag_Activa =1";
                                $resultado = $this->conexion->query($buscarIdCierre);
                                if ($resultado->num_rows > 0) {
                                    $fila = $resultado->fetch_object();
                                    $_SESSION['idCierreSucursal'] = $fila->id_CierreSucursal;
                                    $retorna = 0;
                                }
                            } else {
                                $retorna = -1;
                            }
                        } else {
                            $retorna = -1;
                        }
                    } else {
                        $retorna = -1;
                    }
                }
            }
        } catch
        (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $retorna;
    }

    function cajaVendedor()
    {
        try {

            $usuario = $_SESSION["idUsuario"];
            $id_CierreSucursal = $_SESSION["idCierreSucursal"];
            $sucursal = $_SESSION["sucursal"];
            $buscarCajaGerente = "select id_CierreCaja from bit_cierrecaja AS Caj
                            INNER JOIN bit_cierresucursal AS Suc ON Caj.id_CierreSucursal = Suc.id_CierreSucursal
                            where Caj.usuario = $usuario and Caj.flag_Activa = 1  and Suc.flag_Activa = 1";
            $statement = $this->conexion->query($buscarCajaGerente);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $id_CierreCaja = $fila->id_CierreCaja;

                if($id_CierreCaja==0){
                    $maxIdCierreSuc = "SELECT MAX( id_CierreCaja ) as idCierreCaja FROM bit_cierrecaja WHERE sucursal = $sucursal";
                    $statement = $this->conexion->query($maxIdCierreSuc);
                    if ($statement->num_rows > 0) {
                        $fila = $statement->fetch_object();
                        $idCierreCajaMax = $fila->idCierreCaja;
                        $idCierreCajaMax++;
                    } else {
                        $idCierreCajaMax = 1;
                    }

                    $updateSaldoInicial = "UPDATE bit_cierrecaja SET id_CierreCaja=$idCierreCajaMax
                        WHERE id_CierreCaja=0 AND sucursal=$sucursal AND estatus=1";
                    if ($ps = $this->conexion->prepare($updateSaldoInicial)) {
                        if ($ps->execute()) {
                            $insertoFila = mysqli_stmt_affected_rows($ps);
                            if ($insertoFila > 0) {
                                $buscarIdCierre = "select id_CierreCaja  from bit_cierrecaja where usuario = $usuario AND sucursal = $sucursal and flag_Activa =1";
                                $resultado = $this->conexion->query($buscarIdCierre);
                                if ($resultado->num_rows > 0) {
                                    $fila = $resultado->fetch_object();
                                    $_SESSION['idCierreCaja'] = $fila->id_CierreCaja;
                                    $retorna = 1;
                                    $cajaInactiva = 0;
                                }
                            } else {
                                $retorna = -1;
                            }
                        } else {
                            $retorna = -1;
                        }
                    } else {
                        $retorna = -1;
                    }
                }else{
                    $_SESSION['idCierreCaja'] = $id_CierreCaja;
                    $retorna = 1;
                }
            } else {
                $fechaHoy = date('Y-m-d');
                $buscarHoy = "select id_CierreCaja from bit_cierrecaja where flag_Activa=0 AND sucursal=$sucursal AND DATE(fecha_Creacion)='$fechaHoy'";
                $statement = $this->conexion->query($buscarHoy);
                $encontro = $statement->num_rows;
                if ($encontro > 0) {
                    $fila = $statement->fetch_object();
                    $id_CierreCaja = $fila->id_CierreCaja;
                    $_SESSION['idCierreCaja'] = $id_CierreCaja;
                    $retorna = 2;
                } else {
                    $estatus = 1;
                    $fechaCreacion = date('Y-m-d H:i:s');
                    $usuario = $_SESSION["idUsuario"];
                    $maxIdCierreSuc = "SELECT MAX( id_CierreCaja ) as idCierreCaja FROM bit_cierrecaja";
                    $statement = $this->conexion->query($maxIdCierreSuc);
                    if ($statement->num_rows > 0) {
                        $fila = $statement->fetch_object();
                        $idCierreCajaMax = $fila->idCierreCaja;
                        $idCierreCajaMax++;
                    } else {
                        $idCierreCajaMax = 1;
                    }

                    $insertarCierreCaja = "INSERT INTO bit_cierrecaja " .
                        "(id_CierreCaja,usuario,sucursal, id_CierreSucursal, fecha_Creacion, estatus,flag_Activa)  VALUES " .
                        "($idCierreCajaMax, $usuario, $sucursal,$id_CierreSucursal,' $fechaCreacion',$estatus,1)";

                    if ($ps = $this->conexion->prepare($insertarCierreCaja)) {
                        if ($ps->execute()) {
                            $insertoFila = mysqli_stmt_affected_rows($ps);
                            if ($insertoFila > 0) {
                                $buscarIdCierre = "select id_CierreCaja  from bit_cierrecaja where usuario = $usuario AND sucursal = " . $sucursal . " and flag_Activa =1";
                                $resultado = $this->conexion->query($buscarIdCierre);
                                if ($resultado->num_rows > 0) {
                                    $fila = $resultado->fetch_object();
                                    $_SESSION['idCierreCaja'] = $fila->id_CierreCaja;
                                    $retorna = 1;
                                }
                            } else {
                                $retorna = -1;
                            }
                        } else {
                            $retorna = -1;
                        }
                    } else {
                        $retorna = -1;
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $retorna;
    }

    function haySucursalesRegistradas()
    {
        try {
            $retorna = 0;
            $sucursal = $_SESSION["sucursal"];

            $buscar = "select id_CierreSucursal from bit_cierresucursal ";
            $statement = $this->conexion->query($buscar);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $retorna = 1;
            } else {
                $retorna = 0;
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $retorna;
    }

    function haySucursalesHoy()
    {
        try {
            $retorna = 0;
            $sucursal = $_SESSION["sucursal"];
            $fechaHoy = date('Y-m-d');

            $buscar = "select estatus,id_CierreSucursal from bit_cierresucursal WHERE  sucursal = " . $sucursal . " AND DATE(fecha_Creacion) = '$fechaHoy' and estatus !=20";

            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $estatus = $fila->estatus;
                $idCierreSucursal = $fila->id_CierreSucursal;
                $_SESSION['idCierreSucursal'] = $idCierreSucursal;
                if ($estatus == 1) {
                    $retorna = 1;
                }
                if ($estatus == 2) {
                    $_SESSION['sesionInactiva'] = 1;
                    $retorna = 2;
                }
            } else {
                $retorna = 0;
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $retorna;
    }

    function insertaCajaMaxSucursal()
    {
        try {
            $retorna = 0;
            $estatus = 1;
            $fechaCreacion = date('Y-m-d H:i:s');
            $usuario = $_SESSION["idUsuario"];
            $sucursal = $_SESSION["sucursal"];
            $maxIdCierreSuc = "SELECT MAX( id_CierreSucursal ) as idSucursal FROM bit_cierresucursal";
            $statement = $this->conexion->query($maxIdCierreSuc);
            $fila = $statement->fetch_object();
            $idSucursalMax = $fila->idSucursal;
            $idSucursalMax++;

            $insertarCierreSucursal = "INSERT INTO bit_cierresucursal " .
                "(	id_CierreSucursal, usuario, sucursal, fecha_Creacion, estatus)  VALUES " .
                "(" . $idSucursalMax . ",'" . $usuario . "','" . $sucursal . "','" . $fechaCreacion . "', '" . $estatus . "' )";

            if ($ps = $this->conexion->prepare($insertarCierreSucursal)) {
                if ($ps->execute()) {
                    $insertoFila = mysqli_stmt_affected_rows($ps);
                    if ($insertoFila > 0) {
                        $_SESSION['idCierreSucursal'] = $idSucursalMax;
                        $retorna = 1;
                    } else {
                        $retorna = -1;
                    }
                } else {
                    $retorna = -2;
                }
            } else {
                $retorna = -3;
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $retorna;
    }

    function insertaCajaSucursal($idCierreSuc)
    {
        try {
            $retorna = 0;
            $estatus = 1;
            $fechaCreacion = date('Y-m-d H:i:s');
            $fechaHoy = date('Y-m-d');
            $usuario = $_SESSION["idUsuario"];
            $sucursal = $_SESSION["sucursal"];

            $insertarCierreSucursal = "INSERT INTO bit_cierresucursal " .
                "(	id_CierreSucursal, usuario, sucursal, fecha_Creacion, estatus,flag_Activa)  VALUES " .
                "(" . $idCierreSuc . ",'" . $usuario . "','" . $sucursal . "','" . $fechaCreacion . "', '" . $estatus . "',1 )";

            if ($ps = $this->conexion->prepare($insertarCierreSucursal)) {
                if ($ps->execute()) {
                    $insertoFila = mysqli_stmt_affected_rows($ps);
                    if ($insertoFila > 0) {
                        $buscarIdCierre = "select id_CierreSucursal  from bit_cierresucursal where sucursal = " . $sucursal . " and flag_Activa =1";
                        $resultado = $this->conexion->query($buscarIdCierre);
                        if ($resultado->num_rows > 0) {
                            $fila = $resultado->fetch_object();
                            $_SESSION['idCierreSucursal'] = $fila->id_CierreSucursal;
                            $retorna = 0;
                        }
                    } else {
                        $retorna = -1;
                    }
                } else {
                    $retorna = -2;
                }
            } else {
                $retorna = -3;
            }

        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $retorna;
    }

    function bitacoraUsuario($id_Movimiento, $id_contrato, $id_almoneda, $id_cliente, $consulta_fechaInicio, $consulta_fechaFinal, $idArqueo)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $fechaCreacion = date('Y-m-d H:i:s');
            $usuario = $_SESSION["idUsuario"];
            $sucursal = $_SESSION["sucursal"];
            $id_CierreCaja = $_SESSION["idCierreCaja"];
            $id_CierreSucursal = $_SESSION["idCierreSucursal"];
            $tipoUsuario = $_SESSION['tipoUsuario'];
            if ($tipoUsuario == 1 || $tipoUsuario == 2) {
                $verdad = 1;
            } else {
                $insert = "INSERT INTO bit_usuario (usuario, sucursal, bit_cierreCaja, bit_cierreSucursal, id_Movimiento,
                        id_contrato, id_almoneda, id_cliente, consulta_fechaInicio, consulta_fechaFinal,idArqueo, fecha_Creacion)
                         VALUES 
                         ($usuario, $sucursal, $id_CierreCaja,$id_CierreSucursal, $id_Movimiento, $id_contrato, $id_almoneda,
                          $id_cliente,'$consulta_fechaInicio', '$consulta_fechaFinal',$idArqueo, '$fechaCreacion');";
                if ($ps = $this->conexion->prepare($insert)) {
                    if ($ps->execute()) {
                        $verdad = mysqli_stmt_affected_rows($ps);
                    } else {
                        $verdad = -1;
                    }
                } else {
                    $verdad = -1;
                }
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

    function usuariosCaja()
    {
        $datos = array();

        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT Usu.id_User as id_User, Usu.usuario as NombreUser 
                        FROM usuarios_tbl AS Usu 
                        Where Usu.id_Estatus=1 AND Usu.id_Caja != 0 AND Usu.id_Sucursal=$sucursal";
            $rs = $this->conexion->query($buscar);

            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_User" => $row["id_User"],
                        "NombreUser" => $row["NombreUser"]
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

    function horario()
    {
        try {
            $id = 0;
            $hora = date("H:i:s");
            $dias = array(7, 1, 2, 3, 4, 5, 6);
            $id_horario = $dias[date("w")];
            $id_Sucursal = $_SESSION['sucursal'];

            $buscarHorario = "SELECT id_horario FROM cat_horario WHERE Sucursal = $id_Sucursal AND dia_Num = $id_horario and Estatus = 1 and '$hora' BETWEEN Entrada AND Salida";
            $statement = $this->conexion->query($buscarHorario);

            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $id = $fila->id_horario;
                $_SESSION['id_horario'] = $id;
            }

        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo $id;
    }

    function busquedaCaja()
    {
        try {
            $id_CierreCaja = 0;
            $estatus = 1;
            $fechaCreacion = date('Y-m-d H:i:s');
            $usuario = $_SESSION["idUsuario"];
            $id_CierreSucursal = $_SESSION["idCierreSucursal"];
            $sucursal = $_SESSION["sucursal"];
            $tipoUsuario = $_SESSION['tipoUsuario'];

            if ($tipoUsuario == 1 || $tipoUsuario == 2) {
                $_SESSION['idCierreCaja'] = 0;
                $id_CierreCaja = 1;
            } else {
                $buscar = "select id_CierreCaja from bit_cierrecaja AS Caj
                            INNER JOIN bit_cierresucursal AS Suc ON Caj.id_CierreSucursal = Suc.id_CierreSucursal
                            where Caj.usuario = " . $usuario . " and Caj.estatus = 1  and Suc.estatus = 1";
                $statement = $this->conexion->query($buscar);
                $encontro = $statement->num_rows;
                if ($encontro > 0) {
                    $fila = $statement->fetch_object();
                    $id_CierreCaja = $fila->id_CierreCaja;
                    $_SESSION['idCierreCaja'] = $id_CierreCaja;

                } else {
                    $buscar = "select id_CierreCaja from bit_cierrecaja AS Caj
                            INNER JOIN bit_cierresucursal AS Suc ON Caj.id_CierreSucursal = Suc.id_CierreSucursal
                            where Caj.usuario = " . $usuario . " and Caj.estatus = 2  and Suc.estatus = 1";
                    $statement = $this->conexion->query($buscar);
                    $encontro = $statement->num_rows;
                    if ($encontro > 0) {
                        $fila = $statement->fetch_object();
                        $id_CierreCaja = $fila->id_CierreCaja;
                        $_SESSION['idCierreCaja'] = $id_CierreCaja;
                        $_SESSION['cajaInactiva'] = 1;
                        $id_CierreCaja = -1;
                    } else {
                        $maxIdCierreCaja = "SELECT MAX( id_CierreCaja ) as idCierreCaja FROM bit_cierrecaja";
                        $statement = $this->conexion->query($maxIdCierreCaja);
                        $encontro = $statement->num_rows;
                        if ($encontro == null) {
                            $idCierreCaja = 1;
                        } else {
                            $fila = $statement->fetch_object();
                            $idCierreCaja = $fila->idCierreCaja;
                            $idCierreCaja++;
                        }

                        $insertarCierreCaja = "INSERT INTO bit_cierrecaja " .
                            "(id_CierreCaja,usuario,sucursal, id_CierreSucursal, fecha_Creacion, estatus)  VALUES " .
                            "('" . $idCierreCaja . "','" . $usuario . "','" . $sucursal . "','" . $id_CierreSucursal . "','" . $fechaCreacion . "', '" . $estatus . "' )";

                        if ($ps = $this->conexion->prepare($insertarCierreCaja)) {
                            if ($ps->execute()) {
                                $insertoFila = mysqli_stmt_affected_rows($ps);
                                if ($insertoFila > 0) {
                                    $buscarIdCierre = "select id_CierreCaja from bit_cierrecaja AS Caj
                                    INNER JOIN bit_cierresucursal AS Suc ON Caj.id_CierreSucursal = Suc.id_CierreSucursal
                                    where Caj.usuario = " . $usuario . " and Caj.estatus = 1  and Suc.estatus = 1";
                                    $resultado = $this->conexion->query($buscarIdCierre);
                                    if ($resultado->num_rows > 0) {
                                        $fila = $resultado->fetch_object();
                                        $id_CierreCaja = $fila->id_CierreCaja;
                                        $_SESSION['idCierreCaja'] = $id_CierreCaja;
                                    }
                                }
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
        echo $id_CierreCaja;
    }

    function buscarInfoSaldoInicial()
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT SUM(prestamo) as PrestamoEmp FROM articulo_bazar_tbl
                        WHERE tipo_movimiento=24 and sucursal = $sucursal and HayMovimiento=0";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "PrestamoEmp" => $row["PrestamoEmp"],
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

    function saldosSucursal($saldoInicialInfo)
    {
        try {
            $verdad = 0;
            $id_CierreSucursal = $_SESSION["idCierreSucursal"];
            $sucursal = $_SESSION["sucursal"];
            $saldoBoveda = "SELECT importe FROM flujototales_tbl where id_flujoAgente=3 and sucursal=$sucursal";
            $statement = $this->conexion->query($saldoBoveda);
            $fila = $statement->fetch_object();
            $importeSaldoBoveda = $fila->importe;

            $updateSaldoInicial = "UPDATE bit_cierresucursal SET saldo_Inicial=$importeSaldoBoveda, InfoSaldoInicial=$saldoInicialInfo
                WHERE id_CierreSucursal=$id_CierreSucursal and estatus=1";
            if ($ps = $this->conexion->prepare($updateSaldoInicial)) {
                if ($ps->execute()) {
                    $verdad = 1;
                } else {
                    $verdad = -2;
                }
            } else {
                $verdad = -3;
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
    }

    function vendedores()
    {
        $datos = array();

        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT Usu.id_User as id_User, Usu.usuario as NombreUser 
                        From bit_cierrecaja AS BitC
                        INNER JOIN usuarios_tbl AS Usu on BitC.usuario = Usu.id_User
                        Where Usu.id_Estatus=1 AND Usu.id_Caja != 0 AND Usu.id_Sucursal=$sucursal
                        AND BitC.sucursal=$sucursal";
            $rs = $this->conexion->query($buscar);

            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_User" => $row["id_User"],
                        "NombreUser" => $row["NombreUser"]
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

    function sqlGuardarPass($hashed_password,$user)
    {
        try {
            $verdad = 0;
            $updatePassword = "UPDATE usuarios_tbl SET password='$hashed_password', Pass_reset=0
                WHERE usuario='$user'";
            if ($ps = $this->conexion->prepare($updatePassword)) {
                if ($ps->execute()) {
                    $verdad = 1;
                } else {
                    $verdad = -2;
                }
            } else {
                $verdad = -3;
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
    }
}