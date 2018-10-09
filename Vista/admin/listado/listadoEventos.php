<?php include $ruta . "adminNav.php" ?>
<div id="wrapper">
    <?php include $ruta . 'sidebar.php' ?>
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    Eventos
                </li>
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
                                <th>Sede</th>
                                <th>Fecha Desde</th>
                                <th>Fecha Hasta</th>
                                <th>Categoria</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Imagen</th>
                                <th>Titulo</th>
                                <th>Sede</th>
                                <th>Fecha Desde</th>
                                <th>Fecha Hasta</th>
                                <th>Categoria</th>
                                <th></th>
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
                                    <td><?= $evento->getSede()->getNombre() ?></td>
                                    <td><?= $evento->getFechaDesde() ?></td>
                                    <td><?= $evento->getFechaHasta() ?></td>
                                    <td>
                                        <div class="more">
                                            <?= $evento->getCategoria()->getDescripcion() ?>
                                        </div>
                                    </td>
                                    <td><a href="/evento/calendarios/<?= $evento->getId()?>" class="btn btn-info"><i class="far fa-calendar-alt"></i></a></td>
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
        <form class="modal-content" method="post" action="/evento/update" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="updateTitulo">Titulo</label>
                        <input type="text" name="titulo" class="form-control" id="updateTitulo">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="updateCategoria">Categoria</label>
                        <select required name="selectCategoria" id="updateCategoria" class="form-control">
                            <?php foreach ($param['categorias'] as $categoria){ ?>
                                <option value="<?= $categoria->getId() ?>">
                                    <?= $categoria->getDescripcion() ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="inputImagen">Subir Imagen</label>
                        <input type="file" name="imagen" class="form-control-file" id="inputImagen" aria-describedby="fileHelp">
                        <small id="fileHelp" class="form-text text-muted">Suba una imagen del evento.</small>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="updateFechaDesde">Fecha Desde</label>
                        <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                            <input  required type="text" id="updateFechaDesde" class="form-control datetimepicker-input"
                                    data-target="#datetimepicker1" name="fecha_desde"/>
                            <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="updateFechaHasta">Fecha Hasta</label>
                        <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                            <input required type="text" id="updateFechaHasta" class="form-control datetimepicker-input"
                                   data-target="#datetimepicker2" name="fecha_hasta"/>
                            <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="updateDescripcion">Descripcion</label>
                            <textarea class="form-control" maxlength="200" rows="2" name="descripcion" id="updateDescripcion"></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="updateIdImagen">Id Evento</label>
                            <input readonly type="number" name="id" class="form-control" id="updateId">
                        </div>
                        <input readonly type="hidden" name="id_imagen" class="form-control" id="updateIdImagen">
                    </div>
            </div>
            <div class="modal-footer text-white">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="btnActualizar" type="submit" class="btn btn-success">Actualizar</button>
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
        $('#updateTitulo').val(evento['titulo']);
        //console.log(evento);
        let id_categoria = evento['categoria']['id_categoria'];
        $('#updateCategoria option[value='+id_categoria+']').prop('selected',true);
        $('#updateFechaDesde').val(evento['fecha_desde']);
        $('#updateFechaHasta').val(evento['fecha_hasta']);
        $('#updateId').val(evento['id_evento']);
        $('#updateIdImagen').val(evento['evento_imagen']['id_imagen']);
        $('#updateDescripcion').val(evento['descripcion']);
        $('#updateModal').modal('toggle');
    }

</script>
