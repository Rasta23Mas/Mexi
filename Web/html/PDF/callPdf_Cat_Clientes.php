<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "Conectar.php");
require_once(WEB_PATH . "dompdf/autoload.inc.php");

use Dompdf\Dompdf;


$sucursal='';
if (isset($_GET['sucursal'])) {
    $sucursal = $_GET['sucursal'];
}


$ID = "";
$NOMBRE = "";
$FECHA ="";
$SEXO = "";
$DIRECCION = "";
$MENSAJE = "";
$PROMOCION = "";



$contenido = '<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        font-size: .5em;
        width: 100%;
    }
    
    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 6px;
    }
    
    tr:nth-child(even) {
        background-color: #dddddd;
    }

    </style>
</head>
<body>
<form>';
$contenido .= '
                    <center><h3><b>Clientes</b></h3></center>
                    <br>
         <table  width="100%"border="1">
                        <thead style="background: dodgerblue; color:white;">
                            <tr align="center">
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Fecha Nacimiento</th>
                                <th>Sexo</th>
                                <th>Dirección</th>
                                <th>Mensaje</th>
                                <th>Como se entero</th>
                            </tr>
                        </thead>
                        <tbody id="idTBodyInventario"  align="center">
                        ';
$query = "SELECT id_Cliente,fecha_Nacimiento,
                        CONCAT(apellido_Pat,'/',  apellido_Mat, '/', nombre) AS NombreCompleto, 
                        CONCAT(calle, ', ',num_interior,', ', num_exterior, ', ',localidad, ', ', municipio, 
                        ', ', cat_estado.descripcion ) AS direccionCompleta,  Sex.descripcion as Sexo,
                        PROM.descripcion as Promo, mensaje
                        FROM cliente_tbl
                        INNER JOIN cat_estado ON cliente_tbl.estado = cat_estado.id_Estado
                        LEFT JOIN cat_cliente AS SEX ON cliente_tbl.sexo = Sex.id_Cat_Cliente
                        LEFT JOIN cat_cliente AS PROM ON cliente_tbl.promocion = PROM.id_Cat_Cliente
                        WHERE sucursal =$sucursal";
$resultado = $db->query($query);
$tipoMetal = 0;
$tipoElectro = 0;
$tipoAuto = 0;
$tablaArticulos = '';

foreach ($resultado as $row) {
    $ID = $row["id_Cliente"];
    $FECHA = $row["fecha_Nacimiento"];
    $NOMBRE = $row["NombreCompleto"];
    $DIRECCION = $row["direccionCompleta"];
    $SEXO = $row["Sexo"];
    $PROMOCION = $row["Promo"];
    $MENSAJE = $row["mensaje"];

    $tablaArticulos .= '<tr><td >' . $ID . '</td>
                        <td>' . $FECHA . '</td>
                        <td>' . $NOMBRE . '</td>
                        <td>' . $DIRECCION . '</td>
                        <td>' . $SEXO . '</td>
                        <td>' . $PROMOCION . '</td>
                        <td>' . $MENSAJE . '</td>
                        </tr>';
}

$contenido .= $tablaArticulos;
$contenido .='
                        </tbody>
                        </table>';
$contenido .= '</form></body></html>';

$nombreContrato = 'Catalogo_Clientes.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
