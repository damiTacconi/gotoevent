<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 30/11/2018
 * Time: 15:14
 */

namespace Dao;


use Modelo\Show;

class ShowListaDao extends SingletonDao implements IDao
{
    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaShows'])){
            $_SESSION['ListaShows'] = array();
        }
    }

    private function setSessionShows($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaShows'] = $array;
    }
    private function getSessionShows(){
        return $_SESSION['ListaShows'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaShows'])) {
            $ultimo = end($_SESSION['ListaShows']);
            $index = array_search($ultimo, $_SESSION['ListaShows']);
        }else $index = -1;
        return $index;
    }

    public function getAll(){
        if(isset($_SESSION['ListaShows'])){
            $this->mapear($_SESSION['ListaShows']);
        }
        return $this->lista;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaShows'][] = $data->jsonSerialize();
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
        $this->setSessionShows($lista);
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
        $this->setSessionShows($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionShows();
        $array = [];
        foreach ($lista as $key => $item){
            if($item['id_show'] == $id){
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

    public function existsShow($id_artista, $id_calendario){
        $shows = $this->getAll();
        $flag = FALSE;
        foreach ($shows as $key => $item){
            $artista = $item->getArtista();
            $calendario = $item->getCalendario();
            if($artista->getId() == $id_artista && $calendario->getId() == $id_calendario){
                $flag = TRUE;
                break;
            }
        }
        return $flag;
    }

    public function traerPorIdCalendario($id_calendario){
        $shows = $this->getAll();
        $array = null;
        foreach ($shows as $key => $item){
            if($item->getCalendario()->getId() == $id_calendario){
                $array[] = $item;
            }
        }
        return $array;
    }
    private function mapear($array){
        $this->lista = array_map( function($p){
            $calendarioDao = CalendarioListaDao::getInstance();
            $artistaDao = ArtistaListaDao::getInstance();
            $calendario = $calendarioDao->retrieve($p['calendario']['id_calendario']);
            $artista = $artistaDao->retrieve($p['artista']['id_artista']);
            $show = new Show($artista,$calendario);
            $show->setId($p['id_show']);
            return $show;
        }, $array);
    }
}