<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 19:03
 */

namespace Modelo;

use JsonSerializable;
class Ticket implements JsonSerializable
{
    private $id;
    private $numero;
    private $fecha;
    private $linea;
    private $qr;

    /**
     * Ticket constructor.
     * @param $fecha
     * @param $numero
     * @param $linea
     * @param $qr
     */
    public function __construct($fecha,$numero,Linea $linea, $qr)
    {
        $this->numero = $numero;
        $this->linea = $linea;
        $this->qr = $qr;
        $this->fecha = $fecha;
    }

    public function jsonSerialize()
    {
        return [
          "id_ticket" => $this->id,
          "numero" => $this->numero,
          "linea" => $this->linea->jsonSerialize(),
          "fecha" => $this->fecha,
          "qr" => $this->qr
        ];
    }


    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero): void
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getLinea()
    {
        return $this->linea;
    }

    /**
     * @param mixed $linea
     */
    public function setLinea($linea): void
    {
        $this->linea = $linea;
    }

    /**
     * @return mixed
     */
    public function getQr()
    {
        return $this->qr;
    }

    /**
     * @param mixed $qr
     */
    public function setQr($qr): void
    {
        $this->qr = $qr;
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




}