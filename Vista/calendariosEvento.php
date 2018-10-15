<?php
$sede = $param['evento_sede'];
$evento = $param['evento'];
$bgT = false;
include "navbar.php";
include "navCategorias.php";
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
                        <?php include "calendarios.php" ?>
                        <?php include "promo.php" ?>
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
