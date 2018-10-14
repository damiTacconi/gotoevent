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