<?php


class Contrato
{
    private $idCliente;
    private $totalPrestamo;
    private $Total_Intereses;
    private $Suma_InteresPrestamo;
    private $diasAlmonedaValue;
    private $cotitular;
    private $beneficiario;
    private $plazo;
    private $tasa;
    private $alm;
    private $seguro;
    private $iva;
    private $dias;
    private $idTipoFormulario;
    private $aforo;

    /**
     * Contrato constructor.
     * @param $idCliente
     * @param $totalPrestamo
     * @param $Total_Intereses
     * @param $Suma_InteresPrestamo
     * @param $diasAlmonedaValue
     * @param $cotitular
     * @param $beneficiario
     * @param $plazo
     * @param $tasa
     * @param $alm
     * @param $seguro
     * @param $iva
     * @param $dias
     * @param $idTipoFormulario
     * @param $aforo
     */
    public function __construct($idCliente, $totalPrestamo,$Total_Intereses,$Suma_InteresPrestamo, $diasAlmonedaValue, $cotitular, $beneficiario, $plazo, $tasa, $alm,
                                $seguro, $iva, $dias,$idTipoFormulario,$aforo)
    {
        $this->idCliente = $idCliente;
        $this->totalPrestamo = $totalPrestamo;
        $this->totalIntereses = $Total_Intereses;
        $this->sumaInteresPrestamo = $Suma_InteresPrestamo;
        $this->diasAlmonedaValue = $diasAlmonedaValue;
        $this->cotitular = $cotitular;
        $this->beneficiario = $beneficiario;
        $this->plazo = $plazo;
        $this->tasa = $tasa;
        $this->alm = $alm;
        $this->seguro = $seguro;
        $this->iva = $iva;
        $this->dias = $dias;
        $this->idTipoFormulario = $idTipoFormulario;
        $this->aforo = $aforo;
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
    public function getTotalIntereses()
    {
        return $this->totalIntereses;
    }

    /**
     * @param mixed $totalIntereses
     */
    public function setTotalIntereses($totalIntereses): void
    {
        $this->totalIntereses = $totalIntereses;
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
    public function getDiasAlm()
    {
        return $this->diasAlmonedaValue;
    }

    /**
     * @param mixed $diasAlmonedaValue
     */
    public function setDiasAlm($diasAlmonedaValue): void
    {
        $this->diasAlmonedaValue = $diasAlmonedaValue;
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

}