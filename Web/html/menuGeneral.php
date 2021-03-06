<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Security.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../../librerias/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="../../librerias/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../librerias/bootstrap/css/bootstrapNav.css">
    <link rel="stylesheet" type="text/css" href="../../librerias/alertifyjs/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="../../librerias/alertifyjs/css/themes/default.css">
    <script src="../../librerias/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../librerias/bootstrap/js/bootstrapNav.js"></script>
    <script src="../../librerias/alertifyjs/alertify.js"></script>
    <script src="../../librerias/popper.min.js"></script>
    <link rel="shortcut icon" href="#"/>
    <link rel="stylesheet" type="text/css" href="../../style/General/StyloGeneral.css">
    <script src="../../JavaScript/funcionesGenerales.js"></script>
    <script type="application/javascript">
    </script>
</head>
<body>
<nav class="navbar navbar-expand-xl bg-success navbar-dark">
    <a class="navbar-brand" href="../Empeno/vInicioGerente.php">Inicio</a>
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
                    <li><a class="dropdown-item" href="../Desempeno/vDesempeno.php?tipoFormGet=3">Desempeños</a></li>
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
                    <li><a class="dropdown-item" href="../Desempeno/vDesempeno.php?tipoFormGet=4">Desempeños</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" id="menuConsultas">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Consultas
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                   <li><a class="dropdown-item" href="../Consultas/vConsultaContrato.php">Consulta</a></li>
                    <li><a class="dropdown-item" href="../Consultas/vConsultaVentas.php">Consulta Ventas</a></li>
                    <li><a class="dropdown-item" href="../Consultas/vConsultaCompras.php">Consulta Compras</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" id="menuCompras">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Compras
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Compras/vComprasMetal.php">Metales</a></li>
                    <li><a class="dropdown-item" href="../Compras/vComprasElectronicos.php">Electrónicos</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" id="menuCompras">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Migración
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Migracion/vMigracion.php">Migración</a></li>
                    <li><a class="dropdown-item" href="../Migracion/vAutoMigracion.php">Auto Migración</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" id="menuCierre">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Cierre
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" id="CI_Arqueo" href="../Cierre/vArqueo.php">Arqueo</a></li>
                    <li><a class="dropdown-item" id="CI_Caja" href="../Cierre/vCaja.php">Cierre de Caja</a></li>
                    <li><a class="dropdown-item"   href="../Cierre/vCierre.php">Cierre de Sucursal</a></li>
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
                    <li><a class="dropdown-item" href="../Ventas/vVentasModificarPrecio.php">Modificar Precio</a></li>
                    <li><a class="dropdown-item" href="../Ventas/vVentasClientes.php">Agregar Cliente</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown" id="menuReportes">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Reportes
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Reportes/vReportes.php?tipoReporte=1">Empeños</a></li>
                    <li><a class="dropdown-item" href="../Reportes/vReportes.php?tipoReporte=2">Inventarios</a></li>
                    <li><a class="dropdown-item" href="../Reportes/vReportes.php?tipoReporte=3">Financieros</a></li>
                    <li><a class="dropdown-item" href="../Reportes/vReportes.php?tipoReporte=5">Cierres</a></li>
                    <li><a class="dropdown-item" href="../Reportes/vReportes.php?tipoReporte=6">Autos</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" id="menuCatalogos">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Catalogos
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="../Catalogos/catMetales.php">Metales</a></li>
                    <li><a class="dropdown-item" href="../Catalogos/catClientes.php">Clientes</a></li>

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
