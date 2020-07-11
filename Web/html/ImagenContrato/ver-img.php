<?php
//importamos el archivo de conexiÃ³n
//Funcion para recuperar el mime
function fObtenerMime($wfParamCadena){//creamos una funciÃ³n que recibira un parametro en este caso la extensiÃ³n del archivo
    $fsExtension = $wfParamCadena;
    if  ($fsExtension =='bmp'){ $mime = 'image/bmp'; }
    if  ($fsExtension =='gif' ){ $mime ='image/gif' ; }
    if  ($fsExtension =='jpe' ){ $mime ='image/jpeg' ; }
    if  ($fsExtension =='jpeg'){ $mime = 'image/jpeg' ; }
    if  ($fsExtension =='jpg' ){ $mime ='image/jpeg'; }
    if  ($fsExtension =='png' ){ $mime = 'image/png'; }
    return $mime;//en base a su extenxiÃ³n la function retornara un tipo de mime
}
$server = "localhost";
$bd = "imagen";
$user = "root";
$pas = "";
$con = mysqli_connect($server, $user, $pas, $bd);

$idImagen = $_GET['id']; //Recuperamos el prametro que contiene el id de la imagen que vamos a consultar.

$result = mysqli_query($con,"Select * from img where idImagen = $idImagen");//Realizamos una consulta a la imagen seleccionada
$imagen =  mysqli_fetch_assoc($result);//recuperamos los registros de la consulta
$mime = fObtenerMime($imagen['extension']);//Obtenemos el mime del archivo.
$contenido = $imagen['binario'];//Obtenemos el contenido almacenado en el campo Binario.

header("Content-type:$mime");//le indicamos al navegador que tipo de informaciÃ³n mostraremos.
print $contenido; //Imprimimos el contenido.

mysqli_close($con);//cerramos la conexión
