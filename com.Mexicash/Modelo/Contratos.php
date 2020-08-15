<?php


class Contratos
{
    private $idCliente;
    private $totalPrestamo;
    private $totalAvaluo;
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
    private $suma_InteresPrestamo;
    private $total_Intereses;
    private $totalAvaluoLetra;

    /**
     * Contrato constructor.
     * @param $idCliente
     * @param $totalPrestamo
     * @param $totalAvaluo
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
     * @param $suma_InteresPrestamo
     * @param $total_Intereses
     * @param $totalAvaluoLetra
     */
    public function __construct($idCliente, $totalPrestamo, $totalAvaluo, $diasAlmonedaValue, $cotitular,
                                $beneficiario, $plazo, $periodo, $tipoInteres, $tasa, $alm, $seguro, $iva, $dias, $idTipoFormulario, $aforo,
                                $fecha_vencimiento, $fecha_almoneda,$suma_InteresPrestamo,$total_Intereses,$totalAvaluoLetra)
    {
        $this->idCliente = $idCliente;
        $this->totalPrestamo = $totalPrestamo;
        $this->totalAvaluo = $totalAvaluo;
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
        $this->suma_InteresPrestamo = $suma_InteresPrestamo;
        $this->total_Intereses = $total_Intereses;
        $this->totalAvaluoLetra = $totalAvaluoLetra;
    }

    /**
     * @return mixed
     */
    public function getTotalAvaluoLetra()
    {
        return $this->totalAvaluoLetra;
    }

    /**
     * @param mixed $totalAvaluoLetra
     */
    public function setTotalAvaluoLetra($totalAvaluoLetra): void
    {
        $this->totalAvaluoLetra = $totalAvaluoLetra;
    }

    /**
     * @return mixed
     */
    public function getSumaInteresPrestamo()
    {
        return $this->suma_InteresPrestamo;
    }

    /**
     * @param mixed $suma_InteresPrestamo
     */
    public function setSumaInteresPrestamo($suma_InteresPrestamo): void
    {
        $this->suma_InteresPrestamo = $suma_InteresPrestamo;
    }

    /**
     * @return mixed
     */
    public function getTotalIntereses()
    {
        return $this->total_Intereses;
    }

    /**
     * @param mixed $total_Intereses
     */
    public function setTotalIntereses($total_Intereses): void
    {
        $this->total_Intereses = $total_Intereses;
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