<?php include $ruta . "adminNav.php" ?>
<div id="wrapper">
    <?php include $ruta . 'sidebar.php' ?>
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <?php if(isset($param['evento'])) { ?>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/evento/listado">Eventos</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/evento/calendarios/<?= $param['evento']->getId() ?>">
                            <?= $param['evento']->getTitulo() ?>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Shows
                    </li>
                </ol>
            <?php }else{ ?>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/evento/listado">Volver a Eventos</a>
                    </li>
                </ol>
            <?php } ?>
            <?php if(isset($param['mensaje'])) {
                echo $param['mensaje'];
            }
            ?>

            <?php if(isset($param['shows'])) { ?>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Tabla de Shows de <?= $param['evento']->getTitulo() ?></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Calendario</th>
                                <th>Artista</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Calendario</th>
                                <th>Artista</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($param['shows'] as $show){
                                $calendario = $show->getCalendario();
                                $evento = $calendario->getEvento();
                                $artista = $show->getArtista();
                                $array_show = $show->jsonSerialize();
                                ?>
                                <tr>
                                    <td> <?= $show->getId() ?></td>
                                    <td> <?= $calendario->getFecha() ?></td>
                                    <td> <?= $artista->getNombre() ?></td>
                                    <td style="width:30px;">
                                        <button onclick='actualizar(<?= json_encode($array_show) ?>)' class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td style="width:30px;">
                                        <a data-toggle="modal" onclick="eliminar(<?= $show->getId() ?>,'<?= $calendario->getFecha() ?>')"
                                           class="btn btn-danger"><i class="fas fa-trash-alt wsmoke"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php }else {
                    $mensaje = new Modelo\Mensaje('No Hay Shows cargados' , 'warning');
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
        <form class="modal-content" method="post" action="/show/update" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="updateCalendario">Calendarios</label>
                        <select required name="selectCalendario" id="updateCalendario" class="form-control">
                            <?php foreach ($param['calendarios'] as $calendario){ ?>
                                <option value="<?= $calendario->getId() ?>">
                                    <?= $calendario->getFecha() ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="updateArtista">Artistas</label>
                        <select required name="selectArtistas" id="updateArtista" class="form-control">
                            <?php foreach ($param['artistas'] as $artista){ ?>
                                <option value="<?= $artista->getId() ?>">
                                    <?= $artista->getNombre() ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Id Show</label>
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
<!-- DELETE Modal-->
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
        $("#btnEliminar").attr("href", "/show/delete/"+id);
    }

    function actualizar(show){
        //console.log(evento);
        let id_calendario = show['calendario']['id_calendario'];
        let id_artista = show['artista']['id_artista'];
        $('#updateCalendario option[value='+id_calendario+']').prop('selected',true);
        $('#updateArtista option[value='+id_artista+']').prop('selected',true);
        $('#updateId').val(show['id_show']);
        $('#updateModal').modal('toggle');
    }
</script>