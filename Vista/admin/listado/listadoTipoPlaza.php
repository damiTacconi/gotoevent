<?php include $ruta . "adminNav.php" ?>
<div id="wrapper">
    <?php include $ruta . 'sidebar.php' ?>
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Sede</a>
                </li>
                <li class="breadcrumb-item"><a href="/sede/listado">Listado</a></li>
                <li class="breadcrumb-item active"><?= $param['sede']->getNombre() ?></li>
            </ol>
            <?php if(isset($param['mensaje'])) {
                echo $param['mensaje'];
            } ?>
            <?php if(isset($param['tipo_plazas'])) { ?>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Tabla de Plazas de <?= $param['sede']->getNombre() ?></div>
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
                            <?php foreach ($param['tipo_plazas'] as $plaza){ ?>
                                <tr>
                                    <td> <?= $plaza->getId() ?></td>
                                    <td> <?= $plaza->getDescripcion() ?></td>
                                    <td style="width:30px;"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></td>
                                    <td style="width:30px;">
                                        <a data-toggle="modal" onclick="eliminar(<?= $plaza->getId() ?>,'<?= $plaza->getDescripcion() ?>')"
                                           class="btn btn-danger"><i class="fas fa-trash-alt wsmoke"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php }else {
                    $mensaje = new Modelo\Mensaje('No Hay plazas cargadas' , 'warning');
                    echo $mensaje->getAlert();
                } ?>
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

<!-- Logout Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Eliminar?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Descripcion</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td id="id"></td>
                        <td id="descripcion"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer text-white">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btnEliminar" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function eliminar(id, desc){
        $('#deleteModal').modal('toggle');
        $('#deleteModal #descripcion').html(desc);
        $('#deleteModal #id').html(id);
        $("#btnEliminar").attr("href", "/sede/eliminarPlaza/"+id);
    }
</script>