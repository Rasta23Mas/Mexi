<?php

session_start();
include('../Dao/sql/sqlUsuarioDAO.php');

if ($_POST['botonAcceder'] == "Entrar") {
    $userText = $_POST['usuario'];
    $passText = $_POST['password'];
    $usuDAO = new sqlUsuarioDAO();
    if ($userText != null || $passText != null) {
        $id = $usuDAO->loginAutentificion($userText, $passText);
        if ($id > 0) {
            $_SESSION['sautentificado'] = 1;
            $_SESSION['userName'] = $id;

            header("Location:../Explorer.php");
        } else {
            header("Location:../index.php?errorusuario=1");
        }
    } else {
        header("Location:../index.php?errorusuario=1");
    }
}