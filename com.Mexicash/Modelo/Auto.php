<?php


class Auto
{
    //Contrato
    private $idClienteAuto;
    private $fechaVencimiento;
    private $totalAvaluo;
    private $totalPrestamo;
    private $total_Interes;
    private $sumaInteresPrestamo;
    private $polizaSeguroCost;
    private $gps;
    private $pension;
    private $estatus;
    private $beneficiario;
    private $cotitular;
    private $plazo;
    private $tasa;
    private $alm;
    private $seguro;
    private $iva;
    private $dias;
    private $idTipoFormulario;
    private $aforo;
    //Auto
    private $idTipoVehiculo;
    private $idMarca;
    private $idModelo;
    private $idAnio;
    private $idColor;
    private $idPlacas;
    private $idFactura;
    private $idKms;
    private $idAgencia;
    private $idMotor;
    private $idSerie;
    private $idVehiculo;
    private $idRepuve;
    private $idGasolina;
    private $idAseguradora;
    private $idTarjeta;
    private $idPoliza;
    private $idFecVencimientoAuto;
    private $idTipoPoliza;
    private $idObservacionesAuto;
    private $idCheckTarjeta;
    private $idCheckFactura;
    private $idCheckINE;
    private $idCheckImportacion;
    private $idCheckTenecia;
    private $idCheckPoliza;
    private $idCheckLicencia;
    private $diasAlmoneda;
    private $fecha_Alm;

    /**
     * Auto constructor.
     * @param $idClienteAuto
     * @param $fechaVencimiento
     * @param $totalAvaluo
     * @param $totalPrestamo
     * @param $total_Interes
     * @param $sumaInteresPrestamo
     * @param $polizaSeguroCost
     * @param $gps
     * @param $pension
     * @param $estatus
     * @param $beneficiario
     * @param $cotitular
     * @param $plazo
     * @param $tasa
     * @param $alm
     * @param $seguro
     * @param $iva
     * @param $dias
     * @param $idTipoFormulario
     * @param $aforo
     * @param $idTipoVehiculo
     * @param $idMarca
     * @param $idModelo
     * @param $idAnio
     * @param $idColor
     * @param $idPlacas
     * @param $idFactura
     * @param $idKms
     * @param $idAgencia
     * @param $idMotor
     * @param $idSerie
     * @param $idVehiculo
     * @param $idRepuve
     * @param $idGasolina
     * @param $idAseguradora
     * @param $idTarjeta
     * @param $idPoliza
     * @param $idFecVencimientoAuto
     * @param $idTipoPoliza
     * @param $idObservacionesAuto
     * @param $idCheckTarjeta
     * @param $idCheckFactura
     * @param $idCheckINE
     * @param $idCheckImportacion
     * @param $idCheckTenecia
     * @param $idCheckPoliza
     * @param $idCheckLicencia
     * @param $diasAlmoned
     * @param $fecha_Alm
     */
    public function __construct($idClienteAuto, $fechaVencimiento, $totalAvaluo, $totalPrestamo, $total_Interes,
                                $sumaInteresPrestamo, $polizaSeguroCost, $gps, $pension, $estatus,
                                $beneficiario, $cotitular, $plazo, $tasa, $alm, $seguro, $iva, $dias,$idTipoFormulario,$aforo, $idTipoVehiculo,
                                $idMarca, $idModelo, $idAnio, $idColor, $idPlacas, $idFactura, $idKms, $idAgencia,
                                $idMotor, $idSerie, $idVehiculo, $idRepuve, $idGasolina, $idAseguradora, $idTarjeta,
                                $idPoliza, $idFecVencimientoAuto, $idTipoPoliza, $idObservacionesAuto, $idCheckTarjeta,
                                $idCheckFactura, $idCheckINE, $idCheckImportacion, $idCheckTenecia, $idCheckPoliza,
                                $idCheckLicencia,$diasAlmoneda,$fecha_Alm)
    {
        $this->idClienteAuto = $idClienteAuto;
        $this->fechaVencimiento = $fechaVencimiento;
        $this->totalAvaluo = $totalAvaluo;
        $this->totalPrestamo = $totalPrestamo;
        $this->total_Interes = $total_Interes;
        $this->sumaInteresPrestamo = $sumaInteresPrestamo;
        $this->polizaSeguroCost = $polizaSeguroCost;
        $this->gps = $gps;
        $this->pension = $pension;
        $this->estatus = $estatus;
        $this->beneficiario = $beneficiario;
        $this->cotitular = $cotitular;
        $this->plazo = $plazo;
        $this->tasa = $tasa;
        $this->alm = $alm;
        $this->seguro = $seguro;
        $this->iva = $iva;
        $this->dias = $dias;
        $this->idTipoFormulario = $idTipoFormulario;
        $this->aforo = $aforo;
        $this->idTipoVehiculo = $idTipoVehiculo;
        $this->idMarca = $idMarca;
        $this->idModelo = $idModelo;
        $this->idAnio = $idAnio;
        $this->idColor = $idColor;
        $this->idPlacas = $idPlacas;
        $this->idFactura = $idFactura;
        $this->idKms = $idKms;
        $this->idAgencia = $idAgencia;
        $this->idMotor = $idMotor;
        $this->idSerie = $idSerie;
        $this->idVehiculo = $idVehiculo;
        $this->idRepuve = $idRepuve;
        $this->idGasolina = $idGasolina;
        $this->idAseguradora = $idAseguradora;
        $this->idTarjeta = $idTarjeta;
        $this->idPoliza = $idPoliza;
        $this->idFecVencimientoAuto = $idFecVencimientoAuto;
        $this->idTipoPoliza = $idTipoPoliza;
        $this->idObservacionesAuto = $idObservacionesAuto;
        $this->idCheckTarjeta = $idCheckTarjeta;
        $this->idCheckFactura = $idCheckFactura;
        $this->idCheckINE = $idCheckINE;
        $this->idCheckImportacion = $idCheckImportacion;
        $this->idCheckTenecia = $idCheckTenecia;
        $this->idCheckPoliza = $idCheckPoliza;
        $this->idCheckLicencia = $idCheckLicencia;
        $this->diasAlmoneda = $diasAlmoneda;
        $this->fecha_Alm = $fecha_Alm;
    }


    /**
     * @return mixed
     */
    public function getTipoFormulario()
    {
        return $this->idTipoFormulario;
    }

    /**
     * @param mixed $idTipoFormulario
     */
    public function setTipoFormulario($idTipoFormulario): void
    {
        $this->idTipoFormulario = $idTipoFormulario;
    }

    /**
     * @return mixed
     */
    public function getAforo()
    {
        return $this->aforo;
    }

    /**
     * @param mixed $aforo
     */
    public function setAforo($aforo): void
    {
        $this->aforo = $aforo;
    }

    /**
     * @return mixed
     */
    public function getDiasAlmoneda()
    {
        return $this->diasAlmoneda;
    }

    /**
     * @param mixed $diasAlmoned
     */
    public function setDiasAlmoneda($diasAlmoneda): void
    {
        $this->diasAlmoneda = $diasAlmoneda;
    }



    /**
     * @return mixed
     */
    public function getIdClienteAuto()
    {
        return $this->idClienteAuto;
    }

    /**
     * @param mixed $idClienteAuto
     */
    public function setIdClienteAuto($idClienteAuto): void
    {
        $this->idClienteAuto = $idClienteAuto;
    }

    /**
     * @return mixed
     */
    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }

    /**
     * @param mixed $fechaVencimiento
     */
    public function setFechaVencimiento($fechaVencimiento): void
    {
        $this->fechaVencimiento = $fechaVencimiento;
    }

    /**
     * @return mixed
     */
    public function getTotalAvaluo()
    {
        return $this->totalAvaluo;
    }

    /**
     * @param mixed $totalAvaluo
     */
    public function setTotalAvaluo($totalAvaluo): void
    {
        $this->totalAvaluo = $totalAvaluo;
    }

    /**
     * @return mixed
     */
    public function getTotalPrestamo()
    {
        return $this->totalPrestamo;
    }

    /**
     * @param mixed $totalPrestamo
     */
    public function setTotalPrestamo($totalPrestamo): void
    {
        $this->totalPrestamo = $totalPrestamo;
    }

    /**
     * @return mixed
     */
    public function getTotalInteres()
    {
        return $this->total_Interes;
    }

    /**
     * @param mixed $total_Interes
     */
    public function setTotalInteres($total_Interes): void
    {
        $this->total_Interes = $total_Interes;
    }

    /**
     * @return mixed
     */
    public function getSumaInteresPrestamo()
    {
        return $this->sumaInteresPrestamo;
    }

    /**
     * @param mixed $sumaInteresPrestamo
     */
    public function setSumaInteresPrestamo($sumaInteresPrestamo): void
    {
        $this->sumaInteresPrestamo = $sumaInteresPrestamo;
    }

    /**
     * @return mixed
     */
    public function getPolizaSeguroCost()
    {
        return $this->polizaSeguroCost;
    }

    /**
     * @param mixed $polizaSeguroCost
     */
    public function setPolizaSeguroCost($polizaSeguroCost): void
    {
        $this->polizaSeguroCost = $polizaSeguroCost;
    }

    /**
     * @return mixed
     */
    public function getGps()
    {
        return $this->gps;
    }

    /**
     * @param mixed $gps
     */
    public function setGps($gps): void
    {
        $this->gps = $gps;
    }

    /**
     * @return mixed
     */
    public function getPension()
    {
        return $this->pension;
    }

    /**
     * @param mixed $pension
     */
    public function setPension($pension): void
    {
        $this->pension = $pension;
    }
    /**
     * @return mixed
     */
    public function getFechaAlm()
    {
        return $this->fecha_Alm;
    }

    /**
     * @param mixed $fecha_Alm
     */
    public function setFechaAlm($fecha_Alm): void
    {
        $this->fecha_Alm = $fecha_Alm;
    }

    /**
     * @return mixed
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * @param mixed $estatus
     */
    public function setEstatus($estatus): void
    {
        $this->estatus = $estatus;
    }

    /**
     * @return mixed
     */
    public function getBeneficiario()
    {
        return $this->beneficiario;
    }

    /**
     * @param mixed $beneficiario
     */
    public function setBeneficiario($beneficiario): void
    {
        $this->beneficiario = $beneficiario;
    }

    /**
     * @return mixed
     */
    public function getCotitular()
    {
        return $this->cotitular;
    }

    /**
     * @param mixed $cotitular
     */
    public function setCotitular($cotitular): void
    {
        $this->cotitular = $cotitular;
    }

    /**
     * @return mixed
     */
    public function getPlazo()
    {
        return $this->plazo;
    }

    /**
     * @param mixed $plazo
     */
    public function setPlazo($plazo): void
    {
        $this->plazo = $plazo;
    }

    /**
     * @return mixed
     */
    public function getTasa()
    {
        return $this->tasa;
    }

    /**
     * @param mixed $tasa
     */
    public function setTasa($tasa): void
    {
        $this->tasa = $tasa;
    }

    /**
     * @return mixed
     */
    public function getAlm()
    {
        return $this->alm;
    }

    /**
     * @param mixed $alm
     */
    public function setAlm($alm): void
    {
        $this->alm = $alm;
    }

    /**
     * @return mixed
     */
    public function getSeguro()
    {
        return $this->seguro;
    }

    /**
     * @param mixed $seguro
     */
    public function setSeguro($seguro): void
    {
        $this->seguro = $seguro;
    }

    /**
     * @return mixed
     */
    public function getIva()
    {
        return $this->iva;
    }

    /**
     * @param mixed $iva
     */
    public function setIva($iva): void
    {
        $this->iva = $iva;
    }

    /**
     * @return mixed
     */
    public function getDias()
    {
        return $this->dias;
    }

    /**
     * @param mixed $dias
     */
    public function setDias($dias): void
    {
        $this->dias = $dias;
    }

    /**
     * @return mixed
     */
    public function getIdTipoVehiculo()
    {
        return $this->idTipoVehiculo;
    }

    /**
     * @param mixed $idTipoVehiculo
     */
    public function setIdTipoVehiculo($idTipoVehiculo): void
    {
        $this->idTipoVehiculo = $idTipoVehiculo;
    }

    /**
     * @return mixed
     */
    public function getIdMarca()
    {
        return $this->idMarca;
    }

    /**
     * @param mixed $idMarca
     */
    public function setIdMarca($idMarca): void
    {
        $this->idMarca = $idMarca;
    }

    /**
     * @return mixed
     */
    public function getIdModelo()
    {
        return $this->idModelo;
    }

    /**
     * @param mixed $idModelo
     */
    public function setIdModelo($idModelo): void
    {
        $this->idModelo = $idModelo;
    }

    /**
     * @return mixed
     */
    public function getIdAnio()
    {
        return $this->idAnio;
    }

    /**
     * @param mixed $idAnio
     */
    public function setIdAnio($idAnio): void
    {
        $this->idAnio = $idAnio;
    }

    /**
     * @return mixed
     */
    public function getIdColor()
    {
        return $this->idColor;
    }

    /**
     * @param mixed $idColor
     */
    public function setIdColor($idColor): void
    {
        $this->idColor = $idColor;
    }

    /**
     * @return mixed
     */
    public function getIdPlacas()
    {
        return $this->idPlacas;
    }

    /**
     * @param mixed $idPlacas
     */
    public function setIdPlacas($idPlacas): void
    {
        $this->idPlacas = $idPlacas;
    }

    /**
     * @return mixed
     */
    public function getIdFactura()
    {
        return $this->idFactura;
    }

    /**
     * @param mixed $idFactura
     */
    public function setIdFactura($idFactura): void
    {
        $this->idFactura = $idFactura;
    }

    /**
     * @return mixed
     */
    public function getIdKms()
    {
        return $this->idKms;
    }

    /**
     * @param mixed $idKms
     */
    public function setIdKms($idKms): void
    {
        $this->idKms = $idKms;
    }

    /**
     * @return mixed
     */
    public function getIdAgencia()
    {
        return $this->idAgencia;
    }

    /**
     * @param mixed $idAgencia
     */
    public function setIdAgencia($idAgencia): void
    {
        $this->idAgencia = $idAgencia;
    }

    /**
     * @return mixed
     */
    public function getIdMotor()
    {
        return $this->idMotor;
    }

    /**
     * @param mixed $idMotor
     */
    public function setIdMotor($idMotor): void
    {
        $this->idMotor = $idMotor;
    }

    /**
     * @return mixed
     */
    public function getIdSerie()
    {
        return $this->idSerie;
    }

    /**
     * @param mixed $idSerie
     */
    public function setIdSerie($idSerie): void
    {
        $this->idSerie = $idSerie;
    }

    /**
     * @return mixed
     */
    public function getIdVehiculo()
    {
        return $this->idVehiculo;
    }

    /**
     * @param mixed $idVehiculo
     */
    public function setIdVehiculo($idVehiculo): void
    {
        $this->idVehiculo = $idVehiculo;
    }

    /**
     * @return mixed
     */
    public function getIdRepuve()
    {
        return $this->idRepuve;
    }

    /**
     * @param mixed $idRepuve
     */
    public function setIdRepuve($idRepuve): void
    {
        $this->idRepuve = $idRepuve;
    }

    /**
     * @return mixed
     */
    public function getIdGasolina()
    {
        return $this->idGasolina;
    }

    /**
     * @param mixed $idGasolina
     */
    public function setIdGasolina($idGasolina): void
    {
        $this->idGasolina = $idGasolina;
    }

    /**
     * @return mixed
     */
    public function getIdAseguradora()
    {
        return $this->idAseguradora;
    }

    /**
     * @param mixed $idAseguradora
     */
    public function setIdAseguradora($idAseguradora): void
    {
        $this->idAseguradora = $idAseguradora;
    }

    /**
     * @return mixed
     */
    public function getIdTarjeta()
    {
        return $this->idTarjeta;
    }

    /**
     * @param mixed $idTarjeta
     */
    public function setIdTarjeta($idTarjeta): void
    {
        $this->idTarjeta = $idTarjeta;
    }

    /**
     * @return mixed
     */
    public function getIdPoliza()
    {
        return $this->idPoliza;
    }

    /**
     * @param mixed $idPoliza
     */
    public function setIdPoliza($idPoliza): void
    {
        $this->idPoliza = $idPoliza;
    }

    /**
     * @return mixed
     */
    public function getIdFecVencimientoAuto()
    {
        return $this->idFecVencimientoAuto;
    }

    /**
     * @param mixed $idFecVencimientoAuto
     */
    public function setIdFecVencimientoAuto($idFecVencimientoAuto): void
    {
        $this->idFecVencimientoAuto = $idFecVencimientoAuto;
    }

    /**
     * @return mixed
     */
    public function getIdTipoPoliza()
    {
        return $this->idTipoPoliza;
    }

    /**
     * @param mixed $idTipoPoliza
     */
    public function setIdTipoPoliza($idTipoPoliza): void
    {
        $this->idTipoPoliza = $idTipoPoliza;
    }

    /**
     * @return mixed
     */
    public function getIdObservacionesAuto()
    {
        return $this->idObservacionesAuto;
    }

    /**
     * @param mixed $idObservacionesAuto
     */
    public function setIdObservacionesAuto($idObservacionesAuto): void
    {
        $this->idObservacionesAuto = $idObservacionesAuto;
    }

    /**
     * @return mixed
     */
    public function getIdCheckTarjeta()
    {
        return $this->idCheckTarjeta;
    }

    /**
     * @param mixed $idCheckTarjeta
     */
    public function setIdCheckTarjeta($idCheckTarjeta): void
    {
        $this->idCheckTarjeta = $idCheckTarjeta;
    }

    /**
     * @return mixed
     */
    public function getIdCheckFactura()
    {
        return $this->idCheckFactura;
    }

    /**
     * @param mixed $idCheckFactura
     */
    public function setIdCheckFactura($idCheckFactura): void
    {
        $this->idCheckFactura = $idCheckFactura;
    }

    /**
     * @return mixed
     */
    public function getIdCheckINE()
    {
        return $this->idCheckINE;
    }

    /**
     * @param mixed $idCheckINE
     */
    public function setIdCheckINE($idCheckINE): void
    {
        $this->idCheckINE = $idCheckINE;
    }

    /**
     * @return mixed
     */
    public function getIdCheckImportacion()
    {
        return $this->idCheckImportacion;
    }

    /**
     * @param mixed $idCheckImportacion
     */
    public function setIdCheckImportacion($idCheckImportacion): void
    {
        $this->idCheckImportacion = $idCheckImportacion;
    }

    /**
     * @return mixed
     */
    public function getIdCheckTenecia()
    {
        return $this->idCheckTenecia;
    }

    /**
     * @param mixed $idCheckTenecia
     */
    public function setIdCheckTenecia($idCheckTenecia): void
    {
        $this->idCheckTenecia = $idCheckTenecia;
    }

    /**
     * @return mixed
     */
    public function getIdCheckPoliza()
    {
        return $this->idCheckPoliza;
    }

    /**
     * @param mixed $idCheckPoliza
     */
    public function setIdCheckPoliza($idCheckPoliza): void
    {
        $this->idCheckPoliza = $idCheckPoliza;
    }

    /**
     * @return mixed
     */
    public function getIdCheckLicencia()
    {
        return $this->idCheckLicencia;
    }

    /**
     * @param mixed $idCheckLicencia
     */
    public function setIdCheckLicencia($idCheckLicencia): void
    {
        $this->idCheckLicencia = $idCheckLicencia;
    }



}