<?php include "adminNav.php" ?>
<div id="wrapper">
    <?php include 'sidebar.php' ?>
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Categoria</a>
                </li>
                <li class="breadcrumb-item active">Crear</li>
            </ol>
            <?php if(isset($param['mensaje'])) {
                    echo $param['mensaje'];
            }?>
            <form action="/categoria/save" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCategoria">Descripcion</label>
                        <input type="text" class="form-control" name="categoria" id="inputCategoria" placeholder="Ej: 'Obra de Teatro' ">
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