<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 17:40
 */

namespace Modelo;

use JsonSerializable;

class Evento implements JsonSerializable
{
    private $id;
    private $titulo;
    private $fecha_desde;
    private $fecha_hasta;
    private $categoria;
    private $sede;
    private $descripcion;
    private $eventoImagen = null;


    /*
        $calendarios es un atributo que se le asignara un valor cuando se devuelva el evento
        de la basde de datos, y se devuelvan los calendarios por su id. Estos calendarios se
        almacenaran en el array.
    */
    private $calendarios = [];


    function __construct($titulo, $fecha_desde, $fecha_hasta, $categoria, $sede , $descripcion)
    {
        $this->categoria = $categoria;
        $this->fecha_desde = $fecha_desde;
        $this->sede = $sede;
        $this->fecha_hasta = $fecha_hasta;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
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


    /**
     * @return mixed
     */
    public function getEventoImagen()
    {
        return $this->eventoImagen;
    }

    /**
     * @param mixed $eventoImagen
     */
    public function setEventoImagen($eventoImagen): void
    {
        $this->eventoImagen = $eventoImagen;
    }


    /**
     * @return array
     */
    public function getCalendarios(): array
    {
        return $this->calendarios;
    }

    /**
     * @param array $calendarios
     */
    public function setCalendarios(array $calendarios): void
    {
        $this->calendarios = $calendarios;
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

    private function calendariosToArray(){
        $calendarios = array_map(function($ca) {
            return $ca->jsonSerialize();
        }, $this->calendarios);
        return $calendarios;
    }

    public function jsonSerializeSesion(){
        return [
            'id_evento' => $this->id,
            'titulo' => $this->titulo,
            'fecha_desde' => $this->fecha_desde,
            'fecha_hasta' => $this->fecha_hasta,
            'categoria' => $this->categoria->jsonSerialize(),
            'evento_imagen' => $this->eventoImagen->jsonSerialize(),
        ];
    }
    public function jsonSerialize() {
        return [
            'id_evento' => $this->id,
            'titulo' => $this->titulo,
            'fecha_desde' => $this->fecha_desde,
            'fecha_hasta' => $this->fecha_hasta,
            'categoria' => $this->categoria->jsonSerialize(),
            'sede' => $this->sede->jsonSerialize(),
            'evento_imagen' => $this->eventoImagen->jsonSerialize(),
            'descripcion' => $this->descripcion,
            'calendarios' => $this->calendariosToArray()
        ];
    }
}