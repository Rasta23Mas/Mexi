<?php


class Usuario
{
    private $idUsuario;
    private $nombreUsuario;
    private $password;
    private $nombre;
    private $apellidoP;
    private $apellidoM;
    private $estatus;

    /**
     * Usuario constructor.
     * @param $nombreUsuario
     * @param $password
     * @param $nombre
     * @param $apellidoP
     * @param $apellidoM
     * @param $estatus
     */
    public function __construct($nombreUsuario, $password, $nombre, $apellidoP, $apellidoM, $estatus)
    {
        $this->nombreUsuario = $nombreUsuario;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->apellidoP = $apellidoP;
        $this->apellidoM = $apellidoM;
        $this->estatus = $estatus;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param mixed $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @return mixed
     */
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * @param mixed $nombreUsuario
     */
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setContra($password)
    {
        $this->contra = $password;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getApellidoP()
    {
        return $this->apellidoP;
    }

    /**
     * @param mixed $apellidoP
     */
    public function setApellidoP($apellidoP)
    {
        $this->apellidoP = $apellidoP;
    }

    /**
     * @return mixed
     */
    public function getApellidoM()
    {
        return $this->apellidoM;
    }

    /**
     * @param mixed $apellidoM
     */
    public function setApellidoM($apellidoM)
    {
        $this->apellidoM = $apellidoM;
    }

    /**
     * @return mixed
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * @param mixed $estatus
     */
    public function setEstatus($estatus): void
    {
        $this->estatus = $estatus;
    }



}