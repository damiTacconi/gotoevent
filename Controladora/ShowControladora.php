<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 23/9/2018
 * Time: 11:35
 */

namespace Controladora;


use Dao\ArtistaBdDao;
use Dao\CalendarioBdDao;
use Dao\EventoBdDao;
use Dao\ShowBdDao;
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
        $this->calendarioDao = CalendarioBdDao::getInstance();
        $this->showDao    = ShowBdDao::getInstance();
        $this->artistaDao = ArtistaBdDao::getInstance();
        $this->eventoDao  = EventoBdDao::getInstance();
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

    function crear($params = []){
        $artistas = $this->artistaDao->getAll();
        $eventos = $this->eventoDao->getAll();
        $params['artistas'] = $artistas;
        $params['eventos'] = $eventos;
        $this->page("crearShow" , "Show - Crear" , 2, $params );
    }
}