<?php


class Ventas
{
    private $idVenta;
    private $codigoVenta;
    private $vendedor;
    private $articulo;
    private $formaPago;
    private $descuento;
    private $totPagoVenta;

    /**
     * Ventas constructor.
     * @param $codigoVenta
     * @param $vendedor
     * @param $articulo
     * @param $formaPago
     * @param $descuento
     * @param $totPagoVenta
     */
    public function __construct($codigoVenta, $vendedor, $articulo, $formaPago, $descuento, $totPagoVenta)
    {
        $this->codigoVenta = $codigoVenta;
        $this->vendedor = $vendedor;
        $this->articulo = $articulo;
        $this->formaPago = $formaPago;
        $this->descuento = $descuento;
        $this->totPagoVenta = $totPagoVenta;
    }

    /**
     * @return mixed
     */
    public function getIdVenta()
    {
        return $this->idVenta;
    }

    /**
     * @param mixed $idVenta
     */
    public function setIdVenta($idVenta): void
    {
        $this->idVenta = $idVenta;
    }

    /**
     * @return mixed
     */
    public function getCodigoVenta()
    {
        return $this->codigoVenta;
    }

    /**
     * @param mixed $codigoVenta
     */
    public function setCodigoVenta($codigoVenta): void
    {
        $this->codigoVenta = $codigoVenta;
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
    public function getArticulo()
    {
        return $this->articulo;
    }

    /**
     * @param mixed $articulo
     */
    public function setArticulo($articulo): void
    {
        $this->articulo = $articulo;
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
    public function getTotPagoVenta()
    {
        return $this->totPagoVenta;
    }

    /**
     * @param mixed $totPagoVenta
     */
    public function setTotPagoVenta($totPagoVenta): void
    {
        $this->totPagoVenta = $totPagoVenta;
    }



}