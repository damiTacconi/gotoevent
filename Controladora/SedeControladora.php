<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 21/9/2018
 * Time: 12:39
 */

namespace Controladora;
# LISTAS
/*
use Dao\EventoListaDao as EventoDao;
use Dao\SedeListaDao as SedeDao;
use Dao\TipoPlazaListaDao as TipoPlazaDao;
use Dao\CalendarioListaDao as CalendarioDao;
*/
# BASE DE DATOS
use Dao\EventoBdDao as EventoDao;
use Dao\SedeBdDao as SedeDao;
use Dao\TipoPlazaBdDao as TipoPlazaDao;
use Dao\CalendarioBdDao as CalendarioDao;

use Modelo\Mensaje;
use Modelo\Sede;
use Modelo\TipoPlaza;
use Modelo\Calendario;

class SedeControladora extends PaginaControladora
{
    private $sedeDao;
    private $tipoPlazaDao;
    private $eventoDao;
    private $calendarioDao;

    function __construct()
    {
        $this->calendarioDao = CalendarioDao::getInstance();
        $this->eventoDao = EventoDao::getInstance();
        $this->sedeDao = SedeDao::getInstance();
        $this->tipoPlazaDao = TipoPlazaDao::getInstance();
    }

    function eliminar($id){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin'){
            $sede = $this->sedeDao->retrieve($id);
            try {
                if ($sede->getId() !== null) {
                    $this->sedeDao->delete($sede);
                    $mensaje = new Mensaje('La Sede fue eliminada', 'success');
                } else {
                    $mensaje = new Mensaje('No se encontro la sede en la Base de Datos', 'danger');
                }
            }catch (\PDOException $e){
                $mensaje = new Mensaje("No se pudo eliminar, tal vez haya una plaza de evento cargada con esta sede", "danger");
            }
            $params = array('mensaje' => $mensaje->getAlert());
            $this->paginaListado($params);
        }else header('location: /');
    }
    private function paginaListado($array = []){
        $sedes = $this->sedeDao->getAll();
        if ($sedes)
            $array['sedes'] = $sedes;
        $this->page('listado/listadoSede' , 'Sede - Listado', 2, $array);
    }

    function listado(){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin'){
            $this->paginaListado();
        }else header('location: /');
    }

    function save($nombre , $capacidad){
        if(!empty($_SESSION) && $_SESSION['rol']=='admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $nombre = trim($nombre);
            if(!empty($nombre)) {
                if (!$this->sedeDao->sedeExists($nombre)) {
                    $sede = new Sede($nombre , $capacidad);
                    $this->sedeDao->save($sede);
                    $mensaje = new Mensaje("La Sede se agrego con exito!", 'success');
                } else {
                    $mensaje = new Mensaje('Ya existe una Sede con ese nombre', 'danger');
                }
            }else{
                $mensaje = new Mensaje('Se debe ingresar un nombre valido' , 'danger');
            }
            $sedes = $this->sedeDao->getAll();
            $this->page('crearSede', 'Sede - Crear', 2, array(
                'mensaje' => $mensaje->getAlert(),
                'sedes' => $sedes
            ));
        }else header('location: /');
    }

    function crear(){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin' ){
            $sedes = $this->sedeDao->getAll();
            $this->page('crearSede','Sede - Crear',2,array(
                'sedes' => $sedes
            ));
        }
    }
    function plazas($id){
        if(!empty($_SESSION) && $_SESSION['rol']=='admin') {
            $sede = $this->sedeDao->traerPorId($id);
            $params = [];
            if($sede){
                $tipoPlazas = $this->tipoPlazaDao->traerPorIdSede($id);
                $params['sede'] = $sede;
                $params['tipo_plazas'] = $tipoPlazas;
                $this->page('listado/listadoTipoPlaza',  $sede->getNombre(),2,$params);
            }else {
                $mensaje = new Mensaje('No se encontro la sede', 'danger');
                $params['mensaje'] = $mensaje->getAlert();
                $this->paginaListado($params);
            }
        }
    }
    function verificarDescripcionExistente($desc , $plazas){
        $flag = false;
        if(is_array($plazas)) {
            foreach ($plazas as $plaza) {
                if ($plaza->getDescripcion() === $desc) {
                    $flag = true;
                    break;
                }
            }
        }
        return  $flag;
    }
    function getPlazasAjax($id_sede){
        if(!empty($_SESSION) && $_SESSION['rol']=='admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $plazas = $this->tipoPlazaDao->traerPorIdSede($id_sede);
            $params =[];
            if($plazas){
                $params = array_map(function($plaza){
                    return $plaza->jsonSerialize();
                },$plazas);
            }
            echo json_encode($params);
        }else header('location: /');
    }
    function saveTipoPlaza($descripcion , $id_sede){
        if(!empty($_SESSION) && $_SESSION['rol']=='admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $sede = $this->sedeDao->retrieve($id_sede);
            if($sede){
                $plazas = $this->tipoPlazaDao->traerPorIdSede($id_sede);
                if(!$this->verificarDescripcionExistente($descripcion,$plazas)){
                    $tipoPlaza = new TipoPlaza($descripcion ,$sede);
                    $this->tipoPlazaDao->save($tipoPlaza);
                    $mensaje = new Mensaje('El tipo de plaza se agrego con exito!','success');
                }else $mensaje = new Mensaje('Ya existe ese tipo de plaza en la sede','danger');
            }else $mensaje = new Mensaje('No se encontro la Sede' , 'danger');
            $sedes = $this->sedeDao->getAll();
            $this->page('crearSede','Sede - Crear',2,array(
               'mensaje' => $mensaje->getAlert(),
                'sedes' => $sedes
            ));
        }else header('location: /');
    }


    function getSedeIdCalendarioAjax($id_calendario){
        if(!empty($_SESSION) && $_SESSION['rol']=='admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $calendario = $this->calendarioDao->retrieve($id_calendario);
            $params = [];
            $sede = $calendario->getSede();
            if($sede){
                $sede = $sede->jsonSerialize();
                $params['sede'] = $sede;
            }
            echo json_encode($params);
        }else header('location: /');
    }
}