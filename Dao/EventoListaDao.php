<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 27/11/2018
 * Time: 11:42
 */

namespace Dao;


use Modelo\Evento;

class EventoListaDao extends SingletonDao implements IDao
{
    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaEventos'])){
            $_SESSION['ListaEventos'] = array();
        }
    }

    private function setSessionEvento($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaEventos'] = $array;
    }
    private function getSessionEvento(){
        return $_SESSION['ListaEventos'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaEventos'])) {
            $ultimoEvento = end($_SESSION['ListaEventos']);
            $index = array_search($ultimoEvento, $_SESSION['ListaEventos']);
        }else $index = -1;
        return $index;
    }

    public function getFechas($id_evento){
        $evento = $this->retrieve($id_evento);
        return [
                  'fecha_desde' => $evento->getFechaDesde() ,
                  'fecha_hasta' => $evento->getFechaHasta()
                ];

    }

    public function traerPorIdArtista($id_artista){

    }

    public function titleExists($titulo){
        $eventos = $this->getAll();
        $flag = FALSE;
        foreach ($eventos as $ev){
            if($titulo === $ev->getTitulo()){
                $flag = TRUE;
                break;
            }
        }
        return $flag;
    }

    public function traerPorIdCategoria($id_categoria){
        $lista = $this->getAll();
        $eventos = [];
        foreach($lista as $key => $evento){
            $categoria = $evento->getCategoria();
            if($categoria->getId() == $id_categoria){
                $eventos[] = $lista[$key];
            }
        }
        return $eventos;
    }
    public function getAll(){
        if(isset($_SESSION['ListaEventos'])){
            $this->mapear($_SESSION['ListaEventos']);
        }
        return $this->lista;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaEventos'][] = $data->jsonSerialize();
        return $this->getLastInsertId();
    }

    public function update($data)
    {
        $lista = $this->getAll();
        foreach ($lista as $key => $item){
            if($item->getId() == $data->getId()){
                $evento = $data;
                $lista[$key] = $evento;
                break;
            }
        }
        $this->setSessionEvento($lista);
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
        $this->setSessionEvento($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionEvento();
        $array = [];
        foreach ($lista as $key => $item){
            if($item['id_evento'] == $id){
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
            $categoriaDao = CategoriaListaDao::getInstance();
            $categoria = $categoriaDao->retrieve($p['categoria']['id_categoria']);
            $evento = new Evento($p['titulo'],$p['fecha_desde'],$p['fecha_hasta'],$categoria,$p['descripcion']);
            if(isset($p['evento_imagen']['id_imagen'])){
                $eventoImagenDao = EventoImagenListaDao::getInstance();
                $eventoImagen = $eventoImagenDao->retrieve($p['evento_imagen']['id_imagen']);
                $evento->setEventoImagen($eventoImagen);
            }
            $evento->setId($p['id_evento']);
            return $evento;
        }, $array);
    }
}