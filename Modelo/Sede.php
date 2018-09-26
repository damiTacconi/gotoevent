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
    private $plazas = [];

    public function jsonSerialize()
    {
        return [
          'id_sede' => $this->id,
          'nombre' => $this->nombre,
          'plazas' => $this->plazasToArray()
        ];
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


}