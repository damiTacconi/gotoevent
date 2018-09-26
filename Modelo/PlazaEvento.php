<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 18:20
 */

namespace Modelo;


class PlazaEvento
{
    private $id;
    private $capacidad;
    private $remanente;
    private $sede;
    private $plaza;
    private $calendario;
    private $precio;

    /**
     * PlazaEvento constructor.
     * @param $capacidad
     * @param $remanente
     * @param $sede
     * @param $plaza
     * @param $calendario
     * @param $precio
     */
    public function __construct($capacidad, $remanente, $sede, $plaza, $calendario,$precio)
    {
        $this->capacidad = $capacidad;
        $this->remanente = $remanente;
        $this->sede = $sede;
        $this->plaza = $plaza;
        $this->calendario = $calendario;
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getCalendario()
    {
        return $this->calendario;
    }

    /**
     * @param mixed $calendario
     */
    public function setCalendario($calendario): void
    {
        $this->calendario = $calendario;
    }



    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio): void
    {
        $this->precio = $precio;
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

    /**
     * @return mixed
     */
    public function getRemanente()
    {
        return $this->remanente;
    }

    /**
     * @param mixed $remanente
     */
    public function setRemanente($remanente): void
    {
        $this->remanente = $remanente;
    }

    /**
     * @return mixed
     */
    public function getSede()
    {
        return $this->sede;
    }

    /**
     * @param mixed $sede
     */
    public function setSede($sede): void
    {
        $this->sede = $sede;
    }

    /**
     * @return mixed
     */
    public function getPlaza()
    {
        return $this->plaza;
    }

    /**
     * @param mixed $plaza
     */
    public function setPlaza($plaza): void
    {
        $this->plaza = $plaza;
    }


}