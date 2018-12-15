<!-- HEADER -->


<?php
        use Dao\EventoBdDao as EventoDao;
        #use Dao\EventoListaDao as EventoDao;
        use Dao\CalendarioBdDao as CalendarioDao;
        #use Dao\CalendarioListaDao as CalendarioDao;
        use Dao\ShowBdDao as ShowDao;
        #use Dao\ShowListaDao as ShowDao;
        use Dao\PlazaEventoBdDao as PlazaEventoDao;
        #use Dao\PlazaEventoListaDao as PlazaEventoDao;
        $eventos = EventoDao::getInstance()->getAll();
        if($eventos) {
            $eventos = array_map(function ($ev) {
                $calendarioDao = CalendarioDao::getInstance();
                $calendarios = $calendarioDao->traerPorIdEvento($ev->getId());
                if ($calendarios) {
                    $calendarios = array_map(function ($cal) {
                        $showDao = ShowDao::getInstance();
                        $plazaEventoDao = PlazaEventoDao::getInstance();
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
            if($param['TICKET_MODAL'] === "SUCCESS") {
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
            <?php }else{ ?>
                <!-- Central Modal Medium Danger -->
                <div class="modal fade" id="centralModalDanger" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-notify modal-danger" role="document">
                        <!--Content-->
                        <div class="modal-content">
                            <!--Header-->
                            <div class="modal-header">
                                <p class="heading lead">HUBO UN PROBLEMA</p>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" class="white-text">&times;</span>
                                </button>
                            </div>

                            <!--Body-->
                            <div class="modal-body">
                                <div class="text-center">
                                    <i class="fa fa-check fa-4x mb-3 animated rotateOut"></i>
                                    <p><strong><?= $param['mensaje'] ?></strong></p>
                                </div>
                            </div>

                            <!--Footer-->
                            <div class="modal-footer justify-content-center">
                                <a type="button" class="btn btn-danger">Get it now <i class="fa fa-diamond ml-1 text-white"></i></a>
                                <a type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">No, thanks</a>
                            </div>
                        </div>
                        <!--/.Content-->
                    </div>
                </div>
                <!-- Central Modal Medium Danger-->

                <script>
                    $("#centralModalDanger").on('show.bs.modal', function(){});
                    $(window).on('load',function(){
                        $('#centralModalDanger').modal('show');
                    });
                </script>
            <?php }?>
        <?php
    }
?>
<?php include "header-inicio.php" ?>
<?php include "navCategorias.php" ?>
<!-- FIN HEADER -->

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
                }else{
                    echo "<h1 style='text-align: center'> NO HAY EVENTOS PARA MOSTRAR </h1>";
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
                        <strong>CATEGORIAS</strong>
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-12 col-md-4" style="font-family: 'Acme' ">
                <!-- Card -->
                <div onclick="window.location='/buscar/categoria/concierto'" class="card card-image card-categoria" style="cursor:pointer;background-image: url(/./img/conciertos.jpg);  background-size: cover;">

                <!-- Content -->
                <div class="text-white text-center align-items-center rgba-black-strong py-5 px-4">
                <div>
                    <h1 class="white-text"><i class="fa fa-pie-chart"></i> CONCIERTOS</h1>
                    </div>
                </div>

                </div>
                <!-- Card -->
        </div>
        <div class="col-12 col-md-4" style="font-family: 'Acme'">
                <!-- Card -->
                    <div onclick="window.location='/buscar/categoria/Obra-de-Teatro'" class="card card-image card-categoria" style="cursor:pointer;background-image: url('/./img/teatros.jpg');  background-size: cover;">
                        <!-- Content -->
                        <div class="text-white text-center align-items-center rgba-black-strong py-5 px-4 ">
                            <div>
                                <h1 class="white-text"><i class="fa fa-pie-chart"></i>TEATROS</h1>
                            </div>
                        </div>

                    </div>
                    <!-- Card -->

        </div>
        <div class="col-12 col-md-4" style="font-family: 'Acme'">
                <!-- Card -->
                <div onclick="window.location='/buscar/categoria/festival'" class="card card-image card-categoria"  style="cursor:pointer;background-image: url(/./img/festivales.jpg);  background-size: cover;">

                <!-- Content -->
                <div class="text-white text-center align-items-center rgba-black-strong py-5 px-4">
                <div>
                    <h1 class="white-text"><i class="fa fa-pie-chart"></i>FESTIVALES</h1>
                    </div>
                </div>

                </div>
                <!-- Card -->
        </div>
    </div>
</div>
