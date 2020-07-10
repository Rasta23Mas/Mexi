<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');


class sqlTokenDAO
{

    protected $error;
    protected $conexion;
    protected $db;

    function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    //Validacion de token Cancelados
    public function tokenCancelaciones($token, $Contrato, $tipoContrato)
    {
        $token = mb_strtoupper($token, 'UTF-8');
        $fechaCreacion = date('Y-m-d H:i:s');
        $usuario = $_SESSION["idUsuario"];
        $sucursal = $_SESSION["sucursal"];
        try {
            $id = -1;
            $buscar = "SELECT id_token,descripcion FROM cat_token 
                        WHERE descripcion = '$token' and estatus= 1";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $id = $fila->id_token;
                $insertaBitacora = "INSERT INTO bit_token ( id_Contrato, tipo_Contrato,
                                                token, descripcion,id_tokenMovimiento, estatus, usuario, sucursal, fecha_Creacion)
                                        VALUES ($Contrato, $tipoContrato,
                                                '$id','$token',2,1, $usuario, $sucursal,'$fechaCreacion')";
                if ($ps = $this->conexion->prepare($insertaBitacora)) {
                    if ($ps->execute()) {
                        $updateToken = "UPDATE cat_token SET
                                         estatus = 2
                                        WHERE id_token =$id";
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
        //return $id;
    }

    //Validacion de token dotaciones
    public function tokenDotaciones($tokenDes, $idFolio, $importe, $cat_token_movimiento)
    {
        $tokenDes = mb_strtoupper($tokenDes, 'UTF-8');
        $fechaCreacion = date('Y-m-d H:i:s');
        $usuario = $_SESSION["idUsuario"];
        $sucursal = $_SESSION["sucursal"];
        try {
            $id = -1;
            $buscar = "SELECT id_token FROM cat_token 
                        WHERE descripcion = '$tokenDes' and estatus= 1";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $id = $fila->id_token;
                $insertaBitacora = "INSERT INTO bit_token (token,descripcion,id_tokenMovimiento,importe_flujo,id_flujo, estatus, usuario, sucursal, fecha_Creacion)
                                        VALUES ($id,'$tokenDes',$cat_token_movimiento,$importe,$idFolio, 1, $usuario, $sucursal,'$fechaCreacion')";
                if ($ps = $this->conexion->prepare($insertaBitacora)) {
                    if ($ps->execute()) {
                        $updateToken = "UPDATE cat_token SET
                                         estatus = 2
                                        WHERE id_token =$id";
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
        //return $id;
    }

    //Validacion de token Cancelados
    public function tokenContrato($contrato, $tipoContrato, $tipoFormulario, $token, $tokenDescripcion, $tokenMovimiento)
    {
        $token = mb_strtoupper($token, 'UTF-8');
        $fechaCreacion = date('Y-m-d H:i:s');
        $usuario = $_SESSION["idUsuario"];
        $sucursal = $_SESSION["sucursal"];
        try {

            $insertaBitacora = "INSERT INTO bit_token ( id_Contrato, tipo_Contrato,tipo_formulario, token, descripcion,
                                    id_tokenMovimiento, estatus, usuario, sucursal, fecha_Creacion)
                                    VALUES ($contrato, $tipoContrato,$tipoFormulario,$token, '$tokenDescripcion',$tokenMovimiento,
                                        1,$usuario,$sucursal,'$fechaCreacion')";
            if ($ps = $this->conexion->prepare($insertaBitacora)) {
                if ($ps->execute()) {
                    $updateToken = "UPDATE cat_token SET
                                         estatus = 2
                                        WHERE id_token =$token";
                    if ($ps = $this->conexion->prepare($updateToken)) {
                        if ($ps->execute()) {
                            $verdad = mysqli_stmt_affected_rows($ps);
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
}