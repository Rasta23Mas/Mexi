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
                               $observacionesAuto,$idCheckTarjeta,$idCheckFactura,$idCheckINE,$idCheckImportacion,
                               $idCheckTenecia,$idCheckPoliza,$idCheckLicencia,$idContratoMigSerie, $descripcionCorta){
        // TODO: Implement guardaCiente() method.
        try {

            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];
            $sucursalSerie = "0" . $_SESSION["sucursal"];
            $adquisicion = "03";
            $serie= $sucursalSerie . $adquisicion . $idContratoMigSerie . "01";
            $idMarca = mb_strtoupper($idMarca, 'UTF-8');
            $idModelo = mb_strtoupper($idModelo, 'UTF-8');
            $idColor = mb_strtoupper($idColor, 'UTF-8');
            $idPlacas = mb_strtoupper($idPlacas, 'UTF-8');
            $idAgencia = mb_strtoupper($idAgencia, 'UTF-8');
            $idMotor = mb_strtoupper($idMotor, 'UTF-8');
            $idChasis = mb_strtoupper($idChasis, 'UTF-8');
            $observacionesAuto = mb_strtoupper($observacionesAuto, 'UTF-8');
            $descripcionCorta = mb_strtoupper($descripcionCorta, 'UTF-8');

            $verdad = 0;
            $insertaContrato = "INSERT INTO auto_bazar_tbl " .
                "(id_Contrato, codigo_mig,prestamo,avaluo,
                vitrina,vitrina_venta,id_serie,tipo_Vehiculo,
                 marca,modelo,anio,color,placas,factura,
                 kilometraje,agencia,num_motor,serie_chasis,vin,
                 repuve,gasolina,tarjeta_circulacion,aseguradora,poliza,
                 fechaVencimiento,tipoPoliza,observaciones,descripcionCorta,
                 chkTarjeta,chkFactura,chkINE,chkImportacion,chkTenencias,
                 chkPoliza,chkLicencia,id_cierreCaja,sucursal) VALUES 
                  ($idContratoMig,'$idFolioMig',$idPrestamoMig,$idAvaluoMig,
                  $idVitrinaMig,$idVitrinaMig,'$serie',$idTipoVehiculo,
                  '$idMarca','$idModelo',$idAnio,'$idColor','$idPlacas',$idFactura, 
                  $idKms,'$idAgencia','$idMotor', '$idChasis','$idVehiculo',
                  '$idRepuve', $idGasolina,'$idTarjeta', '$idAseguradora',$idPoliza,
                  '$idFechaVencAuto','$idTipoPoliza','$observacionesAuto','$descripcionCorta',
                  $idCheckTarjeta,$idCheckFactura,$idCheckINE,$idCheckImportacion,$idCheckTenecia,
                  $idCheckPoliza,$idCheckLicencia,$idCierreCaja,$sucursal)";
            if ($ps = $this->conexion->prepare($insertaContrato)) {
                if ($ps->execute()) {
                    $verdad = 1;
                } else {
                    $verdad = 2;
                }
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