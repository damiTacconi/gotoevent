<?php
$bgT = false;
include "navbar.php" ?>
<?php
$evento = $param['evento'];
$imagen = $evento->getEventoImagen()->getImagen();
$url = "data:image/jpg;base64,{$imagen}";


?>
<div class="container-fluid">
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
                          <button type="button" class="btn btn-success">COMPRAR</button>
                    </div>
                    <div class="card-footer text-muted success-color white-text">
                        <p class="mb-0">Compra los <?= count($param['calendarios']) ?> Dias</p>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row ">
        <div class="col-12 col-md-3">
            <!--Panel-->
            <div class="card border-primary mt-5 mb-3" style="max-width: 18rem;">
                <div class="card-header"><?= $evento->getTitulo() ?></div>
                <div class="card-body text-primary">
                <img src="<?= $url ?>" width="250" height="200" alt="Imagen">

                    <p class="card-text p-3"> <?= $evento->getDescripcion() ?></p>
                </div>
            </div>
            <!--/.Panel-->
        </div>
        <div class="col-md-9">
            <?php
                if($param['calendarios']) { ?>
                    <div class="row"> <?php
                    foreach ($param['calendarios'] as $calendario) {
                        $plazas = $calendario->getPlazaEventos();
                         ?>

                         <?php
                        if ($plazas) {
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
                                                        <li class="list-group-item">PRECIO: <strong>
                                                                $<?= $plaza->getPrecio() ?> </strong></li>
                                                        <li class="list-group-item">
                                                            <form class="form" method="post" action="/compra/addToCart/">
                                                                <input type="hidden" name="idPlaza"
                                                                       value="<?= $plaza->getId() ?>">
                                                                <div class="form-group">
                                                                    <label for="inputCantidad">Cantidad</label>
                                                                    <input required value="1" type='number'
                                                                           class="form-control" min='1' max='5'
                                                                           id="inputCantidad" name='cantidad'>
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
                                    <?php
                                }
                        } else echo " <br/> NO HAY PLAZAS DE MOMENTO ...<br/>";
                        echo " <br/> ";
                    } ?>
                    </div> <?php
                }else echo " <br/> <h1>NO HAY CALENDARIOS DE MOMENTO ...</h1> "?>
        </div>

    </div>

</div>
