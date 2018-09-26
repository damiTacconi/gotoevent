<div class="card border-dark mb-3">
    <div class="card-header">Crear Show</div>
    <div class="card-body text-dark">
        <form action="/show/save" method="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputSede">Evento</label>
                    <select onchange="actualizarFechas()" name="eventoSelect" id="selectEvento" class="form-control" required>
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
                    <select name="artistaSelect" id="selectEvento" class="form-control" required>
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
</div>
<script type="text/javascript">
    function actualizarFechas(){
        let id= $('#selectEvento option:selected').val();
        let obj= {id: id};
        ajaxURL('/evento/getFechasAjax/', data => {
            let result = JSON.parse(data);
            $('#fecha_desde').val(result['fecha_desde']);
            $('#fecha_hasta').val(result['fecha_hasta']);
        } , "POST", obj);
    }
</script>