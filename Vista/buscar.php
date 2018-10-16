<?php $bgT = false; include "navbar.php"; include "navCategorias.php";?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card m-4">
                <h3 class="card-header primary-color white-text"> RESULTADOS DE LA BUSQUEDA</h3>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-auto col-12">
                            <?php foreach($param['eventos'] as $evento) { 
                            $fecha = $evento->getFechaDesde();
                            $fecha_hasta = $evento->getFechaHasta();
                            $imagen = $evento->getEventoImagen()->getImagen();
                            $calendarios = $evento->getCalendarios();
                            $categoria = $evento->getCategoria();
                            $url = "data:image/jpg;base64,{$imagen}";
                            ?>
                            <?php include "card-event.php" ?>
                        </div>
                    </div>
                <?php } ?>
                    </div>
            </div>
        </div>
    </div>
</div>