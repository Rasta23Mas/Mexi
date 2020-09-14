<?php


class ArticuloCompras
{
    //Metal
    private $idTipoM;
    private $idKilataje;
    private $idCalidad;
    private $idCantidad;
    private $idPeso;
    private $idPesoPiedra;
    private $idPiedras;
    private $idObs;
    private $idDetallePrenda;
    private $idVitrina;
    private $idPrecioCat;
    //Electronico
    private $idTipoE;
    private $idMarca;
    private $idEstado;
    private $idModelo;
    private $idSerie;
    private $idObsE;
    private $idDetallePrendaE;
    private $idContrato;
    private $SerieBazar;
    private $id_serieTipo;
    private $tipo_movimiento;
    private $descripcionCorta;



    /**
     * Articulo constructor.
     * Metal
     * @param $idTipoM
     * @param $idKilataje
     * @param $idCalidad
     * @param $idCantidad
     * @param $idPeso
     * @param $idPesoPiedra
     * @param $idPiedras
     * @param $idObs
     * @param $idDetallePrenda
     * @param $idVitrina
     * @param $idPrecioCat
     * Electronico
     * @param $idTipoE
     * @param $idMarca
     * @param $idEstado
     * @param $idModelo
     * @param $idSerie
     * @param $idObsE
     * @param $idDetallePrendaE
     * @param $idContrato
     * @param $SerieBazar
     * @param $id_serieTipo
     * @param $tipo_movimiento
     * @param $descripcionCorta
     */

    public function __construct(
        $idTipoM,
        $idKilataje,
        $idCalidad,
        $idCantidad,
        $idPeso,
        $idPesoPiedra,
        $idPiedras,
        $idVitrina,
        $idPrecioCat,
        $idObs,
        $idDetallePrenda,
        $idTipoE,
        $idMarca,
        $idEstado,
        $idModelo,
        $idSerie,
        $idObsE,
        $idDetallePrendaE,
        $idContrato,
        $SerieBazar,
        $id_serieTipo,
        $tipo_movimiento,
        $descripcionCorta
)
    {
        //Metales
        $this->tipoM = $idTipoM;
        $this->kilataje = $idKilataje;
        $this->calidad = $idCalidad;
        $this->cantidad = $idCantidad;
        $this->peso = $idPeso;
        $this->pesoPiedra = $idPesoPiedra;
        $this->piedras = $idPiedras;
        $this->vitrina = $idVitrina;
        $this->precioCat = $idPrecioCat;
        $this->observaciones = $idObs;
        $this->detallePrenda = $idDetallePrenda;
        //ELECTRONICOS
        $this->tipoE = $idTipoE;
        $this->marca = $idMarca;
        $this->estado = $idEstado;
        $this->modelo = $idModelo;
        $this->serie = $idSerie;
        $this->observacionesE = $idObsE;
        $this->detallePrendaE = $idDetallePrendaE;
        $this->idContrato = $idContrato;
        $this->SerieBazar = $SerieBazar;
        $this->id_serieTipo = $id_serieTipo;
        $this->tipo_movimiento = $tipo_movimiento;
        $this->descripcionCorta = $descripcionCorta;

    }

    /**
     * @return mixed
     */
    public function getIdContrato()
    {
        return $this->idContrato;
    }

    /**
     * @param mixed $idContrato
     */
    public function setIdContrato($idContrato): void
    {
        $this->idContrato = $idContrato;
    }

    /**
     * @return mixed
     */
    public function getSerieBazar()
    {
        return $this->SerieBazar;
    }

    /**
     * @param mixed $SerieBazar
     */
    public function setSerieBazar($SerieBazar): void
    {
        $this->SerieBazar = $SerieBazar;
    }

    /**
     * @return mixed
     */
    public function getIdSerieTipo()
    {
        return $this->id_serieTipo;
    }

    /**
     * @param mixed $id_serieTipo
     */
    public function setIdSerieTipo($id_serieTipo): void
    {
        $this->id_serieTipo = $id_serieTipo;
    }

    /**
     * @return mixed
     */
    public function getTipoMovimiento()
    {
        return $this->tipo_movimiento;
    }

    /**
     * @param mixed $tipo_movimiento
     */
    public function setTipoMovimiento($tipo_movimiento): void
    {
        $this->tipo_movimiento = $tipo_movimiento;
    }

    /**
     * @return mixed
     */
    public function getDescripcionCorta()
    {
        return $this->descripcionCorta;
    }

    /**
     * @param mixed $descripcionCorta
     */
    public function setDescripcionCorta($descripcionCorta): void
    {
        $this->descripcionCorta = $descripcionCorta;
    }

    /**
     * @return mixed
     */
    public function getPrecioCat()
    {
        return $this->precioCat;
    }

    /**
     * @param mixed $idPrecioCat
     */
    public function setPrecioCat($idPrecioCat): void
    {
        $this->precioCat = $idPrecioCat;
    }

    /**
     * @return mixed
     */
    public function getVitrina()
    {
        return $this->vitrina;
    }

    /**
     * @param mixed $idVitrina
     */
    public function setVitrina($idVitrina): void
    {
        $this->vitrina = $idVitrina;
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
    public function getDetallePrenda()
    {
        return $this->detallePrenda;
    }

    /**
     * @param mixed $detallePrenda
     */
    public function setDetallePrenda($detallePrenda): void
    {
        $this->detallePrenda = $detallePrenda;
    }

    /**
     * @return mixed
     */
    public function getDetallePrendaE()
    {
        return $this->detallePrendaE;
    }

    /**
     * @param mixed $detallePrendaE
     */
    public function setDetallePrendaE($detallePrendaE): void
    {
        $this->detallePrendaE = $detallePrendaE;
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
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param mixed $marca
     */
    public function setMarca($marca): void
    {
        $this->marca = $marca;
    }

    /**
     * @return mixed
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @param mixed $modelo
     */
    public function setModelo($modelo): void
    {
        $this->modelo = $modelo;
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
    public function getPesoPiedra()
    {
        return $this->pesoPiedra;
    }

    /**
     * @param mixed $pesoPiedra
     */
    public function setPesoPiedra($pesoPiedra): void
    {
        $this->pesoPiedra = $pesoPiedra;
    }


    /**
     * @return mixed
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param mixed $serie
     */
    public function setSerie($serie): void
    {
        $this->serie = $serie;
    }

    /**
     * @return mixed
     */
    public function getTipoM()
    {
        return $this->tipoM;
    }

    /**
     * @param mixed $tipoM
     */
    public function setTipoM($tipoM): void
    {
        $this->tipoM = $tipoM;
    }

    /**
     * @return mixed
     */
    public function getTipoE()
    {
        return $this->tipoE;
    }

    /**
     * @param mixed $tipoE
     */
    public function setTipoE($tipoE): void
    {
        $this->tipoE = $tipoE;
    }


    /**
     * @return mixed
     */
    public function getObs()
    {
        return $this->observaciones;
    }

    /**
     * @param mixed $observaciones
     */
    public function setObseracion($observaciones): void
    {
        $this->observaciones = $observaciones;
    }

    /**
     * @return mixed
     */
    public function getObsE()
    {
        return $this->observacionesE;
    }

    /**
     * @param mixed $observacionesE
     */
    public function setObseracionE($observacionesE): void
    {
        $this->observacionesE = $observacionesE;
    }


}