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


class sqlReportesDAO
{

    protected $error;
    protected $conexion;
    protected $db;

    function __construct()
    {
        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    public function reporteRefrendo($tipoReporte)
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

}