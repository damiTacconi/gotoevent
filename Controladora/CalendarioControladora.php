<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 26/9/2018
 * Time: 15:32
 */

namespace Controladora;


use Dao\CalendarioBdDao;
use Dao\EventoBdDao;
use Dao\SedeBdDao;
use Modelo\Mensaje;
use Modelo\Calendario;
use Modelo\Sede;

class CalendarioControladora extends PaginaControladora
{
    private $calendarioDao;
    private $eventoDao;
    private $sedeDao;

    function __construct()
    {
        $this->sedeDao = SedeBdDao::getInstance();
        $this->eventoDao = EventoBdDao::getInstance();
        $this->calendarioDao = CalendarioBdDao::getInstance();
    }

    function eliminarAjax($id){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $calendario = $this->calendarioDao->retrieve($id);
            if ($calendario) {
                $this->calendarioDao->delete($calendario);
                $mensaje = new Mensaje('El calendario fue eliminado', 'success');
            } else {
                $mensaje = new Mensaje('No se encontro el calendario en la Base de Datos', 'danger');
            }
            $params = array('mensaje' => $mensaje->getAlert());
            echo json_encode($params);
        }else header('location: /');
    }
    function eliminar($id){

            $calendario = $this->calendarioDao->retrieve($id);
            if($calendario){
                $this->calendarioDao->delete($calendario);
                $mensaje = new Mensaje('El calendario fue eliminado' , 'success');
            }else{
                $mensaje = new Mensaje('No se encontro el calendario en la Base de Datos', 'danger');
            }
            $params = array('mensaje' => $mensaje->getAlert());
            $this->crear($params);
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

    function save($id_evento, $id_sede , $fecha){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $evento = $this->eventoDao->retrieve($id_evento);
            $evento_desde = $evento->getFechaDesde();
            $evento_hasta = $evento->getFechaHasta();
            $date_desde = strtotime($evento_desde);
            $date_hasta = strtotime($evento_hasta);
            $date_param = strtotime($fecha);
            if ($date_param < $date_desde) {
                $mensaje = new Mensaje("LA FECHA INGRESADA ES MENOR QUE LA DEL EVENTO", 'danger');
                $params['mensaje'] = $mensaje->getAlert();
            } else if ($date_param > $date_hasta) {
                $mensaje = new Mensaje("LA FECHA INGRESADA ES MAYOR QUE LA DEL EVENTO", "danger");
                $params['mensaje'] = $mensaje->getAlert();
            } else {
                $calendarios = $this->calendarioDao->traerPorIdEvento($id_evento);
                $calendario = $this->buscarPorFecha($calendarios,$fecha);
                if($calendario){
                    $mensaje = new Mensaje("ESTE CALENDARIO YA EXISTE EN EL EVENTO" , "danger");
                }else{
                    $sede = $this->sedeDao->retrieve($id_sede);
                    if($sede){
                        $calendario = new Calendario($fecha, $evento, $sede);
                        $this->calendarioDao->save($calendario);
                        $mensaje = new Mensaje("EL CALENDARIO SE AGREGO CON EXITO ! " , "success");
                    }else $mensaje = new Mensaje("NO SE ENCONTRO LA SEDE", "danger");
                }
            }
            $params['mensaje'] = $mensaje->getAlert();
            $this->crear($params);
        }else header("location: /");
    }
    

    private function generarCalendarios($evento){
        $fecha_desde = $evento->getFechaDesde();
        $fecha_hasta = $evento->getFechaHasta();
        $date_hasta = strtotime($fecha_hasta);
        $fecha = $fecha_desde;
        $flag = FALSE;
        do{
            $existe = $this->calendarioDao->fechaExists($evento->getId(),$fecha);
            if(!$existe){
                $calendario = new Calendario($fecha, $evento);
                $this->calendarioDao->save($calendario);
                $flag = TRUE;
            }
            $fecha = date('Y-m-d', strtotime($fecha . " +1 days"));
            $fecha_date = strtotime($fecha);
        }while($fecha_date <= $date_hasta);

        return $flag;
    }
    function crear($params = []){
        $eventos = $this->eventoDao->getAll();
        $sedes = $this->sedeDao->getAll();
        $params['sedes'] = $sedes;
        $params['eventos'] = $eventos;
        $this->page('crearCalendario' , 'Calendario - Crear' , 2, $params);
    }

    function update($id_calendario_elegido, $id_sede, $id_calendario_actual){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $sede = $this->sedeDao->retrieve($id_sede);
            $calendario_actual = $this->calendarioDao->retrieve($id_calendario_actual);
            $calendario_elegido = $this->calendarioDao->retrieve($id_calendario_elegido);
            $fecha_calendario_actual = $calendario_actual->getFecha();
            $fecha_calendario_elegido = $calendario_elegido->getFecha();
            $calendario_actual->setFecha($fecha_calendario_elegido);
            var_dump($sede);
            $calendario_actual->setSede($sede);
            $calendario_elegido->setFecha($fecha_calendario_actual);
            $this->calendarioDao->update($calendario_actual);
            $this->calendarioDao->update($calendario_elegido);
            $evento = $calendario_actual->getEvento();
            $id_evento = $evento->getId();
            $mensaje = new Mensaje("ACTUALIZACION EJECUTADA CORRECTAMENTE!" , "success");
            $params['mensaje'] = $mensaje->getAlert();
            $params['evento'] = $evento;
            $params['sedes'] = $this->sedeDao->getAll();
            $params['calendarios'] = $this->calendarioDao->traerPorIdEvento($id_evento);
            $this->page("listado/listadoCalendariosDeEventos" , "Calendarios de {$evento->getTitulo()}",2,$params);
        }else header("location: /");
    }
}