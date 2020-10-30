<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Security.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Menu.php');
$sucursal = $_SESSION["sucursal"];
$sucName = "Sucursal";
if ($sucursal == 1) {
    $sucName = "Cantil";
} elseif ($sucursal == 2) {
    $sucName = "Jamaica";
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Mexicash-Inicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../Reportes/bootstrap/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../Reportes/bootstrap/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>
<body>
<form id="idFormEmpeno" name="formEmpeno">
    <div class="container-fluid" style="position: absolute; top: 8.2vh; height: 91.8vh">
        <div class="row" >
            <div class="col col-md-12" >
                <br>
            </div>
        </div>
        <div class="row" id="menuGerente">
            <div class="col col-md-1" >
                <br>
            </div>
            <div class="col col-md-11">
                <table  class="border-primary border" width="90%">
                    <tr  style="background: dodgerblue; color:white;">
                        <td colspan="6" align="center" ><label><h3>Menú acceso rápido</h3></label></td>
                    </tr>
                    <tr style="color:dodgerblue; border-bottom: 1px solid #1e90ff; " >
                        <!--                      style="border-style: solid; border-color: #1e90ff;"
                        -->                      <td colspan="1" align="center" style="width: 20%; border-bottom-color: #1e90ff;"><label><h4>Datos de Sesión</h4></label></td>
                        <td colspan="1" align="center" ><label><h4>Empeño</h4></label></td>
                        <td colspan="1" align="center" ><label><h4>Auto</h4></label></td>
                        <td colspan="1" align="center" ><label><h4>Consulta</h4></label></td>
                        <td colspan="1" align="center" ><label><h4>Cierre</h4></label></td>
                        <td colspan="1" align="center" ><label><h4>Dotaciones</h4></label></td>

                    </tr>
                    <tr>
                        <td colspan="6" align="center"><br></td>
                    </tr>
                    <tr>
                        <td colspan="1" align="left"><label>&nbsp;Bienvenido: <?php echo $_SESSION["usuario"]; ?></label></td>
                        <td colspan="1" align="center" ><input type="button" class="btn btn-primary w-50" value="Empeño" onclick="location.href='vEmpeno.php'"></td>
                        <td colspan="1" align="center" ><input type="button" class="btn btn-primary w-50" value="Auto" onclick="location.href='vAuto.php'"></td>
                        <td colspan="1" align="center" ><input type="button" class="btn btn-primary  w-50" value="Consulta" onclick="location.href='../Consultas/vConsultaContrato.php'"></td>
                        <td colspan="1" align="center" ><input type="button" class="btn btn-primary  w-50" value="Arqueo" onclick="location.href='../Cierre/vArqueo.php'"></td>
                        <td colspan="1" align="center" ><input type="button" class="btn btn-primary  w-50" value="Movimientos" onclick="location.href='../Dotacion/vMovimientosCentral.php'"></td>
                    </tr>
                    <tr>
                        <td colspan="1"align="left"><label>&nbsp;Operación Sucursal: <?php echo $_SESSION["idCierreSucursal"]; ?></label></td>
                        <td colspan="5">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"align="left"><label>&nbsp;Sucursal: <?php echo $sucName; ?></label></td>
                        <td colspan="1" align="center" ><input type="button" class="btn btn-primary  w-50" value="Refrendo" onclick="location.href='../Refrendo/vRefrendo.php?tipoFormGet=1'"></td>
                        <td colspan="1" align="center" ><input type="button" class="btn btn-primary  w-50" value="Refrendo" onclick="location.href='../Refrendo/vRefrendo.php?tipoFormGet=2'"></td>
                        <td colspan="1" align="center" ><input type="button" class="btn btn-primary  w-50" value="Compras" onclick="location.href='../Consultas/vConsultaCompras.php'"></td>
                        <td colspan="1" align="center" ><input type="button" class="btn btn-primary  w-50" value="Caja" onclick="location.href='../Cierre/vCaja.php'"></td>
                        <td colspan="1" align="center" ></td>
                    </tr>
                    <tr>
                        <td colspan="1" align="left"><label>&nbsp;Operación Sesión: <?php echo $_SESSION["idCierreCaja"]; ?></label></td>
                        <td colspan="5">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1" align="center"></td>
                        <td colspan="1" align="center" ><input type="button" class="btn btn-primary  w-50" value="Desempeño" onclick="location.href='../Desempeno/vDesempeno.php?tipoFormGet=3'"></td>
                        <td colspan="1" align="center" ><input type="button" class="btn btn-primary  w-50" value="Desempeño" onclick="location.href='../Desempeno/vDesempeno.php?tipoFormGet=4'"></td>
                        <td colspan="1" align="center" ><input type="button" class="btn btn-primary  w-50" value="Ventas" onclick="location.href='../Consultas/vConsultaVentas.php'"></td>
                        <td colspan="1" align="center" ><input type="button" class="btn btn-primary  w-50" value="Sucursal" onclick="location.href='../Cierre/vCierre.php'"></td>
                        <td colspan="1" align="center" ></td>
                    </tr>
                    <tr>
                        <td colspan="6" align="center"><br></td>

                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <br>&nbsp;
        </div>
    </div>
</form>

</body>
</html>
