<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 18:20
 */

namespace Modelo;

use JsonSerializable;
class PlazaEvento implements JsonSerializable
{
    private $id;
    private $capacidad;
    private $remanente;
    private $plaza;
    private $calendario;
    private $precio;

    public function jsonSerialize()
    {
       return [
         "id_plazaEvento" => $this->id,
         "capacidad" => $this->capacidad,
         "remanente" => $this->remanente,
         "plaza" => $this->plaza->jsonSerialize(),
         "calendario" => $this->calendario->jsonSerialize(),
         "precio" => $this->precio
       ];
    }

    /**
     * PlazaEvento constructor.
     * @param $capacidad
     * @param $remanente
     * @param $plaza
     * @param $calendario
     * @param $precio
     */
    public function __construct($capacidad, $remanente, $plaza, $calendario,$precio)
    {
        $this->capacidad = $capacidad;
        $this->remanente = $remanente;
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