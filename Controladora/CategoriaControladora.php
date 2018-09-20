<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 01:45
 */

namespace Controladora;
use Dao\CategoriaBdDao;
use Modelo\Categoria;
use Modelo\Mensaje;

class CategoriaControladora extends PaginaControladora
{
    private $categoriaDao;
    function __construct()
    {
        $this->categoriaDao = CategoriaBdDao::getInstance();
    }

    function crear(){
        $this->page('crearCategoria','Crear Categoria',2);
    }

    function save($descripcion){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            if (!$this->categoriaDao->DescripcionExists($descripcion)) {
                    $categoria = new Categoria($descripcion);
                    $this->categoriaDao->save($categoria);
                    $mensaje = new Mensaje("La categoria se agrego con exito!", 'success');
                } else {
                    $mensaje = new Mensaje('Ya existe una categoria con esa descripcion', 'danger');
            }
            $this->page('crearCategoria','Crear Categoria', 2, array(
                'mensaje' => $mensaje->getAlert()
            ));
        }else header('location: /');
    }
}