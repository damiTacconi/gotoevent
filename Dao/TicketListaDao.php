<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 30/11/2018
 * Time: 22:02
 */

namespace Dao;


use Modelo\Ticket;

class TicketListaDao extends SingletonDao implements IDao
{
    private $lista = [];

    function __construct()
    {
        if(!isset($_SESSION['ListaTickets'])){
            $_SESSION['ListaTickets'] = array();
        }
    }

    private function setSessionTicket($lista){
        $array = array_map( function($p){
            return $p->jsonSerialize();
        }, $lista);
        $_SESSION['ListaTickets'] = $array;
    }
    private function getSessionTicket(){
        return $_SESSION['ListaTickets'];
    }
    private function getLastInsertId(){
        if(!empty($_SESSION['ListaTickets'])) {
            $ultimo = end($_SESSION['ListaTickets']);
            $index = array_search($ultimo, $_SESSION['ListaTickets']);
        }else $index = -1;
        return $index;
    }

    public function getAll(){
        if(isset($_SESSION['ListaTickets'])){
            $this->mapear($_SESSION['ListaTickets']);
        }
        return $this->lista;
    }

    public function save($data)
    {
        $index = $this->getLastInsertId();
        $data->setId($index+1);
        $_SESSION['ListaTickets'][] = $data->jsonSerialize();
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
        $this->setSessionTicket($lista);
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
        $this->setSessionTicket($lista);
    }

    public function retrieve($id)
    {
        $lista = $this->getSessionTicket();
        $array = [];
        foreach ($lista as $key => $item){
            if($item['id_ticket'] == $id){
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
    public function traerPorIdLinea($id){
        $tickets = $this->getAll();
        $ticket = null;
        foreach ($tickets as $key => $item){
            $linea = $item->getLinea();
            if($linea->getId() == $id){
                $ticket[] = $item;
            }
        }
        return $ticket;
    }

    private function mapear($array){
        $this->lista = array_map( function($p){
            $lineaDao = LineaListaDao::getInstance();
            $linea = $lineaDao->retrieve($p['linea']['id_linea']);
            $ticket = new Ticket($p['fecha'],$p['numero'],$linea,$p['qr']);
            $ticket->setId($p['id_ticket']);
            return $ticket;
        }, $array);
    }
}