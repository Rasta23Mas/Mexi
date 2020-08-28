<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MENU_PATH . "modalSucursal.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../librerias/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../librerias/alertifyjs/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="../../librerias/alertifyjs/css/themes/default.css">
    <script src="../../librerias/jquery-3.4.1.min.js"></script>
    <script src="../../librerias/bootstrap/js/bootstrap.js"></script>
    <script src="../../librerias/alertifyjs/alertify.js"></script>

    <title>Mexicash</title>
</head>
<body>

<nav class="navbar navbar-expand-sm bg-success navbar-dark fixed-top" style="background-color: #e3f2fd;">
    <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="MenuLoggin.php">Ingresar</a>
        </li>
        <li class="nav-item dropdown" id="menuConfiguracion">
            <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                Configuración
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="../Menu/vModHorario.php">Horario</a></li>
            </ul>
        </li>
    </ul>

</nav>
</body>
</html>