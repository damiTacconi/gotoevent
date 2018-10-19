<?php
if($evento->getCategoria()->getDescripcion() === "Festival") {
            $promo = $param['promo'];
            $descuento = $promo->getDescuento();
            $id = $promo->getId();
            $precioPromo = 0;
            foreach ($param['calendarios'] as $calendario){
            $plazas = $calendario->getPlazaEventos();
            foreach ($plazas as $plaza){
            $precioPromo += $plaza->getPrecio();
            }
            }
            $precioPromo -= $descuento;
            ?>
    <div class="row justify-content-center">
        <div class="col-md-6">
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
                    <form action="compra/addToCart">
                        <input type="hidden" name="idpromo" value="<?= $id ?>" >
                        <button type="button" class="btn btn-success">COMPRAR</button>
                    </form>
                </div>
                <div class="card-footer text-muted success-color white-text">
                    <p class="mb-0">Compra los
                        <?= count($param['calendarios']) ?> Dias</p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>