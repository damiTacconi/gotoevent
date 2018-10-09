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
use Dao\EventoImagenBdDao;
use Dao\PlazaEventoBdDao;
use Dao\SedeBdDao;
use Dao\ShowBdDao;
use Dao\TipoPlazaBdDao;
use Modelo\Evento;
use Modelo\EventoImagen;
use Modelo\Mensaje;
use Modelo\PlazaEvento;
use Modelo\TipoPlaza;

class EventoControladora extends PaginaControladora
{
    private $eventoDao;
    private $categoriaDao;
    private $artistaDao;
    private $sedeDao;
    private $calendarioDao;
    private $tipoPlazaDao;
    private $plazaEventoDao;
    private $showDao;
    private $eventoImagenDao;


    function __construct()
    {
        $this->eventoImagenDao = EventoImagenBdDao::getInstance();
        $this->showDao = ShowBdDao::getInstance();
        $this->plazaEventoDao = PlazaEventoBdDao::getInstance();
        $this->sedeDao = SedeBdDao::getInstance();
        $this->eventoDao = EventoBdDao::getInstance();
        $this->categoriaDao = CategoriaBdDao::getInstance();
        $this->artistaDao = ArtistaBdDao::getInstance();
        $this->calendarioDao = CalendarioBdDao::getInstance();
        $this->tipoPlazaDao = TipoPlazaBdDao::getInstance();
    }

    /* FUNCIONES PRIVADAS */
    private function paginaListado($array = []){
        $eventos = $this->eventoDao->getAll();
        $categorias = $this->categoriaDao->getAll();
        if ($eventos)
            $array['eventos'] = $eventos;
        if ($categorias)
            $array['categorias'] = $categorias;
        $this->page('listado/listadoEventos' , 'Eventos - Listado', 2, $array);
    }

    private function verificarCapacidadPermitida($id_calendario , $capacidad){
        $infoCapacidad['info'] = "success";
        $infoCapacidad['exceso'] = 0;
        $calendarioDao = $this->calendarioDao;
        $plazaEventoDao = $this->plazaEventoDao;
        $calendario = $calendarioDao->retrieve($id_calendario);
        $evento = $calendario->getEvento();
        $sede = $evento->getSede();
        $capacidadTotal = $sede->getCapacidad();

        $plazaEventos = $plazaEventoDao->traerPorIdCalendario($id_calendario);
        $suma = 0;
        if($plazaEventos){
            foreach ($plazaEventos as $pe){
                $suma += $pe->getCapacidad();
            }
        }
        $suma += $capacidad;
        if($suma > $capacidadTotal) {
            $exceso = $suma - $capacidadTotal;
            $infoCapacidad['info'] = "error";
            $infoCapacidad['exceso'] = $exceso;
        }
        return $infoCapacidad;
    }

    private function existe($titulo){
        return $this->eventoDao->titleExists($titulo);
    }

    private function configurarCalendarios($fd,$fh,$id_evento)
    {
        $calendarios = $this->calendarioDao->traerPorIdEvento($id_evento);
        $fecha_desde = strtotime($fd);
        $fecha_hasta = strtotime($fh);

        if($calendarios){
            foreach ($calendarios as $calendario){
                $fecha = $calendario->getFecha();
                $fecha = strtotime($fecha);
                if( ($fecha > $fecha_hasta) || ($fecha < $fecha_desde) ){
                    $this->calendarioDao->delete($calendario);
                }
            }
        }
    }


    /* FUNCIONES PUBLICAS */
    function index(){
        if(!empty($_GET)){
            header('location: /');
        }
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin' ){
            $this->page('inicioAdmin', 'Administrar', 2);
        }else{
            $this->page();
        }
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
            $sedes = $this->sedeDao->getAll();
            $param['sedes'] = $sedes;
            $param['categorias'] = $categorias;
            $param['eventos'] = $eventos;
            $param['artistas'] = $artistas;

            $this->page('crearEvento', 'Crear Evento', 2,$param);
        }else header('location: /');
    }



    function consulta(){
        $eventoDao = $this->eventoDao;
        $eventos = $eventoDao->getAll();
        $params['eventos'] = $eventos;
        $this->page("consultaEventos" , "Evento - Consulta" , 2 , $params);
    }
    function savePlazaEvento($id_calendario,$id_tipo_plaza,$capacidad,$precio)
    {
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $params = $this->traerTodos();
            $calendario = $this->calendarioDao->retrieve($id_calendario);
            $plaza = $this->tipoPlazaDao->retrieve($id_tipo_plaza);
            $plazaEventoExistente = $this->plazaEventoDao->verificarPlazaExistente($id_calendario, $id_tipo_plaza);
            if(!$plazaEventoExistente){
                $informeCapacidad = $this->verificarCapacidadPermitida($id_calendario,$capacidad);
                if($informeCapacidad['info'] === "success") {
                    $plazaEvento = new PlazaEvento($capacidad, $capacidad, $plaza, $calendario, $precio);
                    $this->plazaEventoDao->save($plazaEvento);
                    $mensaje = new Mensaje("La plaza se agrego correctamente al evento!", "success");
                }else $mensaje = new Mensaje("Error de exceso en {$informeCapacidad['exceso']} plazas", "danger");
            }else $mensaje = new Mensaje("Ya existe este tipo de plaza en el evento", "danger");
            $params['mensaje'] = $mensaje->getAlert();
            $this->page('crearEvento','Evento - Crear',2,$params);
        }else header('location: /');
    }

    function traerTodos(){
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


    function update($titulo, $id_categoria, $fecha_desde , $fecha_hasta ,$descripcion, $id_evento, $id_imagen){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $titulo = trim($titulo);
            if(!empty($titulo)) {
                $evento = $this->eventoDao->retrieve($id_evento);
                $existeTitulo = FALSE;
                if($evento->getTitulo() !== $titulo){
                    $existeTitulo = $this->existe($titulo);
                }
                if (!$existeTitulo) {
                    $categoria = $this->categoriaDao->retrieve($id_categoria);
                    $evento->setTitulo($titulo);
                    $evento->setFechaDesde($fecha_desde);
                    $evento->setFechaHasta($fecha_hasta);
                    $this->configurarCalendarios($fecha_desde,$fecha_hasta,$id_evento);
                    $evento->setCategoria($categoria);
                    $evento->setDescripcion($descripcion);
                    if(!empty($_FILES['imagen']['tmp_name'])){
                        $imagen = addslashes($_FILES['imagen']['tmp_name']);
                        $nombre = addslashes($_FILES['imagen']['name']);
                        $imagen = file_get_contents($imagen);
                        $imagen = base64_encode($imagen);
                        $eventoImagen = new EventoImagen($nombre,$imagen);
                        $eventoImagen->setId($id_imagen);
                        $this->eventoImagenDao->update($eventoImagen);
                        $evento->setEventoImagen($eventoImagen);
                    }
                    $evento->setId($id_evento);
                    $this->eventoDao->update($evento);
                    $mensaje = new Mensaje("EL evento se actualizo con exito!", 'success');
                }else $mensaje = new Mensaje('Ya existe un evento con ese titulo', 'danger');
            }else $mensaje = new Mensaje('Se debe ingresar una descripcion valida' , 'danger');

            $params = $this->traerTodos();
            $params['mensaje'] = $mensaje->getAlert();
            $this->paginaListado($params);
        }else header('location: /');
    }
    function eliminar($id){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin'){
            $evento = $this->eventoDao->retrieve($id);
            if($evento){
                $this->eventoDao->delete($evento);
                $mensaje = new Mensaje('El evento fue eliminado' , 'success');
            }else{
                $mensaje = new Mensaje('No se encontro el evento en la Base de Datos', 'danger');
            }
            $params = array('mensaje' => $mensaje->getAlert());
            $this->paginaListado($params);
        }else header('location: /');
    }

    function save($titulo, $id_categoria, $id_sede, $fecha_desde , $fecha_hasta, $descripcion){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $titulo = trim($titulo);
            if(!empty($titulo)) {
                if (!$this->eventoDao->titleExists($titulo)){
                    $sede = $this->sedeDao->retrieve($id_sede);
                    $categoria = $this->categoriaDao->retrieve($id_categoria);
                    $evento = new Evento($titulo,$fecha_desde,$fecha_hasta,$categoria,$sede,$descripcion);
                    if(!empty($_FILES['imagen']['tmp_name'])){
                        $imagen = addslashes($_FILES['imagen']['tmp_name']);
                        $nombre = addslashes($_FILES['imagen']['name']);
                        $imagen = file_get_contents($imagen);
                        $imagen = base64_encode($imagen);
                        $eventoImagen = new EventoImagen($nombre,$imagen);
                        $id_imagen = $this->eventoImagenDao->save($eventoImagen);
                        $eventoImagen->setId($id_imagen);
                    }else{
                        //el id 11 pertenece al logo por default
                        $eventoImagen = $this->eventoImagenDao->retrieve(11);
                    }
                    $evento->setEventoImagen($eventoImagen);
                    $this->eventoDao->save($evento);
                    $mensaje = new Mensaje("EL evento se agrego con exito!", 'success');
                }else $mensaje = new Mensaje('Ya existe un evento con ese titulo', 'danger');
            }else $mensaje = new Mensaje('Se debe ingresar una descripcion valida' , 'danger');

            $params = $this->traerTodos();
            $params['mensaje'] = $mensaje->getAlert();
            $this->page('crearEvento', 'Evento - Crear', 2, $params);
        }else header('location: /');
    }
    function listado(){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin'){
            $this->paginaListado();
        }else header('location: /');
    }


    function calendarios($id_evento){
        $evento = $this->eventoDao->retrieve($id_evento);

        if($evento){
          $calendarios= $this->calendarioDao->traerPorIdEvento($id_evento);
          $params['calendarios'] = $calendarios;
          $params['evento'] = $evento;
          $this->page("listado/listadoCalendariosDeEventos" , "Calendarios de {$evento->getTitulo()}",2,$params);
        }

    }


    /* FUNCIONES AJAX */

    function getCalendariosAjax($id_evento){
        if(!empty($_SESSION) && $_SESSION['rol']==='admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $evento = $this->eventoDao->retrieve($id_evento);
            $params = [];
            if($evento){
                $calendarios = $this->calendarioDao->traerPorIdEvento($id_evento);
                if($calendarios) {
                    $evento->setCalendarios($calendarios);
                }
                $params['evento'] = $evento->jsonSerialize();

            }
            echo json_encode($params);
        }else header('location: /');
    }

}
