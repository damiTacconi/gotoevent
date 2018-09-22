<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 18:23
 */

namespace Modelo;


class TipoPlaza
{
    private $id;
    private $descripcion;
    private $id_sede;

    /**
     * TipoPlaza constructor.
     * @param $descripcion
     */
    public function __construct($descripcion)
    {
        $this->descripcion = $descripcion;
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
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getIdSede()
    {
        return $this->id_sede;
    }

    /**
     * @param mixed $id_sede
     */
    public function setIdSede($id_sede): void
    {
        $this->id_sede = $id_sede;
    }


}