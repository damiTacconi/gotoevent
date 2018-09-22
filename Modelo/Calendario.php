<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 17:41
 */

namespace Modelo;


class Calendario
{
    private $id;
    private $fecha;
    private $id_evento;

    function __construct($fecha)
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
    public function setId($id)
    {
        $this->id = $id;
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
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getIdEvento()
    {
        return $this->id_evento;
    }

    /**
     * @param mixed $id_evento
     */
    public function setIdEvento($id_evento): void
    {
        $this->id_evento = $id_evento;
    }



}