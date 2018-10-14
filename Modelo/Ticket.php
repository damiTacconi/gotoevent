<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 19:03
 */

namespace Modelo;


class Ticket
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
    public function __construct($fecha,$numero,$linea, $qr)
    {
        $this->numero = $numero;
        $this->linea = $linea;
        $this->qr = $qr;
        $this->fecha = $fecha;
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