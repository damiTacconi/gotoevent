<?php include $ruta . 'adminNav.php' ?>
<div id="wrapper">
    <?php include $ruta . 'sidebar.php' ?>
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Evento</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="/evento/listado">Listado</a>
                </li>
                <li class="breadcrumb-item active"><?= $param['evento']->getTitulo() ?></li>
            </ol>
            <?php if(isset($param['mensaje'])) {
                echo $param['mensaje'];
            } ?>
            <div id="mensajeAjax"></div>

            <?php if(isset($param['calendarios'])) { ?>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Tabla de Calendarios de <?= $param['evento']->getTitulo() ?></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Fecha</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($param['calendarios'] as $calendario){ ?>
                                <tr id="<?= $calendario->getId() ?>">
                                    <td> <?= $calendario->getId() ?></td>
                                    <td> <?= $calendario->getFecha() ?></td>
                                    <td style="width:30px;"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></td>
                                    <td style="width:30px;">
                                        <a data-toggle="modal" onclick="modal(<?= $calendario->getId() ?>,'<?= $calendario->getFecha() ?>')"
                                           class="btn btn-danger"><i class="fas fa-trash-alt wsmoke"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php }else {
                    $mensaje = new Modelo\Mensaje('No Hay calendarios cargados' , 'warning');
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
                        <th>Nombre</th>
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
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a id="btnEliminar" onclick="eliminar()" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function modal(id, desc){
        $('#deleteModal').modal('toggle');
        $('#deleteModal #descripcion').html(desc);
        $('#deleteModal #id').html(id);
    }

    function eliminar(){
        let id = $('#deleteModal #id').text();
        ajaxURL('/calendario/eliminarAjax', data => {
            let result = JSON.parse(data);
            $('#deleteModal').modal('toggle');
            let id = $('#deleteModal #id').text();
            $('#'+id).remove();
            $('#mensajeAjax').html(result['mensaje']);
        }, "POST" , {id:id})
    }
</script>
