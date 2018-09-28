<?php include "adminNav.php" ?>
<div id="wrapper">
    <?php include 'sidebar.php' ?>
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Calendario</a>
                </li>
                <li class="breadcrumb-item active">Crear</li>
            </ol>
            <?php if(isset($param['mensaje'])) {
                echo $param['mensaje'];
            }
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-9"><?php include "altas/agregarCalendario.php" ?> </div>
                    <div class="col-md-3"><?php include "altas/agregarCalendarioAutomatico.php" ?></div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © Your Website 2018</span>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<script type="text/javascript">
    function actualizarFechas(){
        let id= $('#selectEvento option:selected').val();
        let obj= {id: id};
        ajaxURL('/evento/getFechasAjax/', data => {
            let result = JSON.parse(data);
            $('#fecha_desde').val(result['fecha_desde']);
            $('#fecha_hasta').val(result['fecha_hasta']);
        } , "POST", obj);
    }
</script>