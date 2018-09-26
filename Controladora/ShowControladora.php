<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 23/9/2018
 * Time: 11:35
 */

namespace Controladora;

use Dao\EventoBdDao;
use Dao\SedeBdDao;
use Dao\ShowBdDao;
use Dao\TipoPlazaBdDao;
use Modelo\Show;
use Dao\CategoriaBdDao;
use Modelo\Categoria;
use Dao\CalendarioBdDao;
use Modelo\Calendario;
use Dao\ArtistaBdDao;
use Modelo\Mensaje;

class ShowControladora extends PaginaControladora
{

    private $eventoDao;
    private $categoriaDao;
    private $artistaDao;
    private $showDao;
    private $calendarioDao;
    private $sedeDao;
    function __construct()
    {
        $this->sedeDao = SedeBdDao::getInstance();
        $this->eventoDao = EventoBdDao::getInstance();
        $this->categoriaDao = CategoriaBdDao::getInstance();
        $this->artistaDao = ArtistaBdDao::getInstance();
        $this->showDao = ShowBdDao::getInstance();
        $this->calendarioDao = CalendarioBdDao::getInstance();
    }

    private function saveCalendario($fecha ,$evento){
        $calendario = new Calendario($fecha, $evento);
        $id_calendario = $this->calendarioDao->save($calendario);
        $calendario->setId($id_calendario);
        return $calendario;
    }
    private function saveShow($id_artista,$hora_desde,$hora_hasta,$calendario){
        $artista = $this->artistaDao->retrieve($id_artista);
        $show = new Show($hora_desde,$hora_hasta,$artista,$calendario);
        $this->showDao->save($show);
    }
    private function buscarPorFecha($calendarios,$fecha){
        $calendario = null;
        if($calendarios) {
            for ($i = 0; $i < count($calendarios); $i++) {
                $date_calendario = strtotime($calendarios[$i]->getFecha());
                $date_fecha = strtotime($fecha);
                if ($date_fecha === $date_calendario) {
                    $calendario = $calendarios[$i];
                    break;
                }
            }
        }
        return $calendario;
    }
    private function verificarDisponibilidad($hora_inicio, $hora_fin, $shows){
        $info = [];
        if($shows){
            foreach ($shows as $show) {
                $show_hora_inicio = $show->getHoraInicio();
                $show_hora_fin = $show->getHoraFin();
                $time_inicio = strtotime($show_hora_inicio);
                $time_fin = strtotime($show_hora_fin);
                $time_param_inicio = strtotime($hora_inicio);
                $time_param_fin = strtotime($hora_fin);
                if (
                    ($time_param_inicio === $time_inicio)
                    ||
                    ($time_param_fin === $time_fin)
                    ||
                    ($time_param_inicio > $time_inicio) && ($time_param_inicio < $time_fin)
                    ||
                    ($time_param_fin > $time_inicio) && ($time_param_fin < $time_fin)
                    ||
                    ($time_param_inicio < $time_inicio) && ($time_param_fin > $time_fin)
                ){
                    $info['show'] = $show;
                    break;
                }
            }
        }
        return $info;
    }
    private function traerTodos(){
        $params = [];
        $sedes = $this->sedeDao->getAll();
        $categorias = $this->categoriaDao->getAll();
        $eventos = $this->eventoDao->getAll();
        $artistas = $this->artistaDao->getAll();
        $params['artistas'] = $artistas;
        $params['categorias'] = $categorias;
        $params['eventos'] = $eventos;
        $params['sedes'] = $sedes;
        return $params;
    }
    function save($id_evento, $fecha, $hora_desde, $hora_hasta, $id_artista){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $evento = $this->eventoDao->retrieve($id_evento);
            $evento_desde = $evento->getFechaDesde();
            $evento_hasta = $evento->getFechaHasta();
            $date_desde = strtotime($evento_desde);
            $date_hasta = strtotime($evento_hasta);
            $date_param = strtotime($fecha);
            $params = $this->traerTodos();
            if($date_param <  $date_desde){
                $mensaje = new Mensaje("LA FECHA INGRESADA ES MENOR QUE LA DEL EVENTO",'danger');
                $params['mensaje'] = $mensaje->getAlert();
            }else if($date_param > $date_hasta){
                $mensaje = new Mensaje("LA FECHA INGRESADA ES MAYOR QUE LA DEL EVENTO","danger");
                $params['mensaje'] = $mensaje->getAlert();
            }else{
                $calendarios = $this->calendarioDao->traerPorIdEvento($id_evento);
                $calendario = $this->buscarPorFecha($calendarios,$fecha);
                $saveShow=TRUE;
                if($calendario) {
                    $id_calendario = $calendario->getId();
                    $shows = $this->showDao->traerPorIdCalendario($id_calendario);
                    $info = $this->verificarDisponibilidad($hora_desde,$hora_hasta,$shows);
                    if(!empty($info)) {
                        $mensaje = new Mensaje("YA HAY UN SHOW QUE OCUPA ESOS HORARIOS 
                          <strong>{$info['show']->getHoraInicio()}</strong> - 
                          <strong>{$info['show']->getHoraFin()} </strong> CORRESPONDIENTE A: 
                          <strong>{$info['show']->getArtista()->getNombre()}</strong>","danger");
                        $params['mensaje'] = $mensaje->getAlert();
                        $saveShow=FALSE;
                    }
                }else $calendario = $this->saveCalendario($fecha,$evento);

                if($saveShow) {
                    $this->saveShow($id_artista, $hora_desde, $hora_hasta, $calendario);
                    $mensaje = new Mensaje("El show se agrego con exito!", "success");
                    $params['mensaje'] = $mensaje->getAlert();
                }
            }

            $this->page("crearEvento","Evento - Crear",2,$params);
        }else header('location: /');
    }
}