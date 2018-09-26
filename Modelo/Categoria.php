<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 15:51
 */

namespace Modelo;

use JsonSerializable;

class Categoria implements JsonSerializable
{
    protected $id;
    protected $descripcion;

    public function jsonSerialize()
    {
       return[
         'id_categoria' => $this->id,
         'descripcion' => $this->descripcion
       ];
    }


    /**
     * @param $descripcion
     */
    function __construct($descripcion)
    {
        $this->setDescripcion($descripcion);
    }

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
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }


}