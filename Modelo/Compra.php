<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 19:03
 */

namespace Modelo;
use JsonSerializable;

class Compra implements JsonSerializable
{
    private $id;
    private $fecha;
    private $total;
    private $cliente;
    private $lineas = [];


   function __construct($cliente, $total, $fecha){
       $this->cliente = $cliente;
     $this->total = $total;
     $this->fecha = $fecha;
   }

    public function jsonSerialize()
    {
        return [
          "id_compra" => $this->id,
          "fecha" => $this->fecha,
            "total" => $this->total,
          "cliente" => $this->cliente->jsonSerialize()
        ];
    }


    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
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
