<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 17/9/2018
 * Time: 13:23
 */

namespace Controladora;

# LISTAS
/*
use Dao\ArtistaListaDao as ArtistaDao;
use Dao\CategoriaListaDao as CategoriaDao;
use Dao\EventoListaDao as EventoDao;
use Dao\EventoImagenListaDao as EventoImagenDao;
use Dao\SedeListaDao as SedeDao;
use Dao\CalendarioListaDao as CalendarioDao;
use Dao\PlazaEventoListaDao as PlazaEventoDao;
use Dao\ShowListaDao as ShowDao;
use Dao\TipoPlazaListaDao as TipoPlazaDao;
use Dao\PromoListaDao as PromoDao;
*/
# BASE DE DATOS

use Dao\ArtistaBdDao as ArtistaDao;
use Dao\CalendarioBdDao as CalendarioDao;
use Dao\CategoriaBdDao as CategoriaDao;
use Dao\EventoBdDao as EventoDao;
use Dao\EventoImagenBdDao as EventoImagenDao;
use Dao\PlazaEventoBdDao as PlazaEventoDao;
use Dao\SedeBdDao as SedeDao;
use Dao\ShowBdDao as ShowDao;
use Dao\TipoPlazaBdDao as TipoPlazaDao;
use Dao\PromoBdDao as PromoDao;
use Dao\LineaBdDao as LineaDao;

# MODELOS
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
    private $promoDao;
    private $lineaDao;

    function __construct()
    {
        $this->lineaDao = LineaDao::getInstance();
        $this->promoDao = PromoDao::getInstance();
        $this->eventoImagenDao = EventoImagenDao::getInstance();
        $this->showDao = ShowDao::getInstance();
        $this->plazaEventoDao = PlazaEventoDao::getInstance();
        $this->sedeDao = SedeDao::getInstance();
        $this->eventoDao = EventoDao::getInstance();
        $this->categoriaDao = CategoriaDao::getInstance();
        $this->artistaDao = ArtistaDao::getInstance();
        $this->calendarioDao = CalendarioDao::getInstance();
        $this->tipoPlazaDao = TipoPlazaDao::getInstance();
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
        $sede = $calendario->getSede();
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
            $param['categorias'] = $categorias;
            $param['eventos'] = $eventos;
            $param['artistas'] = $artistas;
            $param['promos'] = [];

            foreach($eventos as $evento){
                $categoria = $evento->getCategoria();
                if($categoria->getDescripcion() === 'Festival'){
                    array_push($param['promos'], $evento);
                }
            }
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
            if(is_numeric($id)){
                if(!isset($_SESSION['ListaEventos'])){
                    $evento = $this->eventoDao->retrieve($id);
                    if($evento){
                        if(!$this->lineaDao->contarLineas($id)){
                            $this->eventoDao->delete($evento);
                            $mensaje = new Mensaje('El evento fue eliminado' , 'success');
                        }else{
                        $mensaje = new Mensaje('El evento no pudo ser eliminado, tal vez haya compras asociadas' , 'danger');
                    }
                    }else{
                        $mensaje = new Mensaje('No se encontro el evento en la Base de Datos', 'danger');
                    }
                }else 
                    $mensaje = new Mensaje("NO SE PUEDE ELIMINAR USANDO LISTAS POR FALTA DE DESARROLLO EN EL SISTEMA");
                $params = array('mensaje' => $mensaje->getAlert());

                $this->paginaListado($params);
            }else header("location: /");
        }else header('location: /');
    }

    function save($titulo, $id_categoria, $fecha_desde , $fecha_hasta, $descripcion){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $titulo = trim($titulo);
            if(!empty($titulo)) {
                if (!$this->eventoDao->titleExists($titulo)){
                    $categoria = $this->categoriaDao->retrieve($id_categoria);
                    $evento = new Evento($titulo,$fecha_desde,$fecha_hasta,$categoria,$descripcion);
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
                        //$eventoImagen = $this->eventoImagenDao->retrieve(11);
                        $imagen = ROOT . 'public_html' . URL_IMG . 'tickets.png';
                        $nombre = "tickets.png";
                        $imagen = file_get_contents($imagen);
                        $imagen = base64_encode($imagen);
                        $eventoImagen = new EventoImagen($nombre,$imagen);
                        $id_imagen = $this->eventoImagenDao->save($eventoImagen);
                        $eventoImagen->setId($id_imagen);
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
        if(is_numeric($id_evento)){
            $evento = $this->eventoDao->retrieve($id_evento);

            if($evento){
              $calendarios= $this->calendarioDao->traerPorIdEvento($id_evento);
              $sedes = $this->sedeDao->getAll();
              $params['sedes'] = $sedes;
              $params['calendarios'] = $calendarios;
              $params['evento'] = $evento;
              $this->page("listado/listadoCalendariosDeEventos" , "Calendarios de {$evento->getTitulo()}",2,$params);
            }else{
                $mensaje = new Mensaje("No se encontraron resultados" , "danger");
                $params['mensaje'] = $mensaje->getAlert();
                $this->paginaListado($params);
            }
        }else{
            header('location: /');
        }

    }

    function sede($id_evento,$id_sede)
    {
        $evento = $this->eventoDao->retrieve($id_evento);
        if($evento) {
            $params['evento'] = $evento;
            $params['evento_sede'] = $this->sedeDao->retrieve($id_sede);
            $calendarios = $this->calendarioDao->traerPorIdEvento($id_evento);
            $promo = $this->promoDao->traerPorIdEvento($id_evento);

            if($calendarios) {
                foreach ($calendarios as $calendario) {
                    $id_calendario = $calendario->getId();
                    $plazas = $this->plazaEventoDao->traerPorIdCalendario($id_calendario);
                    if ($plazas)
                        $calendario->setPlazaEventos($plazas);
                }
            }
            if($promo){
                $params['promo'] = $promo;
            }
            $params['calendarios'] = $calendarios;
            $params['evento'] = $evento;
            $params['calendarios_fechas'] = $this->calendarioDao->traerFechasDeEventoEnUnaSede($id_evento,$id_sede);
            $this->page("calendariosEvento", $evento->getTitulo(), 0, $params);
        }else header('location: /');
    }
    function detalle($id_evento){
        if(is_numeric($id_evento)){
            $evento = $this->eventoDao->retrieve($id_evento);
            if($evento) {
                $params['evento'] = $evento;
                $params['evento_sedes'] = $this->sedeDao->traerPorIdEvento($id_evento);
                /*
                $calendarios = $this->calendarioDao->traerPorIdEvento($id_evento);
                if($calendarios) {
                    foreach ($calendarios as $calendario) {
                        $id_calendario = $calendario->getId();
                        $plazas = $this->plazaEventoDao->traerPorIdCalendario($id_calendario);
                        if ($plazas)
                            $calendario->setPlazaEventos($plazas);
                    }
                }
                $params['calendarios'] = $calendarios;*/
                $this->page("detalleEvento", $evento->getTitulo(), 0, $params);
            }else header('location: /');
        }else header('location: /');
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
