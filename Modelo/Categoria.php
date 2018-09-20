<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 15:51
 */

namespace Modelo;


class Categoria
{
    protected $id;
    protected $descripcion;

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