<?php
$fecha = utf8_encode(strftime("%A, %d de %B del %Y", strtotime($fecha)));
$titulo = $evento->getTitulo();
?>
<!-- Card deck -->


    <!-- Card -->
    <div class="card mb-4">

        <!--Card image-->
        <div class="view overlay">
            <img class="card-img-top" width="200" height="300"  src="<?=$url ?>" alt="Card image cap">
            <a href="#!">
                <div class="mask rgba-white-slight"></div>
            </a>
        </div>

        <!--Card content-->
        <div class="card-body">

            <!--Title-->
            <h4 class="card-title"><?= $titulo ?></h4>
            <a href="/compra/evento/<?= $evento->getId() ?>" class="btn btn-blue btn-md btn-block">MAS INFORMACION</a>

        </div>

    </div>
    <!-- Card -->

<!-- Card deck -->
<!--
 <div class="blog-card">
    <div class="meta">
        <div class="photo" style='background-image: url(// $url );'></div>
        <ul class="details">
            <li class="">
                <span><i>Fecha de inicio</i> <br></span>

            </li>
        </ul>
    </div>
     <!--
    <div class="description">
        <h1></h1>
        <p>  //$evento->getDescripcion() </p>
        <p class="read-more">
            <?php  /*if(!empty($calendarios)){ ?>
                <a href="/compra/evento/<?= $evento->getId() ?>" class="btn btn-success">COMPRAR</a>
            <?php }else{ ?>
                <button class="btn btn-amber" disabled>Proximamente</button>
            <?php } */ ?>
        </p>
    </div>
</div>
-->