<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 21/9/2018
 * Time: 12:39
 */

namespace Controladora;
use Dao\SedeBdDao;
use Dao\TipoPlazaBdDao;
use Modelo\Mensaje;
use Modelo\Sede;
use Modelo\TipoPlaza;

class SedeControladora extends PaginaControladora
{
    private $sedeDao;
    private $tipoPlazaDao;
    function __construct()
    {
        $this->sedeDao = SedeBdDao::getInstance();
        $this->tipoPlazaDao = TipoPlazaBdDao::getInstance();
    }

    function eliminar($id){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin'){
            $sede = $this->sedeDao->retrieve($id);
            if($sede->getId() !== null){
                $this->sedeDao->delete($sede);
                $mensaje = new Mensaje('La Sede fue eliminada' , 'success');
            }else{
                $mensaje = new Mensaje('No se encontro la sede en la Base de Datos', 'danger');
            }
            $params = array('mensaje' => $mensaje->getAlert());
            $this->paginaListado($params);
        }else header('location: /');
    }
    private function paginaListado($array = []){
        $sedes = $this->sedeDao->getAll();
        if ($sedes)
            $array['sedes'] = $sedes;
        $this->page('listadoSede' , 'Sede - Listado', 2, $array);
    }

    function listado(){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin'){
            $this->paginaListado();
        }else header('location: /');
    }

    function save($nombre){
        if(!empty($_SESSION) && $_SESSION['rol']=='admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $nombre = trim($nombre);
            if(!empty($nombre)) {
                if (!$this->sedeDao->sedeExists($nombre)) {
                    $sede = new Sede($nombre);
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
                $tipoPlazas = $this->tipoPlazaDao->traerPorIdSede($sede->getId());
                $params['sede'] = $sede;
                $params['tipo_plazas'] = $tipoPlazas;
            }else {
                $mensaje = new Mensaje('No se encontro la sede', 'danger');
                $params['mensaje'] = $mensaje->getAlert();
            }
            $this->page('listadoTipoPlaza',  $sede->getNombre(),2,$params);
        }
    }
    function saveTipoPlaza($descripcion , $nombreSede){
        if(!empty($_SESSION) && $_SESSION['rol']=='admin' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $id_sede = $this->sedeDao->traerIdPorNombre($nombreSede);
            if($id_sede){
                $descripcion = trim($descripcion);
                if(!$this->tipoPlazaDao->descripcionExists($descripcion)){
                    $tipoPlaza = new TipoPlaza($descripcion);
                    $tipoPlaza->setIdSede($id_sede);
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
}