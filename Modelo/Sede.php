<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 18:22
 */

namespace Modelo;


class Sede
{
    private $id;
    private $nombre;
    private $tipoPlaza = [];
    /**
     * Sede constructor.
     * @param $nombre
     */
    public function __construct($nombre)
    {
        $this->nombre = $nombre;
    }

    public function addTipoPlaza(TipoPlaza $tipoPlaza){
        $this->tipoPlaza[] = $tipoPlaza;
    }
    /**
     * @return array
     */
    public function getTipoPlaza(): array
    {
        return $this->tipoPlaza;
    }

    /**
     * @param array $tipoPlaza
     */
    public function setTipoPlaza(array $tipoPlaza): void
    {
        $this->tipoPlaza = $tipoPlaza;
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