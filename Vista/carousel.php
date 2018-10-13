<style>
    .col-md-3{
        display: inline-block;
        margin-left:-4px;
    }
    .col-md-3 img{
        width:100%;
        height:auto;
    }
    body .carousel-indicators li{
        background-color:#0d47a1;
    }
    body .carousel-control-prev-icon,
    body .carousel-control-next-icon{
        background-color:#0d47a1;
    }
    body .no-padding{
        padding-left: 0;
        padding-right: 0;
    }
</style>

<?php
    $arr = [];
    $count = count($eventos);
    $size = 4;
    do {
        $arr = array_chunk($eventos, $size);
        $count -= $size;
    }while($count > 0);

 /*foreach($eventos as $evento) {
            $fecha = $evento->getFechaDesde();
            $fecha_hasta = $evento->getFechaHasta();
            $imagen = $evento->getEventoImagen()->getImagen();
            $calendarios = $evento->getCalendarios();
            $categoria = $evento->getCategoria();
            $url = "data:image/jpg;base64,{$imagen}";
            ?>
            <?php include "card-event.php" ?>
        <?php }*/
?>
<div id="demo" class="carousel slide" data-ride="carousel">

    <!-- Indicators -->
    <ul class="carousel-indicators">
        <li data-target="#demo" data-slide-to="0" class="active"></li>
        <li data-target="#demo" data-slide-to="1"></li>
        <li data-target="#demo" data-slide-to="2"></li>
    </ul>


    <!-- The slideshow -->
    <div class="container carousel-inner no-padding">
        <?php for($i=0;$i<count($arr);$i++){ ?>
            <div class="carousel-item <?php echo ($i === 0 ? 'active':'') ?>">
                    <?php foreach ($arr[$i] as $evento) {
                        $fecha = $evento->getFechaDesde();
                        $fecha_hasta = $evento->getFechaHasta();
                        $imagen = $evento->getEventoImagen()->getImagen();
                        $calendarios = $evento->getCalendarios();
                        $categoria = $evento->getCategoria();
                        $url = "data:image/jpg;base64,{$imagen}";
                        ?>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="card-deck" style="justify-self: center">
                                <?php include "card-event.php" ?>
                            </div>
                        </div>
                    <?php } ?>
            </div>
        <?php } ?>
    </div>

    <!-- Left and right controls -->
    <a class="carousel-control-prev" style="left: -8vw" href="#demo" data-slide="prev">
        <span class="carousel-control-prev-icon p-4"></span>
    </a>
    <a class="carousel-control-next" style="left:77vw" href="#demo" data-slide="next">
        <span class="carousel-control-next-icon p-4"></span>
    </a>
</div>