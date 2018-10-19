<?php 

namespace Modelo;
class Promo {

    protected $id;
    protected $descuento;
    protected $evento;

    public function __construct($descuento, $evento){
        $this->descuento = $descuento;
        $this->evento = $evento;
    }

    public function setDescuento($descuento){
        $this->descuento = $descuento;
    }

    public function getDescuento(){
        return $this->descuento;
    }

    public function setEvento($evento){
        $this->evento = $evento;
    }

    public function getEvento(){
        return $this->evento;
    }
    
    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    


}