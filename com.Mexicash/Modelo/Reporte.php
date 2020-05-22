<?php


class Reporte
{
    /*
    $id_Contrato;
    $id_Cliente;
    $id_Articulo;
    $id_Auto;
    $id_Interes;
    $fecha_Vencimiento;
    $total_Avaluo;
    $total_Prestamo;
    $abono;
    $intereses;
    $pago;
    $fecha_Alm;
    $fecha_Movimiento;
    $origen_Folio;
    $dest_Folio;
    $id_Estatus;
    $observaciones;
    */

    private $id_Contrato;
    private $id_Cliente;
    private $id_Articulo;
    private $id_Auto;
    private $id_Interes;
    private $fecha_Vencimiento;
    private $total_Avaluo;
    private $total_Prestamo;
    private $abono;
    private $intereses;
    private $pago;
    private $fecha_Alm;
    private $fecha_Movimiento;
    private $origen_Folio;
    private $dest_Folio;
    private $id_Estatus;
    private $observaciones;

    /**
     * Reporte constructor.
     * @param $id_Cliente
     * @param $id_Articulo
     * @param $id_Auto
     * @param $id_Interes
     * @param $fecha_Vencimiento
     * @param $total_Avaluo
     * @param $total_Prestamo
     * @param $abono
     * @param $intereses
     * @param $pago
     * @param $fecha_Alm
     * @param $fecha_Movimiento
     * @param $origen_Folio
     * @param $dest_Folio
     * @param $id_Estatus
     * @param $observaciones
     */
    public function __construct($id_Cliente, $id_Articulo, $id_Auto, $id_Interes, $fecha_Vencimiento, $total_Avaluo, $total_Prestamo, $abono, $intereses, $pago, $fecha_Alm, $fecha_Movimiento, $origen_Folio, $dest_Folio, $id_Estatus, $observaciones)
    {
        $this->id_Cliente = $id_Cliente;
        $this->id_Articulo = $id_Articulo;
        $this->id_Auto = $id_Auto;
        $this->id_Interes = $id_Interes;
        $this->fecha_Vencimiento = $fecha_Vencimiento;
        $this->total_Avaluo = $total_Avaluo;
        $this->total_Prestamo = $total_Prestamo;
        $this->abono = $abono;
        $this->intereses = $intereses;
        $this->pago = $pago;
        $this->fecha_Alm = $fecha_Alm;
        $this->fecha_Movimiento = $fecha_Movimiento;
        $this->origen_Folio = $origen_Folio;
        $this->dest_Folio = $dest_Folio;
        $this->id_Estatus = $id_Estatus;
        $this->observaciones = $observaciones;
    }

    /**
     * @return mixed
     */
    public function getIdContrato()
    {
        return $this->id_Contrato;
    }

    /**
     * @param mixed $id_Contrato
     */
    public function setIdContrato($id_Contrato): void
    {
        $this->id_Contrato = $id_Contrato;
    }

    /**
     * @return mixed
     */
    public function getIdCliente()
    {
        return $this->id_Cliente;
    }

    /**
     * @param mixed $id_Cliente
     */
    public function setIdCliente($id_Cliente): void
    {
        $this->id_Cliente = $id_Cliente;
    }

    /**
     * @return mixed
     */
    public function getIdArticulo()
    {
        return $this->id_Articulo;
    }

    /**
     * @param mixed $id_Articulo
     */
    public function setIdArticulo($id_Articulo): void
    {
        $this->id_Articulo = $id_Articulo;
    }

    /**
     * @return mixed
     */
    public function getIdAuto()
    {
        return $this->id_Auto;
    }

    /**
     * @param mixed $id_Auto
     */
    public function setIdAuto($id_Auto): void
    {
        $this->id_Auto = $id_Auto;
    }

    /**
     * @return mixed
     */
    public function getIdInteres()
    {
        return $this->id_Interes;
    }

    /**
     * @param mixed $id_Interes
     */
    public function setIdInteres($id_Interes): void
    {
        $this->id_Interes = $id_Interes;
    }

    /**
     * @return mixed
     */
    public function getFechaVencimiento()
    {
        return $this->fecha_Vencimiento;
    }

    /**
     * @param mixed $fecha_Vencimiento
     */
    public function setFechaVencimiento($fecha_Vencimiento): void
    {
        $this->fecha_Vencimiento = $fecha_Vencimiento;
    }

    /**
     * @return mixed
     */
    public function getTotalAvaluo()
    {
        return $this->total_Avaluo;
    }

    /**
     * @param mixed $total_Avaluo
     */
    public function setTotalAvaluo($total_Avaluo): void
    {
        $this->total_Avaluo = $total_Avaluo;
    }

    /**
     * @return mixed
     */
    public function getTotalPrestamo()
    {
        return $this->total_Prestamo;
    }

    /**
     * @param mixed $total_Prestamo
     */
    public function setTotalPrestamo($total_Prestamo): void
    {
        $this->total_Prestamo = $total_Prestamo;
    }

    /**
     * @return mixed
     */
    public function getAbono()
    {
        return $this->abono;
    }

    /**
     * @param mixed $abono
     */
    public function setAbono($abono): void
    {
        $this->abono = $abono;
    }

    /**
     * @return mixed
     */
    public function getIntereses()
    {
        return $this->intereses;
    }

    /**
     * @param mixed $intereses
     */
    public function setIntereses($intereses): void
    {
        $this->intereses = $intereses;
    }

    /**
     * @return mixed
     */
    public function getPago()
    {
        return $this->pago;
    }

    /**
     * @param mixed $pago
     */
    public function setPago($pago): void
    {
        $this->pago = $pago;
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
    public function getFechaMovimiento()
    {
        return $this->fecha_Movimiento;
    }

    /**
     * @param mixed $fecha_Movimiento
     */
    public function setFechaMovimiento($fecha_Movimiento): void
    {
        $this->fecha_Movimiento = $fecha_Movimiento;
    }

    /**
     * @return mixed
     */
    public function getOrigenFolio()
    {
        return $this->origen_Folio;
    }

    /**
     * @param mixed $origen_Folio
     */
    public function setOrigenFolio($origen_Folio): void
    {
        $this->origen_Folio = $origen_Folio;
    }

    /**
     * @return mixed
     */
    public function getDestFolio()
    {
        return $this->dest_Folio;
    }

    /**
     * @param mixed $dest_Folio
     */
    public function setDestFolio($dest_Folio): void
    {
        $this->dest_Folio = $dest_Folio;
    }

    /**
     * @return mixed
     */
    public function getIdEstatus()
    {
        return $this->id_Estatus;
    }

    /**
     * @param mixed $id_Estatus
     */
    public function setIdEstatus($id_Estatus): void
    {
        $this->id_Estatus = $id_Estatus;
    }

    /**
     * @return mixed
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param mixed $observaciones
     */
    public function setObservaciones($observaciones): void
    {
        $this->observaciones = $observaciones;
    }



}