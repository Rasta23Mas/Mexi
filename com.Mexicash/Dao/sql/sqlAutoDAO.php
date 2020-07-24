<?php
if(!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Auto.php");
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlAutoDAO
{
    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    public function generaContratoAuto($auto)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $id_Cliente = $auto->getIdClienteAuto();
            $totalPrestamo = $auto->getTotalPrestamo();
            $totalAvaluo = $auto->getTotalAvaluo();
            $totalInteres = $auto->getTotalInteres();
            $sumaInteresPrestamo = $auto->getSumaInteresPrestamo();
            $diasAlm = $auto->getDiasAlmoneda();
            $cotitular = $auto->getCotitular();
            $beneficiario = $auto->getBeneficiario();
            $plazo = $auto->getPlazo();
            $periodo = $auto->getPeriodo();
            $tipoInteres = $auto->getIdTipoInteres();
            $tasa = $auto->getTasa();
            $alm = $auto->getAlm();
            $seguro = $auto->getSeguro();
            $iva = $auto->getIva();
            $dias = $auto->getDias();
            $polizaInteres = $auto->getPolizaSeguroCost();
            $gps = $auto->getGps();
            $pension = $auto->getPension();
            $tipoFormulario = $auto->getIdTipoFormulario();
            $aforo = $auto->getAforo();
            $fechaCreacion = date('Y-m-d H:i:s');
            $fechaVencimiento = $auto->getFechaVencimiento();
            $fechaAlm = $auto->getFechaAlm();
            $idCierreCaja = $_SESSION['idCierreCaja'];

            $usuario = $_SESSION["idUsuario"];
            $sucursal = $_SESSION["sucursal"];
            $insertaContrato = "INSERT INTO contrato_tbl " .
                "(id_Cliente, total_Prestamo,total_Avaluo, total_Interes, suma_InteresPrestamo,diasAlm,cotitular, beneficiario, 
                  plazo,periodo,tipoInteres,tasa, alm, seguro,iva,dias,PolizaSeguro, GPS, Pension,id_Formulario,Aforo, fecha_creacion,
                  fecha_vencimiento,fecha_almoneda, tipoContrato,id_cierreCaja) VALUES (
                  $id_Cliente,$totalPrestamo,$totalAvaluo,$totalInteres,$sumaInteresPrestamo,$diasAlm,'$cotitular','$beneficiario',
                  $plazo,'$periodo','$tipoInteres',$tasa,$alm,$seguro,$iva,$dias,$polizaInteres,$gps,$pension,$tipoFormulario,$aforo,'$fechaCreacion'
                  '$fechaVencimiento','$fechaAlm',2,$idCierreCaja)";
            echo $insertaContrato;
            if ($ps = $this->conexion->prepare($insertaContrato)) {
                if ($ps->execute()) {
                    if (mysqli_stmt_affected_rows($ps) == 1) {
                        $buscar = "select max(id_Contrato) as idContrato  from contrato_tbl ";
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

                        $insertaAuto = "INSERT INTO auto_tbl(id_Contrato, tipo_Vehiculo,marca, modelo, año, color, placas, factura," .
                            " kilometraje, agencia, num_motor, serie_chasis, vin, repuve, gasolina, tarjeta_circulacion, aseguradora, poliza, fechaVencimiento," .
                            " tipoPoliza, observaciones, chkTarjeta, chkFactura, chkINE, chkImportacion, chkTenencias, chkPoliza, chkLicencia, fecha_creacion, fecha_modificacion, usuario,sucursal,id_Estatus)" .
                            " VALUES ('" . $idContratoAuto . "', '" . $idTipoVehiculo . "', '" . $idMarca . "', '" . $idModelo . "'," .
                            " '" . $idAnio . "', '" . $idColor . "', '" . $idPlacas . "', '" . $idFactura . "', '" . $idKms . "','" . $idAgencia . "','" . $idMotor . "'," .
                            " '" . $idSerie . "', '" . $idVehiculo . "', '" . $idRepuve . "', '" . $idGasolina . "', '" . $idTarjeta . "','" . $idAseguradora . "','" . $idPoliza . "'," .
                            " '" . $idFecVencimientoAuto . "', '" . $idTipoPoliza . "', '" . $idObservacionesAuto . "', '" . $idCheckTarjeta . "', '" . $idCheckFactura . "','" . $idCheckINE . "'," .
                            " '" . $idCheckImportacion . "', '" . $idCheckTenecia . "', '" . $idCheckPoliza . "', '" . $idCheckLicencia . "', '" . $fechaCreacion . "','" . $fechaModificacion . "','" . $usuario . "','" . $sucursal . "','" . $estatus . "')";
                        echo $insertaAuto;
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
        //return $verdad;
        echo $verdad;

    }
}