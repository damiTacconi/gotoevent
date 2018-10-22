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
                        PACK PROMO
                    </h1>
                </div>
                <div class="card-body">
                    <h2 class="card-title">
                      <?= $evento->getTitulo() ?>
                      <hr>
                      <p>
                        $<?= $precioPromo ?>
                      </p>
                    </h2>
                    <p class="card-text">No te pierdas esta promo.</p>
                    <hr>
                    <form action="/compra/addToCartPromo" method="post">
                        <input type="hidden" name="idpromo" value="<?= $id ?>" >
                        <div class="form-group">
                          <input type="number" min="1" name="cantidad" value="1">
                        </div>
                        <input type="hidden" name="id_sede" value="<?= $sede->getId() ?>">
                        <button type="submit" class="btn btn-success">COMPRAR</button>
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
