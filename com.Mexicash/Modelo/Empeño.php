<?php


class Empeño
{
    private $idEmpeño;
    //private $dueño;
    private $nombreCot;
    private $apellPCot;
    private $apellMCot;
    private $beneficiario;
    private $metal_Electro;
    private $tipo;
    private $prenda;
    private $kilataje;
    private $calidad;
    private $cantidad;
    private $peso;
    private $pesoPiedras;
    private $piedras;
    private $prestamo;

    /**
     * Empeno constructor.
     * @param $nombreCot
     * @param $apellPCot
     * @param $apellMCot
     * @param $beneficiario
     * @param $metal_Electro
     * @param $tipo
     * @param $prenda
     * @param $kilataje
     * @param $calidad
     * @param $cantidad
     * @param $peso
     * @param $pesoPiedras
     * @param $piedras
     * @param $prestamo
     */
    public function __construct($nombreCot, $apellPCot, $apellMCot, $beneficiario, $metal_Electro, $tipo, $prenda, $kilataje, $calidad, $cantidad, $peso, $pesoPiedras, $piedras, $prestamo)
    {
        $this->nombreCot = $nombreCot;
        $this->apellPCot = $apellPCot;
        $this->apellMCot = $apellMCot;
        $this->beneficiario = $beneficiario;
        $this->metal_Electro = $metal_Electro;
        $this->tipo = $tipo;
        $this->prenda = $prenda;
        $this->kilataje = $kilataje;
        $this->calidad = $calidad;
        $this->cantidad = $cantidad;
        $this->peso = $peso;
        $this->pesoPiedras = $pesoPiedras;
        $this->piedras = $piedras;
        $this->prestamo = $prestamo;
    }

    /**
     * @return mixed
     */
    public function getIdEmpeño()
    {
        return $this->idEmpeño;
    }

    /**
     * @param mixed $idEmpeño
     */
    public function setIdEmpeño($idEmpeño): void
    {
        $this->idEmpeño = $idEmpeño;
    }

    /**
     * @return mixed
     */
    public function getNombreCot()
    {
        return $this->nombreCot;
    }

    /**
     * @param mixed $nombreCot
     */
    public function setNombreCot($nombreCot): void
    {
        $this->nombreCot = $nombreCot;
    }

    /**
     * @return mixed
     */
    public function getApellPCot()
    {
        return $this->apellPCot;
    }

    /**
     * @param mixed $apellPCot
     */
    public function setApellPCot($apellPCot): void
    {
        $this->apellPCot = $apellPCot;
    }

    /**
     * @return mixed
     */
    public function getApellMCot()
    {
        return $this->apellMCot;
    }

    /**
     * @param mixed $apellMCot
     */
    public function setApellMCot($apellMCot): void
    {
        $this->apellMCot = $apellMCot;
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
    public function getMetalElectro()
    {
        return $this->metal_Electro;
    }

    /**
     * @param mixed $metal_Electro
     */
    public function setMetalElectro($metal_Electro): void
    {
        $this->metal_Electro = $metal_Electro;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getPrenda()
    {
        return $this->prenda;
    }

    /**
     * @param mixed $prenda
     */
    public function setPrenda($prenda): void
    {
        $this->prenda = $prenda;
    }

    /**
     * @return mixed
     */
    public function getKilataje()
    {
        return $this->kilataje;
    }

    /**
     * @param mixed $kilataje
     */
    public function setKilataje($kilataje): void
    {
        $this->kilataje = $kilataje;
    }

    /**
     * @return mixed
     */
    public function getCalidad()
    {
        return $this->calidad;
    }

    /**
     * @param mixed $calidad
     */
    public function setCalidad($calidad): void
    {
        $this->calidad = $calidad;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * @param mixed $peso
     */
    public function setPeso($peso): void
    {
        $this->peso = $peso;
    }

    /**
     * @return mixed
     */
    public function getPesoPiedras()
    {
        return $this->pesoPiedras;
    }

    /**
     * @param mixed $pesoPiedras
     */
    public function setPesoPiedras($pesoPiedras): void
    {
        $this->pesoPiedras = $pesoPiedras;
    }

    /**
     * @return mixed
     */
    public function getPiedras()
    {
        return $this->piedras;
    }

    /**
     * @param mixed $piedras
     */
    public function setPiedras($piedras): void
    {
        $this->piedras = $piedras;
    }

    /**
     * @return mixed
     */
    public function getPrestamo()
    {
        return $this->prestamo;
    }

    /**
     * @param mixed $prestamo
     */
    public function setPrestamo($prestamo): void
    {
        $this->prestamo = $prestamo;
    }



}