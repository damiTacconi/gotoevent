<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 01:45
 */

namespace Controladora;
use Dao\CategoriaBdDao as CategoriaDao;
#use Dao\CategoriaListaDao as CategoriaDao;
use Modelo\Categoria;
use Modelo\Mensaje;

class CategoriaControladora extends PaginaControladora
{
    private $categoriaDao;
    function __construct()
    {
        $this->categoriaDao = CategoriaDao::getInstance();
    }

    function crear(){
        $this->page('crearCategoria','Crear Categoria',2);
    }
    function eliminar($id){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin'){
            $categoria = $this->categoriaDao->retrieve($id);
            try {
                if ($categoria->getId() !== null) {
                    $this->categoriaDao->delete($categoria);
                    $mensaje = new Mensaje('La categoria fue eliminada', 'success');
                } else {
                    $mensaje = new Mensaje('No se encontro la categoria en la Base de Datos', 'danger');
                }
            }catch (\PDOException $e){
                $mensaje = new Mensaje("No se pudo eliminar, tal vez haya un evento que utiliza esta categoria","danger");
            }
            $params = array('mensaje' => $mensaje->getAlert());
            $this->paginaListado($params);
        }else header('location: /');
    }

    private function paginaListado($array = []){
        $categorias = $this->categoriaDao->getAll();
          if ($categorias)
            $array['categorias'] = $categorias;
        $this->page('listado/listadoCategorias' , 'Categorias - Listado', 2, $array);
    }

    function listado(){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin'){
            $this->paginaListado();
        }else header('location: /');
    }
    function save($descripcion){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $descripcion = trim($descripcion);
            if(!empty($descripcion)) {
                if (!$this->categoriaDao->descripcionExists($descripcion)) {
                    $categoria = new Categoria($descripcion);
                    $this->categoriaDao->save($categoria);
                    $mensaje = new Mensaje("La categoria se agrego con exito!", 'success');
                }else $mensaje = new Mensaje('Ya existe una categoria con esa descripcion', 'danger');
            }else $mensaje = new Mensaje('Se debe ingresar una descripcion valida' , 'danger');
            $this->page('crearCategoria', 'Crear Categoria', 2, array(
                'mensaje' => $mensaje->getAlert()
            ));
        }else header('location: /');
    }

    function update($descripcion, $id_categoria){
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $categoria = $this->categoriaDao->retrieve($id_categoria);
        if($categoria){
          $categoria->setDescripcion($descripcion);
          $this->categoriaDao->update($categoria);
          $mensaje = new Mensaje("LA CATEGORIA SE ACTUALIZO CON EXITO!","success");
        }else $mensaje = new Mensaje("NO SE ENCONTRO EL ARTISTA", "danger");
        $params['mensaje'] = $mensaje->getAlert();
        $this->paginaListado($params);
      }
    }
}
