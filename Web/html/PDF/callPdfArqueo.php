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
$mil_cant = 0;
$quinientos_cant = 0;
$doscientos_cant = 0;
$cien_cant = 0;
$cincuenta_cant = 0;
$veinte_cant = 0;
$veinteMon_cant = 0;
$diez_cant = 0;
$cinco_cant = 0;
$dos_cant = 0;
$uno_cant = 0;
$cincuentaMon_cant = 0;
$centavos_cant = 0;
$mil_efe = 0;
$quinientos_efe= 0;
$doscientos_efe = 0;
$cien_efe = 0;
$cincuenta_efe = 0;
$veinte_efe = 0;
$veinteMon_efe = 0;
$diez_efe = 0;
$cinco_efe = 0;
$dos_efe = 0;
$uno_efe = 0;
$cincuentaMon_efe = 0;
$centavos = 0;
$totalBilletes = 0;
$totalMonedas = 0;
$totalArqueo = 0;
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

if (isset($_GET['idArqueo'])) {
    $idArqueo = $_GET['idArqueo'];
}

$buscarArqueo = "
    SELECT total_Cierre,total_Billetes,total_Monedas,
    mil_cant,quinientos_cant,doscientos_cant,cien_cant,cincuenta_cant,veinte_cant,veinteMon_cant,diez_cant,cinco_cant,dos_cant,
    uno_cant,cincuentaMon_cant,centavos_cant,mil_efe,quinientos_efe,doscientos_efe,cien_efe,cincuenta_efe,veinte_efe,
    veinteMon_efe,diez_efe,cinco_efe,dos_efe,uno_efe,cincuentaMon_efe,centavos,fecha_Creacion,ajustes,incremento_pat
FROM
    bit_arqueo
    WHERE id_Arqueo = $idArqueo ";
$arqueo = $mysql->query($buscarArqueo);
foreach ($arqueo as $fila) {
    $totalArqueo = $fila['total_Cierre'];
    $totalBilletes = $fila['total_Billetes'];
    $totalMonedas = $fila['total_Monedas'];
    $mil_cant = $fila['mil_cant'];
    $quinientos_cant = $fila['quinientos_cant'];
    $doscientos_cant = $fila['doscientos_cant'];
    $cien_cant = $fila['cien_cant'];
    $cincuenta_cant = $fila['cincuenta_cant'];
    $veinte_cant = $fila['veinte_cant'];
    $veinteMon_cant = $fila['veinteMon_cant'];
    $diez_cant = $fila['diez_cant'];
    $cinco_cant = $fila['cinco_cant'];
    $dos_cant = $fila['dos_cant'];
    $uno_cant = $fila['uno_cant'];
    $cincuentaMon_cant = $fila['cincuentaMon_cant'];
    $centavos_cant = $fila['centavos_cant'];
    $mil_efe = $fila['mil_efe'];
    $quinientos_efe = $fila['quinientos_efe'];
    $doscientos_efe = $fila['doscientos_efe'];
    $cien_efe = $fila['cien_efe'];
    $cincuenta_efe = $fila['cincuenta_efe'];
    $veinte_efe = $fila['veinte_efe'];
    $veinteMon_efe = $fila['veinteMon_efe'];
    $diez_efe = $fila['diez_efe'];
    $cinco_efe = $fila['cinco_efe'];
    $dos_efe = $fila['dos_efe'];
    $uno_efe = $fila['uno_efe'];
    $cincuentaMon_efe = $fila['cincuentaMon_efe'];
    $centavos = $fila['centavos'];
    $fecha_Creacion = $fila['fecha_Creacion'];
    $ajustes = $fila['ajustes'];
    $incremento_pat = $fila['incremento_pat'];
}


//Con PHP: 2 decimales separados por comas y miles por punto.
$totalArqueo = number_format($totalArqueo, 2,'.',',');
$totalBilletes = number_format($totalBilletes, 2,'.',',');
$totalMonedas = number_format($totalMonedas, 2,'.',',');



$mil_efe = number_format($mil_efe, 2,'.',',');
$quinientos_efe = number_format($quinientos_efe, 2,'.',',');
$doscientos_efe = number_format($doscientos_efe, 2,'.',',');
$cien_efe = number_format($cien_efe, 2,'.',',');
$cincuenta_efe = number_format($cincuenta_efe, 2,'.',',');
$veinte_efe = number_format($veinte_efe, 2,'.',',');
$veinteMon_efe = number_format($veinteMon_efe, 2,'.',',');
$diez_efe = number_format($diez_efe, 2,'.',',');
$cinco_efe = number_format($cinco_efe, 2,'.',',');
$dos_efe = number_format($dos_efe, 2,'.',',');
$uno_efe = number_format($uno_efe, 2,'.',',');
$cincuentaMon_efe = number_format($cincuentaMon_efe, 2,'.',',');
$centavos = number_format($centavos, 2,'.',',');


$mysql = new  mysqli($server, $user, $password, $db);
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
            <script src="../../JavaScript/funcionesArqueo.js"></script>

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
</head>
<body >
<form align="center">';
    $contenido .= '  <div class="container-fluid">
        <div>
            <br>
        </div>
        <div class="row">
            <div class="col-12" >
                <table width="80%" border="0" align="center" >
                    <tr><td align="center" class="letraNormalNegrita" colspan="4"><label >' . $sucNombreCasa . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraNormalNegrita" colspan="4"><label > SUCURSAL: ' . $sucNombre . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraNormalNegrita" colspan="4"><label >' . $sucDireccion . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraNormalNegrita" colspan="4"><label>TEL: ' . $sucTelefono . '</label>&nbsp;<label >RFC: ' . $sucRfc . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraNormalNegrita" colspan="4">ARQUEO DE CAJA
                    </td></tr>
                    <tr>
                    <td colspan="4"> <br>
                    </td>
                    </tr>
                    <tr>
                        <td align="center"  colspan="2" style="width: 700px;">
                            <table width="50%" class="borderBlue">
                                <tr style="background: dodgerblue; color:white;" >
                                    <td align="center" colspan="5" >
                                        <label>BILLETES</label>
                                    </td>
                                </tr>
                                <tr >
                                    <td colspan="2" align="right" style="width: 40%"><label> $1,000.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idMilCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center" value="' . $mil_cant . '" disabled/></td>
                                    <td colspan="2" align="right" style="width: 20%"><label id="lblMil"> $' . $mil_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" style="width: 40%"><label> $500.00</label></td>
                                    <td  align="center" style="width: 70px"/>
                                        <input type="text" name="billete" placeholder="0" id="idQuinientosCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center" value="' . $quinientos_cant . '" disabled/></td>
                                    <td colspan="2" align="right"><label id="lblQuinientos"> $' . $quinientos_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" style="width: 40%"><label>  $200.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idDoscientosCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center" value=" ' . $doscientos_cant . '" disabled/></td>
                                    <td colspan="2" align="right"><label id="lblDoscientos"> $' . $doscientos_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" style="width: 40%"><label>  $100.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCienCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center" value=" ' . $cien_cant . '" disabled/></td>
                                    <td colspan="2" align="right"><label id="lblCien"> $' . $cien_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" style="width: 40%"><label>  $50.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCincuentaCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center" value=" ' . $cincuenta_cant . '" disabled/></td>
                                    <td colspan="2" align="right"><label id="lblCincuenta"> $' . $cincuenta_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" style="width: 40%" ><label>  $20.00</label></td>
                                    <td  align="center" style="width: 70px" >
                                        <input type="text" name="billete" placeholder="0" id="idVeinteCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center" value=" ' . $veinte_cant . '" disabled/></td>
                                    <td colspan="2" align="right" ><label id="lblVeinte"> $' . $veinte_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="center" style="width: 40%" >
                                        &nbsp;
                                    </td>
                                </tr>
                                 <tr>
                                    <td colspan="5" align="center" style="width: 40%" >
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr >
                                     <td colspan="5" align="left" class="tdborderBlue">
                                        TOTAL BILLETES:&nbsp;
                                        <label id="lblTotalBilletes"> $' . $totalBilletes . '</label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td align="center" colspan="2" style="width: 700px;">
                            <table class="borderBlue"  width="50%">
                                <tr style="background: dodgerblue; color:white;">
                                    <td align="center" colspan="5">
                                        <label>MONEDAS</label>
                                    </td>
                                </tr>
                                <tr >
                                    <td colspan="2" align="right" style="width: 40%"><label> $20.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idVeinteMonCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center" value=" ' . $veinteMon_cant . '" disabled/></td>
                                    <td colspan="2" align="right"><label id="lblVeinteMon"> $' . $veinteMon_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" style="width: 40%"><label> $10.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idDiezCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center" value=" ' . $diez_cant . '" disabled/></td>
                                    <td colspan="2" align="right"><label id="lblDiez"> $' . $diez_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" style="width: 40%"><label>  $5.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCincoCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center" value=" ' . $cinco_cant . '" disabled/></td>
                                    <td colspan="2" align="right"><label id="lblCinco"> $' . $cinco_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" style="width: 40%"><label>  $2.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idDosCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center" value=" ' . $dos_cant . '" disabled/></td>
                                    <td colspan="2" align="right"><label id="lblDos"> $' . $dos_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" style="width: 40%"><label>  $1.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idUnoCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center" value=" ' . $uno_cant . '" disabled/></td>
                                    <td colspan="2" align="right"><label id="lblUno"> $' . $uno_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" style="width: 40%"><label>  $0.50</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCincuentaCCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center" value=" ' . $cincuentaMon_cant . '" disabled/></td>
                                    <td colspan="2" align="right"><label id="lblCincuentaC"> $' . $cincuentaMon_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" style="width: 40%"><label>Centavos</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCentavosCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center" value=" ' . $centavos_cant . '" disabled/></td>
                                    <td colspan="2" align="right"><label id="lblCentavos"> $' . $centavos . '</label></td>
                                </tr>
                                 <tr>
                                    <td colspan="5" align="center" style="width: 40%" >
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="left" class="tdborderBlue">
                                        TOTAL MONEDAS:&nbsp;
                                  
                                        <label id="lblTotalMonedas">  $' . $totalMonedas . '</label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 150px;">
                        &nbsp;
</td>
                        <td align="left" >
                            <h4><label>TOTAL ARQUEO:  $' . $totalArqueo . '</label></h4>
                        </td>
                        <td>
                        &nbsp;
</td>
<td>
                        &nbsp;
</td>
                    </tr>';
    $contenido .= '<tr><td align="center" colspan="4">
        <input type="button" class="btn btnGenerarPDF" value="Generar PDF"  onclick="verPDFArqueo(' . $idArqueo . ');" >
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
        <div class="row">
            <div class="col-12" >
                <table width="80%" border="0" align="center">
                    <tr><td align="center" class="letraNormalNegrita" colspan="4"><label >' . $sucNombreCasa . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraNormalNegrita" colspan="4"><label > SUCURSAL: ' . $sucNombre . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraNormalNegrita" colspan="4"><label >' . $sucDireccion . '</label>
                        </td></tr>
                    <tr><td align="center" class="letraNormalNegrita" colspan="4"><label>TEL: ' . $sucTelefono . '</label>&nbsp;<label >RFC: ' . $sucRfc . '</label>
                        </td></tr>
                    <tr><td align="left" class="letraNormalNegrita" colspan="4">ARQUEO
                    </td></tr>
                       <tr><td align="left" class="letraNormalNegrita" colspan="4">FECHA: ' . $newFechaCreacion . '
                    </td></tr>
                    <tr>
                    <td colspan="4"> <br>
                    </td>
                    </tr>
                    <tr align="center">
                        <td align="center" width="10%"></td>
                        <td align="center" width="30%">
                         <table class="letraNormalNegrita tableColl" border="1" >
                                <tr >
                                    <td align="center" colspan="5" class="tdAlto">
                                        <label>BILLETES</label>
                                    </td>
                                </tr>
                                <tr >
                                    <td colspan="2" align="right" width="50px" class="tdAlto"><label> $1,000.00</label></td>
                                    <td  align="center" width="50px" >
                                        <label> ' . $mil_cant . '</label>
                                     </td>
                                    <td colspan="2" align="right" width="50px" ><label id="lblMil"> $' . $mil_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" class="tdAlto"><label> $500.00</label></td>
                                    <td  align="center" >
                                     <label> ' . $quinientos_cant . '</label>
                                    <td colspan="2" align="right"><label id="lblQuinientos"> $' . $quinientos_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" class="tdAlto"><label>  $200.00</label></td>
                                    <td  align="center">
                                     <label> ' . $doscientos_cant . '</label></td>
                                    <td colspan="2" align="right"><label id="lblDoscientos"> $' . $doscientos_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" class="tdAlto"><label>  $100.00</label></td>
                                    <td  align="center" >
                                    <label> ' . $cien_cant . '</label>
                                    </td>
                                    <td colspan="2" align="right"><label id="lblCien"> $' . $cien_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" class="tdAlto"><label>  $50.00</label></td>
                                    <td  align="center" >
                                             <label> ' . $cincuenta_cant . '</label>
                                    </td>
                                    <td colspan="2" align="right"><label id="lblCincuenta"> $' . $cincuenta_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" class="tdAlto"><label>  $20.00</label></td>
                                    <td  align="center">
                                             <label> ' . $veinte_cant . '</label>
                                    </td>
                                    <td colspan="2" align="right" ><label id="lblVeinte"> $' . $veinte_efe . '</label></td>
                                </tr>
                                <tr>
                                  <td colspan="5" align="left" class="tdAlto">
                                        &nbsp;
                                    </td>
              
                                </tr> 
                    <tr>
                                  <td colspan="5" align="left" class="tdAlto" style="border-top-style: hidden">
                                        &nbsp;
                                    </td>
              
                                </tr> 
                                <tr >
                                     <td colspan="5" align="left" class="tdAlto">
                                        TOTAL BILLETES:&nbsp;
                                        <label id="lblTotalBilletes"> $' . $totalBilletes . '</label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td align="center" width="30%">
                            <table class="letraNormalNegrita tableColl" border="1">
                                <tr >
                                    <td align="center" colspan="5" class="tdAlto">
                                        <label>MONEDAS</label>
                                    </td>
                                </tr>
                                <tr >
                                    <td colspan="2" align="right" style="width: 50px" class="tdAlto"><label> $20.00</label></td>
                                    <td  align="center" style="width: 50px">
                                    <label> ' . $veinteMon_cant . '</label>
                                    </td>
                                    <td colspan="2" align="right"  style="width: 50px"><label id="lblVeinteMon"> $' . $veinteMon_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" class="tdAlto"><label> $10.00</label></td>
                                    <td  align="center" >
                                    <label> ' . $diez_cant . '</label>
                                    </td>
                                    <td colspan="2" align="right"><label id="lblDiez"> $' . $diez_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" class="tdAlto"><label>  $5.00</label></td>
                                    <td  align="center" >
                                    <label> ' . $cinco_cant . '</label>
                                    </td>
                                    <td colspan="2" align="right"><label id="lblCinco"> $' . $cinco_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" class="tdAlto"><label>  $2.00</label></td>
                                    <td  align="center" >
                                    <label> ' . $dos_cant . '</label>
                                        </td>
                                    <td colspan="2" align="right"><label id="lblDos"> $' . $dos_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" class="tdAlto" ><label>  $1.00</label></td>
                                    <td  align="center">
                                    <label> ' . $uno_cant . '</label>
                                    </td>
                                    <td colspan="2" align="right"><label id="lblUno"> $' . $uno_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" class="tdAlto"><label>  $0.50</label></td>
                                    <td  align="center">
                                    <label> ' . $cincuentaMon_cant . '</label>
                                    </td>
                                    <td colspan="2" align="right"><label id="lblCincuentaC"> $' . $cincuentaMon_efe . '</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" class="tdAlto"><label>Centavos</label></td>
                                    <td  align="center">
                                    <label> ' . $centavos_cant . '</label>
                                   </td>
                                    <td colspan="2" align="right"><label id="lblCentavos"> $' . $centavos . '</label></td>
                                </tr>
                                 <tr>
                                    <td colspan="5" align="center" class="tdAlto">
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="left" class="tdAlto">
                                        TOTAL MONEDAS:&nbsp;
                                  
                                        <label id="lblTotalMonedas">  $' . $totalMonedas . '</label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td align="center" width="10%"></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" colspan="4" class="letraNormalNegrita">
                            <label>TOTAL ARQUEO:  $' . $totalArqueo . '</label>
                        </td>
                    </tr>
                     <tr>
                        <td colspan="4">
                            <br>
                        </td>
                    </tr>
                      <tr>
                        <td colspan="2" align="center">
                            ---------------------------
                        </td>
                        <td colspan="2" align="center">
                            ---------------------------
                        </td>
                    </tr>
                     <tr>
                         <td colspan="2" align="center" class="letraNormalNegrita">
                            GERENTE SUCURSAL
                        </td>
                        <td colspan="2" align="center" class="letraNormalNegrita">
                            CAJERO
                        </td>
                    </tr>
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
