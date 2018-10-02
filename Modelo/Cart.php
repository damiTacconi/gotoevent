<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 1/10/2018
 * Time: 14:53
 */

namespace Modelo;

use JsonSerializable;
class Cart implements JsonSerializable
{
    private $plazaEvento;
    private $cantidad;
    private $categoria;

    /**
     * Cart constructor.
     * @param $plazaEvento
     * @param $cantidad
     */
    public function __construct($plazaEvento, $cantidad, $categoria)
    {
        $this->plazaEvento = $plazaEvento;
        $this->cantidad = $cantidad;
        $this->categoria = $categoria;
    }

    public function setCategoria($categoria){
      $this->categoria = $categoria;
    }
    public function getCategoria(){
      return $this->categoria;
    }

    /**
     * @return mixed
     */
    public function getPlazaEvento()
    {
        return $this->plazaEvento;
    }

    /**
     * @param mixed $plazaEvento
     */
    public function setPlazaEvento($plazaEvento): void
    {
        $this->plazaEvento = $plazaEvento;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
    }


    public function jsonSerialize()
    {
        return[
            "plazaEvento" => $this->plazaEvento->jsonSerialize(),
            "cantidad" => $this->cantidad,
            "categoria" => $this->categoria
        ];
    }

}
