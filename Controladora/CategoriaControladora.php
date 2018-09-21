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
    function eliminar($id){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin'){
            $categoria = $this->categoriaDao->retrieve($id);
            if($categoria->getId() !== null){
                $this->categoriaDao->delete($categoria);
                $mensaje = new Mensaje('La categoria fue eliminada' , 'success');
            }else{
                $mensaje = new Mensaje('No se encontro la categoria en la Base de Datos', 'danger');
            }
            $categorias = $this->categoriaDao->getAll();
            $array = array('mensaje' => $mensaje->getAlert());

            if($categorias)
                $array['categorias'] = $categorias;

            $this->page('listadoCategorias', 'Categorias - Listado', 2, $array);
        }else header('location: /');
    }

    function listado(){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin'){
            $categorias = $this->categoriaDao->getAll();
            if($categorias){
                $this->page('listadoCategorias' , 'Categorias - Listado', 2, array(
                    'categorias' => $categorias
                ));
            }else{
                $mensaje = new Mensaje('No Hay categorias cargadas' , 'warning');
                $this->page('listadoCategorias' , 'Categorias - Listado', 2, array(
                    'mensaje' => $mensaje->getAlert()
                ));
            }

        }else header('location: /');
    }
    function save($descripcion){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $descripcion = trim($descripcion);
            if(!empty($descripcion)) {
                if (!$this->categoriaDao->DescripcionExists($descripcion)) {
                    $categoria = new Categoria($descripcion);
                    $this->categoriaDao->save($categoria);
                    $mensaje = new Mensaje("La categoria se agrego con exito!", 'success');
                } else {
                    $mensaje = new Mensaje('Ya existe una categoria con esa descripcion', 'danger');
                }
                $this->page('crearCategoria', 'Crear Categoria', 2, array(
                    'mensaje' => $mensaje->getAlert()
                ));
            }else{
                $mensaje = new Mensaje('Se debe ingresar una descripcion valida' , 'danger');
                $this->page('crearCategoria', 'Crear Categoria', 2, array(
                    'mensaje' => $mensaje->getAlert()
                ));
            }
        }else header('location: /');
    }
}