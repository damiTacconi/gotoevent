<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 29/11/2018
 * Time: 16:37
 */

namespace Dao;


use Modelo\Calendario;

class CalendarioListaDao extends SingletonDao implements IDao
{
    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaCalendarios'])){
            $_SESSION['ListaCalendarios'] = array();
        }
    }

    private function setSessionCalendario($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaCalendarios'] = $array;
    }
    private function getSessionCalendario(){
        return $_SESSION['ListaCalendarios'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaCalendarios'])) {
            $ultimo = end($_SESSION['ListaCalendarios']);
            $index = array_search($ultimo, $_SESSION['ListaCalendarios']);
        }else $index = -1;
        return $index;
    }

    public function getAll(){
        if(isset($_SESSION['ListaCalendarios'])){
            $this->mapear($_SESSION['ListaCalendarios']);
        }
        return $this->lista;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaCalendarios'][] = $data->jsonSerialize();
        return $this->getLastInsertId();
    }

    public function update($data)
    {
        $lista = $this->getAll();
        foreach ($lista as $key => $item){
            if($item->getId() == $data->getId()){
                $calendario = $data;
                $lista[$key] = $calendario;
                break;
            }
        }
        $this->setSessionCalendario($lista);
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
        $this->setSessionCalendario($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionCalendario();
        $array = [];
        foreach ($lista as $key => $item){
            if($item['id_calendario'] == $id){
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
    public function fechaExists($id_evento, $fecha){
        $calendarios = $this->getAll();
        $flag = FALSE;
        foreach ($calendarios as $key => $item) {
            if ($item->getEvento()->getId() === $id_evento) {
                if($item->getFecha() === $fecha){
                    $flag = TRUE;
                    break;
                }
            }
        }
        return $flag;
    }
    public function traerPorIdEvento($id_evento){
        $calendarios = $this->getAll();
        foreach ($calendarios as $key => $item){
            if($item->getEvento()->getId() != $id_evento){
                unset($calendarios[$key]);
            }
        }
        return $calendarios;
    }
    public function traerPorIdEventoYFecha($id_evento, $fecha){
        $calendarios = $this->getAll();
        $calendario = false;
        foreach ($calendarios as $key => $item){
            if($item->getFecha() === $fecha && $item->getEvento()->getId() == $id_evento){
                $calendario = $item;
                break;
            }
        }
        return $calendario;
    }
    public function traerFechasDeEventoEnUnaSede($id_evento, $id_sede){
        $calendarios = $this->getAll();
        if($calendarios) {
            foreach ($calendarios as $key => $item) {
                if ($item->getEvento()->getId() != $id_evento) {
                    unset($calendarios[$key]);
                }
            }
            foreach ($calendarios as $key => $item) {
                if ($item->getSede()->getId() != $id_sede) {
                    unset($calendarios[$key]);
                }
            }
            return $calendarios;
        }
        return false;
    }
    private function mapear($array){
        $this->lista = array_map( function($p){
            $eventoDao = EventoListaDao::getInstance();
            $sedeDao = SedeListaDao::getInstance();
            $evento = $eventoDao->retrieve($p['evento']['id_evento']);
            $sede = $sedeDao->retrieve($p['sede']['id_sede']);
            $calendario = new Calendario($p['fecha'] , $evento, $sede);
            $calendario->setId($p['id_calendario']);
            return $calendario;
        }, $array);
    }


}