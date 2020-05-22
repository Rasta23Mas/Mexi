<?php
include ('../Modelo/Cliente.php');


interface ClienteDAO
{
    public function guardaCiente(Cliente $cliente);

    public function borraCliente(Cliente $cliente);

}