<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 27/11/2018
 * Time: 11:42
 */

namespace Dao;


use Modelo\Artista;

class ArtistaListaDao extends SingletonDao implements IDao
{
    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaArtistas'])){
            $_SESSION['ListaArtistas'] = array();
        }
    }

    private function setSessionArtista($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaArtistas'] = $array;
    }
    private function getSessionArtista(){
        return $_SESSION['ListaArtistas'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaArtistas'])) {
            $ultimoArtista = end($_SESSION['ListaArtistas']);
            $index = array_search($ultimoArtista, $_SESSION['ListaArtistas']);
        }else $index = -1;
        return $index;
    }
    public function getAll(){
       if(isset($_SESSION['ListaArtistas'])){
           $this->mapear($_SESSION['ListaArtistas']);
       }
       return $this->lista;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaArtistas'][] = $data->jsonSerialize();
        return $this->getLastInsertId();
    }

    public function update($data)
    {
        $lista = $this->getAll();
        foreach ($lista as $key => $item){
            if($item->getId() == $data->getId()){
                $artista = $data;
                $lista[$key] = $artista;
                break;
            }
        }
        $this->setSessionArtista($lista);
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
        $this->setSessionArtista($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionArtista();
        $array = [];
        foreach ($lista as $key => $item){
            if($item['id_artista'] == $id){
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
    public function artistExists($nombre){
        $lista = $this->getAll();
        $flag = FALSE;
        foreach ($lista as $key => $item) {
            if($item->getNombre() === $nombre){
                $flag = TRUE;
                break;
            }
        }
        return $flag;
    }

    private function mapear($array){
        $this->lista = array_map( function($p){
            $artista = new Artista($p['nombre']);
            $artista->setId($p['id_artista']);
            return $artista;
        }, $array);
    }
}