<?php
$bgT = false;
include "navbar.php" ?>
<?php
$evento = $param['evento'];

?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 pt-5">
            <div class="card text-center">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <h1 class="text-center"> <?= $evento->getTitulo() ?></h1>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php if($evento->getCategoria()->getDescripcion() === "Festival") {
        $precioPromo = 0;
        foreach ($param['calendarios'] as $calendario){
            $plazas = $calendario->getPlazaEventos();
            foreach ($plazas as $plaza){
                $precioPromo += $plaza->getPrecio();
            }
        }
        $precioPromo -= 500;
        ?>
        <div class="row justify-content-center">
            <div class="col-12 p-5">
                <div class="card text-center" >
                    <div class="card-header success-color white-text">
                        <h1><?= $evento->getTitulo() ?></h1>
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">PACK PROMO $<?= $precioPromo ?></h2>
                        <p class="card-text">No te pierdas esta promo.</p>
                        <form action="/compra/promo" method="post">
                            <input type="hidden" name="id_evento" value="<?= $evento->getId() ?>">
                            <button type="submit" class="btn btn-success">COMPRAR</button>
                        </form>
                    </div>
                    <div class="card-footer text-muted success-color white-text">
                        <p class="mb-0">Compra los <?= count($param['calendarios']) ?> Dias</p>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row justify-content-center">
                <?php foreach ($param['calendarios'] as $calendario ) {
                    $plazas = $calendario->getPlazaEventos();
                    if($plazas) {
                        foreach ($plazas as $plaza) {
                            ?>
                        <div class="col-md-4 col-12">
                            <div class="p-3">
                                <div class="card">
                                    <h3 class="card-header primary-color white-text text-center"><?= $calendario->getFecha() ?> </h3>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">PLAZA:
                                                <strong>
                                                <?= $plaza->getPlaza()->getDescripcion() ?>
                                                </strong>
                                            </li>
                                            <li class="list-group-item">PRECIO: <strong> $<?= $plaza->getPrecio() ?> </strong></li>
                                            <li class="list-group-item">
                                                <form class="form" method="post" action="/compra/addToCart/">
                                                    <input type="hidden" name="idPlaza" value="<?= $plaza->getId() ?>">
                                                    <div class="form-group">
                                                        <label for="inputCantidad">Cantidad</label>
                                                        <input required value="1" type='number' class="form-control" min='1' max='5'
                                                               id="inputCantidad" name='cantidad'>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary"> AÑADIR AL CARRITO </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php
                        }
                    }else echo " <br/> NO HAY PLAZAS DE MOMENTO ...<br/>";
                    echo " <br/> ";
                }?>
    </div>

</div>

