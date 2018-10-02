<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 21/9/2018
 * Time: 08:48
 */

namespace Controladora;

use Modelo\Artista;
use Modelo\Mensaje;
use Dao\ArtistaBdDao;

class ArtistaControladora extends PaginaControladora
{
    private $artistaDao;

    function __construct()
    {
        $this->artistaDao = ArtistaBdDao::getInstance();
    }

    function eliminar($id){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin'){
            $artista = $this->artistaDao->retrieve($id);
            if($artista->getId() !== null){
                $this->artistaDao->delete($artista);
                $mensaje = new Mensaje('El artista fue eliminado' , 'success');
            }else{
                $mensaje = new Mensaje('No se encontro al artista en la Base de Datos', 'danger');
            }
            $params = array('mensaje' => $mensaje->getAlert());
            $this->paginaListado($params);
        }else header('location: /');
    }
    private function paginaListado($array = []){
        $artistas = $this->artistaDao->getAll();
        if ($artistas)
            $array['artistas'] = $artistas;
        $this->page('listado/listadoArtistas' , 'Artistas - Listado', 2, $array);
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
                if (!$this->artistaDao->artistExists($nombre)) {
                    $artista = new Artista($nombre);
                    $this->artistaDao->save($artista);
                    $mensaje = new Mensaje("El artista se agrego con exito!", 'success');
                } else {
                    $mensaje = new Mensaje('Ya existe un artista con ese nombre', 'danger');
                }
            }else{
                $mensaje = new Mensaje('Se debe ingresar un nombre valido' , 'danger');
            }
            $this->page('crearArtista', 'Artista - Crear', 2, array(
                'mensaje' => $mensaje->getAlert()
            ));
        }else header('location: /');
    }
    function update($nombre, $id_artista){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
          $artista = $this->artistaDao->retrieve($id_artista);
          if($artista){
            $artista->setNombre($nombre);
            $this->artistaDao->update($artista);
            $mensaje = new Mensaje("EL ARTISTA SE ACTUALIZO CON EXITO!","success");
          }else $mensaje = new Mensaje("NO SE ENCONTRO EL ARTISTA", "danger");
          $params['mensaje'] = $mensaje->getAlert();
          $this->paginaListado($params);
        }
    }

    function crear(){
        $this->page('crearArtista','Artista - Crear',2);
    }
}
