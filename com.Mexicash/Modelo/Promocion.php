<?php


class Promocion
{
    private $id_Promocion;
    private $tipo_Promocion;
    private $descripcion_Promocion;

    /**
     * Promocion constructor.
     * @param $tipo_Promocion
     * @param $descripcion_Promocion
     */
    public function __construct($tipo_Promocion, $descripcion_Promocion)
    {
        $this->tipo_Promocion = $tipo_Promocion;
        $this->descripcion_Promocion = $descripcion_Promocion;
    }

    /**
     * @return mixed
     */
    public function getIdPromocion()
    {
        return $this->id_Promocion;
    }

    /**
     * @param mixed $id_Promocion
     */
    public function setIdPromocion($id_Promocion): void
    {
        $this->id_Promocion = $id_Promocion;
    }

    /**
     * @return mixed
     */
    public function getTipoPromocion()
    {
        return $this->tipo_Promocion;
    }

    /**
     * @param mixed $tipo_Promocion
     */
    public function setTipoPromocion($tipo_Promocion): void
    {
        $this->tipo_Promocion = $tipo_Promocion;
    }

    /**
     * @return mixed
     */
    public function getDescripcionPromocion()
    {
        return $this->descripcion_Promocion;
    }

    /**
     * @param mixed $descripcion_Promocion
     */
    public function setDescripcionPromocion($descripcion_Promocion): void
    {
        $this->descripcion_Promocion = $descripcion_Promocion;
    }



}