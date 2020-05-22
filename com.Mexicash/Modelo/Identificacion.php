<?php


class Identificacion
{
    private $id_Identificacion;
    private $tipo_Identificacion;
    private $descripcion_Identificacion;

    /**
     * Identificacion constructor.
     * @param $tipo_Identificacion
     * @param $descripcion_Identificacion
     */
    public function __construct($tipo_Identificacion, $descripcion_Identificacion)
    {
        $this->tipo_Identificacion = $tipo_Identificacion;
        $this->descripcion_Identificacion = $descripcion_Identificacion;
    }

    /**
     * @return mixed
     */
    public function getIdIdentificacion()
    {
        return $this->id_Identificacion;
    }

    /**
     * @param mixed $id_Identificacion
     */
    public function setIdIdentificacion($id_Identificacion): void
    {
        $this->id_Identificacion = $id_Identificacion;
    }

    /**
     * @return mixed
     */
    public function getTipoIdentificacion()
    {
        return $this->tipo_Identificacion;
    }

    /**
     * @param mixed $tipo_Identificacion
     */
    public function setTipoIdentificacion($tipo_Identificacion): void
    {
        $this->tipo_Identificacion = $tipo_Identificacion;
    }

    /**
     * @return mixed
     */
    public function getDescripcionIdentificacion()
    {
        return $this->descripcion_Identificacion;
    }

    /**
     * @param mixed $descripcion_Identificacion
     */
    public function setDescripcionIdentificacion($descripcion_Identificacion): void
    {
        $this->descripcion_Identificacion = $descripcion_Identificacion;
    }



}