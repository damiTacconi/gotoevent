
<header class="v-header">
  <div class="full-v">
    <video src="/./video/videoplayback.mp4" id="video" preload="auto" autoplay="autoplay" loop="loop"></video>
  </div>
  <div class="header-overlay"></div>
  <div class="header-content" id="h-c">
    <div class="container">
      <div class="row justify-content-center">
          <?php if(empty($_SESSION)){ ?>
                <div class="col-md-7 mt-5">
                    <div class="text-center">
                        <div id="welcome-message">
                            <h1> Organizamos eventos para vos</h1>
                            <p>No te pierdas los mejores eventos de tu region. Con GoToEvent
                                podras comprar tus entradas de manera comoda, rapida, segura y sencilla</p>
                            <a href="#" class="btn btn-primary"> Read More</a>
                        </div>
                    </div>
                </div>
              <div class="col-12 col-sm-12 col-md-5">
                  <?php include "login.php" ?>
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
                                <button class="btn btn-blue"> Mis Tickets </button>
                                <button class="btn btn-blue"> Mis Eventos </button>
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
