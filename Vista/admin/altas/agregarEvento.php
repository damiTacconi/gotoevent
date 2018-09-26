<div class="card border-dark mb-3">
    <div class="card-header">Crear Evento</div>
    <div class="card-body text-dark">
        <form action="/evento/save" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputTitulo">Titulo</label>
                    <input required type="text" name="titulo" class="form-control" id="inputTitulo" placeholder="Ej:'Festival Show 2018'">
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
                <div class="form-group col-md-4">
                    <label for="inputImagen">Subir Imagen</label>
                    <input type="file" name="imagen" class="form-control-file" id="inputImagen" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Suba una imagen del evento.</small>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputFechaHasta">Fecha Desde</label>
                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                        <input  required type="text" id="inputFechaHasta" class="form-control datetimepicker-input"
                                data-target="#datetimepicker1" name="fecha_desde"/>
                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputFechaHasta">Fecha Hasta</label>
                    <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                        <input required type="text" id="inputFechaHasta" class="form-control datetimepicker-input"
                               data-target="#datetimepicker2" name="fecha_hasta"/>
                        <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
</div>