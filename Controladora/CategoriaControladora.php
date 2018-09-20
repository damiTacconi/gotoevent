<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 01:45
 */

namespace Controladora;


class CategoriaControladora extends PaginaControladora
{
    function crear(){
        $this->page('crearCategoria','Crear Categoria',2);
    }
}