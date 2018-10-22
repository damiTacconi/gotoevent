<div class="row">
    <div class="col-md-2 col-12">
        <div class="primary-color">
            <h1 class="text-center font-weight-bold  text-white">
                <strong>FECHAS</strong>
            </h1>
        </div>
        <div class="list-group" id="list-tab" role="tablist">
            <?php foreach ($param['calendarios_fechas'] as $key => $cal) { $fecha = $cal->getFecha(); ?>
            <a class="list-group-item list-group-item-action <?= $key===0? 'active':'' ?> " id="list-<?= $fecha ?>-list"
                data-toggle="list" href="#list-<?= $fecha ?>" role="tab" aria-controls="home">
                <i class="far fa-calendar-alt"></i>
                <?= $fecha ?>
            </a>
            <?php } ?>

            <?php if(isset($param['promo'])) { ?>
                <a class="list-group-item list-group-item-action bg-success text-white hvr-fade" id="list-promo-list"
                data-toggle="list" href="#list-promo" role="tab" aria-controls="home">
                    PACK PROMO
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-10 col-12">
        <div class="primary-color">
            <h1 class="text-center font-weight-bold  text-white">
                <strong>PLAZAS</strong>
            </h1>
        </div>
        <div class="tab-content" id="nav-tabContent">
            <?php foreach ($param['calendarios_fechas'] as $key => $cal) { $fecha = $cal->getFecha(); ?>
            <div class="tab-pane fade <?= $key===0? 'show active':'' ?>" id="list-<?= $fecha ?>" role="tabpanel"
                aria-labelledby="list-<?= $fecha ?>-list">
                <div class="row">
                    <?php foreach($param['calendarios'] as $calendario) { ?>
                    <?php if($calendario->getFecha() === $fecha){
                                                            $plazas = $calendario->getPlazaEventos();
                                                        $calendario_sede = $calendario->getSede();
                                                        if ($plazas) {
                                                                if($calendario_sede->getId() === $sede->getId()){
                                                                    foreach ($plazas as $plaza) {?>
                    <div class="col-md-auto col-12">
                        <div class="card">
                            <h3 class="card-header primary-color white-text text-center">
                                <strong>
                                    <?= $plaza->getPlaza()->getDescripcion() ?></strong>
                            </h3>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
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
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php }
                                                                    }
                                                                   }else { /* SI NO HAY PLAZAS ... */?>
                    <div class="col-12 text-center">
                        <div class="bg-warning text-white">
                            <h1> No hay plazas de momento </h1>
                            <span class="p-1">
                                <i class="fas fa-exclamation-triangle"></i> PROXIMAMENTE MAS INFORMACION ... <i class="fas fa-exclamation-triangle"></i>
                            </span>
                        </div>
                    </div>
                    <?php }
                                                     } ?>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>

            <?php if(isset($param['promo'])) { ?>
                <div class="tab-pane fade <?= $key===0? 'show active':'' ?>" id="list-promo" role="tabpanel"
                aria-labelledby="list-promo-list">
                    <?php include "promo.php" ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
