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
                    <div class="card-body mdb-color">
                        <?php include "calendarios.php" ?>
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
                                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d785.4774900406105!2d-57.54312967083426!3d-38.04918429873188!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9584dde618d88b07%3A0x98429fd7ae71776c!2sUTN+Universidad+Tecnol%C3%B3gica+Nacional+Mar+del+Plata+%7C+Universidades+Mar+del+Plata!5e0!3m2!1sen!2sar!4v1541597702679" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
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
