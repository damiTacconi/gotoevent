<div class="row justify-content-lg-center">
<?php foreach ($param['calendarios'] as $calendario) {
    $plazas = $calendario->getPlazaEventos();
    $calendario_sede = $calendario->getSede();
    ?>
    <?php if ($plazas) {
        if($calendario_sede->getId() === $sede->getId()){
            foreach ($plazas as $plaza) { ?>
                <div class="col-md-3 col-12">
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
    } else echo " <br/> NO HAY PLAZAS DE MOMENTO ...<br/>";
    echo " <br/> ";
} ?>
</div>
