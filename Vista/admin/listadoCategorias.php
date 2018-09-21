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
                <li class="breadcrumb-item active">Listado</li>
            </ol>
            <?php if(isset($param['mensaje'])) {
                echo $param['mensaje'];
            } ?>
            <?php if(isset($param['categorias'])) { ?>
            <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Data Table Example</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Descripcion</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Descripcion</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                        <tbody>
                                <?php foreach ($param['categorias'] as $categoria){ ?>
                                    <tr>
                                        <td> <?= $categoria->getId() ?></td>
                                        <td> <?= $categoria->getDescripcion() ?></td>
                                        <td style="width:30px;"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></td>
                                        <td style="width:30px;">
                                            <a href="/categoria/eliminar/<?= $categoria->getId() ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
                <?php } ?>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
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