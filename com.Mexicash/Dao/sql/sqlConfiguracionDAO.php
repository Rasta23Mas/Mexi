<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlConfiguracionDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    function guardarHorario($idGuardarGlb, $idHorarioIniGlb, $idHorarioFinGlb, $idEstatusGlb)
    {
        try {
            $sucursal = $_SESSION["sucursal"];

            $updateHorario = "UPDATE cat_horario SET Entrada='$idHorarioIniGlb',Salida='$idHorarioFinGlb',
                                Estatus='$idEstatusGlb'
                                WHERE Sucursal=$sucursal AND dia_Num=$idGuardarGlb";
            if ($ps = $this->conexion->prepare($updateHorario)) {
                if ($ps->execute()) {
                    $verdad = 1;
                } else {
                    $verdad = -1;
                }
            } else {
                $verdad = -1;
            }
        } catch (Exception $exc) {
            $verdad = -4;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
    }

    function llenarHorario()
    {
        $datos = array();
        $sucursal = $_SESSION["sucursal"];

        try {
            $buscar = "SELECT dia_Num ,date_format(Entrada, '%H:%i') as Entrada,
                        date_format(Salida, '%H:%i') as Salida,
                        Estatus FROM cat_horario WHERE Sucursal = $sucursal ";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "dia_Num" => $row["dia_Num"],
                        "Entrada" => $row["Entrada"],
                        "Salida" => $row["Salida"],
                        "Estatus" => $row["Estatus"]

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

    function bitacoraToken($idGuardarGlb, $idHorarioIniGlb, $idHorarioFinGlb, $idEstatusGlb,
                           $idToken, $tokenDes)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $usuario = $_SESSION["idUsuario"];
            $sucursal = $_SESSION["sucursal"];
            $id_tokenMovimiento = 11; //Modificacion de horario

            $tokenDes = mb_strtoupper($tokenDes, 'UTF-8');
            $insertaBitacora = "INSERT INTO bit_token ( token, descripcion,id_tokenMovimiento, estatus, usuario, sucursal, fecha_Creacion,
                                                        dia_Num,horario_inicial,horario_final,horario_estatus)
                                        VALUES ($idToken, '$tokenDes',$id_tokenMovimiento,1, $usuario, $sucursal,'$fechaModificacion',
                                                $idGuardarGlb,'$idHorarioIniGlb','$idHorarioFinGlb',$idEstatusGlb)";
            if ($ps = $this->conexion->prepare($insertaBitacora)) {
                if ($ps->execute()) {
                    $updateToken = "UPDATE cat_token SET
                                         estatus = 2
                                        WHERE id_token =$idToken";
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
        } catch
        (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
    }

    function sqlLlenarIvaCat()
    {
        $datos = array();
        $sucursal = $_SESSION["sucursal"];
        $idCantidad = 0;
        try {
            $buscar = "SELECT cantidad FROM cat_iva WHERE sucursal = $sucursal AND estatus=1";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $idCantidad = $fila->cantidad;
            }else{
                $idCantidad = 0;
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo $idCantidad;
    }

}