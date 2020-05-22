<?php


class ClienteActualizar
{
    private $idNombreEditar;
    private $idApPatEditar;
    private $idApMatEditar;
    private $idSexoEditar;
    private $idFechaNacEditar;
    private $idRfcEditar;
    private $idCurpEditar;
    private $idCelularEditar;
    private $idTelefonoEditar;
    private $idCorreoEditar;
    private $idOcupacionEditar;
    private $idIdentificacionEditar;
    private $idNumIdentificacionEditar;
    private $idEstadoEditar;
    private $idMunicipioEditar;
    private $idLocalidadEditar;
    private $idCalleEditar;
    private $idCPEditar;
    private $idNumExtEditar;
    private $idNumIntEditar;
    private $idPromocionEditar;
    private $idMensajeInternoEditar;

    /**
     * Cliente constructor.
     * @param $idNombreEditar
     * @param $idApPatEditar
     * @param $idApMatEditar
     * @param $idSexoEditar
     * @param $idFechaNacEditar
     * @param $idRfcEditar
     * @param $idCurpEditar
     * @param $idCelularEditar
     * @param $idTelefonoEditar
     * @param $idCorreoEditar
     * @param $idOcupacionEditar
     * @param $idIdentificacionEditar
     * @param $idNumIdentificacionEditar
     * @param $idEstadoEditar
     * @param $idMunicipioEditar
     * @param $idLocalidadEditar
     * @param $idCalleEditar
     * @param $idCPEditar
     * @param $idNumExtEditar
     * @param $idNumIntEditar
     * @param $idPromocionEditar
     * @param $idMensajeInternoEditar
     */
    public function __construct($idNombreEditar, $idApPatEditar, $idApMatEditar, $idSexoEditar, $idFechaNacEditar, $idRfcEditar, $idCurpEditar, $idCelularEditar, $idTelefonoEditar, $idCorreoEditar, $idOcupacionEditar, $idIdentificacionEditar, $idNumIdentificacionEditar, $idEstadoEditar, $idMunicipioEditar, $idLocalidadEditar, $idCalleEditar, $idCPEditar, $idNumExtEditar, $idNumIntEditar, $idPromocionEditar, $idMensajeInternoEditar)
    {
        $this->idNombreEditar = $idNombreEditar;
        $this->idApPatEditar = $idApPatEditar;
        $this->idApMatEditar = $idApMatEditar;
        $this->idSexoEditar = $idSexoEditar;
        $this->idFechaNacEditar = $idFechaNacEditar;
        $this->idRfcEditar = $idRfcEditar;
        $this->idCurpEditar = $idCurpEditar;
        $this->idCelularEditar = $idCelularEditar;
        $this->idTelefonoEditar = $idTelefonoEditar;
        $this->idCorreoEditar = $idCorreoEditar;
        $this->idOcupacionEditar = $idOcupacionEditar;
        $this->idIdentificacionEditar = $idIdentificacionEditar;
        $this->idNumIdentificacionEditar = $idNumIdentificacionEditar;
        $this->idEstadoEditar = $idEstadoEditar;
        $this->idMunicipioEditar = $idMunicipioEditar;
        $this->idLocalidadEditar = $idLocalidadEditar;
        $this->idCalleEditar = $idCalleEditar;
        $this->idCPEditar = $idCPEditar;
        $this->idNumExtEditar = $idNumExtEditar;
        $this->idNumIntEditar = $idNumIntEditar;
        $this->idPromocionEditar = $idPromocionEditar;
        $this->idMensajeInternoEditar = $idMensajeInternoEditar;
    }

    /**
     * @return mixed
     */
    public function getIdNombreEditar()
    {
        return $this->idNombreEditar;
    }

    /**
     * @param mixed $idNombreEditar
     */
    public function setIdNombreEditar($idNombreEditar): void
    {
        $this->idNombreEditar = $idNombreEditar;
    }

    /**
     * @return mixed
     */
    public function getIdApPatEditar()
    {
        return $this->idApPatEditar;
    }

    /**
     * @param mixed $idApPatEditar
     */
    public function setIdApPatEditar($idApPatEditar): void
    {
        $this->idApPatEditar = $idApPatEditar;
    }

    /**
     * @return mixed
     */
    public function getIdApMatEditar()
    {
        return $this->idApMatEditar;
    }

    /**
     * @param mixed $idApMatEditar
     */
    public function setIdApMatEditar($idApMatEditar): void
    {
        $this->idApMatEditar = $idApMatEditar;
    }

    /**
     * @return mixed
     */
    public function getIdSexoEditar()
    {
        return $this->idSexoEditar;
    }

    /**
     * @param mixed $idSexoEditar
     */
    public function setIdSexoEditar($idSexoEditar): void
    {
        $this->idSexoEditar = $idSexoEditar;
    }

    /**
     * @return mixed
     */
    public function getIdFechaNacEditar()
    {
        return $this->idFechaNacEditar;
    }

    /**
     * @param mixed $idFechaNacEditar
     */
    public function setIdFechaNacEditar($idFechaNacEditar): void
    {
        $this->idFechaNacEditar = $idFechaNacEditar;
    }

    /**
     * @return mixed
     */
    public function getIdRfcEditar()
    {
        return $this->idRfcEditar;
    }

    /**
     * @param mixed $idRfcEditar
     */
    public function setIdRfcEditar($idRfcEditar): void
    {
        $this->idRfcEditar = $idRfcEditar;
    }

    /**
     * @return mixed
     */
    public function getIdCurpEditar()
    {
        return $this->idCurpEditar;
    }

    /**
     * @param mixed $idCurpEditar
     */
    public function setIdCurpEditar($idCurpEditar): void
    {
        $this->idCurpEditar = $idCurpEditar;
    }

    /**
     * @return mixed
     */
    public function getIdCelularEditar()
    {
        return $this->idCelularEditar;
    }

    /**
     * @param mixed $idCelularEditar
     */
    public function setIdCelularEditar($idCelularEditar): void
    {
        $this->idCelularEditar = $idCelularEditar;
    }

    /**
     * @return mixed
     */
    public function getIdTelefonoEditar()
    {
        return $this->idTelefonoEditar;
    }

    /**
     * @param mixed $idTelefonoEditar
     */
    public function setIdTelefonoEditar($idTelefonoEditar): void
    {
        $this->idTelefonoEditar = $idTelefonoEditar;
    }

    /**
     * @return mixed
     */
    public function getIdCorreoEditar()
    {
        return $this->idCorreoEditar;
    }

    /**
     * @param mixed $idCorreoEditar
     */
    public function setIdCorreoEditar($idCorreoEditar): void
    {
        $this->idCorreoEditar = $idCorreoEditar;
    }

    /**
     * @return mixed
     */
    public function getIdOcupacionEditar()
    {
        return $this->idOcupacionEditar;
    }

    /**
     * @param mixed $idOcupacionEditar
     */
    public function setIdOcupacionEditar($idOcupacionEditar): void
    {
        $this->idOcupacionEditar = $idOcupacionEditar;
    }

    /**
     * @return mixed
     */
    public function getIdIdentificacionEditar()
    {
        return $this->idIdentificacionEditar;
    }

    /**
     * @param mixed $idIdentificacionEditar
     */
    public function setIdIdentificacionEditar($idIdentificacionEditar): void
    {
        $this->idIdentificacionEditar = $idIdentificacionEditar;
    }

    /**
     * @return mixed
     */
    public function getIdNumIdentificacionEditar()
    {
        return $this->idNumIdentificacionEditar;
    }

    /**
     * @param mixed $idNumIdentificacionEditar
     */
    public function setIdNumIdentificacionEditar($idNumIdentificacionEditar): void
    {
        $this->idNumIdentificacionEditar = $idNumIdentificacionEditar;
    }

    /**
     * @return mixed
     */
    public function getIdEstadoEditar()
    {
        return $this->idEstadoEditar;
    }

    /**
     * @param mixed $idEstadoEditar
     */
    public function setIdEstadoEditar($idEstadoEditar): void
    {
        $this->idEstadoEditar = $idEstadoEditar;
    }

    /**
     * @return mixed
     */
    public function getIdMunicipioEditar()
    {
        return $this->idMunicipioEditar;
    }

    /**
     * @param mixed $idMunicipioEditar
     */
    public function setIdMunicipioEditar($idMunicipioEditar): void
    {
        $this->idMunicipioEditar = $idMunicipioEditar;
    }

    /**
     * @return mixed
     */
    public function getIdLocalidadEditar()
    {
        return $this->idLocalidadEditar;
    }

    /**
     * @param mixed $idLocalidadEditar
     */
    public function setIdLocalidadEditar($idLocalidadEditar): void
    {
        $this->idLocalidadEditar = $idLocalidadEditar;
    }

    /**
     * @return mixed
     */
    public function getIdCalleEditar()
    {
        return $this->idCalleEditar;
    }

    /**
     * @param mixed $idCalleEditar
     */
    public function setIdCalleEditar($idCalleEditar): void
    {
        $this->idCalleEditar = $idCalleEditar;
    }

    /**
     * @return mixed
     */
    public function getIdCPEditar()
    {
        return $this->idCPEditar;
    }

    /**
     * @param mixed $idCPEditar
     */
    public function setIdCPEditar($idCPEditar): void
    {
        $this->idCPEditar = $idCPEditar;
    }

    /**
     * @return mixed
     */
    public function getIdNumExtEditar()
    {
        return $this->idNumExtEditar;
    }

    /**
     * @param mixed $idNumExtEditar
     */
    public function setIdNumExtEditar($idNumExtEditar): void
    {
        $this->idNumExtEditar = $idNumExtEditar;
    }

    /**
     * @return mixed
     */
    public function getIdNumIntEditar()
    {
        return $this->idNumIntEditar;
    }

    /**
     * @param mixed $idNumIntEditar
     */
    public function setIdNumIntEditar($idNumIntEditar): void
    {
        $this->idNumIntEditar = $idNumIntEditar;
    }

    /**
     * @return mixed
     */
    public function getIdPromocionEditar()
    {
        return $this->idPromocionEditar;
    }

    /**
     * @param mixed $idPromocionEditar
     */
    public function setIdPromocionEditar($idPromocionEditar): void
    {
        $this->idPromocionEditar = $idPromocionEditar;
    }

    /**
     * @return mixed
     */
    public function getIdMensajeInternoEditar()
    {
        return $this->idMensajeInternoEditar;
    }

    /**
     * @param mixed $idMensajeInternoEditar
     */
    public function setIdMensajeInternoEditar($idMensajeInternoEditar): void
    {
        $this->idMensajeInternoEditar = $idMensajeInternoEditar;
    }




}
