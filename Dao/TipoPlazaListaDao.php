<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 30/11/2018
 * Time: 14:37
 */

namespace Dao;


use Modelo\TipoPlaza;

class TipoPlazaListaDao extends SingletonDao implements IDao
{
    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaTipoPlazas'])){
            $_SESSION['ListaTipoPlazas'] = array();
        }
    }

    private function setSessionTipoPlazas($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaTipoPlazas'] = $array;
    }
    private function getSessionTipoPlazas(){
        return $_SESSION['ListaTipoPlazas'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaTipoPlazas'])) {
            $ultimo = end($_SESSION['ListaTipoPlazas']);
            $index = array_search($ultimo, $_SESSION['ListaTipoPlazas']);
        }else $index = -1;
        return $index;
    }

    public function getAll(){
        if(isset($_SESSION['ListaTipoPlazas'])){
            $this->mapear($_SESSION['ListaTipoPlazas']);
        }
        return $this->lista;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaTipoPlazas'][] = $data->jsonSerialize();
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
        $this->setSessionTipoPlazas($lista);
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
        $this->setSessionTipoPlazas($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionTipoPlazas();
        $array = [];
        foreach ($lista as $key => $item){
            if($item['id_tipo_plaza'] == $id){
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

    public function descripcionExists($desc){
        $plazas = $this->getAll();
        $flag = FALSE;
        foreach ($plazas as $key => $item){
            if($item->getDescripcion() === $desc){
                $flag = TRUE;
                break;
            }
        }
        return $flag;

    }
    public function traerPorIdSede($id){
        $lista = $this->getAll();
        $tipoPlazas = null;
        if($lista){
            foreach ($lista as $key => $item){
                $sede = $item->getSede();
                if($sede->getId() == $id){
                    $tipoPlazas[] = $item;
                }
            }
        }
        return $tipoPlazas;
    }
    private function mapear($array){
        $this->lista = array_map( function($p){
            $sedeDao = SedeListaDao::getInstance();
            $sede = $sedeDao->retrieve($p['sede']['id_sede']);
            $tipoPlaza = new TipoPlaza($p['descripcion'],$sede);
            $tipoPlaza->setId($p['id_tipo_plaza']);
            return $tipoPlaza;
        }, $array);
    }
}