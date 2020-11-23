<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlMigracionDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    //Busqueda de Contrato
    function sqlBuscarIdContrato()
    {
        $idBazar = 0;
        //Modifique los estatus de usuario
        try {

                $sucursal = $_SESSION["sucursal"];
                $IdCompraMax= 0;
                $buscar = "SELECT MAX(id_Contrato) as UltimaCompra FROM articulo_bazar_tbl 
                            WHERE sucursal=$sucursal  and compra_mig=1";
                $statement = $this->conexion->query($buscar);
                $encontro = $statement->num_rows;
                if ($encontro > 0) {
                    $fila = $statement->fetch_object();
                    $IdCompraMax = $fila->UltimaCompra;
                }
                $IdCompraMax++;

        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $IdCompraMax;
    }

    function sqlBuscarValidarContrato($idContratoSerie,$checkCompraGlb)
    {
        $idBazar = 0;
        //Modifique los estatus de usuario
        try {

            $sucursal = $_SESSION["sucursal"];
            $IdCompraMax= 0;
            $buscar = "SELECT id_Contrato FROM articulo_bazar_tbl WHERE sucursal=$sucursal
            AND id_contrato=$idContratoSerie";
            if($checkCompraGlb!=0){
                $buscar .= " AND compra_mig=1";
            }

            $statement = $this->conexion->query($buscar);
            $encontro = $statement->num_rows;
            if ($encontro > 0) {
                $fila = $statement->fetch_object();
                $IdCompraMax = $fila->id_Contrato;
            }

        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $IdCompraMax;
    }

    function sqlGuardarArticuloMig($idTipoEnviar, $idContrato, $idFolioMig,
                                    $idKilataje, $idCalidad, $idPiezas, $idCantidad,
                                   $idPeso, $idPiedras, $idPesoPiedra,
                                   $idMarca, $idModelo, $idSerie, $idIMEI, $idPrestamoMig, $idAvaluoMig,
                                   $idVitrinaMig, $descDetalle, $idObs,
                                   $SerieBazar, $id_serieTipo, $tipo_movimiento, $descripcionCorta,$tipoCMB,
                                   $checkCompraGlb)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $idCierreCaja = $_SESSION['idCierreCaja'];
            $sucursal = $_SESSION["sucursal"];

            $descripcionCorta = strtoupper($descripcionCorta);
            $idObs = strtoupper($idObs);
            $descDetalle = strtoupper($descDetalle);

            $insert = "INSERT INTO articulo_bazar_tbl " .
                    "(id_Contrato, id_serie,id_serieTipo,tipo_movimiento,tipoArticulo,tipo, " .
                    " kilataje, calidad,piezas, cantidad, peso, piedras, peso_Piedra,
                      marca, modelo, num_Serie,IMEI,prestamo,avaluo,vitrina, " .
                    " vitrinaVenta,observaciones, detalle,descripcionCorta,sucursal,id_cierreCaja,compra_mig,codigo_mig)  VALUES " .
                    " ($idContrato,'$SerieBazar',$id_serieTipo,$tipo_movimiento,$idTipoEnviar,$tipoCMB,$idKilataje,
                        $idCalidad,$idPiezas,$idCantidad,$idPeso,$idPiedras,$idPesoPiedra,$idMarca,$idModelo,$idSerie
                        $idIMEI,$idPrestamoMig,$idAvaluoMig,$idVitrinaMig,$idVitrinaMig,$idObs,$descDetalle
                         $descripcionCorta,$sucursal,$idCierreCaja,$checkCompraGlb,$idFolioMig)";
            if ($ps = $this->conexion->prepare($insert)) {
                if ($ps->execute()) {
                    $verdad =  mysqli_stmt_affected_rows($ps);
                } else {
                    $verdad = -1;
                }
            } else {
                $verdad = -1;
            }

        } catch (Exception $exc) {
            $verdad = -1;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
    }

}