<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
require_once(WEB_PATH . "dompdf/autoload.inc.php");
require_once (BASE_PATH . "Conectar.php");
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


if (isset($_GET['folio'])) {
    $idFolio = $_GET['folio'];


}
$buscarFlujo = "SELECT Cat.descripcion as Descrip,Flu.importe as Importe,Flu.importeLetra as ImporteLetra,Usu.usuario as User, Flu.usuarioCaja as UserCaja,
                Flu.concepto as Concepto,fechaCreacion as FechaCreacion
                FROM flujo_tbl as Flu 
                INNER JOIN cat_flujo as Cat on Flu.id_cat_flujo = Cat.id_CatFlujo 
                INNER JOIN usuarios_tbl as Usu on Flu.usuario = Usu.id_User 
                WHERE id_flujo = $idFolio ";

$flujo = $db->query($buscarFlujo);

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
    $folio = $db->query($buscarVendedor);
    foreach ($folio as $fila) {
        $Vendedor = $fila['UserCaja'];
    }
}

$buscar = "SELECT Nombre, direccion, telefono, NombreCasa,rfc FROM cat_sucursal WHERE id_Sucursal = " . $sucursal;
$contrato = $db->query($buscar);
foreach ($contrato as $fila) {
    $sucNombre = $fila['Nombre'];
    $sucDireccion = $fila['direccion'];
    $sucTelefono = $fila['telefono'];
    $sucNombreCasa = $fila['NombreCasa'];
    $sucRfc = $fila['rfc'];
}

$newFechaCreacion = date("d-m-Y", strtotime($fecha_Creacion));

$contenido = '<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .letraNormalNegrita{
          font-size: .4em;
          font-weight: bold;
         }
          .letraGrandeNegrita{
          font-size: .5em;
          font-weight: bold;
         }
          .letraChicaNegrita{
          font-size: .3em;
          font-weight: bold;
         }
          .letraNormal{
          font-size: .4em;
         }
          .letraGrande{
          font-size: .5em;
         }
          .letraChica{
          font-size: .3em;
         }
         
         .tableColl {
        border-collapse: collapse;
        }
        .tdAlto{
        height: 10px;
        }

    </style>
</head>
<body>
<form>';
$contenido .= '
                <table width="100%" border="0" align="center" >
                  <tr><td align="center" class="letraGrandeNegrita" colspan="2"><br>
                        </td></tr>
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
//echo $contenido;
//exit;
$nombreContrato = 'Flujo_' . $idFolio . ".pdf";
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
//$customPaper = array(0,0,ANCHO,Largo);
$customPaper = array(0,0,226.772,425.197);
$dompdf->setPaper($customPaper);
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
