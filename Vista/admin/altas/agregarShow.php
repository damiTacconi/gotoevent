<div class="card border-dark mb-3">
    <div class="card-header">Crear Show</div>
    <div class="card-body text-dark">
        <form action="/show/save" method="post">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Evento</label>
                    <select onchange="actualizarCalendario()" id="selectEventoCalendario"
                            class="form-control" required>
                        <option value="" selected disabled>Elegir evento...</option>
                        <?php if(!empty($param['eventos'])) { ?>
                            <?php foreach ($param['eventos'] as $evento) { ?>
                                <option value='<?= $evento->getId() ?>'><?= $evento->getTitulo() ?> </option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Calendarios</label>
                    <select name="calendarioSelect" id="selectCalendario" class="form-control" required>
                        <option value="" selected disabled>Elegir calendario...</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Artista</label>
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
    function actualizarCalendario(){
        let id = $('#selectEventoCalendario option:selected').val();
        let obj = { id: id};
        ajaxURL('/evento/getCalendariosAjax/', data => {
            let result = JSON.parse(data);
            let $selectCalendario = $('#selectCalendario');
            $selectCalendario.find('option').not(':first').remove();
            if(result != Array) {
                if (result['evento']['calendarios'].length >= 1) {
                    let calendarios = result['evento']['calendarios'];
                    let option = '';
                    for (let i = 0; i < calendarios.length; i++) {
                        option += '<option value="' + calendarios[i].id_calendario + '">' + calendarios[i].fecha + '</option>';
                    }
                    $selectCalendario.append(option);
                }
            }
        }, 'POST' , obj);
    }
</script>