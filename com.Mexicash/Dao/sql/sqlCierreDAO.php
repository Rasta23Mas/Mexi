<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlCierreDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }


    function datosSucursal($sucursal)
    {
        $datos = array();
        try {
            $buscar = "SELECT Nombre, direccion, telefono, NombreCasa,rfc FROM cat_sucursal WHERE id_Sucursal = " . $sucursal;
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

        //return  json_encode($data);
        echo json_encode($data);
    }

    function guardarArqueo(
        $idMilCantGlobal, $idQuinientosCantGlobal, $idDoscientosCantGlobal, $idCienCantGlobal, $idCincuentaCantGlobal, $idVeinteCantGlobal, $idVeinteMonCantGlobal,
        $idDiezCantGlobal, $idCincoCantGlobal, $idDosCantGlobal, $idUnoCantGlobal, $idCincuentaCCantGlobal, $idCentavosCantGlobal, $idMilGlobal, $idQuinientosGlobal,
        $idDoscientosGlobal, $idCienGlobal, $idCincuentaGlobal, $idVeinteGlobal, $idVeinteMonGlobal, $idDiezGlobal, $idCincoGlobal, $idDosGlobal, $idUnoGlobal,
        $idCincuentaCGlobal, $idCentavosGlobal, $totalArqueoMonedas, $totalArqueoBilletes, $totalArqueoGlobal, $guardadoPorGerenteGlb, $idCierreCaja, $idUsuarioCaja,
        $ajustesGbl, $incrementoPatGbl)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $fechaCreacion = date('Y-m-d H:i:s');


            $insertaArqueo = "INSERT INTO bit_arqueo (total_Cierre,total_Billetes,total_Monedas,mil_cant, quinientos_cant, doscientos_cant, cien_cant, cincuenta_cant,
                            veinte_cant, veinteMon_cant, diez_cant, cinco_cant, dos_cant, uno_cant, cincuentaMon_cant,
                            centavos_cant, mil_efe, quinientos_efe, doscientos_efe, cien_efe, cincuenta_efe, veinte_efe,
                            veinteMon_efe, diez_efe, cinco_efe, dos_efe, uno_efe, cincuentaMon_efe, centavos, 
                            id_cierreCaja, usuario, sucursal, fecha_Creacion,estatus,guardadoPorGerente,ajustes,incremento_pat)
                            VALUES 
                            ($totalArqueoGlobal, $totalArqueoBilletes,$totalArqueoMonedas,
                             $idMilCantGlobal,$idQuinientosCantGlobal,$idDoscientosCantGlobal,$idCienCantGlobal,
                             $idCincuentaCantGlobal,$idVeinteCantGlobal,$idVeinteMonCantGlobal,$idDiezCantGlobal,
                             $idCincoCantGlobal,$idDosCantGlobal,$idUnoCantGlobal,$idCincuentaCCantGlobal, 
                             $idCentavosCantGlobal, $idMilGlobal, $idQuinientosGlobal,$idDoscientosGlobal,
                             $idCienGlobal, $idCincuentaGlobal, $idVeinteGlobal, $idVeinteMonGlobal, $idDiezGlobal,
                             $idCincoGlobal, $idDosGlobal, $idUnoGlobal, $idCincuentaCGlobal, $idCentavosGlobal,
                             $idCierreCaja,$idUsuarioCaja,$sucursal,'$fechaCreacion',1,$guardadoPorGerenteGlb,$ajustesGbl,$incrementoPatGbl);";

            if ($ps = $this->conexion->prepare($insertaArqueo)) {
                if ($ps->execute()) {
                    $buscarArqueo = "select max(id_Arqueo) as Arqueo from bit_arqueo where sucursal = $sucursal";
                    $statement = $this->conexion->query($buscarArqueo);
                    $encontro = $statement->num_rows;
                    if ($encontro > 0) {
                        $fila = $statement->fetch_object();
                        $IDArqueo = $fila->Arqueo;
                        $verdad = $IDArqueo;

                    }
                } else {
                    $verdad = -2;
                }
            } else {
                $verdad = -3;
            }
        } catch (Exception $exc) {
            $verdad = -4;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
    }

    function validaCierreCaja($idCierreCaja)
    {
        try {
            $buscar = "SELECT folio_CierreCaja, estatus FROM bit_cierrecaja
                       WHERE  id_cierreCaja=$idCierreCaja and estatus!=20";
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

        //return  json_encode($data);
        echo json_encode($data);
    }

    function validaCierreCajaArqueo($idCierreCaja)
    {
        try {
            $buscarMaxArqueo = "SELECT max(id_Arqueo) as idArqueo 
                                    FROM bit_arqueo WHERE id_cierreCaja= $idCierreCaja";
            $rs = $this->conexion->query($buscarMaxArqueo);
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

        //return  json_encode($data);
        echo json_encode($data);
    }

    function traerCierreCaja($idUsuarioSelect)
    {
        try {

            $buscar = "select id_cierreCaja from bit_cierrecaja AS Caj
                        INNER JOIN bit_cierresucursal AS Suc ON Caj.id_CierreSucursal = Suc.id_CierreSucursal
                            where Caj.usuario = " . $idUsuarioSelect . " and Caj.estatus = 1  and Suc.estatus = 1";
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

        //return  json_encode($data);
        echo json_encode($data);
    }

    function llenarMovimientosCaja($idUsuarioSelect)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT id_cat_flujo,importe FROM flujo_tbl
                       WHERE sucursal= $sucursal AND usuarioCaja=$idUsuarioSelect";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_cat_flujo" => $row["id_cat_flujo"],
                        "importe" => $row["importe"],
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

    function llenarEntradasySalidas($idUsuarioSelect, $idCierreCaja)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT Con.tipo_movimiento, Con.e_pagoDesempeno,Con.e_costoContrato,
                       Con.e_abono,  Con.s_descuento_aplicado,  Con.s_prestamo_nuevo, Con.e_iva,e_intereses,e_moratorios,
                       e_gps,	e_poliza,e_pension,s_descuento_venta,e_venta_mostrador,e_venta_iva,e_venta_apartados,e_venta_abono 
                       FROM contratomovimientos_tbl AS Con
                       WHERE Con.sucursal= $sucursal AND Con.usuario=$idUsuarioSelect AND Con.id_CierreCaja=$idCierreCaja";

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "tipo_movimiento" => $row["tipo_movimiento"],
                        "e_pagoDesempeno" => $row["e_pagoDesempeno"],
                        "e_costoContrato" => $row["e_costoContrato"],
                        "e_abono" => $row["e_abono"],
                        "s_descuento_aplicado" => $row["s_descuento_aplicado"],
                        "s_prestamo_nuevo" => $row["s_prestamo_nuevo"],
                        "e_iva" => $row["e_iva"],
                        "e_intereses" => $row["e_intereses"],
                        "e_moratorios" => $row["e_moratorios"],
                        "e_gps" => $row["e_gps"],
                        "e_poliza" => $row["e_poliza"],
                        "e_pension" => $row["e_pension"],
                        "s_descuento_venta" => $row["s_descuento_venta"],
                        "e_venta_mostrador" => $row["e_venta_mostrador"],
                        "e_venta_iva" => $row["e_venta_iva"],
                        "e_venta_apartados" => $row["e_venta_apartados"],
                        "e_venta_abono" => $row["e_venta_abono"],


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

    function llenarEfectivoCaja($idCierreCaja)
    {
        $datos = array();
        try {
            $buscarFlujoGenerado = "SELECT max(id_Arqueo) as idArqueo FROM bit_arqueo WHERE id_cierreCaja= $idCierreCaja";
            $statement = $this->conexion->query($buscarFlujoGenerado);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $idArqueo = $fila->idArqueo;
                $buscar = "SELECT total_Cierre FROM bit_arqueo
                       WHERE  id_Arqueo=$idArqueo";
                $rs = $this->conexion->query($buscar);
                if ($rs->num_rows > 0) {
                    while ($row = $rs->fetch_assoc()) {
                        $data = [
                            "total_Cierre" => $row["total_Cierre"]
                        ];
                        array_push($datos, $data);
                    }
                }
            }else{
                echo -1;
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($datos);
    }

    function llenarAjustesCaja($idCierreCaja)
    {
        $datos = array();
        try {
            $buscar = "SELECT ajustes,incremento_pat FROM bit_arqueo
                       WHERE  id_cierreCaja=$idCierreCaja";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "ajustes" => $row["ajustes"],
                        "incremento_pat" => $row["incremento_pat"]
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

    function guardarCierreCaja($cantDotaciones, $dotacionesA_Caja, $cantCapitalRecuperado, $capitalRecuperado, $cantAbono, $abonoCapital, $cantInteres, $intereses,
                               $cantIva, $iva, $cantMostrador, $mostrador, $cantIvaVenta, $iva_venta, $cantApartados,$apartadosVenta,$cantAbonoVenta,$abonoVentas,
                               $cantGps, $gps,
                               $cantPoliza, $poliza, $cantPension, $pension, $cantRetiros, $retirosCaja, $cantPrestamos, $prestamosNuevos, $cantDescuentos, $descuentosAplicados,
                               $cantDescuentosVentas, $descuento_Ventas, $cantCostoContrato, $costoContrato, $total_Salida, $total_Entrada, $total_Iva,$saldo_Caja, $efectivo_Caja,
                               $cantAjustes, $ajuste,$CantIncremento, $incrementoPatrimonio, $cantRefrendos, $informeRefrendo, $idCierreCaja, $cerradoPorGerenteGlb)
    {
        try {
            $fechaCreacion = date('Y-m-d H:i:s');

            $updateArqueo = "UPDATE bit_cierrecaja SET 
                            cantDotaciones=$cantDotaciones,dotacionesA_Caja=$dotacionesA_Caja,cantCapitalRecuperado=$cantCapitalRecuperado,capitalRecuperado=$capitalRecuperado,
                            cantAbono=$cantAbono,abonoCapital=$abonoCapital,cantInteres=$cantInteres,intereses=$intereses,cantIva=$cantIva,iva=$iva,
                            cantMostrador=$cantMostrador,mostrador=$mostrador,cantIvaVenta=$cantIvaVenta,iva_venta=$iva_venta,cantApartados=$cantApartados,
                            apartadosVentas=$apartadosVenta,cantAbonoVentas=$cantAbonoVenta,
                            abonoVentas=$abonoVentas,cantGps=$cantGps,gps=$gps,cantPoliza=$cantPoliza,poliza=$poliza,cantPension=$cantPension,
                            pension=$pension,cantRetiros=$cantRetiros,retirosCaja=$retirosCaja,cantPrestamos=$cantPrestamos,prestamosNuevos=$prestamosNuevos,
                            cantDescuentos=$cantDescuentos,descuentosAplicados=$descuentosAplicados,cantDescuentosVentas=$cantDescuentosVentas,
                            descuento_Ventas=$descuento_Ventas,cantCostoContrato=$cantCostoContrato,costoContrato=$costoContrato,total_Salida=$total_Salida,
                            total_Entrada=$total_Entrada,total_Iva=$total_Iva,saldo_Caja=$saldo_Caja,efectivo_Caja=$efectivo_Caja,cantAjustes=$cantAjustes,ajuste=$ajuste,cantIncremento=$CantIncremento,incremento=$incrementoPatrimonio,
                            cantRefrendos=$cantRefrendos,informeRefrendo=$informeRefrendo,fecha_Creacion='$fechaCreacion',estatus=2, CerradoPorGerente=$cerradoPorGerenteGlb WHERE id_CierreCaja=$idCierreCaja and estatus =1";
            if ($ps = $this->conexion->prepare($updateArqueo)) {
                if ($ps->execute()) {
                    $verdad = mysqli_stmt_affected_rows($ps);
                } else {
                    $verdad = -2;
                }
            } else {
                $verdad = -3;
            }
        } catch (Exception $exc) {
            $verdad = -4;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
    }

    function cargarUsuariosCaja()
    {
        $datos = array();

        try {
            $sucursal = $_SESSION["sucursal"];
            $tipoUsuario = $_SESSION['tipoUsuario'];
            $usuario = $_SESSION["idUsuario"];


            $buscar = "SELECT Bit.usuario AS idUsuario, Usu.usuario AS Usuario FROM bit_cierrecaja AS Bit 
                        INNER JOIN usuarios_tbl  AS Usu ON Bit.usuario = Usu.id_User
                        WHERE sucursal = $sucursal and estatus = 1 and id_CierreSucursal = 1 ";
            if ($tipoUsuario == 4) {
                $buscar .= " AND Bit.Usuario = $usuario";
            }
            $buscar .= " ORDER BY Usu.id_User";
            echo $buscar;
            $rs = $this->conexion->query($buscar);

            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "idUsuario" => $row["idUsuario"],
                        "Usuario" => $row["Usuario"],
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

    function llenarInformeRefrendo($idCierreCaja)
    {
        $datos = array();
        try {
            $buscar = "SELECT s_prestamo_nuevo AS Prestamo
                        FROM contratomovimientos_tbl AS Mov 
                        WHERE Mov.id_CierreCaja=$idCierreCaja AND 
                         Mov.tipo_movimiento = 4 || Mov.tipo_movimiento = 8";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Prestamo" => $row["Prestamo"],
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

    function ArqueoEntradasySalidas( $idCierreCaja)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT Con.tipo_movimiento, Con.e_pagoDesempeno,Con.e_costoContrato,
                       Con.e_abono,  Con.s_descuento_aplicado,  Con.s_prestamo_nuevo, Con.e_iva,e_intereses,e_moratorios,
                       e_gps,	e_poliza,e_pension 
                       FROM contratomovimientos_tbl AS Con
                       WHERE Con.id_CierreCaja=$idCierreCaja AND Con.tipo_movimiento !=20";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "tipo_movimiento" => $row["tipo_movimiento"],
                        "e_pagoDesempeno" => $row["e_pagoDesempeno"],
                        "e_costoContrato" => $row["e_costoContrato"],
                        "e_abono" => $row["e_abono"],
                        "s_descuento_aplicado" => $row["s_descuento_aplicado"],
                        "s_prestamo_nuevo" => $row["s_prestamo_nuevo"],
                        "e_iva" => $row["e_iva"],
                        "e_intereses" => $row["e_intereses"],
                        "e_moratorios" => $row["e_moratorios"],
                        "e_gps" => $row["e_gps"],
                        "e_poliza" => $row["e_poliza"],
                        "e_pension" => $row["e_pension"],


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

    public function busquedaPorFechasCajaCierre($fechaInicial, $fechaFinal)
    {
        $datos = array();
        try {
            $buscar = "SELECT Bit.folio_CierreCaja,Bit.id_CierreCaja,Bit.id_CierreSucursal,Usu.usuario AS usuario,
                        Bit.CerradoPorGerente, Est.descripcion AS estatus ,Bit.fecha_Creacion
                        FROM bit_cierrecaja AS Bit 
                        INNER JOIN 
                        usuarios_tbl as Usu on Bit.usuario = Usu.id_User
                        INNER JOIN 
                        cat_estatusflujo as Est on Bit.estatus = Est.estatus
                        WHERE Bit.fecha_Creacion between '$fechaInicial' AND '$fechaFinal' ";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "folio_CierreCaja" => $row["folio_CierreCaja"],
                        "id_CierreCaja" => $row["id_CierreCaja"],
                        "id_CierreSucursal" => $row["id_CierreSucursal"],
                        "usuario" => $row["usuario"],
                        "CerradoPorGerente" => $row["CerradoPorGerente"],
                        "estatus" => $row["estatus"],
                        "fecha_Creacion" => $row["fecha_Creacion"]
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

    public function busquedaPorFechasSucursalCierre($fechaInicial, $fechaFinal)
    {
        $datos = array();
        try {
            $buscar = "SELECT Bit.folio_CierreCaja,Bit.id_CierreCaja,Bit.id_CierreSucursal,Usu.usuario AS usuario,
                        Bit.CerradoPorGerente, Bit.estatus ,Bit.fecha_Creacion
                        FROM bit_cierrecaja AS Bit 
                        INNER JOIN 
                        usuarios_tbl as Usu on Bit.usuario = Usu.id_User";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "folio_CierreCaja" => $row["folio_CierreCaja"],
                        "id_CierreCaja" => $row["id_CierreCaja"],
                        "id_CierreSucursal" => $row["id_CierreSucursal"],
                        "usuario" => $row["usuario"],
                        "CerradoPorGerente" => $row["CerradoPorGerente"],
                        "fecha_Creacion" => $row["fecha_Creacion"]
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


    function validarCierreSucursal($idCierreSucursal)
    {
        try {
            $buscar = "SELECT folio_CierreSucursal FROM bit_cierresucursal
                       WHERE id_CierreSucursal= $idCierreSucursal AND estatus=1";
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

    function llenarSaldosSucursal($idCierreSucursal)
    {
        try {
            $buscar = "SELECT saldo_Inicial, InfoSaldoInicial FROM bit_cierresucursal
                       WHERE id_CierreSucursal= $idCierreSucursal AND estatus=1";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                $consulta = $rs->fetch_assoc();
                $data['status'] = 'ok';
                $data['result'] = $consulta;
            } else {
                $data['status'] = 'NO';
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo json_encode($data);
    }

    function llenarEntradasSalidas($idCierreSucursal)
    {
        $datos = array();
        try {
            $buscar = "SELECT dotacionesA_Caja,cantCapitalRecuperado,capitalRecuperado,cantAbono,abonoCapital,intereses,iva,
                        cantMostrador, mostrador, cantIvaVenta, iva_venta, cantApartados,apartadosVentas,cantAbonoVentas,abonoVentas,gps, poliza,pension,cantAjustes, ajuste,
                        CantIncremento,incremento,
                        cantRetiros,retirosCaja, cantPrestamos,prestamosNuevos,cantDescuentos,descuentosAplicados,cantDescuentosVentas,descuento_Ventas,cantCostoContrato,
                        costoContrato,total_Salida,total_Entrada,total_Iva
                        FROM bit_cierrecaja
                        WHERE id_CierreSucursal= $idCierreSucursal AND estatus=2";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "dotacionesA_Caja" => $row["dotacionesA_Caja"],
                        "cantCapitalRecuperado" => $row["cantCapitalRecuperado"],
                        "capitalRecuperado" => $row["capitalRecuperado"],
                        "cantAbono" => $row["cantAbono"],
                        "abonoCapital" => $row["abonoCapital"],
                        "intereses" => $row["intereses"],
                        "iva" => $row["iva"],
                        "cantMostrador" => $row["cantMostrador"],
                        "mostrador" => $row["mostrador"],
                        "cantIvaVenta" => $row["cantIvaVenta"],
                        "iva_venta" => $row["iva_venta"],
                        "cantApartados" => $row["cantApartados"],
                        "apartadosVentas" => $row["apartadosVentas"],
                        "cantAbonoVentas" => $row["cantAbonoVentas"],
                        "abonoVentas" => $row["abonoVentas"],
                        "gps" => $row["gps"],
                        "poliza" => $row["poliza"],
                        "pension" => $row["pension"],
                        "cantAjustes" => $row["cantAjustes"],
                        "ajuste" => $row["ajuste"],
                        "CantIncremento" => $row["CantIncremento"],
                        "incrementoPatrimonio" => $row["incremento"],
                        "cantRetiros" => $row["cantRetiros"],
                        "retirosCaja" => $row["retirosCaja"],
                        "cantPrestamos" => $row["cantPrestamos"],
                        "prestamosNuevos" => $row["prestamosNuevos"],
                        "cantDescuentos" => $row["cantDescuentos"],
                        "descuentosAplicados" => $row["descuentosAplicados"],
                        "cantDescuentosVentas" => $row["cantDescuentosVentas"],
                        "descuento_Ventas" => $row["descuento_Ventas"],
                        "cantCostoContrato" => $row["cantCostoContrato"],
                        "costoContrato" => $row["costoContrato"],
                        "total_Salida" => $row["total_Salida"],
                        "total_Entrada" => $row["total_Entrada"],
                        "totalIVA" => $row["total_Iva"],

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

    function llenarGenerales($idCierreSucursal)
    {
        $datos = array();
        try {
            $buscar = "SELECT importe, id_cat_flujo  FROM flujo_tbl
                        WHERE id_cierreSucursal= $idCierreSucursal";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "importe" => $row["importe"],
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

    function llenarInformativo()
    {
        $datos = array();
        try {
            $id_CierreSucursal = $_SESSION["idCierreSucursal"];

            $buscar = "SELECT prestamo_Empeno,tipo_movimiento  FROM bazar_articulos
                        WHERE id_CierreSucursal= $id_CierreSucursal and tipo_movimiento=22 || tipo_movimiento=23";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "prestamo_Empeno" => $row["prestamo_Empeno"],
                        "tipo_movimiento" => $row["tipo_movimiento"],
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
    function ventasInfo()
    {
        $datos = array();
        try {
            $fechaCreacion = date('Y-m-d');
            $buscar = "SELECT prestamo_Informativo,v_PrecioVenta
                        FROM contratomovimientos_tbl
                        WHERE  fecha_Venta='$fechaCreacion' and tipo_movimiento = 6";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "prestamo_Informativo" => $row["prestamo_Informativo"],
                        "v_PrecioVenta" => $row["v_PrecioVenta"],
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

    function pasarBazar()
    {
        $datos = array();
        try {
            $fechaCreacion = date('Y-m-d');
            $buscar = "SELECT prestamo_Informativo
                        FROM contratomovimientos_tbl
                        WHERE  fecha_Bazar='$fechaCreacion'";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "prestamo_Informativo" => $row["prestamo_Informativo"],
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


    function llenarTotalInformativo()
    {
        $datos = array();
        try {

            $buscar = "SELECT s_prestamo_nuevo,tipo_movimiento FROM contratomovimientos_tbl 
                        WHERE tipo_movimiento=3 and id_contrato not in 
                        (select id_contrato FROM contratomovimientos_tbl 
                        where tipo_movimiento = 4 || tipo_movimiento = 5 || tipo_movimiento = 5 
                        || tipo_movimiento = 20 || tipo_movimiento = 24 )";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "s_prestamo_nuevo" => $row["s_prestamo_nuevo"],
                        "tipo_movimiento" => $row["tipo_movimiento"],
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
    function saldoInicialInformativo()
    {
        $datos = array();
        try {
            $buscar = "SELECT prestamo_Informativo  FROM contratomovimientos_tbl
                        WHERE tipo_movimiento=24";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "prestamo_Informativo" => $row["prestamo_Informativo"],
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

    function guardarCierreSucursal($dotacionesA_Caja,$CantAportacionesBoveda,$aportaciones_Boveda,$CantCapitalRecuperado,$capitalRecuperado,$CantAbono,
                                   $abonoCapital,$intereses, $iva,$CantVentasMostrador,$mostrador,$iva_venta, $cantCostoContrato, $costoContrato,
                                   $utilidadVenta, $CantApartados, $apartados, $CantAbonosVenta, $abonoVenta, $gps,$poliza,$pension,$CantAjustes,
                                   $ajustes,$CantRetirosCaja, $retirosCaja,$retiros_boveda,$CantPrestamosNuevos,$prestamosNuevos,$CantDescuentos,
                                   $descuentosAplicados,$CantDescuentosVentas,$descuentos_ventas, $cantIncremento, $incrementoPatrimonio,
                                   $total_Entrada,$total_Iva,$total_Salida,$saldo_final, $InfoSaldoInicial, $InfoEntradas, $InfoSalidas,$InfoSaldoFinal,
                                   $InfoApartados, $InfoAbono, $InfoTotalInventario, $idCierreSucursal)
    {
        try {
            $fechaCreacion = date('Y-m-d H:i:s');
            $estatus = 2;

            $updateCierreSucursal = "UPDATE bit_cierresucursal SET 
                             dotacionesA_Caja = $dotacionesA_Caja, CantAportacionesBoveda = $CantAportacionesBoveda,
                             aportaciones_Boveda = $aportaciones_Boveda,CantCapitalRecuperado = $CantCapitalRecuperado, 
                             capitalRecuperado = $capitalRecuperado, CantAbono = $CantAbono, abonoCapital = $abonoCapital,intereses = $intereses, 
                             CantCostoContrato = $cantCostoContrato,costoContrato = $costoContrato, 
                             iva = $iva, CantVentasMostrador = $CantVentasMostrador, mostrador = $mostrador, iva_venta = $iva_venta, 
                             utilidadVenta = $utilidadVenta,CantApartados = $CantApartados, apartados = $apartados, CantAbonoVentas = $CantAbonosVenta,
                             abonoVentas = $abonoVenta, gps = $gps, poliza = $poliza, pension = $pension, CantAjustes = $CantAjustes, ajustes = $ajustes,
                             CantRetirosCaja = $CantRetirosCaja, retirosCaja = $retirosCaja, retiros_boveda = $retiros_boveda,
                             CantPrestamosNuevos = $CantPrestamosNuevos, prestamosNuevos = $prestamosNuevos, CantDescuentos = $CantDescuentos, 
                             descuentosAplicados = $descuentosAplicados,CantDescuentosVentas = $CantDescuentosVentas, 
                             descuentos_ventas = $descuentos_ventas, CantIncremento = $cantIncremento, incrementoPatrimonio = $incrementoPatrimonio, 
                             total_Entrada = $total_Entrada,totalIVA = $total_Iva, total_Salida = $total_Salida, 
                             saldo_final = $saldo_final,
                             InfoSaldoInicial = $InfoSaldoInicial,InfoEntradas = $InfoEntradas,InfoSalidas = $InfoSalidas,InfoSaldoFinal = $InfoSaldoFinal,
                             InfoApartados = $InfoApartados,InfoAbono = $InfoAbono,InfoTotalInventario = $InfoTotalInventario,
                             fecha_Creacion = '$fechaCreacion', estatus = $estatus 
                             WHERE id_CierreSucursal=$idCierreSucursal and estatus =1";
            if ($ps = $this->conexion->prepare($updateCierreSucursal)) {
                if ($ps->execute()) {
                    $verdad = mysqli_stmt_affected_rows($ps);
                } else {
                    $verdad = -2;
                }
            } else {
                $verdad = -3;
            }
        } catch (Exception $exc) {
            $verdad = -4;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
    }

    function dotacionCajaAjustes($sucursal)
    {
        $datos = array();
        try {
            $buscar = "SELECT Nombre, direccion, telefono, NombreCasa,rfc FROM cat_sucursal WHERE id_Sucursal = " . $sucursal;
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

        //return  json_encode($data);
        echo json_encode($data);
    }

    function busquedaArqueoAnterior($usuarioCaja, $idCierreCaja)
    {
        $datos = array();
        try {
            $buscar = "SELECT total_Cierre, incremento_pat,ajustes FROM bit_arqueo
                       WHERE usuario= $usuarioCaja AND id_cierreCaja=$idCierreCaja";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "total_Cierre" => $row["total_Cierre"],
                        "incremento_pat" => $row["incremento_pat"],
                        "ajustes" => $row["ajustes"],

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

    function guardarBazar()
    {
        try {
            $fechaCreacion = date('Y-m-d');
            $insertaBazar = "INSERT INTO bazar_articulos 
                       (id_Contrato, id_serie, fecha_Bazar,precio_venta,tipo_movimiento,prestamo_Empeno,precio_Actual)
                        SELECT Art.id_Contrato, CONCAT (Art.id_SerieSucursal, 
                        Art.id_SerieContrato,Art.id_SerieArticulo) as idSerie,
                        Con.fecha_Bazar,Art.vitrina,24,Con.prestamo_Informativo,Con.prestamo_Informativo
                        FROM articulo_tbl as Art
                        INNER JOIN contratomovimientos_tbl as Con on Art.id_Contrato = Con.id_contrato
                        WHERE  Con.fecha_Bazar='$fechaCreacion'";
            if ($ps = $this->conexion->prepare($insertaBazar)) {
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

}