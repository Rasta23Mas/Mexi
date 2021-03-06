
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

if (isset($_GET['tipoAjuste'])) {
    $tipoAjuste = $_GET['tipoAjuste'];
}
if (isset($_GET['idArqueo'])) {
    $idArqueo = $_GET['idArqueo'];
}
$buscarAjustes = "
    SELECT ajustes,incremento_pat,fecha_Creacion
FROM
    bit_arqueo
    WHERE id_Arqueo = $idArqueo ";
$arqueo = $db->query($buscarAjustes);
foreach ($arqueo as $fila) {
    $incremento_pat = $fila['incremento_pat'];
    $ajustes = $fila['ajustes'];
    $fecha_Creacion = $fila['fecha_Creacion'];
}

//Con PHP: 2 decimales separados por comas y miles por punto.
$ajustes = number_format($ajustes, 2,'.',',');
$incremento_pat = number_format($incremento_pat, 2,'.',',');

if($tipoAjuste==1){
    $Desc = "Ajuste";
    $ImporteFormat = $ajustes;
}else if($tipoAjuste==2){
    $Desc = "Incremento de Patrimonio";
    $ImporteFormat = $incremento_pat;

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
                <table width="30%" border="0" align="center" >
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
                    <tr><td  align="center" colspan="2" class="letraGrandeNegrita" ><label>Arqueo:'.$idArqueo.'</label>
                        </td></tr>
                    <tr> <td colspan="2">&nbsp;
                        </td></tr> 
                    <tr><td  align="right" class="letraNormalNegrita"><label>Fecha:</label></td>
                    <td  align="left" class="letraNormalNegrita"><label >'.$fecha_Creacion.'</label>
                        </td></tr>
                    <tr><td  align="right" class="letraNormalNegrita"><label>Importe:</label></td>
                    <td  align="left" class="letraNormalNegrita"><label >$'.$ImporteFormat.'</label>
                    </td></tr>
                    <tr>
                        <td colspan="2">
                            <br>
                        </td>
                    </tr>
                              <tr> <td>&nbsp;</td><td>
            <tr> <td>&nbsp;</td><td>
              <tr><td  align="center" colspan="2" class="letraGrandeNegrita"><label>Firmas</label></td>
            </tr>
            <tr> <td colspan="2">&nbsp;</td></tr>
            <tr> <td colspan="2">&nbsp;</td></tr>
            <tr> <td  align="center" colspan="2" class="letraGrandeNegrita">
            <label>_____________________</label></td></tr>
            <tr> <td  colspan="2"  align="center" class="letraGrande"><label >Cajero</label></td></tr>
            <tr> <td colspan="2">&nbsp;</td></tr>
            <tr> <td colspan="2">&nbsp;</td></tr>
            <tr><td  align="center" colspan="2" class="letraGrandeNegrita">
            <label>_____________________</label></td></tr>
            <tr><td  colspan="2"  align="center" class="letraGrande"><label >Gerente</label></td></tr>';

$contenido .= '</tbody></table></form></body></html>';

$nombreContrato = 'Ajustes' . $idArqueo . ".pdf";
$dompdf = new DOMPDF();
$dompdf->load_html($contenido);
//Horizontal
//$dompdf->setPaper('letter', 'landscape');
//letter carta, legal oficio
//Vertical
if($sucursal==1){
    $dompdf->setPaper('letter', 'portrait');
}else if($sucursal==2){
    $customPaper = array(0,0,227,426);
    $dompdf->setPaper($customPaper);
}
$dompdf->render();
$pdf = $dompdf->output();
$dompdf->stream($nombreContrato);
