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
            $sucursal = $_SESSION["sucursal"];


            $insertCliente = "INSERT INTO cliente_tbl (nombre, apellido_Pat, apellido_Mat, sexo, fecha_Nacimiento, curp," .
                " ocupacion, tipo_Identificacion, num_Identificacion, celular, rfc, telefono, correo, estado, codigo_Postal," .
                " municipio, localidad, calle, num_exterior, num_interior, mensaje,promocion, fecha_creacion, fecha_modificacion,usuario,sucursal)" .
                " VALUES ('" . $idNombre . "', '" . $idApPat . "', '" . $idApMat . "', '" . $idSexo . "', '" . $idFechaNac . "','" . $idCurp . "', " .
                " '" . $idOcupacion . "', '" . $idIdentificacion . "', '" . $idNumIdentificacion . "', '" . $idCelular . "', '" . $idRfc . "', " .
                "'" . $idTelefono . "', '" . $idCorreo . "', '" . $idEstado . "', '" . $idCP . "', '" . $idMunicipio . "', '" . $idLocalidad . "', " .
                "'" . $idCalle . "'," . " '" . $idNumExt . "', '" . $idNumInt . "', '" . $idMensajeInterno . "', '" . $idPromocion . "', " .
                "'" . $fechaCreacion . "', '" . $fechaModificacion . "', '" . $usuario . "', '" . $sucursal . "')";
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

    public function autocompleteCliente($idCliente)
    {
        try {
            $html = '';
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT id_Cliente,
                       CONCAT(apellido_Pat,'/',  apellido_Mat, '/', nombre) AS NombreCompleto, celular,
                       CONCAT(calle, ', ',num_interior,', ', num_exterior, ', ',localidad, ', ', municipio, 
                       ', ', cat_estado.descripcion ) AS direccionCompleta
                       FROM cliente_tbl
                       INNER JOIN cat_estado ON cliente_tbl.estado = cat_estado.id_Estado
                       WHERE sucursal = $sucursal AND CONCAT(apellido_Pat, ' ', apellido_Mat, ' ',nombre) LIKE '%" . strip_tags($idCliente) . "%' LIMIT 5 ";
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
        $sucursal = $_SESSION["sucursal"];

        try {
            $buscar = "SELECT
    nombre,apellido_Pat, apellido_Mat, sexo,fecha_Nacimiento,curp,ocupacion,
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
    id_Cliente = '$idClienteEditar' and sucursal=" . $sucursal;

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

            $sucursal = $_SESSION["sucursal"];


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
WHERE id_Cliente = '$idClienteEditar' AND sucursal=".$sucursal;

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
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT id_Cliente, CONCAT (apellido_Pat,'/',  apellido_Mat, '/', nombre) as NombreCompleto, celular , CONCAT (calle, ', ',num_interior, ', ',num_exterior, ', ',  localidad, ', ',municipio,', ',cat_estado.descripcion ) as direccionCompleta FROM cliente_tbl " .
                " INNER JOIN cat_estado on cliente_tbl.estado = cat_estado.id_Estado " .
                " WHERE  id_Cliente = (SELECT MAX(id_Cliente) FROM cliente_tbl) AND sucursal =$sucursal";
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
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT id_Cliente, CONCAT (apellido_Pat,'/',  apellido_Mat, '/', nombre) as NombreCompleto, celular , CONCAT (calle, ', ',num_interior, ', ',num_exterior, ', ',  localidad, ', ',municipio,', ',cat_estado.descripcion ) as direccionCompleta FROM cliente_tbl " .
                " INNER JOIN cat_estado on cliente_tbl.estado = cat_estado.id_Estado " .
                " WHERE  id_Cliente = '$idClienteEditado' AND sucursal =$sucursal ";
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
        $sucursal = $_SESSION["sucursal"];

        try {
            $buscar = "SELECT id_Cliente, CONCAT (apellido_Pat  , ' ',apellido_Mat,' ',nombre ) as NombreCompleto, 
                        celular , CONCAT (calle, ', ',num_interior, ', ',num_exterior, ', ',  localidad, ', ',
                        municipio,', ',cat_estado.descripcion ) as direccionCompleta FROM cliente_tbl 
                        INNER JOIN cat_estado on cliente_tbl.estado = cat_estado.id_Estado 
                        WHERE sucursal=". $sucursal . " AND 
                        CONCAT(apellido_Pat, ' ', apellido_Mat, ' ',nombre) LIKE 
                        '%" . strip_tags($idNombres) . "%')";
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

    public function traerTodos()
    {
        $datos = array();
        $sucursal = $_SESSION["sucursal"];

        try {
            $buscar = "SELECT id_Cliente, CONCAT (apellido_Pat  , ' ',apellido_Mat,' ',nombre ) as NombreCompleto, 
                        celular , CONCAT (calle, ', ',num_interior, ', ',num_exterior, ', ',  localidad, ', ',
                        municipio,', ',cat_estado.descripcion ) as direccionCompleta FROM cliente_tbl 
                        INNER JOIN cat_estado on cliente_tbl.estado = cat_estado.id_Estado 
                        where sucursal=". $sucursal;
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
                        CONCAT(Cont.plazo, ' ', Cont.periodo, ' ',Cont.tipoInteres) as Interes, 
                        Con.fechaVencimiento as FechaVenc, Con.fecha_Movimiento as FechaCreac, 
                        Art.descripcionCorta AS DescripcionCorta,  Art.observaciones AS Obs,
                        Aut.observaciones as ObserAuto,
                        CONCAT(Aut.marca, ' ', Aut.modelo) as DetalleAuto, 
                        Art.tipoArticulo, Cont.id_Formulario as Form,
                        Mov.descripcion as EstDesc
                        FROM contrato_mov_tbl as Con 
                        INNER JOIN contratos_tbl as Cont on Con.id_contrato = Cont.id_Contrato 
                        INNER JOIN cliente_tbl as Cli on Cont.id_Cliente = Cli.id_Cliente 
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato 
                        LEFT JOIN cat_movimientos as Mov on Con.tipo_movimiento = Mov.id_Movimiento 
                        WHERE Cont.id_Cliente=$clienteEmpeno";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "ContratoHistorial" => $row["Contrato"],
                        "Cliente" => $row["Cliente"],
                        "NombreCompleto" => $row["NombreCompleto"],
                        "Interes" => $row["Interes"],
                        "FechaVenc" => $row["FechaVenc"],
                        "FechaCreac" => $row["FechaCreac"],
                        "EstDesc" => $row["EstDesc"],
                        "Form" => $row["Form"],
                        "DescripcionCorta" => $row["DescripcionCorta"],
                        "Obs" => $row["Obs"],
                        "ObserAuto" => $row["ObserAuto"],
                        "DetalleAuto" => $row["DetalleAuto"],
                        "tipoArticulo" => $row["tipoArticulo"],

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

            $buscarEmpe = "SELECT COUNT(ConMov.id_contrato) AS TotalEmpenos 
                 FROM contrato_mov_tbl ConMov
                 INNER JOIN contratos_tbl AS Con ON ConMov.id_contrato = Con.id_Contrato
                 WHERE Con.id_Cliente = $clienteEmpeno AND ConMov.tipo_Contrato=1 
                 AND ConMov.id_contrato 
                 NOT IN (SELECT id_contrato FROM contrato_mov_tbl 
                        WHERE tipo_movimiento = 4 || tipo_movimiento = 5 || tipo_movimiento = 6 
                        || tipo_movimiento = 20 || tipo_movimiento = 21 ||tipo_movimiento = 22 ||tipo_movimiento = 23 || tipo_movimiento = 24)";
            $statement = $this->conexion->query($buscarEmpe);
            $fila = $statement->fetch_object();
            $TotalEmpenos = $fila->TotalEmpenos;

            $buscarEmpeAuto = "SELECT COUNT(ConMov.id_contrato) AS TotalEmpenos 
                 FROM contrato_mov_tbl ConMov
                 INNER JOIN contratos_tbl AS Con ON ConMov.id_contrato = Con.id_Contrato
                 WHERE Con.id_Cliente = $clienteEmpeno AND ConMov.tipo_Contrato=2 
                 AND ConMov.id_contrato 
                 NOT IN (SELECT id_contrato FROM contrato_mov_tbl 
                        WHERE tipo_movimiento = 8 || tipo_movimiento = 9 || tipo_movimiento = 10 
                        || tipo_movimiento = 20 || tipo_movimiento = 21 || tipo_movimiento = 24)";
            $statement = $this->conexion->query($buscarEmpeAuto);
            $fila = $statement->fetch_object();
            $TotalEmpenosAuto = $fila->TotalEmpenos;

            $buscarRefrendo = "SELECT COUNT(ConMov.id_contrato) AS TotalRefrendo
                 FROM contrato_mov_tbl ConMov
                 INNER JOIN contratos_tbl AS Con ON ConMov.id_contrato = Con.id_Contrato
                 WHERE Con.id_Cliente = $clienteEmpeno AND ConMov.tipo_Contrato=2  
                 AND tipo_movimiento = 8
                 AND ConMov.id_contrato 
                 NOT IN (SELECT id_contrato FROM contrato_mov_tbl 
                        WHERE tipo_movimiento = 9 || tipo_movimiento = 10 
                        || tipo_movimiento = 20 || tipo_movimiento = 21 || tipo_movimiento = 24)";
            $statement = $this->conexion->query($buscarRefrendo);
            $fila = $statement->fetch_object();
            $TotalRefrendo = $fila->TotalRefrendo;

            $buscarRefrendoAuto = "SELECT COUNT(ConMov.id_contrato) AS TotalRefrendo
                 FROM contrato_mov_tbl ConMov
                 INNER JOIN contratos_tbl AS Con ON ConMov.id_contrato = Con.id_Contrato
                 WHERE Con.id_Cliente = $clienteEmpeno AND ConMov.tipo_Contrato=2  
                 AND tipo_movimiento = 8
                 AND ConMov.id_contrato 
                 NOT IN (SELECT id_contrato FROM contrato_mov_tbl 
                        WHERE tipo_movimiento = 9 || tipo_movimiento = 10 
                        || tipo_movimiento = 20 || tipo_movimiento = 21 || tipo_movimiento = 24)";
            $statement = $this->conexion->query($buscarRefrendoAuto);
            $fila = $statement->fetch_object();
            $TotalRefrendoAuto = $fila->TotalRefrendo;

            $buscarDesemp = "SELECT COUNT(ConMov.id_contrato) AS TotalDesemp 
                 FROM contrato_mov_tbl ConMov
                 INNER JOIN contratos_tbl AS Con ON ConMov.id_contrato = Con.id_Contrato
                 WHERE Con.id_Cliente = $clienteEmpeno AND ConMov.tipo_Contrato=2 
                 AND tipo_movimiento = 9 || tipo_movimiento = 21
                 AND ConMov.id_contrato 
                 NOT IN (SELECT id_contrato FROM contrato_mov_tbl 
                        WHERE tipo_movimiento = 20 )";
            $statement = $this->conexion->query($buscarDesemp);
            $fila = $statement->fetch_object();
            $TotalDesemp = $fila->TotalDesemp;

            $buscarDesempAuto = "SELECT COUNT(ConMov.id_contrato) AS TotalDesemp 
                 FROM contrato_mov_tbl ConMov
                 INNER JOIN contratos_tbl AS Con ON ConMov.id_contrato = Con.id_Contrato
                 WHERE Con.id_Cliente = $clienteEmpeno AND ConMov.tipo_Contrato=2 
                 AND tipo_movimiento = 9 || tipo_movimiento = 21
                 AND ConMov.id_contrato 
                 NOT IN (SELECT id_contrato FROM contrato_mov_tbl 
                        WHERE tipo_movimiento = 20 )";
            $statement = $this->conexion->query($buscarDesempAuto);
            $fila = $statement->fetch_object();
            $TotalDesempAuto = $fila->TotalDesemp;

            $buscarBazar = "SELECT COUNT(ConMov.id_contrato) AS TotalBazar
                 FROM contrato_mov_tbl ConMov
                 INNER JOIN contratos_tbl AS Con ON ConMov.id_contrato = Con.id_Contrato
                 WHERE Con.id_Cliente = $clienteEmpeno AND ConMov.tipo_Contrato=2 
                 AND tipo_movimiento = 24
                 AND ConMov.id_contrato 
                 NOT IN (SELECT ConMov.id_contrato FROM contrato_mov_tbl 
                        WHERE tipo_movimiento = 10 || tipo_movimiento = 20)";
            $statement = $this->conexion->query($buscarBazar);
            $fila = $statement->fetch_object();
            $TotalBazar = $fila->TotalBazar;

            $buscarBazarAuto = "SELECT COUNT(ConMov.id_contrato) AS TotalBazar
                 FROM contrato_mov_tbl ConMov
                 INNER JOIN contratos_tbl AS Con ON ConMov.id_contrato = Con.id_Contrato
                 WHERE Con.id_Cliente = $clienteEmpeno AND ConMov.tipo_Contrato=2 
                 AND tipo_movimiento = 24
                 AND ConMov.id_contrato 
                 NOT IN (SELECT ConMov.id_contrato FROM contrato_mov_tbl 
                        WHERE tipo_movimiento = 10 || tipo_movimiento = 20)";
            $statement = $this->conexion->query($buscarBazarAuto);
            $fila = $statement->fetch_object();
            $TotalBazarAuto = $fila->TotalBazar;

            $buscarVenta = "SELECT COUNT(ConMov.id_contrato) AS TotalVenta
                 FROM contrato_mov_tbl ConMov
                 INNER JOIN contratos_tbl AS Con ON ConMov.id_contrato = Con.id_Contrato
                 WHERE Con.id_Cliente = $clienteEmpeno AND ConMov.tipo_Contrato=1 
                 AND tipo_movimiento = 6
                 AND ConMov.id_contrato 
                 NOT IN (SELECT id_contrato FROM contrato_mov_tbl 
                        WHERE tipo_movimiento = 20 )";
            $statement = $this->conexion->query($buscarVenta);
            $fila = $statement->fetch_object();
            $TotalVenta = $fila->TotalVenta;

            $buscarVentaAuto = "SELECT COUNT(ConMov.id_contrato) AS TotalVenta
                 FROM contrato_mov_tbl ConMov
                 INNER JOIN contratos_tbl AS Con ON ConMov.id_contrato = Con.id_Contrato
                 WHERE Con.id_Cliente = $clienteEmpeno AND ConMov.tipo_Contrato=2 
                 AND tipo_movimiento = 10
                 AND ConMov.id_contrato 
                 NOT IN (SELECT id_contrato FROM contrato_mov_tbl 
                        WHERE tipo_movimiento = 20 )";
            $statement = $this->conexion->query($buscarVentaAuto);
            $fila = $statement->fetch_object();
            $TotalVentaAuto = $fila->TotalVenta;


            $totalFinalEmpe = $TotalEmpenos + $TotalEmpenosAuto;
            $totalFinalRefre = $TotalRefrendo + $TotalRefrendoAuto;
            $totalFinalDesem = $TotalDesemp + $TotalDesempAuto;
            $totalFinalBaz = $TotalBazar + $TotalBazarAuto;
            $totalFinalVen = $TotalVenta + $TotalVentaAuto;


            $data = [
                "TotalEmpeno" => $totalFinalEmpe,
                "TotalRefrendo" => $totalFinalRefre,
                "TotalDesem" => $totalFinalDesem,
                "TotalAlmoneda" => $totalFinalBaz,
                "TotalVenta" => $totalFinalVen
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