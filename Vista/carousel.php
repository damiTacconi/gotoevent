<!-- The slideshow -->
<div class="owl-carousel text-center">
        <?php foreach ($eventos as $evento) {
            $fecha = $evento->getFechaDesde();
            $fecha_hasta = $evento->getFechaHasta();
            $imagen = $evento->getEventoImagen()->getImagen();
            $calendarios = $evento->getCalendarios();
            $categoria = $evento->getCategoria();
            $url = "data:image/jpg;base64,{$imagen}";
            ?>
                <div>
                    <?php include "card-event.php" ?>
                </div>
        <?php } ?>
</div>


<script>
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        responsiveClass:true,
        nav:false,
        dots:false,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:2,
            },
            1000:{
                items:3,
            }
        }
    })
</script>