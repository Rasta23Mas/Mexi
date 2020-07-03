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

</head>
<body>
<nav class="navbar navbar-expand-xl bg-success navbar-dark">
    <a class="navbar-brand" href="vInicio.php">Inicio</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Empeñosssss
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="vEmpeno.php">Empeños</a></li>
                    <li><a class="dropdown-item" href="../Refrendo/vRefrendo.php?tipoFormGet=1">Refrendo</a></li>
                    <li><a class="dropdown-item" href="../Refrendo/vRefrendo.php?tipoFormGet=3">Desempeños</a></li>
                    <li><a class="dropdown-item" href="vConsultaContrato.php">Consulta</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Auto
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="vAuto.php">Empeños</a></li>
                    <li><a class="dropdown-item" href="../Refrendo/vRefrendo.php?tipoFormGet=2">Refrendo</a></li>
                    <li><a class="dropdown-item" href="../Refrendo/vRefrendo.php?tipoFormGet=4">Desempeños</a></li>
                    <li><a class="dropdown-item" href="vConsultaContrato.php">Consulta</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cierre
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Cierre/vArqueo.php">Arqueo</a></li>
                    <li><a class="dropdown-item" href="../Cierre/vCaja.php">Cierre de Caja(P)</a></li>
                    <li><a class="dropdown-item" href="../Cierre/vCierre.php">Cierre de Sucursal(P)</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ventas
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Ventas/vVentasMostrador.php">Mostrador</a></li>
                    <li><a class="dropdown-item" href="../Ventas/pruebas.php">Abono (P)</a></li>
                    <li><a class="dropdown-item" href="../Ventas/pruebas.php">Apartados (P)</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Reportes
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item dropdown-toggle" href="#">Empeños</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="pruebas.php">Hist&oacute;rico (P)</a></li>
                            <li><a class="dropdown-item" href="pruebas.php" >Inventarios(M)</a></li>
                            <li><a class="dropdown-item" href="pruebas.php">Contratos Vencidos (P)</a></li>
                            <li><a class="dropdown-item" href="pruebas.php">Desempeños-detallado (P)</a></li>
                            <li><a class="dropdown-item" href="pruebas.php">Refrendo-detallado (P)</a></li>
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
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Catalogos
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Catalogos/catMetales.php">Metales</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dotaciones
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Dotacion/vMovimientosCentral.php">Movimientos</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cancelaciones
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Cancelaciones/vCancelado.php">Cancelar</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Salir
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item"  href="#" onclick="cerrarSesion()">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
</body>
</html>
