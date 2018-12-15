<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 30/11/2018
 * Time: 22:09
 */

namespace Dao;


use Modelo\Compra;

class CompraListaDao extends SingletonDao implements IDao
{
    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaCompras'])){
            $_SESSION['ListaCompras'] = array();
        }
    }

    private function setSessionCompra($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaCompras'] = $array;
    }
    private function getSessionCompra(){
        return $_SESSION['ListaCompras'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaCompras'])) {
            $ultimo = end($_SESSION['ListaCompras']);
            $index = array_search($ultimo, $_SESSION['ListaCompras']);
        }else $index = -1;
        return $index;
    }

    public function getAll(){
        if(isset($_SESSION['ListaCompras'])){
            $this->mapear($_SESSION['ListaCompras']);
        }
        return $this->lista;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaCompras'][] = $data->jsonSerialize();
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
        $this->setSessionCompra($lista);
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
        $this->setSessionCompra($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionCompra();
        $array = [];
        foreach ($lista as $key => $item){
            if($item['id_compra'] == $id){
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

    public function traerPorIdCliente($id){
        $lista = $this->getAll();
        $compras = null;
        foreach($lista as $key => $item){
            $cliente = $item->getCliente();
            if($cliente->getId() == $id){
                $compras[] = $item;
            }
        }
        return $compras;
    }
    private function mapear($array){
        $this->lista = array_map( function($p){
            $clienteDao = ClienteListaDao::getInstance();
            $cliente = $clienteDao->retrieve($p['cliente']['id_cliente']);
            $compra = new Compra($cliente,$p['total'],$p['fecha']);
            $compra->setId($p['id_compra']);
            return $compra;

        }, $array);
    }
}