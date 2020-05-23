<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Usuario.php");
include_once(BASE_PATH . "Conexion.php");
include_once(SERVICIOS_PATH . "Errores.php");
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

    function loginAutentificion($usuario, $pass)
    {
        try {
            $id = -1;

            $buscar = "select id_User,usuario,id_Sucursal,tipoUsuario  from usuarios_tbl where usuario = '" . $usuario . "' and password = '" . $pass . "'";

            $statement = $this->conexion->query($buscar);

            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $id = $fila->id_User;
                $idName = $fila->usuario;
                $id_Sucursal = $fila->id_Sucursal;
                $tipoUsuario = $fila->tipoUsuario;
                $_SESSION['idUsuario'] = $id;
                $_SESSION['usuario'] = $idName;
                $_SESSION['sucursal'] = $id_Sucursal;
                $_SESSION['tipoUsuario'] = $tipoUsuario;
                $_SESSION['sesionInactiva'] = 0;
                $_SESSION['cajaInactiva'] = 0;
                $_SESSION['idCierreSucursal'] = 0;
                $_SESSION['idCierreCaja'] = 0;
            }

        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo $tipoUsuario;
    }

    function haySucursalesRegistradas(){
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

    function haySucursalesHoy(){
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

    function insertaCajaMaxSucursal(){
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

    function insertaCajaSucursal($idCierreSuc){
        try {
            $retorna = 0;
            $estatus = 1;
            $fechaCreacion = date('Y-m-d H:i:s');
            $fechaHoy = date('Y-m-d');
            $usuario = $_SESSION["idUsuario"];
            $sucursal = $_SESSION["sucursal"];

            $insertarCierreSucursal = "INSERT INTO bit_cierresucursal " .
                "(	id_CierreSucursal, usuario, sucursal, fecha_Creacion, estatus)  VALUES " .
                "(" . $idCierreSuc . ",'" . $usuario . "','" . $sucursal . "','" . $fechaCreacion . "', '" . $estatus . "' )";

            if ($ps = $this->conexion->prepare($insertarCierreSucursal)) {
                if ($ps->execute()) {
                    $insertoFila = mysqli_stmt_affected_rows($ps);
                    if ($insertoFila > 0) {
                        $buscarIdCierre = "select id_CierreSucursal  from bit_cierresucursal where sucursal = " . $sucursal . " and estatus = $estatus AND DATE(fecha_Creacion) = '$fechaHoy'";
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

    function bitacoraUsuario($id_Movimiento, $id_contrato, $id_almoneda, $id_cliente, $consulta_fechaInicio, $consulta_fechaFinal, $idArqueo){
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

            $buscar = "SELECT  Flu.usuario as id_User, Usu.usuario as NombreUser
                        FROM flujototales_tbl AS Flu
                        INNER JOIN usuarios_tbl as Usu on Flu.usuario = Usu.id_User
                        Where Usu.id_Estatus=1 AND tipoUsuario != 1 AND id_Sucursal=$sucursal ";
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

    function horario(){
        try {
            $id = 0;
            $hora = date("H:i:s");
            $dias = array(7, 1, 2, 3, 4, 5, 6);
            $id_horario = $dias[date("w")];

            $buscarHorario = "SELECT id_horario FROM cat_horario WHERE id_horario = $id_horario and Estatus = 1 and '$hora' BETWEEN Entrada AND Salida";
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

    function busquedaCaja(){
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
                    }else{
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

    function saldosSucursal($saldoInicial){
        try {
            $retorna = 0;
            $id_CierreSucursal = $_SESSION["idCierreSucursal"];

            $saldoBoveda = "SELECT importe FROM flujototales_tbl where id_flujoAgente=3";
            $statement = $this->conexion->query($saldoBoveda);
            $fila = $statement->fetch_object();
            $importeSaldoBoveda = $fila->importe;


            $updateSaldoInicial = "UPDATE bit_cierresucursal SET saldo_Inicial=$importeSaldoBoveda,DepoSaldoInicial=$saldoInicial
                WHERE id_CierreSucursal=$id_CierreSucursal and estatus=1";
            if ($ps = $this->conexion->prepare($updateSaldoInicial)) {
                if ($ps->execute()) {
                    $verdad = 1;
                } else {
                    $verdad = -1;
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

    function vendedores()
    {
        $datos = array();

        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT  Usu.usuario as id_User, Usu.usuario as NombreUser
                        FROM usuarios_tbl AS Usu
                        Where Usu.id_Estatus=1 AND id_Sucursal=$sucursal  AND tipoUsuario = 3 OR tipoUsuario=4 ";
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
}