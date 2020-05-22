<?php


class Apartado
{
    private $idApartado;
    private $codigoApartado;
    private $vendedor;
    private $fechaApartado;
    private $fechaVencimientoApartado;
    private $folioApartado;
    private $formaPago;
    private $descuento;
    private $totalPagarApartado;

    /**
     * Apartado constructor.
     * @param $codigoApartado
     * @param $vendedor
     * @param $fechaApartado
     * @param $fechaVencimientoApartado
     * @param $folioApartado
     * @param $formaPago
     * @param $descuento
     * @param $totalPagarApartado
     */
    public function __construct($codigoApartado, $vendedor, $fechaApartado, $fechaVencimientoApartado, $folioApartado, $formaPago, $descuento, $totalPagarApartado)
    {
        $this->codigoApartado = $codigoApartado;
        $this->vendedor = $vendedor;
        $this->fechaApartado = $fechaApartado;
        $this->fechaVencimientoApartado = $fechaVencimientoApartado;
        $this->folioApartado = $folioApartado;
        $this->formaPago = $formaPago;
        $this->descuento = $descuento;
        $this->totalPagarApartado = $totalPagarApartado;
    }

    /**
     * @return mixed
     */
    public function getIdApartado()
    {
        return $this->idApartado;
    }

    /**
     * @param mixed $idApartado
     */
    public function setIdApartado($idApartado): void
    {
        $this->idApartado = $idApartado;
    }

    /**
     * @return mixed
     */
    public function getCodigoApartado()
    {
        return $this->codigoApartado;
    }

    /**
     * @param mixed $codigoApartado
     */
    public function setCodigoApartado($codigoApartado): void
    {
        $this->codigoApartado = $codigoApartado;
    }

    /**
     * @return mixed
     */
    public function getVendedor()
    {
        return $this->vendedor;
    }

    /**
     * @param mixed $vendedor
     */
    public function setVendedor($vendedor): void
    {
        $this->vendedor = $vendedor;
    }

    /**
     * @return mixed
     */
    public function getFechaApartado()
    {
        return $this->fechaApartado;
    }

    /**
     * @param mixed $fechaApartado
     */
    public function setFechaApartado($fechaApartado): void
    {
        $this->fechaApartado = $fechaApartado;
    }

    /**
     * @return mixed
     */
    public function getFechaVencimientoApartado()
    {
        return $this->fechaVencimientoApartado;
    }

    /**
     * @param mixed $fechaVencimientoApartado
     */
    public function setFechaVencimientoApartado($fechaVencimientoApartado): void
    {
        $this->fechaVencimientoApartado = $fechaVencimientoApartado;
    }

    /**
     * @return mixed
     */
    public function getFolioApartado()
    {
        return $this->folioApartado;
    }

    /**
     * @param mixed $folioApartado
     */
    public function setFolioApartado($folioApartado): void
    {
        $this->folioApartado = $folioApartado;
    }

    /**
     * @return mixed
     */
    public function getFormaPago()
    {
        return $this->formaPago;
    }

    /**
     * @param mixed $formaPago
     */
    public function setFormaPago($formaPago): void
    {
        $this->formaPago = $formaPago;
    }

    /**
     * @return mixed
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * @param mixed $descuento
     */
    public function setDescuento($descuento): void
    {
        $this->descuento = $descuento;
    }

    /**
     * @return mixed
     */
    public function getTotalPagarApartado()
    {
        return $this->totalPagarApartado;
    }

    /**
     * @param mixed $totalPagarApartado
     */
    public function setTotalPagarApartado($totalPagarApartado): void
    {
        $this->totalPagarApartado = $totalPagarApartado;
    }



}