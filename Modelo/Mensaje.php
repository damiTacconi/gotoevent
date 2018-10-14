<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 16:39
 */

namespace Modelo;


class Mensaje
{
    protected $mensaje;
    protected $tipo;

    /**
     * Mensaje constructor.
     * @param $mensaje
     * @param $tipo
     */
    public function __construct($mensaje, $tipo)
    {
        $this->mensaje = $mensaje;
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * @param mixed $mensaje
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    function getAlert( $close=true ){
        $html = ("<div class=\"alert alert-{$this->getTipo()} alert-dismissible  fade show\" role=\"alert\">
                    {$this->getMensaje()}
                    ". ($close === true ? ("<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                    </button>") : '') ."
                </div>");
        return $html;
    }

}