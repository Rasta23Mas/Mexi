<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Cliente.php");
include_once(MODELO_PATH . "ClienteActualizar.php");
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlClienteDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    public function guardaCiente($clienteData)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $idNombre = $clienteData->getNombre();
            $idApPat = $clienteData->getApellidoPat();
            $idApMat = $clienteData->getApellidoMat();
            $idSexo = $clienteData->getSexo();
            $idFechaNac = $clienteData->getFechaNacimiento();
            $idRfc = $clienteData->getRfc();
            $idCurp = $clienteData->getCurp();
            $idCelular = $clienteData->getCelular();
            $idTelefono = $clienteData->getTelefono();
            $idCorreo = $clienteData->getCorreo();
            $idOcupacion = $clienteData->getOcupacion();
            $idIdentificacion = $clienteData->getIdentificacion();
            $idNumIdentificacion = $clienteData->getNumIdentificacion();
            $idEstado = $clienteData->getEstado();
            $idMunicipio = $clienteData->getMunicipio();
            $idLocalidad = $clienteData->getLocalidad();
            $idCalle = $clienteData->getCalle();
            $idCP = $clienteData->getCodigoPostal();
            $idNumExt = $clienteData->getNumExterior();
            $idNumInt = $clienteData->getNumInterior();
            $idPromocion = $clienteData->getPromocion();
            $idMensajeInterno = $clienteData->getMensajeInterno();
            $fechaCreacion = date('Y-m-d H:i:s');
            $fechaModificacion = date('Y-m-d H:i:s');
            $usuario = $_SESSION["idUsuario"];
            $idNombre = mb_strtoupper($idNombre, 'UTF-8');
            $idApPat = mb_strtoupper($idApPat, 'UTF-8');
            $idApMat = mb_strtoupper($idApMat, 'UTF-8');
            $idCurp = mb_strtoupper($idCurp, 'UTF-8');
            $idOcupacion = mb_strtoupper($idOcupacion, 'UTF-8');
            $idCorreo = mb_strtoupper($idCorreo, 'UTF-8');
            $idNumIdentificacion = mb_strtoupper($idNumIdentificacion, 'UTF-8');
            $idRfc = mb_strtoupper($idRfc, 'UTF-8');
            $idMunicipio = mb_strtoupper($idMunicipio, 'UTF-8');
            $idLocalidad = mb_strtoupper($idLocalidad, 'UTF-8');
            $idCalle = mb_strtoupper($idCalle, 'UTF-8');
            $idMensajeInterno = mb_strtoupper($idMensajeInterno, 'UTF-8');

            $insertCliente = "INSERT INTO cliente_tbl (nombre, apellido_Pat, apellido_Mat, sexo, fecha_Nacimiento, curp," .
                " ocupacion, tipo_Identificacion, num_Identificacion, celular, rfc, telefono, correo, estado, codigo_Postal," .
                " municipio, localidad, calle, num_exterior, num_interior, mensaje,promocion, fecha_creacion, fecha_modificacion,usuario)" .
                " VALUES ('" . $idNombre . "', '" . $idApPat . "', '" . $idApMat . "', '" . $idSexo . "', '" . $idFechaNac . "','" . $idCurp . "', " .
                " '" . $idOcupacion . "', '" . $idIdentificacion . "', '" . $idNumIdentificacion . "', '" . $idCelular . "', '" . $idRfc . "', " .
                "'" . $idTelefono . "', '" . $idCorreo . "', '" . $idEstado . "', '" . $idCP . "', '" . $idMunicipio . "', '" . $idLocalidad . "', " .
                "'" . $idCalle . "'," . " '" . $idNumExt . "', '" . $idNumInt . "', '" . $idMensajeInterno . "', '" . $idPromocion . "', " .
                "'" . $fechaCreacion . "', '" . $fechaModificacion . "', '" . $usuario . "')";
            if ($ps = $this->conexion->prepare($insertCliente)) {
                if ($ps->execute()) {
                    $respuesta = 1;
                } else {
                    $respuesta = 2;
                }
            } else {
                $respuesta = 3;
            }
        } catch (Exception $exc) {
            $respuesta = 4;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        //return $verdad;
        echo $respuesta;
    }

    public function traerTodos()
    {
        $clientes = array();
        try {
            $buscar = "select * from cliente_tbl";

            $rs = $this->conexion->query($buscar);

            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $cliente = [
                        "nombre" => $row["nombre"],
                        "apellidoPat" => $row["apellido_Pat"],
                        "apellidoMat" => $row["apellido_Mat"],
                        "fechaNac" => $row["fecha_Nacimiento"],
                        "curp" => $row["curp"],
                        "celular" => $row["celular"],
                        "rfc" => $row["rfc"],
                        "telefono" => $row["telefono"],
                        "correo" => $row["correo"],
                        "estado" => $row["estado"],
                        "codigoPostal" => $row["codigo_Postal"],
                        "municipio" => $row["municipio"],
                        "calle" => $row["calle"],
                        "numExt" => $row["num_exterior"],
                        "numInt" => $row["num_interior"]
                    ];

                    array_push($clientes, $cliente);
                }

            } else {
                echo " No se ejecutó TraerTodos SqlClienteDAO";
            }

        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        return $clientes;
    }

    public function consultaClienteEmpeño($nombre, $opc)
    {

        $clien = array();
        try {
            $rs = null;
            $buscar = "";

            if ($opc == 1) {
                $buscar = "select * from cliente_tbl where concat(apellido_Mat , ' ', apellido_Pat, ' ', nombre) like concat('%', '" . $nombre . "', '%');";
            } else {
                if ($opc == 2) {
                    $buscar = "select id_Cliente, nombre, apellido_Pat, apellido_Mat, fecha_Nacimiento, curp, celular, rfc, telefono, correo, 
                    estado, codigo_Postal, municipio, colonia, calle, num_exterior, num_interior from cliente_tbl 
                    where concat(nombre, ' ', apellido_Pat, ' ', apellido_Mat) like concat('%', '" . $nombre . "', '%');";
                } else {
                    if ($opc == 3) {

                        $buscar = "SELECT c.id_Cliente, CONCAT (c.apellido_Pat , ' ', c.apellido_Mat,' ',  c.nombre) as nombreCompleto, c.fecha_Nacimiento, c.curp, c.celular, c.rfc, c.telefono, c.correo, CONCAT (c.calle, ' ', c.num_exterior, ', Interior ', c.num_interior, ', CP ', c.codigo_Postal, ', ', localidad) as direccionCompleta, e.descripcion as estado  
                                FROM cliente_tbl as c 
                                INNER JOIN cat_estado as e
                                on c.estado = e.id_Estado 
                             where concat(c.nombre, ' ', c.apellido_Pat, ' ', c.apellido_Mat) like concat('%', '" . $nombre . "', '%');";
                    }
                }
            }

            $rs = $this->conexion->query($buscar);

            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {

                    $cliente = [
                        "nombreCompleto" => $row["nombreCompleto"],
                        "fechaNac" => $row["fecha_Nacimiento"],
                        "curp" => $row["curp"],
                        "celular" => $row["celular"],
                        "rfc" => $row["rfc"],
                        "telefono" => $row["telefono"],
                        "correo" => $row["correo"],
                        "direccionCompleta" => $row["direccionCompleta"],
                        "estado" => $row["estado"]
                    ];

                    array_push($clien, $cliente);
                }

            } else {
                echo " No se ejecutó TraerTodos SqlClienteDAO";
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        return $clien;
    }


    public function buscarIdCliente($celular, $correoCliente)
    {
        try {
            $id = -1;

            $buscar = "select id_Cliente from cliente_tbl where celular = " . $celular . " and correo = '" . $correoCliente . "';";

            $statement = $this->conexion->query($buscar);

            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $id = $fila->id_Cliente;
            }

        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        return $id;
    }


    public function autocompleteCliente($idCliente)
    {
        try {
            $html = '';

            $buscar = "SELECT id_Cliente,
                       CONCAT(apellido_Pat,'/',  apellido_Mat, '/', nombre) AS NombreCompleto,
                       celular,
                       CONCAT(calle, ', ',num_interior,', ', num_exterior, ', ',localidad, ', ', municipio, ', ', cat_estado.descripcion ) AS direccionCompleta
                       FROM cliente_tbl
                       INNER JOIN cat_estado ON cliente_tbl.estado = cat_estado.id_Estado
                       WHERE
                       CONCAT(apellido_Pat, ' ', apellido_Mat, ' ',nombre) LIKE '%" . strip_tags($idCliente) . "%' LIMIT 5 ";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                while ($row = $statement->fetch_assoc()) {
                    $html .= '<div><a class="suggest-element" data="' . $row['NombreCompleto'] . '" celular="' . $row['celular']
                        . '" direccionCompleta="' . $row['direccionCompleta'] . '" id="' . $row['id_Cliente'] . '">' . $row['NombreCompleto'] . '</a></div>';
                }
            } else {
                while ($row = $statement->fetch_assoc()) {
                    $html .= '<div><a class="suggest-element"><h3>Sin sugerencias... </h3></a></div>';
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $html;

    }

    public function autocompleteClienteAbono($ClienteNombre)
    {
        try {
            $html = '';

            $buscar = "SELECT id_Cliente,
                       CONCAT(apellido_Pat,'/',  apellido_Mat, '/', nombre) AS NombreCompleto
                       FROM cliente_tbl
                       WHERE
                       CONCAT(apellido_Pat, ' ', apellido_Mat, ' ',nombre) LIKE '%" . strip_tags($ClienteNombre) . "%' LIMIT 5 ";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                while ($row = $statement->fetch_assoc()) {
                    $html .= '<div><a class="suggest-element" data="' . $row['NombreCompleto'] . '" id="' . $row['id_Cliente'] . '">' . $row['NombreCompleto'] . '</a></div>';
                }
            } else {
                while ($row = $statement->fetch_assoc()) {
                    $html .= '<div><a class="suggest-element"><h3>Sin sugerencias... </h3></a></div>';
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $html;

    }


    public function buscarClienteDatos($idClienteEditar)
    {
        $datos = array();
        try {
            $buscar = "SELECT
    nombre,
    apellido_Pat,
    apellido_Mat,
    sexo,
    fecha_Nacimiento,
    curp,
    ocupacion,
    tipo_Identificacion,
    num_Identificacion,
    celular,
    rfc,
    telefono,
    correo,
    estado,
    municipio,
    localidad,
    codigo_Postal,
    calle,
    num_exterior,
    num_interior,
    mensaje,
    promocion
FROM
    cliente_tbl
WHERE
    id_Cliente = '$idClienteEditar'";

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "nombre" => $row["nombre"],
                        "apellido_Pat" => $row["apellido_Pat"],
                        "apellido_Mat" => $row["apellido_Mat"],
                        "sexo" => $row["sexo"],
                        "fecha_Nacimiento" => $row["fecha_Nacimiento"],
                        "curp" => $row["curp"],
                        "ocupacion" => $row["ocupacion"],
                        "tipo_Identificacion" => $row["tipo_Identificacion"],
                        "num_Identificacion" => $row["num_Identificacion"],
                        "celular" => $row["celular"],
                        "rfc" => $row["rfc"],
                        "telefono" => $row["telefono"],
                        "correo" => $row["correo"],
                        "estado" => $row["estado"],
                        "municipio" => $row["municipio"],
                        "localidad" => $row["localidad"],
                        "codigo_Postal" => $row["codigo_Postal"],
                        "calle" => $row["calle"],
                        "num_exterior" => $row["num_exterior"],
                        "num_interior" => $row["num_interior"],
                        "mensaje" => $row["mensaje"],
                        "promocion" => $row["promocion"]
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

    public function actualizaCiente($idClienteEditar, $clienteData)
    {

        try {

            $idNombre = $clienteData->getNombre();
            $idApPat = $clienteData->getApellidoMat();
            $idApMat = $clienteData->getApellidoPat();
            $idSexo = $clienteData->getSexo();
            $idFechaNac = $clienteData->getFechaNacimiento();
            $idRfc = $clienteData->getRfc();
            $idCurp = $clienteData->getCurp();
            $idCelular = $clienteData->getCelular();
            $idTelefono = $clienteData->getTelefono();
            $idCorreo = $clienteData->getCorreo();
            $idOcupacion = $clienteData->getOcupacion();
            $idIdentificacion = $clienteData->getIdentificacion();
            $idNumIdentificacion = $clienteData->getNumIdentificacion();
            $idEstado = $clienteData->getEstado();
            $idMunicipio = $clienteData->getMunicipio();
            $idLocalidad = $clienteData->getLocalidad();
            $idCalle = $clienteData->getCalle();
            $idCP = $clienteData->getCodigoPostal();
            $idNumExt = $clienteData->getNumExterior();
            $idNumInt = $clienteData->getNumInterior();
            $idPromocion = $clienteData->getPromocion();
            $idMensajeInterno = $clienteData->getMensajeInterno();
            $fechaModificacion = date('Y-m-d H:i:s');
            $usuario = $_SESSION["idUsuario"];
            $idNombre = mb_strtoupper($idNombre, 'UTF-8');
            $idApPat = mb_strtoupper($idApPat, 'UTF-8');
            $idApMat = mb_strtoupper($idApMat, 'UTF-8');
            $idCurp = mb_strtoupper($idCurp, 'UTF-8');
            $idOcupacion = mb_strtoupper($idOcupacion, 'UTF-8');
            $idCorreo = mb_strtoupper($idCorreo, 'UTF-8');
            $idNumIdentificacion = mb_strtoupper($idNumIdentificacion, 'UTF-8');
            $idRfc = mb_strtoupper($idRfc, 'UTF-8');
            $idMunicipio = mb_strtoupper($idMunicipio, 'UTF-8');
            $idLocalidad = mb_strtoupper($idLocalidad, 'UTF-8');
            $idCalle = mb_strtoupper($idCalle, 'UTF-8');
            $idMensajeInterno = mb_strtoupper($idMensajeInterno, 'UTF-8');

            $updateCliente = "UPDATE cliente_tbl
SET
    nombre = '$idNombre',
    apellido_Pat = '$idApPat' ,
    apellido_Mat = '$idApMat',
    sexo = '$idSexo' ,
    fecha_Nacimiento =  '$idFechaNac' ,
    curp = '$idCurp' ,
    ocupacion = '$idOcupacion' ,
    tipo_Identificacion = '$idIdentificacion' ,
    num_Identificacion = '$idNumIdentificacion' ,
    celular = '$idCelular' ,
    rfc = '$idRfc' ,
    telefono = '$idTelefono' ,
    correo = '$idCorreo' ,
    estado = '$idEstado' ,
    codigo_Postal = '$idCP' ,
    municipio = '$idMunicipio',
    localidad = '$idLocalidad' ,
    calle = '$idCalle' ,
    num_exterior = '$idNumExt' ,
    num_interior = '$idNumInt' ,
    mensaje = '$idMensajeInterno' ,
    promocion = '$idPromocion' ,
    fecha_modificacion = '$fechaModificacion' ,
    usuario = '$usuario' 
WHERE id_Cliente = '$idClienteEditar'";

            if ($ps = $this->conexion->prepare($updateCliente)) {
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

    public function buscarClienteAgregado()
    {
        try {

            $buscar = "SELECT id_Cliente, CONCAT (apellido_Pat , ' ',apellido_Mat,' ',  nombre) as NombreCompleto, celular , CONCAT (calle, ', ',num_interior, ', ',num_exterior, ', ',  localidad, ', ',municipio,', ',cat_estado.descripcion ) as direccionCompleta FROM cliente_tbl " .
                " INNER JOIN cat_estado on cliente_tbl.estado = cat_estado.id_Estado " .
                " WHERE  id_Cliente = (SELECT MAX(id_Cliente) FROM cliente_tbl)";
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

    public function buscarClienteEditado($idClienteEditado)
    {
        try {

            $buscar = "SELECT id_Cliente, CONCAT (apellido_Pat , ' ', apellido_Mat,' ', nombre) as NombreCompleto, celular , CONCAT (calle, ', ',num_interior, ', ',num_exterior, ', ',  localidad, ', ',municipio,', ',cat_estado.descripcion ) as direccionCompleta FROM cliente_tbl " .
                " INNER JOIN cat_estado on cliente_tbl.estado = cat_estado.id_Estado " .
                " WHERE  id_Cliente = '$idClienteEditado'";
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

    public function verTodos($idNombres)
    {
        $datos = array();
        try {
            $buscar = "SELECT id_Cliente, CONCAT (apellido_Pat  , ' ',apellido_Mat,' ',nombre ) as NombreCompleto, 
                        celular , CONCAT (calle, ', ',num_interior, ', ',num_exterior, ', ',  localidad, ', ',
                        municipio,', ',cat_estado.descripcion ) as direccionCompleta FROM cliente_tbl 
                        INNER JOIN cat_estado on cliente_tbl.estado = cat_estado.id_Estado 
                        WHERE nombre LIKE '%" . strip_tags($idNombres) . "%' ";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Cliente" => $row["id_Cliente"],
                        "NombreCompleto" => $row["NombreCompleto"],
                        "celular" => $row["celular"],
                        "direccionCompleta" => $row["direccionCompleta"]
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

    public function historial($clienteEmpeno)
    {
        $datos = array();
        try {
            $buscar = "SELECT Con.id_Contrato as Contrato,Cont.id_Cliente as Cliente,
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto, 
                        CONCAT(Con.plazo, ' ', Con.periodo, ' ',Con.tipoInteres) as Interes, 
                        Con.fechaVencimiento as FechaVenc, Con.fecha_creacion as FechaCreac, 
                        CONCAT(EM.descripcion,' ', ET.descripcion, ' ',EMOD.descripcion) as ObserElec, 
                        CONCAT(Tipo.descripcion, ' ',Kil.descripcion,' ', Cal.descripcion) as ObserMetal,
                        CONCAT(Art.detalle) as Detalle,
                        Art.tipoArticulo,
                        Mov.descripcion as EstDesc
                        FROM contratomovimientos_tbl as Con 
                        INNER JOIN contrato_tbl as Cont on Con.id_contrato = Cont.id_Contrato 
                        INNER JOIN cliente_tbl as Cli on Cont.id_Cliente = Cli.id_Cliente 
                        INNER JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
                        INNER JOIN cat_movimientos as Mov on Con.tipo_movimiento = Mov.id_Movimiento 
                        LEFT JOIN cat_electronico_marca as EM on Art.marca = EM.id_marca
                        LEFT JOIN cat_electronico_modelo as EMOD on Art.modelo = EMOD.id_modelo
                        LEFT JOIN cat_electronico_tipo as ET on Art.tipo = ET.id_tipo
                        LEFT JOIN cat_kilataje as Kil on Art.kilataje = Kil.id_Kilataje
                        LEFT JOIN cat_tipoarticulo as Tipo on Art.tipo = Tipo.id_tipo
                        LEFT JOIN cat_calidad as Cal on Art.calidad = Cal.id_calidad
                        WHERE Cont.id_Cliente=$clienteEmpeno and Con.tipo_Contrato = 1";

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Contrato" => $row["Contrato"],
                        "Cliente" => $row["Cliente"],
                        "NombreCompleto" => $row["NombreCompleto"],
                        "Interes" => $row["Interes"],
                        "FechaVenc" => $row["FechaVenc"],
                        "FechaCreac" => $row["FechaCreac"],
                        "ObserElec" => $row["ObserElec"],
                        "ObserMetal" => $row["ObserMetal"],
                        "EstDesc" => $row["EstDesc"],
                        "Detalle" => $row["Detalle"],
                        "tipoArticulo" => $row["tipoArticulo"]

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

    public function historialAuto($clienteEmpeno)
    {
        $datos = array();
        try {
            $buscar = "SELECT Con.id_Contrato as Contrato,Cont.id_Cliente as Cliente,
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto, 
                        CONCAT(Con.plazo, ' ', Con.periodo, ' ',Con.tipoInteres) as Interes, 
                        Con.fechaVencimiento as FechaVenc, Con.fecha_creacion as FechaCreac, 
                        Aut.observaciones as Observ, Mov.descripcion as EstDesc,
                        CONCAT(Aut.marca, ' ', Aut.modelo) as Detalle  
                        FROM contratomovimientos_tbl as Con 
                        INNER JOIN contrato_tbl as Cont on Con.id_contrato = Cont.id_Contrato 
                        INNER JOIN cliente_tbl as Cli on Cont.id_Cliente = Cli.id_Cliente 
                        INNER JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato 
                        INNER JOIN cat_movimientos as Mov on Con.tipo_movimiento = Mov.id_Movimiento 
                        WHERE Cont.id_Cliente=$clienteEmpeno and Con.tipo_Contrato = 2";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Contrato" => $row["Contrato"],
                        "Cliente" => $row["Cliente"],
                        "NombreCompleto" => $row["NombreCompleto"],
                        "Interes" => $row["Interes"],
                        "FechaVenc" => $row["FechaVenc"],
                        "FechaCreac" => $row["FechaCreac"],
                        "Observ" => $row["Observ"],
                        "EstDesc" => $row["EstDesc"],
                        "Detalle" => $row["Detalle"]
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

    public function historialCount($clienteEmpeno)
    {
        $datos = array();
        try {
            $buscar = "SELECT SUM(Con.id_Estatus=1) as TotalEmpeno,SUM(Con.id_Estatus=2) as TotalDesem, " .
                " SUM(Con.id_Estatus=3) as TotalRefrendo,SUM(Con.id_Estatus=4) as TotalAlmoneda " .
                " FROM contrato_tbl as Con INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente " .
                " INNER JOIN cat_estatus as Sta on Con.id_Estatus = Sta.id_Estatus WHERE Con.id_Cliente=$clienteEmpeno";

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "TotalEmpeno" => $row["TotalEmpeno"],
                        "TotalDesem" => $row["TotalDesem"],
                        "TotalRefrendo" => $row["TotalRefrendo"],
                        "TotalAlmoneda" => $row["TotalAlmoneda"]
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

    public function historialCountAuto($clienteEmpeno)
    {
        $datos = array();
        try {
            $buscar = "SELECT Sum(ConMov.id_contrato) AS TotalEmpenos 
                 FROM contratomovimientos_tbl ConMov
                 INNER JOIN contrato_tbl AS Con ON ConMov.id_contrato = Con.id_Contrato
                 WHERE Con.id_Cliente = $clienteEmpeno AND ConMov.tipo_Contrato=2 
                 AND id_contrato 
                 id_contrato NOT IN (SELECT id_contrato FROM contratomovimientos_tbl 
                        WHERE tipo_movimiento = 8 || tipo_movimiento = 9 || tipo_movimiento = 10
                        || tipo_movimiento = 20 || tipo_movimiento = 24 )";
            $statement = $this->conexion->query($buscar);
            $fila = $statement->fetch_object();
            $TotalEmpenos = $fila->TotalEmpenos;


            $data = [
                "TotalEmpeno" => $TotalEmpenos,
                "TotalDesem" => $TotalEmpenos,
                "TotalRefrendo" => $TotalEmpenos,
                "TotalAlmoneda" => $TotalEmpenos
            ];
            array_push($datos, $data);


        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($datos);
    }
}