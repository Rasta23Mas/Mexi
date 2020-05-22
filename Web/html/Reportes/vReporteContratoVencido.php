<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Consultas</title>

    <link rel="stylesheet" href="../../style/less/main.css"/>
    <link rel="stylesheet" href="../../style/css/bootstrap/bootstrap.css"/>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="../../style/css/magicsuggest/magicsuggest-min.css" rel="stylesheet">

    <script>
        $( function() {
            $( "#datepicker" ).datepicker();
        } );

    </script>
    <script>
        $(document).ready(function () {
            $('.menuContainer').load('menu.php');
            $('#consultas').load('consultaCliente.php');
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
    </style>

</head>
<body>
<div class="menuContainer" ></div>

<div class="container-fluid" style="position: absolute; top: 8.2vh; border:1px solid black; height: 91.8vh">
    <div class="clearfix" style="position:relative; width: 60%; height: 30vh; top: 1%">
        <br/><br/>
        <div style="float: left; margin-right: 5%; margin-left: 5%; width: 28%">
            <label>Desde:<input type="text" id="inFechaInicial" placeholder = "Fecha [dd/mm/aaaa]"/></label>
        </div>
        <div style="float: left; width: 28%; margin-right: 5%">
            <label>Hasta:<input type="text" id="inFechaFinal" placeholder = "Fecha [dd/mm/aaaa]"/></label>
            <br/><br/><input type="button" class="btn btn-outline-primary" onclick="traerContratos();" value="Buscar"/>
        </div>
        <div style=" width: 28%; margin-right: 5%">

        </div>
        <div style="position:absolute; left: 70%; width: 40%">

            <fieldset>
                <h5>Ordenar por</h5>
                <label><input type="radio" name="favorite_pet"  value="Cats">Contrato</label><input type="radio" style="margin-left: 20%" name="favorite_pet" value="Cats">Fecha<br>
                <label><input type="radio" name="favorite_pet" value="Dogs">Vencimiento</label><input type="radio" style="margin-left: 12.9%" name="favorite_pet" value="Cats">Cliente<br>
                <label><input type="radio" name="favorite_pet" value="Birds">Comercializacion</label><input type="radio" style="margin-left: 3.25%" name="favorite_pet" value="Cats">Dias Vencido<br>
            </fieldset>

        </div>
    </div>
    <div class="clearfix" style="position:relative; left: 70%; width: 30% height: 30vh; top: -29vh">
        <br/><br/>
        <fieldset>
            <h5>Ordenar por</h5>
            <label><input type="radio" name="favorite_pet"  value="Cats">Contrato</label><br>
            <label><input type="radio" name="favorite_pet" value="Dogs">Tipo Tasa</label><br>
        </fieldset>
    </div>

    <div class="" style="  position: relative;width: 95%;height: 55.6vh;border: 1px solid black;top: -22%;left: 0;right: 0;margin-left: auto;margin-right: auto;">
        <table width="100%" id="tblContratosVencidos" style="position: relative; top: 0;">
            <thead style="width: 100%">
            <tr>
                <th>Contrato</th>
                <th>Fecha</th>
                <th>Venci&oacute;</th>
                <th>Cliente</th>
                <th>Celular</th>
                <th>Tel&eacute;fono</th>
                <th>Aval&uacute;o</th>
                <th>Pr&eacute;stamo</th>
                <th>D&iacute;as venc.</th>
                <th>Tipo Tasa</th>
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