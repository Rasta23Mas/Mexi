<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(MODELO_PATH . "Articulo.php");
include_once(BASE_PATH . "Conexion.php");
date_default_timezone_set('America/Mexico_City');
class TablaDatos
{

    private $id;
    private $titulo;
    private $imagen;
    private $con;

    public function __construct()
    {
        /*$this->conexion = mysqli_connect("localhost", "root", "") or
        die("Problemas en la conexion");

        mysqli_select_db($this->conexion, "u672450412_Mexicash") or die("Problemas en
    la selección de la base de datos");*/

        $this->db = new Conexion();
        $this->conexion = $this->db->connectDB();
    }

    public function set($atributo, $contenido)
    {
        $this->$atributo = $contenido;
    }

    public function get($atributo)
    {
        return $this->$atributo;
    }


    /* Anterior
    public function listar(){
          $sql=mysql_query("SELECT * FROM imagenes");
          while($data=mysql_fetch_array($sql)){
              echo "Titulo: <b>".$data['titulo']."</b>";
              echo'<img src="data:image/jpeg;base64,'.base64_encode($data['img']).'" class="img-responsive img-rounded ">';
              echo'<a href="javascript:preEditImg('.$data['id'].');" class="btn btn-success"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Pre-Editar</a>';
              echo'<a href="javascript:deleteImg('.$data['id'].');" class="btn btn-danger"><span  style="padding-left: 10px" class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Eliminar</a>';
              echo "<hr><br>";
          }
      }*/

    public function listar()
    {
        //$sql=mysql_query("SELECT * FROM imagenes");
        $buscar = "SELECT * FROM imagenes";
        $rs = $this->conexion->query($buscar);
        while ($data = mysqli_fetch_array($rs)) {
            echo "Titulo: <b>" . $data['titulo'] . "</b>";
            echo '<img src="data:image/jpeg;base64,' . base64_encode($data['img']) . '" class="img-responsive img-rounded ">';
            echo '<a href="javascript:preEditImg(' . $data['id'] . ');" class="btn btn-success"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Pre-Editar</a>';
            echo '<a href="javascript:deleteImg(' . $data['id'] . ');" class="btn btn-danger"><span  style="padding-left: 10px" class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Eliminar</a>';
            echo "<hr><br>";
        }
    }

    public function getOneImg()
    {
        $idImg = $this->id;
        //$sql=mysql_query("SELECT * FROM imagenes WHERE id=".$idImg."");
        $buscarImg = "SELECT * FROM imagenes WHERE id=$idImg";
        $rs = $this->conexion->query($buscarImg);


        if ($data = mysqli_fetch_array($rs)) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($data['img']) . '" class="img-responsive img-rounded ">';
        }
    }

    public function getTitle()
    {
        $idImg = $this->id;
        //$sql=mysql_query("SELECT * FROM imagenes WHERE id=".$idImg."");
        $buscarImgTitle = "SELECT * FROM imagenes WHERE id=$idImg";
        $rs = $this->conexion->query($buscarImgTitle);
        if ($data = mysqli_fetch_array($rs)) {
            echo $data['titulo'];
        }
    }

    public function editDataSinImg()
    {
        $id = $this->id;
        $titulo = $this->titulo;
        //mysql_query("UPDATE imagenes SET titulo= '".$titulo."' WHERE id='".$id."'");
        $updateTitle = "UPDATE imagenes SET titulo= '" . $titulo . "' WHERE id='" . $id . "'";
        $ps = $this->conexion->prepare($updateTitle);
        $ps->execute();

    }


    public function editConImg()
    {
        $id = $this->id;
        $titulo = $this->titulo;
        $imgData = $this->imagen;
        //mysql_query("UPDATE imagenes SET img='{$imgData}', titulo='".$titulo."' WHERE id=".$id."");
        $updateImg = "UPDATE imagenes SET img='{$imgData}', titulo='" . $titulo . "' WHERE id=$id" ;
        $ps = $this->conexion->prepare($updateImg);
        $ps->execute();

    }

    public function ingresoImg()
    {
        $titulo = $this->titulo;
        $imgData = $this->imagen;
        // mysql_query("INSERT INTO imagenes VALUES (0,'" . $titulo . "','{$imgData}')");
        $insertImg = "INSERT INTO imagenes VALUES (0,'" . $titulo . "','{$imgData}')";
        $ps = $this->conexion->prepare($insertImg);
        $ps->execute();
    }

    public function deleteData()
    {
        $idImg = $this->id;
        //mysql_query("DELETE FROM imagenes WHERE id='" . $idImg . "'");
        $insertImg = "DELETE FROM imagenes WHERE id='" . $idImg . "'";
        $ps = $this->conexion->prepare($insertImg);
        $ps->execute();
    }

}

?>