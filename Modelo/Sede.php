<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 18:22
 */

namespace Modelo;

use JsonSerializable;

class Sede implements JsonSerializable
{
    private $id;
    private $nombre;
    private $capacidad;
    /**/
    private $plazas = [];

    /**
     * Sede constructor.
     * @param $nombre
     * @param $capacidad
     */
    public function __construct($nombre , $capacidad)
    {
        $this->nombre = $nombre;
        $this->capacidad = $capacidad;
    }


    public function jsonSerialize()
    {
        return [
          'id_sede' => $this->id,
          'nombre' => $this->nombre,
          'plazas' => $this->plazasToArray()
        ];
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


    private function plazasToArray(){
        $plazas = array_map(function($plaza){
            return $plaza->jsonSerialize();
        } , $this->plazas);
        return $plazas;
    }
    /**
     * @return array
     */
    public function getPlazas(): array
    {
        return $this->plazas;
    }

    /**
     * @param array $plazas
     */
    public function setPlazas(array $plazas): void
    {
        $this->plazas = $plazas;
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


}