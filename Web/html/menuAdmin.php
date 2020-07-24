<?php
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
            <li class="nav-item dropdown" id="menuConsultas">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Consultas
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Consultas/vConsultaContrato.php">Consulta</a></li>
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
                            <li><a class="dropdown-item" href="../Reportes/vReportesEmpenos.php?tipoReporte=1">Hist&oacute;rico</a></li>
                            <li><a class="dropdown-item" href="../Reportes/vReportesEmpenos.php?tipoReporte=2">Inventarios</a></li>
                            <li><a class="dropdown-item" href="../Reportes/vReportesEmpenos.php?tipoReporte=3">Contratos Vencidos</a></li>
                            <li><a class="dropdown-item" href="../Reportes/vReportesEmpenos.php?tipoReporte=4">Desempeños</a></li>
                            <li><a class="dropdown-item" href="../Reportes/vReportesEmpenos.php?tipoReporte=5">Refrendo</a></li>
                        </ul>
                    </li>
                    <li><a class="dropdown-item dropdown-toggle" href="#">Financieros</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="pruebas.php">Ingresos(P)</a></li>
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
                    <li><a class="dropdown-item" href="../Dotacion/vMovimientosCentral.php">Movimientos</a></li>
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