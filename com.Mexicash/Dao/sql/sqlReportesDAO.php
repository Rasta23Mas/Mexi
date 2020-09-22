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
    public function sqlReporteHistorico($busqueda,$fechaIni,$fechaFin,$limit,$offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if($busqueda==1){
                $count = "SELECT COUNT(Con.id_Contrato) as  totalCount 
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato 
                        WHERE '$fechaIni' >= Con.fecha_fisico_ini
                        AND '$fechaFin'  <= Con.fecha_fisico_fin
                        AND Art.sucursal = $sucursal ";
                $resultado = $this->conexion->query($count);
                $fila = $resultado ->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
            }else{
                $BusquedaQuery = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM,  
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Con.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO,
                        Art.descripcionCorta AS DESCRIPCION,
                        Art.observaciones as ObserArt,
                        Aut.observaciones as ObserAuto,
                        Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato 
                        WHERE '$fechaIni' >= Con.fecha_fisico_ini
                        AND '$fechaFin'  <= Con.fecha_fisico_fin
                        AND Art.sucursal = $sucursal 
                        ORDER BY Con.id_contrato
                        LIMIT ".$this->conexion->real_escape_string($limit)." 
                    OFFSET ".$this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while($fila = $resultado ->fetch_assoc())
                {
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
                    $jsondataperson["Form"] = $fila["Form"];
                    $jsondataList[]=$jsondataperson;
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
    public function sqlReporteContratos($busqueda,$limit,$offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if($busqueda==1){
                $count = "SELECT COUNT(id_Articulo) as  totalCount 
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato 
                        WHERE CURDATE() BETWEEN DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') 
                        AND DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d')
                        AND Art.sucursal = $sucursal 
                        ORDER BY Con.id_contrato";
                $resultado = $this->conexion->query($count);
                $fila = $resultado ->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
            }else{
                $BusquedaQuery = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM,  
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Con.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO,
                        Art.descripcionCorta AS DESCRIPCION,
                        Art.observaciones as ObserArt,
                        Aut.observaciones as ObserAuto,
                        Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato 
                        WHERE CURDATE() BETWEEN DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') 
                        AND DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d')
                        AND Art.sucursal = $sucursal 
                        ORDER BY Con.id_contrato LIMIT ".$this->conexion->real_escape_string($limit)." 
                    OFFSET ".$this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while($fila = $resultado ->fetch_assoc())
                {
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
                    $jsondataperson["Form"] = $fila["Form"];
                    $jsondataList[]=$jsondataperson;
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
    public function sqlReporteDesempeno($busqueda,$fechaIni,$fechaFin,$limit,$offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if($busqueda==1){
                $count = "SELECT COUNT(ConM.id_contrato) as  totalCount 
                        FROM contrato_mov_tbl AS ConM
                        INNER JOIN contratos_tbl AS Con ON ConM.id_contrato = Con.id_Contrato
                        WHERE DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 5 OR ConM.tipo_movimiento = 9 )  
                        ORDER BY ConM.id_contrato";
                $resultado = $this->conexion->query($count);
                $fila = $resultado ->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
            }else{
                $BusquedaQuery = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') AS FECHAMOV,
                        DATE_FORMAT(ConM.fechaVencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        ConM.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO, 
                        ConM.e_interes AS INTERESES,  ConM.e_almacenaje AS ALMACENAJE, 
                        ConM.e_seguro AS SEGURO,  ConM.e_abono as ABONO,ConM.s_descuento_aplicado as DESCU,
                        ConM.e_iva as IVA, ConM.e_costoContrato AS COSTO, Con.id_Formulario as FORMU,
                         ConM.pag_subtotal,  ConM.pag_total
                        FROM contrato_mov_tbl AS ConM
                        INNER JOIN contratos_tbl AS Con ON ConM.id_contrato = Con.id_Contrato
                        WHERE DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 5 OR ConM.tipo_movimiento = 9 )  
                        ORDER BY ConM.id_contrato LIMIT ".$this->conexion->real_escape_string($limit)." 
                    OFFSET ".$this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while($fila = $resultado ->fetch_assoc())
                {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["FECHAMOV"] = $fila["FECHAMOV"];
                    $jsondataperson["FECHAVEN"] = $fila["FECHAVEN"];
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
                    $jsondataList[]=$jsondataperson;
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
    public function sqlReporteRefrendo($busqueda,$fechaIni,$fechaFin,$limit,$offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if($busqueda==1){
                $count = "SELECT COUNT(ConM.id_contrato) as  totalCount 
                        FROM contrato_mov_tbl AS ConM
                        INNER JOIN contratos_tbl AS Con ON ConM.id_contrato = Con.id_Contrato
                        WHERE DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 4 OR ConM.tipo_movimiento = 8 )  
                        ORDER BY ConM.id_contrato";
                $resultado = $this->conexion->query($count);
                $fila = $resultado ->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
            }else{
                $BusquedaQuery = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') AS FECHAMOV,
                        DATE_FORMAT(ConM.fechaVencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        ConM.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO, 
                        ConM.e_interes AS INTERESES,  ConM.e_almacenaje AS ALMACENAJE, 
                        ConM.e_seguro AS SEGURO,  ConM.e_abono as ABONO,ConM.s_descuento_aplicado as DESCU,
                        ConM.e_iva as IVA, ConM.e_costoContrato AS COSTO, Con.id_Formulario as FORMU,
                         ConM.pag_subtotal,  ConM.pag_total
                        FROM contrato_mov_tbl AS ConM
                        INNER JOIN contratos_tbl AS Con ON ConM.id_contrato = Con.id_Contrato
                        WHERE DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 4 OR ConM.tipo_movimiento = 8 )  
                        ORDER BY ConM.id_contrato LIMIT ".$this->conexion->real_escape_string($limit)." 
                    OFFSET ".$this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while($fila = $resultado ->fetch_assoc())
                {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["FECHAMOV"] = $fila["FECHAMOV"];
                    $jsondataperson["FECHAVEN"] = $fila["FECHAVEN"];
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
                    $jsondataList[]=$jsondataperson;
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
    public function sqlReporteBazar($busqueda,$limit,$offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if($busqueda==1){
                $count = "SELECT COUNT(Baz.id_Contrato) as  totalCount 
                        FROM articulo_bazar_tbl as Baz
                        LEFT JOIN cat_adquisicion AS CAT on Baz.id_serieTipo = CAT.id_Adquisicion
                        WHERE tipo_movimiento!= 6 and Baz.sucursal=$sucursal";
                $resultado = $this->conexion->query($count);
                $fila = $resultado ->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
            }else{
                $BusquedaQuery = "SELECT DATE_FORMAT(fecha_Bazar,'%Y-%m-%d') as FECHA, id_Contrato,id_serie,vitrinaVenta AS precio_venta, 
                        descripcionCorta as Detalle,CAT.descripcion as CatDesc
                        FROM articulo_bazar_tbl as Baz
                        LEFT JOIN cat_adquisicion AS CAT on Baz.id_serieTipo = CAT.id_Adquisicion
                        WHERE fisico= 1 AND HayMovimiento=0 AND Baz.sucursal=$sucursal
                        LIMIT ".$this->conexion->real_escape_string($limit)." 
                    OFFSET ".$this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while($fila = $resultado ->fetch_assoc())
                {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["id_Contrato"] = $fila["id_Contrato"];
                    $jsondataperson["id_serie"] = $fila["id_serie"];
                    $jsondataperson["precio_venta"] = $fila["precio_venta"];
                    $jsondataperson["Detalle"] = $fila["Detalle"];
                    $jsondataperson["CatDesc"] = $fila["CatDesc"];
                    $jsondataList[]=$jsondataperson;
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
    public function sqlReporteCompras($busqueda,$fechaIni,$fechaFin,$limit,$offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if($busqueda==1){
                $count = "SELECT COUNT(Baz.id_Contrato) as  totalCount 
                        FROM articulo_bazar_tbl as Baz
                        LEFT JOIN cat_adquisicion AS CAT on Baz.id_serieTipo = CAT.id_Adquisicion
                        WHERE fecha_Bazar  >=  '$fechaIni'
                        AND fecha_Bazar  <=  '$fechaFin' 
                        AND id_serieTipo=2  AND Baz.sucursal=$sucursal";
                $resultado = $this->conexion->query($count);
                $fila = $resultado ->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
            }else{
                $BusquedaQuery = "SELECT DATE_FORMAT(fecha_Bazar,'%Y-%m-%d') as FECHA, id_Contrato,id_serie,vitrinaVenta AS precio_venta, 
                        descripcionCorta as Detalle,CAT.descripcion as CatDesc
                        FROM articulo_bazar_tbl 
                        LEFT JOIN cat_adquisicion AS CAT on id_serieTipo = CAT.id_Adquisicion
                        WHERE fecha_Bazar  >=  '$fechaIni'
                        AND fecha_Bazar  <=  '$fechaFin' 
                        AND id_serieTipo=2  AND sucursal=$sucursal LIMIT ".$this->conexion->real_escape_string($limit)." 
                    OFFSET ".$this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while($fila = $resultado ->fetch_assoc())
                {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["id_Contrato"] = $fila["id_Contrato"];
                    $jsondataperson["id_serie"] = $fila["id_serie"];
                    $jsondataperson["precio_venta"] = $fila["precio_venta"];
                    $jsondataperson["Detalle"] = $fila["Detalle"];
                    $jsondataperson["CatDesc"] = $fila["CatDesc"];
                    $jsondataList[]=$jsondataperson;
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
    public function sqlReporteInventarios($busqueda,$limit,$offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if($busqueda==1){
                $count = "SELECT COUNT(id_Articulo) as  totalCount 
                            FROM articulo_tbl AS ART 
                            LEFT JOIN contratos_tbl AS Con on ART.id_Contrato = Con.id_Contrato
                            LEFT JOIN cat_adquisicion AS CAT on ART.Adquisiciones_Tipo = CAT.id_Adquisicion
                            WHERE Con.fisico = 1
                            AND sucursal = $sucursal";
                $resultado = $this->conexion->query($count);
                $fila = $resultado ->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
            }else{
                $BusquedaQuery = "SELECT DATE_FORMAT(ART.fecha_creacion,'%Y-%m-%d') as FECHA, ART.id_Contrato,
                        CONCAT (id_SerieSucursal,Adquisiciones_Tipo,id_SerieContrato,id_SerieArticulo) as id_serie,
                        vitrina AS precio_venta, 
                        descripcionCorta as Detalle,CAT.descripcion as CatDesc
                        FROM articulo_tbl AS ART 
                        LEFT JOIN contratos_tbl AS Con on ART.id_Contrato = Con.id_Contrato
                        LEFT JOIN cat_adquisicion AS CAT on tipoArticulo = CAT.id_Adquisicion
                        WHERE Con.fisico = 1 AND sucursal = $sucursal LIMIT ".$this->conexion->real_escape_string($limit)." 
                    OFFSET ".$this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while($fila = $resultado ->fetch_assoc())
                {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["id_Contrato"] = $fila["id_Contrato"];
                    $jsondataperson["id_serie"] = $fila["id_serie"];
                    $jsondataperson["precio_venta"] = $fila["precio_venta"];
                    $jsondataperson["Detalle"] = $fila["Detalle"];
                    $jsondataperson["CatDesc"] = $fila["CatDesc"];
                    $jsondataList[]=$jsondataperson;
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
    public function sqlReporteVentas($busqueda,$fechaIni,$fechaFin,$limit,$offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if($busqueda==1){
                $count = "SELECT COUNT(id_ventas) as  totalCount 
                        FROM bit_ventas as Con
                        WHERE fecha_Creacion  >=  '$fechaIni'
                        AND fecha_Creacion  <=  '$fechaFin' 
                        AND sucursal=$sucursal";
                $resultado = $this->conexion->query($count);
                $fila = $resultado ->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
            }else{
                $BusquedaQuery = "SELECT DATE_FORMAT(Ven.fecha_Creacion,'%Y-%m-%d') as FECHA, id_Contrato,id_serie,vitrinaVenta AS precio_venta, 
                        descripcionCorta as Detalle,descuento_Venta,CAT.descripcion as CatDesc
                        FROM bit_ventas as Ven
                        LEFT JOIN articulo_bazar_tbl AS ART on Ven.id_ArticuloBazar = ART.id_ArticuloBazar
                        LEFT JOIN contrato_mov_baz_tbl AS Con on Con.id_Bazar = Ven.id_Bazar
                        LEFT JOIN cat_adquisicion AS CAT on id_serieTipo = CAT.id_Adquisicion
                        WHERE Ven.fecha_Creacion  >=  '$fechaIni'
                        AND Ven.fecha_Creacion  <=  '$fechaFin' 
                        AND Ven.sucursal=$sucursal LIMIT ".$this->conexion->real_escape_string($limit)." 
                      OFFSET ".$this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while($fila = $resultado ->fetch_assoc())
                {
                    $jsondataperson = array();
                    $jsondataperson["FECHA"] = $fila["FECHA"];
                    $jsondataperson["id_Contrato"] = $fila["id_Contrato"];
                    $jsondataperson["id_serie"] = $fila["id_serie"];
                    $jsondataperson["precio_venta"] = $fila["precio_venta"];
                    $jsondataperson["Detalle"] = $fila["Detalle"];
                    $jsondataperson["descuento_Venta"] = $fila["descuento_Venta"];
                    $jsondataperson["CatDesc"] = $fila["CatDesc"];
                    $jsondataList[]=$jsondataperson;
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
    public function sqlReporteIngresos($busqueda,$fechaIni,$fechaFin,$limit,$offset)
    {
        try {
            $sucursal = $_SESSION["sucursal"];
            $jsondata = array();
            if($busqueda==1){
                $count = "SELECT COUNT(id_CierreSucursal) as  totalCount 
                       FROM bit_cierresucursal
                       WHERE DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin' 
                       AND sucursal = $sucursal  ORDER BY id_CierreSucursal";
                $resultado = $this->conexion->query($count);
                $fila = $resultado ->fetch_assoc();
                $jsondata['totalCount'] = $fila['totalCount'];
            }else{
                $BusquedaQuery = "SELECT id_CierreSucursal,capitalRecuperado as Desem,abonoCapital as AbonoRef,intereses as Inte,
                       costoContrato as costoContrato,iva as Iva,mostrador as Ventas,iva_venta as IvaVenta,
                       utilidadVenta as Utilidad, apartados as Apartados,abonoVentas as AbonoVen, 
                       DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') as Fecha 
                       FROM bit_cierresucursal
                       WHERE DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin' 
                       AND sucursal = $sucursal  ORDER BY id_CierreSucursal 
                       LIMIT ".$this->conexion->real_escape_string($limit)." 
                      OFFSET ".$this->conexion->real_escape_string($offset);
                $resultado = $this->conexion->query($BusquedaQuery);
                while($fila = $resultado ->fetch_assoc())
                {
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

                    $jsondataList[]=$jsondataperson;
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

    public function reporteMon($tipo,$fechaIni,$fechaFin)
    {
        $datos = array();
        try {
            $sucursal = $_SESSION["sucursal"];
            $buscar = "SELECT Bit.id_BitacoraToken,Bit.id_Contrato,Bit.tipo_formulario,Bit.token,Bit.descripcion,
                        Bit.descuento,Bit.interes, Cat.descripcion as Descripcion, Usu.usuario,Bit.importe_flujo,Bit.id_flujo,
                        DATE_FORMAT(Bit.fecha_Creacion,'%Y-%m-%d') as Fecha FROM bit_token as Bit
                        INNER JOIN cat_token_movimiento as Cat on Bit.id_tokenMovimiento = Cat.id_tokenMovimiento
                        LEFT JOIN usuarios_tbl as Usu on Bit.usuario = Usu.id_User  ";
            if($tipo==0){
                $buscar .= " WHERE Bit.fecha_Creacion BETWEEN '$fechaIni' 
                            AND '$fechaFin' AND Bit.sucursal = $sucursal  ORDER BY Bit.id_BitacoraToken";
            }else{
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


}