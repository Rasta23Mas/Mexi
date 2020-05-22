<?php
if(!isset($_SESSION)) {
    session_start();
}
if(!isset($_SESSION["idUsuario"])){
    header("Location: ../index.php");
    session_destroy();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once (HTML_PATH. "Empeno/menuEmpeno.php")
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        $(document).ready(function () {
           // $('.menuContainer').load('menu.php');
            $('#consultas').load('consultaCliente.php');
        });
    </script>
    <script>
        $( function() {
            $( "#datepicker" ).datepicker();
        } );

        $(function() {
            $('input:radio[name="rConsultaPor"]').change(function() {
                if ($(this).val() == '1') {
                    document.getElementById('Nombres').disabled = true;
                    document.getElementById('btnTodos').disabled = true;
                    document.getElementById('btnBuscar').disabled = true;

                    document.getElementById('inContrato').disabled = false;
                    document.getElementById('btnContrato').disabled = false;
                } else {
                    document.getElementById('Nombres').disabled = false;
                    document.getElementById('btnTodos').disabled = false;
                    document.getElementById('btnBuscar').disabled = false;

                    document.getElementById('inContrato').disabled = true;
                    document.getElementById('btnContrato').disabled = true;
                }
            });
        });

    </script>

    <style type="text/css">
        table{
            width: 100%; text-align: center;
        }
        thead{
            text-align: center;
        }
        th{
            padding-left: 1%; padding-right: 1%; border: 1px solid black;
        }
        th{
            border: 1px solid black;
        }
    </style>

</head>
<body>
<div class="container-fluid" style="position: absolute; top: 8.2vh; border:1px solid black; height: 91.8vh">

    <div style="position: relative; top: 2vh; left: 60%; height: 33vh">
        <h5>Detalle del Cliente</h5>
        <div id="consultas"></div>
    </div>

    <div style="position: relative; width: 60%; top: -32vh; left: 0; height: 33vh;">

        <div style="position: relative; width: 25%; height: 100%; padding-top: 20px">
            <div style="width: 90%; float: left">
                <label for=""><input type="radio" name="rConsultaPor" value="1" id="chkContrato" value="1" />Por Contrato</label>
            </div>
            <div style="width: 90%; float: left">
                <label for=""><input type="radio" name="rConsultaPor" value="2" id="chkNombre" value="1"/>Por Nombre</label>
            </div>
            <div style="width: 90%; float: left; padding-top: 20px">
                <h5>Detalles del Contrato</h5>
                <div style="width: 100%">
                    <h6>Contrato:</h6>
                    <input type="text" name="inContrato" placeholder="" id="inContrato" style="width: 90%" disabled/>
                    <input type="button" id="btnContrato" onclick="buscarContrato();" class="btn btn-outline-primary" value="Buscar" style="margin-top: 5px" disabled/>
                </div>
            </div>
        </div>

        <div style="position:relative; width: 70%; height: 100%; left: 25%; top: -100%; ">
            <table id="tblArticulo" style="position: relative; top: 0;">
                <thead style="width: 100%">
                <tr>
                    <th style="width: 20%">Cantidad</th>
                    <th style="width: 20%">Articulo</th>
                    <th style="width: 60%">Observaciones</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>

    <div class="tblConsultaEmpeños" style="  position: relative;width: 95%;height: 55.6vh;top: -34%;left: 0;right: 0;margin-left: auto;margin-right: auto;">
        <table width="100%" id="tblContratos" style="position: relative; top: 0; border: 1px solid black">
            <thead style="width: 100%">
            <tr>
                <th>Contrato</th>
                <th>Folio</th>
                <th>Pr&eacute;stamo</th>
                <th>Abono</th>
                <th>Inter&eacute;s</th>
                <th>Pago</th>
                <th>Fecha Alm</th>
                <th>Fecha mto.</th>
                <th>Estatus</th>
                <th>Vencimiento</th>
            </tr>
            </thead>
        </table>
    </div>

</div>



<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="../../style/css/magicsuggest/magicsuggest-min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>
</html>