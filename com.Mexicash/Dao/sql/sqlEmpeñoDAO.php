<?php

include ('../../Modelo/Empeño.php');
date_default_timezone_set('America/Mexico_City');

class sqlEmpeñoDAO
{
    protected $conexion;
    protected $db;

    public function __construct(){
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    public function empeñar(Empeño $empeño, $idCliente){

        try{

            $idEmpeño = $empeño->getIdEmpeño();
            //$dueño = $empeño->getDueño();
            $nombreCot = $empeño->getNombreCot();
            $apellPCot = $empeño->getApellPCot();
            $apellMCot = $empeño->getApellMCot();
            $beneficiario = $empeño->getBeneficiario();
            $metal_Electro = $empeño->getMetalElectro();
            $tipo = $empeño->getTipo();
            $prenda = $empeño->getPrenda();
            $kilataje = $empeño->getKilataje();
            $calidad = $empeño->getCalidad();
            $cantidad = $empeño->getCantidad();
            $peso = $empeño->getPeso();
            $pesoPiedras = $empeño->getPesoPiedras();
            $piedras = $empeño->getPiedras();
            $prestamo = $empeño->getPrestamo();

            $insertar = "";

            $this->conexion->query($insertar);
            echo "Se registró correctamente";

            $verdad = true;

        }catch (Exception $exc){
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

    }

    public function desempeñar($idEmpeño, $idCliente){
        try {

            $borrar = "delete from Empeños where idEmpeño = ". $idEmpeño ." and idUsuario = " . $idCliente;

            $this->conexion->query($borrar);
            echo "Se borr&oacute; correctamente";

            $verdad = true;

        }catch (Exception $exc){
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
    }

}