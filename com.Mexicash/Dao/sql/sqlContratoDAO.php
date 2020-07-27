<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Contrato.php");
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');

class sqlContratoDAO
{

    protected $conexion;
    protected $db;


    public function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }


    public function guardarContrato(Contrato $contrato)
    {
        // TODO: Implement guardaCiente() method.
        try {

            $id_Cliente = $contrato->getIdCliente();
            $totalPrestamo = $contrato->getTotalPrestamo();
            $totalAvaluo = $contrato->getTotalAvaluo();
            $totalInteres = $contrato->getTotalIntereses();
            $sumaInteresPrestamo = $contrato->getSumaInteresPrestamo();
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
            $id_cat_estatus = 1;


            $insertaContrato = "INSERT INTO contratos_tbl
                (id_Cliente, total_Prestamo,total_Avaluo, diasAlm, cotitular,
                 beneficiario, plazo,periodo,tipoInteres,tasa, alm,seguro,iva,dias, id_Formulario,Aforo, fecha_creacion,
                 fecha_vencimiento,fecha_almoneda,tipoContrato,id_cierreCaja,fisico,fecha_fisico_ini,fecha_fisico_fin,id_cat_estatus) VALUES 
                ( $id_Cliente, $totalPrestamo ,$totalAvaluo,$diasAlm,'$cotitular','$beneficiario',
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
                                WHERE id_Contrato='' and id_cierreCaja=$idCierreCaja";
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
            $eliminarArticulo = "DELETE FROM articulo_tbl WHERE id_Contrato = '' and id_cierreCaja=$idCierreCaja ";

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

    public function buscarDetalleContrato($idContratoBusqueda, $tipoContratoGlobal)
    {
        $datos = array();
        try {
            $buscar = "SELECT  Cli.id_Cliente AS Cliente, CONCAT (Cli.apellido_Pat, '/',Cli.apellido_Mat,'/', Cli.nombre) as NombreCompleto,
                        CONCAT(Cli.calle, ', ',Cli.num_interior,', ', Cli.num_exterior, ', ',Cli.localidad, ', ', Cli.municipio, ', ', CatEst.descripcion ) AS direccionCompleta
                        FROM contratos_tbl as Con 
                        INNER JOIN cliente_tbl AS Cli on Con.id_Cliente = Cli.id_Cliente
                         INNER JOIN cat_estado as CatEst on Cli.estado = CatEst.id_Estado
                        WHERE Con.id_Contrato =" . $idContratoBusqueda . " AND Con.tipoContrato =" . $tipoContratoGlobal;
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

    public function buscarDetalleContArticulo($idContratoBusqueda, $tipoContratoGlobal)
    {
        $datos = array();
        $sucursal = $_SESSION["sucursal"];

        try {
            $buscar = "SELECT  Con.id_Formulario AS Formulario,Art.id_SerieArticulo,
                         ET.descripcion AS TipoElectronico, EM.descripcion AS MarcaElectronico,
                        EMOD.descripcion AS ModeloElectronico,
                        Art.detalle AS Detalle, TA.descripcion AS TipoMetal, TK.descripcion as Kilataje,
                        TC.descripcion as Calidad FROM contratos_tbl as Con 
                        INNER JOIN cliente_tbl AS Cli on Con.id_Cliente = Cli.id_Cliente
                        INNER JOIN articulo_tbl as Art on Con.id_Contrato =  Art.id_Contrato
                        INNER JOIN cat_estado ON Cli.estado = cat_estado.id_Estado
                        LEFT JOIN cat_electronico_tipo as ET on Art.tipo = ET.id_tipo
                        LEFT JOIN cat_electronico_marca as EM on Art.marca = EM.id_marca
                        LEFT JOIN cat_electronico_modelo as EMOD on Art.modelo = EMOD.id_modelo
                        LEFT JOIN cat_tipoarticulo as TA on Art.tipo = TA.id_tipo
                        LEFT JOIN cat_kilataje as TK on Art.kilataje = TK.id_Kilataje
                        LEFT JOIN cat_calidad as TC on Art.calidad = TC.id_calidad
                        WHERE Con.id_Contrato =" . $idContratoBusqueda . " AND Con.tipoContrato =" . $tipoContratoGlobal;
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Formulario" => $row["Formulario"],
                        "id_SerieArticulo" => $row["id_SerieArticulo"],
                        "TipoElectronico" => $row["TipoElectronico"],
                        "MarcaElectronico" => $row["MarcaElectronico"],
                        "ModeloElectronico" => $row["ModeloElectronico"],
                        "TipoMetal" => $row["TipoMetal"],
                        "Kilataje" => $row["Kilataje"],
                        "Calidad" => $row["Calidad"],
                        "Detalle" => $row["Detalle"]

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

    public function buscarDetalleContAuto($idContratoBusqueda, $tipoContratoGlobal)
    {
        $datos = array();
        $sucursal = $_SESSION["sucursal"];

        try {
            $buscar = "SELECT  Con.id_Formulario AS Formulario,Auto.marca as Marca,Auto.modelo as Modelo,Auto.año as Anio, Art.descripcion as Vehiculo,
                        COl.descripcion as ColorAuto, Auto.observaciones as Obs 
                        FROM auto_tbl as Auto 
                        INNER JOIN contratos_tbl AS Con on Auto.id_Contrato = Con.id_Contrato 
                        LEFT JOIN cat_color as COl on Auto.color = COl.id_Color
                        LEFT JOIN cat_articulos as Art on Auto.tipo_Vehiculo = Art.id_Cat_Articulo
                        WHERE Auto.id_Contrato = '$idContratoBusqueda' AND Con.tipoContrato =" . $tipoContratoGlobal;
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Formulario" => $row["Formulario"],
                        "Marca" => $row["Marca"],
                        "Modelo" => $row["Modelo"],
                        "Vehiculo" => $row["Vehiculo"],
                        "Anio" => $row["Anio"],
                        "ColorAuto" => $row["ColorAuto"],
                        "Obs" => $row["Obs"]

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

    public function buscarContratoDetalle($idContratoBusqueda, $tipoContratoGlobal)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT ConM.id_Contrato AS Contrato,DATE_FORMAT(fecha_Movimiento,'%d-%m-%Y') AS FechaCreacion,
                        CMov.descripcion as Movimiento, ConM.id_movimiento AS idMovimiento, 
                        s_prestamo_nuevo AS Prestamo,prestamo_actual  AS PrestamoActual,e_abono AS Abono,
                        e_intereses AS InteresMovimiento,e_moratorios AS MoratoriosMov, 
                        s_descuento_aplicado AS DescuentoMov,e_pagoDesempeno AS PagoMov, 
                        CONCAT(tipoInteres, ' ' ,periodo ,' ' ,plazo) AS PlazoMov, 
                        e_costoContrato AS CostoContrato,tipo_movimiento AS MovimientoTipo 
                        FROM contrato_mov_tbl  as ConM
                        INNER JOIN contratos_tbl Con on ConM.id_contrato = Con.id_Contrato 
                        INNER JOIN cat_movimientos CMov on tipo_movimiento = CMov.id_Movimiento 
                        WHERE ConM.id_Contrato= $idContratoBusqueda AND tipo_Contrato  =$tipoContratoGlobal AND ConM.sucursal= $sucursal ORDER BY Contrato";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Contrato" => $row["Contrato"],
                        "FechaCreacion" => $row["FechaCreacion"],
                        "Movimiento" => $row["Movimiento"],
                        "idMovimiento" => $row["idMovimiento"],
                        "Prestamo" => $row["Prestamo"],
                        "PrestamoActual" => $row["PrestamoActual"],
                        "Abono" => $row["Abono"],
                        "Interes" => $row["InteresMovimiento"],
                        "Moratorios" => $row["MoratoriosMov"],
                        "Descuento" => $row["DescuentoMov"],
                        "Pago" => $row["PagoMov"],
                        "Plazo" => $row["PlazoMov"],
                        "CostoContrato" => $row["CostoContrato"],
                        "MovimientoTipo" => $row["MovimientoTipo"],

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

    public function buscarContratoDetalleNombre($idClienteConsulta, $tipoContratoGlobal)
    {
        $datos = array();
        $sucursal = $_SESSION["sucursal"];

        try {
            $buscar = "SELECT Mov.id_Contrato AS Contrato,DATE_FORMAT(Mov.fecha_Movimiento,'%d-%m-%Y') AS FechaCreacion,
                       CMov.descripcion as Movimiento, Mov.id_movimiento AS idMovimiento, s_prestamo_nuevo AS Prestamo,
                       prestamo_actual  AS PrestamoActual,
                       e_abono AS Abono, e_intereses AS InteresMovimiento,e_moratorios AS MoratoriosMov, 
                       s_descuento_aplicado AS DescuentoMov, e_pagoDesempeno AS PagoMov,
                       CONCAT(Con.tipoInteres, ' ' ,Con.periodo ,' ' ,Con.plazo) AS PlazoMov, e_costoContrato AS CostoContrato,
                       tipo_movimiento AS MovimientoTipo  
                       FROM contrato_mov_tbl Mov 
                       INNER JOIN cat_movimientos CMov on tipo_movimiento = CMov.id_Movimiento 
                       INNER JOIN contratos_tbl Con on Mov.id_contrato = Con.id_Contrato 
                       WHERE Con.id_Cliente= $idClienteConsulta AND tipo_Contrato =$tipoContratoGlobal AND Mov.sucursal=$sucursal ORDER BY Mov.id_Contrato";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Contrato" => $row["Contrato"],
                        "FechaCreacion" => $row["FechaCreacion"],
                        "Movimiento" => $row["Movimiento"],
                        "idMovimiento" => $row["idMovimiento"],
                        "Prestamo" => $row["Prestamo"],
                        "PrestamoActual" => $row["PrestamoActual"],
                        "Abono" => $row["Abono"],
                        "Interes" => $row["InteresMovimiento"],
                        "Moratorios" => $row["MoratoriosMov"],
                        "Descuento" => $row["DescuentoMov"],
                        "Pago" => $row["PagoMov"],
                        "Plazo" => $row["PlazoMov"],
                        "CostoContrato" => $row["CostoContrato"],
                        "MovimientoTipo" => $row["MovimientoTipo"],


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

    public function buscarContratoFechas($fechaInicio, $fechaFinal, $tipoContratoGlobal)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT Mov.id_contrato AS Contrato,DATE_FORMAT(fecha_Movimiento,'%d-%m-%Y') AS FechaCreacion,CMov.descripcion as Movimiento,
                        Mov.id_movimiento AS idMovimiento, s_prestamo_nuevo AS Prestamo,
                        prestamo_actual  AS PrestamoActual,e_abono AS Abono,
                        e_intereses AS InteresMovimiento,e_moratorios AS MoratoriosMov, s_descuento_aplicado AS DescuentoMov,
                        e_pagoDesempeno AS PagoMov, CONCAT(tipoInteres, ' ' ,periodo ,' ' ,plazo) AS PlazoMov, e_costoContrato AS CostoContrato,tipo_movimiento AS MovimientoTipo 
                        FROM contrato_mov_tbl as Mov
                        INNER JOIN contratos_tbl Con on Mov.id_contrato = Con.id_Contrato 
                        INNER JOIN cat_movimientos CMov on tipo_movimiento = CMov.id_Movimiento 
                        WHERE tipo_contrato=$tipoContratoGlobal  AND sucursal=$sucursal AND  fecha_Movimiento BETWEEN '$fechaInicio' AND '$fechaFinal' 
                        ORDER BY Mov.id_Contrato";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "Contrato" => $row["Contrato"],
                        "FechaCreacion" => $row["FechaCreacion"],
                        "Movimiento" => $row["Movimiento"],
                        "idMovimiento" => $row["idMovimiento"],
                        "Prestamo" => $row["Prestamo"],
                        "PrestamoActual" => $row["PrestamoActual"],
                        "Abono" => $row["Abono"],
                        "Interes" => $row["InteresMovimiento"],
                        "Moratorios" => $row["MoratoriosMov"],
                        "Descuento" => $row["DescuentoMov"],
                        "Pago" => $row["PagoMov"],
                        "Plazo" => $row["PlazoMov"],
                        "CostoContrato" => $row["CostoContrato"],
                        "MovimientoTipo" => $row["MovimientoTipo"],


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