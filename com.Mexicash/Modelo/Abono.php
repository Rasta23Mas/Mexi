<?php


class Abono
{
    private $idAbono;
    private $folio;
    private $fecha;
    private $articulosApartados;
    private $totApartado;
    private $abonado;
    private $ultSaldo;
    private $fechaabono;
    private $importeAbono;
    private $nuevoSaldo;
    private $totalPagarAbono;
    private $formaPago;
    private $puntos;

    /**
     * Abono constructor.
     * @param $folio
     * @param $fecha
     * @param $articulosApartados
     * @param $totApartado
     * @param $abonado
     * @param $ultSaldo
     * @param $fechaabono
     * @param $importeAbono
     * @param $nuevoSaldo
     * @param $totalPagarAbono
     * @param $formaPago
     * @param $puntos
     */
    public function __construct($folio, $fecha, $articulosApartados, $totApartado, $abonado, $ultSaldo, $fechaabono, $importeAbono, $nuevoSaldo, $totalPagarAbono, $formaPago, $puntos)
    {
        $this->folio = $folio;
        $this->fecha = $fecha;
        $this->articulosApartados = $articulosApartados;
        $this->totApartado = $totApartado;
        $this->abonado = $abonado;
        $this->ultSaldo = $ultSaldo;
        $this->fechaabono = $fechaabono;
        $this->importeAbono = $importeAbono;
        $this->nuevoSaldo = $nuevoSaldo;
        $this->totalPagarAbono = $totalPagarAbono;
        $this->formaPago = $formaPago;
        $this->puntos = $puntos;
    }

    /**
     * @return mixed
     */
    public function getIdAbono()
    {
        return $this->idAbono;
    }

    /**
     * @param mixed $idAbono
     */
    public function setIdAbono($idAbono): void
    {
        $this->idAbono = $idAbono;
    }

    /**
     * @return mixed
     */
    public function getFolio()
    {
        return $this->folio;
    }

    /**
     * @param mixed $folio
     */
    public function setFolio($folio): void
    {
        $this->folio = $folio;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getArticulosApartados()
    {
        return $this->articulosApartados;
    }

    /**
     * @param mixed $articulosApartados
     */
    public function setArticulosApartados($articulosApartados): void
    {
        $this->articulosApartados = $articulosApartados;
    }

    /**
     * @return mixed
     */
    public function getTotApartado()
    {
        return $this->totApartado;
    }

    /**
     * @param mixed $totApartado
     */
    public function setTotApartado($totApartado): void
    {
        $this->totApartado = $totApartado;
    }

    /**
     * @return mixed
     */
    public function getAbonado()
    {
        return $this->abonado;
    }

    /**
     * @param mixed $abonado
     */
    public function setAbonado($abonado): void
    {
        $this->abonado = $abonado;
    }

    /**
     * @return mixed
     */
    public function getUltSaldo()
    {
        return $this->ultSaldo;
    }

    /**
     * @param mixed $ultSaldo
     */
    public function setUltSaldo($ultSaldo): void
    {
        $this->ultSaldo = $ultSaldo;
    }

    /**
     * @return mixed
     */
    public function getFechaabono()
    {
        return $this->fechaabono;
    }

    /**
     * @param mixed $fechaabono
     */
    public function setFechaabono($fechaabono): void
    {
        $this->fechaabono = $fechaabono;
    }

    /**
     * @return mixed
     */
    public function getImporteAbono()
    {
        return $this->importeAbono;
    }

    /**
     * @param mixed $importeAbono
     */
    public function setImporteAbono($importeAbono): void
    {
        $this->importeAbono = $importeAbono;
    }

    /**
     * @return mixed
     */
    public function getNuevoSaldo()
    {
        return $this->nuevoSaldo;
    }

    /**
     * @param mixed $nuevoSaldo
     */
    public function setNuevoSaldo($nuevoSaldo): void
    {
        $this->nuevoSaldo = $nuevoSaldo;
    }

    /**
     * @return mixed
     */
    public function getTotalPagarAbono()
    {
        return $this->totalPagarAbono;
    }

    /**
     * @param mixed $totalPagarAbono
     */
    public function setTotalPagarAbono($totalPagarAbono): void
    {
        $this->totalPagarAbono = $totalPagarAbono;
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
    public function getPuntos()
    {
        return $this->puntos;
    }

    /**
     * @param mixed $puntos
     */
    public function setPuntos($puntos): void
    {
        $this->puntos = $puntos;
    }




}