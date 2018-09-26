<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 25/9/2018
 * Time: 15:42
 */

namespace Modelo;

use JsonSerializable;
class EventoImagen implements JsonSerializable
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


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
          'id_imagen' => $this->id,
          'nombre' => $this->nombre
        ];
    }
}