<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 18:20
 */

namespace Modelo;


class PlazaEvento
{
    private $id;
    private $capacidad;
    private $remanente;
    private $sede;
    private $tipoPlaza;
    private $id_calendario;

    /**
     * PlazaEvento constructor.
     * @param $capacidad
     * @param $remanente
     * @param $sede
     * @param $tipoPlaza
     */
    public function __construct($capacidad, $remanente, $sede, $tipoPlaza)
    {
        $this->capacidad = $capacidad;
        $this->remanente = $remanente;
        $this->sede = $sede;
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
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * @param mixed $capacidad
     */
    public function setCapacidad($capacidad): void
    {
        $this->capacidad = $capacidad;
    }

    /**
     * @return mixed
     */
    public function getRemanente()
    {
        return $this->remanente;
    }

    /**
     * @param mixed $remanente
     */
    public function setRemanente($remanente): void
    {
        $this->remanente = $remanente;
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
     * @return mixed
     */
    public function getTipoPlaza()
    {
        return $this->tipoPlaza;
    }

    /**
     * @param mixed $tipoPlaza
     */
    public function setTipoPlaza($tipoPlaza): void
    {
        $this->tipoPlaza = $tipoPlaza;
    }


}