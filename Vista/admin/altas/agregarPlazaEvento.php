<div class="card border-dark mb-3">
    <div class="card-header">Agregar plaza a un evento</div>
    <div class="card-body text-dark">
        <form action="/evento/savePlazaEvento" method="post">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputSede">Evento</label>
                    <select onchange="actualizarCalendario();" id="selectEvento"
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
                    <select onchange="actualizarSede();" name="calendarioSelect" id="selectCalendario" class="form-control" required>
                        <option value="" selected disabled>Elegir calendario...</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Sede</label>
                    <input disabled id="inputSede" class="form-control" type="text">
                </div>
                <div class="form-group col-md-3">
                    <label>Plaza</label>
                    <select name="plazaSelect" id="selectPlaza" class="form-control" required>
                        <option value="" selected disabled>Elegir plaza...</option>
                        <?php if(!empty($param['plazas'])) { ?>
                            <?php foreach ($param['plazas'] as $plaza) { ?>
                                <option value='<?= $plaza->getId() ?>'><?= $plaza->getDescripcion() ?> </option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputSede">Capacidad</label>
                    <input required name="capacidad" class="form-control" min="1" type="number" placeholder="capacidad...">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputSede">Precio</label>
                    <input required name="precio" class="form-control" min="1" type="number" placeholder="capacidad...">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
</div>

<script type="text/javascript">

    function clearAll(){
        $('#selectCalendario').val([]);
        $('#inputSede').val('');
        $('#selectPlaza').find('option').remove()
            .end()
            .append('<option value="" disabled>Elegir Plaza</option>')
            .val('Elegir Plaza');
    }
    function actualizarCalendario(){
        let id = $('#selectEvento option:selected').val();
        clearAll();
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
                actualizarSede();
            }
        }, 'POST' , obj);
    }

    function actualizarSede(){
        let id = $('#selectCalendario option:selected').val();
        let obj = {id: id};
        $('#selectPlaza').val([]);

        ajaxURL('/sede/getSedeIdCalendarioAjax/', data => {
            let result = JSON.parse(data);
            let $sede = $('#inputSede');
            $sede.val(result['sede']['nombre']);
            actualizarPlazas(result['sede']['id_sede']);
        }, 'POST' , obj);
    }
    function actualizarPlazas(id_sede){
        let obj = { id: id_sede};
        ajaxURL('/sede/getPlazasAjax/', data => {
            let result = JSON.parse(data);
            console.log(result);
            let $selectPlaza = $('#selectPlaza');
            $selectPlaza.find('option').not(':first').remove();
            if(result != Array) {
                if (result.length >= 1) {
                    let plazas = result;
                    let option = '';
                    for (let i = 0; i < plazas.length; i++) {
                        option += '<option value="' + result[i].id_tipo_plaza + '">' + result[i].descripcion + '</option>';
                    }
                    $selectPlaza.append(option);
                }
            }
        }, 'POST' , obj);

    }
</script>