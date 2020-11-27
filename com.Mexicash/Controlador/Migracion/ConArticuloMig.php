<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlMigracionDAO.php");

$idTipoEnviar = $_POST['idTipoEnviar'];
$idContrato = $_POST['idContrato'];
$idFolioMig = $_POST['idFolioMig'];
$idKilataje = $_POST['idKilataje'];
$idCalidad = $_POST['idCalidad'];
$idPiezas = $_POST['idPiezas'];
$idCantidad = $_POST['idCantidad'];
$idPeso = $_POST['idPeso'];
$idPiedras = $_POST['idPiedras'];
$idPesoPiedra = $_POST['idPesoPiedra'];
$idMarca = $_POST['idMarca'];
$idModelo = $_POST['idModelo'];
$idSerie = $_POST['idSerie'];
$idIMEI = $_POST['idIMEI'];
$idPrestamoMig = $_POST['idPrestamoMig'];
$idAvaluoMig = $_POST['idAvaluoMig'];
$idVitrinaMig = $_POST['idVitrinaMig'];
$descDetalle = $_POST['descDetalle'];
$idObs = $_POST['idObs'];
$SerieBazar = $_POST['SerieBazar'];
$id_serieTipo = $_POST['id_serieTipo'];
$tipo_movimiento = $_POST['tipo_movimiento'];
$descripcionCorta = $_POST['descripcionCorta'];
$tipoCMB = $_POST['tipoCMB'];
$checkCompraGlb = $_POST['checkCompraGlb'];


$sqlArticuloCompras = new sqlMigracionDAO();
$sqlArticuloCompras->sqlGuardarArticuloMig($idTipoEnviar, $idContrato, $idFolioMig,
$idKilataje, $idCalidad, $idPiezas, $idCantidad, $idPeso, $idPiedras, $idPesoPiedra,
$idMarca, $idModelo, $idSerie, $idIMEI, $idPrestamoMig, $idAvaluoMig, $idVitrinaMig, $descDetalle, $idObs,
$SerieBazar, $id_serieTipo, $tipo_movimiento, $descripcionCorta,$tipoCMB,$checkCompraGlb);

?>

