<?php
$fecha = utf8_encode(strftime("%A, %d de %B del %Y", strtotime($fecha)));
$titulo = $evento->getTitulo();
?>
    <!-- Card -->
    <div class="card mb-4">
        <!--Card image-->
        <div class="view overlay">
            <img class="card-img-top" width="200" height="300"  src="<?=$url ?>" alt="Card image cap">
            <a href="#">
                <div class="mask rgba-white-slight"></div>
            </a>
        </div>
        <!--Card content-->
        <div class="card-body">
            <!--Title-->
            <a href="/evento/detalle/<?= $evento->getId() ?>" class="btn btn-blue btn-block">MAS INFORMACION</a>
        </div>
    </div>