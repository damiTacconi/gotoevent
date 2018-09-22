<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 22/9/2018
 * Time: 17:03
 */

namespace Modelo;


class Show
{
    private $id;
    private $hora_inicio;
    private $hora_fin;
    private $artista;
    private $calendario;

    /**
     * Show constructor.
     * @param $hora_inicio
     * @param $hora_fin
     * @param $artista
     * @param $calendario
     */
    public function __construct($hora_inicio, $hora_fin, $artista, $calendario)
    {
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
        $this->artista = $artista;
        $this->calendario = $calendario;
    }

    /**
     * @return mixed
     */
    public function getHoraInicio()
    {
        return $this->hora_inicio;
    }

    /**
     * @param mixed $hora_inicio
     */
    public function setHoraInicio($hora_inicio): void
    {
        $this->hora_inicio = $hora_inicio;
    }

    /**
     * @return mixed
     */
    public function getHoraFin()
    {
        return $this->hora_fin;
    }

    /**
     * @param mixed $hora_fin
     */
    public function setHoraFin($hora_fin): void
    {
        $this->hora_fin = $hora_fin;
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