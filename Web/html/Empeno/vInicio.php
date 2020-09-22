<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/Menu.php');
$sucursal = $_SESSION["sucursal"];
$sucName = "Sucursal";
if($sucursal==1){
    $sucName= "Cantil";
}elseif ($sucursal==2){
    $sucName= "Jamaica";
}
$tipoUsuario = $_SESSION['tipoUsuario'];



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="application/javascript">
        $(document).ready(function () {
            var menu = <?php echo $tipoUsuario?>;
        if (menu==2){
            $("#menuGerente").hide();
            $("#menuAdmin").show();
        }else if (menu==3){
            $("#menuGerente").show();
            $("#menuAdmin").hide();
        }else{
            $("#menuGerente").hide();
            $("#menuAdmin").hide();
        }
        })
    </script>
</head>
<body>
<form id="idFormEmpeno" name="formEmpeno">
    <div class="container-fluid" style="position: absolute; top: 8.2vh; height: 91.8vh">
        <div>
            <br>
            <h2 align="center">Menú acceso rápido</h2>
            <!--<h2 align="center" id="sesionInactiva" style="color:#FF0000";>¡IMPORTANTE. NO PODRA HACER OPERACIONES DE DOTACIÓN!</h2>
            <h2 align="center" id="cajaInactiva" style="color:#FF0000";>¡IMPORTANTE. NO PODRA HACER OPERACIONES, EL CIERRE DE CAJA YA FUE REALIZADO!</h2>
            <br>-->
            <h4 align="center">Bienvenido: <?php echo $_SESSION["usuario"]; ?></h4>
            <br>
            <h5 align="left">Sucursal: <?php echo $sucName; ?></h5>
            <h5 align="left">Operación Sucursal: <?php echo $_SESSION["idCierreSucursal"]; ?></h5>
            <h5 align="left"><label id="OpSesion">Operación Sesión: <?php echo $_SESSION["idCierreCaja"]; ?></label></h5>

            <br>
        </div>
        <div class="row" id="menuGerente">
            <div class="col-1" >
            </div>
            <div class="col-2 border border-info " align="center">
                <table width="80%">
                    <tr>
                        <td align="center">
                            <br>
                            <h2>Empeño</h2>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" width="50%">
                            <br>
                            <input type="button" class="btn btn-info w-100" value="Empeño" onclick="location.href='vEmpeno.php'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <br>
                            <input type="button" class="btn btn-info  w-100" value="Refrendo" onclick="location.href='../Refrendo/vRefrendo.php?tipoFormGet=1'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <br>
                            <input type="button" class="btn btn-info  w-100" value="Desempeño" onclick="location.href='../Desempeno/vDesempeno.php?tipoFormGet=3'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <br>
                            <input type="button" class="btn btn-info  w-100" value="Consulta" onclick="location.href='../Consultas/vConsultaContrato.php'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <br>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-2 border border-info " align="center">
                <table width="80%">
                    <tr>
                        <td align="center">
                            <br>
                            <h2>Auto</h2>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" width="50%">
                            <br>
                            <input type="button" class="btn btn-info w-100" value="Auto" onclick="location.href='vAuto.php'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <br>
                            <input type="button" class="btn btn-info  w-100" value="Refrendo" onclick="location.href='../Refrendo/vRefrendo.php?tipoFormGet=2'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <br>
                            <input type="button" class="btn btn-info  w-100" value="Desempeño" onclick="location.href='../Desempeno/vDesempeno.php?tipoFormGet=4'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <br>
                            <input type="button" class="btn btn-info  w-100" value="Consulta" onclick="location.href='../Consultas/vConsultaContrato.php'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <br>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row" id="menuAdmin">
            <div class="col-1" >
            </div>
            <div class="col-2 border border-info " align="center">
                <table width="80%">
                    <tr>
                        <td align="center">
                            <br>
                            <h2>Reportes</h2>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" width="50%">
                            <br>
                            <input type="button" class="btn btn-info w-100" value="Consultas" onclick="location.href='../Consultas/vConsultaContrato.php'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" width="50%">
                            <br>
                            <input type="button" class="btn btn-info w-100" value="Empeños" onclick="location.href='../Reportes/vReportes.php?tipoReporte=1'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" width="50%">
                            <br>
                            <input type="button" class="btn btn-info w-100" value="Inventarios" onclick="location.href='../Reportes/vReportes.php?tipoReporte=2'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <br>
                            <input type="button" class="btn btn-info  w-100" value="Financieros" onclick="location.href='../Reportes/vReportes.php?tipoReporte=3'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <br>
                            <input type="button" class="btn btn-info  w-100" value="Cierres" onclick="location.href='../Reportes/vReportesCierres.php'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <br>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-2 border border-info " align="center">
                <table width="80%">
                    <tr>
                        <td align="center">
                            <br>
                            <h2>Catalogos</h2>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" width="50%">
                            <br>
                            <input type="button" class="btn btn-info w-100" value="Clientes" onclick="location.href='../Catalogos/catClientes.php">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" width="50%">
                            <br>
                            <input type="button" class="btn btn-info w-100" value="Cancelaciones" onclick="location.href='../Cancelaciones/vCancelado.php'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <br>
                            <input type="button" class="btn btn-info  w-100" value="Alta Usuario" onclick="location.href='../Configuracion/vAltaUsuario.php'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <br>
                            <input type="button" class="btn btn-info  w-100" value="Horario" onclick="location.href='../Configuracion/vHorario.php'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <br>
                            <input type="button" class="btn btn-info  w-100" value="Cancelaciones" onclick="location.href='../Configuracion/vCancelarSucursal.php'">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <br>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-2 border border-info " align="center" id="MenRapDotacion">
                <table width="80%">
                    <tr>
                        <td align="center">
                            <br>
                            <h2>Dotaciones</h2>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" width="50%">
                            <br>
                            <input type="button" class="btn btn-info w-100" value="Movimientos" onclick="location.href='../Dotacion/vMovimientosCentral.php">
                            <br>
                        </td>
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
