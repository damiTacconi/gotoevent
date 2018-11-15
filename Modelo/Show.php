<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 22/9/2018
 * Time: 17:03
 */

namespace Modelo;

use JsonSerializable;
class Show implements JsonSerializable
{
    private $id;
    private $artista;
    private $calendario;

    function jsonSerialize()
    {
       return [
           "id_show" => $this->id,
         "artista" => $this->artista->jsonSerialize(),
         "calendario" => $this->calendario->jsonSerialize()
       ];
    }

    /**
     * Show constructor.
     * @param $artista
     * @param $calendario
     */
    public function __construct(Artista $artista, Calendario $calendario)
    {
        $this->artista = $artista;
        $this->calendario = $calendario;
    }

    /**
     * @return mixed
     */
    public function getArtista()
    {
        return $this->artista;
    }

    /**
     * @param mixed $artista
     */
    public function setArtista($artista): void
    {
        $this->artista = $artista;
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


}