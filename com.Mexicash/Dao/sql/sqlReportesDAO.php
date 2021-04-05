<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Usuario.php");
include_once(BASE_PATH . "Conexion.php");
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

    public function sqlReporteHistorico($busqueda, $fechaIni, $fechaFin, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(Con.id_Contrato) as  totalCount,
                        SUM(Con.total_Prestamo)  AS TOT_PRESTAMO
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente AND Cli.sucursal=$sucursal
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato And Art.sucursal=$sucursal
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato AND Aut.sucursal=$sucursal
                        WHERE '$fechaIni' >= Con.fecha_fisico_ini
                        AND '$fechaFin'  <= Con.fecha_fisico_fin  AND Con.sucursal=$sucursal";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_PRESTAMO"] = $fila["TOT_PRESTAMO"];

            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM,  
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Con.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO,
                        Art.descripcionCorta AS DESCRIPCION,
                        Art.observaciones as ObserArt,
                        Aut.observaciones as ObserAuto,
                        CONCAT ( Aut.marca,' ', Aut.modelo, ' ',Aut.color, ' ' , Aut.placas) as detalleAuto,
                        Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente AND Cli.sucursal=$sucursal
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato And Art.sucursal=$sucursal
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato AND Aut.sucursal=$sucursal
                        WHERE '$fechaIni' >= Con.fecha_fisico_ini
                        AND '$fechaFin'  <= Con.fecha_fisico_fin  AND Con.sucursal=$sucursal
                        ORDER BY Con.id_contrato
                        LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["FECHAVEN"] = $fila["FECHAVEN"];
                    $jsondataperson["FECHAALM"] = $fila["FECHAALM"];
                    $jsondataperson["NombreCompleto"] = $fila["NombreCompleto"];
                    $jsondataperson["CONTRATO"] = $fila["CONTRATO"];
                    $jsondataperson["PRESTAMO"] = $fila["PRESTAMO"];
                    $jsondataperson["DESCRIPCION"] = $fila["DESCRIPCION"];
                    $jsondataperson["ObserArt"] = $fila["ObserArt"];
                    $jsondataperson["ObserAuto"] = $fila["ObserAuto"];
                    $jsondataperson["detalleAuto"] = $fila["detalleAuto"];
                    $jsondataperson["Form"] = $fila["Form"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }
    public function sqlReporteContratos($busqueda, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "
                        SELECT COUNT(id_Articulo) as  totalCount,
                        SUM(Con.total_Prestamo)  AS TOT_PRESTAMO 
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
                        AND Art.sucursal=$sucursal
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato
     					AND Aut.sucursal=$sucursal
                        WHERE CURDATE() BETWEEN DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') 
                        AND DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d')
                        AND Con.sucursal = $sucursal AND (id_cat_estatus=1 OR id_cat_estatus=2)
                        ORDER BY Con.id_contrato";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_PRESTAMO"] = $fila["TOT_PRESTAMO"];

            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM,  
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Cli.celular,
                        Con.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO,
                        Art.descripcionCorta AS DESCRIPCION,
                        Art.observaciones as ObserArt,
                        Aut.observaciones as ObserAuto,
                        Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
                        AND Art.sucursal=$sucursal
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato
     					AND Aut.sucursal=$sucursal
                        WHERE CURDATE() BETWEEN DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') 
                        AND DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d')
                        AND Con.sucursal = $sucursal AND (id_cat_estatus=1 OR id_cat_estatus=2)
                        ORDER BY Con.id_contrato LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["FECHAVEN"] = $fila["FECHAVEN"];
                    $jsondataperson["FECHAALM"] = $fila["FECHAALM"];
                    $jsondataperson["NombreCompleto"] = $fila["NombreCompleto"];
                    $jsondataperson["celular"] = $fila["celular"];
                    $jsondataperson["CONTRATO"] = $fila["CONTRATO"];
                    $jsondataperson["PRESTAMO"] = $fila["PRESTAMO"];
                    $jsondataperson["DESCRIPCION"] = $fila["DESCRIPCION"];
                    $jsondataperson["ObserArt"] = $fila["ObserArt"];
                    $jsondataperson["ObserAuto"] = $fila["ObserAuto"];
                    $jsondataperson["Form"] = $fila["Form"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteDesempeno($busqueda, $fechaIni, $fechaFin, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(ConM.id_contrato) as  totalCount,
                        SUM(Con.total_Prestamo)  AS TOT_PRESTAMO,
                        SUM(ConM.e_interes)  AS TOT_INTERES,
                        SUM(ConM.e_almacenaje)  AS TOT_ALM,
                        SUM(ConM.e_seguro)  AS TOT_SEG,
                        SUM(ConM.s_descuento_aplicado)  AS TOT_DESC,
                        SUM(ConM.e_iva)  AS TOT_IVA,
                        SUM(ConM.e_costoContrato)  AS TOT_COSTO,
                        SUM(ConM.pag_subtotal)  AS TOT_SUB,
                        SUM(ConM.pag_total)  AS TOT_TOTAL         
                        FROM contrato_mov_tbl AS ConM
                        INNER JOIN contratos_tbl AS Con ON ConM.id_contrato = Con.id_Contrato AND Con.sucursal=$sucursal
                        WHERE DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 5 OR ConM.tipo_movimiento = 9 )  
                        ORDER BY ConM.id_contrato";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_PRESTAMO"] = $fila["TOT_PRESTAMO"];
                $jsondata["TOT_INTERES"] = $fila["TOT_INTERES"];
                $jsondata["TOT_ALM"] = $fila["TOT_ALM"];
                $jsondata["TOT_SEG"] = $fila["TOT_SEG"];
                $jsondata["TOT_DESC"] = $fila["TOT_DESC"];
                $jsondata["TOT_IVA"] = $fila["TOT_IVA"];
                $jsondata["TOT_COSTO"] = $fila["TOT_COSTO"];
                $jsondata["TOT_SUB"] = $fila["TOT_SUB"];
                $jsondata["TOT_TOTAL"] = $fila["TOT_TOTAL"];

            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') AS FECHAMOV,
                        ConM.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO, 
                        ConM.e_interes AS INTERESES,  ConM.e_almacenaje AS ALMACENAJE, 
                        ConM.e_seguro AS SEGURO,  ConM.e_pagoDesempeno as DES,ConM.s_descuento_aplicado as DESCU,
                        ConM.e_iva as IVA, ConM.e_costoContrato AS COSTO, Con.id_Formulario as FORMU,
                        ConM.pag_subtotal,  ConM.pag_total,ConM.e_intereses, ConM.e_moratorios,ConM.prestamo_Informativo
                        FROM contrato_mov_tbl AS ConM
                        INNER JOIN contratos_tbl AS Con ON ConM.id_contrato = Con.id_Contrato AND Con.sucursal=$sucursal
                        WHERE DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 5 OR ConM.tipo_movimiento = 9 )  
                        ORDER BY ConM.id_contrato LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["FECHAMOV"] = $fila["FECHAMOV"];
                    $jsondataperson["CONTRATO"] = $fila["CONTRATO"];
                    $jsondataperson["PRESTAMO"] = $fila["PRESTAMO"];
                    $jsondataperson["INTERESES"] = $fila["INTERESES"];
                    $jsondataperson["ALMACENAJE"] = $fila["ALMACENAJE"];
                    $jsondataperson["SEGURO"] = $fila["SEGURO"];
                    $jsondataperson["DES"] = $fila["DES"];
                    $jsondataperson["DESCU"] = $fila["DESCU"];
                    $jsondataperson["IVA"] = $fila["IVA"];
                    $jsondataperson["COSTO"] = $fila["COSTO"];
                    $jsondataperson["FORMU"] = $fila["FORMU"];
                    $jsondataperson["pag_subtotal"] = $fila["pag_subtotal"];
                    $jsondataperson["pag_total"] = $fila["pag_total"];
                    $jsondataperson["e_intereses"] = $fila["e_intereses"];
                    $jsondataperson["e_moratorios"] = $fila["e_moratorios"];
                    $jsondataperson["prestamo_Informativo"] = $fila["prestamo_Informativo"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteRefrendo($busqueda, $fechaIni, $fechaFin, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(ConM.id_contrato) as  totalCount,
                        SUM(Con.total_Prestamo)  AS TOT_PRESTAMO,
                        SUM(ConM.e_interes)  AS TOT_INTERES,
                        SUM(ConM.e_almacenaje)  AS TOT_ALM,
                        SUM(ConM.e_seguro)  AS TOT_SEG,
                        SUM(ConM.e_abono)  AS TOT_ABONO,
                        SUM(ConM.s_descuento_aplicado)  AS TOT_DESC,
                        SUM(ConM.e_iva)  AS TOT_IVA,
                        SUM(ConM.e_costoContrato)  AS TOT_COSTO,
                        SUM(ConM.pag_subtotal)  AS TOT_SUB,
                        SUM(ConM.pag_total)  AS TOT_TOTAL
                        FROM contrato_mov_tbl AS ConM
                        INNER JOIN contratos_tbl AS Con ON ConM.id_contrato = Con.id_Contrato AND Con.sucursal=$sucursal
                        WHERE DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 4 OR ConM.tipo_movimiento = 8 )  
                        ORDER BY ConM.id_contrato";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_PRESTAMO"] = $fila["TOT_PRESTAMO"];
                $jsondata["TOT_INTERES"] = $fila["TOT_INTERES"];
                $jsondata["TOT_ALM"] = $fila["TOT_ALM"];
                $jsondata["TOT_SEG"] = $fila["TOT_SEG"];
                $jsondata["TOT_ABONO"] = $fila["TOT_ABONO"];
                $jsondata["TOT_DESC"] = $fila["TOT_DESC"];
                $jsondata["TOT_IVA"] = $fila["TOT_IVA"];
                $jsondata["TOT_COSTO"] = $fila["TOT_COSTO"];
                $jsondata["TOT_SUB"] = $fila["TOT_SUB"];
                $jsondata["TOT_TOTAL"] = $fila["TOT_TOTAL"];
            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') AS FECHAMOV,
                        ConM.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO, 
                        ConM.e_interes AS INTERESES,  ConM.e_almacenaje AS ALMACENAJE, 
                        ConM.e_seguro AS SEGURO,  ConM.e_abono as ABONO,ConM.s_descuento_aplicado as DESCU,
                        ConM.e_iva as IVA, ConM.e_costoContrato AS COSTO, Con.id_Formulario as FORMU,
                        ConM.pag_subtotal,  ConM.pag_total,ConM.pag_total,ConM.e_intereses, 
                        ConM.e_moratorios
                        FROM contrato_mov_tbl AS ConM
                        INNER JOIN contratos_tbl AS Con ON ConM.id_contrato = Con.id_Contrato AND Con.sucursal=$sucursal
                        WHERE DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 4 OR ConM.tipo_movimiento = 8 )  
                        ORDER BY ConM.id_contrato LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["FECHAMOV"] = $fila["FECHAMOV"];
                    $jsondataperson["CONTRATO"] = $fila["CONTRATO"];
                    $jsondataperson["PRESTAMO"] = $fila["PRESTAMO"];
                    $jsondataperson["INTERESES"] = $fila["INTERESES"];
                    $jsondataperson["ALMACENAJE"] = $fila["ALMACENAJE"];
                    $jsondataperson["SEGURO"] = $fila["SEGURO"];
                    $jsondataperson["ABONO"] = $fila["ABONO"];
                    $jsondataperson["DESCU"] = $fila["DESCU"];
                    $jsondataperson["IVA"] = $fila["IVA"];
                    $jsondataperson["COSTO"] = $fila["COSTO"];
                    $jsondataperson["FORMU"] = $fila["FORMU"];
                    $jsondataperson["pag_subtotal"] = $fila["pag_subtotal"];
                    $jsondataperson["pag_total"] = $fila["pag_total"];
                    $jsondataperson["e_intereses"] = $fila["e_intereses"];
                    $jsondataperson["e_moratorios"] = $fila["e_moratorios"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteBazar($busqueda, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(Baz.id_Contrato) as  totalCount,
                        SUM(vitrinaVenta)  AS TOT_VENTAS  
                        FROM articulo_bazar_tbl as Baz
                        WHERE (tipo_movimiento= 24||tipo_movimiento=23||tipo_movimiento=22) and Baz.sucursal=$sucursal";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_VENTAS"] = $fila["TOT_VENTAS"];

            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(fecha_Bazar,'%Y-%m-%d') as FECHA, id_Contrato,id_serie,
       prestamo,
       vitrinaVenta AS precio_venta, 
                        descripcionCorta as Detalle
                        FROM articulo_bazar_tbl as Baz
                        WHERE (tipo_movimiento= 24||tipo_movimiento=23||tipo_movimiento=22) AND Baz.sucursal=$sucursal
                        LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["id_Contrato"] = $fila["id_Contrato"];
                    $jsondataperson["id_serie"] = $fila["id_serie"];
                    $jsondataperson["prestamo"] = $fila["prestamo"];
                    $jsondataperson["precio_venta"] = $fila["precio_venta"];
                    $jsondataperson["Detalle"] = $fila["Detalle"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteCompras($busqueda, $fechaIni, $fechaFin, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(Baz.id_Contrato) as  totalCount,
                        SUM(vitrinaVenta)  AS TOT_VENTAS,
                        SUM(precioCompra)  AS TOT_COMPRA
                        FROM articulo_bazar_tbl as Baz
                        LEFT JOIN cat_adquisicion AS CAT on Baz.id_serieTipo = CAT.id_Adquisicion
                        WHERE DATE_FORMAT(fecha_Bazar,'%Y-%m-%d')   >=  '$fechaIni'
                        AND DATE_FORMAT(fecha_Bazar,'%Y-%m-%d')   <=  '$fechaFin' 
                        AND id_serieTipo=2  AND Baz.sucursal=$sucursal";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_VENTAS"] = $fila["TOT_VENTAS"];
                $jsondata["TOT_COMPRA"] = $fila["TOT_COMPRA"];

            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(fecha_Bazar,'%Y-%m-%d') as FECHA, id_Contrato,id_serie,
                        vitrinaVenta AS precio_venta, 
                        precioCompra ,descripcionCorta as Detalle,CAT.descripcion as CatDesc
                        FROM articulo_bazar_tbl 
                        LEFT JOIN cat_adquisicion AS CAT on id_serieTipo = CAT.id_Adquisicion
                        WHERE DATE_FORMAT(fecha_Bazar,'%Y-%m-%d')   >=  '$fechaIni'
                        AND DATE_FORMAT(fecha_Bazar,'%Y-%m-%d')   <=  '$fechaFin' 
                        AND id_serieTipo=2  AND sucursal=$sucursal LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["id_Contrato"] = $fila["id_Contrato"];
                    $jsondataperson["id_serie"] = $fila["id_serie"];
                    $jsondataperson["precio_venta"] = $fila["precio_venta"];
                    $jsondataperson["precioCompra"] = $fila["precioCompra"];
                    $jsondataperson["Detalle"] = $fila["Detalle"];
                    $jsondataperson["CatDesc"] = $fila["CatDesc"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteInventarios($busqueda, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(id_Articulo) as  totalCount,
                        SUM(prestamo)  AS TOT_VENTAS   
                            FROM articulo_tbl AS ART 
                            LEFT JOIN contratos_tbl AS Con on ART.id_Contrato = Con.id_Contrato AND Con.sucursal = $sucursal
                            WHERE Con.fisico = 1 AND ART.id_Estatus != 20 
                            AND  ART.sucursal = $sucursal AND (Con.id_cat_estatus=1 OR Con.id_cat_estatus=2 )";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_VENTAS"] = $fila["TOT_VENTAS"];
            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(ART.fecha_creacion,'%Y-%m-%d') as FECHA, ART.id_Contrato,
                        CONCAT (id_SerieSucursal,Adquisiciones_Tipo,id_SerieContrato,id_SerieArticulo) as id_serie,
                        prestamo  AS precio_venta, ART.descripcionCorta AS Detalle
                        FROM articulo_tbl AS ART 
                        LEFT JOIN contratos_tbl AS Con on ART.id_Contrato = Con.id_Contrato AND Con.sucursal = $sucursal
                        WHERE Con.fisico = 1 AND ART.id_Estatus != 20 AND  ART.sucursal = $sucursal
                        AND (Con.id_cat_estatus=1 OR Con.id_cat_estatus=2 ) LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["id_Contrato"] = $fila["id_Contrato"];
                    $jsondataperson["id_serie"] = $fila["id_serie"];
                    $jsondataperson["precio_venta"] = $fila["precio_venta"];
                    $jsondataperson["Detalle"] = $fila["Detalle"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteVentas($busqueda, $fechaIni, $fechaFin, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(id_Bazar) AS totalCount,
                        SUM(Con.subTotal)  AS TOT_SUB,
                        SUM(Con.descuento_Venta)  AS TOT_DESC,
                        SUM(Con.total)  AS TOT_VENTAS,
                        SUM(Con.totalPrestamo)  AS TOT_PREST,
                        SUM(Con.utilidad)  AS TOT_UTIL   
                    FROM contrato_mov_baz_tbl AS Con
                    LEFT JOIN bit_cierrecaja AS BitC on Con.id_CierreCaja = BitC.id_CierreCaja 
                    AND BitC.sucursal=$sucursal
                    LEFT JOIN usuarios_tbl AS Usu on BitC.usuario = Usu.id_User
                    WHERE DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d')  >=  '$fechaIni'
                    AND DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d')  <=  '$fechaFin' 
                    AND Con.sucursal=$sucursal ";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_SUB"] = $fila["TOT_SUB"];
                $jsondata["TOT_DESC"] = $fila["TOT_DESC"];
                $jsondata["TOT_VENTAS"] = $fila["TOT_VENTAS"];
                $jsondata["TOT_PREST"] = $fila["TOT_PREST"];
                $jsondata["TOT_UTIL"] = $fila["TOT_UTIL"];

            } else {
                $BusquedaQuery = "SELECT id_Bazar,DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
Con.subTotal,Con.descuento_Venta,Con.total, Con.totalPrestamo, Con.utilidad, Usu.usuario
                    FROM contrato_mov_baz_tbl AS Con
                    LEFT JOIN bit_cierrecaja AS BitC on Con.id_CierreCaja = BitC.id_CierreCaja 
                    AND BitC.sucursal=$sucursal
                    LEFT JOIN usuarios_tbl AS Usu on BitC.usuario = Usu.id_User
                    WHERE DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d')  >=  '$fechaIni'
                    AND DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d')  <=  '$fechaFin' 
                    AND Con.sucursal=$sucursal LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["id_Bazar"] = $fila["id_Bazar"];
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["subTotal"] = $fila["subTotal"];
                    $jsondataperson["descuento_Venta"] = $fila["descuento_Venta"];
                    $jsondataperson["total"] = $fila["total"];
                    $jsondataperson["totalPrestamo"] = $fila["totalPrestamo"];
                    $jsondataperson["utilidad"] = $fila["utilidad"];
                    $jsondataperson["usuario"] = $fila["usuario"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteIngresos($busqueda, $fechaIni, $fechaFin, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(id_CierreSucursal) as  totalCount,
                        SUM(capitalRecuperado)  AS TOT_CAP,
                        SUM(abonoCapital)  AS TOT_ABONO,
                        SUM(intereses)  AS TOT_INTER,
                        SUM(costoContrato)  AS TOT_COST,
                        SUM(iva)  AS TOT_IVA,
                        SUM(mostrador)  AS TOT_MOS,
                        SUM(iva_venta)  AS TOT_IVAVEN,
                        SUM(utilidadVenta)  AS TOT_UTIL,
                        SUM(apartados)  AS TOT_APAR,
                        SUM(abonoVentas)  AS TOT_ABON
                       FROM bit_cierresucursal
                       WHERE DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin' 
                       AND sucursal = $sucursal  ORDER BY id_CierreSucursal";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_DES"] = $fila["TOT_CAP"];
                $jsondata["TOT_COST"] = $fila["TOT_COST"];
                $jsondata["TOT_ABONO"] = $fila["TOT_ABONO"];
                $jsondata["TOT_INTER"] = $fila["TOT_INTER"];
                $jsondata["TOT_IVA"] = $fila["TOT_IVA"];
                $jsondata["TOT_MOS"] = $fila["TOT_MOS"];
                $jsondata["TOT_IVAVEN"] = $fila["TOT_IVAVEN"];
                $jsondata["TOT_APAR"] = $fila["TOT_APAR"];
                $jsondata["TOT_ABON"] = $fila["TOT_ABON"];
                $jsondata["TOT_UTIL"] = $fila["TOT_UTIL"];

            } else {
                $BusquedaQuery = "SELECT id_CierreSucursal,capitalRecuperado as Desem,abonoCapital as AbonoRef,intereses as Inte,
                       costoContrato as costoContrato,iva as Iva,mostrador as Ventas,iva_venta as IvaVenta,
                       utilidadVenta as Utilidad, apartados as Apartados,abonoVentas as AbonoVen, 
                       DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') as Fecha 
                       FROM bit_cierresucursal
                       WHERE DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin' 
                       AND sucursal = $sucursal  ORDER BY id_CierreSucursal 
                       LIMIT " . $this->conexion->real_escape_string($limit) . " 
                      OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["id_CierreSucursal"] = $fila["id_CierreSucursal"];
                    $jsondataperson["Desem"] = $fila["Desem"];
                    $jsondataperson["costoContrato"] = $fila["costoContrato"];
                    $jsondataperson["AbonoRef"] = $fila["AbonoRef"];
                    $jsondataperson["Inte"] = $fila["Inte"];
                    $jsondataperson["Iva"] = $fila["Iva"];
                    $jsondataperson["Ventas"] = $fila["Ventas"];
                    $jsondataperson["IvaVenta"] = $fila["IvaVenta"];
                    $jsondataperson["Apartados"] = $fila["Apartados"];
                    $jsondataperson["AbonoVen"] = $fila["AbonoVen"];
                    $jsondataperson["Utilidad"] = $fila["Utilidad"];
                    $jsondataperson["Fecha"] = $fila["Fecha"];

                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }


    public function sqlReporteCorporativo($busqueda, $fechaIni, $fechaFin, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(id_CierreSucursal) as  totalCount,
                        SUM(capitalRecuperado)  AS TOT_CAP,
                        SUM(abonoCapital)  AS TOT_ABONO,
                        SUM(intereses)  AS TOT_INTER,
                        SUM(costoContrato)  AS TOT_COST,
                        SUM(iva)  AS TOT_IVA,
                        SUM(mostrador)  AS TOT_MOS,
                        SUM(iva_venta)  AS TOT_IVAVEN,
                        SUM(utilidadVenta)  AS TOT_UTIL,
                        SUM(apartados)  AS TOT_APAR,
                        SUM(abonoVentas)  AS TOT_ABON 
                       FROM bit_cierresucursal
                       WHERE DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin' 
                       AND sucursal = $sucursal  ORDER BY id_CierreSucursal";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_DES"] = $fila["TOT_CAP"];
                $jsondata["TOT_COST"] = $fila["TOT_COST"];
                $jsondata["TOT_ABONO"] = $fila["TOT_ABONO"];
                $jsondata["TOT_INTER"] = $fila["TOT_INTER"];
                $jsondata["TOT_IVA"] = $fila["TOT_IVA"];
                $jsondata["TOT_MOS"] = $fila["TOT_MOS"];
                $jsondata["TOT_IVAVEN"] = $fila["TOT_IVAVEN"];
                $jsondata["TOT_APAR"] = $fila["TOT_APAR"];
                $jsondata["TOT_ABON"] = $fila["TOT_ABON"];
                $jsondata["TOT_UTIL"] = $fila["TOT_UTIL"];
            } else {
                $BusquedaQuery = "SELECT id_CierreSucursal,capitalRecuperado as Desem,abonoCapital as AbonoRef,intereses as Inte,
                       costoContrato as costoContrato,iva as Iva,mostrador as Ventas,iva_venta as IvaVenta,
                       utilidadVenta as Utilidad, apartados as Apartados,abonoVentas as AbonoVen, 
                       DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') as Fecha, MONTH(fecha_Creacion) as Mes
                       FROM bit_cierresucursal
                       WHERE DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin' 
                       AND sucursal = $sucursal  ORDER BY id_CierreSucursal 
                       LIMIT " . $this->conexion->real_escape_string($limit) . " 
                      OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                $mesLista = 0;
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    if($mesLista==0){
                        $jsondataperson["id_CierreSucursal"] = $fila["id_CierreSucursal"];
                        $jsondataperson["Desem"] = $fila["Desem"];
                        $jsondataperson["costoContrato"] = $fila["costoContrato"];
                        $jsondataperson["AbonoRef"] = $fila["AbonoRef"];
                        $jsondataperson["Inte"] = $fila["Inte"];
                        $jsondataperson["Iva"] = $fila["Iva"];
                        $jsondataperson["Ventas"] = $fila["Ventas"];
                        $jsondataperson["IvaVenta"] = $fila["IvaVenta"];
                        $jsondataperson["Apartados"] = $fila["Apartados"];
                        $jsondataperson["AbonoVen"] = $fila["AbonoVen"];
                        $jsondataperson["Utilidad"] = $fila["Utilidad"];
                        $jsondataperson["Fecha"] = $fila["Fecha"];
                        $jsondataperson["Mes"] = $fila["Mes"];
                        $jsondataperson["Imprime"] = 0;

                        $mesLista =  $fila["Mes"];

                    }else{
                        if($mesLista==$fila["Mes"]){
                            $jsondataperson["id_CierreSucursal"] = $fila["id_CierreSucursal"];
                            $jsondataperson["Desem"] = $fila["Desem"];
                            $jsondataperson["costoContrato"] = $fila["costoContrato"];
                            $jsondataperson["AbonoRef"] = $fila["AbonoRef"];
                            $jsondataperson["Inte"] = $fila["Inte"];
                            $jsondataperson["Iva"] = $fila["Iva"];
                            $jsondataperson["Ventas"] = $fila["Ventas"];
                            $jsondataperson["IvaVenta"] = $fila["IvaVenta"];
                            $jsondataperson["Apartados"] = $fila["Apartados"];
                            $jsondataperson["AbonoVen"] = $fila["AbonoVen"];
                            $jsondataperson["Utilidad"] = $fila["Utilidad"];
                            $jsondataperson["Fecha"] = $fila["Fecha"];
                            $jsondataperson["Mes"] = $fila["Mes"];
                            $jsondataperson["Imprime"] = 0;
                            $mesLista =  $fila["Mes"];
                        }else{
                            $jsondataperson["id_CierreSucursal"] = $fila["id_CierreSucursal"];
                            $jsondataperson["Desem"] = $fila["Desem"];
                            $jsondataperson["costoContrato"] = $fila["costoContrato"];
                            $jsondataperson["AbonoRef"] = $fila["AbonoRef"];
                            $jsondataperson["Inte"] = $fila["Inte"];
                            $jsondataperson["Iva"] = $fila["Iva"];
                            $jsondataperson["Ventas"] = $fila["Ventas"];
                            $jsondataperson["IvaVenta"] = $fila["IvaVenta"];
                            $jsondataperson["Apartados"] = $fila["Apartados"];
                            $jsondataperson["AbonoVen"] = $fila["AbonoVen"];
                            $jsondataperson["Utilidad"] = $fila["Utilidad"];
                            $jsondataperson["Fecha"] = $fila["Fecha"];
                            $jsondataperson["Mes"] = $fila["Mes"];
                            $jsondataperson["Imprime"] = 1;
                            $mesLista =  $fila["Mes"];
                        }
                    }


                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    //MONITOREO

    public function sqlReporteDescuento($busqueda, $fechaIni, $fechaFin, $limit, $offset,$tipoReporte)
    {
        try {
            $sucursal = $_SESSION["sucursal"];

            if($tipoReporte==12){
                $tokenMov=1;
            }else if($tipoReporte==13){
                $tokenMov=2;
            }else if($tipoReporte==14){
                $tokenMov=3;
            }else if($tipoReporte==15){
                $tokenMov=4;
            }else if($tipoReporte==16){
                $tokenMov=5;
            }else if($tipoReporte==17){
                $tokenMov=6;
            }else if($tipoReporte==18){
                $tokenMov=7;
            }else if($tipoReporte==19){
                $tokenMov=8;
            }else if($tipoReporte==20){
                $tokenMov=9;
            }else if($tipoReporte==21){
                $tokenMov=10;
            }else if($tipoReporte==22){
                $tokenMov=11;
            }

            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(id_BitTokenVenta) as  totalCount 
                       FROM bit_token
                       WHERE DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin' 
                       AND id_tokenMovimiento =$tokenMov AND sucursal=$sucursal ORDER BY id_BitTokenVenta";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
            } else {
                $BusquedaQuery = "SELECT id_Contrato,token,descripcion,descuento,usuario,sucursal,
                        estatus,DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') AS Fecha
                        FROM bit_token 
                        WHERE DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin' 
                        AND id_tokenMovimiento= $tokenMov AND sucursal=$sucursal
                       LIMIT " . $this->conexion->real_escape_string($limit) . " 
                      OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["id_Contrato"] = $fila["id_Contrato"];
                    $jsondataperson["token"] = $fila["token"];
                    $jsondataperson["descripcion"] = $fila["descripcion"];
                    $jsondataperson["descuento"] = $fila["descuento"];
                    $jsondataperson["usuario"] = $fila["usuario"];
                    $jsondataperson["sucursal"] = $fila["sucursal"];
                    $jsondataperson["estatus"] = $fila["estatus"];
                    $jsondataperson["Fecha"] = $fila["Fecha"];

                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteCierreCaja($busqueda, $fechaIni, $fechaFin, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(id_CierreCaja) as  totalCount 
                       FROM bit_cierrecaja
                       WHERE DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin' 
                       AND sucursal = $sucursal  ORDER BY id_CierreCaja";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
            } else {
                $BusquedaQuery = "SELECT id_CierreCaja,id_CierreSucursal,dotacionesA_Caja,capitalRecuperado,abonoCapital,intereses,
                        iva,mostrador,iva_venta,apartadosVentas,abonoVentas,retirosCaja,prestamosNuevos,costoContrato
                       FROM bit_cierrecaja
                       WHERE DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin' 
                       AND sucursal = $sucursal  ORDER BY id_CierreCaja 
                       LIMIT " . $this->conexion->real_escape_string($limit) . " 
                      OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["id_CierreCaja"] = $fila["id_CierreCaja"];
                    $jsondataperson["id_CierreSucursal"] = $fila["id_CierreSucursal"];
                    $jsondataperson["dotacionesA_Caja"] = $fila["dotacionesA_Caja"];
                    $jsondataperson["capitalRecuperado"] = $fila["capitalRecuperado"];
                    $jsondataperson["abonoCapital"] = $fila["abonoCapital"];
                    $jsondataperson["intereses"] = $fila["intereses"];
                    $jsondataperson["iva"] = $fila["iva"];
                    $jsondataperson["mostrador"] = $fila["mostrador"];
                    $jsondataperson["iva_venta"] = $fila["iva_venta"];
                    $jsondataperson["apartadosVentas"] = $fila["apartadosVentas"];
                    $jsondataperson["abonoVentas"] = $fila["abonoVentas"];
                    $jsondataperson["retirosCaja"] = $fila["retirosCaja"];
                    $jsondataperson["prestamosNuevos"] = $fila["prestamosNuevos"];
                    $jsondataperson["costoContrato"] = $fila["costoContrato"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteCierreSucursal($busqueda, $fechaIni, $fechaFin, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(id_CierreSucursal) as  totalCount 
                       FROM bit_cierresucursal
                       WHERE DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin' 
                       AND sucursal = $sucursal  ORDER BY id_CierreSucursal";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
            } else {
                $BusquedaQuery = "SELECT id_CierreSucursal,dotacionesA_Caja,capitalRecuperado,abonoCapital,intereses,
                        iva,mostrador,iva_venta,apartados,abonoVentas,retirosCaja,prestamosNuevos,costoContrato
                       FROM bit_cierresucursal
                       WHERE DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin' 
                       AND sucursal = $sucursal  ORDER BY id_CierreSucursal 
                       LIMIT " . $this->conexion->real_escape_string($limit) . " 
                      OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["id_CierreSucursal"] = $fila["id_CierreSucursal"];
                    $jsondataperson["dotacionesA_Caja"] = $fila["dotacionesA_Caja"];
                    $jsondataperson["capitalRecuperado"] = $fila["capitalRecuperado"];
                    $jsondataperson["abonoCapital"] = $fila["abonoCapital"];
                    $jsondataperson["intereses"] = $fila["intereses"];
                    $jsondataperson["iva"] = $fila["iva"];
                    $jsondataperson["mostrador"] = $fila["mostrador"];
                    $jsondataperson["iva_venta"] = $fila["iva_venta"];
                    $jsondataperson["apartados"] = $fila["apartados"];
                    $jsondataperson["abonoVentas"] = $fila["abonoVentas"];
                    $jsondataperson["retirosCaja"] = $fila["retirosCaja"];
                    $jsondataperson["prestamosNuevos"] = $fila["prestamosNuevos"];
                    $jsondataperson["costoContrato"] = $fila["costoContrato"];

                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function reporteMon($tipo, $fechaIni, $fechaFin)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT Bit.id_BitacoraToken,Bit.id_Contrato,Bit.tipo_formulario,Bit.token,Bit.descripcion,
                        Bit.descuento,Bit.interes, Cat.descripcion as Descripcion, Usu.usuario,Bit.importe_flujo,Bit.id_flujo,
                        DATE_FORMAT(Bit.fecha_Creacion,'%Y-%m-%d') as Fecha FROM bit_token as Bit
                        INNER JOIN cat_token_movimiento as Cat on Bit.id_tokenMovimiento = Cat.id_tokenMovimiento
                        LEFT JOIN usuarios_tbl as Usu on Bit.usuario = Usu.id_User  ";
            if ($tipo == 0) {
                $buscar .= " WHERE Bit.fecha_Creacion BETWEEN '$fechaIni' 
                            AND '$fechaFin' AND Bit.sucursal = $sucursal  ORDER BY Bit.id_BitacoraToken";
            } else {
                $buscar .= "WHERE Bit.id_tokenMovimiento=$tipo AND  Bit.fecha_Creacion BETWEEN '$fechaIni' 
                            AND '$fechaFin' AND Bit.sucursal = $sucursal  ORDER BY Bit.id_BitacoraToken";
            }
            // echo $buscar;
            $rs = $this->conexion->query($buscar);
            if ($rs->num_rows > 0) {
                while ($row = $rs->fetch_assoc()) {
                    $data = [
                        "id_BitacoraToken" => $row["id_BitacoraToken"],
                        "id_Contrato" => $row["id_Contrato"],
                        "tipo_formulario" => $row["tipo_formulario"],
                        "token" => $row["token"],
                        "descripcion" => $row["descripcion"],
                        "descuento" => $row["descuento"],
                        "interes" => $row["interes"],
                        "Descripcion" => $row["Descripcion"],
                        "usuario" => $row["usuario"],
                        "importe_flujo" => $row["importe_flujo"],
                        "id_flujo" => $row["id_flujo"],
                        "Fecha" => $row["Fecha"],
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

    public function sqlReporteEmpeno($busqueda, $fechaIni, $fechaFin, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(Con.id_Contrato) as  totalCount,
                        SUM(Con.total_Prestamo)  AS TOT_PRESTAMO  
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato  AND Con.sucursal = Art.sucursal
                        WHERE Con.id_Formulario!=3 AND DATE_FORMAT(Con.fecha_creacion,'%Y-%m-%d') 
                        BETWEEN '$fechaIni' AND '$fechaFin' AND Con.sucursal=$sucursal
                        ORDER BY Con.id_contrato";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_PRESTAMO"] = $fila["TOT_PRESTAMO"];

            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM,  
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Con.id_contrato AS CONTRATO,
                        Art.prestamo AS PRESTAMO,
                        Art.descripcionCorta AS DESCRIPCION,
                        Art.observaciones as ObserArt,
                        Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato  AND Con.sucursal = Art.sucursal
                        WHERE Con.id_Formulario!=3 AND DATE_FORMAT(Con.fecha_creacion,'%Y-%m-%d') 
                        BETWEEN '$fechaIni' AND '$fechaFin' AND Con.sucursal=$sucursal
                        ORDER BY Con.id_contrato
                        LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["FECHAVEN"] = $fila["FECHAVEN"];
                    $jsondataperson["FECHAALM"] = $fila["FECHAALM"];
                    $jsondataperson["NombreCompleto"] = $fila["NombreCompleto"];
                    $jsondataperson["CONTRATO"] = $fila["CONTRATO"];
                    $jsondataperson["PRESTAMO"] = $fila["PRESTAMO"];
                    $jsondataperson["DESCRIPCION"] = $fila["DESCRIPCION"];
                    $jsondataperson["ObserArt"] = $fila["ObserArt"];
                    $jsondataperson["Form"] = $fila["Form"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteBazarAuto($busqueda, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(Baz.id_AutoBazar) as  totalCount,
                        SUM(vitrina_venta)  AS TOT_VENTAS   
                        FROM auto_bazar_tbl as Baz
                        WHERE tipo_movimiento!= 10 and Baz.sucursal=$sucursal";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_VENTAS"] = $fila["TOT_VENTAS"];

            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(fecha_creacion,'%Y-%m-%d') as FECHA, id_Contrato,
                        id_serie, prestamo AS prestamo, 
                        vitrina_venta AS precio_venta, 
                        descripcionCorta as Detalle
                        FROM auto_bazar_tbl as Baz
                        WHERE fisico= 1 AND HayMovimiento=0 AND Baz.sucursal=$sucursal
                        LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["id_Contrato"] = $fila["id_Contrato"];
                    $jsondataperson["id_serie"] = $fila["id_serie"];
                    $jsondataperson["prestamo"] = $fila["prestamo"];
                    $jsondataperson["precio_venta"] = $fila["precio_venta"];
                    $jsondataperson["Detalle"] = $fila["Detalle"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteUtilidad($busqueda, $fechaIni, $fechaFin, $limit, $offset)
    {
        try {
            //Reporte30
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(id_movimiento) as  totalCount
                        FROM contrato_mov_tbl WHERE sucursal=$sucursal AND (tipo_movimiento=4 || tipo_movimiento=5) AND
                        DATE_FORMAT(fecha_Movimiento,'%Y-%m-%d')                             
                        BETWEEN '$fechaIni' AND '$fechaFin'   ORDER BY fecha_Movimiento ";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];

            } else {
                $BusquedaQuery = "SELECT  DATE_FORMAT(fecha_Movimiento,'%Y-%m-%d')  AS Movimiento,id_movimiento, id_contrato, tipo_movimiento,
                                    e_intereses,e_iva,e_pagoDesempeno,e_costoContrato, prestamo_Informativo
                                    FROM contrato_mov_tbl WHERE sucursal=$sucursal AND (tipo_movimiento=4 || tipo_movimiento=5) AND
                                    DATE_FORMAT(fecha_Movimiento,'%Y-%m-%d')                                
                                    BETWEEN '$fechaIni' AND '$fechaFin'   ORDER BY fecha_Movimiento 
                                    LIMIT " . $this->conexion->real_escape_string($limit) . " 
                                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["Movimiento"] = $fila["Movimiento"];
                    $jsondataperson["id_movimiento"] = $fila["id_movimiento"];
                    $jsondataperson["id_contrato"] = $fila["id_contrato"];
                    $jsondataperson["tipo_movimiento"] = $fila["tipo_movimiento"];
                    $jsondataperson["e_intereses"] = $fila["e_intereses"];
                    $jsondataperson["e_iva"] = $fila["e_iva"];
                    $jsondataperson["e_pagoDesempeno"] = $fila["e_pagoDesempeno"];
                    $jsondataperson["e_costoContrato"] = $fila["e_costoContrato"];
                    $jsondataperson["prestamo_Informativo"] = $fila["prestamo_Informativo"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }


    public function sqlReportePasarBazar($busqueda, $limit, $offset)
    {
        try {
            //Reporte30
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "
                        SELECT COUNT(Con.id_contrato) as  totalCount,
                        SUM(Con.total_Prestamo)  AS TOT_PRESTAMO 
                         FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
                        AND Con.sucursal =Art.sucursal
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato
     					 AND Con.sucursal =Aut.sucursal
                        WHERE DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') < CURDATE()  
                        AND Con.sucursal = $sucursal AND (id_cat_estatus=1 OR id_cat_estatus=2)
                        AND (id_cat_estatus!=20)
                        ORDER BY Con.id_contrato";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_PRESTAMO"] = $fila["TOT_PRESTAMO"];

            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM,  
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Cli.celular,
                        Con.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO,
                        Art.descripcionCorta AS DESCRIPCION,
                        Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
                        AND Con.sucursal =Art.sucursal
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato
     					AND Con.sucursal =Aut.sucursal
                        WHERE DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') < CURDATE()  
                        AND Con.sucursal = $sucursal AND (id_cat_estatus=1 OR id_cat_estatus=2)
                        AND (id_cat_estatus!=20)
                        ORDER BY Con.id_contrato LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["FECHAVEN"] = $fila["FECHAVEN"];
                    $jsondataperson["FECHAALM"] = $fila["FECHAALM"];
                    $jsondataperson["NombreCompleto"] = $fila["NombreCompleto"];
                    $jsondataperson["celular"] = $fila["celular"];
                    $jsondataperson["CONTRATO"] = $fila["CONTRATO"];
                    $jsondataperson["PRESTAMO"] = $fila["PRESTAMO"];
                    $jsondataperson["DESCRIPCION"] = $fila["DESCRIPCION"];
                    $jsondataperson["Form"] = $fila["Form"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }


    public function sqlReporteUtilidadVenta($busqueda, $fechaIni, $fechaFin, $limit, $offset)
    {
        try {
            //Reporte30
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(id) as  totalCount,
                        SUM(total)  AS TOT,
                        SUM(totalPrestamo)  AS TOT_PRES,
                        SUM(utilidad)  AS TOT_UTIL
                        FROM contrato_mov_baz_tbl 
                        WHERE sucursal=$sucursal AND tipo_movimiento=6 AND
                        DATE_FORMAT(fecha_Creacion,'%Y-%m-%d')                                
                        BETWEEN '$fechaIni' AND '$fechaFin'   ORDER BY id ";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT"] = $fila["TOT"];
                $jsondata["TOT_PRES"] = $fila["TOT_PRES"];
                $jsondata["TOT_UTIL"] = $fila["TOT_UTIL"];

            } else {
                $BusquedaQuery = "SELECT  DATE_FORMAT(fecha_Creacion,'%Y-%m-%d')  AS Movimiento,id_Bazar, 
                                    total,totalPrestamo,utilidad FROM contrato_mov_baz_tbl
                                    WHERE sucursal=$sucursal AND tipo_movimiento=6 AND
                                    DATE_FORMAT(fecha_Creacion,'%Y-%m-%d')                                
                                    BETWEEN '$fechaIni' AND '$fechaFin'   ORDER BY id_Bazar 
                                    LIMIT " . $this->conexion->real_escape_string($limit) . " 
                                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["Movimiento"] = $fila["Movimiento"];
                    $jsondataperson["id_Bazar"] = $fila["id_Bazar"];
                    $jsondataperson["total"] = $fila["total"];
                    $jsondataperson["totalPrestamo"] = $fila["totalPrestamo"];
                    $jsondataperson["utilidad"] = $fila["utilidad"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteInventariosAutos($busqueda, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(id_Auto) as  totalCount,
                        SUM(total_Prestamo)  AS TOT_PRES  
                            FROM auto_tbl AS Aut 
                            LEFT JOIN contratos_tbl AS Con on Aut.id_Contrato = Con.id_Contrato 
                            AND  Aut.sucursal  = Con.sucursal
                            WHERE Con.fisico = 1 AND Aut.id_Estatus != 20 
                            AND  Aut.sucursal = $sucursal AND (Con.id_cat_estatus=1 OR Con.id_cat_estatus=2 )";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_PRES"] = $fila["TOT_PRES"];
            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(Aut.fecha_creacion,'%Y-%m-%d') as FECHA, Aut.id_Contrato,
                        total_Prestamo  AS total_Prestamo, Aut.marca, Aut.modelo,Aut.anio,Aut.color,
                        Aut.placas, Aut.observaciones
                        FROM auto_tbl AS Aut 
                            LEFT JOIN contratos_tbl AS Con on Aut.id_Contrato = Con.id_Contrato 
                            AND  Aut.sucursal  = Con.sucursal
                            WHERE Con.fisico = 1 AND Aut.id_Estatus != 20 
                            AND  Aut.sucursal = $sucursal AND (Con.id_cat_estatus=1 OR Con.id_cat_estatus=2 )
                             LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["id_Contrato"] = $fila["id_Contrato"];
                    $jsondataperson["total_Prestamo"] = $fila["total_Prestamo"];
                    $jsondataperson["marca"] = $fila["marca"];
                    $jsondataperson["modelo"] = $fila["modelo"];
                    $jsondataperson["anio"] = $fila["anio"];
                    $jsondataperson["color"] = $fila["color"];
                    $jsondataperson["placas"] = $fila["placas"];
                    $jsondataperson["observaciones"] = $fila["observaciones"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteEmpenoAuto($busqueda, $fechaIni, $fechaFin, $limit, $offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(Con.id_Contrato) as  totalCount,
                        SUM(Con.total_Prestamo)  AS TOT_PRESTAMO  
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato AND Con.sucursal = Aut.sucursal
                        WHERE Con.id_Formulario=3 AND DATE_FORMAT(Con.fecha_creacion,'%Y-%m-%d') 
                        BETWEEN '$fechaIni' AND '$fechaFin' AND Con.sucursal=$sucursal
                        ORDER BY Con.id_contrato";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
                $jsondata["TOT_PRESTAMO"] = $fila["TOT_PRESTAMO"];

            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM,  
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Con.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMOAUTO,
                        CONCAT (Aut.marca , ' ',Aut.modelo,' ', Aut.anio,' ', Aut.color) as DESCRIPCIONAUTO,
                        Aut.observaciones as ObserAuto,
                        Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato AND Con.sucursal = Aut.sucursal
                        WHERE Con.id_Formulario=3 AND DATE_FORMAT(Con.fecha_creacion,'%Y-%m-%d') 
                        BETWEEN '$fechaIni' AND '$fechaFin' AND Con.sucursal=$sucursal
                        ORDER BY Con.id_contrato
                        LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["FECHAVEN"] = $fila["FECHAVEN"];
                    $jsondataperson["FECHAALM"] = $fila["FECHAALM"];
                    $jsondataperson["NombreCompleto"] = $fila["NombreCompleto"];
                    $jsondataperson["CONTRATO"] = $fila["CONTRATO"];
                    $jsondataperson["PRESTAMOAUTO"] = $fila["PRESTAMOAUTO"];
                    $jsondataperson["DESCRIPCIONAUTO"] = $fila["DESCRIPCIONAUTO"];
                    $jsondataperson["ObserAuto"] = $fila["ObserAuto"];
                    $jsondataperson["Form"] = $fila["Form"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteMigrarBazar($busqueda, $limit, $offset)
    {
        try {
            //Reporte30
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "
                        SELECT COUNT(Con.id_contrato) as  totalCount
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
                        AND Con.sucursal =Art.sucursal
                        WHERE DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') < CURDATE()  
                        AND Con.sucursal = $sucursal AND tipoContrato=1  AND (id_cat_estatus=1 OR id_cat_estatus=2)
                        AND (id_cat_estatus!=20)
                        ORDER BY Con.id_contrato ";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];

            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM,  
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Cli.celular,
                        Con.id_contrato AS CONTRATO,
                        Art.prestamo AS PRESTAMO,
                        Art.descripcionCorta AS DESCRIPCION,
                        Con.id_cat_estatus AS Estatus
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
                        AND Con.sucursal =Art.sucursal
                        WHERE DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') < CURDATE()  
                        AND Con.sucursal = $sucursal AND (id_cat_estatus=1 OR id_cat_estatus=2)
                        AND (id_cat_estatus!=20)
                        ORDER BY Con.id_contrato LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["FECHAVEN"] = $fila["FECHAVEN"];
                    $jsondataperson["FECHAALM"] = $fila["FECHAALM"];
                    $jsondataperson["NombreCompleto"] = $fila["NombreCompleto"];
                    $jsondataperson["celular"] = $fila["celular"];
                    $jsondataperson["CONTRATO"] = $fila["CONTRATO"];
                    $jsondataperson["PRESTAMO"] = $fila["PRESTAMO"];
                    $jsondataperson["DESCRIPCION"] = $fila["DESCRIPCION"];
                    $jsondataperson["Estatus"] = $fila["Estatus"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteRegresarBazar($busqueda, $limit, $offset)
    {
        try {
            //Reporte30
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(id_ArticuloBazar) as  totalCount
                        FROM articulo_bazar_tbl 
                        WHERE DATE_FORMAT(fecha_creacion,'%Y-%m-%d') = CURDATE()  
                        AND sucursal = $sucursal AND Fisico=1 AND HayMovimiento=0";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];

            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(fecha_creacion,'%Y-%m-%d') as Fecha_Bazar,
                        id_Contrato, descripcionCorta,  prestamo, vitrinaVenta,estatus_Contrato						
                        FROM articulo_bazar_tbl 
                        WHERE DATE_FORMAT(fecha_creacion,'%Y-%m-%d') = CURDATE()  
                        AND sucursal = $sucursal AND Fisico=1 AND HayMovimiento=0
                        ORDER BY id_Contrato LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["Fecha"] = $fila["Fecha_Bazar"];
                    $jsondataperson["Contrato"] = $fila["id_Contrato"];
                    $jsondataperson["Descripcion"] = $fila["descripcionCorta"];
                    $jsondataperson["prestamo"] = $fila["prestamo"];
                    $jsondataperson["vitrinaVenta"] = $fila["vitrinaVenta"];
                    $jsondataperson["Estatus"] = $fila["estatus_Contrato"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteMigrarAuto($busqueda, $limit, $offset)
    {
        try {
            //Reporte30
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "
                        SELECT COUNT(Con.id_contrato) as  totalCount
                         FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato 
                        AND Con.sucursal =Aut.sucursal
                        WHERE DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') < CURDATE()  
                        AND Con.sucursal = $sucursal AND tipoContrato=2 AND (id_cat_estatus=1 OR id_cat_estatus=2)
                        AND (id_cat_estatus!=20)";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];

            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM,  
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Cli.celular,
                        Con.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO,
                        Aut.marca, Aut.modelo,Aut.anio,Aut.color,
                        Aut.placas, Aut.observaciones,
                        Con.id_cat_estatus AS Estatus
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato 
                        AND Con.sucursal =Aut.sucursal
                        WHERE DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') < CURDATE()  
                        AND Con.sucursal = $sucursal AND tipoContrato=2 AND (id_cat_estatus=1 OR id_cat_estatus=2)
                        AND (id_cat_estatus!=20)
                        ORDER BY Con.id_contrato LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["FECHAVEN"] = $fila["FECHAVEN"];
                    $jsondataperson["FECHAALM"] = $fila["FECHAALM"];
                    $jsondataperson["NombreCompleto"] = $fila["NombreCompleto"];
                    $jsondataperson["celular"] = $fila["celular"];
                    $jsondataperson["CONTRATO"] = $fila["CONTRATO"];
                    $jsondataperson["PRESTAMO"] = $fila["PRESTAMO"];
                    $jsondataperson["marca"] = $fila["marca"];
                    $jsondataperson["modelo"] = $fila["modelo"];
                    $jsondataperson["anio"] = $fila["anio"];
                    $jsondataperson["color"] = $fila["color"];
                    $jsondataperson["placas"] = $fila["placas"];
                    $jsondataperson["observaciones"] = $fila["observaciones"];
                    $jsondataperson["Estatus"] = $fila["Estatus"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlReporteRegresarAuto($busqueda, $limit, $offset)
    {
        try {
            //Reporte30
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(id_AutoBazar) as  totalCount
                        FROM auto_bazar_tbl 
                        WHERE DATE_FORMAT(fecha_creacion,'%Y-%m-%d') = CURDATE()  
                        AND sucursal = $sucursal AND Fisico=1 AND HayMovimiento=0 
                        AND tipo_movimiento=24";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];

            } else {
                $BusquedaQuery = "SELECT DATE_FORMAT(fecha_creacion,'%Y-%m-%d') as Fecha_Bazar,
                        id_Contrato, descripcionCorta,  prestamo, vitrinaVenta,estatus_Contrato						
                        FROM auto_bazar_tbl 
                        WHERE DATE_FORMAT(fecha_creacion,'%Y-%m-%d') = CURDATE()  
                        AND sucursal = $sucursal AND Fisico=1 AND HayMovimiento=0 
                        AND tipo_movimiento=24
                        ORDER BY id_Contrato LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["Fecha"] = $fila["Fecha_Bazar"];
                    $jsondataperson["Contrato"] = $fila["id_Contrato"];
                    $jsondataperson["Descripcion"] = $fila["descripcionCorta"];
                    $jsondataperson["prestamo"] = $fila["prestamo"];
                    $jsondataperson["vitrinaVenta"] = $fila["vitrinaVenta"];
                    $jsondataperson["Estatus"] = $fila["estatus_Contrato"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

    public function sqlMigrarBazar($contrato,$Estatus){
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {
            $sucursal = $_SESSION["sucursal"];


            $updateMigracion = "UPDATE contratos_tbl SET fisico=0,id_cat_estatus=4 
                                WHERE sucursal=$sucursal AND id_Contrato=$contrato";

            if ($ps = $this->conexion->prepare($updateMigracion)) {
                if ($ps->execute()) {
                    if (mysqli_stmt_affected_rows($ps) > 0) {
                        $insertaMigracion = "INSERT INTO articulo_bazar_tbl(id_Contrato, id_serie, id_Articulo, tipo_movimiento,
                                 tipoArticulo, tipo, kilataje, calidad, cantidad, peso, peso_Piedra,
                                piedras, marca, modelo, num_Serie, prestamo, avaluo, vitrina,vitrinaVenta, precioCat,
                                observaciones, detalle,descripcionCorta,sucursal,estatus_Contrato)
                            SELECT Art.id_Contrato, CONCAT (id_SerieSucursal, Adquisiciones_Tipo, id_SerieContrato,id_SerieArticulo) as idSerie,
                                id_Articulo,25, tipoArticulo, tipo, kilataje, calidad, cantidad,
                                peso, peso_Piedra, piedras, marca, modelo, num_Serie, prestamo, avaluo, vitrina,vitrina,
                                precioCat, observaciones, detalle, Art.descripcionCorta,
                                Art.sucursal,$Estatus
                            FROM articulo_tbl as Art
                            INNER JOIN contratos_tbl as Con on Art.id_Contrato = Con.id_contrato AND Con.sucursal= Art.sucursal
                            WHERE Art.sucursal=$sucursal AND Con.id_Contrato= $contrato";
                        if ($ps = $this->conexion->prepare($insertaMigracion)) {
                            if ($ps->execute()) {
                                $verdad = 1;
                            }else{
                                $verdad = -1;
                            }
                        }else{
                            $verdad = -2;
                        }
                    }else{
                        $verdad = -2;
                    }
                } else {
                    $verdad = -2;
                }
            } else {
                $verdad = -2;
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

    public function sqlMigrarBazarAuto($contrato,$Estatus){
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {
            $sucursal = $_SESSION["sucursal"];


            $updateMigracion = "UPDATE contratos_tbl SET fisico=0,id_cat_estatus=4 
                                WHERE sucursal=$sucursal AND id_Contrato=$contrato";

            if ($ps = $this->conexion->prepare($updateMigracion)) {
                if ($ps->execute()) {
                    if (mysqli_stmt_affected_rows($ps) > 0) {
                        $insertaMigracion = "INSERT INTO auto_bazar_tbl(id_Contrato,id_serie, prestamo, 
                           avaluo, vitrina, vitrinaVenta,  tipo_Vehiculo, marca, modelo,
                          	anio, color, placas, factura, kilometraje, agencia, num_motor, 
                           serie_chasis, vin, repuve, gasolina, tarjeta_circulacion, aseguradora, poliza,
                           fechaVencimiento, tipoPoliza, observaciones, descripcionCorta,	
                           chkTarjeta, chkFactura, chkINE, chkImportacion, chkTenencias, chkPoliza,
                           chkLicencia, sucursal,estatus_Contrato)				
                            SELECT Con.id_Contrato,id_serie, total_Prestamo, total_Avaluo, total_Avaluo,
                                   total_Avaluo,tipo_Vehiculo, marca, modelo,anio, color, placas, factura,
                                   kilometraje, agencia, num_motor, serie_chasis, vin, repuve, gasolina,
                                   tarjeta_circulacion, aseguradora, poliza, fechaVencimiento, tipoPoliza, 
                                   observaciones, 
                                   CONCAT(marca, ' ', modelo,' ',color,' ',placas) as descripcionCorta,	
                                   chkTarjeta, chkFactura, chkINE, chkImportacion, chkTenencias, chkPoliza,
                                   chkLicencia, Con.sucursal,$Estatus
                                    FROM auto_tbl as Aut
                                    INNER JOIN contratos_tbl as Con on Aut.id_Contrato = Con.id_contrato
                                    AND Aut.sucursal= Con.sucursal
                                    WHERE Aut.sucursal=$sucursal AND Con.id_Contrato= $contrato";
                        if ($ps = $this->conexion->prepare($insertaMigracion)) {
                            if ($ps->execute()) {
                                $verdad = 1;
                            }else{
                                $verdad = -1;
                            }
                        }else{
                            $verdad = -2;
                        }
                    }else{
                        $verdad = -2;
                    }
                } else {
                    $verdad = -2;
                }
            } else {
                $verdad = -2;
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

    public function sqlRegresarBazar($contrato,$Estatus){
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {
            $sucursal = $_SESSION["sucursal"];

            $updateContrato = "UPDATE contratos_tbl SET fisico=1,id_cat_estatus=$Estatus 
                                WHERE sucursal=$sucursal AND id_Contrato=$contrato";

            if ($ps = $this->conexion->prepare($updateContrato)) {
                if ($ps->execute()) {
                    if (mysqli_stmt_affected_rows($ps) > 0) {
                        $updateBazar = "UPDATE articulo_bazar_tbl SET tipo_movimiento=44,
                              HayMovimiento=1,Fisico=0 
                                WHERE sucursal=$sucursal AND id_Contrato=$contrato";
                        if ($ps = $this->conexion->prepare($updateBazar)) {
                            if ($ps->execute()) {
                                $verdad = 1;
                            }else{
                                $verdad = -1;
                            }
                        }else{
                            $verdad = -2;
                        }
                    }else{
                        $verdad = -2;
                    }
                } else {
                    $verdad = -2;
                }
            } else {
                $verdad = -2;
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

    public function sqlRegresarBazarAuto($contrato,$Estatus){
        //Funcion Verificada
        // TODO: Implement guardaCiente() method.
        try {
            $sucursal = $_SESSION["sucursal"];

            $updateContrato = "UPDATE contratos_tbl SET fisico=1,id_cat_estatus=$Estatus 
                                WHERE sucursal=$sucursal AND id_Contrato=$contrato and tipoContrato = 2";
            if ($ps = $this->conexion->prepare($updateContrato)) {
                if ($ps->execute()) {
                    if (mysqli_stmt_affected_rows($ps) > 0) {
                        $updateBazar = "UPDATE auto_bazar_tbl SET tipo_movimiento=44,
                              HayMovimiento=1,Fisico=0 
                                WHERE sucursal=$sucursal AND id_Contrato=$contrato  ";
                        if ($ps = $this->conexion->prepare($updateBazar)) {
                            if ($ps->execute()) {
                                $verdad = 1;
                            }else{
                                $verdad = -1;
                            }
                        }else{
                            $verdad = -2;
                        }
                    }else{
                        $verdad = -2;
                    }
                } else {
                    $verdad = -2;
                }
            } else {
                $verdad = -2;
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

    public function sqlReporteBazarHoy($busqueda, $fechaIni, $fechaFin, $limit, $offset)
    {
        try {
            //Reporte30
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if ($busqueda == 1) {
                $count = "SELECT COUNT(id_ArticuloBazar) as  totalCount
                        FROM articulo_bazar_tbl 
                        WHERE DATE_FORMAT(fecha_creacion,'%Y-%m-%d') 
                        BETWEEN '$fechaIni' AND '$fechaFin' AND sucursal=$sucursal ";
                $resultado = $this->conexion->query($count);
                $fila = $resultado->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];

            } else {
                $BusquedaQuery = " SELECT DATE_FORMAT(fecha_creacion,'%Y-%m-%d') as Fecha_Bazar,
                        id_Contrato, descripcionCorta,  prestamo, vitrinaVenta,estatus_Contrato						
                        FROM articulo_bazar_tbl 
                        WHERE DATE_FORMAT(fecha_creacion,'%Y-%m-%d') 
                        BETWEEN '$fechaIni' AND '$fechaFin' AND sucursal=$sucursal 
                        Order by id_Contrato
                        LIMIT " . $this->conexion->real_escape_string($limit) . " 
                    OFFSET " . $this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while ($fila = $resultado->fetch_assoc()) {
                    $jsondataperson = array();
                    $jsondataperson["Fecha"] = $fila["Fecha_Bazar"];
                    $jsondataperson["Contrato"] = $fila["id_Contrato"];
                    $jsondataperson["Descripcion"] = $fila["descripcionCorta"];
                    $jsondataperson["prestamo"] = $fila["prestamo"];
                    $jsondataperson["vitrinaVenta"] = $fila["vitrinaVenta"];
                    $jsondataperson["Estatus"] = $fila["estatus_Contrato"];
                    $jsondataList[] = $jsondataperson;
                }
                $jsondata["lista"] = array_values($jsondataList);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } finally {
            $this->db->closeDB();
        }

        echo json_encode($jsondata);
    }

}