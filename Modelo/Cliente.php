<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 4/9/2018
 * Time: 20:47
 */

namespace Modelo;


use JsonSerializable;
class Cliente implements JsonSerializable
{
    protected $id;
    protected $nombre;
    protected $apellido;
    protected $dni;
    protected $id_fb;
    protected $usuario = null;

    //atributo que no se almacena en BD
    private $compras = [];

    function __construct($nombre, $apellido)
    {
        $this->apellido = $apellido;
        $this->nombre = $nombre;
    }

    public function jsonSerialize()
    {
        $usuario = $this->usuario;
        if($usuario){
            $usuarioJson = $usuario->jsonSerialize();
        }else $usuarioJson = null;

        return [
          "id_cliente" => $this->id,
          "nombre" => $this->nombre,
          "apellido" => $this->apellido,
          "dni" => $this->dni,
          "id_fb" => $this->id_fb,
          "usuario" => $usuarioJson
        ];
    }

    /**
     * @return array
     */
    public function getCompras(): array
    {
        return $this->compras;
    }

    /**
     * @param array $compras
     */
    public function setCompras(array $compras): void
    {
        $this->compras = $compras;
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
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param mixed $apellido
     */
    public function setApellido($apellido): void
    {
        $this->apellido = $apellido;
    }

    /**
     * @return mixed
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param mixed $dni
     */
    public function setDni($dni): void
    {
        $this->dni = $dni;
    }

    /**
     * @return mixed
     */
    public function getIdFb()
    {
        return $this->id_fb;
    }

    /**
     * @param mixed $id_fb
     */
    public function setIdFb($id_fb): void
    {
        $this->id_fb = $id_fb;
    }

    /**
     * @return null
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param null $usuario
     */
    public function setUsuario($usuario): void
    {
        $this->usuario = $usuario;
    }



}