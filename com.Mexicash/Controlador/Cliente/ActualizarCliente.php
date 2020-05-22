<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Cliente.php");
include_once(SQL_PATH . "sqlClienteDAO.php");

$idClienteEditar = $_POST['idClienteEditar'];
$idNombre = $_POST['idNombre'];
$idApPat = $_POST['idApPat'];
$idApMat = $_POST['idApMat'];
$idSexo = $_POST['idSexo'];
$idFechaNac = $_POST['idFechaNac'];
$idRfc = $_POST['idRfc'];
$idCurp = $_POST['idCurp'];
$idCelular = $_POST['idCelular'];
$idTelefono = $_POST['idTelefono'];
$idCorreo = $_POST['idCorreo'];
$idOcupacion = $_POST['idOcupacion'];
$idIdentificacion = $_POST['idIdentificacion'];
$idNumIdentificacion = $_POST['idNumIdentificacion'];
$idEstado = $_POST['idEstado'];
$idMunicipio = $_POST['idMunicipio'];
$idLocalidad = $_POST['idLocalidad'];
$idCalle = $_POST['idCalle'];
$idCP = $_POST['idCP'];
$idNumExt = $_POST['idNumExt'];
$idNumInt = $_POST['idNumInt'];
$idPromocion = $_POST['idPromocion'];
$idMensajeInterno = $_POST['idMensajeInterno'];

$clienteData = new Cliente(

    $idNombre,
    $idApPat,
    $idApMat,
    $idSexo,
    $idFechaNac,
    $idRfc,
    $idCurp,
    $idCelular,
    $idTelefono,
    $idCorreo,
    $idOcupacion,
    $idIdentificacion,
    $idNumIdentificacion,
    $idEstado,
    $idMunicipio,
    $idLocalidad,
    $idCalle,
    $idCP,
    $idNumExt,
    $idNumInt,
    $idPromocion,
    $idMensajeInterno
);

$sqlCliente = new sqlClienteDAO();
$sqlCliente->actualizaCiente($idClienteEditar, $clienteData);