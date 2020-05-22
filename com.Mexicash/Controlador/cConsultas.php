
<style>
    .boton {cursor:pointer;padding:2px 5px;color:Blue;}
</style>


<?php
    include_once ($_SERVER['DOCUMENT_ROOT'].'/dirs.php');
    include_once (SQL_PATH."sqlClienteDAO.php");
    include_once  (MODELO_PATH."Cliente.php");

    $sql = new sqlClienteDAO();

    $nombre = $_POST['Nombres'];

    $arr = array();

    $arr = $sql->consultaClienteEmpeño($nombre, 3);
    echo "<table style='width: 100%'>";
    echo "<tr>";
    echo "<th>Nombre Completo:</th>";
    echo "<th>Fecha de Nacimiento:</th>";
    echo "<th>CURP:</th>";
    echo "<th>Celular:</th>";
    echo "<th>RFC:</th>";
    echo "<th>Telefono:</th>";
    echo "<th>Correo: </th>";
    echo "<th>Direccion: </th>";
    echo "<th>Estado: </th>";
    echo "</tr>";

    for($i = 0; $i < count($arr); $i++){
        echo "<tr>";
        echo "<td style='padding: 20px' onclick='tablaClientes(this)' class='boton'>". $arr[$i]['nombreCompleto'] ."</td>";
        echo "<td style='padding: 20px'>". $arr[$i]['fechaNac'] ."</td>";
        echo "<td style='padding: 20px'>". $arr[$i]['curp'] ."</td>";
        echo "<td style='padding: 20px'>". $arr[$i]['celular'] ."</td>";
        echo "<td style='padding: 20px'>". $arr[$i]['rfc'] ."</td>";
        echo "<td style='padding: 20px'>". $arr[$i]['telefono'] ."</td>";
        echo "<td style='padding: 20px'>". $arr[$i]['correo'] ."</td>";
        echo "<td style='padding: 20px'>". $arr[$i]['direccionCompleta'] ."</td>";
        echo "<td style='padding: 20px'>". $arr[$i]['estado'] ."</td>";
        echo "</tr>";
    }

    echo "</table>";
?>






