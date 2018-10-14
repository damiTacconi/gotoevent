<!-- HEADER -->


<?php
        $eventos = \Dao\EventoBdDao::getInstance()->getAll();
        if($eventos) {
            $eventos = array_map(function ($ev) {
                $calendarioDao = \Dao\CalendarioBdDao::getInstance();
                $calendarios = $calendarioDao->traerPorIdEvento($ev->getId());
                if ($calendarios) {
                    $calendarios = array_map(function ($cal) {
                        $showDao = \Dao\ShowBdDao::getInstance();
                        $plazaEventoDao = \Dao\PlazaEventoBdDao::getInstance();
                        $id = $cal->getId();
                        $shows = $showDao->traerPorIdCalendario($id);
                        $plazaEventos = $plazaEventoDao->traerPorIdCalendario($id);
                        if ($shows)
                            $cal->setShows($shows);
                        if ($plazaEventos)
                            $cal->setPlazaEventos($plazaEventos);
                        return $cal;
                    }, $calendarios);
                    $ev->setCalendarios($calendarios);
                }
                return $ev;
            }, $eventos);
        }
    if(isset($param['TICKET_MODAL'])){
        ?>
        <!-- Central Modal Medium Success -->
        <div class="modal fade" id="centralModalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-notify modal-success" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header">
                        <p class="heading lead">GRACIAS POR ELEGIRNOS</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fa fa-check fa-4x mb-3 animated rotateIn"></i>
                            <p><strong><?= $param['mensaje'] ?></strong></p>
                        </div>
                    </div>

                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <a type="button" class="btn btn-primary waves-effect" data-dismiss="modal">ACEPTAR</a>
                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!-- Central Modal Medium Success-->

        <!-- Button trigger modal -->
        <script>
            $("#centralModalSuccess").on('show.bs.modal', function(){});
            $(window).on('load',function(){
                $('#centralModalSuccess').modal('show');
            });
        </script>
        <?php
    }
?>

<?php include "header-inicio.php" ?>
<nav class="navbar navbar-expand-lg navbar-dark blue scrolling-navbar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#">TEATROS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">CONCIERTOS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">FESTIVALES</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">MAS</a>
        </li>
      </ul>
    </div>
  </nav>
<!-- FIN HEADER -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 bg-white">
            <div id="containerSearch" class="border-bottom p-3 border-light">
                <form  class="justify-content-center form-inline active-cyan-4">
                    <input class="form-control form-control-sm mr-3 w-50" type="text" placeholder="ENCONTRA LO MEJOR DEL ENTRETENIMIENTO" aria-label="Search">
                    <button id="btnSearch" class="btn btn-primary btn-sm" style="width: 10%"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>


    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="p-5">
                    <div class="primary-color">
                        <h1 class="text-center font-weight-bold  text-white">
                            <strong>Proximos Eventos</strong>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php
                if($eventos) {
                   //var_dump($eventos);
                    include 'carousel.php';
                }
                ?>
            </div>
        </div>
    </div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="p-2 pt-5">
                <div class="primary-color">
                    <h1 class="text-center font-weight-bold  text-white">
                        <strong>Eventos por categoria</strong>
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

        </div>
    </div>
</div>