<?php

include_once ($_SERVER['DOCUMENT_ROOT'].'/dirs.php');
include_once (SERVICIOS_PATH."Errores.php");

class Conexion
{
    protected $server = "localhost";
    protected $user = "root";
    protected $password = "";
    protected $db = "u672450412_Mexicash";
    protected $link;
    protected $error;

    //conexión web
/*    protected $user = "u672450412_root";
    protected $password = "12345";*/

    public function connectDB(){
        try {
            $this->link = mysqli_connect($this->server, $this->user, $this->password, $this->db);
            return $this->link;
        }catch (\Exception $error){
            echo $error->getMessage();
            /*$this->error = new ErroresInfo();
            $this->error->setError(1, $error->getMessage(), 1);
            $this->error->imprimirError();*/
            return 0;
        }
    }

    public function closeDB(){
        try{
            mysqli_close($this->link);
        }catch (Exception $e){
            $this->error = new ErroresInfo();
            $this->error->setError(1, $e->getMessage(), 1);
            $this->error->imprimirError();
        }
    }

    function getArray($resultado) {
        return mysqli_fetch_array($resultado);
    }
    function getRows($resultado) {
        return mysqli_num_rows($resultado);
    }

}

?>