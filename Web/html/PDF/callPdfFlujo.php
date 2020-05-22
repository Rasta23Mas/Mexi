<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
require_once(WEB_PATH . "dompdf/autoload.inc.php");

use Dompdf\Dompdf;


if (!isset($_SESSION)) {
    session_start();
}
$usuario = $_SESSION["idUsuario"];
$sucursal = $_SESSION["sucursal"];
$idCierreCaja = $_SESSION["idCierreCaja"];

//Sucursal
$sucNombre = "";
$sucDireccion = "";
$sucTelefono = "";
$sucNombreCasa = "";
$sucRfc = "";
//Arqueo

$fecha_Creacion = "";

$web = 2;
if ($web == 1) {
    $server = "localhost";
    $user = "u672450412_root";
    $password = "12345";
    $db = "u672450412_Mexicash";
} else {
    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "mexicash";
}


$mysql = new  mysqli($server, $user, $password, $db);
if (isset($_GET['folio'])) {
    $idFolio = $_GET['folio'];


}

$buscarFlujo = "SELECT Cat.descripcion as Descrip,Flu.importe as Importe,Flu.importeLetra as ImporteLetra,Usu.usuario as User, Flu.usuarioCaja as UserCaja,
                Flu.concepto as Concepto,fechaCreacion as FechaCreacion
                FROM flujo_tbl as Flu 
                INNER JOIN cat_flujo as Cat on Flu.id_cat_flujo = Cat.id_CatFlujo 
                INNER JOIN usuarios_tbl as Usu on Flu.usuario = Usu.id_User 
                WHERE id_flujo = $idFolio ";

$flujo = $mysql->query($buscarFlujo);

foreach ($flujo as $fila) {
    $Desc = $fila['Descrip'];
    $Importe = $fila['Importe'];
    $ImporteLetra = $fila['ImporteLetra'];
    $User = $fila['User'];
    $UserCaja = $fila['UserCaja'];
    $Concepto = $fila['Concepto'];
    $fecha_Creacion = $fila['FechaCreacion'];
}

//Con PHP: 2 decimales separados por comas y miles por punto.
$ImporteFormat = number_format($Importe, 2,'.',',');
if($UserCaja!=0){
    $buscarVendedor = "SELECT Usu.usuario as UserCaja FROM flujo_tbl as Flu
    INNER JOIN usuarios_tbl as Usu on Flu.usuarioCaja = Usu.id_User      
    WHERE id_flujo = $idFolio";
    $folio = $mysql->query($buscarVendedor);
    foreach ($folio as $fila) {
        $Vendedor = $fila['UserCaja'];
    }
}

$buscar = "SELECT Nombre, direccion, telefono, NombreCasa,rfc FROM cat_sucursal WHERE id_Sucursal = " . $sucursal;
$contrato = $mysql->query($buscar);
foreach ($contrato as $fila) {
    $sucNombre = $fila['Nombre'];
    $sucDireccion = $fila['direccion'];
    $sucTelefono = $fila['telefono'];
    $sucNombreCasa = $fila['NombreCasa'];
    $sucRfc = $fila['rfc'];
}

$newFechaCreacion = date("d-m-Y", strtotime($fecha_Creacion));

if (!isset($_GET['pdf'])) {
    $contenido = '<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
            <script src="../../JavaScript/funcionesFlujo.js"></script>

    <style>
        .letraNormalNegrita {
            font-size: 1.2em;
            font-weight: bold;
        }

        .letraGrandeNegrita {
            font-size: 1.6em;
            font-weight: bold;
        }

        .letraChicaNegrita {
            font-size: .8em;
            font-weight: bold;
        }

        .letraNormal {
            font-size: 1.2em;
        }

        .letraGrande {
            font-size: 1.6em;
        }

        .letraChica {
            font-size: .8em;
        }
        .btn{
        color: #0099CC;
        background: transparent;
        border: 2px solid #0099CC;
        border-radius: 6px;
      padding: 16px 32px;
      text-align: center;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      -webkit-transition-duration: 0.4s; /* Safari */
      transition-duration: 0.4s;
      cursor: pointer;
      text-decoration: none;
      text-transform: uppercase;
}
        }
        .btnGenerarPDF {
        background-color: white; 
        color: black; 
        border: 2px solid #008CBA;
        }
        .btnGenerarPDF:hover {
        background-color: #008CBA;
        color: white;
        }
        
        .borderBlue{
        border-style: solid;
         border-color: dodgerblue;
          border-collapse: collapse;
        }
        
        .tdborderBlue{
        border-style: solid;
         border-color: dodgerblue;
          border-collapse: collapse;
            padding: 10px;
        }
    </style>
    <script>
       var a = NumeroALetras(550.5);
   alert(a);
</script>
</head>
<body >
<form align="center">';
    $contenido .= '  <div class="container-fluid">
        <div>
            <br>
        </div>
        <div class="row">
            <div class="col-12" >
                <table width="30%" border="1" align="center" >
                    <tr><td align="center" class="letraNormalNegrita" colspan="2"><label >' . $sucNombreCasa . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraNormalNegrita" colspan="2"><label > SUCURSAL: ' . $sucNombre . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraNormalNegrita" colspan="2"><label >' . $sucDireccion . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraNormalNegrita" colspan="2"><label>TEL: ' . $sucTelefono . '</label>&nbsp;<label >RFC: ' . $sucRfc . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraNormalNegrita" colspan="2">**********
                        </td></tr>
                    <tr><td align="center" class="letraGrandeNegrita" colspan="2"><label >'.$Desc.'</label>
                        </td></tr>
                    <tr><td align="center" class="letraNormalNegrita" colspan="2">**********
                        </td></tr>
                    <tr><td  align="center" colspan="2" class="letraGrandeNegrita" ><label>Folio:'.$idFolio.'</label>
                        </td></tr>
                    <tr> <td colspan="2">&nbsp;
                        </td></tr> 
                    <tr><td  align="right" ><label>Fecha:</label></td><td  align="left" ><label >'.$fecha_Creacion.'</label>
                        </td></tr>
                    <tr><td  align="right" ><label>Concepto:</label></td><td  align="left"><label >'.$Concepto.'</label>
                        </td></tr>';
if($UserCaja!=0) {
    $contenido .= ' 
                    <tr><td  align="right" ><label>Usuario Caja:</label></td><td align="left"><label >' . $Vendedor . '</label></td></tr>';
}
    $contenido .= '  
                    <tr><td  align="right" ><label>Importe:</label></td><td  align="left"><label >$'.$ImporteFormat.'</label>
                    </td></tr>
                    <tr><td  align="right" ><label>Importe en letra:</label></td><td  align="left"><label >'.$ImporteLetra.'</label>
                    </td></tr>
                    <tr>
                        <td colspan="2">
                            <br>
                        </td>
                    </tr>';
    $contenido .= '<tr><td align="center" colspan="4">
        <input type="button" class="btn btnGenerarPDF" value="Generar PDF"  onclick="verPDFDepositaria(' . $idFolio . ');" >
        </td></tr>';
    $contenido .= '</table></div></div>
    </div></form></body></html>';
    echo $contenido;
    exit;
}
$contenido = '<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .letraNormalNegrita{
          font-size: .6em;
          font-weight: bold;
         }
          .letraGrandeNegrita{
          font-size: 1em;
          font-weight: bold;
         }
          .letraChicaNegrita{
          font-size: .4em;
          font-weight: bold;
         }
          .letraNormal{
          font-size: .6em;
         }
          .letraGrande{
          font-size: 1em;
         }
          .letraChica{
          font-size: .4em;
         }
         
         .tableColl {
        border-collapse: collapse;
        }
        .tdAlto{
        height: 20px;
        }

    </style>
</head>
<body>
<form>';
$contenido .= '  <div class="container-fluid">
        <div>
            <br>
        </div>
        <div class="row" >
            <div class="col-12" >';
                $contenido .= '  <div class="container-fluid">
        <div>
            <br>
        </div>
        <div class="row">
            <div class="col-12" >
                <table width="40%" border="0" align="center" >
                    <tr><td align="center" class="letraGrandeNegrita" colspan="2"><label >' . $sucNombreCasa . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraGrandeNegrita" colspan="2"><label > SUCURSAL: ' . $sucNombre . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraGrandeNegrita" colspan="2"><label >' . $sucDireccion . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraGrandeNegrita" colspan="2"><label>TEL: ' . $sucTelefono . '</label>&nbsp;<label >RFC: ' . $sucRfc . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraGrandeNegrita" colspan="2">**********
                        </td></tr>
                    <tr><td align="center" class="letraGrandeNegrita" colspan="2"><label >'.$Desc.'</label>
                        </td></tr>
                    <tr><td align="center" class="letraGrandeNegrita" colspan="2">**********
                        </td></tr>
                    <tr><td  align="center" colspan="2" class="letraGrandeNegrita" ><label>Folio:'.$idFolio.'</label>
                        </td></tr>
                    <tr> <td colspan="2">&nbsp;
                        </td></tr> 
                    <tr><td  align="right"   class="letraGrande"><label>Fecha:</label></td><td  align="left" class="letraGrande"><label >'.$fecha_Creacion.'</label>
                        </td></tr>
                    <tr><td  align="right" class="letraGrande"><label>Concepto:</label></td><td  align="left" class="letraGrande"><label >'.$Concepto.'</label>
                        </td></tr>';
if($UserCaja!=0) {
    $contenido .= ' 
                    <tr><td  align="right" class="letraGrande"><label>Usuario Caja:</label></td><td align="left" class="letraGrande"><label >' . $Vendedor . '</label></td></tr>';
}
    $contenido .= '  
                    <tr><td  align="right" class="letraGrande"><label>Importe:</label></td><td  align="left" class="letraGrande"><label >$'.$ImporteFormat.'</label>
                    </td></tr>
                    <tr><td  align="right" class="letraGrande"><label>Importe en letra:</label></td><td  align="left" class="letraGrande"><label >'.$ImporteLetra.'</label>
                    </td></tr>
                    <tr>
                        <td colspan="2">
                            <br>
                        </td>
                    </tr>
            <tr> <td>&nbsp;</td><td>
            <tr> <td>&nbsp;</td><td>
              <tr><td  align="center" colspan="2" class="letraGrandeNegrita"><label>Firma</label></td>
            </tr>
                        <tr> <td colspan="2">&nbsp;</td></tr>
                          <tr> <td>&nbsp;</td><td>
                   
 <tr>  <td colspan="2">&nbsp;</td></tr>
          <tr><td  align="center" colspan="2" class="letraGrandeNegrita"><label>_____________________</label></td>
            </tr>
                                <tr><td  colspan="2"  align="center" class="letraGrande"><label >'.$User.'</label>

         ';

$contenido .= '</tbody></table></form></body></html>';

$nombreContrato = 'Arqueo Caja ' . $idCierreCaja . ".pdf";
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
//Horizontal
//$dompdf->setPaper('letter', 'landscape');
//letter carta, legal oficio
//Vertical
$dompdf->setPaper('letter', 'portrait');

$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
