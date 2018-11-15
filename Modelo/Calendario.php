<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 17:41
 */

namespace Modelo;

use JsonSerializable;
class Calendario implements JsonSerializable
{
    private $id;
    private $fecha;
    private $evento;
    private $sede;


    private $plazaEventos = [];
    private $shows = [];

    public function jsonSerialize()
    {
       return [
         'id_calendario' => $this->id,
         'fecha' => $this->fecha,
         'sede' => $this->sede->jsonSerialize(),
         'evento' => $this->evento->jsonSerializeSesion()
       ];
    }


    function __construct($fecha , Evento $evento, $sede)
    {
        $this->fecha = $fecha;
        $this->evento = $evento;
        $this->sede = $sede;
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

    /**
     * @return array
     */
    public function getPlazaEventos(): array
    {
        return $this->plazaEventos;
    }

    /**
     * @param array $plazaEventos
     */
    public function setPlazaEventos($plazaEventos): void
    {
        $this->plazaEventos = $plazaEventos;
    }

    /**
     * @return array
     */
    public function getShows(): array
    {
        return $this->shows;
    }

    /**
     * @param array $shows
     */
    public function setShows($shows): void
    {
        $this->shows = $shows;
    }



    /**
     * @return mixed
     */
    public function getEvento()
    {
        return $this->evento;
    }

    /**
     * @param mixed $evento
     */
    public function setEvento($evento): void
    {
        $this->evento = $evento;
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
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }


}