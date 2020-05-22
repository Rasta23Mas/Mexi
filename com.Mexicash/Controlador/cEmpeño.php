<?php

    include ('../Modelo/Empeño.php');
    include ('../Dao/sql/sqlEmpeñoDAO.php');
    include ('../Dao/sql/sqlClienteDAO.php');


    $nombreCot = $_POST['txtNombreCot'];
    $apellPCot = $_POST['txtApPCot'];
    $apellMCot = $_POST['txtApMCot'];
    $beneficiario = $_POST['txtBeneficiario'];
    $metal_Electro = $_POST['boxMetalElectro'];
    $tipo = $_POST['boxTipo'];
    $prenda = $_POST['boxPrenda'];
    $kilataje = $_POST['txtKilataje'];
    $calidad = $_POST['boxCalidad'];
    $cantidad = $_POST['txtCantidad'];
    $peso = $_POST['txtPeso'];
    $pesoPiedras = $_POST['txtPesoPiedras'];
    $piedras = $_POST['boxPiedras'];
    $prestamo = $_POST['boxPrestamo'];

    $celular = $_POST['txtCelular'];
    $correoCliente = $_POST['txtCorreoCliente'];

    $emp = new Empeño(
        $nombreCot,
        $apellPCot,
        $apellMCot,
        $beneficiario,
        $metal_Electro,
        $tipo,
        $prenda,
        $kilataje,
        $calidad,
        $cantidad,
        $peso,
        $pesoPiedras,
        $piedras,
        $prestamo
    );

    $idCliente = new sqlClienteDAO();

    $e = new sqlEmpeñoDAO();

    if(!$e->empeñar($emp, $idCliente->buscarIdCliente($celular, $correoCliente))){
        header('Status: 301 Moved Permanently', false, 301);
        header('Location: ../../Web/html/vEmpeno.php');
        exit();
    }else{
        header('Status: 301 Moved Permanently', false, 301);
        header('Location: ../../Web/html/menuEmpeno.php');
        exit();
    }

