<?php


class Errores
{
    private $error;
    private $id;

    //opc -> 1 trycatch, 2 if, 3 void
    private $opc;

    public function getError() {
        return $this->error;
    }

    public function setError($id, $error, $opc) {
        $this->id = $id;
        $this->error = $error;
        if($opc == 1){
            $this->opc = "trycatch";
        }else{
            if($opc == 2){
                $this->opc = "if";
            }else{
                if($opc == 1){
                    $this->opc = "void";
                }else{
                    $this->opc = "opcion invalida";
                }
            }
        }

    }

    public function imprimirError(){

        echo "Error con id " . $this->id . "con razon " . $this->error . "en un " . $this->opc;

    }
}