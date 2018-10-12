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
use Dao\LineaBdDao;
use Dao\PlazaEventoBdDao;
use Dao\SedeBdDao;
use Dao\TicketBdDao;
use Dao\TipoPlazaBdDao;
use Dao\CompraBdDao;
use Modelo\Cart;
use Modelo\Compra;
use Modelo\Linea;
use Modelo\Cliente;
use Modelo\QR;
use Modelo\Ticket;
use Modelo\Mensaje;
use Modelo\Mail;

class CompraControladora extends PaginaControladora
{
    private $eventDao;
    private $calendarDao;
    private $eventPlaceDao;
    private $tipoPlazaDao;
    private $clienteDao;
    private $compraDao;
    private $lineaDao;
    private $ticketDAo;
    function  __construct()
    {
        $this->ticketDAo = TicketBdDao::getInstance();
        $this->lineaDao = LineaBdDao::getInstance();
        $this->compraDao = CompraBdDao::getInstance();
        $this->clienteDao = ClienteBdDao::getInstance();
        $this->calendarDao = CalendarioBdDao::getInstance();
        $this->eventDao = EventoBdDao::getInstance();
        $this->eventPlaceDao = PlazaEventoBdDao::getInstance();
        $this->tipoPlazaDao = TipoPlazaBdDao::getInstance();
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
        $imagenes = array(
            [
                'path' => ROOT . 'public_html' . URL_IMG . "qr/{$numberTicket}.png",
                'cid' => "qr"
            ],
            [
                'path' => ROOT . 'public_html' . URL_IMG . 'icono.png',
                'cid' => "icon"
            ]
        );
        $plazaEvento = $line->getPlazaEvento();
        $plaza = $plazaEvento->getPlaza();
        $calendario = $plazaEvento->getCalendario();
        $evento = $calendario->getEvento();
        $imagenes = str_replace("\\" , "/" , $imagenes);
        $html = ("<h1><img style='vertical-align: middle' src='cid:icon'><span>GoToEvent</span> </h1>
                            <p>Gracias {$_SESSION['name']} , su ticket fue generado: </p>
                            <p>Ticket <strong>N°{$numberTicket}</strong></p>
                            <div style='text-align: center'><img src='cid:qr'></div>
                            <p><strong>Evento</strong>: {$evento->getTitulo()} </p>
                            <p><strong>Plaza</strong>: {$plaza->getDescripcion()}</p>
                            <p><strong>Fecha</strong>: {$calendario->getFecha()}</p>
                            <hr>
                            <p><i>Este codigo QR solo podra usarse una vez.</i></p>
                            <br>
                            <small>Equipo de GoToEvent - 2018</small>");
        $mail->enviarMail("GoToEvent - TICKET", $html,$_SESSION['email'] , $imagenes);
    }
    private function generateTicket($line){
        $digits = 10;
        $numberTicket = strval(rand(pow(10, $digits-1), pow(10, $digits)-1));
        $qrContent = ("Nombre Cliente: " . $_SESSION['name'] . "\n"
                    . "Numero Ticket: " . $numberTicket);
        $ticket = new Ticket(date("Y-m-d H:i:s"), $numberTicket ,$line, $qrContent);
        $id_ticket = $this->ticketDAo->save($ticket);
        $ticket->setId($id_ticket);
        $qr = new QR();
        $qr->generateQR($qrContent, $numberTicket);
        $this->enviarEmail($numberTicket,$line);
    }
    private function generateLine($compra , $subtotales , $cantidades , $plazaEventos ){
        if($plazaEventos){
            foreach ($plazaEventos as $key => $plaza){
                $linea = new Linea($plaza,$cantidades[$key],$subtotales[$key],$compra);
                $id_linea = $this->lineaDao->save($linea);
                $linea->setId($id_linea);
                $remanente = $plaza->getRemanente();

                for($i=0; $i<$cantidades[$key];$i++) {
                  $remanente--;
                   $this->generateTicket($linea);
                }

                $plaza->setRemanente($remanente);
                $this->eventPlaceDao->update($plaza);


            }
        }
    }

    function terminar($cantidades, $subtotales, $id_plazaEventos , $total ){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $plazaEventos = $this->traerPlazaEventos($id_plazaEventos);
            if(isset($_SESSION['fb_access_token'])) {
                $cliente = $this->clienteDao->getForIdFacebook($_SESSION['id']);
                if(!$cliente){
                    $cliente = new Cliente($_SESSION['first_name'], $_SESSION['last_name']);
                    $cliente->setIdFb($_SESSION['id']);
                    $id_cliente = $this->clienteDao->save($cliente);
                    $cliente->setId($id_cliente);
                }
            }else{
                $cliente = $this->clienteDao->traerPorEmail($_SESSION['email']);
            }
            $compra = new Compra($cliente,$total,date("Y-m-d H:i:s"));
            $id_compra = $this->compraDao->save($compra);
            $compra->setId($id_compra);
            $this->generateLine($compra, $subtotales , $cantidades, $plazaEventos);
            $mensaje = new Mensaje("EL TICKET SE GENERO CON EXITO" , "success");

            $_SESSION['cart'] = array();
            $params['mensaje'] = $mensaje->getAlert();
            $params['TICKET_MODAL'] = "ON";
            $this->page("inicio" , "GoToEvent" , 0, $params);
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


    /* FUNCIONES AJAX */

    function consultarAjax($id_evento){
      if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['rol'] === 'admin'){

        $eventoDao = $this->eventDao;
        $calendarioDao = $this->calendarDao;
        $lineaDao = $this->lineaDao;
        $plazaEventoDao = $this->eventPlaceDao;

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
