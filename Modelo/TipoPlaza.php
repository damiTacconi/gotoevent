<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 18:23
 */

namespace Modelo;

use JsonSerializable;
class TipoPlaza implements JsonSerializable
{
    private $id;
    private $descripcion;
    private $sede;


    /**
     * TipoPlaza constructor.
     * @param $descripcion
     * @param $sede
     */
    public function __construct($descripcion , $sede)
    {
        $this->descripcion = $descripcion;
        $this->sede = $sede;
    }

    public function jsonSerialize()
    {
        return[
            'id_tipo_plaza' => $this->id,
            'sede' => $this->sede->jsonSerialize(),
            'descripcion' => $this->descripcion
        ];
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


}