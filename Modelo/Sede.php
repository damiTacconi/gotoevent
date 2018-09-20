<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 18:22
 */

namespace Modelo;


class Sede
{
    private $id;
    private $nombre;
    private $capacidad;

    /**
     * Sede constructor.
     * @param $nombre
     */
    public function __construct($nombre)
    {
        $this->nombre = $nombre;
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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * @param mixed $capacidad
     */
    public function setCapacidad($capacidad): void
    {
        $this->capacidad = $capacidad;
    }


}