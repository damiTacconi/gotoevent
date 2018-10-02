 <div class="blog-card">
    <div class="meta">
        <div class="photo" style='background-image: url(<?= $url ?>);'></div>
        <ul class="details">
            <li class="">
                <span><i>Fecha de inicio</i> <br></span>
                <?= utf8_encode(strftime("%A, %d de %B del %Y", strtotime($fecha))) ?>
            </li>
        </ul>
    </div>
    <div class="description">
        <h1><?=  $evento->getTitulo() ?></h1>
        <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad eum dolorum architecto obcaecati.</p>
        <p class="read-more">
            <?php  if(!empty($calendarios)){ ?>
                <a href="/compra/evento/<?= $evento->getId() ?>" class="btn btn-success">COMPRAR</a>
            <?php }else{ ?>
                <button class="btn btn-amber" disabled>Proximamente</button>
            <?php }  ?>
        </p>
    </div>
</div>


<!--
<style>
    .card-img-top {
        width: 100%;
        height: 15vw;
        object-fit: cover;
    }
</style>
<div class="card-group">
    <div class="card">
        <img class="card-img-top" src="<?php// $url ?>" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title"><strong><?php // $evento->getTitulo() ?></strong></h5>

        </div>
    </div>
</div> -->