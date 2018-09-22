<?php include "adminNav.php" ?>
<div id="wrapper">
    <?php include 'sidebar.php' ?>
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Evento</a>
                </li>
                <li class="breadcrumb-item active">Crear</li>
            </ol>
            <?php if(isset($param['mensaje'])) {
                echo $param['mensaje'];
            }?>
            <form action="/evento/save" method="post">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputTitulo">Titulo</label>
                        <input required type="text" name="titulo" class="form-control" id="inputTitulo" placeholder="Ej:'Festival Show 2018'">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState">Categoria</label>
                        <select required name="selectCategoria" id="inputState" class="form-control">
                            <option disabled selected>Elige una categoria...</option>
                            <?php foreach ($param['categorias'] as $categoria){ ?>
                                <option value="<?= $categoria->getId() ?>">
                                    <?= $categoria->getDescripcion() ?>
                                </option>
                            <?php } ?>
                        </select>
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
            <hr>
            <form action="/evento/saveShow" method="post">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputSede" >Evento</label>
                        <select onchange="actualizarSelect()" name="eventoSelect" id="selectEvento" class="form-control" required>
                            <option value="" selected disabled>Elegir evento...</option>
                            <?php if(!empty($param['eventos'])) { ?>
                                <?php foreach ($param['eventos'] as $evento) { ?>
                                    <option value='<?= $evento->getId() ?>'><?= $evento->getTitulo() ?> </option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Fecha Desde</label>
                        <div class="input-group date" id="desdepicker" data-target-input="nearest">
                            <input readonly id="fecha_desde" type="text"  class="form-control datetimepicker-input"
                                    data-target="#desdepicker"/>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Fecha Hasta</label>
                        <div class="input-group date" id="hastapicker" data-target-input="nearest">
                            <input readonly id="fecha_hasta" type="text"  class="form-control datetimepicker-input"
                                   data-target="#hastapicker"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputFechaPicker">Fecha</label>
                        <div class="input-group date" id="fechapicker" data-target-input="nearest">
                            <input  required type="text" id="inputFechaPicker" class="form-control datetimepicker-input"
                                    data-target="#fechapicker" name="fecha"/>
                            <div class="input-group-append" data-target="#fechapicker" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                        </div>
                    </div>
                        <div class="form-group col-md-3">
                            <label>Hora Desde</label>
                            <div class="input-group date" id="hora_desde_picker" data-target-input="nearest">
                                <input  required type="text" id="inputHoraDesde" class="form-control datetimepicker-input"
                                        data-target="#hora_desde_picker" name="hora_desde"/>
                                <div class="input-group-append" data-target="#hora_desde_picker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Hora Hasta</label>
                            <div class="input-group date" id="hora_hasta_picker" data-target-input="nearest">
                                <input  required type="text" id="inputHoraHasta" class="form-control datetimepicker-input"
                                        data-target="#hora_hasta_picker" name="hora_hasta"/>
                                <div class="input-group-append" data-target="#hora_hasta_picker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
                    <div class="form-group col-md-3">
                        <label for="inputSede" >Artista</label>
                        <select onchange="actualizarSelect()" name="artistaSelect" id="selectEvento" class="form-control" required>
                            <option value="" selected disabled>Elegir artista...</option>
                            <?php if(!empty($param['artistas'])) { ?>
                                <?php foreach ($param['artistas'] as $artista) { ?>
                                    <option value='<?= $artista->getId() ?>'><?= $artista->getNombre() ?> </option>
                                <?php } ?>
                            <?php } ?>
                        </select>
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

    <script type="text/javascript">

        function actualizarSelect(){

            let id= $('#selectEvento option:selected').val();
            ajaxURL('/evento/getFechasAjax/', data => {
                let result = JSON.parse(data);
                $('#fecha_desde').val(result['fecha_desde']);
                $('#fecha_hasta').val(result['fecha_hasta']);
            } , "POST" , {
               id:id
            });
        }

    </script>

</div>
<!-- /#wrapper -->




