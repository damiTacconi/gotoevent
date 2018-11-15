
<header> 
    <video loop muted autoplay playsinline poster="/./video/videoplayback.mp4">
        <source src="video/videoplayback.ogv" type="video/ogg" />
        <source src="video/videoplayback.webm" type="video/webm" />
        <source src="/video/videoplayback.mp4" type="video/mp4"  />
    </video>
    
    <div class="banner">
        <?php $bgT=true; include "navbar.php" ?>
        <div class="header-content">
            <div class="container">
                <div class="row justify-content-center">
                    <?php if($_SESSION['rol'] === 'invitado'){ ?>
                        <div class="col-md-7 d-none d-sm-block">
                            <div class="text-center mt-5">
                                <div id="welcome-message">
                                    <h1> Organizamos eventos para vos</h1>
                                    <p>No te pierdas los mejores eventos de tu region. Con GoToEvent
                                        podras comprar tus entradas de manera comoda, rapida, segura y sencilla</p>
                                    <a href="#" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="No implementado"> Leer Mas</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-5">
                            <div class="xs-padding-top">
                                <?php include "login.php" ?>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="col-md-8 mt-5">
                            <div class="text-center">
                                <div class="card text-center">
                                    <div class="card-header indigo   white-text">
                                        <h2>Bienvenido</h2>
                                    </div>
                                    <div class="card-body black-text">
                                        <h2 class="card-title"><?= $_SESSION['name'] ?> </h2>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    </div>
                                    <div class="card-footer text-muted    white-text">
                                        <a href="/cuenta/tickets" class="btn btn-blue"> Mis Tickets </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</header>