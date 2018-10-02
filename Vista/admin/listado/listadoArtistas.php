<?php include $ruta . "adminNav.php" ?>
<div id="wrapper">
    <?php include $ruta . 'sidebar.php' ?>
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="/">Artistas</a>
                </li>
            </ol>
            <?php if(isset($param['mensaje'])) {
                echo $param['mensaje'];
            } ?>
            <?php if(isset($param['artistas'])) { ?>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Tabla de Artistas</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
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
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($param['artistas'] as $artista){ ?>
                                <tr>
                                    <td> <?= $artista->getId() ?></td>
                                    <td> <?= $artista->getNombre() ?></td>
                                    <td style="width:30px;">
                                      <button class="btn btn-primary" onclick="actualizar(<?= $artista->getId() ?> , '<?= $artista->getNombre() ?>')">
                                        <i class="fas fa-edit"></i>
                                      </button>
                                    </td>
                                    <td style="width:30px;">
                                        <a data-toggle="modal" onclick="eliminar(<?= $artista->getId() ?>,'<?= $artista->getNombre() ?>')"
                                           class="btn btn-danger"><i class="fas fa-trash-alt wsmoke"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php }else {
                    $mensaje = new Modelo\Mensaje('No Hay artistas cargados' , 'warning');
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

<!-- UPDATE MODAL-->
<!-- Large modal -->
<div id="updateModal" class="modal fade bd-example-modal-lg" tabindex="-1"
     role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content" method="post" action="/artista/update" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputNombre">Artistas</label>
                        <input type="text" class="form-control" id="inputNombre" name="nombre" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Id Artista</label>
                        <input readonly type="number" name="id" class="form-control" id="updateId">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-white">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="btnActualizar" type="submit" class="btn btn-success">Actualizar</button>
            </div>
        </form>
    </div>
</div>

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
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
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
        $("#btnEliminar").attr("href", "/artista/eliminar/"+id);
    }

    function actualizar(id, nombre){
      console.log(id);
      console.log(nombre);
      $('#inputNombre').val(nombre);
      $('#updateId').val(id);
      $('#updateModal').modal('toggle');
    }
</script>
