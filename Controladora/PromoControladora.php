<?php

namespace Controladora;

use Modelo\Promo;
use Modelo\Evento;
use Modelo\Mensaje;
use Dao\CategoriaBdDao;
use Dao\ArtistaBdDao;
use Dao\EventoBdDao;
use Dao\PromoBdDao;



class PromoControladora extends PaginaControladora{

    private $promoDao;
    private $eventoDao;
    private $categoriaDao;


    function __construct(){
        $this->artistaDao = ArtistaBdDao::getInstance();
        $this->categoriaDao = CategoriaBdDao::getInstance();
        $this->eventoDao = EventoBdDao::getInstance();
        $this->promoDao = PromoBdDao::getInstance();
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
