<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Contratos.php");
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlConsultaDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }


    public function guardarContrato(Contratos $contrato)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $id_Cliente = $contrato->getIdCliente();
            $totalPrestamo = $contrato->getTotalPrestamo();
            $totalAvaluo = $contrato->getTotalAvaluo();
            $diasAlm = $contrato->getDiasAlmonedaValue();
            $cotitular = $contrato->getCotitular();
            $beneficiario = $contrato->getBeneficiario();
            $plazo = $contrato->getPlazo();
            $periodo = $contrato->getPeriodo();
            $tipoInteres = $contrato->getTipoInteres();
            $tasa = $contrato->getTasa();
            $alm = $contrato->getAlm();
            $seguro = $contrato->getSeguro();
            $iva = $contrato->getIva();
            $dias = $contrato->getDias();
            $tipoFormulario = $contrato->getIdTipoFormulario();
            $aforo = $contrato->getAforo();
            $fechaCreacion = date('Y-m-d H:i:s');
            $fecha_vencimiento = $contrato->getFechaVencimiento();
            $fecha_almoneda = $contrato->getFechaAlmoneda();
            $idCierreCaja = $_SESSION['idCierreCaja'];
            //tipoContrato (Articulos = 1, Autos = 2,)
            $tipoContrato = 1;
            $fisico = 1;
            $fecha_fisico_ini = $fechaCreacion;
            $fecha_fisico_fin = $fecha_almoneda;
            $suma_InteresPrestamo = $contrato->getSumaInteresPrestamo();;
            $total_Intereses = $contrato->getTotalIntereses();
            $AvaluoLetra = $contrato->getTotalAvaluoLetra();
            $id_cat_estatus = 1;


            $insertaContrato = "INSERT INTO contratos_tbl
                (id_Cliente, total_Prestamo,total_Avaluo,avaluo_Letra, suma_InteresPrestamo,total_Interes,diasAlm, cotitular,
                 beneficiario, plazo,periodo,tipoInteres,tasa, alm,seguro,iva,dias, id_Formulario,Aforo, fecha_creacion,
                 fecha_vencimiento,fecha_almoneda,tipoContrato,id_cierreCaja,fisico,fecha_fisico_ini,fecha_fisico_fin,id_cat_estatus) VALUES 
                ( $id_Cliente, $totalPrestamo ,$totalAvaluo,'$AvaluoLetra',$suma_InteresPrestamo,$total_Intereses,$diasAlm,'$cotitular','$beneficiario',
                  $plazo,'$periodo','$tipoInteres',$tasa,$alm,$seguro,$iva,$dias,$tipoFormulario,$aforo,'$fechaCreacion','$fecha_vencimiento',
                  '$fecha_almoneda', $tipoContrato,$idCierreCaja,$fisico,'$fecha_fisico_ini','$fecha_fisico_fin',$id_cat_estatus)";
            if ($ps = $this->conexion->prepare($insertaContrato)) {
                if ($ps->execute()) {
                    $buscarContrato = "select max(id_Contrato) as UltimoContrato from contratos_tbl where id_cierreCaja = $idCierreCaja";
                    $statement = $this->conexion->query($buscarContrato);
                    $encontro = $statement->num_rows;
                    if ($encontro > 0) {
                        $fila = $statement->fetch_object();
                        $UltimoContrato = $fila->UltimoContrato;
                        $verdad = $UltimoContrato;
                    }
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
        //return $verdad;
        echo $verdad;
    }

    public function actualizarArticulo($contrato, $idSerieContrato)
    {
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {
            $idCierreCaja = $_SESSION['idCierreCaja'];

            $updateArticulo = "UPDATE articulo_tbl SET id_Contrato=$contrato,
                                id_SerieContrato = '$idSerieContrato' 
                                WHERE id_Contrato=0 and id_cierreCaja=$idCierreCaja";
            if ($ps = $this->conexion->prepare($updateArticulo)) {
                if ($ps->execute()) {
                    $verdad = mysqli_stmt_affected_rows($ps);
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
        //return $verdad;
        echo $verdad;
    }

    public function articulosObsoletos()
    {
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        $idCierreCaja = $_SESSION['idCierreCaja'];

        try {
            $eliminarArticulo = "DELETE FROM articulo_tbl WHERE id_Contrato = 0 and id_cierreCaja=$idCierreCaja ";

            if ($this->conexion->query($eliminarArticulo) === TRUE) {
                $verdad = 1;
            } else {
                $verdad = 2;
            }
        } catch (Exception $exc) {
            $verdad = 4;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        //return $verdad;
        echo $verdad;
    }

    public function sqlBuscarDetalleVenta($idVentaBusqueda)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];

            $buscar = "SELECT  Cli.id_Cliente AS Cliente, CONCAT (Cli.apellido_Pat, '/',Cli.apellido_Mat,'/', Cli.nombre) as NombreCompleto,
                        CONCAT(Cli.calle, ', ',Cli.num_interior,', ', Cli.num_exterior, ', ',Cli.localidad, ', ', Cli.municipio, ', ', CatEst.descripcion ) AS direccionCompleta
                        FROM contrato_baz_mov_tbl as Con 
                        INNER JOIN cliente_tbl AS Cli on Con.cliente = Cli.id_Cliente
                         INNER JOIN cat_estado as CatEst on Cli.estado = CatEst.id_Estado
                        WHERE Con.id_Bazar =$idVentaBusqueda AND Con.sucursal= $sucursal";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Cliente" => $row["Cliente"],
                        "NombreCompleto" => $row["NombreCompleto"],
                        "direccionCompleta" => $row["direccionCompleta"]
                    ];
                    array_push($datos, $data);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($datos);
        //echo json_encode($datos);
    }

    public function sqlVentaArticulos($idVentaBusqueda)
    {
        $datos = array();
        $sucursal = $_SESSION["sucursal"];

        try {
            $buscar = "SELECT ART.id_serie, ART.descripcionCorta,ART.vitrina, ART.vitrinaVenta  
                        FROM articulo_bazar_tbl ART
                        INNER JOIN bit_ventas as VEN ON ART.id_ArticuloBazar = VEN.id_ArticuloBazar
                        WHERE VEN.id_Bazar = $idVentaBusqueda AND VEN.sucursal = $sucursal";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_serie" => $row["id_serie"],
                        "descripcionCorta" => $row["descripcionCorta"],
                        "vitrina" => $row["vitrina"],
                        "vitrinaVenta" => $row["vitrinaVenta"],

                    ];
                    array_push($datos, $data);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($datos);
        //echo json_encode($datos);
    }


    public function sqlBuscarVentaDetalle($idVentaBusqueda)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT id_Bazar, DATE_FORMAT(fecha_Creacion,'%d-%m-%Y') AS FechaCreacion,
                        subTotal,iva,descuento_Venta,total,tipo_movimiento
                        FROM contrato_baz_mov_tbl 
                        WHERE id_Bazar= $idVentaBusqueda AND sucursal= $sucursal ORDER BY id_Bazar";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Bazar" => $row["id_Bazar"],
                        "FechaCreacion" => $row["FechaCreacion"],
                        "subTotal" => $row["subTotal"],
                        "ivaVenta" => $row["iva"],
                        "descuento_Venta" => $row["descuento_Venta"],
                        "totalVenta" => $row["total"],
                        "tipo_movimientoVenta" => $row["tipo_movimiento"],

                    ];
                    array_push($datos, $data);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($datos);
    }

    public function sqlBuscarVentaNombre($idClienteConsulta)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT id_Bazar, DATE_FORMAT(fecha_Creacion,'%d-%m-%Y') AS FechaCreacion,
                        subTotal,iva,descuento_Venta,total,tipo_movimiento
                        FROM contrato_baz_mov_tbl 
                        WHERE cliente= $idClienteConsulta AND sucursal= $sucursal ORDER BY id_Bazar";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Bazar" => $row["id_Bazar"],
                        "FechaCreacion" => $row["FechaCreacion"],
                        "subTotal" => $row["subTotal"],
                        "ivaVenta" => $row["iva"],
                        "descuento_Venta" => $row["descuento_Venta"],
                        "totalVenta" => $row["total"],
                        "tipo_movimientoVenta" => $row["tipo_movimiento"],

                    ];
                    array_push($datos, $data);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo json_encode($datos);
    }

    public function sqlBuscarVentaFechas($fechaInicio, $fechaFinal)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT id_Bazar, DATE_FORMAT(fecha_Creacion,'%d-%m-%Y') AS FechaCreacion,
                        subTotal,iva,descuento_Venta,total,tipo_movimiento
                        FROM contrato_baz_mov_tbl 
                        WHERE fecha_Creacion BETWEEN '$fechaInicio' AND '$fechaFinal' AND tipo_movimiento=0 AND sucursal= $sucursal ORDER BY id_Bazar";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_Bazar" => $row["id_Bazar"],
                        "FechaCreacion" => $row["FechaCreacion"],
                        "subTotal" => $row["subTotal"],
                        "ivaVenta" => $row["iva"],
                        "descuento_Venta" => $row["descuento_Venta"],
                        "totalVenta" => $row["total"],
                        "tipo_movimientoVenta" => $row["tipo_movimiento"],

                    ];
                    array_push($datos, $data);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($datos);
    }

}