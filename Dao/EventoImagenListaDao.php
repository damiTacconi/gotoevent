<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 28/11/2018
 * Time: 19:14
 */

namespace Dao;


use Modelo\EventoImagen;

class EventoImagenListaDao extends SingletonDao implements IDao
{
    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaEventoImagenes'])){
            $_SESSION['ListaEventoImagenes'] = array();
        }
    }

    private function setSessionEventoImagen($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaEventoImagenes'] = $array;
    }
    private function getSessionEventoImagen(){
        return $_SESSION['ListaEventoImagenes'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaEventoImagenes'])) {
            $ultimo = end($_SESSION['ListaEventoImagenes']);
            $index = array_search($ultimo, $_SESSION['ListaEventoImagenes']);
        }else $index = -1;
        return $index;
    }

    public function getAll(){
        if(isset($_SESSION['ListaEventoImagenes'])){
            $this->mapear($_SESSION['ListaEventoImagenes']);
        }
        return $this->lista;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaEventoImagenes'][] = $data->jsonSerialize();
        return $this->getLastInsertId();
    }

    public function update($data)
    {
        $lista = $this->getAll();
        foreach ($lista as $key => $item){
            if($item->getId() == $data->getId()){
                $eventoImagen = $data;
                $lista[$key] = $eventoImagen;
                break;
            }
        }
        $this->setSessionEventoImagen($lista);
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
        $this->setSessionEventoImagen($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionEventoImagen();
        $array = [];
        foreach ($lista as $key => $item){
            if($item['id_imagen'] == $id){
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

    private function mapear($array){
        $this->lista = array_map( function($p){
            $eventoImagen = new EventoImagen($p['nombre'],$p['imagen']);
            $eventoImagen->setId($p['id_imagen']);
            return $eventoImagen;
        }, $array);
    }
}