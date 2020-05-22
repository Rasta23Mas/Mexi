<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/dirs.php');
include_once (MODELO_PATH."Usuario.php");


interface UsuarioDAO
{
    public function guardaUsuario(Usuario $usuario);

    public function borrarUsuario($usuario);

    public function login($usuario,$pass);
}