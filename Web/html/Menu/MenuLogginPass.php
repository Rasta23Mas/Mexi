<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MENU_PATH . "menuPrincipal.php");
$usuarioGet = 'No name';
if (isset($_GET['userGet'])) {
    $usuarioGet = $_GET['userGet'];
}

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
    <script src="../../JavaScript/funcionesLogin.js"></script>
    <style>
        .login-container{
            margin-top: 5%;
            margin-bottom: 5%;
        }
        .login-form-1{
            padding: 3%;
            background:#ffffff;
            box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
        }
        .login-form-1 h3{
            text-align: center;
            margin-bottom:5%;
            color:#39b54a;
        }
    </style>
    <script type="application/javascript">
        $(document).ready(function () {
            var imgOpen = document.getElementById("ojoOpen");
            imgOpen.style.visibility = 'hidden';
        });

    </script>

</head>
<body id="bodyHome">
<div class="container login-container">
    <div class="row">
        <div class="col-md-5"></div>
        <div class="col-md-5 login-form-1" align="center">
            <div align="center">
                <img src="../../img/logo/logoChT.png" alt=""/>
            </div>
            <h3>Cambio de Contraseña</h3>
            <div id="resultado" style="color:#FF0000;" align="center">
            </div>
            <div class="form-group" align="center">
                <table>
                    <tr>
                        <td class="2">
                            <input type="text" name="us" id="idUsuarioReset" class="form-control"
                                   style="width: 170px"  disabled value="<?php echo $usuarioGet; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="2">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" name="password" id="idPassword" class="form-control"
                                   placeholder="Nueva Contraseña"
                                   style="width: 170px" />
                        </td>
                        <td>
                            <img src="../../style/Img/ojo_abierto.png"  alt="Ver Contraseña" id="ojoOpen"
                                 onclick="mostrarContrasena();">
                            <img src="../../style/Img/ojo_cerrado.jpg"  alt="Ocultar Contraseña" id="ojoClose" 
                                 onclick="mostrarContrasena();">
                        </td>
                    </tr>
                    <tr>
                        <td class="2">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td class="2">
                        <input type="password" name="password" id="idPasswordSecond" class="form-control"
                               placeholder="Repetir Contraseña"
                               style="width: 170px"/>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="form-group" align="center">
                <input type="button" class="sub btn btn-primary" value="Guardar" onclick="validarContrasenas()"/>
                <input type="button" class="sub btn btn-primary" value="Mostrar" onclick="mostrarContrasena()"/>

            </div>
        </div>
    </div>
</div>
</body>