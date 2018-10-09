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
<!-- FIN HEADER -->

<?php
if($eventos) {
    include 'example.php';
}
?>
<?php include "modalRegister.php"; ?>
<script type="text/javascript">

    function add(event){
        ajaxURL('/cuenta/verificarSesion', data => {
            let result = $.trim(data);
            if(result === 'success') {
                if ($(event).hasClass("btn-success")) {
                    $(event).removeClass("btn-success");
                    $(event).addClass("btn-danger");
                    $(event).html('<i class=\"fas fa-shopping-cart\"></i> CANCELAR');
                } else {
                    $(event).removeClass("btn-danger");
                    $(event).addClass("btn-success");
                    $(event).html('<i class=\"fas fa-shopping-cart\"></i> AÑADIR');
                }
            }else{
                $('#registrarse').click();
            }
        });
    }
</script>

