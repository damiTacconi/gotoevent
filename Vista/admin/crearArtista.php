<?php include "adminNav.php" ?>
<div id="wrapper">
    <?php include 'sidebar.php' ?>
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Artista</a>
                </li>
                <li class="breadcrumb-item active">Crear</li>
            </ol>
            <?php if(isset($param['mensaje'])) {
                echo $param['mensaje'];
            }?>
            <form action="/artista/save" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputNombre">Nombre</label>
                        <input required type="text" class="form-control" name="nombre" id="inputNombre" placeholder="Ej: 'AC/DC' ">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>
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