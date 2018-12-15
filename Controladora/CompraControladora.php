<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 29/9/2018
 * Time: 23:16
 */
namespace Controladora;
# LISTAS

/*use Dao\CalendarioListaDao as CalendarioDao;
use Dao\ClienteListaDao as ClienteDao;
use Dao\EventoListaDao as EventoDao;
use Dao\LineaListaDao as LineaDao;
use Dao\PlazaEventoListaDao as PlazaEventoDao;
use Dao\SedeListaDao as SedeDao;
use Dao\TicketListaDao as TicketDao;
use Dao\TipoPlazaListaDao as TipoPlazaDao;
use Dao\CompraListaDao as CompraDao;
use Dao\PromoListaDao as PromoDao;
*/
# BASE DE DATOS
use Dao\CalendarioBdDao as CalendarioDao;
use Dao\ClienteBdDao as ClienteDao;
use Dao\EventoBdDao as EventoDao;
use Dao\LineaBdDao as LineaDao;
use Dao\PlazaEventoBdDao as PlazaEventoDao;
use Dao\SedeBdDao as SedeDao;
use Dao\TicketBdDao as TicketDao;
use Dao\TipoPlazaBdDao as TipoPlazaDao;
use Dao\CompraBdDao as CompraDao;
use Dao\PromoBdDao as PromoDao;

use Modelo\Carrito;
use Modelo\Compra;
use Modelo\Linea;
use Modelo\Cliente;
use Modelo\QR;
use Modelo\Ticket;
use Modelo\Mensaje;
use Modelo\Mail;
use PHPMailer\PHPMailer\Exception;

class CompraControladora extends PaginaControladora
{
    private $eventDao;
    private $calendarDao;
    private $eventPlaceDao;
    private $tipoPlazaDao;
    private $clienteDao;
    private $compraDao;
    private $lineaDao;
    private $sedeDao;
    private $ticketDAo;
    private $promoDao;
    function  __construct()
    {
        $this->promoDao = PromoDao::getInstance();
        $this->sedeDao  = SedeDao::getInstance();
        $this->ticketDAo = TicketDao::getInstance();
        $this->lineaDao = LineaDao::getInstance();
        $this->compraDao = CompraDao::getInstance();
        $this->clienteDao = ClienteDao::getInstance();
        $this->calendarDao = CalendarioDao::getInstance();
        $this->eventDao = EventoDao::getInstance();
        $this->eventPlaceDao = PlazaEventoDao::getInstance();
        $this->tipoPlazaDao = TipoPlazaDao::getInstance();
    }
    private function traerPlazaEventos($id_plazaEventos){
        $plazaEventos = array_map(function ($id){
            $plazaEvento = $this->eventPlaceDao->retrieve($id);
            return $plazaEvento;
        } , $id_plazaEventos);
        return $plazaEventos;
    }
    private function enviarEmail($numberTicket,$line){

        $mail = new Mail();
        $root = ROOT . 'public_html' . URL_IMG;
        $imagenes = array(
            [
                'path' => $root . "qr/{$numberTicket}.png",
                'cid' => "qr"
            ],
            [
                'path' => $root . 'icono.png',
                'cid' => "icon"
            ]
        );
        $plazaEvento = $line->getPlazaEvento();
        $plaza = $plazaEvento->getPlaza();
        $calendario = $plazaEvento->getCalendario();
        $evento = $calendario->getEvento();
        $sede = $calendario->getSede();
        $imagenes = str_replace("\\" , "/" , $imagenes);
        $html = ("<h1><img style='vertical-align: middle' src='cid:icon'><span>GoToEvent</span> </h1>
                            <p>Gracias {$_SESSION['name']} , su ticket fue generado: </p>
                            <p>Ticket <strong>N°{$numberTicket}</strong></p>
                            <div style='text-align: center'><img src='cid:qr'></div>
                            <p><strong>Evento</strong>: {$evento->getTitulo()} </p>
                            <p><strong>Sede</strong>: {$sede->getNombre()} </p>
                            <p><strong>Plaza</strong>: {$plaza->getDescripcion()}</p>
                            <p><strong>Fecha</strong>: {$calendario->getFecha()}</p>
                            <hr>
                            <p><i>Este codigo QR solo podra usarse una vez.</i></p>
                            <br>
                            <small>Equipo de GoToEvent - 2018</small>");
        try{
            $mail->enviarMail("GoToEvent - TICKET", $html,$_SESSION['email'] , $imagenes);
        }catch(\Exception $e){
            $compra = $line->getCompra();
            $this->compraDao->delete($compra);
            throw $e;
        }
    }
    private function generateTicket($line){
        $digits = 10;
        $plazaEvento = $line->getPlazaEvento();
        $plaza = $plazaEvento->getPlaza();
        $calendario = $plazaEvento->getCalendario();
        $evento = $calendario->getEvento();
        $sede = $calendario->getSede();
        $numberTicket = strval(rand(pow(10, $digits-1), pow(10, $digits)-1));
        $qrContent = ("Nombre Cliente: " . $_SESSION['name'] . "\n"
                    . "Evento: " . $evento->getTitulo() . "\n"
                    . "Sede: " . $sede->getNombre() . "\n"
                    . "Plaza: " . $plaza->getDescripcion() . "\n"
                    . "Fecha: " . $calendario->getFecha() . "\n"
                    . "Numero Ticket: " . $numberTicket);
        $ticket = new Ticket(date("Y-m-d H:i:s"), $numberTicket ,$line, $qrContent);
        $id_ticket = $this->ticketDAo->save($ticket);
        $ticket->setId($id_ticket);
        $qr = new QR();
        $qr->generateQR($qrContent, $numberTicket);
        try {
            $this->enviarEmail($numberTicket, $line);
        }catch (\Exception $e){
            throw $e;
        }
    }
    private function generateLine($compra , $subtotales , $cantidades , $plazaEventos, $promos=[] ){
        if($plazaEventos){
            foreach ($plazaEventos as $key => $plaza){
                $linea = new Linea($plaza,$cantidades[$key],$subtotales[$key],$compra);
                if(!empty($promos)){
                  $id_promo = array_shift($promos);
                  $promo = $this->promoDao->retrieve($id_promo);
                  $linea->setPromo($promo);
                }
                $id_linea = $this->lineaDao->save($linea);
                $linea->setId($id_linea);
                $remanente = $plaza->getRemanente();
                for($i=0; $i<$cantidades[$key];$i++) {
                  $remanente--;
                  try {
                      $this->generateTicket($linea);
                  }catch (\Exception $e){
                      throw $e;
                  }
                }
                $plaza->setRemanente($remanente);
                $this->eventPlaceDao->update($plaza);
            }
        }
    }
    function terminarConPromoYPlazas($cantidadesPlazas, $subtotalesPlazas, $id_plazaEventos, $id_promos, $cantidadPromos, $total)
    {
      $this->terminarConPromo($id_promos,$cantidadPromos,$total,$cantidadesPlazas,$subtotalesPlazas,$id_plazaEventos);
    }
    function terminarConPromo($id_promos, $cantidadPromos, $total, $cantidadesPlazas = [], $subtotalesPlazas = [], $id_plazaEventos = []){
        $eventos = [];
        $idPromos = [];
        foreach ($id_promos as $key => $value) {
          $promo = $this->promoDao->retrieve($value);
          $evento = $this->eventDao->retrieve($promo->getEvento()->getId());
          $eventos[] = $evento;
        }
          foreach ($eventos as $key => $value){
              $calendarios = $this->calendarDao->traerPorIdEvento($value->getId());
              $cantidad = array_shift($cantidadPromos);
              $id_promo = array_shift($id_promos);
                foreach($calendarios as $key => $value){
                    $plazaEventos = $this->eventPlaceDao->traerPorIdCalendario($value->getId());
                    if($plazaEventos != null) { //debe verificar que haya plazaEvento cargada
                        if (count($plazaEventos) === 1) { //solo debe llegar 1 solo plazaEvento, si hay mas, se omite
                            $plazaEvento = $plazaEventos[0];
                            $id_plazaEventos[] = $plazaEvento->getId();
                            $cantidadesPlazas[] = (int)$cantidad;
                            $subtotalesPlazas[] = $plazaEvento->getPrecio();
                            $idPromos[] = $id_promo;
                        }
                    }
              }
          }
        $this->terminar($cantidadesPlazas,$subtotalesPlazas,$id_plazaEventos,$total, $idPromos);
    }
    function terminar($cantidades, $subtotales, $id_plazaEventos , $total , $id_promos = []){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $cliente = $this->clienteDao->traerPorEmail($_SESSION['email']);
            $compra = new Compra($cliente,$total,date("Y-m-d H:i:s"));
            $id_compra = $this->compraDao->save($compra);
            $compra->setId($id_compra);
            $plazaEventos = $this->traerPlazaEventos($id_plazaEventos);
            if($plazaEventos){
                try {
                    if (!empty($id_promos)) {
                        $this->generateLine($compra, $subtotales, $cantidades, $plazaEventos, $id_promos);
                    } else $this->generateLine($compra, $subtotales, $cantidades, $plazaEventos);
                    $mensaje = new Mensaje("EL TICKET SE GENERO CON EXITO", "success");
                    $params['TICKET_MODAL'] = "SUCCESS";
                }catch(\Exception $e){
                    $mensaje = new Mensaje("NO SE PUDO COMPLETAR LA OPERACION, INTENTE MAS TARDE", "danger");
                    $params['TICKET_MODAL'] = "ERROR";
                }
            }else{
                $mensaje = new Mensaje("NO SE PUDO COMPLETAR LA OPERACION" , "danger");
                $params['TICKET_MODAL'] = "ERROR";
            }
            $_SESSION['cart'] = array();
            $_SESSION['cartPromo'] = array();
            $params['mensaje'] = $mensaje->getAlert();
            $this->page("inicio" , "GoToEvent" , 0, $params);
        }else header("location: /");
    }
    function clear(){
        $_SESSION['cart'] = array();
        $_SESSION['cartPromo'] = array();
    }
    function removeOfCart($id){
        if(isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }
    function removeOfCartPromo($id){
      if(isset($_SESSION['cartPromo'][$id])){
        unset($_SESSION['cartPromo'][$id]);
      }
    }
    private function verificarIdPromoExistente($id){
      $flag = FALSE;
      if(isset($_SESSION['cartPromo'])){
          $cart = $_SESSION['cartPromo'];
          foreach ($cart as $key => $item){
              if($item['id_promo'] === $id){
                  $flag = TRUE;
                  break;
              }
          }
      }
      return $flag;
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
    private function sumarCantidadPromo($cantidad , $id){
        $cart = $_SESSION['cartPromo'];
        foreach ($cart as $key => $item){
            if($item['id_promo'] === $id){
                $cantidad += (int) $item['cantidad'];
                if($cantidad > 5)
                    $cantidad = 5;
                $item['cantidad'] = (String) $cantidad;
                $_SESSION['cartPromo'][$key]['cantidad'] = $item['cantidad'];
                break;
            }
        }
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
    private function traerTotalPrecioPlazas($calendarios){
      $total = array_map( function($cal){
          $id_calendario = $cal->getId();
          $plazas = $this->eventPlaceDao->traerPorIdCalendario($id_calendario);
          $cantidad = 0;
          foreach ($plazas as $key => $value) {
              $cantidad += $value->getPrecio();
          }
          return $cantidad;
      }, $calendarios);
      $total = array_sum($total);
      return $total;
    }
    function addToCartPromo($id_promo, $cantidad , $id_sede){
            $promo = $this->promoDao->retrieve($id_promo);
            $sede = $this->sedeDao->retrieve($id_sede);
            if($promo && $sede){
                $evento = $promo->getEvento();
                $id_evento = $evento->getId();
                $calendarios = $this->calendarDao->traerPorIdEvento($id_evento);
                $total = $this->traerTotalPrecioPlazas($calendarios);
                $jsonPromo = $promo->jsonSerialize();
                $jsonPromo['cantidad'] = $cantidad;
                $jsonPromo['precio'] = $total;
                $respuesta = $this->verificarIdPromoExistente($id_promo);
                if(!$respuesta)
                  $_SESSION['cartPromo'][] = $jsonPromo;
                else {
                  $this->sumarCantidadPromo($cantidad, $id_promo);
                }
                header('location: /evento/sede/'. $evento->getId() . '/' . $sede->getId() );
            }else header('location: /');
    }
    function addToCart($id, $cantidad){
        $plazaEvento = $this->eventPlaceDao->retrieve($id);
        if($plazaEvento){
            $respuesta = $this->verificarIdExistente($id,$cantidad);
            if(!$respuesta) {
                $cart = new Carrito($plazaEvento, $cantidad);
                $_SESSION['cart'][] = $cart->jsonSerialize();
            }else{
                $this->sumarCantidad($cantidad,$id);
            }
            $calendario = $plazaEvento->getCalendario();
            $sede = $calendario->getSede();
            $evento = $calendario->getEvento();
            header('location: /evento/sede/'. $evento->getId() . '/' . $sede->getId() );
        }else header('location: /');
    }
    /* FUNCIONES AJAX */
    function actualizarCantidad($cantidad , $id){
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
        foreach ($_SESSION['cart'] as $key => $value) {
          if($value['plazaEvento']['id_plazaEvento'] === $id){
            $_SESSION['cart'][$key]['cantidad'] = $cantidad;
          }
        }
      }else header("location: /");
    }
    function consultarAjax($id_evento){
      if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['rol'] === 'admin'){
        $eventoDao = $this->eventDao;
        $calendarioDao = $this->calendarDao;
        $evento = $eventoDao->retrieve($id_evento);
        $params = [];
        if($evento){
          $calendarios = $calendarioDao->traerPorIdEvento($id_evento);
          foreach ($calendarios as $key => $value) {
              $params[] = $this->consultarVentasPorCalendario($value->getId());
          }
        }
        echo json_encode($params);
      }else header("location: /");
    }
    private function consultarVentasPorCalendario($id_calendario){
            $plazaEventoDao = $this->eventPlaceDao;
            $plazaEventos = $plazaEventoDao->traerPorIdCalendario($id_calendario);
            $cantidadRemanentes = 0;
            $params = [];
            if($plazaEventos) {
                $calendario = $this->calendarDao->retrieve($id_calendario);
                $calendarioJSON = $calendario->jsonSerialize();
                $params['calendario'] = $calendarioJSON;
                foreach ($plazaEventos as $plaza) {
                    $cantidadRemanentes += $plaza->getRemanente();
                }
                $params['cantidad_remanentes_totales'] = $cantidadRemanentes;
                $lineasMulti = array_map(function ($plaza) {
                    $lineaDao = $this->lineaDao;
                    $id_plaza = $plaza->getId();
                    $lineas = $lineaDao->traerPorIdPlazaEvento($id_plaza);
                    return $lineas;
                }, $plazaEventos);
                $lineasMulti = array_filter($lineasMulti);
                if(!empty($lineasMulti)) {
                    $lineasSingle = [];
                    foreach ($lineasMulti as $arr) {
                        $lineasSingle = array_merge($lineasSingle, $arr);
                    }
                    $cantidadVentas = $this->contarCantidadVentas($lineasSingle);
                    $lineasJSON = array_map(function ($linea) {
                        return $linea->jsonSerialize();
                    }, $lineasSingle);
                    $params['lineas'] = $lineasJSON;
                    $params['cantidad_ventas_totales'] = $cantidadVentas;
                }else{
                  $params['lineas'] = [];
                  $params['cantidad_ventas_totales'] = 0;
                }
            }
            return $params;
    }
    private function contarCantidadVentas($lineas){
        $cantidad = 0;
        foreach ($lineas as $linea){
            $cantidad += $linea->getCantidad();
        }
        return $cantidad;
    }
}
