<?php 

namespace Controladora;

use Dao\EventoBdDao;
use Dao\CategoriaBdDao;
use Dao\CalendarioBdDao;

class BuscarControladora extends PaginaControladora{
    private $eventoDao;
    private $categoriaDao;
    private $calendarioDao;

    function __construct(){
        $this->eventoDao = EventoBdDao::getInstance();
        $this->categoriaDao = CategoriaBdDao::getInstance();
        $this->calendarioDao = CalendarioBdDao::getInstance();
    }

    private function buscar($desc){
        $params = [];
        $eventoDao = $this->eventoDao;
        $categoriaDao = $this->categoriaDao;

        $categoria = $categoriaDao->traerPorDescripcion($desc);
        $id_categoria = $categoria->getId();

        $eventos = $eventoDao->traerPorIdCategoria($id_categoria);
        $params['eventos'] = $eventos;
        return $params;
    }

    function teatros(){
        $params = $this->buscar("Obra de Teatro");
        $this->page("buscar","GoToEvent",0,$params);
    }

    function festivales(){
        $params = $this->buscar("Festival");
        $this->page("buscar","GoToEvento",0,$params);
    }

    function conciertos(){
        $params = $this->buscar("Concierto");
        $this->page("buscar","GoToEvent", 0 , $params);
    }
}