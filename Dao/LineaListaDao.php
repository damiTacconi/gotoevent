<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 30/11/2018
 * Time: 22:16
 */

namespace Dao;


use Modelo\Linea;

class LineaListaDao extends SingletonDao implements IDao
{
    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaLineas'])){
            $_SESSION['ListaLineas'] = array();
        }
    }

    private function setSessionLinea($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaLineas'] = $array;
    }
    private function getSessionLinea(){
        return $_SESSION['ListaLineas'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaLineas'])) {
            $ultimo = end($_SESSION['ListaLineas']);
            $index = array_search($ultimo, $_SESSION['ListaLineas']);
        }else $index = -1;
        return $index;
    }

    public function getAll(){
        if(isset($_SESSION['ListaLineas'])){
            $this->mapear($_SESSION['ListaLineas']);
        }
        return $this->lista;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaLineas'][] = $data->jsonSerialize();
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
        $this->setSessionLinea($lista);
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
        $this->setSessionLinea($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionLinea();
        $array = [];
        foreach ($lista as $key => $item){
            if($item['id_linea'] == $id){
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

    public function traerPorIdPlazaEvento($id){
        $lista = $this->getAll();
        $lineas = null;
        foreach ($lista as $key => $item){
            $plazaEvento = $item->getPlazaEvento();
            if($plazaEvento->getId() == $id){
                $lineas[] = $item;
            }
        }
        return $lineas;
    }

    public function traerPorIdCompra($id){
        $lista = $this->getAll();
        $lineas = null;
        foreach ($lista as $key => $item){
            $compra = $item->getCompra();
            if($compra->getId() == $id){
                $lineas[] = $item;
            }
        }
        return $lineas;
    }
    private function mapear($array){
        $this->lista = array_map( function($p){
            $plazaEventoDao = PlazaEventoListaDao::getInstance();
            $compraDao = CompraListaDao::getInstance();
            $plazaEvento = $plazaEventoDao->retrieve($p['plazaEvento']['id_plazaEvento']);
            $compra = $compraDao->retrieve($p['compra']['id_compra']);
            $linea = new Linea($plazaEvento, $p['cantidad'], $p['subtotal'], $compra);
            if($p['promo']){
                $promoDao = PromoListaDao::getInstance();
                $promo = $promoDao->retrieve($p['promo']['id_promo']);
                $linea->setPromo($promo);
            }
            $linea->setId($p['id_linea']);
            return $linea;
        }, $array);
    }

}