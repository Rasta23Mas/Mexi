<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Contratos.php");
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlDesempenoDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    //Busqueda de Contrato
    public function busquedaMovimiento($idContratoDes, $tipoContrato)
    {
        //Modifique los estatus de usuario
        //$datos = array();
        $id="";
        $sucursal = $_SESSION["sucursal"];
        try {
            $buscar = "SELECT max(id_movimiento) as IdMovimiento FROM contrato_mov_tbl 
                        WHERE id_contrato = '$idContratoDes' and tipo_Contrato= $tipoContrato 
                        and sucursal= $sucursal and tipo_movimiento!=20";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                $fila = $rs->fetch_object();
                $id = $fila->IdMovimiento;
            } else {
                $id = -1;
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $id;
    }

    //Busqueda de Contrato
    public function estatusContrato($IdMovimiento)
    {
        //Modifique los estatus de usuario
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT Mov.id_contrato as Contrato, Mov.fecha_Movimiento  as Fecha,
                        CONCAT (Cli.nombre, ' ',Cli.apellido_Pat,' ', Cli.apellido_Mat) as NombreCompleto,
                        CatM.descripcion as Movimiento, Mov.tipo_movimiento as tipoMovimiento
                        FROM contrato_mov_tbl as Mov
                        INNER JOIN contratos_tbl as Con on Mov.id_contrato = Con.id_Contrato  
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        INNER JOIN cat_movimientos as CatM on Mov.tipo_movimiento = CatM.id_Movimiento  
                        WHERE Mov.id_movimiento = $IdMovimiento  and Con.sucursal=$sucursal 
                        and Mov.sucursal=$sucursal ";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Contrato" => $row["Contrato"],
                        "Fecha" => $row["Fecha"],
                        "NombreCompleto" => $row["NombreCompleto"],
                        "Movimiento" => $row["Movimiento"],
                        "tipoMovimiento" => $row["tipoMovimiento"]
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

    //Busqueda de Cliente
    public function buscarCliente($IdMovimiento)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT 	Con.id_Cliente AS Cliente,CONCAT (Cli.apellido_Pat,'/', Cli.apellido_Mat,'/',Cli.nombre) as NombreCompleto,
                        CONCAT (calle, ', ',num_interior, ', ',num_exterior, ', ',  localidad, ', ') as DireccionCompleta,
                        CONCAT (municipio,', ',Est.descripcion ) as DireccionCompletaEst,
                        Con.cotitular as Cotitular, Usu.usuario as UsuarioName
                        FROM contrato_mov_tbl as Mov
                        INNER JOIN contratos_tbl as Con on Mov.id_contrato = Con.id_Contrato  
                        LEFT JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN cat_estado as Est on Cli.estado = Est.id_Estado  
                        LEFT JOIN bit_cierrecaja as Caj on Mov.id_CierreCaja = Caj.id_cierreCaja
                        LEFT JOIN usuarios_tbl as Usu on Caj.usuario = Usu.id_User
                       	WHERE Mov.id_movimiento = $IdMovimiento  and Con.sucursal=$sucursal 
                        and Mov.sucursal=$sucursal";

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Cliente" => $row["Cliente"],
                        "NombreCompleto" => $row["NombreCompleto"],
                        "DireccionCompleta" => $row["DireccionCompleta"],
                        "DireccionCompletaEst" => $row["DireccionCompletaEst"],
                        "Cotitular" => $row["Cotitular"],
                        "UsuarioName" => $row["UsuarioName"]
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

    //Busqueda de Contrato
    public function buscarContrato($IdMovimiento)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT
                        ConMov.fecha_Movimiento AS FechaEmpMovimiento,
                        DATE(ConMov.fecha_Movimiento) AS FechaEmpConvertMovimiento,
                        DATE(ConMov.fechaVencimiento) AS FechaVenConvertMovimiento,
                        ConMov.fechaAlmoneda AS FechaAlmMovimiento,
                        Con.plazo AS PlazoDesc,
                        Con.tasa AS TasaDesc,
                        Con.alm AS AlmacDesc,
                        Con.seguro AS SeguDesc,
                        Con.iva AS IvaDesc,
                        Con.dias AS Dias,
                        Con.suma_InteresPrestamo AS TotalInteresPrestamo,
                        ConMov.prestamo_actual AS TotalPrestamoMovimiento,
                        ConMov.abonoTotal AS AbonoMovimiento,
                        ConMov.descuentoTotal AS DescuentoMovimiento,
                        Con.diasAlm AS DiasAlmoneda,
                        Con.polizaSeguro AS PolizaSeguro,
                        Con.gps AS GPS,
                        Con.pension AS Pension,
                        Con.total_Avaluo as TotalAvaluo,                        
                        ConMov.prestamo_Informativo as PrestamoInfo,
                        CCC.costo as CostoContrato
                        From contrato_mov_tbl AS ConMov
                        INNER JOIN contratos_tbl AS Con ON ConMov.id_contrato =  Con.id_Contrato
                        INNER JOIN cat_costo_contrato AS CCC ON Con.id_Formulario =  CCC.id_formulario
                        AND Con.sucursal = CCC.sucursal
						WHERE ConMov.id_movimiento = $IdMovimiento  and Con.sucursal=$sucursal ";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "FechaEmpMovimiento" => $row["FechaEmpMovimiento"],
                        "FechaEmpConvertMovimiento" => $row["FechaEmpConvertMovimiento"],
                        "FechaVenConvertMovimiento" => $row["FechaVenConvertMovimiento"],
                        "FechaAlmMovimiento" => $row["FechaAlmMovimiento"],
                        "PlazoDesc" => $row["PlazoDesc"],
                        "TasaDesc" => $row["TasaDesc"],
                        "AlmacDesc" => $row["AlmacDesc"],
                        "SeguDesc" => $row["SeguDesc"],
                        "IvaDesc" => $row["IvaDesc"],
                        "Dias" => $row["Dias"],
                        "TotalInteresPrestamo" => $row["TotalInteresPrestamo"],
                        "TotalPrestamoMovimiento" => $row["TotalPrestamoMovimiento"],
                        "AbonoMovimiento" => $row["AbonoMovimiento"],
                        "DescuentoMovimiento" => $row["DescuentoMovimiento"],
                        "DiasAlmoneda" => $row["DiasAlmoneda"],
                        "PolizaSeguro" => $row["PolizaSeguro"],
                        "GPS" => $row["GPS"],
                        "Pension" => $row["Pension"],
                        "TotalAvaluo" => $row["TotalAvaluo"],
                        "PrestamoInfo" => $row["PrestamoInfo"],
                        "CostoContrato" => $row["CostoContrato"],

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

    //Busqueda de detalle del contrato
    public function buscarDetalle($IdMovimiento)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT Art.detalle as Detalle,Art.observaciones as Obseracion 
                        FROM articulo_tbl as Art
                        INNER JOIN contrato_mov_tbl  as Mov ON Art.id_Contrato = Mov.id_contrato
                        WHERE Mov.id_movimiento = $IdMovimiento and Mov.sucursal=$sucursal ";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Detalle" => $row["Detalle"],
                        "Obseracion" => $row["Obseracion"]
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

    //Busqueda de detalle del auto
    public function buscarDetalleAuto($IdMovimiento)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT Auto.marca as Marca,Auto.modelo as Modelo,Auto.anio as Anio,
                        Auto.observaciones as Obs, Auto.color as ColorAuto 
                        FROM auto_tbl as Auto 
                        INNER JOIN contrato_mov_tbl  as Mov ON Auto.id_Contrato = Mov.id_contrato
                        WHERE Mov.id_movimiento = $IdMovimiento  and Mov.sucursal=$sucursal";

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Marca" => $row["Marca"],
                        "Modelo" => $row["Modelo"],
                        "Anio" => $row["Anio"],
                        "ColorAuto" => $row["ColorAuto"],
                        "Obs" => $row["Obs"]
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

    //Validacion de token
    public function validarToken($token)
    {
        $token = mb_strtoupper($token, 'UTF-8');

        try {
            $id = -1;
            $buscar = "SELECT id_token,descripcion FROM cat_token 
                        WHERE descripcion = '$token' and estatus= 1";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $id = $fila->id_token;
            } else {
                $id = -1;
            }

        } catch (Exception $exc) {
            $id = -1;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $id;
        //return $id;
    }

    //Generar Refrendo
    public function generar($tipeFormulario, $descuento, $contrato, $token,
                            $tipoContrato, $token_interes, $token_moratorio, $token_gps, $token_pension, $token_poliza, $token_movimiento, $token_decripcion)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $usuario = $_SESSION["idUsuario"];
            $sucursal = $_SESSION["sucursal"];

            $token_decripcion = mb_strtoupper($token_decripcion, 'UTF-8');
            $insertaBitacora = "INSERT INTO bit_token ( id_Contrato, tipo_Contrato, tipo_formulario,
                                                token, descripcion, descuento, interes, moratorio,gps,
                                                pension,poliza,id_tokenMovimiento, estatus, usuario, sucursal, fecha_Creacion)
                                        VALUES ($contrato, $tipoContrato,$tipeFormulario,
                                                '$token','$token_decripcion', $descuento, $token_interes,$token_moratorio,$token_gps,
                                                $token_pension,$token_poliza,$token_movimiento,1, $usuario, $sucursal,'$fechaModificacion')";
            if ($ps = $this->conexion->prepare($insertaBitacora)) {
                if ($ps->execute()) {
                    if (empty($token)) {
                        $verdad = 1;
                    } else {
                        $updateToken = "UPDATE cat_token SET
                                         estatus = 2
                                        WHERE id_token =$token";
                        if ($ps = $this->conexion->prepare($updateToken)) {
                            if ($ps->execute()) {
                                $verdad = mysqli_stmt_affected_rows($ps);
                            } else {
                                $verdad = -11;
                            }
                        } else {
                            $verdad = -12;
                        }
                    }
                } else {
                    $verdad = -13;
                }
            } else {
                $verdad = -14;
            }


        } catch
        (Exception $exc) {
            $verdad = -20;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        //return $verdad;
        echo $verdad;
    }


    public function generarDesempenoAuto($pago, $idImporte, $idContrato)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $fechaModificacion = date('Y-m-d H:i:s');
            $usuario = $_SESSION["idUsuario"];
            $updateDesempeno = "UPDATE contratos_tbl SET pago=$pago,fecha_Pago='$fechaModificacion' ,
                                descuento=$idImporte, usuario= $usuario ,
                                fecha_modificacion = '$fechaModificacion',	id_Estatus=2
                                WHERE id_Contrato=$idContrato";
            if ($ps = $this->conexion->prepare($updateDesempeno)) {
                if ($ps->execute()) {
                    $updateArticulos = "UPDATE auto_tbl SET id_Estatus=2, fecha_modificacion = '$fechaModificacion',usuario= $usuario 
                                WHERE id_Contrato=$idContrato";
                    if ($ps = $this->conexion->prepare($updateArticulos)) {
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
        //return $verdad;
        echo $verdad;
    }




//Auto
    public function buscarClienteDesAuto($idContratoDes)
    {
        $datos = array();
        try {
            $buscar = "SELECT CONCAT (Cli.nombre, ' ', Cli.apellido_Pat,' ', Cli.apellido_Mat) as NombreCompleto,
                        CONCAT (calle, ', ',num_interior, ', ',num_exterior, ', ',  localidad, ', ') as DireccionCompleta,
                        CONCAT (municipio,', ',Est.descripcion ) as DireccionCompletaEst,
                        Con.cotitular as Cotitular, Usu.usuario as UsuarioName
                        FROM contratos_tbl as Con
                        LEFT JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN cat_estado as Est on Cli.estado = Est.id_Estado
                        LEFT JOIN usuarios_tbl as Usu on Con.usuario = Usu.id_User
                        WHERE Con.id_Contrato = '$idContratoDes' and Con.tipoContrato=2  and Con.id_Estatus= 1";

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "NombreCompleto" => $row["NombreCompleto"],
                        "DireccionCompleta" => $row["DireccionCompleta"],
                        "DireccionCompletaEst" => $row["DireccionCompletaEst"],
                        "Cotitular" => $row["Cotitular"],
                        "UsuarioName" => $row["UsuarioName"]
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

    public function buscarContratoDesAuto($idContratoDes)
    {
        $datos = array();
        try {
            $buscar = "SELECT
                        Con.fecha_creacion AS FechaEmp,
                        DATE(Con.fecha_creacion) AS FechaEmpConvert,
                        Con.fecha_Vencimiento AS FechaVenc,
                        DATE(Con.fecha_Vencimiento) AS FechaVenConvert,
                        Con.fecha_Alm AS FechaAlm,
                        Con.plazo AS PlazoDesc,
                        Con.tasa AS TasaDesc,
                        Con.alm AS AlmacDesc,
                        Con.seguro AS SeguDesc,
                        Con.iva AS IvaDesc,
                        Con.dias AS Dias,
                        Con.total_Prestamo AS TotalPrestamo,
                        Con.total_Interes AS TotalInteres,
                        Con.suma_InteresPrestamo AS TotalInteresPrestamo,
                        Con.polizaSeguro AS PolizaSeguro,
                        Con.gps AS GPS,
                        Con.abono AS Abono,
                        Con.fecha_Abono AS FechaAbono
                        FROM contratos_tbl as Con
                        WHERE Con.id_Contrato = '$idContratoDes' and Con.tipoContrato= 2  and Con.id_Estatus= 1";

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "FechaEmp" => $row["FechaEmp"],
                        "FechaEmpConvert" => $row["FechaEmpConvert"],
                        "FechaVenc" => $row["FechaVenc"],
                        "FechaVenConvert" => $row["FechaVenConvert"],
                        "FechaAlm" => $row["FechaAlm"],
                        "PlazoDesc" => $row["PlazoDesc"],
                        "TasaDesc" => $row["TasaDesc"],
                        "AlmacDesc" => $row["AlmacDesc"],
                        "SeguDesc" => $row["SeguDesc"],
                        "IvaDesc" => $row["IvaDesc"],
                        "Dias" => $row["Dias"],
                        "TotalPrestamo" => $row["TotalPrestamo"],
                        "TotalInteres" => $row["TotalInteres"],
                        "TotalInteresPrestamo" => $row["TotalInteresPrestamo"],
                        "PolizaSeguro" => $row["PolizaSeguro"],
                        "GPS" => $row["GPS"],
                        "Abono" => $row["Abono"],
                        "FechaAbono" => $row["FechaAbono"]
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


    public function buscarContratoRefAuto($idContratoDes)
    {
        $datos = array();
        try {
            $buscar = "SELECT
                        Con.fecha_creacion AS FechaEmp,
                        DATE(Con.fecha_creacion) AS FechaEmpConvert,
                        Con.fecha_Vencimiento AS FechaVenc,
                        DATE(Con.fecha_Vencimiento) AS FechaVenConvert,
                        Con.fecha_Alm AS FechaAlm,
                        Con.plazo AS PlazoDesc,
                        Con.tasa AS TasaDesc,
                        Con.alm AS AlmacDesc,
                        Con.seguro AS SeguDesc,
                        Con.iva AS IvaDesc,
                        Con.dias AS Dias,
                        Con.total_Prestamo AS TotalPrestamo,
                        Con.total_Interes AS TotalInteres,
                        Con.suma_InteresPrestamo AS TotalInteresPrestamo,
                        Con.polizaSeguro AS PolizaSeguro,
                        Con.gps AS GPS,
                        Con.abono AS Abono,
                        Con.fecha_Abono AS FechaAbono
                        FROM contratos_tbl as Con
                        WHERE Con.id_Contrato = '$idContratoDes' and Con.tipoContrato= 2  and Con.id_Estatus= 1";

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "FechaEmp" => $row["FechaEmp"],
                        "FechaEmpConvert" => $row["FechaEmpConvert"],
                        "FechaVenc" => $row["FechaVenc"],
                        "FechaVenConvert" => $row["FechaVenConvert"],
                        "FechaAlm" => $row["FechaAlm"],
                        "PlazoDesc" => $row["PlazoDesc"],
                        "TasaDesc" => $row["TasaDesc"],
                        "AlmacDesc" => $row["AlmacDesc"],
                        "SeguDesc" => $row["SeguDesc"],
                        "IvaDesc" => $row["IvaDesc"],
                        "Dias" => $row["Dias"],
                        "TotalPrestamo" => $row["TotalPrestamo"],
                        "TotalInteres" => $row["TotalInteres"],
                        "TotalInteresPrestamo" => $row["TotalInteresPrestamo"],
                        "PolizaSeguro" => $row["PolizaSeguro"],
                        "GPS" => $row["GPS"],
                        "Abono" => $row["Abono"],
                        "FechaAbono" => $row["FechaAbono"]
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


    public function estatusContratoAuto($idContratoDes)
    {
        $datos = array();
        try {
            $buscar = "SELECT Con.id_Contrato as Contrato, Con.fecha_creacion as Fecha,
                        CONCAT (Cli.nombre, ' ',Cli.apellido_Pat,' ', Cli.apellido_Mat) as NombreCompleto,
                        Est.descripcion as Estatus, Con.id_Estatus as idEstatus FROM contratos_tbl as Con
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        INNER JOIN cat_estatus as Est on Con.id_Estatus = Est.id_Estatus
                        WHERE Con.id_Contrato = '$idContratoDes' and Con.tipoContrato= 2";

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {

                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Contrato" => $row["Contrato"],
                        "Fecha" => $row["Fecha"],
                        "NombreCompleto" => $row["NombreCompleto"],
                        "Estatus" => $row["Estatus"],
                        "idEstatus" => $row["idEstatus"]
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


    public function costoContrato($contrato)
    {

        try {
            $resultado = -1;
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT Cos.costo AS Costo FROM contratos_tbl as Con
                       INNER JOIN cat_costo_contrato AS Cos ON Con.id_Formulario = Cos.id_formulario
                       WHERE Con.id_Contrato = $contrato and Cos.sucursal=$sucursal  and Con.sucursal=$sucursal";
            $statement = $this->conexion->query($buscar);
            if ($statement->num_rows > 0) {
                $fila = $statement->fetch_object();
                $resultado = $fila->Costo;
            } else {
                $resultado = -1;
            }

        } catch (Exception $exc) {
            $resultado = -1;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $resultado;
        //return $id;
    }
//Generar Refrendo
public function generarViejo($tipeFormulario, $newFechaVencimiento, $descuento, $newFechaAlm, $contrato, $idEstatusArt, $token,
$tipoContrato, $token_interes, $token_moratorio, $token_gps, $token_pension, $token_poliza, $token_movimiento, $token_decripcion, $estatusAnterior)
{
    // TODO: Implement guardaCiente() method.
try {
$fechaModificacion = date('Y-m-d H:i:s');
$usuario = $_SESSION["idUsuario"];
$sucursal = $_SESSION["sucursal"];

if ($tipeFormulario == 1) {
$updateArticulos = "UPDATE articulo_tbl SET  fecha_modificacion = '$fechaModificacion',usuario= $usuario, id_Estatus = $idEstatusArt 
                                WHERE id_Contrato=$contrato";
}
if ($tipeFormulario == 2) {
    $updateArticulos = "UPDATE auto_tbl SET  fecha_modificacion = '$fechaModificacion',usuario= $usuario, id_Estatus = $idEstatusArt 
                                WHERE id_Contrato=$contrato";
}

if ($ps = $this->conexion->prepare($updateArticulos)) {
    if ($ps->execute()) {
        if (empty($token)) {
            $verdad = 1;
        } else {
            $token_decripcion = mb_strtoupper($token_decripcion, 'UTF-8');
            $insertaBitacora = "INSERT INTO bit_token ( id_Contrato, tipo_Contrato, tipo_formulario,
                                                token, descripcion, descuento, interes, moratorio,gps,
                                                pension,poliza,id_tokenMovimiento, estatus, usuario, sucursal, fecha_Creacion)
                                        VALUES ($contrato, $tipoContrato,$tipeFormulario,
                                                '$token','$token_decripcion', $descuento, $token_interes,$token_moratorio,$token_gps,
                                                $token_pension,$token_poliza,$token_movimiento,1, $usuario, $sucursal,'$fechaModificacion')";
            if ($ps = $this->conexion->prepare($insertaBitacora)) {
                if ($ps->execute()) {
                    $updateToken = "UPDATE cat_token SET
                                         estatus = 2
                                        WHERE id_token =$token";
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
        }
    } else {
        $verdad = -16;
    }
} else {
    $verdad = -17;
}

} catch (Exception $exc) {
    $verdad = -20;
    echo $exc->getMessage();
} finally {
    $this->db->closeDB();
}
    //return $verdad;
    echo $verdad;
}

}

