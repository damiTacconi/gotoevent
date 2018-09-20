<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 17:40
 */

namespace Modelo;


class Evento
{
    private $id;
    private $titulo;
    private $fecha_desde;
    private $fecha_hasta;
    private $categoria;

    function __construct($titulo,$fecha_desde,$fecha_hasta,$categoria)
    {
        $this->categoria = $categoria;
        $this->fecha_desde = $fecha_desde;
        $this->fecha_hasta = $fecha_hasta;
        $this->titulo = $titulo;
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
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo): void
    {
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getFechaDesde()
    {
        return $this->fecha_desde;
    }

    /**
     * @param mixed $fecha_desde
     */
    public function setFechaDesde($fecha_desde): void
    {
        $this->fecha_desde = $fecha_desde;
    }

    /**
     * @return mixed
     */
    public function getFechaHasta()
    {
        return $this->fecha_hasta;
    }

    /**
     * @param mixed $fecha_hasta
     */
    public function setFechaHasta($fecha_hasta): void
    {
        $this->fecha_hasta = $fecha_hasta;
    }

    /**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria($categoria): void
    {
        $this->categoria = $categoria;
    }


}