<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 17/9/2018
 * Time: 13:23
 */

namespace Controladora;

use Dao\ArtistaBdDao;
use Dao\CalendarioBdDao;
use Dao\CategoriaBdDao;
use Dao\EventoBdDao;
use Dao\ShowBdDao;
use Modelo\Calendario;
use Modelo\Evento;
use Modelo\Mensaje;
use Modelo\Show;

class EventoControladora extends PaginaControladora
{
    private $eventoDao;
    private $categoriaDao;
    private $artistaDao;
    private $showDao;
    private $calendarioDao;
    function __construct()
    {
        $this->eventoDao = EventoBdDao::getInstance();
        $this->categoriaDao = CategoriaBdDao::getInstance();
        $this->artistaDao = ArtistaBdDao::getInstance();
        $this->showDao = ShowBdDao::getInstance();
        $this->calendarioDao = CalendarioBdDao::getInstance();
    }

    function index(){
        header('location: /');
    }

    function getFechasAjax($id){
        if(!empty($_SESSION) && $_SESSION['rol']==='admin' && $_SERVER['REQUEST_METHOD'] === "POST"){
            $evento = $this->eventoDao->getFechas($id);
            echo json_encode(array(
               'fecha_desde' => $evento['fecha_desde'],
               'fecha_hasta' => $evento['fecha_hasta']
            ));
        }else header('location: /');
    }
    function crear(){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin') {
            $categorias = $this->categoriaDao->getAll();
            $eventos = $this->eventoDao->getAll();
            $artistas = $this->artistaDao->getAll();
            $param['categorias'] = $categorias;
            $param['eventos'] = $eventos;
            $param['artistas'] = $artistas;

            $this->page('crearEvento', 'Crear Evento', 2,$param);
        }
    }

    function saveShow($id_evento, $fecha, $hora_desde, $hora_hasta, $id_artista){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $evento = $this->eventoDao->retrieve($id_evento);
            $evento_desde = $evento->getFechaDesde();
            $evento_hasta = $evento->getFechaHasta();
            $date_desde = strtotime($evento_desde);
            $date_hasta = strtotime($evento_hasta);
            $date_param = strtotime($fecha);
            $params = [];
            if($date_param <  $date_desde){
                $mensaje = new Mensaje("LA FECHA INGRESADA ES MENOR QUE LA DEL EVENTO",'danger');
            }else if($date_param > $date_hasta){
                $mensaje = new Mensaje("LA FECHA INGRESADA ES MAYOR QUE LA DEL EVENTO","danger");
            }else{
                $calendarios = $this->calendarioDao->traerPorIdEvento($id_evento);
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
                    if($calendario){
                        $id_calendario = $calendario->getId();
                        $shows = $this->showDao->traerPorIdCalendario($id_calendario);
                        if($shows) {
                            foreach ($shows as $show) {
                                $show_hora_inicio = $show->getHoraInicio();
                                $show_hora_fin = $show->getHoraFin();
                                $time_inicio = strtotime($show_hora_inicio);
                                $time_fin = strtotime($show_hora_fin);
                                $time_param_desde = strtotime($hora_desde);
                                $time_param_hasta = strtotime($hora_hasta);
                                if (
                                    ($time_param_desde > $time_inicio) && ($time_param_desde < $time_fin)
                                    ||
                                    ($time_param_hasta > $time_inicio) && ($time_param_hasta < $time_fin)
                                    ||
                                    ($time_param_desde < $time_inicio) && ($time_param_hasta > $time_fin)
                                ){
                                    $mensaje = new Mensaje("YA HAY UN SHOW QUE OCUPA ESOS HORARIOS 
                                    <strong>{$show_hora_inicio}</strong> - 
                                    <strong>{$show_hora_fin} </strong> CORRESPONDIENTE A: 
                                    <strong>{$show->getArtista()->getNombre()}</strong>","danger");
                                }else{
                                    $mensaje = new Mensaje("El show se agrego con exito!","success");
                                }
                            }
                        }else{
                            $artista = $this->artistaDao->retrieve($id_artista);
                            $show = new Show($hora_desde,$hora_hasta,$artista,$calendario);
                            $this->showDao->save($show);
                            $mensaje = new Mensaje("El show se agrego con exito!","success");
                        }
                    }else{
                        $calendario = new Calendario($fecha);
                        $calendario->setIdEvento($id_evento);
                        $id_calendario = $this->calendarioDao->save($calendario);
                        $calendario->setId($id_calendario);

                        $artista = $this->artistaDao->retrieve($id_artista);
                        $show = new Show($hora_desde,$hora_hasta,$artista,$calendario);
                        $this->showDao->save($show);
                        $mensaje = new Mensaje("El show se agrego con exito!","success");
                    }
                }else{
                    $calendario = new Calendario($fecha);
                    $calendario->setIdEvento($id_evento);
                    $id_calendario = $this->calendarioDao->save($calendario);
                    $calendario->setId($id_calendario);

                    $artista = $this->artistaDao->retrieve($id_artista);
                    $show = new Show($hora_desde,$hora_hasta,$artista,$calendario);
                    $this->showDao->save($show);
                    $mensaje = new Mensaje("El show se agrego con exito!","success");
                }
            }
            $params['mensaje'] = $mensaje->getAlert();
            $this->page("crearEvento","Evento - Crear",2,$params);
        }else header('location: /');
    }

    function save($titulo, $id_categoria, $fecha_desde , $fecha_hasta){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $titulo = trim($titulo);
            $params = [];
            if(!empty($titulo)) {
                if (!$this->eventoDao->titleExists($titulo)) {
                    $categoria = $this->categoriaDao->retrieve($id_categoria);
                    $evento = new Evento($titulo,$fecha_desde,$fecha_hasta,$categoria);
                    $this->eventoDao->save($evento);
                    $eventos = $this->eventoDao->getAll();
                    $categorias = $this->categoriaDao->getAll();
                    $params['categorias'] = $categorias;
                    $params['eventos'] = $eventos;
                    $mensaje = new Mensaje("EL evento se agrego con exito!", 'success');
                }else $mensaje = new Mensaje('Ya existe un evento con ese titulo', 'danger');
            }else $mensaje = new Mensaje('Se debe ingresar una descripcion valida' , 'danger');
            $params['mensaje'] = $mensaje->getAlert();
            $this->page('crearEvento', 'Evento - Crear', 2, $params);
        }
    }
}