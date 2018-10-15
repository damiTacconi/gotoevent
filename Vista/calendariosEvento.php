<?php
$sede = $param['evento_sede'];
$bgT = false;
include "navbar.php";
include "navCategorias.php";
/*
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
        <?php } */
?>

<?php if($sede) { ?>
<div class="container-fluid">
    <div class="row justify-content-center">
            <div class="col-md-12 p-4">
                <div class="card">
                    <div class="card-header primary-color lighten-1 white-text">
                        <h1>
                            <i class="fas fa-map-marked"></i> <?= $sede->getNombre() ?>
                        </h1>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12 p-3">
                                    <div class="card">
                                        <div class="card-header primary-color lighten-1 white-text">
                                            <h3>
                                                <i class="far fa-calendar-alt"></i> | FECHAS
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <?php include "calendarios.php" ?>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 p-3">
                                <div class="card">
                                    <div class="card-header primary-color lighten-1 white-text">
                                        <h3>
                                            <i class="fas fa-map-marker-alt"></i> | ESCENARIO
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div id="googleMap" style="width:100%;height:400px;">
                                            <img src="/./img/ejemplo-map.jpg" width="100%" height="100%" alt="Google Maps">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<?php } ?>
</script>
