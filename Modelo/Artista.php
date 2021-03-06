<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 18:50
 */

namespace Modelo;

use JsonSerializable;

class Artista implements JsonSerializable
{
    private $nombre;
    private $id;

    public function jsonSerialize()
    {
        return [
          "nombre" => $this->nombre,
          "id_artista" => $this->id
        ];
    }

    /**
     * Artista constructor.
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