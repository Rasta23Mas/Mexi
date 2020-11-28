<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlMigracionDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    //Busqueda de Contrato
    function sqlBuscarIdContrato()
    {
        $idBazar = 0;
        //Modifique los estatus de usuario
        try {

            $sucursal = $_SESSION["sucursal"];
            $IdCompraMax = 0;
            $buscar = "SELECT MAX(id_Contrato) as UltimaCompra FROM articulo_bazar_tbl 
                            WHERE sucursal=$sucursal  and compra_mig=1";
            $statement = $this->conexion->query($buscar);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $IdCompraMax = $fila->UltimaCompra;
            }
            $IdCompraMax++;

        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $IdCompraMax;
    }

    function sqlBuscarValidarContrato($idContratoSerie, $checkCompraGlb)
    {
        $idBazar = 0;
        //Modifique los estatus de usuario
        try {

            $sucursal = $_SESSION["sucursal"];
            $IdCompraMax = 0;
            $buscar = "SELECT id_Contrato FROM articulo_bazar_tbl WHERE sucursal=$sucursal
            AND id_contrato=$idContratoSerie";
            if ($checkCompraGlb != 0) {
                $buscar .= " AND compra_mig=1";
            }

            $statement = $this->conexion->query($buscar);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $IdCompraMax = $fila->id_Contrato;
            }

        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $IdCompraMax;
    }

    function sqlGuardarArticuloMig($idTipoEnviar, $idContrato, $idFolioMig, $idKilataje, $idCalidad, $idPiezas, $idCantidad,
                                   $idPeso, $idPiedras, $idPesoPiedra, $idMarca, $idModelo, $idSerie, $idIMEI, $idPrestamoMig, $idAvaluoMig,
                                   $idVitrinaMig, $descDetalle, $idObs, $SerieBazar, $id_serieTipo, $tipo_movimiento, $descripcionCorta, $tipoCMB,
                                   $checkCompraGlb)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];

            $descripcionCorta = strtoupper($descripcionCorta);
            $idObs = strtoupper($idObs);
            $descDetalle = strtoupper($descDetalle);

            $insert = "INSERT INTO articulo_bazar_tbl " .
                "(id_Contrato, id_serie,id_serieTipo,tipo_movimiento,tipoArticulo,tipo, " .
                " kilataje, calidad,piezas, cantidad, peso, piedras, peso_Piedra,
                      marca, modelo, num_Serie,IMEI,prestamo,avaluo,vitrina, " .
                " vitrinaVenta,observaciones, detalle,descripcionCorta,sucursal,id_cierreCaja,compra_mig,codigo_mig)  VALUES " .
                " ($idContrato,'$SerieBazar',$id_serieTipo,$tipo_movimiento,$idTipoEnviar,$tipoCMB,$idKilataje,
                        $idCalidad,$idPiezas,$idCantidad,$idPeso,$idPiedras,$idPesoPiedra,$idMarca,$idModelo,'$idSerie',
                        '$idIMEI',$idPrestamoMig,$idAvaluoMig,$idVitrinaMig,$idVitrinaMig,'$idObs','$descDetalle',
                         '$descripcionCorta',$sucursal,$idCierreCaja,$checkCompraGlb,$idFolioMig)";
            if ($ps = $this->conexion->prepare($insert)) {
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
        echo $verdad;
    }

    function sqlBuscarArticulosMig()

    {
        $datos = array();
        try {
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT id_ArticuloBazar,id_serie, descripcionCorta,observaciones,prestamo,vitrina
                        FROM articulo_bazar_tbl 
                        WHERE tipo_movimiento=33  and id_cierreCaja=$idCierreCaja AND sucursal=$sucursal";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_ArticuloBazar" => $row["id_ArticuloBazar"],
                        "id_serie" => $row["id_serie"],
                        "descripcionCorta" => $row["descripcionCorta"],
                        "observaciones" => $row["observaciones"],
                        "prestamo" => $row["prestamo"],
                        "vitrina" => $row["vitrina"],

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
        //echo json_encode($datos);
    }

    public function sqlEliminarArticuloMig($id_ArticuloBazar)
    {
        // TODO: Implement guardaCiente() method.
        try {
            $sucursal = $_SESSION["sucursal"];

            $eliminarArticulo = "DELETE FROM articulo_bazar_tbl WHERE id_ArticuloBazar=$id_ArticuloBazar
            AND sucursal=$sucursal";
            if ($ps = $this->conexion->prepare($eliminarArticulo)) {
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

    function sqlGuardarMig()
    {
        // TODO: Implement guardaCiente() method.
        try {

            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];

            $updateBitVentas = "UPDATE articulo_bazar_tbl SET tipo_movimiento = 24
                            WHERE sucursal=$sucursal AND tipo_movimiento =33 AND id_cierreCaja=$idCierreCaja";
            if ($ps = $this->conexion->prepare($updateBitVentas)) {
                if ($ps->execute()) {
                    $respuesta = 1;
                } else {
                    $respuesta = -1;
                }
            } else {
                $respuesta = 1;
            }
        }
        catch
            (Exception $exc) {
                $respuesta = -20;
                echo $exc->getMessage();
            } finally {
                $this->db->closeDB();
            }
        echo $respuesta;
    }


    public function sqlArticulosMigObsoletos(){
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        $idCierreCaja = $_SESSION['idCierreCaja'];
        $sucursal = $_SESSION["sucursal"];

        try {
            $eliminarArticulo = "DELETE FROM articulo_bazar_tbl WHERE tipo_movimiento =33 and 
                                    id_cierreCaja=$idCierreCaja AND sucursal=$sucursal";
            if ($this->conexion->query($eliminarArticulo) === TRUE) {
                $verdad = 1;
            } else {
                $verdad = 2;
            }
        } catch (Exception $exc) {
            $verdad = 4;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
    }

    public function sqlAutoMig($idContratoMig,$idFolioMig,$idPrestamoMig,$idAvaluoMig,$idVitrinaMig,$idTipoVehiculo,$idMarca,$idModelo,
                               $idAnio,$idColor,$idPlacas,$idFactura, $idKms,$idAgencia,$idMotor, $idChasis,$idVehiculo,
                               $idRepuve, $idGasolina,$idTarjeta, $idAseguradora,$idPoliza,$idFechaVencAuto,$idTipoPoliza,
                               $totalAvaluoLetra, $observacionesAuto,$idCheckTarjeta,$idCheckFactura,$idCheckINE,$idCheckImportacion,
                               $idCheckTenecia,$idCheckPoliza,$idCheckLicencia){
        // TODO: Implement guardaCiente() method.
        try {

            $fechaCreacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];


            $insertaContrato = "INSERT INTO auto_bazar_tbl " .
                "(id_Contrato, compra_mig,prestamo,avaluo,
                vitrina,vitrina_venta,id_serie,tipo_Vehiculo,
                 marca,modelo,anio,color,placas,factura,
                 kilometraje,agencia,num_motor,serie_chasis,vin,
                 repuve,gasolina,tarjeta_circulacion,aseguradora,poliza
                 fechaVencimiento,tipoPoliza,observaciones,
                 chkTarjeta,chkFactura,chkINE,chkImportacion,chkTenencias,
                 chkPoliza,chkLicencia,id_cierreCaja,sucursal) VALUES 
                  ($idContratoMig,$idFolioMig,$idPrestamoMig,$idAvaluoMig,
                  $idVitrinaMig,$idVitrinaMig,id_serie,$idTipoVehiculo,
                  $idMarca,$idModelo,$idAnio,$idColor,$idPlacas,$idFactura, 
                  $idKms,$idAgencia,$idMotor, $idChasis,$idVehiculo,
                  $idRepuve, $idGasolina,$idTarjeta, $idAseguradora,$idPoliza,
                  $idFechaVencAuto,$idTipoPoliza,$observacionesAuto,
                  $idCheckTarjeta,$idCheckFactura,$idCheckINE,$idCheckImportacion,$idCheckTenecia,
                  $idCheckPoliza,$idCheckLicencia,$idCierreCaja,$sucursal)";
            if ($ps = $this->conexion->prepare($insertaContrato)) {
                if ($ps->execute()) {
                    if (mysqli_stmt_affected_rows($ps) == 1) {
                        $buscar = "select max(id_Contrato) as idContrato  from contratos_tbl ";
                        $statement = $this->conexion->query($buscar);
                        $fila = $statement->fetch_object();
                        $fechaModificacion = date('Y-m-d H:i:s');
                        $idContratoAuto = $fila->idContrato;
                        $idTipoVehiculo = $auto->getidTipoVehiculo();
                        $idMarca = $auto->getidMarca();
                        $idModelo = $auto->getidModelo();
                        $idAnio = $auto->getidAnio();
                        $idColor = $auto->getidColor();
                        $idPlacas = $auto->getidPlacas();
                        $idFactura = $auto->getidFactura();
                        $idKms = $auto->getidKms();
                        $idAgencia = $auto->getidAgencia();
                        $idMotor = $auto->getidMotor();
                        $idSerie = $auto->getidSerie();
                        $idVehiculo = $auto->getidVehiculo();
                        $idRepuve = $auto->getidRepuve();
                        $idGasolina = $auto->getidGasolina();
                        $idAseguradora = $auto->getidAseguradora();
                        $idTarjeta = $auto->getidTarjeta();
                        $idPoliza = $auto->getidPoliza();
                        $idFecVencimientoAuto = $auto->getidFecVencimientoAuto();
                        $idTipoPoliza = $auto->getidTipoPoliza();
                        $idObservacionesAuto = $auto->getidObservacionesAuto();
                        $idCheckTarjeta = $auto->getidCheckTarjeta();
                        $idCheckFactura = $auto->getidCheckFactura();
                        $idCheckINE = $auto->getidCheckINE();
                        $idCheckImportacion = $auto->getidCheckImportacion();
                        $idCheckTenecia = $auto->getidCheckTenecia();
                        $idCheckPoliza = $auto->getidCheckPoliza();
                        $idCheckLicencia = $auto->getidCheckLicencia();
                        $estatus = 1;
                        $idColor = mb_strtoupper($idColor, 'UTF-8');
                        $idMarca = mb_strtoupper($idMarca, 'UTF-8');
                        $idModelo = mb_strtoupper($idModelo, 'UTF-8');
                        $idPlacas = mb_strtoupper($idPlacas, 'UTF-8');
                        $idAgencia = mb_strtoupper($idAgencia, 'UTF-8');
                        $idMotor = mb_strtoupper($idMotor, 'UTF-8');
                        $idSerie = mb_strtoupper($idSerie, 'UTF-8');
                        $idVehiculo = mb_strtoupper($idVehiculo, 'UTF-8');
                        $idRepuve = mb_strtoupper($idRepuve, 'UTF-8');
                        $idTarjeta = mb_strtoupper($idTarjeta, 'UTF-8');
                        $idPoliza = mb_strtoupper($idPoliza, 'UTF-8');
                        $idTipoPoliza = mb_strtoupper($idTipoPoliza, 'UTF-8');
                        $idObservacionesAuto = mb_strtoupper($idObservacionesAuto, 'UTF-8');

                        $insertaAuto = "INSERT INTO auto_tbl(id_Contrato, tipo_Vehiculo,marca, modelo, anio, color, placas, factura," .
                            " kilometraje, agencia, num_motor, serie_chasis, vin, repuve, gasolina, tarjeta_circulacion, aseguradora, poliza, fechaVencimiento," .
                            " tipoPoliza, observaciones, chkTarjeta, chkFactura, chkINE, chkImportacion, chkTenencias, chkPoliza, chkLicencia, fecha_creacion, fecha_modificacion, id_cierreCaja,id_Estatus)" .
                            " VALUES ('" . $idContratoAuto . "', '" . $idTipoVehiculo . "', '" . $idMarca . "', '" . $idModelo . "'," .
                            " '" . $idAnio . "', '" . $idColor . "', '" . $idPlacas . "', '" . $idFactura . "', '" . $idKms . "','" . $idAgencia . "','" . $idMotor . "'," .
                            " '" . $idSerie . "', '" . $idVehiculo . "', '" . $idRepuve . "', '" . $idGasolina . "', '" . $idTarjeta . "','" . $idAseguradora . "','" . $idPoliza . "'," .
                            " '" . $idFecVencimientoAuto . "', '" . $idTipoPoliza . "', '" . $idObservacionesAuto . "', '" . $idCheckTarjeta . "', '" . $idCheckFactura . "','" . $idCheckINE . "'," .
                            " '" . $idCheckImportacion . "', '" . $idCheckTenecia . "', '" . $idCheckPoliza . "', '" . $idCheckLicencia . "', '" . $fechaCreacion . "','" . $fechaModificacion . "','" . $idCierreCaja . "','" . $estatus . "')";

                        if ($ps = $this->conexion->prepare($insertaAuto)) {
                            if ($ps->execute()) {
                                $verdad =  $idContratoAuto;
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