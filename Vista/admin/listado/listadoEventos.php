<?php include $ruta . "adminNav.php" ?>
<div id="wrapper">
    <?php include $ruta . 'sidebar.php' ?>
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Evento</a>
                </li>
                <li class="breadcrumb-item active">Listado</li>
            </ol>
            <?php if(isset($param['mensaje'])) {
                echo $param['mensaje'];
            } ?>
            <?php if(isset($param['eventos'])) { ?>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Tabla de Eventos</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Imagen</th>
                                <th>Titulo</th>
                                <th>Fecha Desde</th>
                                <th>Fecha Hasta</th>
                                <th>Categoria</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Imagen</th>
                                <th>Titulo</th>
                                <th>Fecha Desde</th>
                                <th>Fecha Hasta</th>
                                <th>Categoria</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($param['eventos'] as $evento){
                                $array_evento = $evento->jsonSerialize();
                                ?>
                                <tr>
                                    <td><?= $evento->getId() ?></td>
                                    <td width="30px" class="text-center">
                                        <?php
                                        $imagen = $evento->getEventoImagen()->getImagen();
                                        $url = "data:image;base64,{$imagen}";
                                        ?>
                                        <img src="<?= $url ?>" width="50px" alt="Imagen de Evento">
                                    </td>
                                    <td><?= $evento->getTitulo() ?></td>
                                    <td><?= $evento->getFechaDesde() ?></td>
                                    <td><?= $evento->getFechaHasta() ?></td>
                                    <td><?= $evento->getCategoria()->getDescripcion() ?> </td>
                                    <td style="width:30px;"><button data-toggle="modal"
                                     onclick='actualizar(<?= json_encode($array_evento) ?>)'
                                                      class="btn btn-primary"><i class="fas fa-edit"></i></button></td>
                                    <td style="width:30px;">
                                        <a data-toggle="modal" onclick="eliminar(<?= $evento->getId() ?>,'<?= $evento->getTitulo() ?>')"
                                           class="btn btn-danger"><i class="fas fa-trash-alt wsmoke"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php }else {
                    $mensaje = new Modelo\Mensaje('No Hay categorias cargadas' , 'warning');
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
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group col-md-4">
                    <label for="inputTitulo">Titulo</label>
                    <input type="text" name="titulo" class="form-control" id="inputTitulo">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputCategoria">Categoria</label>
                    <select required name="selectCategoria" id="inputCategoria" class="form-control">
                        <option disabled selected>Elige una categoria...</option>
                        <?php foreach ($param['categorias'] as $categoria){ ?>
                            <option value="<?= $categoria->getId() ?>">
                                <?= $categoria->getDescripcion() ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer text-white">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btnActualizar" class="btn btn-success">Actualizar</a>
            </div>
        </form>
    </div>
</div>
<!-- DELETE MODAL -->
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
        $("#btnEliminar").attr("href", "/evento/eliminar/"+id);
    }
    function actualizar(evento){
        console.log(evento);
        $('#updateModal').modal('toggle');
    }
</script>