<?php
$tipoUsuario = $_SESSION['tipoUsuario'];
$cajaInactiva = $_SESSION['cajaInactiva'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../librerias/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../librerias/bootstrap/css/bootstrapNav.css">
    <link rel="stylesheet" type="text/css" href="../../librerias/alertifyjs/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="../../librerias/alertifyjs/css/themes/default.css">
    <script src="../../librerias/jquery-3.4.1.min.js"></script>
    <script src="../../librerias/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../librerias/bootstrap/js/bootstrapNav.js"></script>
    <script src="../../librerias/alertifyjs/alertify.js"></script>
    <script src="../../librerias/popper.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../style/General/StyloGeneral.css">
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script type="application/javascript">
        $(document).ready(function () {
            var tipoUser = <?php echo $tipoUsuario; ?>;
            var cajaInactiva = <?php echo $cajaInactiva; ?>;

            if (tipoUser == 2) {
                $("#menuEmpeno").hide();
                $("#menuEmpenoAuto").hide();
                $("#menuCierre").hide();
                $("#menuVentas").hide();
                $("#menuConsultas").show();
                $("#menuCatalogos").show();
                $("#menuDotaciones").show();
                $("#menuCancelaciones").show();

            } else if (tipoUser == 3) {
                if(cajaInactiva==0){
                    $("#menuEmpeno").show();
                    $("#menuEmpenoAuto").show();
                    $("#menuVentas").show();
                }else{
                    $("#menuEmpeno").hide();
                    $("#menuEmpenoAuto").hide();
                    $("#menuVentas").hide();
                }

                $("#menuCierre").show();
                $("#menuConsultas").hide();
                $("#menuCatalogos").hide();
                $("#menuDotaciones").show();
                $("#menuCancelaciones").show();
                $("#menuConfiguracion").show();
            } else if (tipoUser == 4) {
                $("#menuEmpeno").show();
                $("#menuEmpenoAuto").show();
                $("#menuCierre").show();
                $("#menuVentas").show();
                $("#menuConsultas").hide();
                $("#menuCatalogos").hide();
                $("#menuDotaciones").hide();
                $("#menuCancelaciones").hide();
            }
        })
    </script>
</head>
<body>
<nav class="navbar navbar-expand-xl bg-success navbar-dark">
    <a class="navbar-brand" href="../Empeno/vInicio.php">Inicio</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item dropdown" id="menuEmpeno">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Empeño
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Empeno/vEmpeno.php">Empeños</a></li>
                    <li><a class="dropdown-item" href="../Refrendo/vRefrendo.php?tipoFormGet=1">Refrendo</a></li>
                    <li><a class="dropdown-item" href="../Refrendo/vRefrendo.php?tipoFormGet=3">Desempeños</a></li>
                    <li><a class="dropdown-item" href="../Empeno/vConsultaContrato.php">Consulta</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" id="menuEmpenoAuto">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Auto
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Empeno/vAuto.php">Empeños</a></li>
                    <li><a class="dropdown-item" href="../Refrendo/vRefrendo.php?tipoFormGet=2">Refrendo</a></li>
                    <li><a class="dropdown-item" href="../Refrendo/vRefrendo.php?tipoFormGet=4">Desempeños</a></li>
                    <li><a class="dropdown-item" href="../Empeno/vConsultaContrato.php">Consulta</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" id="menuConsultas">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Consultas
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Empeno/vConsultaContrato.php">Consulta</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" id="menuCierre">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Cierre
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Cierre/vArqueo.php">Arqueo</a></li>
                    <li><a class="dropdown-item" href="../Cierre/vCaja.php">Cierre de Caja</a></li>
                    <li><a class="dropdown-item" href="../Cierre/vCierre.php">Cierre de Sucursal</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" id="menuVentas">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Ventas
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Ventas/vVentasMostrador.php">Mostrador</a></li>
                    <li><a class="dropdown-item" href="../Ventas/vVentasAbonos.php">Abono</a></li>
                    <li><a class="dropdown-item" href="../Ventas/vVentasApartados.php">Apartados</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" id="menuReportes">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Reportes
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item dropdown-toggle" href="#">Empeños</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../Empeno/pruebas.php">Hist&oacute;rico (P)</a></li>
                            <li><a class="dropdown-item" href="../Empeno/pruebas.php">Inventarios(M)</a></li>
                            <li><a class="dropdown-item" href="../Empeno/pruebas.php">Contratos Vencidos (P)</a></li>
                            <li><a class="dropdown-item" href="../Empeno/pruebas.php">Desempeños-detallado (P)</a></li>
                            <li><a class="dropdown-item" href="../Empeno/pruebas.php">Refrendo-detallado (P)</a></li>
                        </ul>
                    </li>
                    <li><a class="dropdown-item dropdown-toggle" href="#">Financieros</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../Empeno/pruebas.php">Ingresos(P)</a></li>
                            <li><a class="dropdown-item" href="../Empeno/pruebas.php">Corporativo(P)</a></li>

                        </ul>
                    </li>
                    <li><a class="dropdown-item dropdown-toggle" href="#">Monitoreo (P)</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../Empeno/pruebas.php">Autorizaciones(P)</a></li>
                        </ul>
                    </li>
                    <li><a class="dropdown-item dropdown-toggle" href="#">Cierres</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../Empeno/pruebas.php">Reporte Cierre.</a></li>
                        </ul>
                </ul>
            </li>
            <li class="nav-item dropdown" id="menuCatalogos">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Catalogos
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Catalogos/catMetales.php">Metales</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" id="menuDotaciones">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Dotaciones
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="vMovimientosCentral.php">Movimientos</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" id="menuCancelaciones">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Cancelaciones
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Cancelaciones/vCancelado.php">Cancelar</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" id="menuConfiguracion">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Configuración
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Configuracion/vAltaUsuario.php">Alta Usuario</a></li>
                    <li><a class="dropdown-item" href="../Configuracion/vHorario.php">Horario</a></li>
                    <li><a class="dropdown-item" href="../Configuracion/vCancelarSucursal.php">Cancelaciones</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Salir
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="#" onclick="cerrarSesion()">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
</body>
</html>
