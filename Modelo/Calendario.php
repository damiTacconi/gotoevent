<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 17:41
 */

namespace Modelo;


class Calendario
{
    private $id;
    private $fecha;
    private $evento;
    private $artista;

    function __construct($fecha , $evento, $artista)
    {
        $this->artista = $artista;
        $this->evento = $evento;
        $this->fecha = $fecha;
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