<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 19:03
 */

namespace Modelo;


class Compra
{
    private $id;
   private $total;
   private $cliente;
   private $lineas = [];


   function __construct($cliente, $total){
       $this->cliente = $cliente;
     $this->total = $total;
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
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param mixed $cliente
     */
    public function setCliente($cliente): void
    {
        $this->cliente = $cliente;
    }

    /**
     * @return array
     */
    public function getLineas(): array
    {
        return $this->lineas;
    }

    /**
     * @param array $lineas
     */
    public function setLineas(array $lineas): void
    {
        $this->lineas = $lineas;
    }




}
