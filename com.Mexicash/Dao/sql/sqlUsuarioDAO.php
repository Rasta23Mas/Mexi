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

    function sqlNuevoLoginAutentificacion($usuario, $pass)
    {
        try {
            $buscar = "select id_User,usuario,password,id_Sucursal,tipoUsuario  from usuarios_tbl where usuario = '$usuario'";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $pass_hash = $fila->password;
                //Verifica la contraseña
                if (password_verify($pass, $pass_hash)) {
                    //valida el tipo de usuario si es admin debe preguntar la sucursal,
                    // si es otro valida si hay un inicio.
                    //Si es un superUser debe preguntar que perfil quiere copiar
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
                    $_SESSION["autentificado"] = "SI";
                    $_SESSION["ultimoAcceso"] = date("Y-n-j H:i:s");
                    //1 Es un SU
                    //2 Es un Admin
                    //3 Es gerente
                    //4 Es vendedor
                    $retorna = $tipoUsuario;

                }
            }

        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo $retorna;
    }

    function sqlValidaSiYaInicio($sucursalEnviada)
    {
        try {
            //$Validar = 1; Todo ok dejalo iniciar sesion
            //$Validar = 2; La sucursal ya cerro sesión
            //$Validar = 3; Ocurrio un error al insertar la sesión de caja
            //$Validar = 4; Ocurrio un error al insertar la sesión de SUCURSAL

            $tipoUser = $_SESSION['tipoUsuario'];
            //Admin  = 2
            // Gerente = 3 y Vendedor 4
            if ($tipoUser == 2) {
                $_SESSION["sucursal"] = $sucursalEnviada;
            }
            $sucursal = $_SESSION["sucursal"];
            $usuario = $_SESSION['idUsuario'];
            $fechaHoy = date('Y-m-d');
            $fechaCreacion = date('Y-m-d H:i:s');
            $buscarHoy = "select id_CierreCaja,id_CierreSucursal,estatus,flag_Activa from bit_cierrecaja
                            where sucursal=$sucursal 
                              AND  DATE_FORMAT(fecha_Creacion,'%Y-%m-%d')='$fechaHoy' AND usuario=$usuario";
            $statement = $this->conexion->query($buscarHoy);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                //EL usuario tiene una sesion iniciada
                $fila = $statement->fetch_object();
                $idCierreCaja = $fila->id_CierreCaja;
                $idCierreSucursal = $fila->id_CierreSucursal;
                $status = $fila->estatus;
                $flag_Activa = $fila->flag_Activa;
                if ($status = 1 && $flag_Activa == 1) {
                    //Cargamos sus sesiones de caja y sucursal
                    $_SESSION['idCierreCaja'] = $idCierreCaja;
                    $_SESSION['idCierreSucursal'] = $idCierreSucursal;
                    //Si es 1 ya inicio sesion en el día
                    $Validar = 1;
                } else {
                    //El usuario no tiene una sesion, validaremos que si exista una de la sucursal
                    //Valida que ya exista una sesion para la sucursal
                    $buscarSucHoy = "select id_CierreSucursal,estatus,flag_Activa from bit_cierresucursal 
                            where sucursal=$sucursal AND DATE_FORMAT(fecha_Creacion,'%Y-%m-%d')='$fechaHoy'";
                    $statement = $this->conexion->query($buscarSucHoy);
                    $encontro = $statement->num_rows;
                    if ($encontro > 0) {
                        //Si existe una sesion de sucursal validamos que este activa
                        $fila = $statement->fetch_object();
                        $idCierreSucursal = $fila->id_CierreSucursal;
                        $statusSucursal = $fila->estatus;
                        $flag_ActivaSucursal = $fila->flag_Activa;
                        if ($statusSucursal = 1 && $flag_ActivaSucursal == 1) {
                            $_SESSION['idCierreSucursal'] = $idCierreSucursal;
                            //Si es 1 ya inicio sesion la sucursal en el día
                            //Procedemos a insertar la sesion de caja
                            //Buscamos el id maximo
                            $idCierreCajaMax = 0;
                            $maxIdCierreSuc = "SELECT MAX( id_CierreCaja ) as idCierreCaja FROM bit_cierrecaja 
                                                WHERE sucursal = $sucursal";
                            $statement = $this->conexion->query($maxIdCierreSuc);
                            if ($statement->num_rows > 0) {
                                //Lo incrementamos
                                $fila = $statement->fetch_object();
                                $idCierreCajaMax = $fila->idCierreCaja;
                                $idCierreCajaMax++;
                            }
                            //Lo insertamos
                            $insertarCierreCaja = "INSERT INTO bit_cierrecaja 
                                (id_CierreCaja,usuario,sucursal, id_CierreSucursal, fecha_Creacion, estatus,flag_Activa) 
                                 VALUES ($idCierreCajaMax, $usuario, $sucursal,$idCierreSucursal,' $fechaCreacion',1,1)";

                            if ($ps = $this->conexion->prepare($insertarCierreCaja)) {
                                if ($ps->execute()) {
                                    //Si se inserta el registro
                                    $insertoFila = mysqli_stmt_affected_rows($ps);
                                    if ($insertoFila > 0) {
                                        $_SESSION['idCierreCaja'] = $idCierreCajaMax;
                                        $Validar = 1;

                                    } else {
                                        $Validar = 3;
                                    }
                                } else {
                                    $Validar = 3;
                                }
                            } else {
                                $Validar = 3;
                            }

                        } else {
                            //La sucursal ya cerro operaciones
                            if($usuario==2){
                                $_SESSION['idCierreSucursal'] = $idCierreSucursal;
                                $_SESSION['idCierreCaja'] = 0;
                                $Validar = 1;
                            }else{
                                $Validar = 2;
                            }

                        }
                    } else {
                        //NADIE A INICIADO SESION DE SUCURSAL
                        //Buscamose la sesion de sucursal más alta
                        $maxIdCierreSuc = "SELECT MAX(id_CierreSucursal) as idSucursal FROM bit_cierresucursal 
                                        WHERE  sucursal=$sucursal";
                        $statement = $this->conexion->query($maxIdCierreSuc);
                        $idSucursalMax = 0;
                        if ($statement->num_rows > 0) {
                            $fila = $statement->fetch_object();
                            $idSucursalMax = $fila->idSucursal;
                            $idSucursalMax++;
                        }

                        //Buscamos el importe de la boveda de la sucursal
                        //id_flujoAgente=3 esla boveda de la sucursal
                        $importeSaldoBoveda = 0;
                        $saldoBoveda = "SELECT importe FROM flujototales_tbl where id_flujoAgente=3 and sucursal=$sucursal";
                        $statementBov = $this->conexion->query($saldoBoveda);
                        if ($statementBov->num_rows > 0) {
                            $fila = $statementBov->fetch_object();
                            $importeSaldoBoveda = $fila->importe;
                        }

                        //Buscamos el saldo inicial de prestamo en el bazar
                        //tipo_movimiento=24 bazar sin apartads, abonos ni ventas
                        $InfoSaldoIni = 0;
                        $buscarSaldoIni = "SELECT SUM(prestamo) as PrestamoEmp FROM articulo_bazar_tbl
                        WHERE tipo_movimiento=24 and sucursal = $sucursal and HayMovimiento=0";
                        $statementPres = $this->conexion->query($buscarSaldoIni);
                        if ($statementPres->num_rows > 0) {
                            $fila = $statementPres->fetch_object();
                            $InfoSaldoIni = $fila->PrestamoEmp;
                        }
                        //INSERTAMOS LA NUEVA SESION DE SUCURSAL

                        $insertarCierreSucursal = "INSERT INTO bit_cierresucursal 
                            (id_CierreSucursal,	usuario, sucursal,
                             saldo_Inicial,InfoSaldoInicial,
                              fecha_Creacion, estatus,flag_Activa)  VALUES 
                            ($idSucursalMax,$usuario,$sucursal,
                             $importeSaldoBoveda,$InfoSaldoIni,
                             '$fechaCreacion',1,1 )";
                        if ($ps = $this->conexion->prepare($insertarCierreSucursal)) {
                            if ($ps->execute()) {
                                $insertoFila = mysqli_stmt_affected_rows($ps);
                                if ($insertoFila > 0) {
                                    $_SESSION['idCierreSucursal'] = $idSucursalMax;
                                    //Se inserto correctamente la sucursal y
                                    // ahora se debe insertar la sesión de caja

                                    //Procedemos a insertar la sesion de caja
                                    //Buscamos el id maximo
                                    $idCierreCajaMax = 0;
                                    $maxIdCierreSuc = "SELECT MAX( id_CierreCaja ) as idCierreCaja FROM bit_cierrecaja 
                                                WHERE sucursal = $sucursal";
                                    $statement = $this->conexion->query($maxIdCierreSuc);
                                    if ($statement->num_rows > 0) {
                                        //Lo incrementamos
                                        $fila = $statement->fetch_object();
                                        $idCierreCajaMax = $fila->idCierreCaja;
                                        $idCierreCajaMax++;
                                    }
                                    //Lo insertamos
                                    $insertarCierreCaja = "INSERT INTO bit_cierrecaja 
                                        (id_CierreCaja,usuario,sucursal, id_CierreSucursal, 
                                        fecha_Creacion, estatus,flag_Activa) 
                                        VALUES ($idCierreCajaMax, $usuario, $sucursal,$idSucursalMax,
                                        '$fechaCreacion',1,1)";
                                    if ($ps = $this->conexion->prepare($insertarCierreCaja)) {
                                        if ($ps->execute()) {
                                            //Si se inserta el registro
                                            $insertoFila = mysqli_stmt_affected_rows($ps);
                                            if ($insertoFila > 0) {
                                                $_SESSION['idCierreCaja'] = $idCierreCajaMax;
                                                $Validar = 1;
                                            } else {
                                                $Validar = 3;
                                            }
                                        } else {
                                            $Validar = 3;
                                        }
                                    } else {
                                        $Validar = 3;
                                    }

                                } else {
                                    $Validar = 4;
                                }
                            } else {
                                $Validar = 4;
                            }
                        } else {
                            $Validar = 4;
                        }
                    }
                }
            }else {

                //El usuario no tiene una sesion, validaremos que si exista una de la sucursal
                //Valida que ya exista una sesion para la sucursal
                $buscarSucHoy = "select id_CierreSucursal,estatus,flag_Activa from bit_cierresucursal 
                            where sucursal=$sucursal AND DATE_FORMAT(fecha_Creacion,'%Y-%m-%d')='$fechaHoy'";
                $statement = $this->conexion->query($buscarSucHoy);
                $encontro = $statement->num_rows;
                if ($encontro > 0) {
                    //Si existe una sesion de sucursal validamos que este activa
                    $fila = $statement->fetch_object();
                    $idCierreSucursal = $fila->id_CierreSucursal;
                    $statusSucursal = $fila->estatus;
                    $flag_ActivaSucursal = $fila->flag_Activa;
                    if ($statusSucursal = 1 && $flag_ActivaSucursal == 1) {
                        $_SESSION['idCierreSucursal'] = $idCierreSucursal;
                        //Si es 1 ya inicio sesion la sucursal en el día
                        //Procedemos a insertar la sesion de caja
                        //Buscamos el id maximo
                        $idCierreCajaMax = 0;
                        $maxIdCierreSuc = "SELECT MAX( id_CierreCaja ) as idCierreCaja FROM bit_cierrecaja 
                                                WHERE sucursal = $sucursal";
                        $statement = $this->conexion->query($maxIdCierreSuc);
                        if ($statement->num_rows > 0) {
                            //Lo incrementamos
                            $fila = $statement->fetch_object();
                            $idCierreCajaMax = $fila->idCierreCaja;
                            $idCierreCajaMax++;
                        }
                        //Lo insertamos
                        $insertarCierreCaja = "INSERT INTO bit_cierrecaja 
                                (id_CierreCaja,usuario,sucursal, id_CierreSucursal, fecha_Creacion, estatus,flag_Activa) 
                                 VALUES ($idCierreCajaMax, $usuario, $sucursal,$idCierreSucursal,' $fechaCreacion',1,1)";

                        if ($ps = $this->conexion->prepare($insertarCierreCaja)) {
                            if ($ps->execute()) {
                                //Si se inserta el registro
                                $insertoFila = mysqli_stmt_affected_rows($ps);
                                if ($insertoFila > 0) {
                                    $_SESSION['idCierreCaja'] = $idCierreCajaMax;
                                    $Validar = 1;

                                } else {
                                    $Validar = 3;
                                }
                            } else {
                                $Validar = 3;
                            }
                        } else {
                            $Validar = 3;
                        }

                    } else {
                        //La sucursal ya cerro operaciones
                        if($usuario==2){
                            $_SESSION['idCierreSucursal'] = $idCierreSucursal;
                            $_SESSION['idCierreCaja'] = 0;
                            $Validar = 1;
                        }else{
                            $Validar = 2;
                        }
                    }
                } else {
                    //NADIE A INICIADO SESION DE SUCURSAL
                    //Buscamose la sesion de sucursal más alta
                    $maxIdCierreSuc = "SELECT MAX(id_CierreSucursal) as idSucursal FROM bit_cierresucursal 
                                        WHERE  sucursal=$sucursal";
                    $statement = $this->conexion->query($maxIdCierreSuc);
                    $idSucursalMax = 0;
                    if ($statement->num_rows > 0) {
                        $fila = $statement->fetch_object();
                        $idSucursalMax = $fila->idSucursal;
                        $idSucursalMax++;
                    }

                    //Buscamos el importe de la boveda de la sucursal
                    //id_flujoAgente=3 esla boveda de la sucursal
                    $importeSaldoBoveda = 0;
                    $saldoBoveda = "SELECT importe FROM flujototales_tbl where id_flujoAgente=3 and sucursal=$sucursal";
                    $statementBov = $this->conexion->query($saldoBoveda);
                    if ($statementBov->num_rows > 0) {
                        $fila = $statementBov->fetch_object();
                        $importeSaldoBoveda = $fila->importe;
                    }

                    //Buscamos el saldo inicial de prestamo en el bazar
                    //tipo_movimiento=24 bazar sin apartads, abonos ni ventas
                    $InfoSaldoIni = 0;
                    $buscarSaldoIni = "SELECT SUM(prestamo) as PrestamoEmp FROM articulo_bazar_tbl
                        WHERE tipo_movimiento=24 and sucursal = $sucursal and HayMovimiento=0";
                    $statementPres = $this->conexion->query($buscarSaldoIni);
                    if ($statementPres->num_rows > 0) {
                        $fila = $statementPres->fetch_object();
                        $InfoSaldoIni = $fila->PrestamoEmp;
                    }

                    //INSERTAMOS LA NUEVA SESION DE SUCURSAL

                    $insertarCierreSucursal = "INSERT INTO bit_cierresucursal 
                            (id_CierreSucursal,	usuario, sucursal,
                             saldo_Inicial,InfoSaldoInicial,
                              fecha_Creacion, estatus,flag_Activa)  VALUES 
                            ($idSucursalMax,$usuario,$sucursal,
                             $importeSaldoBoveda,$InfoSaldoIni,
                             '$fechaCreacion',1,1 )";
                    if ($ps = $this->conexion->prepare($insertarCierreSucursal)) {
                        if ($ps->execute()) {
                            $insertoFila = mysqli_stmt_affected_rows($ps);
                            if ($insertoFila > 0) {
                                $_SESSION['idCierreSucursal'] = $idSucursalMax;
                                //Se inserto correctamente la sucursal y
                                // ahora se debe insertar la sesión de caja

                                //Procedemos a insertar la sesion de caja
                                //Buscamos el id maximo
                                $idCierreCajaMax = 0;
                                $maxIdCierreSuc = "SELECT MAX( id_CierreCaja ) as idCierreCaja FROM bit_cierrecaja 
                                                WHERE sucursal = $sucursal";
                                $statement = $this->conexion->query($maxIdCierreSuc);
                                if ($statement->num_rows > 0) {
                                    //Lo incrementamos
                                    $fila = $statement->fetch_object();
                                    $idCierreCajaMax = $fila->idCierreCaja;
                                    $idCierreCajaMax++;
                                }
                                //Lo insertamos
                                $insertarCierreCaja = "INSERT INTO bit_cierrecaja 
                                        (id_CierreCaja,usuario,sucursal, id_CierreSucursal, 
                                        fecha_Creacion, estatus,flag_Activa) 
                                        VALUES ($idCierreCajaMax, $usuario, $sucursal,$idSucursalMax,
                                        '$fechaCreacion',1,1)";
                                if ($ps = $this->conexion->prepare($insertarCierreCaja)) {
                                    if ($ps->execute()) {
                                        //Si se inserta el registro
                                        $insertoFila = mysqli_stmt_affected_rows($ps);
                                        if ($insertoFila > 0) {
                                            $_SESSION['idCierreCaja'] = $idCierreCajaMax;
                                            $Validar = 1;
                                        } else {
                                            $Validar = 3;
                                        }
                                    } else {
                                        $Validar = 3;
                                    }
                                } else {
                                    $Validar = 3;
                                }

                            } else {
                                $Validar = 4;
                            }
                        } else {
                            $Validar = 4;
                        }
                    } else {
                        $Validar = 4;
                    }
                }

            }

        } catch
        (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo $Validar;
    }

    function sqlBitacoraUsuario($id_Movimiento, $id_contrato, $id_almoneda, $id_cliente, $consulta_fechaInicio, $consulta_fechaFinal, $idArqueo)
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

    function sqlUsuariosCaja()
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

    function sqlHorario()
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

    function sqlGuardarPass($hashed_password, $user)
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