<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 29/9/2018
 * Time: 23:16
 */

namespace Controladora;


use Dao\CalendarioBdDao;
use Dao\ClienteBdDao;
use Dao\EventoBdDao;
use Dao\PlazaEventoBdDao;
use Dao\SedeBdDao;
use Dao\TipoPlazaBdDao;
use Dao\CompraBdDao;
use Modelo\Cart;
use Modelo\Compra;
use Modelo\Sede;

class CompraControladora extends PaginaControladora
{
    private $eventDao;
    private $calendarDao;
    private $eventPlaceDao;
    private $tipoPlazaDao;
    private $sedeDao;
    private $clienteDao;
    private $compraDao;
    function  __construct()
    {
        $this->compraDao = CompraBdDao::getInstance();
        $this->clienteDao = ClienteBdDao::getInstance();
        $this->calendarDao = CalendarioBdDao::getInstance();
        $this->eventDao = EventoBdDao::getInstance();
        $this->eventPlaceDao = PlazaEventoBdDao::getInstance();
        $this->tipoPlazaDao = TipoPlazaBdDao::getInstance();
        $this->sedeDao = SedeBdDao::getInstance();
    }

    private function traerPlazaEventos($id_plazaEventos){
        $plazaEventos = array_map(function ($id){
            $plazaEvento = $this->eventPlaceDao->retrieve($id);
            return $plazaEvento;
        } , $id_plazaEventos);
        return $plazaEventos;
    }
    function terminar($precios, $cantidades, $subtotales, $id_plazaEventos , $total ){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $plazaEventos = $this->traerPlazaEventos($id_plazaEventos);
            if(isset($_SESSION['fb_access_token'])) {
                $cliente = new Cliente($_SESSION['first_name'], $_SESSION['last_name']);
                $id_cliente = $this->clienteDao->save($cliente);
                $cliente->setId($id_cliente);
                $compra = new Compra($cliente,$total);
                //$id_compra =
            }
            //$compra = new Compra()
        }else header("location: /");
    }
    function clear(){
        $_SESSION['cart'] = array();
    }

    function removeOfCart($id){
        if(isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    private function verificarIdExistente($id){
        $flag = FALSE;
        if(isset($_SESSION['cart'])){
            $cart = $_SESSION['cart'];
            foreach ($cart as $key => $item){
                if($item['plazaEvento']['id_plazaEvento'] === $id){
                    $flag = TRUE;
                    break;
                }
            }
        }
        return $flag;
    }

    private function sumarCantidad($cantidad , $id){
        $cart = $_SESSION['cart'];
        foreach ($cart as $key => $item){
            if($item['plazaEvento']['id_plazaEvento'] === $id){
                $cantidad += (int) $item['cantidad'];
                if($cantidad > 5)
                    $cantidad = 5;
                $item['cantidad'] = (String) $cantidad;
                $_SESSION['cart'][$key]['cantidad'] = $item['cantidad'];
                break;
            }
        }
    }
    function addToCart($id, $cantidad){
        $plazaEvento = $this->eventPlaceDao->retrieve($id);
        if($plazaEvento){
            $respuesta = $this->verificarIdExistente($id,$cantidad);
            if(!$respuesta) {
                $cart = new Cart($plazaEvento, $cantidad);
                $_SESSION['cart'][] = $cart->jsonSerialize();
            }else{
                $this->sumarCantidad($cantidad,$id);
            }
            $calendario = $plazaEvento->getCalendario();
            $evento = $calendario->getEvento();
            header('location: /compra/evento/'. $evento->getId());
        }else header('location: /');
    }
    function evento($id_evento){
        $evento = $this->eventDao->retrieve($id_evento);
        if($evento) {
            $params['evento'] = $evento;
            $calendarios = $this->calendarDao->traerPorIdEvento($id_evento);
            foreach($calendarios as $calendario){
                $id_calendario = $calendario->getId();
                $plazas = $this->eventPlaceDao->traerPorIdCalendario($id_calendario);
                if($plazas)
                    $calendario->setPlazaEventos($plazas);
            }
            $params['calendarios'] = $calendarios;
            $this->page("comprarEvento", $evento->getTitulo(), 0, $params);
        }else header('location: /');
    }
}
