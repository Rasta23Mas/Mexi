<?php

include ('../../Modelo/Abono.php');
date_default_timezone_set('America/Mexico_City');

class sqlAbonoDAO
{
    protected $conexion;
    protected $db;

    public function __construct(){
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    public function guardaAbono(Abono $abono){
        try{
            $verdad = false;

            $idAbono = $abono->getIdAbono();
            $folio = $abono->getFolio();
            $fecha = $abono->getFecha();
            $articulosApartados = $abono->getArticulosApartados();
            $totApartado = $abono->getTotApartado();
            $abonado = $abono->getAbonado();
            $ultSaldo = $abono->getUltSaldo();
            $fechaabono = $abono->getFechaabono();
            $importeAbono = $abono->getImporteAbono();
            $nuevoSaldo = $abono->getNuevoSaldo();
            $totalPagarAbono = $abono->getTotalPagarAbono();
            $formaPago = $abono->getFormaPago();
            $puntos = $abono->getPuntos();

            $insertar = "";

            $this->conexion->query($insertar);
            echo "Se registró correctamente";

            $verdad = true;

        }catch (Exception $exc){
            echo  $exc->getMessage();
        }finally{
            $this->db->closeDB();
        }

        return $verdad;
    }

    public function borraAbono(Abono $abono){

    }
}