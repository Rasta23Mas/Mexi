<?php


class Cliente
{
    private $idNombre;
    private $idApPat;
    private $idApMat;
    private $idSexo;
    private $idFechaNac;
    private $idRfc;
    private $idCurp;
    private $idCelular;
    private $idTelefono;
    private $idCorreo;
    private $idOcupacion;
    private $idIdentificacion;
    private $idNumIdentificacion;
    private $idEstado;
    private $idMunicipio;
    private $idLocalidad;
    private $idCalle;
    private $idCP;
    private $idNumExt;
    private $idNumInt;
    private $idPromocion;
    private $idMensajeInterno;

    /**
     * Cliente constructor.
     * @param  $idNombre
     * @param  $idApPat
     * @param  $idApMat
     * @param  $idSexo
     * @param  $idFechaNac
     * @param  $idRfc
     * @param  $idCurp
     * @param  $idCelular
     * @param  $idTelefono
     * @param  $idCorreo
     * @param  $idOcupacion
     * @param  $idIdentificacion
     * @param  $idNumIdentificacion
     * @param  $idEstado
     * @param  $idMunicipio
     * @param  $idLocalidad
     * @param  $idCalle
     * @param  $idCP
     * @param  $idNumExt
     * @param  $idNumInt
     * @param  $idPromocion
     * @param  $idMensajeInterno
     */
    public function __construct($idNombre, $idApPat, $idApMat, $idSexo, $idFechaNac, $idRfc, $idCurp, $idCelular, $idTelefono, $idCorreo,
        $idOcupacion, $idIdentificacion, $idNumIdentificacion, $idEstado, $idMunicipio, $idLocalidad, $idCalle, $idCP, $idNumExt,
        $idNumInt, $idPromocion, $idMensajeInterno
    )
    {


        $this->nombre = $idNombre;
        $this->apellido_Pat = $idApPat;
        $this->apellido_Mat = $idApMat;
        $this->sexo = $idSexo;
        $this->fecha_Nacimiento = $idFechaNac;
        $this->rfc = $idRfc;
        $this->curp = $idCurp;
        $this->celular = $idCelular;
        $this->telefono = $idTelefono;
        $this->correo = $idCorreo;
        $this->ocupacion = $idOcupacion;
        $this->identificacion = $idIdentificacion;
        $this->numIdentificacion = $idNumIdentificacion;
        $this->estado = $idEstado;
        $this->municipio = $idMunicipio;
        $this->localidad = $idLocalidad;
        $this->calle = $idCalle;
        $this->codigo_postal = $idCP;
        $this->num_exterior = $idNumExt;
        $this->num_interior = $idNumInt;
        $this->promocion = $idPromocion;
        $this->mensajeInterno = $idMensajeInterno;
    }

    /**
     * @return mixed
     */
    public function getApellidoMat()
    {
        return $this->apellido_Mat;
    }

    /**
     * @param mixed $apellido_Mat
     */
    public function setApellidoMat($apellido_Mat): void
    {
        $this->apellido_Mat = $apellido_Mat;
    }

    /**
     * @return mixed
     */
    public function getApellidoPat()
    {
        return $this->apellido_Pat;
    }

    /**
     * @param mixed $apellido_Pat
     */
    public function setApellidoPat($apellido_Pat): void
    {
        $this->apellido_Pat = $apellido_Pat;
    }

    /**
     * @return mixed
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * @param mixed $calle
     */
    public function setCalle($calle): void
    {
        $this->calle = $calle;
    }

    /**
     * @return mixed
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @param mixed $celular
     */
    public function setCelular($celular): void
    {
        $this->celular = $celular;
    }

    /**
     * @return mixed
     */
    public function getCodigoPostal()
    {
        return $this->codigo_postal;
    }

    /**
     * @param mixed $codigo_postal
     */
    public function setCodigoPostal($codigo_postal): void
    {
        $this->codigo_postal = $codigo_postal;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed
     */
    public function getCurp()
    {
        return $this->curp;
    }

    /**
     * @param mixed $curp
     */
    public function setCurp($curp): void
    {
        $this->curp = $curp;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getFechaNacimiento()
    {
        return $this->fecha_Nacimiento;
    }

    /**
     * @param mixed $fecha_Nacimiento
     */
    public function setFechaNacimiento($fecha_Nacimiento): void
    {
        $this->fecha_Nacimiento = $fecha_Nacimiento;
    }

    /**
     * @return mixed
     */
    public function getIdentificacion()
    {
        return $this->identificacion;
    }

    /**
     * @param mixed $identificacion
     */
    public function setIdentificacion($identificacion): void
    {
        $this->identificacion = $identificacion;
    }

    /**
     * @return mixed
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * @param mixed $localidad
     */
    public function setLocalidad($localidad): void
    {
        $this->localidad = $localidad;
    }

    /**
     * @return mixed
     */
    public function getMensajeInterno()
    {
        return $this->mensajeInterno;
    }

    /**
     * @param mixed $mensajeInterno
     */
    public function setMensajeInterno($mensajeInterno): void
    {
        $this->mensajeInterno = $mensajeInterno;
    }

    /**
     * @return mixed
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * @param mixed $municipio
     */
    public function setMunicipio($municipio): void
    {
        $this->municipio = $municipio;
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
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getNumIdentificacion()
    {
        return $this->numIdentificacion;
    }

    /**
     * @param mixed $numIdentificacion
     */
    public function setNumIdentificacion($numIdentificacion): void
    {
        $this->numIdentificacion = $numIdentificacion;
    }

    /**
     * @return mixed
     */
    public function getNumExterior()
    {
        return $this->num_exterior;
    }

    /**
     * @param mixed $num_exterior
     */
    public function setNumExterior($num_exterior): void
    {
        $this->num_exterior = $num_exterior;
    }

    /**
     * @return mixed
     */
    public function getNumInterior()
    {
        return $this->num_interior;
    }

    /**
     * @param mixed $num_interior
     */
    public function setNumInterior($num_interior): void
    {
        $this->num_interior = $num_interior;
    }

    /**
     * @return mixed
     */
    public function getOcupacion()
    {
        return $this->ocupacion;
    }

    /**
     * @param mixed $ocupacion
     */
    public function setOcupacion($ocupacion): void
    {
        $this->ocupacion = $ocupacion;
    }

    /**
     * @return mixed
     */
    public function getPromocion()
    {
        return $this->promocion;
    }

    /**
     * @param mixed $promocion
     */
    public function setPromocion($promocion): void
    {
        $this->promocion = $promocion;
    }

    /**
     * @return mixed
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * @param mixed $rfc
     */
    public function setRfc($rfc): void
    {
        $this->rfc = $rfc;
    }

    /**
     * @return mixed
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @param mixed $sexo
     */
    public function setSexo($sexo): void
    {
        $this->sexo = $sexo;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }


}
