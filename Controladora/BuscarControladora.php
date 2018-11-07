<?php

namespace Controladora;

use Dao\ArtistaBdDao;
use Dao\EventoBdDao;
use Dao\CategoriaBdDao;
use Dao\CalendarioBdDao;

class BuscarControladora extends PaginaControladora{
    private $eventoDao;
    private $categoriaDao;
    private $calendarioDao;
    private $artistaDao;

    function __construct(){
        $this->artistaDao = ArtistaBdDao::getInstance();
        $this->eventoDao = EventoBdDao::getInstance();
        $this->categoriaDao = CategoriaBdDao::getInstance();
        $this->calendarioDao = CalendarioBdDao::getInstance();
    }

    private function buscarArtista($nombre){
        $params = [];
        $eventoDao = $this->eventoDao;
        $artistaDao = $this->artistaDao;

        $artista = $artistaDao->traerPorNombre($nombre);

        if($artista){
            $id_artista = $artista->getId();
            $eventos = $eventoDao->traerPorIdArtista($id_artista);

            if($eventos) {
                $params['eventos'] = $eventos;
            }
        }

        $this->page("buscar","GoToEvent",0,$params);
    }
    private function buscarCategoria($desc){
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
      $params = $this->buscarCategoria($cat);
      $this->page("buscar","GoToEvent",0,$params);
    }

    function filtrar($palabraClave){
        $str = strtolower($palabraClave);
        $this->buscarArtista($str);
    }
}
