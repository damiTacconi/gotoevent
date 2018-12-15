<?php
$bgT = false;
include "navbar.php";
include "navCategorias.php";

$evento = $param['evento'];
$fecha_desde = $evento->getFechaDesde();
$fecha_hasta = $evento->getFechaHasta();
$fecha_desde = utf8_encode(strftime("%A, %d de %B del %Y", strtotime($fecha_desde)));
$fecha_hasta = utf8_encode(strftime("%A, %d de %B del %Y", strtotime($fecha_hasta)));
$imagen = $evento->getEventoImagen()->getImagen();
$url = "data:image/jpg;base64,{$imagen}";

?>

<section class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="row">
                    <div class="col-md-4">
                        <img src="<?= $url ?>" class="w-100 h-100">
                    </div>
                    <div class="col-md-8 px-3">
                        <div class="card-block p-3">
                            <h2 class="card-title">
                                <?= $evento->getTitulo() ?>
                            </h2>
                            <hr>
                            <p>
                                <?php if($fecha_desde === $fecha_hasta) { ?>
                                Fecha: <strong><?= $fecha_desde ?></strong>
                                <?php }else { ?>
                                Fecha de Inicio: <strong> <?= $fecha_desde ?></strong><br>
                                Fecha de Cierre: <strong> <?= $fecha_hasta ?></strong>
                                <?php } ?>
                            </p>
                            <p class="card-text">
                                <?= $evento->getDescripcion() ?>
                            </p>
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h3 class="card-header primary-color white-text">PROXIMOS SHOWS</h3>
                    <ul class="list-group list-group-flush">
                        <?php
                        if($param['evento_sedes']) {
                            foreach ($param['evento_sedes'] as $sede) { ?>
                                <li class="list-group-item">
                                    <strong style="font-size: 30px;color:#3949ab">
                                        <a href="/evento/sede/<?= $evento->getId() ?>/<?= $sede->getId() ?>" style="color:inherit;text-decoration: none">
                                            <?= $sede->getNombre() ?>
                                        </a>
                                    </strong>
                                </li>
                            <?php }
                        }else{ ?>
                            <li class="list-group-item">
                                <span class="bg-warning text-white p-1">
                                    <i class="fas fa-exclamation-triangle"></i>  PROXIMAMENTE MAS INFORMACION ... <i class="fas fa-exclamation-triangle"></i>
                                </span>
                            </li>
                        <?php } ?>
                    </ul>

            </div>
        </div>
    </div>
</section>