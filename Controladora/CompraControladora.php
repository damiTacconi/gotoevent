<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 29/9/2018
 * Time: 23:16
 */

namespace Controladora;


use Dao\CalendarioBdDao;
use Dao\EventoBdDao;
use Dao\PlazaEventoBdDao;
use Dao\SedeBdDao;
use Dao\TipoPlazaBdDao;
use Modelo\Cart;
use Modelo\Sede;

class CompraControladora extends PaginaControladora
{
    private $eventDao;
    private $calendarDao;
    private $eventPlaceDao;
    private $tipoPlazaDao;
    private $sedeDao;
    function  __construct()
    {
        $this->calendarDao = CalendarioBdDao::getInstance();
        $this->eventDao = EventoBdDao::getInstance();
        $this->eventPlaceDao = PlazaEventoBdDao::getInstance();
        $this->tipoPlazaDao = TipoPlazaBdDao::getInstance();
        $this->sedeDao = SedeBdDao::getInstance();
    }

    function promo($id_evento){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $calendarios = $this->calendarDao->traerPorIdEvento($id_evento);

            foreach ($calendarios as $calendario){
                $plazaEventos = $this->eventPlaceDao->traerPorIdCalendario($calendario->getId());

            }
        }else header("location: /");
    }

    function terminar($id_plazas , $total){

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
                    $cantidad = (int) $item['cantidad'];
                    if($cantidad < 5)
                        $cantidad++;
                    $item['cantidad'] = (String)$cantidad;
                    $_SESSION['cart'][$key]['cantidad'] = $item['cantidad'];
                    $flag = TRUE;
                    break;
                }
            }
        }
        return $flag;
    }
    function addToCart($id, $cantidad){
        $plazaEvento = $this->eventPlaceDao->retrieve($id);
        if($plazaEvento){
            $respuesta = $this->verificarIdExistente($id);
            if(!$respuesta) {
                $cart = new Cart($plazaEvento, $cantidad);
                $_SESSION['cart'][] = $cart->jsonSerialize();
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