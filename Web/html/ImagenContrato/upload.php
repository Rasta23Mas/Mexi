<?php
//Comienzo de lectura del archivo
/*
    Comprovamos que se aya pasado un parametro: isset($_FILES['miArchivo'])
    Comprovamos que el parametro no esta vacio isset($_FILES['miArchivo'] !='')
*/
if((isset($_FILES['miArchivo'])) && ($_FILES['miArchivo'] !='')){
$server = "localhost";
$bd = "imagen";
$user = "root";
$pas = "";
$con = mysqli_connect($server, $user, $pas, $bd);
    $file = $_FILES['miArchivo']; //Asignamos el contenido del parametro a una variable para su mejor manejo

    $temName = $file['tmp_name']; //Obtenemos el directorio temporal en donde se ha almacenado el archivo;
    $fileName = $file['name']; //Obtenemos el nombre del archivo
    $fileExtension = substr(strrchr($fileName, '.'), 1); //Obtenemos la extensiÃ³n del archivo.

    //Comenzamos a extraer la informaciÃ³n del archivo
    $fp = fopen($temName, "rb");//abrimos el archivo con permiso de lectura
    $contenido = fread($fp, filesize($temName));//leemos el contenido del archivo
    //Una vez leido el archivo se obtiene un string con caracteres especiales.
    $contenido = addslashes($contenido);//se escapan los caracteres especiales
    fclose($fp);//Cerramos el archivo

    //Insertando los datos
    //Creando el query
    $query = "INSERT INTO img (fileName ,extension ,binario ) VALUES ('$fileName' ,'$fileExtension' ,'$contenido' )";
    //Ejecutando el Query
    $result = mysqli_query($con, $query);

    mysqli_close($con);//cerramos la conexiÃ³n
}