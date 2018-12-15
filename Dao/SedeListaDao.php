<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 28/11/2018
 * Time: 23:50
 */

namespace Dao;

use Modelo\Sede;

class SedeListaDao extends SingletonDao implements IDao
{
    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaSedes'])){
            $_SESSION['ListaSedes'] = array();
        }
    }

    private function setSessionSede($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaSedes'] = $array;
    }
    private function getSessionSede(){
        return $_SESSION['ListaSedes'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaSedes'])) {
            $ultimo = end($_SESSION['ListaSedes']);
            $index = array_search($ultimo, $_SESSION['ListaSedes']);
        }else $index = -1;
        return $index;
    }

    public function sedeExists($nombre){
        $lista = $this->getAll();
        $sede = false;
        foreach ($lista as $key => $item){
            if($item->getNombre() === $nombre){
                $sede = $item;
                break;
            }
        }
        return $sede;
    }
    public function getAll(){
        if(isset($_SESSION['ListaSedes'])){
            $this->mapear($_SESSION['ListaSedes']);
        }
        return $this->lista;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaSedes'][] = $data->jsonSerialize();
        return $this->getLastInsertId();
    }

    public function update($data)
    {
        $lista = $this->getAll();
        foreach ($lista as $key => $item){
            if($item->getId() == $data->getId()){
                $sede = $data;
                $lista[$key] = $sede;
                break;
            }
        }
        $this->setSessionSede($lista);
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
        $this->setSessionSede($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionSede();
        $array = [];
        foreach ($lista as $key => $item){
            if($item['id_sede'] == $id){
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

    public function traerPorId($id){
        $lista = $this->getAll();
        $sede = false;
        foreach ($lista as $key => $item){
            if($item->getId() === (Integer) $id){
                $sede = $item;
                break;
            }
        }
        return $sede;
    }

    private function my_array_unique($array, $keep_key_assoc = false){
        $duplicate_keys = array();
        $tmp = array();

        foreach ($array as $key => $val){
            // convert objects to arrays, in_array() does not support objects
            if (is_object($val))
                $val = (array)$val;

            if (!in_array($val, $tmp))
                $tmp[] = $val;
            else
                $duplicate_keys[] = $key;
        }

        foreach ($duplicate_keys as $key)
            unset($array[$key]);

        return $keep_key_assoc ? $array : array_values($array);
    }
    public function traerPorIdEvento($id_evento){
        $calendarioDao = CalendarioListaDao::getInstance();
        $calendarios = $calendarioDao->traerPorIdEvento($id_evento);
        $sedesCalendarios = [];
        foreach($calendarios as $key => $item){
            $sedesCalendarios[] = $item->getSede();
        }
        $sedesCalendarios = $this->my_array_unique($sedesCalendarios);
        return $sedesCalendarios;
    }
    private function mapear($array){
        $this->lista = array_map( function($p){
            $sede = new Sede($p['nombre'],$p['capacidad']);
            $sede->setId($p['id_sede']);
            return $sede;
        }, $array);
    }

}