<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
require_once(WEB_PATH . "dompdf/autoload.inc.php");

use Dompdf\Dompdf;


if (!isset($_SESSION)) {
    session_start();
}
$usuario = $_SESSION["idUsuario"];
$sucursal = $_SESSION["sucursal"];
$web = 1;
if($web==2){
    $server = "localhost";
    $user = "u672450412_root";
    $password = "12345";
    $db = "u672450412_Mexicash";
}else{
    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "mexicash";
}

$sucNombre = "";
$sucDireccion= "";
$sucTelefono = "";
$sucNombreCasa = "";
$sucRfc = "";

$mysql = new  mysqli($server, $user, $password, $db);
$buscar = "SELECT Nombre, direccion, telefono, NombreCasa,rfc FROM cat_sucursal WHERE id_Sucursal = " . $sucursal;
$contrato = $mysql->query($buscar);
foreach ($contrato as $fila) {
    $sucNombre = $fila['Nombre'];
    $sucDireccion= $fila['direccion'];
    $sucTelefono = $fila['telefono'];
    $sucNombreCasa = $fila['NombreCasa'];
    $sucRfc = $fila['rfc'];
}

?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../../JavaScript/funcionesContrato.js"></script>

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
    </style>
</head>
<body >
<form align="center">
    <div class="container-fluid" style="position: absolute; top: 8.2vh; height: 91.8vh">
        <div>
            <br>
        </div>
        <div class="row">
            <div class="col-12">
                <table width="80%" border="0" align="center">
                    <tr>
                        <h5 align="center"><label >'. $sucNombre .'</label></h5>
                        <h5 align="center"><label > SUCURSAL:'. $sucDireccion .'</label></h5>
                        <h5 align="center"><label >'. $sucTelefono .'</label></h5>
                        <h5 align="center"><label>TEL: '. $sucTelefono .'</label>&nbsp;<label >RFC: '. $sucRfc .'</label></h5>
                        <br>
                        <h4 align="center">ARQUEO DE CAJA</h4>
                    </tr>
                    <tr>
                        <br>
                    </tr>
                    <tr>
                        <td align="center"  style="width: 700px;">
                            <table class="table-bordered border-primary" width="80%">
                                <tr style="background: dodgerblue; color:white;">
                                    <td align="center" colspan="5">
                                        <label>BILLETES</label>
                                    </td>
                                </tr>
                                <tr >
                                    <td colspan="2" align="center" style="width: 40%"><label> $1000.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idMilCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="center"><label id="lblMil"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> 500.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idQuinientosCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="center"><label id="lblQuinientos"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> 200.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idDoscientosCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="center"><label id="lblDoscientos"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> 100.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCienCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="center"><label id="lblCien"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> 50.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCincuentaCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="center"><label id="lblCincuenta"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%" ><label> 20.00</label></td>
                                    <td  align="center" style="width: 70px" >
                                        <input type="text" name="billete" placeholder="0" id="idVeinteCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="center" ><label id="lblVeinte"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="center" style="width: 40%" >
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">
                                        TOTAL BILLETES:&nbsp;
                                    </td>
                                    <td colspan="2" align="right">
                                        <label id="lblTotalBilletes"></label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td align="center" style="width: 700px;">
                            <table class="table-bordered border-primary" width="80%">
                                <tr style="background: dodgerblue; color:white;">
                                    <td align="center" colspan="5">
                                        <label>MONEDAS</label>
                                    </td>
                                </tr>
                                <tr >
                                    <td colspan="2" align="center" style="width: 40%"><label> $20.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idVeinteMonCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="center"><label id="lblVeinteMon"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label>10.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idDiezCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="center"><label id="lblDiez"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> 5.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCincoCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="center"><label id="lblCinco"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> 2.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idDosCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="center"><label id="lblDos"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> 1.00</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idUnoCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="center"><label id="lblUno"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label> .50</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCincuentaCCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="center"><label id="lblCincuentaC"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="width: 40%"><label>Centavos</label></td>
                                    <td  align="center" style="width: 70px">
                                        <input type="text" name="billete" placeholder="0" id="idCentavosCant" onkeypress="return soloNumeros(event)" maxlength="3"
                                               style="width: 50px; text-align: center"/></td>
                                    <td colspan="2" align="center"><label id="lblCentavos"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">
                                        TOTAL MONEDAS:&nbsp;
                                    </td>
                                    <td colspan="2" align="right">
                                        <label id="lblTotalMonedas"></label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <h4><label>&nbsp;&nbsp;TOTAL ARQUEO:</label>&nbsp;&nbsp;<label id="lblTotalArqueo"></label></h4>
                        </td>
                        <td align="right">
                            <input type="button" class="btn btn-primary" value="Calcular Arqueo" onclick="arqueo()">&nbsp;
                            <input type="button" class="btn btn-success" value="Cerrar Caja" onclick="confirmarEliminarMetales()">&nbsp;
                            <input type="button" class="btn btn-primary" value="inserta" onclick="guardarCaja()">&nbsp;

                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>

</form></body></html>