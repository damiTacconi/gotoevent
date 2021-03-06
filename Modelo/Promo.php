<?php

namespace Modelo;

use \JsonSerializable;

class Promo implements JsonSerializable {

    protected $id;
    protected $descuento;
    protected $evento;

    public function __construct($descuento, Evento $evento){
        $this->descuento = $descuento;
        $this->evento = $evento;
    }

    public function jsonSerialize(){
      return [
          "id_promo" => $this->id,
          "descuento" => $this->descuento,
          "evento" => $this->evento->jsonSerializeSesion()
      ];
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
