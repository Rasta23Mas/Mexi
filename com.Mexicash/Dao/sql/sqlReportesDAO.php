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
    public function reporteHistorico($fechaIni,$fechaFin)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM, 
                        Con.id_contrato AS CONTRATO,
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Con.total_Prestamo AS PRESTAMO,
                        Con.plazo AS Plazo, Con.periodo as Periodo, Con.tipoInteres as TipoInteres,
                        CONCAT(EM.descripcion,' ', ET.descripcion, ' ',EMOD.descripcion) as ObserElec, 
                        CONCAT(Tipo.descripcion, ' ',Kil.descripcion,' ', Cal.descripcion) as ObserMetal,
                        Aut.observaciones as ObserAuto,
                        CONCAT(Aut.marca, ' ', Aut.modelo) as DetalleAuto, 
                        CONCAT(Art.detalle) as Detalle,
                        Art.tipoArticulo, Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN bit_cierrecaja as Bit on Con.id_cierreCaja = Bit.id_CierreCaja
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato 
                        LEFT JOIN cat_electronico_marca as EM on Art.marca = EM.id_marca
                        LEFT JOIN cat_electronico_modelo as EMOD on Art.modelo = EMOD.id_modelo
                        LEFT JOIN cat_electronico_tipo as ET on Art.tipo = ET.id_tipo
                        LEFT JOIN cat_kilataje as Kil on Art.kilataje = Kil.id_Kilataje
                        LEFT JOIN cat_tipoarticulo as Tipo on Art.tipo = Tipo.id_tipo
                        LEFT JOIN cat_calidad as Cal on Art.calidad = Cal.id_calidad
                        WHERE '$fechaIni' >= Con.fecha_fisico_ini
                        AND '$fechaFin'  <= Con.fecha_fisico_fin
                        AND Bit.sucursal = $sucursal 
                        ORDER BY Form";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "FECHA" => $row["FECHA"],
                        "FECHAVEN" => $row["FECHAVEN"],
                        "FECHAALM" => $row["FECHAALM"],
                        "CONTRATO" => $row["CONTRATO"],
                        "NombreCompleto" => $row["NombreCompleto"],
                        "PRESTAMO" => $row["PRESTAMO"],
                        "Plazo" => $row["Plazo"],
                        "Periodo" => $row["Periodo"],
                        "TipoInteres" => $row["TipoInteres"],
                        "ObserElec" => $row["ObserElec"],
                        "ObserMetal" => $row["ObserMetal"],
                        "ObserAuto" => $row["ObserAuto"],
                        "DetalleAuto" => $row["DetalleAuto"],
                        "Detalle" => $row["Detalle"],
                        "Form" => $row["Form"],
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
    public function reporteInve()
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM, 
                        Con.id_contrato AS CONTRATO,
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Con.total_Prestamo AS PRESTAMO,
                        Con.plazo AS Plazo, Con.periodo as Periodo, Con.tipoInteres as TipoInteres,
                        CONCAT(EM.descripcion,' ', ET.descripcion, ' ',EMOD.descripcion) as ObserElec, 
                        CONCAT(Tipo.descripcion, ' ',Kil.descripcion,' ', Cal.descripcion) as ObserMetal,
                        Aut.observaciones as ObserAuto,
                        CONCAT(Aut.marca, ' ', Aut.modelo) as DetalleAuto, 
                        CONCAT(Art.detalle) as Detalle,
                        Art.tipoArticulo, Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN bit_cierrecaja as Bit on Con.id_cierreCaja = Bit.id_CierreCaja
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato 
                        LEFT JOIN cat_electronico_marca as EM on Art.marca = EM.id_marca
                        LEFT JOIN cat_electronico_modelo as EMOD on Art.modelo = EMOD.id_modelo
                        LEFT JOIN cat_electronico_tipo as ET on Art.tipo = ET.id_tipo
                        LEFT JOIN cat_kilataje as Kil on Art.kilataje = Kil.id_Kilataje
                        LEFT JOIN cat_tipoarticulo as Tipo on Art.tipo = Tipo.id_tipo
                        LEFT JOIN cat_calidad as Cal on Art.calidad = Cal.id_calidad
                        WHERE Con.fisico = 1
                        AND Bit.sucursal = $sucursal 
                        ORDER BY Form";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "FECHA" => $row["FECHA"],
                        "FECHAVEN" => $row["FECHAVEN"],
                        "FECHAALM" => $row["FECHAALM"],
                        "CONTRATO" => $row["CONTRATO"],
                        "NombreCompleto" => $row["NombreCompleto"],
                        "PRESTAMO" => $row["PRESTAMO"],
                        "Plazo" => $row["Plazo"],
                        "Periodo" => $row["Periodo"],
                        "TipoInteres" => $row["TipoInteres"],
                        "ObserElec" => $row["ObserElec"],
                        "ObserMetal" => $row["ObserMetal"],
                        "ObserAuto" => $row["ObserAuto"],
                        "DetalleAuto" => $row["DetalleAuto"],
                        "Detalle" => $row["Detalle"],
                        "Form" => $row["Form"],
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
    public function reporteContratos()
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM, 
                        Con.id_contrato AS CONTRATO,
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Con.total_Prestamo AS PRESTAMO,
                        Con.plazo AS Plazo, Con.periodo as Periodo, Con.tipoInteres as TipoInteres,
                        CONCAT(EM.descripcion,' ', ET.descripcion, ' ',EMOD.descripcion) as ObserElec, 
                        CONCAT(Tipo.descripcion, ' ',Kil.descripcion,' ', Cal.descripcion) as ObserMetal,
                        Aut.observaciones as ObserAuto,
                        CONCAT(Aut.marca, ' ', Aut.modelo) as DetalleAuto, 
                        CONCAT(Art.detalle) as Detalle,
                        Art.tipoArticulo, Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN bit_cierrecaja as Bit on Con.id_cierreCaja = Bit.id_CierreCaja
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato 
                        LEFT JOIN cat_electronico_marca as EM on Art.marca = EM.id_marca
                        LEFT JOIN cat_electronico_modelo as EMOD on Art.modelo = EMOD.id_modelo
                        LEFT JOIN cat_electronico_tipo as ET on Art.tipo = ET.id_tipo
                        LEFT JOIN cat_kilataje as Kil on Art.kilataje = Kil.id_Kilataje
                        LEFT JOIN cat_tipoarticulo as Tipo on Art.tipo = Tipo.id_tipo
                        LEFT JOIN cat_calidad as Cal on Art.calidad = Cal.id_calidad
                        WHERE CURDATE() BETWEEN DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') 
                        AND DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d')
                        AND Bit.sucursal = $sucursal 
                        ORDER BY Form";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "FECHA" => $row["FECHA"],
                        "FECHAVEN" => $row["FECHAVEN"],
                        "FECHAALM" => $row["FECHAALM"],
                        "CONTRATO" => $row["CONTRATO"],
                        "NombreCompleto" => $row["NombreCompleto"],
                        "PRESTAMO" => $row["PRESTAMO"],
                        "Plazo" => $row["Plazo"],
                        "Periodo" => $row["Periodo"],
                        "TipoInteres" => $row["TipoInteres"],
                        "ObserElec" => $row["ObserElec"],
                        "ObserMetal" => $row["ObserMetal"],
                        "ObserAuto" => $row["ObserAuto"],
                        "DetalleAuto" => $row["DetalleAuto"],
                        "Detalle" => $row["Detalle"],
                        "Form" => $row["Form"],
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
    public function reporteDesempe($fechaIni,$fechaFin)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') AS FECHAMOV,
                        DATE_FORMAT(ConM.fechaVencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        ConM.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO, 
                        ConM.e_interes AS INTERESES,  ConM.e_almacenaje AS ALMACENAJE, 
                        ConM.e_seguro AS SEGURO,  ConM.e_abono as ABONO,ConM.s_descuento_aplicado as DESCU,
                        ConM.e_iva as IVA, ConM.e_costoContrato AS COSTO, Con.id_Formulario as FORMU,
                        Con.id_Formulario as FORMU, ConM.pag_subtotal, 
                        ConM.pag_total
                        FROM contrato_mov_tbl AS ConM
                        INNER JOIN contratos_tbl AS Con ON ConM.id_contrato = Con.id_Contrato
                        WHERE DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 5 OR ConM.tipo_movimiento = 9 )  
                        ORDER BY CONTRATO";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "FECHA" => $row["FECHA"],
                        "FECHAMOV" => $row["FECHAMOV"],
                        "FECHAVEN" => $row["FECHAVEN"],
                        "CONTRATO" => $row["CONTRATO"],
                        "PRESTAMO" => $row["PRESTAMO"],
                        "INTERESES" => $row["INTERESES"],
                        "ALMACENAJE" => $row["ALMACENAJE"],
                        "SEGURO" => $row["SEGURO"],
                        "ABONO" => $row["ABONO"],
                        "DESCU" => $row["DESCU"],
                        "IVA" => $row["IVA"],
                        "COSTO" => $row["COSTO"],
                        "FORMU" => $row["FORMU"],
                        "pag_subtotal" => $row["pag_subtotal"],
                        "pag_total" => $row["pag_total"],
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
    public function reporteRefrendo($fechaIni,$fechaFin)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') AS FECHAMOV,
                        DATE_FORMAT(ConM.fechaVencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        ConM.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO, 
                        ConM.e_interes AS INTERESES,  ConM.e_almacenaje AS ALMACENAJE, 
                        ConM.e_seguro AS SEGURO,  ConM.e_abono as ABONO,ConM.s_descuento_aplicado as DESCU,
                        ConM.e_iva as IVA, ConM.e_costoContrato AS COSTO, Con.id_Formulario as FORMU
                        FROM contrato_mov_tbl AS ConM
                        INNER JOIN contratos_tbl AS Con ON ConM.id_contrato = Con.id_Contrato
                        WHERE DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 4 OR ConM.tipo_movimiento = 8 )  
                        ORDER BY FORMU";
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "FECHA" => $row["FECHA"],
                        "FECHAMOV" => $row["FECHAMOV"],
                        "FECHAVEN" => $row["FECHAVEN"],
                        "CONTRATO" => $row["CONTRATO"],
                        "PRESTAMO" => $row["PRESTAMO"],
                        "INTERESES" => $row["INTERESES"],
                        "ALMACENAJE" => $row["ALMACENAJE"],
                        "SEGURO" => $row["SEGURO"],
                        "ABONO" => $row["ABONO"],
                        "DESCU" => $row["DESCU"],
                        "IVA" => $row["IVA"],
                        "COSTO" => $row["COSTO"],
                        "FORMU" => $row["FORMU"],
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