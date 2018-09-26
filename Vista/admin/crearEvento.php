<?php include "adminNav.php" ?>
<div id="wrapper">
    <?php include 'sidebar.php' ?>
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Evento</a>
                </li>
                <li class="breadcrumb-item active">Crear</li>
            </ol>
            <?php if(isset($param['mensaje'])) { echo $param['mensaje']; ?>
                <script>window.scrollTo(0, 0);</script>
            <?php } ?>

            <!-- FORMULARIOS -->
            <?php include "altas/agregarEvento.php" ?>
            <hr>
            <?php include "altas/agregarShow.php" ?>
            <hr>
            <?php include "altas/agregarPlaza.php" ?>
            <!-- FIN FORMULARIOS -->
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




