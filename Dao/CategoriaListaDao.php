<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 28/11/2018
 * Time: 18:24
 */

namespace Dao;


use Modelo\Categoria;

class CategoriaListaDao extends SingletonDao implements IDao
{
    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaCategorias'])){
            $_SESSION['ListaCategorias'] = array();
        }
    }

    private function setSessionCategoria($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaCategorias'] = $array;
    }
    private function getSessionCategoria(){
        return $_SESSION['ListaCategorias'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaCategorias'])) {
            $ultimo = end($_SESSION['ListaCategorias']);
            $index = array_search($ultimo, $_SESSION['ListaCategorias']);
        }else $index = -1;
        return $index;
    }
    public function descripcionExists($desc){
        $categorias = $this->getAll();
        $flag = FALSE;
        foreach ($categorias as $categoria){
            if($categoria->getDescripcion() === $desc){
                $flag = TRUE;
                break;
            }
        }
        return $flag;
    }
    public function traerPorDescripcion($desc){
        $categorias = $this->getAll();
        $categoria = FALSE;
        foreach ($categorias as $key => $item){
            if(!strcasecmp($item->getDescripcion(), $desc)){
                $categoria = $item;
                break;
            }
        }
        return $categoria;
    }
    public function getAll(){
        if(isset($_SESSION['ListaCategorias'])){
            $this->mapear($_SESSION['ListaCategorias']);
        }
        return $this->lista;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaCategorias'][] = $data->jsonSerialize();
        return $this->getLastInsertId();
    }

    public function update($data)
    {
        $lista = $this->getAll();
        foreach ($lista as $key => $item){
            if($item->getId() == $data->getId()){
                $categoria = $data;
                $lista[$key] = $categoria;
                break;
            }
        }
        $this->setSessionCategoria($lista);
    }

    public function delete($data)
    {
        $lista = $this->getAll();
        foreach ($lista as $key => $item){
            if($item->getId() == $data->getId()){
                unset($lista[$key]);
                break;
            }
        }
        $this->setSessionCategoria($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionCategoria();
        $array = [];
        foreach ($lista as $key => $item){
            if($item['id_categoria'] == $id){
                $array[] = $lista[$key];
                break;
            }
        }
        $this->mapear($array);
        if(!empty($this->lista)){
            return $this->lista[0];
        }
        return false;
    }

    public function traerPorNombre($nombre){
        $lista = $this->getAll();
        $array = [];
        foreach ($lista as $key => $item){
            if($item->getNombre() === $nombre){
                $array[] = $lista[$key];
                break;
            }
        }
        $this->mapear($array);
        return $this->lista;

    }
    private function mapear($array){
        $this->lista = array_map( function($p){
            $categoria = new Categoria($p['descripcion']);
            $categoria->setId($p['id_categoria']);
            return $categoria;
        }, $array);
    }
}