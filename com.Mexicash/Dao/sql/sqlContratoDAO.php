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
            $totalInteres = $contrato->getTotalIntereses();
            $sumaInteresPrestamo = $contrato->getSumaInteresPrestamo();
            $beneficiario = $contrato->getBeneficiario();
            $cotitular = $contrato->getCotitular();
            $plazo = $contrato->getPlazo();
            $tasa = $contrato->getTasa();
            $alm = $contrato->getAlm();
            $seguro = $contrato->getSeguro();
            $iva = $contrato->getIva();
            $dias = $contrato->getDias();
            $tipoFormulario = $contrato->getTipoFormulario();
            $aforo = $contrato->getAforo();
            $diasAlm = $contrato->getDiasAlm();
            $fechaCreacion = date('Y-m-d H:i:s');
            $idCierreCaja = $_SESSION['idCierreCaja'];
            //tipoContrato (Articulos = 1, Autos = 2,)
            $tipoContrato = 1;


            $insertaContrato = "INSERT INTO contrato_tbl " .
                "(id_Cliente, total_Prestamo,total_Interes, suma_InteresPrestamo, diasAlm, cotitular, beneficiario, plazo,tasa,
                  alm,seguro,iva,dias, id_Formulario,aforo, fecha_creacion,tipoContrato,id_cierreCaja) VALUES " .
                "( $id_Cliente, $totalPrestamo ,$totalInteres,$sumaInteresPrestamo,$diasAlm,'" . $cotitular . "','" . $beneficiario . "',
                $plazo,$tasa,$alm,$seguro,$iva,$dias,$tipoFormulario,$aforo,'.$fechaCreacion.',$tipoContrato,$idCierreCaja)";
            if ($ps = $this->conexion->prepare($insertaContrato)) {
                if ($ps->execute()) {
                    $buscarContrato = "select max(id_Contrato) as UltimoContrato from contrato_tbl where id_cierreCaja = $idCierreCaja";
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

    public function actualizarArticulo($contrato,$idSerieContrato)
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
                        FROM contrato_tbl as Con 
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
            $buscar = "SELECT  Con.id_Formulario AS Formulario,
                         ET.descripcion AS TipoElectronico, EM.descripcion AS MarcaElectronico,
                        EMOD.descripcion AS ModeloElectronico,
                        Art.detalle AS Detalle, TA.descripcion AS TipoMetal, TK.descripcion as Kilataje,
                        TC.descripcion as Calidad FROM contrato_tbl as Con 
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
                        INNER JOIN contrato_tbl AS Con on Auto.id_Contrato = Con.id_Contrato 
                        INNER JOIN cat_color as COl on Auto.color = COl.id_Color
                        INNER JOIN cat_articulos as Art on Auto.tipo_Vehiculo = Art.id_Cat_Articulo
                        WHERE Auto.id_Contrato = '$idContratoBusqueda' AND Con.tipoContrato =" . $tipoContratoGlobal . " AND Con.sucursal=" . $sucursal;

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
            $buscar = "SELECT id_Contrato AS Contrato,DATE_FORMAT(fecha_Creacion,'%d-%m-%Y') AS FechaCreacion,CMov.descripcion as Movimiento,
                        contratomovimientos_tbl.id_movimiento AS idMovimiento, s_prestamo_nuevo AS Prestamo,
                         prestamo_actual  AS PrestamoActual,e_abono AS Abono,
                        e_intereses AS InteresMovimiento,e_moratorios AS MoratoriosMov, s_descuento_aplicado AS DescuentoMov,
                        e_pagoDesempeno AS PagoMov, CONCAT(tipoInteres, ' ' ,periodo ,' ' ,plazo) AS PlazoMov, e_costoContrato AS CostoContrato,tipo_movimiento AS MovimientoTipo 
                        FROM contratomovimientos_tbl 
                        INNER JOIN cat_movimientos CMov on tipo_movimiento = CMov.id_Movimiento 
                        WHERE id_Contrato= $idContratoBusqueda AND tipo_Contrato  =$tipoContratoGlobal AND sucursal= $sucursal";
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
            $buscar = "SELECT Mov.id_Contrato AS Contrato,DATE_FORMAT(Mov.fecha_Creacion,'%d-%m-%Y') AS FechaCreacion,
                       CMov.descripcion as Movimiento, Mov.id_movimiento AS idMovimiento, s_prestamo_nuevo AS Prestamo,
                       prestamo_actual  AS PrestamoActual,
                       e_abono AS Abono, e_intereses AS InteresMovimiento,e_moratorios AS MoratoriosMov, 
                       s_descuento_aplicado AS DescuentoMov, e_pagoDesempeno AS PagoMov,
                       CONCAT(tipoInteres, ' ' ,periodo ,' ' ,Mov.plazo) AS PlazoMov, e_costoContrato AS CostoContrato,tipo_movimiento AS MovimientoTipo  
                       FROM contratomovimientos_tbl Mov 
                       INNER JOIN cat_movimientos CMov on tipo_movimiento = CMov.id_Movimiento 
                       INNER JOIN contrato_tbl Con on Mov.id_contrato = Con.id_Contrato 
                       WHERE Con.id_Cliente= $idClienteConsulta AND tipo_Contrato =$tipoContratoGlobal AND Mov.sucursal=$sucursal";
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

    public function buscarContratoFechas($fechaInicio,$fechaFinal, $tipoContratoGlobal)
{
    $datos = array();
    try {
        $sucursal = $_SESSION["sucursal"];
        $buscar = "SELECT id_Contrato AS Contrato,DATE_FORMAT(fecha_Creacion,'%d-%m-%Y') AS FechaCreacion,CMov.descripcion as Movimiento,
                        contratomovimientos_tbl.id_movimiento AS idMovimiento, s_prestamo_nuevo AS Prestamo,
                        prestamo_actual  AS PrestamoActual,e_abono AS Abono,
                        e_intereses AS InteresMovimiento,e_moratorios AS MoratoriosMov, s_descuento_aplicado AS DescuentoMov,
                        e_pagoDesempeno AS PagoMov, CONCAT(tipoInteres, ' ' ,periodo ,' ' ,plazo) AS PlazoMov, e_costoContrato AS CostoContrato,tipo_movimiento AS MovimientoTipo 
                        FROM contratomovimientos_tbl 
                        INNER JOIN cat_movimientos CMov on tipo_movimiento = CMov.id_Movimiento 
                        WHERE tipo_contrato=$tipoContratoGlobal  AND sucursal=$sucursal AND  fecha_Creacion BETWEEN '$fechaInicio' AND '$fechaFinal'";
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

    /*public function buscarContrato($contrato, $nombre, $celular)
    {
        $datos = array();
        try {
            $buscar = "";
            if ($nombre == 0) {
                $buscar = "select c.id_Contrato, c.id_Cliente, c.id_Interes, c.folio, c.fecha_creacion, c.fecha_Vencimiento, c.total_Avaluo, c.total_Prestamo, 
                c.abono, c.pago, c.fecha_Alm, c.fecha_Movimiento, c.id_Estatus, a.detalle, c.observaciones, a.cantidad 
                from contrato_tbl as c inner join articulo_tbl as a on c.id_Contrato = a.id_Contrato where c.id_Contrato = " . $contrato . ";";
            }
            if ($contrato == 0) {
                $buscar = "select c.id_Contrato, c.id_Cliente, c.id_Interes, c.folio, c.fecha_creacion, c.fecha_Vencimiento, c.total_Avaluo, c.total_Prestamo, 
                c.abono, c.pago, c.fecha_Alm, c.fecha_Movimiento, c.id_Estatus, a.detalle, c.observaciones, a.cantidad 
                from contrato_tbl as c inner join articulo_tbl as a on c.id_Contrato = a.id_Contrato inner join cliente_tbl as cl on cl.id_Cliente = c.id_Cliente 
                where concat(cl.nombre, ' ', cl.apellido_Pat, ' ', cl.apellido_Mat) = '" . $nombre . "' and cl.celular = " . $celular . ";";

            }

            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        //Contrato
                        "id_Contrato" => $row["id_Contrato"],
                        "id_Cliente" => $row["id_Cliente"],
                        "id_Interes" => $row["id_Interes"],
                        "folio" => $row["folio"],
                        "fecha_creacion" => $row["fecha_creacion"],
                        "fecha_vencimiento" => $row["fecha_Vencimiento"],
                        "total_avaluo" => $row["total_Avaluo"],
                        "total_prestamo" => $row["total_Prestamo"],
                        "abono" => $row["abono"],
                        "pago" => $row["pago"],
                        "fecha_alm" => $row["fecha_Alm"],
                        "fecha_movimiento" => $row["fecha_Movimiento"],
                        "id_Estatus" => $row["id_Estatus"],

                        //Articulo
                        "detalle" => $row["detalle"],
                        "observaciones" => $row["observaciones"],
                        "cantidad" => $row["cantidad"]
                    ];

                    array_push($datos, $data);
                }
            } else {
                echo "No se ejecuto buscarContrato-sqlContratoDAO";
            }

        } catch (Exception $exc) {
            $verdad = 4;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        return $datos;
    }*/

}