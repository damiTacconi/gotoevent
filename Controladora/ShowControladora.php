<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 23/9/2018
 * Time: 11:35
 */

namespace Controladora;

# LISTA
/*
use Dao\ArtistaListaDao as ArtistaDao;
use Dao\CalendarioListaDao as CalendarioDao;
use Dao\EventoListaDao as EventoDao;
use Dao\ShowListaDao as ShowDao;
*/
# BASE DE DATOS
use Dao\ArtistaBdDao as ArtistaDao;
use Dao\CalendarioBdDao as CalendarioDao;
use Dao\EventoBdDao as EventoDao;
use Dao\ShowBdDao as ShowDao;

use Modelo\Mensaje;
use Modelo\Show;

class ShowControladora extends PaginaControladora
{
    private $showDao;
    private $artistaDao;
    private $eventoDao;
    private $calendarioDao;

    function __construct()
    {
        $this->calendarioDao = CalendarioDao::getInstance();
        $this->showDao    = ShowDao::getInstance();
        $this->artistaDao = ArtistaDao::getInstance();
        $this->eventoDao  = EventoDao::getInstance();
    }

    function delete($id_show){
        if($_SESSION['rol'] === 'admin'){
            $show = $this->showDao->retrieve($id_show);
            if($show){
                $this->showDao->delete($show);
                $mensaje = new Mensaje("EL SHOW SE ELIMINO CON EXITO!", "success");
            }else $mensaje = new Mensaje("NO SE ENCONTRO EL SHOW" , "danger");
            $params['mensaje'] = $mensaje->getAlert();
            $this->crear($params);
        }
    }
    function save($id_calendario, $id_artista){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $calendario = $this->calendarioDao->retrieve($id_calendario);
            if($calendario) {
                $artista = $this->artistaDao->retrieve($id_artista);
                if($artista) {
                    if(!$this->showDao->existsShow($artista->getId(), $calendario->getId())) {
                        $show = new Show($artista, $calendario);
                        $this->showDao->save($show);
                        $mensaje = new Mensaje("EL SHOW SE AGREGO CON EXITO! ", "success");
                    }else $mensaje = new Mensaje("ESTE SHOW YA FUE CARGADO EN EL CALENDARIO ELEGIDO","danger");
                }else $mensaje = new Mensaje("NO SE ENCONTRO AL ARTISTA" , "danger");
            }else $mensaje = new Mensaje("NO SE ENCONTRO EL CALENDARIO", "danger");
            $params['mensaje'] = $mensaje->getAlert();
            $this->crear($params);
        }else header('location: /');
    }

    function showsEvento($id_calendario){
        if(is_numeric($id_calendario)){
            $calendario = $this->calendarioDao->retrieve($id_calendario);
            $params = [];
            if($calendario){
                $evento = $calendario->getEvento();
                $params['evento'] = $evento;
                $calendarios = $this->calendarioDao->traerPorIdEvento($evento->getId());
                $params['calendarios'] = $calendarios;
                $shows = $this->showDao->traerPorIdCalendario($id_calendario);
                $params['shows'] = $shows;
            }else {
                $mensaje = new Mensaje("NO SE ENCONTRO EL CALENDARIO" , "danger");
                $params['mensaje'] = $mensaje->getAlert();
            }
            $params['artistas'] = $this->artistaDao->getAll();
            $this->page("listado/listadoShowsDeEventos","Shows - Listado",2,$params);
        }else header("location: /");
    }
    function crear($params = []){
        $artistas = $this->artistaDao->getAll();
        $eventos = $this->eventoDao->getAll();
        $params['artistas'] = $artistas;
        $params['eventos'] = $eventos;
        $this->page("crearShow" , "Show - Crear" , 2, $params );
    }

    function update($id_calendario, $id_artista, $id_show){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $calendario = $this->calendarioDao->retrieve($id_calendario);
            $artista = $this->artistaDao->retrieve($id_artista);
            $show = $this->showDao->retrieve($id_show);
            $show->setArtista($artista);
            $show->setCalendario($calendario);
            $this->showDao->update($show);

            $mensaje = new Mensaje("EL SHOW SE ACTUALIZO CORRECTAMENTE!","success");

            $evento = $calendario->getEvento();
            $shows = $this->showDao->traerPorIdCalendario($id_calendario);
            $calendarios = $this->calendarioDao->traerPorIdEvento($evento->getId());

            $params['mensaje'] = $mensaje->getAlert();
            $params['artistas'] = $this->artistaDao->getAll();
            $params['calendarios'] = $calendarios;
            $params['shows'] = $shows;
            $params['evento'] = $evento;
            $this->page("listado/listadoShowsDeEventos","Shows - Listado",2,$params);
        }else header("location: /");
    }
}