<?php


class Articulo
{
    //Metal
    private $idTipoM;
    private $idKilataje;
    private $idCalidad;
    private $idCantidad;
    private $idPeso;
    private $idPesoPiedra;
    private $idPiedras;
    private $idPrestamo;
    private $idAvaluo;
    private $idObs;
    private $idDetallePrenda;
    private $descCorto;
    private $idVitrina;
    private $idPrecioCat;
    private $interes;
    //Electronico
    private $idTipoE;
    private $idMarca;
    private $idEstado;
    private $idModelo;
    private $idSerie;
    private $idPrestamoE;
    private $idAvaluoE;
    private $idObsE;
    private $idDetallePrendaE;
    private $descCortoElectro;


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
     * @param $idPrestamo
     * @param $idAvaluo
     * @param $idObs
     * @param $idDetallePrenda
     * @param $descCorto
     * @param $idVitrina
     * @param $idPrecioCat
     * @param $interes
     * Electronico
     * @param $idTipoE
     * @param $idMarca
     * @param $idEstado
     * @param $idModelo
     * @param $idSerie
     * @param $idPrestamoE
     * @param $idAvaluoE
     * @param $idObsE
     * @param $idDetallePrendaE
     * @param $descCortoElectro
     */
    public function __construct(
        $idTipoM,
        $idKilataje,
        $idCalidad,
        $idCantidad,
        $idPeso,
        $idPesoPiedra,
        $idPiedras,
        $idPrestamo,
        $idAvaluo,
        $idVitrina,
        $idPrecioCat,
        $interes,
        $idObs,
        $idDetallePrenda,
        $descCorto,
        $idTipoE,
        $idMarca,
        $idEstado,
        $idModelo,
        $idSerie,
        $idPrestamoE,
        $idAvaluoE,
        $idObsE,
        $idDetallePrendaE,
        $descCortoElectro)
    {
        //Metales
        $this->tipoM = $idTipoM;
        $this->kilataje = $idKilataje;
        $this->calidad = $idCalidad;
        $this->cantidad = $idCantidad;
        $this->peso = $idPeso;
        $this->pesoPiedra = $idPesoPiedra;
        $this->piedras = $idPiedras;
        $this->prestamo = $idPrestamo;
        $this->avaluo = $idAvaluo;
        $this->vitrina = $idVitrina;
        $this->precioCat = $idPrecioCat;
        $this->interes = $interes;
        $this->observaciones = $idObs;
        $this->detallePrenda = $idDetallePrenda;
        $this->descCorto = $descCorto;
        //ELECTRONICOS
        $this->tipoE = $idTipoE;
        $this->marca = $idMarca;
        $this->estado = $idEstado;
        $this->modelo = $idModelo;
        $this->serie = $idSerie;
        $this->prestamoE = $idPrestamoE;
        $this->avaluoE = $idAvaluoE;
        $this->observacionesE = $idObsE;
        $this->detallePrendaE = $idDetallePrendaE;
        $this->descCortoElectro = $descCortoElectro;

    }

    /**
     * @return mixed
     */
    public function getDescCorto()
    {
        return $this->descCorto;
    }

    /**
     * @param mixed $descCorto
     */
    public function setDescCorto($descCorto): void
    {
        $this->descCorto = $descCorto;
    }

    /**
     * @return mixed
     */
    public function getDescCortoElectro()
    {
        return $this->descCortoElectro;
    }

    /**
     * @param mixed $descCortoElectro
     */
    public function setDescCortoElectro($descCortoElectro): void
    {
        $this->descCortoElectro = $descCortoElectro;
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
    public function getInteres()
    {
        return $this->interes;
    }

    /**
     * @param mixed $interes
     */
    public function setInteres($interes): void
    {
        $this->interes = $interes;
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
    public function getAvaluo()
    {
        return $this->avaluo;
    }

    /**
     * @param mixed $avaluo
     */
    public function setAvaluo($avaluo): void
    {
        $this->avaluo = $avaluo;
    }

    /**
     * @return mixed
     */
    public function getAvaluoE()
    {
        return $this->avaluoE;
    }

    /**
     * @param mixed $avaluoE
     */
    public function setAvaluoE($avaluoE): void
    {
        $this->avaluoE = $avaluoE;
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

    /**
     * @return mixed
     */
    public function getPrestamoE()
    {
        return $this->prestamoE;
    }

    /**
     * @param mixed $prestamoE
     */
    public function setPrestamoE($prestamoE): void
    {
        $this->prestamoE = $prestamoE;
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