<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MENU_PATH . "menuPrincipal.php");
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
</head>
<body id="bodyHome">
<div class="container login-container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 login-form-1" align="center">
            <div align="center">
                <img src="../../img/logo/logoChT.png" alt=""/>
            </div>
            <h3>Iniciar Sesion</h3>
            <div id="resultado" style="color:#FF0000;" align="center">
            </div>
            <div class="form-group" align="center">
                <br>
                <input type="text" name="usuario" id="usuario" class="form-control"
                       placeholder="Usuario:" required style="width: 130px" value="Test"/>
            </div>
            <div class="form-group" align="center">
                <input type="password" name="password" id="password" class="form-control"
                       placeholder="Contraseña" required style="width: 130px"  onkeypress="return enterValidaUser(event)"/>
            </div>
            <div class="form-group" align="center">
                <input type="button" class="sub btn btn-primary" value="Entrar" onclick="validarPass()"/>
            </div>
        </div>
    </div>
</div>
</body>