<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 19:03
 */

namespace Modelo;


class Linea
{
     private $id;
     private $plazaEvento;
     private $subtotal;
     private $compra;

    /**
     * Linea constructor.
     * @param $plazaEvento
     * @param $subtotal
     * @param $compra
     */
    public function __construct($plazaEvento, $subtotal, $compra)
    {
        $this->plazaEvento = $plazaEvento;
        $this->subtotal = $subtotal;
        $this->compra = $compra;
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
