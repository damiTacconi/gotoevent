<style>
    /*PEN STYLES*/

    body {
        background: #f1f1f1;
    }

    .blog-card {
        display: flex;
        flex-direction: column;
        box-shadow: 0 3px 7px -1px rgba(0, 0, 0, 0.1);
        background: #fff;
        line-height: 1.4;
        margin:10px;
        font-family: sans-serif;
        border-radius: 5px;
        overflow: hidden;
        z-index: 0;
    }
    .blog-card a {
        color: inherit;
    }
    .blog-card a:hover {
        color: #5ad67d;
    }
    .blog-card:hover .photo {
        -webkit-transform: scale(1.3) rotate(3deg);
        transform: scale(1.3) rotate(3deg);
    }
    .blog-card .meta {
        position: relative;
        z-index: 0;
        height: 200px;
    }
    .blog-card .photo {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-size: cover;
        background-position: center;
        transition: -webkit-transform .2s;
        transition: transform .2s;
        transition: transform .2s, -webkit-transform .2s;
    }
    .blog-card .details,
    .blog-card .details ul {
        margin: auto;
        padding: 0;
        list-style: none;
    }
    .blog-card .details {
        position: absolute;
        top: 0;
        bottom: 0;
        left: -100%;
        margin: auto;
        transition: left .2s;
        background: rgba(0, 0, 0, 0.6);
        color: #fff;
        padding: 10px;
        width: 100%;
        font-size: .9rem;
    }
    .blog-card .details a {
        -webkit-text-decoration: dotted underline;
        text-decoration: dotted underline;
    }
    .blog-card .details ul li {
        display: inline-block;
    }
    .blog-card .details .author:before {
        font-family: FontAwesome;
        margin-right: 10px;
        content: "\f007";
    }
    .blog-card .details .date:before {
        font-family: FontAwesome;
        margin-right: 10px;
        content: "\f133";
    }
    .blog-card .details .tags ul:before {
        font-family: FontAwesome;
        content: "\f02b";
        margin-right: 10px;
    }
    .blog-card .details .tags li {
        margin-right: 2px;
    }
    .blog-card .details .tags li:first-child {
        margin-left: -4px;
    }
    .blog-card .description {
        padding: 1rem;
        background: #fff;
        position: relative;
        z-index: 1;
    }
    .blog-card .description h1,
    .blog-card .description h2 {
        font-family: Poppins, sans-serif;
    }
    .blog-card .description h1 {
        line-height: 1;
        margin: 0;
        font-size: 1.7rem;
    }
    .blog-card .description h2 {
        font-size: 1rem;
        font-weight: 300;
        text-transform: uppercase;
        color: #a2a2a2;
        margin-top: 5px;
    }
    .blog-card .description .read-more {
        text-align: right;
    }
    .blog-card .description .read-more a {
        color: #5ad67d;
        display: inline-block;
        position: relative;
    }
    .blog-card .description .read-more a:after {
        content: "\f061";
        font-family: FontAwesome;
        margin-left: -10px;
        opacity: 0;
        vertical-align: middle;
        transition: margin .3s, opacity .3s;
    }
    .blog-card .description .read-more a:hover:after {
        margin-left: 5px;
        opacity: 1;
    }
    .blog-card p {
        position: relative;
        margin: 1rem 0 0;
    }
    .blog-card p:first-of-type {
        margin-top: 1.25rem;
    }
    .blog-card p:first-of-type:before {
        content: "";
        position: absolute;
        height: 5px;
        background: #5ad67d;
        width: 35px;
        top: -0.75rem;
        border-radius: 3px;
    }
    .blog-card:hover .details {
        left: 0%;
    }
    @media (min-width: 640px) {
        .blog-card {
            flex-direction: row;
            max-width: 700px;
        }
        .blog-card .meta {
            flex-basis: 40%;
            height: auto;
        }
        .blog-card .description {
            flex-basis: 60%;
        }
        .blog-card .description:before {
            -webkit-transform: skewX(-3deg);
            transform: skewX(-3deg);
            content: "";
            background: #fff;
            width: 0px;
            position: absolute;
            left: -10px;
            top: 0;
            bottom: 0;
            z-index: -1;
        }
        .blog-card.alt {
            flex-direction: row-reverse;
        }
        .blog-card.alt .description:before {
            left: inherit;
            right: -10px;
            -webkit-transform: skew(3deg);
            transform: skew(3deg);
        }
        .blog-card.alt .details {
            padding-left: 25px;
        }
    }

</style>

<div class="p-4">
    <div class="container-fluid">
        <div class="row">
            <?php foreach($param['eventos'] as $evento) {
                $fecha = $evento->getFechaDesde();
                $fecha_hasta = $evento->getFechaHasta();
                $imagen = $evento->getEventoImagen()->getImagen();
                $calendarios = $evento->getCalendarios();
                $categoria = $evento->getCategoria();
                $url = "data:image;base64,{$imagen}";
                ?>
                <div class="col-md-6 col-12">
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
                            <h1><?= $evento->getTitulo() ?></h1>
                            <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad eum dolorum architecto obcaecati.</p>
                            <p class="read-more">
                                <?php if(!empty($calendarios)){ ?>
                                    <button class="btn btn-success">COMPRAR TICKET</button>
                                <?php }else{ ?>
                                    <button class="btn btn-amber" disabled>Proximamente</button>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
