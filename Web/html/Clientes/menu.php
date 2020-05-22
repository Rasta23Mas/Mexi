
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" href="../../style/css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="../../style/less/main.css" type="text/css">
    <link rel="stylesheet" href="../../style/less/pagPrincipal.css" type="text/css">
    <title>Acceder</title>
</head>

<body>

    <div id="login">
        <div class="container-fluid Inicio-Sec1" style="margin-left: -1vw">
            <div class="div-Navegador container-fluid" >
                <nav class="navbar navbar-expand-lg navbar-light bg-light navegador fijador">
                    <a class="navbar-brand ZBNav" href="#">MexiCash</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" style="margin-left: -145px;"  id="navbarNavAltMarkup">
                        <div class="navbar-nav nav-Home-collapsed">

                            <a class="nav-item nav-link active" href="#" onclick="menu(this, 1)">Empeño<span class="sr-only">(current)</span></a>
                            <a class="nav-item nav-link" href="#" onclick="menu(this, 2)">Cierre</a>
                            <a class="nav-item nav-link" href="#" onclick="menu(this, 3)">Ventas</a>
                            <a class="nav-item nav-link" href="#" onclick="menu(this, 4)">Inventario</a>
                            <a class="nav-item nav-link" href="#" onclick="menu(this, 5)">Reportes</a>
                            <a class="nav-item nav-link" href="#" onclick="menu(this, 6)">Movimientos</a>
                            <a class="nav-item nav-link" href="#" tabindex="-1" aria-disabled="true" onclick="menu(this, 7)">Utilerias</a>
                            <a class="nav-item nav-link menu-Opcion-Login" href="#" onclick="menu(this, 9)">Cuenta</a>
                            <!--
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>

                            <form class="navbar-form navbar-left buscador" role="search">
                                <div class="form-group">
                                    <input type="text" class="form-control caja" placeholder="Buscar">
                                </div>
                            </form>-->
                        </div>
                    </div>
                </nav>
            </div><!--Barra Navegación Home-->
        </div>

    </div>
    <div class="container2" style="left: 19.25vw;" id="empeño">
        <nav>
            <ul class="menu" >
                <li>
                    <a href="../Empeno/vEmpeno.php">
                        <i class="fa fa-home"></i>
                        <strong>Empeños</strong>
                    </a>
                </li>
                <li>
                    <a href="../Empeno/vDesempeno.php">
                        <i class="fa fa-dollar"></i>
                        <strong>Desempeños</strong>
                    </a>
                </li>
                <li>
                    <a href="../Empeno/vRefrendo.php">
                        <i class="fa fa-gift"></i>
                        <strong>Refrendo</strong>
                    </a>
                </li>
                <li>
                    <a href="../Empeno/vConsulta.php">
                        <i class="fa fa-gear"></i>
                        <strong>Consultas</strong>
                        <small>+m&aacute;s</small>
                    </a>
                    <ul>
                        <li><a href="#"><i class="fa fa-plus-square"></i>Por nombre</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Por Contrato</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../Empeno/vAuto.php">
                        <i class="fa fa-dollar"></i>
                        <strong>Autos</strong>
                    </a>
                </li>

            </ul>
        </nav>
    </div><!--container2-->

    <div class="container2" style="left: 27.5vw;" id="cierre">
        <nav>
            <ul class="menu" >
                <li>
                    <a href="#">
                        <i class="fa fa-gear"></i>
                        <strong>Cierre</strong>
                        <small>+m&aacute;s</small>
                    </a>
                    <ul>
                        <li><a href="#"><i class="fa fa-plus-square"></i>De Caja</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>De Divisas</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>De Sucursal</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-dollar"></i>
                        <strong>Balance</strong>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-gift"></i>
                        <strong>Activos</strong>
                    </a>
                </li>

            </ul>
        </nav>
    </div><!--container2-->

    <div class="container2" style="left: 34.52vw;" id="ventas">
        <nav>
            <ul class="menu" >
                <li>
                    <a href="#">
                        <i class="fa fa-gear"></i>
                        <strong>Mostrador</strong>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-dollar"></i>
                        <strong>Abono</strong>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-gear"></i>
                        <strong>Reportes</strong>
                        <small>+m&aacute;s</small>
                    </a>
                    <ul>
                        <li><a href="#"><i class="fa fa-plus-square"></i>Ventas Mostrador</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Ventas Apartado</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Apartados Abonos</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Apartados liquidados</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Utilidad Ventas</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div><!--container2-->

    <div class="container2" style="left: 41.7vw;" id="inventario">
        <nav>
            <ul class="menu">
                <li>
                    <a href="#">
                        <i class="fa fa-dollar"></i>
                        <strong>Existencias</strong>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="ventanaInvFisico(1)">
                        <i class="fa fa-gift"></i>
                        <strong>Inventario F&iacute;sico</strong>
                    </a>
                </li>

            </ul>
        </nav>
    </div><!--container2-->

    <div class="container2" style="left: 50.7vw;" id="reportes">
        <nav>
            <ul class="menu" >
                <li>
                    <a href="#">
                        <i class="fa fa-gear"></i>
                        <strong>Empeños</strong>
                        <small>+m&aacute;s</small>
                    </a>
                    <ul>
                        <li><a href="#"><i class="fa fa-plus-square"></i>Hist&oacute;rico</a></li>
                        <li><a href="#" onclick="ventanaInvFisico(1)"><i class="fa fa-user-plus" ></i>Inventarios</a></li>
                        <li><a href="#" onclick="ventanaInvFisico(2)"><i class="fa fa-user-plus" ></i>Contratos Almoneda</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Contratos Vencidos</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Desempeños-detallado</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Refrendo-detallado</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Pagos Fijos</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-dollar"></i>
                        <strong>Monitoreo</strong>
                        <small>+m&aacute;s</small>
                    </a>
                    <ul>
                        <li><a href="#"><i class="fa fa-plus-square"></i>Re-Impresiones</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Autorizaciones</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Cancelaciones</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-dollar"></i>
                        <strong>Contratos Promedio</strong>
                        <small>+m&aacute;s</small>
                    </a>
                    <ul>
                        <li><a href="#"><i class="fa fa-plus-square"></i>Empeño</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Desempeño</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Refrendos</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-dollar"></i>
                        <strong>Cliente Frecuente</strong>
                        <small>+m&aacute;s</small>
                    </a>
                    <ul>
                        <li><a href="#"><i class="fa fa-plus-square"></i>Movimientos</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Estado de Cuenta</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div><!--container2-->

    <div class="container2" style="left: 59vw;" id="movimientos">
        <nav>
            <ul class="menu" >
                <li>
                    <a href="#">
                        <i class="fa fa-gift"></i>
                        <strong>Usuarios</strong>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-dollar"></i>
                        <strong>Respaldar Informaci&oacute;n</strong>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-gift"></i>
                        <strong>Activos</strong>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-gear"></i>
                        <strong>Cat&aacute;logo</strong>
                        <small>+m&aacute;s</small>
                    </a>
                    <ul>
                        <li><a href="RegistrarCliente.php"><i class="fa fa-plus-square"></i>Clientes</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Identificaciones</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Plazos de inter&eacute;s</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Tipos de prenda</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Prendas Joyeria</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>Prendas Varios</a></li>
                        <!--Faltan los tipos de prendas varios-->
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-gift"></i>
                        <strong>Envio de mensajes</strong>
                    </a>
                </li>
            </ul>
        </nav>
    </div><!--container2-->

    <div class="container2" style="left: 69vw;" id="antilavado">
        <nav>
            <ul class="menu" >
                <li>
                    <a href="#">
                        <i class="fa fa-gear"></i>
                        <strong>Cierre</strong>
                        <small>+m&aacute;s</small>
                    </a>
                    <ul>
                        <li><a href="#"><i class="fa fa-plus-square"></i>De Caja</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>De Divisas</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>De Sucursal</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-dollar"></i>
                        <strong>Balance</strong>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-gift"></i>
                        <strong>Activos</strong>
                    </a>
                </li>

            </ul>
        </nav>
    </div><!--container2-->

    <div class="container2" style="left: 78.5vw;" id="utilerias">
        <nav>
            <ul class="menu" >
                <li>
                    <a href="#">
                        <i class="fa fa-gear"></i>
                        <strong>Cierre</strong>
                        <small>+m&aacute;s</small>
                    </a>
                    <ul>
                        <li><a href="#"><i class="fa fa-plus-square"></i>De Caja</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>De Divisas</a></li>
                        <li><a href="#"><i class="fa fa-user-plus" ></i>De Sucursal</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-dollar"></i>
                        <strong>Balance</strong>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-gift"></i>
                        <strong>Activos</strong>
                    </a>
                </li>

            </ul>
        </nav>
    </div><!--container2-->

    <div class="container2" style="left: 87.25vw;" id="cuenta">
        <nav>
            <ul class="menu" >
                <li>
                    <a href="#">
                        <i class="fa fa-gear"></i>
                        <strong>Configuraci&oacute;n</strong>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-dollar"></i>
                        <strong>Balance</strong>
                    </a>
                </li>
                <li>
                    <a href="../index.php">
                        <i class="fa fa-gift"></i>
                        <strong>Cerrar Sesi&oacute;n</strong>
                    </a>
                </li>

            </ul>
        </nav>
    </div><!--container2-->

<script src="../../js/main/main.js"></script>
</body>
</html>