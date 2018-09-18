<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 17/9/2018
 * Time: 13:23
 */

namespace Controladora;


class EventoControladora extends PaginaControladora
{
    function crear(){
        $this->page('crearEvento','Crear Evento',2);
    }
}