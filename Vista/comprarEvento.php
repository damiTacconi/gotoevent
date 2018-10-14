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
        <?php
            if($evento->getCategoria()->getDescripcion() === "Festival") {
            $precioPromo = 0;
            foreach ($param['calendarios'] as $calendario){
            $plazas = $calendario->getPlazaEventos();
            foreach ($plazas as $plaza){
            $precioPromo += $plaza->getPrecio();
            }
            }
            $precioPromo -= 500;
            ?>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header success-color white-text">
                    <h1>
                        <?= $evento->getTitulo() ?>
                    </h1>
                </div>
                <div class="card-body">
                    <h2 class="card-title">PACK PROMO $
                        <?= $precioPromo ?>
                    </h2>
                    <p class="card-text">No te pierdas esta promo.</p>
                    <button type="button" class="btn btn-success">COMPRAR</button>
                </div>
                <div class="card-footer text-muted success-color white-text">
                    <p class="mb-0">Compra los
                        <?= count($param['calendarios']) ?> Dias</p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>

<?php if($param['evento_sedes']) { ?>
<div class="container">
    <div class="row justify-content-center">
    <?php foreach($param['evento_sedes'] as $sede) { ?>
        <div class="col-md-12 p-4">
            <div class="card">
                <div class="card-header primary-color lighten-1 white-text">
                    <h1>
                    <i class="fas fa-map-marked"></i> <?= $sede->getNombre() ?> 
                    </h1>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <?php foreach ($param['calendarios'] as $calendario) {
                                $plazas = $calendario->getPlazaEventos();
                                $calendario_sede = $calendario->getSede();
                        ?>
                        <?php if ($plazas) {
                                if($calendario_sede->getId() === $sede->getId()){ 
                                     foreach ($plazas as $plaza) { ?>
                                        <div class="col-md-auto col-12">
                                            <div class="p-1">
                                                <div class="card">
                                                    <h3 class="card-header primary-color white-text text-center">
                                                    <i class="far fa-calendar-alt"></i> <strong><?= $calendario->getFecha() ?></strong> 
                                                    </h3>
                                                    <div class="card-body">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">PLAZA:
                                                                <strong>
                                                                    <?= $plaza->getPlaza()->getDescripcion() ?>
                                                                </strong>
                                                            </li>
                                                            <li class="list-group-item">PRECIO: <strong>
                                                                    $
                                                                    <?= $plaza->getPrecio() ?> </strong></li>
                                                            <li class="list-group-item">
                                                                <form class="form" method="post" action="/compra/addToCart/">
                                                                    <input type="hidden" name="idPlaza" value="<?= $plaza->getId() ?>">
                                                                    <div class="form-group">
                                                                        <label for="inputCantidad">Cantidad</label>
                                                                        <input required value="1" type='number' class="form-control" min='1'
                                                                            max='5' id="inputCantidad" name='cantidad'>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">AGREGAR
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }
                            } else echo " <br/> NO HAY PLAZAS DE MOMENTO ...<br/>";
                                            echo " <br/> ";
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    
    <?php } ?>
    </div>
</div>
<?php } ?>