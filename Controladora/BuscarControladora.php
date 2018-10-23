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
        if($categoria){
          $id_categoria = $categoria->getId();
          $eventos = $eventoDao->traerPorIdCategoria($id_categoria);
          $params['eventos'] = $eventos;
        }
        return $params;
    }

    function categoria($cat){
      $cat = str_replace('-',' ', $cat);
      $params = $this->buscar($cat);
      $this->page("buscar","GoToEvent",0,$params);
    }

    function filtrar($palabraClave){

    }
}
