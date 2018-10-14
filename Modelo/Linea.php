<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 19:03
 */

namespace Modelo;

use JsonSerializable;
class Linea implements JsonSerializable
{
     private $id;
     private $plazaEvento;
     private $cantidad;
     private $subtotal;
     private $compra;

    /**
     * Linea constructor.
     * @param $plazaEvento
     * @param $cantidad
     * @param $subtotal
     * @param $compra
     */
    public function __construct($plazaEvento, $cantidad, $subtotal, $compra)
    {
        $this->cantidad = $cantidad;
        $this->plazaEvento = $plazaEvento;
        $this->subtotal = $subtotal;
        $this->compra = $compra;
    }

    public function jsonSerialize()
    {
        return [
          "id_linea" => $this->id,
          "plazaEvento" => $this->plazaEvento->jsonSerialize(),
          "cantidad" => $this->cantidad,
          "subtotal" => $this->subtotal,
          "compra" => $this->compra->jsonSerialize()
        ];
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


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * @param mixed $subtotal
     */
    public function setSubtotal($subtotal): void
    {
        $this->subtotal = $subtotal;
    }

    /**
     * @return mixed
     */
    public function getCompra()
    {
        return $this->compra;
    }

    /**
     * @param mixed $compra
     */
    public function setCompra($compra): void
    {
        $this->compra = $compra;
    }


}
