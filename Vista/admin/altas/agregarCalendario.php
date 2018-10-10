<div class="card border-dark mb-3">
    <div class="card-header">Crear Calendario</div>
    <div class="card-body text-dark">
        <form action="/calendario/save" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputSede">Evento </label>
                    <select onchange="actualizarFechas()" name="eventoSelect" id="selectEvento" class="form-control" required>
                        <option value="" selected disabled>Elegir evento...</option>
                        <?php if(!empty($param['eventos'])) {?>
                            <?php foreach ($param['eventos'] as $evento) { ?>
                                <option value='<?= $evento->getId() ?>'><?= $evento->getTitulo() ?> </option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Sede</label>
                    <select name="sedeSelect" id="selectSede" class="form-control" required>
                        <option value="" selected disabled>Elegir sede...</option>
                        <?php if(!empty($param['sedes'])) { ?>
                            <?php foreach ($param['sedes'] as $sede) { ?>
                                <option value='<?= $sede->getId() ?>'><?= $sede->getNombre() ?> </option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="inputFechaPicker">Fecha</label>
                    <div class="input-group date" id="fechapicker" data-target-input="nearest">
                        <input  required type="text" id="inputFechaPicker" class="form-control datetimepicker-input"
                                data-target="#fechapicker" name="fecha"/>
                        <div class="input-group-append" data-target="#fechapicker" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                    </div>
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
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
</div>
