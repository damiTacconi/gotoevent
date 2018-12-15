<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 30/11/2018
 * Time: 15:47
 */

namespace Dao;


use Modelo\PlazaEvento;

class PlazaEventoListaDao extends SingletonDao implements IDao
{
    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaPlazaEvento'])){
            $_SESSION['ListaPlazaEvento'] = array();
        }
    }

    private function setSessionPlazaEvento($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaPlazaEvento'] = $array;
    }
    private function getSessionPlazaEvento(){
        return $_SESSION['ListaPlazaEvento'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaPlazaEvento'])) {
            $ultimo = end($_SESSION['ListaPlazaEvento']);
            $index = array_search($ultimo, $_SESSION['ListaPlazaEvento']);
        }else $index = -1;
        return $index;
    }

    public function getAll(){
        if(isset($_SESSION['ListaPlazaEvento'])){
            $this->mapear($_SESSION['ListaPlazaEvento']);
        }
        return $this->lista;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaPlazaEvento'][] = $data->jsonSerialize();
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
        $this->setSessionPlazaEvento($lista);
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
        $this->setSessionPlazaEvento($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionPlazaEvento();
        $array = [];
        foreach ($lista as $key => $item){
            if($item['id_plazaEvento'] == $id){
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

    public function traerPorIdEventoYPlaza($id_evento, $plaza){
        $plazaEventos = $this->getAll();
        $array = null;
        foreach ($plazaEventos as $key => $item){
            $calendario = $item->getCalendario();
            $evento = $calendario->getEvento();
            $tipoPlaza = $item->getPlaza();
            if($evento->getId() == $id_evento && $tipoPlaza->getDescripcion() === $plaza){
                $array[] = $item;
            }
        }
        return $array;
    }
    public function verificarPlazaExistente($id_calendario,$id_tipo_plaza){
        $plazaEventos = $this->getAll();
        $flag = false;
        foreach ($plazaEventos as $key => $item){
            $calendario = $item->getCalendario();
            $tipoPlaza = $item->getPlaza();
            if($calendario->getId() == $id_calendario && $tipoPlaza->getId() == $id_tipo_plaza){
                $flag = TRUE;
                break;
            }
        }
        return $flag;
    }

    public function traerPorIdCalendario($id_calendario){
        $plazaEventos = $this->getAll();
        $array = null;
        foreach ($plazaEventos as $key => $item){
            $calendario = $item->getCalendario();
            if($calendario->getId() == $id_calendario){
                $array[] = $item;
            }
        }
        return $array;
    }
    private function mapear($array){
        $this->lista = array_map( function($p){
            $calendarioDao = CalendarioListaDao::getInstance();
            $tipoPlazaDao = TipoPlazaListaDao::getInstance();
            $calendario = $calendarioDao->retrieve($p['calendario']['id_calendario']);
            $tipoPlaza = $tipoPlazaDao->retrieve($p['plaza']['id_tipo_plaza']);
            $plazaEvento = new PlazaEvento($p['capacidad'],$p['remanente'],$tipoPlaza,$calendario,$p['precio']);
            $plazaEvento->setId($p['id_plazaEvento']);
            return $plazaEvento;
        }, $array);
    }
}