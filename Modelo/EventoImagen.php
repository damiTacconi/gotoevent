<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 25/9/2018
 * Time: 15:42
 */

namespace Modelo;


class EventoImagen
{
    private $id;
    private $nombre;
    private $imagen;

    /**
     * EventoImagen constructor.
     * @param $nombre
     * @param $imagen
     */
    public function __construct($nombre, $imagen)
    {
        $this->nombre = $nombre;
        $this->imagen = $imagen;
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
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param mixed $imagen
     */
    public function setImagen($imagen): void
    {
        $this->imagen = $imagen;
    }



}