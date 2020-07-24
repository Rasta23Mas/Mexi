<?php


class Contrato
{
    private $idCliente;
    private $totalPrestamo;
    private $totalAvaluo;
    private $Total_Intereses;
    private $Suma_InteresPrestamo;
    private $diasAlmonedaValue;
    private $cotitular;
    private $beneficiario;
    private $plazo;
    private $periodo;
    private $tipoInteres;
    private $tasa;
    private $alm;
    private $seguro;
    private $iva;
    private $dias;
    private $idTipoFormulario;
    private $aforo;
    private $fecha_vencimiento;
    private $fecha_almoneda;

    /**
     * Contrato constructor.
     * @param $idCliente
     * @param $totalPrestamo
     * @param $totalAvaluo
     * @param $Total_Intereses
     * @param $Suma_InteresPrestamo
     * @param $diasAlmonedaValue
     * @param $cotitular
     * @param $beneficiario
     * @param $plazo
     * @param $periodo
     * @param $tipoInteres
     * @param $tasa
     * @param $alm
     * @param $seguro
     * @param $iva
     * @param $dias
     * @param $idTipoFormulario
     * @param $aforo
     * @param $fecha_vencimiento
     * @param $fecha_almoneda
     */
    public function __construct($idCliente, $totalPrestamo, $totalAvaluo, $Total_Intereses, $Suma_InteresPrestamo, $diasAlmonedaValue, $cotitular,
                                $beneficiario, $plazo, $periodo, $tipoInteres, $tasa, $alm, $seguro, $iva, $dias, $idTipoFormulario, $aforo,
                                $fecha_vencimiento, $fecha_almoneda)
    {
        $this->idCliente = $idCliente;
        $this->totalPrestamo = $totalPrestamo;
        $this->totalAvaluo = $totalAvaluo;
        $this->Total_Intereses = $Total_Intereses;
        $this->Suma_InteresPrestamo = $Suma_InteresPrestamo;
        $this->diasAlmonedaValue = $diasAlmonedaValue;
        $this->cotitular = $cotitular;
        $this->beneficiario = $beneficiario;
        $this->plazo = $plazo;
        $this->periodo = $periodo;
        $this->tipoInteres = $tipoInteres;
        $this->tasa = $tasa;
        $this->alm = $alm;
        $this->seguro = $seguro;
        $this->iva = $iva;
        $this->dias = $dias;
        $this->idTipoFormulario = $idTipoFormulario;
        $this->aforo = $aforo;
        $this->fecha_vencimiento = $fecha_vencimiento;
        $this->fecha_almoneda = $fecha_almoneda;
    }

    /**
     * @return mixed
     */
    public function getIdCliente()
    {
        return $this->idCliente;
    }

    /**
     * @param mixed $idCliente
     */
    public function setIdCliente($idCliente): void
    {
        $this->idCliente = $idCliente;
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
    public function getTotalIntereses()
    {
        return $this->Total_Intereses;
    }

    /**
     * @param mixed $Total_Intereses
     */
    public function setTotalIntereses($Total_Intereses): void
    {
        $this->Total_Intereses = $Total_Intereses;
    }

    /**
     * @return mixed
     */
    public function getSumaInteresPrestamo()
    {
        return $this->Suma_InteresPrestamo;
    }

    /**
     * @param mixed $Suma_InteresPrestamo
     */
    public function setSumaInteresPrestamo($Suma_InteresPrestamo): void
    {
        $this->Suma_InteresPrestamo = $Suma_InteresPrestamo;
    }

    /**
     * @return mixed
     */
    public function getDiasAlmonedaValue()
    {
        return $this->diasAlmonedaValue;
    }

    /**
     * @param mixed $diasAlmonedaValue
     */
    public function setDiasAlmonedaValue($diasAlmonedaValue): void
    {
        $this->diasAlmonedaValue = $diasAlmonedaValue;
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
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * @param mixed $periodo
     */
    public function setPeriodo($periodo): void
    {
        $this->periodo = $periodo;
    }

    /**
     * @return mixed
     */
    public function getTipoInteres()
    {
        return $this->tipoInteres;
    }

    /**
     * @param mixed $tipoInteres
     */
    public function setTipoInteres($tipoInteres): void
    {
        $this->tipoInteres = $tipoInteres;
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
    public function getIdTipoFormulario()
    {
        return $this->idTipoFormulario;
    }

    /**
     * @param mixed $idTipoFormulario
     */
    public function setIdTipoFormulario($idTipoFormulario): void
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
    public function getFechaVencimiento()
    {
        return $this->fecha_vencimiento;
    }

    /**
     * @param mixed $fecha_vencimiento
     */
    public function setFechaVencimiento($fecha_vencimiento): void
    {
        $this->fecha_vencimiento = $fecha_vencimiento;
    }

    /**
     * @return mixed
     */
    public function getFechaAlmoneda()
    {
        return $this->fecha_almoneda;
    }

    /**
     * @param mixed $fecha_almoneda
     */
    public function setFechaAlmoneda($fecha_almoneda): void
    {
        $this->fecha_almoneda = $fecha_almoneda;
    }



}