<?php

namespace Controladora;

use Modelo\Promo;
use Modelo\Evento;
use Modelo\Mensaje;

# LISTAS
/*
use Dao\CategoriaListaDao as CategoriaDao;
use Dao\ArtistaListaDao as ArtistaDao;
use Dao\EventoListaDao as EventoDao;
use Dao\PromoListaDao as PromoDao;
*/
# BASE DE DATOS

use Dao\CategoriaBdDao as CategoriaDao;
use Dao\ArtistaBdDao as ArtistaDao;
use Dao\EventoBdDao as EventoDao;
use Dao\PromoBdDao as PromoDao;



class PromoControladora extends PaginaControladora{

    private $promoDao;
    private $eventoDao;
    private $categoriaDao;
    private $artistaDao;

    function __construct(){
        $this->artistaDao = ArtistaDao::getInstance();
        $this->categoriaDao = CategoriaDao::getInstance();
        $this->eventoDao = EventoDao::getInstance();
        $this->promoDao = PromoDao::getInstance();
    }

    function save($id_evento, $descuento){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $evento = $this->eventoDao->retrieve($id_evento);
            $params = [];
            if($evento){
                $promo = new Promo($descuento, $evento);
                $this->promoDao->save($promo);
                $mensaje = new Mensaje("SE AGREGO LA PROMO CORRECTAMENTE!" , "success");
            }else $mensaje = new Mensaje("NO SE ENCONTRO EL EVENTO" , "danger");

            $params['mensaje'] = $mensaje->getAlert();


            $categorias = $this->categoriaDao->getAll();
            $eventos = $this->eventoDao->getAll();
            $artistas = $this->artistaDao->getAll();
            $params['categorias'] = $categorias;
            $params['eventos'] = $eventos;
            $params['artistas'] = $artistas;

            $this->page('crearEvento', 'Crear Evento', 2,$params);

        }else { header("location: /"); }
    }
}
