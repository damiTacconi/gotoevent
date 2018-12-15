<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 30/11/2018
 * Time: 21:56
 */

namespace Dao;


use Modelo\Promo;

class PromoListaDao extends SingletonDao implements IDao
{
    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaPromos'])){
            $_SESSION['ListaPromos'] = array();
        }
    }

    private function setSessionPromo($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaPromos'] = $array;
    }
    private function getSessionPromo(){
        return $_SESSION['ListaPromos'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaPromos'])) {
            $ultimo = end($_SESSION['ListaPromos']);
            $index = array_search($ultimo, $_SESSION['ListaPromos']);
        }else $index = -1;
        return $index;
    }

    public function getAll(){
        if(isset($_SESSION['ListaPromos'])){
            $this->mapear($_SESSION['ListaPromos']);
        }
        return $this->lista;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaPromos'][] = $data->jsonSerialize();
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
        $this->setSessionPromo($lista);
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
        $this->setSessionPromo($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionPromo();
        $array = [];
        foreach ($lista as $key => $item){
            if($item['id_promo'] == $id){
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
    public function traerPorIdEvento($id){
        $promos = $this->getAll();
        $promo = null;
        foreach ($promos as $key => $item){
            $evento = $item->getEvento();
            if($evento->getId() == $id){
                $promo = $item;
                break;
            }
        }
        return $promo;
    }
    private function mapear($array){
        $this->lista = array_map( function($p){
            $eventoDao = EventoListaDao::getInstance();
            $evento = $eventoDao->retrieve($p['evento']['id_evento']);
            $promo = new Promo($p['descuento'],$evento);
            $promo->setId($p['id_promo']);
            return $promo;
        }, $array);
    }
}