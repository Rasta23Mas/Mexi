<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Vendedor.php");
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlVendedorDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    public function guardaVendedor($vendedorData)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $idNombre = $vendedorData->getNombre();
            $idApPat = $vendedorData->getApellidoPat();
            $idApMat = $vendedorData->getApellidoMat();
            $idSexo = $vendedorData->getSexo();
            $idFechaNac = $vendedorData->getFechaNacimiento();
            $idRfc = $vendedorData->getRfc();
            $idCurp = $vendedorData->getCurp();
            $idCelular = $vendedorData->getCelular();
            $idTelefono = $vendedorData->getTelefono();
            $idCorreo = $vendedorData->getCorreo();
            $idOcupacion = $vendedorData->getOcupacion();
            $idIdentificacion = $vendedorData->getIdentificacion();
            $idNumIdentificacion = $vendedorData->getNumIdentificacion();
            $idEstado = $vendedorData->getEstado();
            $idMunicipio = $vendedorData->getMunicipio();
            $idLocalidad = $vendedorData->getLocalidad();
            $idCalle = $vendedorData->getCalle();
            $idCP = $vendedorData->getCodigoPostal();
            $idNumExt = $vendedorData->getNumExterior();
            $idNumInt = $vendedorData->getNumInterior();
            $idPromocion = $vendedorData->getPromocion();
            $idMensajeInterno = $vendedorData->getMensajeInterno();
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


            $insertVendedor = "INSERT INTO cat_vendedores (nombre, apellido_Pat, apellido_Mat, sexo, fecha_Nacimiento, curp," .
                " ocupacion, tipo_Identificacion, num_Identificacion, celular, rfc, telefono, correo, estado, codigo_Postal," .
                " municipio, localidad, calle, num_exterior, num_interior, mensaje,promocion, fecha_creacion, fecha_modificacion,usuario,sucursal)" .
                " VALUES ('" . $idNombre . "', '" . $idApPat . "', '" . $idApMat . "', '" . $idSexo . "', '" . $idFechaNac . "','" . $idCurp . "', " .
                " '" . $idOcupacion . "', '" . $idIdentificacion . "', '" . $idNumIdentificacion . "', '" . $idCelular . "', '" . $idRfc . "', " .
                "'" . $idTelefono . "', '" . $idCorreo . "', '" . $idEstado . "', '" . $idCP . "', '" . $idMunicipio . "', '" . $idLocalidad . "', " .
                "'" . $idCalle . "'," . " '" . $idNumExt . "', '" . $idNumInt . "', '" . $idMensajeInterno . "', '" . $idPromocion . "', " .
                "'" . $fechaCreacion . "', '" . $fechaModificacion . "', '" . $usuario . "', '" . $sucursal . "')";
            if ($ps = $this->conexion->prepare($insertVendedor)) {
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

    public function autocompleteVendedor($idVendedor)
    {
        try {
            $html = '';
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT id_Vendedor,
                       CONCAT(apellido_Pat,'/',  apellido_Mat, '/', nombre) AS NombreCompleto, celular,
                       CONCAT(calle, ', ',num_interior,', ', num_exterior, ', ',localidad, ', ', municipio, 
                       ', ', cat_estado.descripcion ) AS direccionCompleta
                       FROM cat_vendedores
                       INNER JOIN cat_estado ON cat_vendedores.estado = cat_estado.id_Estado
                       WHERE sucursal = $sucursal AND CONCAT(apellido_Pat, ' ', apellido_Mat, ' ',nombre) LIKE '%" . strip_tags($idVendedor) . "%' LIMIT 5 ";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                while ($row = $statement->fetch_assoc()) {
                    $html .= '<div><a class="suggest-element" data="' . $row['NombreCompleto'] . '" celular="' . $row['celular']
                        . '" direccionCompleta="' . $row['direccionCompleta'] . '" id="' . $row['id_Vendedor'] . '">' . $row['NombreCompleto'] . '</a></div>';
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

    public function buscarVendedorDatos($idVendedorEditar)
    {
        $datos = array();
        $sucursal = $_SESSION["sucursal"];

        try {
            $buscar = "SELECT nombre, apellido_Pat, apellido_Mat, sexo, fecha_Nacimiento, curp, ocupacion,
                        tipo_Identificacion, num_Identificacion, celular, rfc, telefono, correo, estado,
                        municipio, localidad, codigo_Postal, calle, num_exterior, num_interior,
                        mensaje, promocion
                        FROM cat_vendedores
                        WHERE id_Vendedor = $idVendedorEditar and sucursal= $sucursal";

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

    public function actualizaVendedor($idVendedorEditar, $vendedorData)
    {

        try {

            $idNombre = $vendedorData->getNombre();
            $idApPat = $vendedorData->getApellidoMat();
            $idApMat = $vendedorData->getApellidoPat();
            $idSexo = $vendedorData->getSexo();
            $idFechaNac = $vendedorData->getFechaNacimiento();
            $idRfc = $vendedorData->getRfc();
            $idCurp = $vendedorData->getCurp();
            $idCelular = $vendedorData->getCelular();
            $idTelefono = $vendedorData->getTelefono();
            $idCorreo = $vendedorData->getCorreo();
            $idOcupacion = $vendedorData->getOcupacion();
            $idIdentificacion = $vendedorData->getIdentificacion();
            $idNumIdentificacion = $vendedorData->getNumIdentificacion();
            $idEstado = $vendedorData->getEstado();
            $idMunicipio = $vendedorData->getMunicipio();
            $idLocalidad = $vendedorData->getLocalidad();
            $idCalle = $vendedorData->getCalle();
            $idCP = $vendedorData->getCodigoPostal();
            $idNumExt = $vendedorData->getNumExterior();
            $idNumInt = $vendedorData->getNumInterior();
            $idPromocion = $vendedorData->getPromocion();
            $idMensajeInterno = $vendedorData->getMensajeInterno();
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


            $updateCliente = "UPDATE cat_vendedores
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
                                WHERE id_Vendedor = '$idVendedorEditar' AND sucursal=$sucursal";

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

    public function buscarVendedorAgregado()
    {
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT id_Vendedor, CONCAT (apellido_Pat,'/',  apellido_Mat, '/', nombre) as NombreCompleto, 
                        celular , CONCAT (calle, ', ',num_interior, ', ',num_exterior, ', ',  localidad, ', ',municipio,', ',cat_estado.descripcion ) as direccionCompleta
                        FROM cat_vendedores
                        INNER JOIN cat_estado on cat_vendedores.estado = cat_estado.id_Estado 
                        WHERE  id_Vendedor = (SELECT MAX(id_Vendedor) FROM cat_vendedores) AND sucursal =$sucursal";
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

    public function buscarVendedorEditado($vendedorEditado)
    {
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT id_Vendedor, CONCAT (apellido_Pat,'/',  apellido_Mat, '/', nombre) as NombreCompleto, celular , CONCAT (calle, ', ',num_interior, ', ',num_exterior, ', ',  localidad, ', ',municipio,', ',cat_estado.descripcion ) as direccionCompleta 
                        FROM cat_vendedores 
                        INNER JOIN cat_estado on cat_vendedores.estado = cat_estado.id_Estado 
                        WHERE  id_Vendedor =$vendedorEditado AND sucursal =$sucursal ";
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

    public function verTodos($idNombresVendedor)
    {
        $datos = array();
        $sucursal = $_SESSION["sucursal"];

        try {
            $buscar = "SELECT id_Vendedor, CONCAT (apellido_Pat  , ' ',apellido_Mat,' ',nombre ) as NombreCompleto, 
                        celular , CONCAT (calle, ', ',num_interior, ', ',num_exterior, ', ',  localidad, ', ',
                        municipio,', ',cat_estado.descripcion ) as direccionCompleta FROM cat_vendedores 
                        INNER JOIN cat_estado on cat_vendedores.estado = cat_estado.id_Estado 
                        WHERE sucursal=" . $sucursal . " AND 
                        CONCAT(apellido_Pat, ' ', apellido_Mat, ' ',nombre) LIKE 
                        '%" . strip_tags($idNombresVendedor) . "%'";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Vendedor" => $row["id_Vendedor"],
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
            $buscar = "SELECT id_Vendedor, CONCAT (apellido_Pat  , ' ',apellido_Mat,' ',nombre ) as NombreCompleto, 
                        celular , CONCAT (calle, ', ',num_interior, ', ',num_exterior, ', ',  localidad, ', ',
                        municipio,', ',cat_estado.descripcion ) as direccionCompleta FROM cat_vendedores 
                        INNER JOIN cat_estado on cat_vendedores.estado = cat_estado.id_Estado 
                        where sucursal=" . $sucursal;
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Vendedor" => $row["id_Vendedor"],
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
                        CONCAT(EM.descripcion,' ', ET.descripcion, ' ',EMOD.descripcion) as ObserElec, 
                        CONCAT(Tipo.descripcion, ' ',Kil.descripcion,' ', Cal.descripcion) as ObserMetal,
                        Aut.observaciones as ObserAuto,
                        CONCAT(Art.detalle) as Detalle,
                        CONCAT(Aut.marca, ' ', Aut.modelo) as DetalleAuto, 
                        Art.tipoArticulo, Cont.id_Formulario as Form,
                        Mov.descripcion as EstDesc
                        FROM contrato_mov_tbl as Con 
                        INNER JOIN contratos_tbl as Cont on Con.id_contrato = Cont.id_Contrato 
                        INNER JOIN cliente_tbl as Cli on Cont.id_Cliente = Cli.id_Cliente 
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato 
                        LEFT JOIN cat_movimientos as Mov on Con.tipo_movimiento = Mov.id_Movimiento 
                        LEFT JOIN cat_electronico_marca as EM on Art.marca = EM.id_marca
                        LEFT JOIN cat_electronico_modelo as EMOD on Art.modelo = EMOD.id_modelo
                        LEFT JOIN cat_electronico_tipo as ET on Art.tipo = ET.id_tipo
                        LEFT JOIN cat_kilataje as Kil on Art.kilataje = Kil.id_Kilataje
                        LEFT JOIN cat_tipoarticulo as Tipo on Art.tipo = Tipo.id_tipo
                        LEFT JOIN cat_calidad as Cal on Art.calidad = Cal.id_calidad
                        WHERE Cont.id_Cliente=$clienteEmpeno";
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
                        "ObserAuto" => $row["ObserAuto"],
                        "Detalle" => $row["Detalle"],
                        "DetalleAuto" => $row["DetalleAuto"],
                        "tipoArticulo" => $row["tipoArticulo"],
                        "tipoArticulo" => $row["tipoArticulo"],
                        "Form" => $row["Form"],
                        "EstDesc" => $row["EstDesc"],
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