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
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT folio_CierreCaja, estatus FROM bit_cierrecaja
                       WHERE  id_cierreCaja=$idCierreCaja and estatus!=20  AND sucursal=$sucursal";
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
            $sucursal = $_SESSION["sucursal"];
            $buscarMaxArqueo = "SELECT max(id_Arqueo) as idArqueo 
                                    FROM bit_arqueo WHERE id_cierreCaja= $idCierreCaja AND sucursal=$sucursal";
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
            $sucursal = $_SESSION["sucursal"];

            $buscar = "select id_cierreCaja from bit_cierrecaja AS Caj
                        INNER JOIN bit_cierresucursal AS Suc ON Caj.id_CierreSucursal = Suc.id_CierreSucursal
                            where Caj.usuario = " . $idUsuarioSelect . " and Caj.estatus = 1  and Suc.estatus = 1  AND Caj.sucursal=$sucursal AND Suc.sucursal=$sucursal";
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
            $idCierreSucursal = $_SESSION["idCierreSucursal"];

            $buscar = "SELECT id_cat_flujo,importe FROM flujo_tbl
                       WHERE sucursal= $sucursal AND usuarioCaja=$idUsuarioSelect AND id_cierreSucursal=$idCierreSucursal";
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

    function llenarEntradasySalidas($idCierreCaja)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT Con.tipo_movimiento, Con.e_capital_recuperado,Con.e_pagoDesempeno,Con.e_costoContrato,
                       Con.e_abono,  Con.s_descuento_aplicado,  Con.s_prestamo_nuevo, Con.e_iva,e_intereses,e_moratorios,
                       e_gps,	e_poliza,e_pension
                       FROM contrato_mov_tbl AS Con
                       WHERE Con.sucursal = $sucursal AND Con.id_CierreCaja=$idCierreCaja AND Con.tipo_movimiento !=20";

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "tipo_movimiento" => $row["tipo_movimiento"],
                        "e_capital_recuperado" => $row["e_capital_recuperado"],
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

    function sqlLlenarEntradasySalidasVentas($idCierreCaja)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT tipo_movimiento,subTotal,abono,apartado,descuento_Venta,iva
                       FROM contrato_mov_baz_tbl  
                       WHERE id_CierreCaja=$idCierreCaja AND tipo_movimiento !=20 AND sucursal=$sucursal";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "tipo_movimiento" => $row["tipo_movimiento"],
                        "subTotal" => $row["subTotal"],
                        "abono" => $row["abono"],
                        "apartado" => $row["apartado"],
                        "descuento_Venta" => $row["descuento_Venta"],
                        "iva" => $row["iva"],
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
            $sucursal = $_SESSION["sucursal"];

            $buscarFlujoGenerado = "SELECT max(id_Arqueo) as idArqueo FROM bit_arqueo WHERE id_cierreCaja= $idCierreCaja   AND sucursal=$sucursal";
            $statement = $this->conexion->query($buscarFlujoGenerado);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $idArqueo = $fila->idArqueo;
                $buscar = "SELECT total_Cierre FROM bit_arqueo
                       WHERE  id_Arqueo=$idArqueo AND sucursal=$sucursal";
                $rs = $this->conexion->query($buscar);
                if ($rs->num_rows > 0) {
                    while ($row = $rs->fetch_assoc()) {
                        $data = [
                            "total_Cierre" => $row["total_Cierre"]
                        ];
                        array_push($datos, $data);
                    }
                }
            } else {
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
            $sucursal = $_SESSION["sucursal"];


            $buscar = "SELECT ajustes,incremento_pat FROM bit_arqueo
                       WHERE  id_cierreCaja=$idCierreCaja AND sucursal=$sucursal";
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
                               $cantIva, $iva, $cantMostrador, $mostrador, $cantIvaVenta, $iva_venta, $cantApartados, $apartadosVenta, $cantAbonoVenta, $abonoVentas,
                               $cantGps, $gps,
                               $cantPoliza, $poliza, $cantPension, $pension, $cantRetiros, $retirosCaja, $cantPrestamos, $prestamosNuevos, $cantDescuentos, $descuentosAplicados,
                               $cantDescuentosVentas, $descuento_Ventas, $cantCostoContrato, $costoContrato, $total_Salida, $total_Entrada, $total_Iva, $saldo_Caja, $efectivo_Caja,
                               $cantAjustes, $ajuste, $CantIncremento, $incrementoPatrimonio, $cantRefrendos, $informeRefrendo, $idCierreCaja, $cerradoPorGerenteGlb)
    {
        try {
            $fechaCreacion = date('Y-m-d H:i:s');
            $sucursal = $_SESSION["sucursal"];
            $updateArqueo = "UPDATE bit_cierrecaja SET 
                            cantDotaciones=$cantDotaciones,dotacionesA_Caja=$dotacionesA_Caja,cantCapitalRecuperado=$cantCapitalRecuperado,capitalRecuperado=$capitalRecuperado,
                            cantAbono=$cantAbono,abonoCapital=$abonoCapital,cantInteres=$cantInteres,intereses=$intereses,cantIva=$cantIva,iva=$iva,
                            cantMostrador=$cantMostrador,mostrador=$mostrador,cantIvaVenta=$cantIvaVenta,iva_venta=$iva_venta,cantApartados=$cantApartados,
                            apartadosVentas=$apartadosVenta,cantAbonoVentas=$cantAbonoVenta,
                            abonoVentas=$abonoVentas,cantGps=$cantGps,gps=$gps,cantPoliza=$cantPoliza,poliza=$poliza,cantPension=$cantPension,
                            pension=$pension,cantRetiros=$cantRetiros,retirosCaja=$retirosCaja,cantPrestamos=$cantPrestamos,prestamosNuevos=$prestamosNuevos,
                            cantDescuentos=$cantDescuentos,descuentosAplicados=$descuentosAplicados,cantDescuentosVentas=$cantDescuentosVentas,
                            descuento_Ventas=$descuento_Ventas,cantCostoContrato=$cantCostoContrato,costoContrato=$costoContrato,total_Salida=$total_Salida,
                            total_Entrada=$total_Entrada,total_Iva=$total_Iva,saldo_Caja=$saldo_Caja,efectivo_Caja=$efectivo_Caja,cantAjustes=$cantAjustes,
                            ajuste=$ajuste,cantIncremento=$CantIncremento,incremento=$incrementoPatrimonio,
                            cantRefrendos=$cantRefrendos,informeRefrendo=$informeRefrendo,fecha_Creacion='$fechaCreacion',
                            estatus=2, CerradoPorGerente=$cerradoPorGerenteGlb,flag_Activa=0,CierreCajaIndispensable=0  
                            WHERE id_CierreCaja=$idCierreCaja AND sucursal = $sucursal and estatus =1";
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

    public function guardarFlujoDeCaja($id_catFlujo, $importe, $importeLetra, $usuarioCaja)
    {
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscarFlujoGenerado = "SELECT id_flujo FROM flujo_tbl WHERE id_cat_flujo= 0 AND sucursal = $sucursal";
            $statement = $this->conexion->query($buscarFlujoGenerado);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $id_flujo = $fila->id_flujo;
                $fechaCreacion = date('Y-m-d H:i:s');
                $usuario = $_SESSION["idUsuario"];
                $concepto = "CIERRE DE CAJA";
                $updateFlujo = "UPDATE flujo_tbl SET importe=$importe,importeLetra='$importeLetra',id_cat_flujo=$id_catFlujo,
                fechaCreacion='$fechaCreacion',estatus=1,concepto = '$concepto',usuario=$usuario,usuarioCaja=$usuarioCaja 
                WHERE id_flujo=$id_flujo";
                if ($ps = $this->conexion->prepare($updateFlujo)) {
                    if ($ps->execute()) {
                        $sucursal = $_SESSION["sucursal"];
                        $buscarSaldoBoveda = "SELECT importe as ImporteBoveda FROM flujototales_tbl  
                                                WHERE sucursal=$sucursal and id_flujoAgente=3";
                        $statement = $this->conexion->query($buscarSaldoBoveda);
                        $encontro = $statement->num_rows;
                        if ($encontro > 0) {
                            $fila = $statement->fetch_object();
                            $importeBoveda = $fila->ImporteBoveda;
                            $nuevoImporte = $importeBoveda + $importe;
                            $updateBoveda = "UPDATE flujototales_tbl SET importe=$nuevoImporte,
                                            fechaModificacion='$fechaCreacion'
                                            WHERE sucursal=$sucursal and id_flujoAgente=3";
                            if ($ps = $this->conexion->prepare($updateBoveda)) {
                                if ($ps->execute()) {
                                    $buscarSaldoBoveda = "SELECT importe as ImporteCaja FROM flujototales_tbl  
                                                WHERE usuario=$usuarioCaja";
                                    $statement = $this->conexion->query($buscarSaldoBoveda);
                                    $encontro = $statement->num_rows;
                                    if ($encontro > 0) {
                                        $fila = $statement->fetch_object();
                                        $ImporteCaja = $fila->ImporteCaja;
                                        $nuevoImporteCaja = $ImporteCaja - $importe;
                                        $updateCaja = "UPDATE flujototales_tbl SET importe=$nuevoImporteCaja,
                                            fechaModificacion='$fechaCreacion'
                                            WHERE usuario=$usuarioCaja";
                                        if ($ps = $this->conexion->prepare($updateCaja)) {
                                            if ($ps->execute()) {
                                                $verdad = 33;
                                            } else {
                                                $verdad = -1;
                                            }
                                        }
                                    } else {
                                        $verdad = -12;
                                    }
                                } else {
                                    $verdad = -1;
                                }
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

    public function sqlValidarFolioCaja()
    {
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscarFlujoGenerado = "SELECT id_flujo FROM flujo_tbl WHERE id_cat_flujo= 0 AND sucursal = $sucursal";
            $statement = $this->conexion->query($buscarFlujoGenerado);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $verdad = 1;
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

    function cargarUsuariosCaja()
    {
        $datos = array();

        try {
            $sucursal = $_SESSION["sucursal"];
            $tipoUsuario = $_SESSION['tipoUsuario'];
            $usuario = $_SESSION["idUsuario"];


            $buscar = "SELECT Bit.usuario AS idUsuario, Usu.usuario AS Usuario FROM bit_cierrecaja AS Bit 
                        INNER JOIN usuarios_tbl  AS Usu ON Bit.usuario = Usu.id_User
                        WHERE sucursal = $sucursal and estatus = 1 ";
            if ($tipoUsuario == 3) {
                $buscar .= " AND Bit.usuario = $usuario";
            }else if ($tipoUsuario == 4) {
            $buscar .= " AND Bit.usuario = $usuario";
            }
            $buscar .= " ORDER BY Usu.id_User";
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
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT s_prestamo_nuevo AS Prestamo
                        FROM contrato_mov_tbl AS Mov 
                        WHERE Mov.id_CierreCaja=$idCierreCaja AND sucursal=$sucursal AND 
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

    function ArqueoEntradasySalidas($idCierreCaja)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT tipo_movimiento, pag_total,prestamo_Informativo
                       FROM contrato_mov_tbl AS Con
                       WHERE Con.id_CierreCaja=$idCierreCaja AND sucursal = $sucursal AND Con.tipo_movimiento !=20";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "tipo_movimiento" => $row["tipo_movimiento"],
                        "pag_total" => $row["pag_total"],
                        "prestamo_Informativo" => $row["prestamo_Informativo"]


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

    function sqlArqueoEntradasySalidasVentas($idCierreCaja)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT tipo_movimiento,subTotal,abono,apartado
                       FROM contrato_mov_baz_tbl  
                       WHERE id_CierreCaja=$idCierreCaja AND sucursal =$sucursal  AND tipo_movimiento !=20 ";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "tipo_movimiento" => $row["tipo_movimiento"],
                        "subTotal" => $row["subTotal"],
                        "abono" => $row["abono"],
                        "apartado" => $row["apartado"],
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
    function sqlArqueoEntradasySalidasCompras($idCierreCaja)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT total
                       FROM contrato_mov_com_tbl  
                       WHERE id_CierreCaja=$idCierreCaja AND sucursal =$sucursal AND tipo_movimiento !=20 ";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "total" => $row["total"],
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
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT folio_CierreSucursal FROM bit_cierresucursal
                       WHERE id_CierreSucursal= $idCierreSucursal AND estatus=1  and sucursal=$sucursal";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "folio_CierreSucursal" => $row["folio_CierreSucursal"],
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

    function llenarSaldosSucursal($idCierreSucursal)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT saldo_Inicial, InfoSaldoInicial FROM bit_cierresucursal
                       WHERE id_CierreSucursal= $idCierreSucursal AND estatus=1 and sucursal=$sucursal";
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
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT dotacionesA_Caja,cantCapitalRecuperado,capitalRecuperado,cantAbono,abonoCapital,intereses,iva,
                        cantMostrador, mostrador, cantIvaVenta, iva_venta, cantApartados,apartadosVentas,cantAbonoVentas,abonoVentas,gps, poliza,pension,cantAjustes, ajuste,
                        CantIncremento,incremento,
                        cantRetiros,retirosCaja, cantPrestamos,prestamosNuevos,cantDescuentos,descuentosAplicados,cantDescuentosVentas,descuento_Ventas,cantCostoContrato,
                        costoContrato,total_Salida,total_Entrada,total_Iva
                        FROM bit_cierrecaja
                        WHERE id_CierreSucursal= $idCierreSucursal AND estatus=2 and sucursal=$sucursal";
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
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT importe, id_cat_flujo  FROM flujo_tbl
                        WHERE id_cierreSucursal= $idCierreSucursal AND sucursal = $sucursal";
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

    function sqlLlenarInformativo()
    {
        $datos = array();
        try {
            $id_CierreSucursal = $_SESSION["idCierreSucursal"];
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT abono,apartado, tipo_movimiento  FROM contrato_mov_baz_tbl
                        WHERE id_CierreSucursal= $id_CierreSucursal AND sucursal= $sucursal and tipo_movimiento=22 || tipo_movimiento=23";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "abono" => $row["abono"],
                        "apartado" => $row["apartado"],
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
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT total,utilidad
                        FROM contrato_mov_baz_tbl
                        WHERE  DATE_FORMAT(fecha_Creacion,'%Y-%m-%d')='$fechaCreacion' and tipo_movimiento = 6 AND sucursal= $sucursal";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "total" => $row["total"],
                        "utilidad" => $row["utilidad"],
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
                        FROM contrato_mov_tbl
                        WHERE  fechaAlmoneda='$fechaCreacion'";
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

            $buscar = "SELECT s_prestamo_nuevo,tipo_movimiento FROM contrato_mov_tbl 
                        WHERE tipo_movimiento=3 and id_contrato not in 
                        (select id_contrato FROM contrato_mov_tbl 
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
            $buscar = "SELECT prestamo_Informativo  FROM contrato_mov_tbl
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

    function guardarCierreSucursal($dotacionesA_Caja, $CantAportacionesBoveda, $aportaciones_Boveda, $CantCapitalRecuperado, $capitalRecuperado, $CantAbono,
                                   $abonoCapital, $intereses, $iva, $CantVentasMostrador, $mostrador, $iva_venta, $cantCostoContrato, $costoContrato,
                                   $utilidadVenta, $CantApartados, $apartados, $CantAbonosVenta, $abonoVenta, $gps, $poliza, $pension, $CantAjustes,
                                   $ajustes, $CantRetirosCaja, $retirosCaja, $retiros_boveda, $CantPrestamosNuevos, $prestamosNuevos, $CantDescuentos,
                                   $descuentosAplicados, $CantDescuentosVentas, $descuentos_ventas, $cantIncremento, $incrementoPatrimonio,
                                   $total_Entrada, $total_Iva, $total_Salida, $saldo_final, $InfoSaldoInicial, $InfoEntradas, $InfoSalidas, $InfoSaldoFinal,
                                   $InfoApartados, $InfoAbono, $InfoTotalInventario, $idCierreSucursal)
    {
        try {
            $fechaCreacion = date('Y-m-d H:i:s');
            $estatus = 2;
            $sucursal = $_SESSION["sucursal"];

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
                             fecha_Creacion = '$fechaCreacion', estatus = $estatus ,flag_Activa = 0 
                             WHERE id_CierreSucursal=$idCierreSucursal AND sucursal = $sucursal and estatus =1";
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
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT total_Cierre, incremento_pat,ajustes FROM bit_arqueo
                       WHERE usuario= $usuarioCaja AND id_cierreCaja=$idCierreCaja AND sucursal = $sucursal";
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

            $insertaBazar = "INSERT INTO articulo_bazar_tbl(id_Contrato, id_serie, id_Articulo, tipo_movimiento,
                                fecha_Bazar, tipoArticulo, tipo, kilataje, calidad, cantidad, peso, peso_Piedra,
                                piedras, marca, modelo, num_Serie, prestamo, avaluo, vitrina,precioCat,
                                observaciones, detalle, fecha_creacion,descripcionCorta,sucursal)
                            SELECT Art.id_Contrato, CONCAT (id_SerieSucursal, Adquisiciones_Tipo, id_SerieContrato,id_SerieArticulo) as idSerie,
                                id_Articulo,24,fecha_almoneda, tipoArticulo, tipo, kilataje, calidad, cantidad,
                                peso, peso_Piedra, piedras, marca, modelo, num_Serie, prestamo, avaluo, vitrina,
                                precioCat, observaciones, detalle, Art.fecha_creacion,Art.descripcionCorta,
                                Art.sucursal
                            FROM articulo_tbl as Art
                            INNER JOIN contratos_tbl as Con on Art.id_Contrato = Con.id_contrato
                        WHERE  Con.fecha_almoneda='$fechaCreacion'";
            if ($ps = $this->conexion->prepare($insertaBazar)) {
                if ($ps->execute()) {
                    $respuesta = mysqli_stmt_affected_rows($ps);
                } else {
                    $respuesta = -1;
                }
            } else {
                $respuesta = -1;
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

    function actualizarBazar()
    {
        try {

            $fechaCreacion = date('Y-m-d');
            $sucursal = $_SESSION["sucursal"];
            $updateBazar = "UPDATE contrato_mov_tbl 
                                SET fechaAlmoneda='',tipo_movimiento=24
                                WHERE  fechaAlmoneda='$fechaCreacion' AND sucursal = $sucursal";
            if ($ps = $this->conexion->prepare($updateBazar)) {
                if ($ps->execute()) {
                    $verdad = mysqli_stmt_affected_rows($ps);
                } else {
                    $verdad = -2;
                }
            } else {
                $verdad = -3;
            }
        } catch (Exception $exc) {
            $respuesta = 4;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        //return $verdad;
        echo $verdad;
    }



    function verificarCierreCaja($idCierreSucursal)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT Usu.usuario as Nombre FROM bit_cierrecaja as Bit
                        INNER JOIN usuarios_tbl as Usu on Bit.usuario = Usu.id_User 
                        WHERE id_CierreSucursal=$idCierreSucursal AND sucursal= $sucursal AND CierreCajaIndispensable=1";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Nombre" => $row["Nombre"],
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


    public function sqlCierreCajaIndispensable($estatus)
    {
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {
            $sucursal = $_SESSION["sucursal"];
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $updateCajaIndispensable = "UPDATE bit_cierrecaja SET CierreCajaIndispensable=$estatus
                                            WHERE sucursal=$sucursal and  id_cierreCaja=$idCierreCaja";
            if ($ps = $this->conexion->prepare($updateCajaIndispensable)) {
                if ($ps->execute()) {
                    $verdad = 1;
                } else {
                    $verdad = -2;
                }
            } else {
                $verdad = -3;
            }
        } catch (Exception $exc) {
            $respuesta = 4;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        //return $verdad;
        echo $verdad;
    }
    public function sqlCierreCajaIndispensableUser($estatus,$user)
    {
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {
            $sucursal = $_SESSION["sucursal"];
            $id_CierreSucursal = $_SESSION["idCierreSucursal"];
            $buscar = "SELECT id_CierreCaja  FROM bit_cierrecaja 
                        WHERE usuario=$user AND sucursal= $sucursal 
                        AND id_CierreSucursal=$id_CierreSucursal and estatus=1";
            $statement = $this->conexion->query($buscar);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $id_CierreCajaSelect = $fila->id_CierreCaja;
                $updateCajaIndispensable = "UPDATE bit_cierrecaja SET CierreCajaIndispensable=$estatus
                                            WHERE sucursal=$sucursal and  id_cierreCaja=$id_CierreCajaSelect";
                if ($ps = $this->conexion->prepare($updateCajaIndispensable)) {
                    if ($ps->execute()) {
                        $verdad = 1;
                    } else {
                        $verdad = -2;
                    }
                } else {
                    $verdad = -3;
                }
            }
        } catch (Exception $exc) {
            $respuesta = 4;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        //return $verdad;
        echo $verdad;
    }
}
