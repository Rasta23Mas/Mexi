<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Usuario.php");
include_once(BASE_PATH . "Conexion.php");
include_once(SERVICIOS_PATH . "Errores.php");
include_once(DAO_PATH . "UsuarioDAO.php");
date_default_timezone_set('America/Mexico_City');


class sqlCancelarDAO
{

    protected $error;
    protected $conexion;
    protected $db;

    function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    function empenoCancelar($tipoMovimiento, $tipoContratoGlobal)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $fechaHoy = date('Y-m-d');

            $buscar = "SELECT Mov.id_Contrato AS Contrato,DATE_FORMAT(Mov.fecha_Creacion,'%d-%m-%Y') AS FechaCreacion,CMov.descripcion as Movimiento,
                        Mov.id_movimiento AS idMovimiento, Mov.s_prestamo_nuevo AS Prestamo,
                        Mov.prestamo_actual  AS PrestamoActual,Mov.e_abono AS Abono,
                        Mov.e_intereses AS InteresMovimiento,Mov.e_moratorios AS MoratoriosMov,
                        Mov.s_descuento_aplicado AS DescuentoMov,Mov.e_pagoDesempeno AS PagoMov,
                        CONCAT(Mov.tipoInteres, ' ' ,Mov.periodo ,' ' ,Mov.plazo) AS PlazoMov,
                        Mov.e_costoContrato AS CostoContrato,Mov.tipo_movimiento AS MovimientoTipo
                        FROM contratomovimientos_tbl Mov
                        INNER JOIN cat_movimientos CMov on tipo_movimiento = CMov.id_Movimiento 
                        INNER JOIN contrato_tbl Con on Mov.id_Contrato = Con.id_Contrato 
                        WHERE Mov.tipo_Contrato = $tipoContratoGlobal AND Mov.tipo_movimiento  !=20 AND Mov.tipo_movimiento  =$tipoMovimiento AND Mov.sucursal= $sucursal
                        AND DATE_FORMAT(Mov.fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaHoy' AND '$fechaHoy'";

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

    function desempenoCancelar($tipoMovimiento, $tipoContratoGlobal)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $fechaHoy = date('Y-m-d');

            $buscar = "SELECT Mov.id_Contrato AS Contrato,DATE_FORMAT(Mov.fecha_Creacion,'%d-%m-%Y') AS FechaCreacion,CMov.descripcion as Movimiento,
                        Mov.id_movimiento AS idMovimiento, Mov.s_prestamo_nuevo AS Prestamo,
                         Mov.prestamo_actual  AS PrestamoActual,Mov.e_abono AS Abono,
                        Mov.e_intereses AS InteresMovimiento,Mov.e_moratorios AS MoratoriosMov, Mov.s_descuento_aplicado AS DescuentoMov,
                        Mov.e_pagoDesempeno AS PagoMov, CONCAT(Mov.tipoInteres, ' ' ,Mov.periodo ,' ' ,Mov.plazo) AS PlazoMov, Mov.e_costoContrato AS CostoContrato,Mov.tipo_movimiento AS MovimientoTipo
                        FROM contratomovimientos_tbl Mov
                        INNER JOIN cat_movimientos CMov on tipo_movimiento = CMov.id_Movimiento 
                        INNER JOIN contrato_tbl Con on Mov.id_Contrato = Con.id_Contrato 
                        WHERE Mov.tipo_Contrato = $tipoContratoGlobal AND Mov.sucursal= $sucursal AND Mov.tipo_movimiento  !=20 AND Mov.tipo_movimiento  =$tipoMovimiento OR Mov.tipo_movimiento  =21
                                AND DATE_FORMAT(Mov.fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaHoy' AND '$fechaHoy'";
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

    function todosCancelar($tipoContratoGlobal)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $fechaHoy = date('Y-m-d');
            $buscar = "SELECT Mov.id_Contrato AS Contrato,DATE_FORMAT(Mov.fecha_Creacion,'%d-%m-%Y') AS FechaCreacion,CMov.descripcion as Movimiento,
                        Mov.id_movimiento AS idMovimiento, Mov.s_prestamo_nuevo AS Prestamo,
                         Mov.prestamo_actual  AS PrestamoActual,Mov.e_abono AS Abono,
                        Mov.e_intereses AS InteresMovimiento,Mov.e_moratorios AS MoratoriosMov, Mov.s_descuento_aplicado AS DescuentoMov,
                        Mov.e_pagoDesempeno AS PagoMov, CONCAT(Mov.tipoInteres, ' ' ,Mov.periodo ,' ' ,Mov.plazo) AS PlazoMov, Mov.e_costoContrato AS CostoContrato,Mov.tipo_movimiento AS MovimientoTipo
                        FROM contratomovimientos_tbl Mov
                        INNER JOIN cat_movimientos CMov on tipo_movimiento = CMov.id_Movimiento 
                        INNER JOIN contrato_tbl Con on Mov.id_Contrato = Con.id_Contrato 
                        WHERE Mov.tipo_Contrato = $tipoContratoGlobal AND Mov.tipo_movimiento  !=20 AND Mov.sucursal= $sucursal
                        AND DATE_FORMAT(Mov.fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaHoy' AND '$fechaHoy'";
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

    function busquedaEstatus($Contrato)
    {
        $datos = array();
        try {
            $buscar = "SELECT  Con.id_movimiento as IdMovimiento,tipo_movimiento,CMov.descripcion as Movimiento FROM contratomovimientos_tbl AS Con
                        INNER JOIN cat_movimientos CMov on tipo_movimiento = CMov.id_Movimiento WHERE id_contrato = $Contrato ";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "IdMovimiento" => $row["IdMovimiento"],
                        "tipo_movimiento" => $row["tipo_movimiento"],
                        "MovimientoDesc" => $row["Movimiento"],

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

    function cancelarMovimiento($tipo_movimiento, $movimientoCancelado, $IdMovimiento)
    {
        try {
            $updateMovimiento = "UPDATE contratomovimientos_tbl SET
            tipo_movimiento = $movimientoCancelado
            WHERE id_movimiento = $IdMovimiento";
            if ($ps = $this->conexion->prepare($updateMovimiento)) {
                if ($ps->execute()) {
                    if ($tipo_movimiento == 3 || $tipo_movimiento == 7) {
                        $verdad = mysqli_stmt_affected_rows($ps);
                    } else {
                        $updatePagos = "UPDATE bit_pagos SET
                        estatus = $movimientoCancelado
                        WHERE ultimoMovimiento=$IdMovimiento";
                        if ($ps = $this->conexion->prepare($updatePagos)) {
                            if ($ps->execute()) {
                                $verdad = mysqli_stmt_affected_rows($ps);
                            } else {
                                $verdad = -1;
                            }
                        } else {
                            $verdad = -1;
                        }
                    }
                } else {
                    $verdad = -1;
                }

            } else {
                $verdad = -1;
            }
        } catch
        (Exception $exc) {
            $verdad = -1;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        //return $verdad;
        echo $verdad;
    }

    function cancelarContrato($Contrato, $tipoContratoGlobal)
    {
        try {

            $EstatusAnterior = 20;

            $fechaModificacion = date('Y-m-d H:i:s');
            if ($tipoContratoGlobal == 1) {
                $updateArticulos = "UPDATE articulo_tbl SET  fecha_modificacion = '$fechaModificacion', id_Estatus = $EstatusAnterior 
                                WHERE id_Contrato=$Contrato";
            }
            if ($tipoContratoGlobal == 2) {
                $updateArticulos = "UPDATE auto_tbl SET  fecha_modificacion = '$fechaModificacion', id_Estatus = $EstatusAnterior 
                                WHERE id_Contrato=$Contrato";
            }
            if ($ps = $this->conexion->prepare($updateArticulos)) {
                if ($ps->execute()) {
                    $verdad = 1;
                } else {
                    $verdad = -1;
                }
            } else {
                $verdad = -1;
            }
        } catch
        (Exception $exc) {
            $verdad = -1;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
    }

    function cierreCaja()
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $fechaHoy = date('Y-m-d');
            $buscar = "SELECT folio_CierreCaja,id_CierreCaja,id_CierreSucursal,total_Salida,total_Entrada,
                            saldo_Caja,efectivo_Caja,ajuste,usuario,CerradoPorGerente 
                            FROM bit_cierrecaja WHERE estatus = 2 AND DATE(fecha_Creacion) = '$fechaHoy' 
                            and sucursal = $sucursal";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "folio_CierreCaja" => $row["folio_CierreCaja"],
                        "id_CierreCaja" => $row["id_CierreCaja"],
                        "id_CierreSucursal" => $row["id_CierreSucursal"],
                        "total_Salida" => $row["total_Salida"],
                        "total_Entrada" => $row["total_Entrada"],
                        "saldo_Caja" => $row["saldo_Caja"],
                        "efectivo_Caja" => $row["efectivo_Caja"],
                        "ajuste" => $row["ajuste"],
                        "usuario" => $row["usuario"],
                        "CerradoPorGerente" => $row["CerradoPorGerente"],
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

    function cancelarCierreCaja($folio)
    {
        try {
            $estatus = 1;
            $fechaCreacion = date('Y-m-d H:i:s');
            $buscarIdCierre = "Select id_CierreCaja,usuario,sucursal, id_CierreSucursal FROM bit_cierrecaja " .
                " WHERE folio_CierreCaja= $folio";
            $resultado = $this->conexion->query($buscarIdCierre);
            if ($resultado->num_rows > 0) {
                $fila = $resultado->fetch_object();
                $id_CierreCaja = $fila->id_CierreCaja;
                $usuario = $fila->usuario;
                $sucursal = $fila->sucursal;
                $id_CierreSucursal = $fila->id_CierreSucursal;

                $updateCierreCaja = "UPDATE bit_cierrecaja SET estatus = 20
                WHERE folio_CierreCaja = $folio";
                if ($ps = $this->conexion->prepare($updateCierreCaja)) {
                    if ($ps->execute()) {
                        $insertarCierreCaja = "INSERT INTO bit_cierrecaja " .
                            "(id_CierreCaja,usuario,sucursal, id_CierreSucursal, fecha_Creacion, estatus)  VALUES " .
                            "('" . $id_CierreCaja . "','" . $usuario . "','" . $sucursal . "','" . $id_CierreSucursal . "','" . $fechaCreacion . "', '" . $estatus . "' )";
                        if ($ps = $this->conexion->prepare($insertarCierreCaja)) {
                            if ($ps->execute()) {
                                $verdad = 1;
                            } else {
                                $verdad = -1;
                            }
                        } else {
                            $verdad = -1;
                        }
                    } else {
                        $verdad = -1;
                    }
                } else {
                    $verdad = -1;
                }
            } else {
                $verdad = -1;
            }
        } catch
        (Exception $exc) {
            $verdad = -1;
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }
        echo $verdad;
    }

}
